<?php
class Admin_footer extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	public function fetch(){
		$var = array();
		$this->db->select('*');
		$this->db->from('crud_languages');
		$query = $this->db->get();
		$var['languages'] = $query->result_array();
		
		return $this->load->view('admin/common/footer', $var, true);
	}
}