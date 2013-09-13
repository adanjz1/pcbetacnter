<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once FCPATH . 'application/third_party/scrud/class/Hook.php';
require_once FCPATH . 'application/third_party/scrud/class/ScrudDao.php';
require_once FCPATH . 'application/third_party/scrud/class/functions.php';

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->config->load('scrud');
        $this->load->helper('url');
        $this->load->database();
        
        $_lang = $this->session->userdata('lang');
        $_c_lang = $this->input->cookie('lang', true);
        if (!isset($_GET['lang']) && isset($_POST['lang'])){
        	$_GET['lang'] = $_POST['lang'];
        }
        if(isset($_GET['lang'])){
        	$language = $_GET['lang'];
        		
        	// register the session and set the cookie
        	$this->session->set_userdata('lang', $language);
        	
        	setcookie("lang", $language, time() + (3600 * 24 * 30),'/',false);
        		
        }else if(!empty($_lang)){
        	$language = $_lang;
        }else if(!empty($_c_lang)){
        	$language = $_c_lang;
        }else{
        	if (file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/v_1.0.txt')) {
	        	$this->db->select('*');
	        	$this->db->from('crud_settings');
	        	$this->db->where('setting_key',sha1('general'));
	        	$query = $this->db->get();
	        	$setting = $query->row_array();
	        	$setting = unserialize($setting['setting_value']);
	        	
	        	if (!empty($setting['default_language']) && trim($setting['default_language']) != ''){
	        		$language = $setting['default_language'];
	        	}else{
	        		$language = 'default';
	        	}
        	}else{
        		$language = 'default';
        	}
        }
        
        $this->lang->load('message', $language);
    }

}

class Admin_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->authenticate();

        $hook = Hook::singleton();

        $hook->set('SCRUD_INIT');
        $hook->set('SCRUD_BEFORE_VALIDATE');
        $hook->set('SCRUD_VALIDATE');
        $hook->set('SCRUD_ADD_FORM');
        $hook->set('SCRUD_EDIT_FORM');
        $hook->set('SCRUD_VIEW_FORM');
        $hook->set('SCRUD_ADD_CONFIRM');
        $hook->set('SCRUD_EDIT_CONFIRM');
        $hook->set('SCRUD_BEFORE_SAVE');
        $hook->set('SCRUD_BEFORE_INSERT');
        $hook->set('SCRUD_BEFORE_UPDATE');
        $hook->set('SCRUD_COMPLETE_INSERT');
        $hook->set('SCRUD_COMPLETE_UPDATE');
        $hook->set('SCRUD_COMPLETE_SAVE');
        $hook->set('SCRUD_CONFRIM_DELETE_FORM');
        $hook->set('SCRUD_COMPLETE_DELETE');
    }

    private function authenticate() {
        if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/v_1.0.txt')) {
            redirect('install/index');
        } else {
            $auth = $this->session->userdata('CRUD_AUTH');
            if (empty($auth) && $this->uri->uri_string() != 'admin/login') {
                redirect('/admin/login');
            }
        }
    }

}