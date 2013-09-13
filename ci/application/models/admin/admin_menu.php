<?php

class Admin_menu extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function fetch($type = 'dashboard') {

        $var = array();
        $var['type'] = $type;

        $var['database_name'] = $this->db->database;
        
        $this->db->select('*');
        $this->db->from('crud_components');
        $query = $this->db->get();

        $rs = $query->result_array();
        
        $coms = array();
        foreach ($rs as $v){
        	if (file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$v['id']).'/'.$v['component_table'].'.php' )) {
        		$coms[] = $v;
        	}
        }
        
        $this->db->select('*');
        $this->db->from('crud_group_components');
        $query = $this->db->get();
        
        $rs = $query->result_array();
        
        $mnuGroup = array();
        $exComs = array();
        foreach ($rs as $v){
        	$mnuGroup[$v['id']] = $v;
        	$mnuGroup[$v['id']]['coms'] = array();
        	foreach ($coms as $com){
        		if ($v['id'] == $com['group_id']){
        			$mnuGroup[$v['id']]['coms'][] = $com;
        			$exComs[] = $com['id'];
        		}
        	}
        }
        
        $var['mnuGroup'] = $mnuGroup;
        $var['exComs'] = $exComs;
        $var['coms'] = $coms;
        
        $this->load->model('crud_auth');
        $var['auth'] = $this->crud_auth;

        return $this->load->view('admin/menu/menu', $var, true);
    }

}