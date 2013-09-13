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
           
            $data['pageTitle'] = 'Dell Coupons, HP Coupons, Cheap Laptops, Computer Sales';//Title tag
            $data['page_title'] = '';//H1 tag
            $data['page_desc'] = '';
           
            /**
             * Selected Menu deals and lastest deals
             */
            $this->load->model('Pages');
            $page = $this->Pages->getStaticPage($idPage);
            $page = $page[0];
            $data['pageName'] = $page->name;
            $data['pageHtml'] = $page->html;
            $data['headerText'] = $page->heading;
              /**
               * Footer
               */
              /**********************************************/
                $this->load->library('parser');
                $this->parser->parse('widgets/header', $data);
                $this->parser->parse('static', $data);
                
                $this->parser->parse('widgets/rightBar', $data);
                $this->parser->parse('widgets/footer', $data);
        }
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
