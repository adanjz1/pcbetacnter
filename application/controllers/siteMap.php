<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sitemap extends CI_Controller {

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
	
        public function index(){
           
            $this->load->helper('metaHelper');
            $this->load->helper(array('form', 'url')); 
            $data = getConstData($this);
            $this->load->model('pages');
            $seoPg = $this->pages->getSEOPage('siteMap');
            $seoPg = $seoPg[0];
            $data['pageTitle'] = $seoPg->Title;//Title tag
            $data['headerText'] = $seoPg->Header;//H1 tag
            $data['metaTitle'] = $seoPg->Meta_title;
            $data['metaKeywords'] = $seoPg->Meta_keywords;
            $data['metaDescription'] = $seoPg->Meta_Description;
           
            $this->load->model('Category');
            $data['pathLocation']='<a class="prevPath" href="/">HOME</a> > <a href="/siteMap" class="activePath">Site Map</a> ';
            $categories = $this->Category->get_categories();
            foreach($categories as $cat){
                $subcats = $this->Category->get_Subcategories('','',$cat->id);
                $scats = array();
                foreach($subcats as $sub){
                    
                    
                    $scats[] = array('subName'=>$sub->name,'subUrl'=> $this->config->item('base_url').$this->config->item('index_page').$sub->url);
                }
                $cat->subcategories = $scats;
                $cat->categoryUrl = $this->config->item('base_url').$this->config->item('index_page').$cat->url;
            }
            $data['categories'] = $categories;
            
            $data['pageName'] = 'SITE MAP';
            /**
             * Selected Menu deals and lastest deals
             */
              /**
               * Footer
               */
              /**********************************************/
                $this->load->library('parser');
                $this->parser->parse('widgets/header_new', $data);
                $this->parser->parse('siteMap_new', $data);
                $this->parser->parse('widgets/footer_new', $data);
        }
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
