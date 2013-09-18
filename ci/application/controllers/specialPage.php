<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SpecialPage extends CI_Controller {

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
	
        public function index($limit,$idPage){
           
            $this->load->helper('metaHelper');
            $this->load->helper(array('form', 'url')); 
            $data = getConstData($this);
           
            $this->load->model('Pages');
            $page = $this->Pages->getSpecialPage($idPage);
            $page = $page[0];
           
            $data['pageTitle'] = $page->title_tag;//Title tag
            $data['metaTitle'] = $page->meta_title;
            $data['metaKeywords'] = $page->meta_keywords;
            $data['metaDescription'] = $page->meta_desc;
            /**
             * Selected Menu deals and lastest deals
             */
            $data['pageName'] = $page->title;
            $data['headerText'] = $page->heading;
            
             $deals = array();
            $this->load->model('Deal');
            $this->load->model('Source');
            $this->load->model('Category');
            if($limit == ''){
                $limit = 0;
            }
            $merge = $this->Deal->get_pageDeals(52,$limit,$idPage); //Get the other deals
            $this->load->library('session');
            foreach($merge as $deal){
                if(empty($deal->display_name)){
                    $deal->display_name = $deal->title;
                }
                if(empty($deal->image_url)){
                    $deal->image = 'http://pccounter.net/media/images/noImage.jpg';
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
            $data['totalDeals'] = $this->Deal->get_totalDeals_page($idPage);
            $this->load->library('pagination');
            
            $config['base_url'] = $this->config->item('base_url').$this->config->item('index_page').'/specialPage/paginator/'.$idPage;
            $config['total_rows'] = $data['totalDeals'];
            $config['per_page'] = 52; 
            $this->pagination->initialize($config); 
            $data['paginator'] = $this->pagination->create_links();
            
            /********************************************************/
            
              $data['noDeals'] =  ((count($data['deals'])==0)?'<div class="pro_box">
                                                        <span style="color:#FF0000;">NO DEALS ARE THERE.</span>
                                                 </div>':'');
            
              /**
               * Footer
               */
              /**********************************************/
                $this->load->library('parser');
                $this->parser->parse('widgets/header', $data);
                $this->parser->parse('special', $data);
                
                $this->parser->parse('widgets/rightBar', $data);
                $this->parser->parse('widgets/footer', $data);
        }
          public function paginator($var1='',$var2=''){
            $this->load->helper('url');
           
            redirect('/specialPage/index/'.$var2.'/'.$var1);
            
        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
