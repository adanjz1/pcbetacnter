<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

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
	public function index($limit = ''){
           
        }
        public function like($id=0){
            $this->load->library('session');
            $this->load->model('Deal');
            $dealLikes = $this->Deal->get_dealLikes($id);
            $dealLikes = $dealLikes[0]->thumbs;
            if(empty($this->session->all_userdata()[$id])){
                
                $this->session->set_userdata($id, true);

             
                
                $dealLikes = $dealLikes +1;
                $this->Deal->set_plusOnedeal($id,$dealLikes);
            }else{
                 
                $this->session->unset_userdata($id);
                $dealLikes = $dealLikes -1;
                $this->Deal->set_plusOnedeal($id,$dealLikes);
            }
            echo $dealLikes;
        }
}