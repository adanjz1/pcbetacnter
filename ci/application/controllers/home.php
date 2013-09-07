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
            $data['pageTitle'] = 'Dell Coupons, HP Coupons, Cheap Laptops, Computer Sales';//Title tag
            $data['page_title'] = 'Best Deals, Dell Coupons, HP Coupons, Cheap Laptops';//H1 tag
            $data['page_desc'] = 'Best Deals & Discount Coupons on technology products every day. We research thousands of cheap laptops deal & discount coupon & codes on Dell, HP, Sony, Lenovo and may more word class brands.';
           
           
            /**
             * Selected Menu deals and lastest deals
             */
            $deals = array();
            $this->load->model('Deal');
            $this->load->model('Category');
            $this->load->model('Source');
            $dealsList = $this->Deal->get_mainMenuDeals(52); //Get the main menu deal list
            $others = 52-count($deals);
            $dealSources = $this->Source->get_stores(99);
            $dealsList2 = array();
            foreach($dealSources as $source){
                $auxDeals = $this->Deal->get_homeDeals(3,$source->deal_source_id); //Get the other deals
                $dealsList2 = array_merge($dealsList2, $auxDeals);
            }
            
            $merge = array_merge($dealsList, $dealsList2);
            foreach($merge as $deal){
                if(empty($deal->display_name)){
                    $deal->display_name = $deal->title;
                }
                if(empty($deal->image_url)){
                    $deal->image = 'media/images/noImage.jpg';
                }else{
                    $deal->image =$deal->image_url;
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
                if(!empty($this->session->all_userdata()[$deal->id])){
                     $deal->thumbsClass = 'thumbActive';
                }else{
                    $deal->thumbsClass = 'thumbs';
                }
                $deal->categoryStr = $this->Category->get_CatName($deal->cat_id);
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
                if(empty($deal->image_url)){
                    $deal->image = 'media/images/noImage.jpg';
                }else{
                    $deal->image =$deal->image_url;
                }
                if(!empty($deal->deal_sources_id)){
                    $deal->provider = $this->Source->get_dealSourceStr($deal->deal_sources_id);
                }
                if($deal->actual_price >0){
                    $savings = ($deal->actual_price - $deal->deal_price);
                    $deal->savingsPercentage  = round(($savings * 100) / $deal->actual_price,2);
                }else{
                    $deal->savingsPercentage  = 0;
                }
                $deal->couponCode = $deal->coupon_code;
                $deal->offerUrl = $this->config->item('base_url').$this->config->item('index_page').'/deals/pop/'.$deal->id;
                $deal->categoryStr = $this->Category->get_CatName($deal->cat_id);
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
              $data['staticPages'] = array();
              /**********************************************/
                $this->load->library('parser');
                $this->parser->parse('widgets/header', $data);
                $this->parser->parse('home', $data);
                $this->parser->parse('widgets/rightBar', $data);
                $this->parser->parse('widgets/footer', $data);
	}
        
}
