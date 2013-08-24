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
            $data['storesPaginatorUrl'] = $this->config->item('base_url').$this->config->item('index_page').'/stores/paginator';
            $data['pageTitle'] = 'Dell Coupons, HP Coupons, Cheap Laptops, Computer Sales';//Title tag
            $data['page_title'] = '';//H1 tag
            $data['page_desc'] = '';
            
            $this->load->model('Source');
            $data['stores'] = $this->Source->get_stores(15);
            $data['stores2'] = $this->Source->get_stores(21,$limit,$initial);
            $data['noStores'] =  ((count($data['stores2'])==0)?'<div class="pro_box">
                                                        <span style="color:#FF0000;">NO STORES ARE THERE.</span>
                                                 </div>':'');
            $data['storesUrlBrandSearch'] = $this->config->item('base_url').$this->config->item('index_page').'/stores/index/0/';
            $data['initials'] = array(
                                        array(
                                            'id'=>'0-9'
                                        ),
                                        array(
                                           'id'=>'a'
                                        ),
                                        array(
                                           'id'=>'b'
                                        ),
                                        array(
                                           'id'=>'c'
                                        ),
                                        array(
                                           'id'=>'d'
                                        ),
                                        array(
                                           'id'=>'e'
                                        ),
                                        array(
                                           'id'=>'f'
                                        ),
                                        array(
                                           'id'=>'g'
                                        ),
                                        array(
                                           'id'=>'h'
                                        ),
                                        array(
                                           'id'=>'i'
                                        ),
                                        array(
                                           'id'=>'j'
                                        ),
                                        array(
                                           'id'=>'k'
                                        ),
                                        array(
                                           'id'=>'l'
                                        ),
                                        array(
                                           'id'=>'m'
                                        ),
                                        array(
                                           'id'=>'n'
                                        ),
                                        array(
                                           'id'=>'o'
                                        ),
                                        array(
                                           'id'=>'p'
                                        ),
                                        array(
                                           'id'=>'q'
                                        ),
                                        array(
                                           'id'=>'r'
                                        ),
                                        array(
                                           'id'=>'s'
                                        ),
                                        array(
                                           'id'=>'t'
                                        ),
                                        array(
                                           'id'=>'u'
                                        ),
                                        array(
                                           'id'=>'v'
                                        ),
                                        array(
                                           'id'=>'w'
                                        ),
                                        array(
                                           'id'=>'x'
                                        ),
                                        array(
                                           'id'=>'y'
                                        ),
                                        array(
                                           'id'=>'z'
                                        ),
                                    );
                $this->load->library('pagination');
                $config['base_url'] = $this->config->item('base_url').$this->config->item('index_page').'/stores/index/';
                $config['total_rows'] = $this->Source->get_totalStores($initial);
                $config['per_page'] = 21; 
                $this->pagination->initialize($config); 
                $data['paginator'] = $this->pagination->create_links();
                $data['dealsStore'] = $this->config->item('base_url').$this->config->item('index_page').'/deals/index/0/_/null/null/';
            /**
            * Footer
            */
           $data['staticPages'] = array();
           /**********************************************/
             $this->load->library('parser');
             $this->parser->parse('widgets/header', $data);
             $this->parser->parse('stores', $data);

             $this->parser->parse('widgets/rightBar', $data);
             $this->parser->parse('widgets/footer', $data);
        }
}