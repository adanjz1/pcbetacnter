<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends CI_Controller {

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
           
            
            $data['pageTitle'] = "Are you lost?";//Title tag
            $data['metaTitle'] = "404 error page";
            $data['metaKeywords'] = "pccounter, deals, 404 error";
            $data['metaDescription'] = "pccounter deals coupons";
            $data['pathLocation']='<a class="prevPath" href="/">HOME</a> > <a href="#" class="activePath">404 Error</a> ';
            /**
             * Selected Menu deals and lastest deals
             */
            $data['pageName'] = 'Error';
            $data['pageHtml'] = '<p>The requested URL was not found on this server. That’s all we know.</p>';
            $data['headerText'] = '';
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
