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
            $bannerDeals = $this->Deal->get_mainMenuDeals(5); //Get the main menu deal list
            $arrExclude=array();
            foreach($bannerDeals as $deal){
                $arrExclude[] = $deal->id;
            }
            $lastestDeals = $this->Deal->get_lastDeals(8,$arrExclude); //Get the other deals
            foreach($lastestDeals as $deal){
                $arrExclude[] = $deal->id;
            }
            $topDeals = $this->Deal->get_topDeals(8,$arrExclude); //Get the other deals
            $this->load->model('Review');
            $data['bannerDealsIndicator'] = encapsuleDeals($bannerDeals,$this);
            $data['bannerDeals'] = encapsuleDeals($bannerDeals,$this);
            $data['lastestDeals'] = encapsuleDeals($lastestDeals,$this);
            $data['topDeals'] = encapsuleDeals($topDeals,$this);
            /********************************************/
            //COUPONS
                $lastestCoupons = $this->Deal->get_lastCouponsHome(8); //Get the other deals
                foreach($lastestCoupons as $deal){
                    $arrExclude[] = $deal->id;
                }
                $topCoupons = $this->Deal->get_topCoupons(8,$arrExclude); //Get the other deals
                $data['lastestCoupons'] = encapsuleDeals($lastestCoupons,$this);
                $data['topCoupons'] = encapsuleDeals($topCoupons,$this);

            
            /********************************************************/
            
              /**
               * Footer
               */
              
              $this->load->model('Category');
                $categ_list = $this->Category->get_categories(90);
                foreach ($categ_list as $categ){
                    if(empty($categ->url)){
                        $categ->subCategoryUrl = $this->config->item('base_url').$this->config->item('index_page').'/categories/subcategories/0/'.$categ->id;
                        $categ->dealCategoryUrl = $this->config->item('base_url').$this->config->item('index_page').'/categories/subcategories/0/'.$categ->id;
                    }else{
                        $categ->subCategoryUrl = $this->config->item('base_url').$this->config->item('index_page').$categ->url;
                        $categ->dealCategoryUrl = $this->config->item('base_url').$this->config->item('index_page').$categ->url;
                    }
                    if(empty($categ->image)){
                        $categ->image = 'http://pccounter.net/media/images/noImage.jpg';
                    }
                    if($categ->id > 6){
                        $categ->extraClass = 'hiddenCat';
                    }elsE{
                        $categ->extraClass = '';
                    }
                }
                $data['categories'] = $categ_list;

            $this->load->model('Source');
            $stor = $this->Source->get_stores(64);
            $storcount =1;
            foreach($stor as $st){
                if(strpos($st->deal_source_logo_url,'ttp://') || strpos($st->deal_source_logo_url,'ttps://')){
                    $st->image = $st->deal_source_logo_url;
                }else{
                    $st->image = $data['siteUrlMedia'].'/media/images/'.$st->deal_source_logo_url;
                }
                if(empty($st->url)){
                    $st->dealsStore = $this->config->item('base_url').$this->config->item('index_page').'deals/index/0/_/null/null/'.$st->deal_source_id;
                }else{
                    $st->dealsStore = $this->config->item('base_url').$this->config->item('index_page').$st->url;
                }
                if($storcount > 8){
                    $st->extraClass = 'hiddenCat';
                }else{
                    $st->extraClass = '';
                }
                $storcount++;
            }
            $data['stores'] = $stor;
              $data['activeHome'] = 'active';
              /**********************************************/
                $this->load->library('parser');
                $this->parser->parse('widgets/header_new', $data);
                $this->parser->parse('home_new', $data);
                //$this->parser->parse('widgets/rightBar', $data);
                $this->parser->parse('widgets/footer_new', $data);
	}
        
}
