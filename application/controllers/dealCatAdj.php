<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DealCatAdj extends CI_Controller {

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
	
        public function index($category=1){

            $this->load->helper('url');
            $this->load->model('Deal');
            if(!empty($_POST)){
                foreach($_POST['check'] as $ch){
                    $this->Deal->editDealCat($ch,$_POST['category'],$_POST['subcategory']);
                }
            }
            $this->load->model('Category');
            $data['categories'] = $this->Category->get_categories(30);
            $data['subcategories'] = $this->Category->get_AllSubcategories();
            
            $data['deals'] = $this->Deal->getDealsForEditCat($category);
            $this->load->library('parser');
            $this->parser->parse('deal_cat_adjuster', $data);
        }
}
