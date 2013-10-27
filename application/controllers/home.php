<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    public function __construct()
       {
        parent::__construct();
       }
public function index()
	{
            /**
             * HEADER
             */
            $this->load->helper('metaHelper');
            $this->load->helper(array('form', 'url'));
            $this->load->library('session');
            $data = getConstData($this);
            $this->load->model('pages');
            $seoPg = $this->pages->getSEOPage('home');
            $seoPg = $seoPg[0];
            $data['pageTitle'] = $seoPg->Title;//Title tag
            $data['headerText'] = $seoPg->Header;//H1 tag
            $data['metaTitle'] = $seoPg->Meta_title;
            $data['metaKeywords'] = $seoPg->Meta_keywords;
            $data['metaDescription'] = $seoPg->Meta_Description;
           
           
            /**
             * Selected Menu deals and lastest deals
             */
            $deals = array();
            $this->load->model('Deal');
            $this->load->model('Category');
            $this->load->model('Source');
            $dealsList = $this->Deal->get_mainMenuDeals(24); //Get the main menu deal list
            $others = 24-count($deals);
            
//            $dealSources = $this->Source->get_stores(99);
            $dealsList2 = $this->Deal->get_lastDeals($others); //Get the other deals
//            foreach($dealSources as $source){
//                $auxDeals = $this->Deal->get_homeDeals(3,$source->deal_source_id); //Get the other deals
//                $dealsList2 = array_merge($dealsList2, $auxDeals);
//            }
            
            $merge = array_merge($dealsList, $dealsList2);
            foreach($merge as $deal){
                if($deal->actual_price > 0){
                    $deal->showActualPrice = '<span class="actualPriceList">
                                $'.$deal->actual_price.'
                            </span> ';
                }else{
                    $deal->showActualPrice = '';
                }
                if(empty($deal->display_name)){
                    $deal->display_name = $deal->title;
                }
                if(empty($deal->image_url)){
                    $deal->image = 'media/images/noImage.jpg';
                }else{
                    $deal->image = str_replace("https://pccounter.s3.amazonaws.com/","http://dr30wky7ya0nu.cloudfront.net/",$deal->image_url);
                }
                if(Imageexists($deal->image)){
                    $deal->image = $this->Source->get_dealSourceImg($deal->deal_sources_id);
                }
                if(!empty($deal->deal_sources_id)){
                    $deal->provider = $this->Source->get_dealSourceStr($deal->deal_sources_id);
                }
                if($deal->hot){
                    $deal->hot = '<div class="hot_deal"></div>';
                }else{
                    $deal->hot = '';
                }
                $deal->offerUrl = $this->config->item('base_url').$this->config->item('index_page').'/deals/review/'.$deal->id;
                $sess = $this->session->all_userdata();
                if(!empty($sess[$deal->id])){
                     $deal->thumbsClass = 'thumbActive';
                }else{
                    $deal->thumbsClass = 'thumbs';
                }
                $deal->categoryStr = $this->Category->get_CatName($deal->cat_id);
                $deal->catUrl = $this->Category->get_CatUrl($deal->cat_id);
                $deal->categoryCount = $this->Category->get_catCant($deal->cat_id);
                
            }
            $data['deals'] = $merge;
            /********************************************/
            
            /**
             * NewestCoupons last 9 deals with coupon code
             */
            
             $coupons= $this->Deal->get_dealsWithCode(9);
             foreach($coupons as $deal){
                if(empty($deal->display_name)){
                    $deal->display_name = $deal->title;
                }
                $source = $this->Source->get_source($deal->deal_sources_id);
                if(empty($deal->image_url)){
                    if(strpos($source->deal_source_logo_url,"ttp://") || strpos($source->deal_source_logo_url,'ttps://')){
                        $deal->image = $source->deal_source_logo_url;
                    }else{
                        $deal->image = 'http://pccounter.net/media/images/'.$source->deal_source_logo_url;
                    }
                }else{
                    $deal->image =$deal->image_url;
                }
                if(!empty($deal->deal_sources_id)){
                    $deal->provider = $source->deal_source_name;
                }
                if($deal->actual_price >0){
                    $savings = ($deal->actual_price - $deal->deal_price);
                    $deal->savingsPercentage  = round(($savings * 100) / $deal->actual_price,2);
                }else{
                    $deal->savingsPercentage  = 0;
                }
                $deal->couponCode = $deal->coupon_code;
                $deal->offerUrl = $this->config->item('base_url').$this->config->item('index_page').'/deals/review/'.$deal->id;
                $deal->categoryStr = $this->Category->get_CatName($deal->cat_id);
                $deal->catUrl = $this->Category->get_CatUrl($deal->cat_id);
            }
            $data['newestCoupons'] = $coupons;
            /********************************************************/
            
              $data['noDeals'] =  ((count($data['deals'])==0)?'<div class="pro_box">
                                                        <span style="color:#FF0000;">NO DEALS ARE THERE.</span>
                                                 </div>':'');
              $data['noNewestCoupons'] = ((count($data['newestCoupons'])==0)?'<div class="pro_box">
                                                        <span style="color:#FF0000;">NO DEALS ARE THERE.</span>
                                                 </div>':'');
              $data['topStores'] = array();
              /**
               * Footer
               */
              
              /**********************************************/
                $this->load->library('parser');
                $this->parser->parse('widgets/header', $data);
                $this->parser->parse('home', $data);
                $this->parser->parse('widgets/rightBar', $data);
                $this->parser->parse('widgets/footer', $data);
	}
        
}
