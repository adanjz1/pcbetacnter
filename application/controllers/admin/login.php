<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends Admin_Controller {

    public function index() {
        $this->load->model('admin/admin_common');

        $var = array();
        if ($this->admin_common->login()) {
            redirect('/admin/dashboard');
        } else {
        	$settingKey = sha1('general');
        	
        	$this->db->select('*');
        	$this->db->from('crud_settings');
        	$this->db->where('setting_key',$settingKey);
        	$query = $this->db->get();
        	$setting = $query->row_array();
        	$var['setting'] = unserialize($setting['setting_value']);
        	
        	$this->db->select('*');
        	$this->db->from('crud_languages');
        	$query = $this->db->get();
        	$var['languages'] = $query->result_array();
        	
            $var['main_content'] = $this->load->view('admin/common/login', $var, true);
            $this->load->view('layouts/admin/login', $var);
        }
    }

}