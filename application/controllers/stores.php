<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stores extends CI_Controller {

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
	public function index($limit = '', $initial=''){
             /**
             * Common
             */
            $this->load->helper('metaHelper');
            $this->load->helper(array('form', 'url'));
            $data = getConstData($this);
            /**
             * HEADER
             */
            $data['storesPaginatorUrl'] = $this->config->item('base_url').$this->config->item('index_page').'stores/paginator';
            $this->load->model('pages');
            $seoPg = $this->pages->getSEOPage('stores');
            $seoPg = $seoPg[0];
            $data['pageTitle'] = $seoPg->Title;//Title tag
            $data['headerText'] = $seoPg->Header;//H1 tag
            $data['metaTitle'] = $seoPg->Meta_title;
            $data['metaKeywords'] = $seoPg->Meta_keywords;
            $data['metaDescription'] = $seoPg->Meta_Description;
           
            $data['pathLocation']='<a class="prevPath" href="/">HOME</a> > <a href="/all-stores" class="activePath">STORES</a> ';
            $this->load->model('Source');
            $stor = $this->Source->get_stores(24,$limit,$initial);
            $lastInRow = 1;
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
                if($lastInRow ==4){
                    $lastInRow=0;
                    $st->lastInRow = 'lastInRow';
                }
                $lastInRow++;
            }
            $data['stores'] = $stor;
            $data['storesUrlBrandSearch'] = $this->config->item('base_url').$this->config->item('index_page').'stores/index/0/';
            $data['initials'] = array(
                                        array(
                                            'id'=>'0-9'
                                        ),
                                        array(
                                           'id'=>'A'
                                        ),
                                        array(
                                           'id'=>'B'
                                        ),
                                        array(
                                           'id'=>'C'
                                        ),
                                        array(
                                           'id'=>'D'
                                        ),
                                        array(
                                           'id'=>'E'
                                        ),
                                        array(
                                           'id'=>'F'
                                        ),
                                        array(
                                           'id'=>'G'
                                        ),
                                        array(
                                           'id'=>'H'
                                        ),
                                        array(
                                           'id'=>'I'
                                        ),
                                        array(
                                           'id'=>'J'
                                        ),
                                        array(
                                           'id'=>'K'
                                        ),
                                        array(
                                           'id'=>'L'
                                        ),
                                        array(
                                           'id'=>'M'
                                        ),
                                        array(
                                           'id'=>'N'
                                        ),
                                        array(
                                           'id'=>'O'
                                        ),
                                        array(
                                           'id'=>'P'
                                        ),
                                        array(
                                           'id'=>'Q'
                                        ),
                                        array(
                                           'id'=>'R'
                                        ),
                                        array(
                                           'id'=>'S'
                                        ),
                                        array(
                                           'id'=>'T'
                                        ),
                                        array(
                                           'id'=>'U'
                                        ),
                                        array(
                                           'id'=>'V'
                                        ),
                                        array(
                                           'id'=>'W'
                                        ),
                                        array(
                                           'id'=>'X'
                                        ),
                                        array(
                                           'id'=>'Y'
                                        ),
                                        array(
                                           'id'=>'Z'
                                        ),
                                    );
                $this->load->library('pagination');
                $config['base_url'] = $this->config->item('base_url').$this->config->item('index_page').'all-stores';
                $config['total_rows'] = $this->Source->get_totalStores($initial);
                $config['per_page'] = 24; 
                $config['uri_segment'] = 2;
                $this->pagination->initialize($config); 
                $data['paginator'] = $this->pagination->create_links();
                $data['dealsStore'] = $this->config->item('base_url').$this->config->item('index_page').'all-stores';
            /**
            * Footer
            */
           
           /**********************************************/
             $this->load->library('parser');
             $this->parser->parse('widgets/header_new', $data);
             $this->parser->parse('stores_new', $data);
             $this->parser->parse('widgets/footer_new', $data);
        }
}
