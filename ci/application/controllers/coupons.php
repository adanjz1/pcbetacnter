<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coupons extends CI_Controller {

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
	
        public function index( $limit='', $category='___0'){
            $cat = $category;
            if($cat != ''){
                $cat = substr($category, 3);
            }
            /**
             * Common
             */
            $this->load->helper('metaHelper');
            $this->load->helper(array('form', 'url'));
            $data = getConstData($this);
            /**
             * HEADER
             */
            $data['couponsPaginatorUrl'] = $this->config->item('base_url').$this->config->item('index_page').'/coupons/paginator';
            $this->load->model('pages');
            $seoPg = $this->pages->getSEOPage('coupons');
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
            $this->load->model('Source');
            
            if($limit == ''){
                $limit = 0;
            }
            $merge = $this->Deal->get_lastCoupons(30,$limit,$cat); //Get the other deals
            
            foreach($merge as $deal){
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
                if($deal->hot){
                    $deal->hot = '<div class="hot_deal"></div>';
                }else{
                    $deal->hot = '';
                }
                if($deal->actual_price >0){
                    $savings = ($deal->actual_price - $deal->deal_price);
                    $deal->savingsPercentage  = round(($savings * 100) / $deal->actual_price,2);
                }else{
                    $deal->savingsPercentage  = 0;
                }
                $deal->offerUrl = $this->config->item('base_url').$this->config->item('index_page').'/deals/review/'.$deal->id;
                $deal->couponCode = $deal->coupon_code;
                
            }
            $data['deals'] = $merge;
            $data['totalDeals'] = $this->Deal->get_totalCoupons($cat);
            $this->load->library('pagination');
            $config['base_url'] = $this->config->item('base_url').$this->config->item('index_page').'/coupons/paginator/'.$category;
            $config['total_rows'] = $data['totalDeals'];
            $config['per_page'] = 30; 
            $this->pagination->initialize($config); 
            $data['paginator'] = $this->pagination->create_links();
            
            
            /********************************************************/
            
              $data['noCoupons'] =  ((count($data['deals'])==0)?'<div class="pro_box">
                                                        <span style="color:#FF0000;">NO COUPONS ARE THERE.</span>
                                                 </div>':'');
                $data['topStores'] = array();
                
            /**
             * Categories
             */
                $this->load->model('Category');
                $categ_list = $this->Category->get_categories();
                foreach ($categ_list as $categ){
                    if($cat == $categ->id){
                        $categ->selected = 'selected="selected"';
                    }
                }
                $data['categories'] = $categ_list;
            /*****************/
                
              /**
               * Footer
               */
              /**********************************************/
                $this->load->library('parser');
                $this->parser->parse('widgets/header', $data);
                $this->parser->parse('coupons', $data);
                
                $this->parser->parse('widgets/rightBar', $data);
                $this->parser->parse('widgets/footer', $data);
        }
        /* HACKS TO CENTRALIZE SEARCH AND PAGINATOR*/
        
        public function paginator($limit='',$category=''){
            $this->load->helper('url');
            if(substr($limit, 0,3) == '___' && $category ==''){
                redirect('/coupons/index/0/'.$limit);
                die();
                
            }
            
            if($limit==''){
                $limit = 0;
            }
            
            redirect('/coupons/index/'.$category.'/'.$limit);
        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */