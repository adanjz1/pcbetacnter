<?php
class Activate_complete extends MY_Controller{
	public function index(){
		$this->load->library('session');
		
		if ($this->session->userdata('activate_complete') !== false){
			$this->session->unset_userdata('activate_complete');
			$var = array();
			$var['main_content'] = $this->load->view('admin/common/activate_complete', $var, true);
			$this->load->view('layouts/admin/login', $var);
		}else{
			redirect('/admin/login');
		}
	}
}