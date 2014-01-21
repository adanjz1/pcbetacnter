<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();
    }

    public function index($timeZone = "") {
        /**
         * HEADER
         */
        if (/*$this->agent->is_mobile() ||*/ !empty($_GET['m']) && $_GET['m']  == 'debug') {
            $this->load->model('Source');
            $this->load->helper('metaHelper');
            $this->load->model('pages');
            $seoPg = $this->pages->getSEOPage('home');
            $seoPg = $seoPg[0];
            $data['siteUrlMedia']  = $this->config->item('base_url');
            $data['pageTitle'] = $seoPg->Title; //Title tag
            $data['headerText'] = $seoPg->Header; //H1 tag
            $data['metaTitle'] = $seoPg->Meta_title;
            $data['metaKeywords'] = $seoPg->Meta_keywords;
            $data['metaDescription'] = $seoPg->Meta_Description;
            $this->load->model('Deal');
            $this->load->model('Category');
            
            $topDeals = $this->Deal->get_topDeals(8, array()); //Get the other deals
            $data['topDeals'] = encapsuleDeals($topDeals, $this);
            
            $topCoupons = $this->Deal->get_topCoupons(8, array()); //Get the other deals
            $data['topCoupons'] = encapsuleDeals($topCoupons, $this);

            $this->load->model('Category');
            $categ_list = $this->Category->get_categories(30);
            $data['categArray'] = array();
            
            foreach ($categ_list as $categ) {
                if (empty($categ->url)) {
                    $categ->subCategoryUrl = $this->config->item('base_url') . $this->config->item('index_page') . '/categories/subcategories/0/' . $categ->id;
                    $categ->dealCategoryUrl = $this->config->item('base_url') . $this->config->item('index_page') . '/categories/subcategories/0/' . $categ->id;
                } else {
                    $categ->subCategoryUrl = $this->config->item('base_url') . $this->config->item('index_page') . $categ->url;
                    $categ->dealCategoryUrl = $this->config->item('base_url') . $this->config->item('index_page') . $categ->url;
                }
                
                
            }
            if(empty($timeZone)){
                $cat= 1;
            }else{
                $cat = $timeZone;
            }
            $data['categories'] = $categ_list;
            $categ_list = $this->Category->get_Subcategories(null, null, $cat);
                foreach ($categ_list as $cat) {
                    if (empty($cat->url)) {
                        $cat->subCategoryUrl = $this->config->item('base_url') . $this->config->item('index_page') . 'deals/index/0/category/' . $_SESSION['categories'][0] . '/' . $categ->id;
                    } else {
                        $cat->subCategoryUrl = $this->config->item('base_url') . $this->config->item('index_page') . $cat->url;
                    }
                }
            $data['subcategories'] = $categ_list;
            $data['selCat']=1;
            $data['selSubCat']=22;



            $this->load->library('parser');
            $this->parser->parse('widgets/m_header_new', $data);
            $this->parser->parse('m_home_new', $data);
            $this->parser->parse('widgets/m_footer_new', $data);
        } else {
            $this->load->helper('metaHelper');
            if (!empty($timeZone)) {
                echo'<pre style="text-align:center;font-size:20px;">UTC: ' . date('Y-m-d H:i:s') . '</pre>';
                $timeZone = str_replace('GMT', 'Etc/GMT', $timeZone);
                date_default_timezone_set($timeZone);
                echo'<pre style="text-align:center;font-size:20px;">' . $timeZone . ': ' . date('Y-m-d H:i:s') . '</pre>';
            }

            $this->load->helper(array('form', 'url'));

            $data = getConstData($this);
            $this->load->model('pages');
            $seoPg = $this->pages->getSEOPage('home');
            $seoPg = $seoPg[0];
            $data['pageTitle'] = $seoPg->Title; //Title tag
            $data['headerText'] = $seoPg->Header; //H1 tag
            $data['metaTitle'] = $seoPg->Meta_title;
            $data['metaKeywords'] = $seoPg->Meta_keywords;
            $data['metaDescription'] = $seoPg->Meta_Description;


            $data['pathLocation'] = '';

            /**
             * Selected Menu deals and lastest deals
             */
            $deals = array();
            $this->load->model('Deal');
            $this->load->model('Category');
            $this->load->model('Source');
            $bannerDeals = $this->Deal->get_mainMenuDeals(5); //Get the main menu deal list
            if (empty($bannerDeals)) {
                $bannerDeals = $this->Deal->get_lastDealsHome(5, array()); //Get the other deals    
            }
            $arrExclude = array();
            foreach ($bannerDeals as $deal) {
                $arrExclude[] = $deal->id;
            }

            $lastestDeals = $this->Deal->get_lastDealsHome(8, $arrExclude); //Get the other deals

            foreach ($lastestDeals as $deal) {
                $arrExclude[] = $deal->id;
            }
            $topDeals = $this->Deal->get_topDeals(8, $arrExclude); //Get the other deals

            $data['bannerDealsIndicator'] = encapsuleDeals($bannerDeals, $this);
            $data['bannerDeals'] = encapsuleDeals($bannerDeals, $this);
            $data['lastestDeals'] = encapsuleDeals($lastestDeals, $this);
            $data['topDeals'] = encapsuleDeals($topDeals, $this);

            /*             * ***************************************** */
            //COUPONS
            $lastestCoupons = $this->Deal->get_lastCouponsHome(8); //Get the other deals
            foreach ($lastestCoupons as $deal) {
                $arrExclude[] = $deal->id;
            }
            $topCoupons = $this->Deal->get_topCoupons(8, $arrExclude); //Get the other deals
            $data['lastestCoupons'] = encapsuleDeals($lastestCoupons, $this);
            $data['topCoupons'] = encapsuleDeals($topCoupons, $this);


            /*             * ***************************************************** */

            /**
             * Footer
             */
            $data['activeHome'] = 'active';
            /*             * ******************************************* */
            $this->load->library('parser');
            $this->parser->parse('widgets/header_new', $data);
            $this->parser->parse('home_new', $data);
            //$this->parser->parse('widgets/rightBar', $data);
            $this->parser->parse('widgets/footer_new', $data);
        }
    }

}
