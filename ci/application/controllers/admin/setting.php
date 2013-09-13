<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Setting extends Admin_Controller{
	public function index(){
		$this->load->model('crud_auth');
		$this->load->model('admin/admin_menu');

		$settingKey = sha1('general');

		$var = array();
		$var['setting_key'] = $settingKey;

		$this->db->select('*');
		$this->db->from('crud_settings');
		$this->db->where('setting_key',$settingKey);
		$query = $this->db->get();
		$setting = $query->row_array();
		$var['data'] = unserialize($setting['setting_value']);

		$this->db->select('*');
		$this->db->from('crud_groups');
		$query = $this->db->get();
		$var['groups'] = $query->result_array();

		$this->db->select('*');
		$this->db->from('crud_languages');
		$query = $this->db->get();
		$var['languages'] = $query->result_array();

		$var['main_menu'] = $this->admin_menu->fetch('setting');
		$var['main_content'] = $this->load->view('admin/setting/index',$var,true);
		
		$this->load->model('admin/admin_footer');
		$var['main_footer'] = $this->admin_footer->fetch();

		$this->load->view('layouts/admin/default', $var);
	}

	public function email($type = 'new_user'){
		$this->load->model('crud_auth');
		$this->load->model('admin/admin_menu');

		$var = array();
		$settingKey = sha1($type);

		$var['setting_key'] = $settingKey;

		$this->db->select('*');
		$this->db->from('crud_settings');
		$this->db->where('setting_key',$settingKey);
		$query = $this->db->get();
		$setting = $query->row_array();

		$var['data'] = unserialize($setting['setting_value']);

		$var['main_menu'] = $this->admin_menu->fetch('setting');
		switch ($type){
			case 'new_user':
				$var['main_content'] = $this->load->view('admin/setting/email_new_user',$var,true);
				break;
			case 'reset_password':
				$var['main_content'] = $this->load->view('admin/setting/email_reset_password',$var,true);
				break;
		}
		
		$this->load->model('admin/admin_footer');
		$var['main_footer'] = $this->admin_footer->fetch();


		$this->load->view('layouts/admin/default', $var);
	}

	public function save(){
		require_once FCPATH . 'application/third_party/scrud/class/Validation.php';
		$var = array();
		$var['error'] = 0;
		$validate = Validation::singleton();

		$data = $this->input->post('data');

		if (isset($data['email_address'])){
			if (!$validate->email($data['email_address'])){
				$var['error'] = 1;
				$var['error_message'] = $this->lang->line('please_provide_valid_email_for_admin_email');
			}
		}

		if ($var['error'] == 0){
			$setting = array();
			$setting['setting_key'] = $_POST['data']['setting_key'];
			$setting['setting_value'] = serialize($_POST['data']);

			$this->db->where('setting_key', $setting['setting_key']);
			$this->db->update('crud_settings', $setting);
		}

		echo json_encode($var);
	}
}