<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class StaticPage extends CI_Controller {

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
	
        public function index($idPage){
           
            $this->load->helper('metaHelper');
            $this->load->helper(array('form', 'url')); 
            $data = getConstData($this);
           
            $this->load->model('Pages');
            $page = $this->Pages->getStaticPage($idPage);
            $page = $page[0];
            
            $data['pageTitle'] = $page->title;//Title tag
            $data['metaTitle'] = $page->meta_title;
            $data['metaKeywords'] = $page->meta_keywords;
            $data['metaDescription'] = $page->meta_description;
            $data['pathLocation']='<a class="prevPath" href="/">HOME</a> > <a href="'.$page->url.'" class="activePath">'.$page->title.'</a> ';
            /**
             * Selected Menu deals and lastest deals
             */
            $data['pageName'] = $page->name;
            $data['pageHtml'] = $page->html;
            $data['headerText'] = $page->heading;
              /**
               * Footer
               */
              /**********************************************/
                $this->load->library('parser');
                $this->parser->parse('widgets/header_new', $data);
                $this->parser->parse('static_new', $data);
                $this->parser->parse('widgets/footer_new', $data);
        }
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
