<?php
class Reset_password_complete extends MY_Controller{
	public function index(){
		$this->load->library('session');
		
		if ($this->session->userdata('reset_password_complete') !== false){
			$this->session->unset_userdata('reset_password_complete');
			$var = array();
			$var['main_content'] = $this->load->view('admin/common/reset_password_complete', $var, true);
			$this->load->view('layouts/admin/login', $var);
		}else{
			redirect('/admin/login');
		}
	}
}