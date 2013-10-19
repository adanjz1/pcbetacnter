<?php
class Signup_complete extends MY_Controller{
	public function index(){
		$this->load->library('session');
		
		if ($this->session->userdata('signup_complete') !== false){
			$this->session->unset_userdata('signup_complete');
			$var = array();
			$var['main_content'] = $this->load->view('admin/common/signup_conplete', $var, true);
			$this->load->view('layouts/admin/login', $var);
		}else{
			redirect('/admin/login');
		}
	}
}