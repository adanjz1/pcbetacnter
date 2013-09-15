<?php

class Crud_auth extends CI_Model {

	public function __construct() {
		parent::__construct();
	}


	public function checkUserManagement(){
		$CRUD_AUTH = $this->session->userdata('CRUD_AUTH');
		if ((int) $CRUD_AUTH['group']['group_manage_flag'] != 1 &&
		(int) $CRUD_AUTH['group']['group_manage_flag'] != 3 &&
		(int) $CRUD_AUTH['user_manage_flag'] != 1 &&
		(int) $CRUD_AUTH['user_manage_flag'] != 3) {
			show_error('No Access');
		}
	}

	public function checkToolManagement(){
		$CRUD_AUTH = $this->session->userdata('CRUD_AUTH');
		if ((int) $CRUD_AUTH['group']['group_manage_flag'] != 2 &&
		(int) $CRUD_AUTH['group']['group_manage_flag'] != 3 &&
		(int) $CRUD_AUTH['user_manage_flag'] != 2 &&
		(int) $CRUD_AUTH['user_manage_flag'] != 3) {
			show_error('No Access');
		}
	}

	public function isGlobalAccess($com_id = null){
		$CRUD_AUTH = $this->session->userdata('CRUD_AUTH');
		$permissions = $this->getPermissionType($com_id);
		$flag = true;

		if ((int) $CRUD_AUTH['group']['group_global_access'] != 1 &&
		(int) $CRUD_AUTH['user_global_access'] != 1) {
			$flag = false;
		}
		if ($flag == false){
			if (!in_array(5, $permissions)) {
				$flag = false;
			}else {
				$flag = true;
			}
		}

		return $flag;
	}

	public function checkSettingManagement(){
		if (!$this->isSettingManagement()) {
			show_error('No Access');
		}
	}

	public function isSettingManagement(){
		$CRUD_AUTH = $this->session->userdata('CRUD_AUTH');
		$flag = true;
		if ((int) $CRUD_AUTH['group']['group_setting_management'] != 1 &&
		(int) $CRUD_AUTH['user_setting_management'] != 1) {
			$flag = false;
		}

		return $flag;
	}

	public function checkBrowsePermission() {
		$permissions = $this->getPermissionType();
		$xtype = $this->input->get('xtype');
		if (empty($xtype)) {
			$this->session->unset_userdata('auth_token_xtable');
			$this->session->unset_userdata('xtable_search_conditions');
			$xtype = $_GET['xtype'] = 'index';
		}
		switch (strtolower($xtype)) {
			case 'index':
				if (!in_array(4, $permissions)) {
					show_error('No Access');
				}
				break;
			case 'form':
			case 'confirm':
			case 'update':
				if (isset($_REQUEST['key'])){
					if (!in_array(2, $permissions)) {
						show_error('No Access');
					}
				}else{
					if (!in_array(1, $permissions)) {
						show_error('No Access');
					}
				}
				break;
			case 'del':
			case 'delFile':
			case 'delconfirm':
				if (!in_array(3, $permissions)) {
					redirect('error/no_access.php');
				}
				break;
		}
	}

	public function getPermissionType($com_id = null) {
		$CRUD_AUTH = $this->session->userdata('CRUD_AUTH');
		 
		if ($CRUD_AUTH['__system_admin__'] == 1){
			return array(1,2,3,4,5);
		}else{
			if ($com_id == null) {
				if (isset($_POST['com_id'])) {
					$com_id = $this->input->post('com_id');
				} else if (isset($_GET['com_id'])) {
					$com_id = $this->input->get('com_id');
				}
			}
			$rs = array();
			if (isset($CRUD_AUTH['group']['id'])) {
				$this->db->select('*');
				$this->db->from('crud_permissions');
				$this->db->where('group_id',(int) $CRUD_AUTH['group']['id']);
				$this->db->where('com_id',$com_id);
				$query = $this->db->get();
				$rs = $query->result_array();
				 
			}
			$permissions = array();
			if (!empty($rs)){
				foreach ($rs as $v){
					$permissions[] = $v['permission_type'];
				}
			}

			if (isset($CRUD_AUTH['id'])) {
				$this->db->select('*');
				$this->db->from('crud_user_permissions');
				$this->db->where('user_id',(int) $CRUD_AUTH['id']);
				$this->db->where('com_id',$com_id);
				$query = $this->db->get();
				$rs = $query->result_array();
			}
			if (!empty($rs)){
				foreach ($rs as $v){
					if (!in_array($v['permission_type'], $permissions)){
						$permissions[] = $v['permission_type'];
					}
				}
			}

			return $permissions;
		}

	}

}
