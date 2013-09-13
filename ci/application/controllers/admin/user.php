<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('crud_auth');
        $this->crud_auth->checkUserManagement();
    }

    public function index() {
        $this->load->model('admin/admin_menu');
        $this->load->add_package_path(APPPATH . 'third_party/scrud/');
        $_GET['table'] = 'crud_users';
        $var = array();
        $conf = array();
        $var['main_menu'] = $this->admin_menu->fetch('user');

        if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/crud_users.php')) {
            exit;
        }else{
        	require __DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/crud_users.php';
        }

        $hook = Hook::singleton();

        $hook->addFunction('SCRUD_ADD_FORM', 'addPasswordConfirmElement');
        $hook->addFunction('SCRUD_EDIT_FORM', 'addPasswordConfirmElement');

        $hook->addFunction('SCRUD_BEFORE_VALIDATE', 'passwordConfirmValidate');
        $hook->addFunction('SCRUD_VALIDATE', 'comparePassAndConfirmPass');
        $hook->addFunction('SCRUD_VALIDATE', 'checkUser');

        $hook->addFunction('SCRUD_BEFORE_SAVE', 'encryptPassword');
        
        $conf['theme_path'] = FCPATH . 'application/views/admin/user/templates';
        $this->load->library('crud', array('table' => 'crud_users', 'conf' => $conf));
        $var['main_content'] = $this->load->view('admin/user/user', array('content' => $this->crud->process()), true);
        
        $this->load->model('admin/admin_footer');
        $var['main_footer'] = $this->admin_footer->fetch();

        $this->load->view('layouts/admin/user/default', $var);
    }

    public function group() {
        $this->load->model('admin/admin_menu');
        $this->load->add_package_path(APPPATH . 'third_party/scrud/');
        $_GET['table'] = 'crud_groups';
        $var = array();
        $conf = array();
        $var['main_menu'] = $this->admin_menu->fetch('user');

        if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/crud_groups.php')) {
            exit;
        }else{
        	require __DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/crud_groups.php';
        }

        $conf['theme_path'] = FCPATH . 'application/views/admin/user/templates';
        $this->load->library('crud', array('table' => 'crud_groups', 'conf' => $conf));
        $var['main_content'] = $this->load->view('admin/user/group', array('content' => $this->crud->process()), true);
        
        $this->load->model('admin/admin_footer');
        $var['main_footer'] = $this->admin_footer->fetch();

        $this->load->view('layouts/admin/user/default', $var);
    }

    public function permission() {
        $this->load->model('admin/admin_menu');
        $this->load->library('session');
        
        $var = array();
        $var['main_menu'] = $this->admin_menu->fetch('user');

        $this->db->select('*');
        $this->db->from('crud_components');
        $query = $this->db->get();
        $var['coms'] = $query->result_array();

        $groups = array();
        $query = $this->db->query('SELECT * FROM crud_groups');
        if (!empty($query)) {
            foreach ($query->result_array() as $row) {
                $groups[] = $row;
            }
        }
        $var['groups'] = $groups;

        $query = $this->db->query('SELECT * FROM crud_permissions');
        $pt = array();
        if (!empty($query)) {
            foreach ($query->result_array() as $k => $v) {
                $pt[$v['group_id'] . '_' . $v['com_id'].'_'.$v['permission_type']] = $v['permission_type'];
            }
        }
        $var['pt'] = $pt;

        $var['main_content'] = $this->load->view('admin/user/permission', $var, true);
        
        $this->load->model('admin/admin_footer');
        $var['main_footer'] = $this->admin_footer->fetch();

        $this->load->view('layouts/admin/user/default', $var);
    }
    
    public function user_permission(){
    	$this->load->library('session');
    	$this->load->model('admin/admin_menu');
    	$var = array();
    	$var['main_menu'] = $this->admin_menu->fetch('user');
    	$var['main_content'] = $this->load->view('admin/user/user_permission_browse', $var, true);
    	
    	$this->load->model('admin/admin_footer');
    	$var['main_footer'] = $this->admin_footer->fetch();
    	
    	$this->load->view('layouts/admin/user/default', $var);
    }
    
    public function user_json(){
    	$userDao = new ScrudDao('crud_users', $this->db);
    	 
    	if (!isset($_GET['id'])){
    		$params = array();
    		$params['fields'] = array('id','user_name');
    		$params['conditions'] = array('user_name like ?',array("%".$_GET['q']."%"));
    		$rs = $userDao->find($params);
    		echo $_GET['callback'].'('.json_encode($rs).')';
    	}else{
    		$var = array();
    		
	    	$this->db->select('*');
        	$this->db->from('crud_components');
        	$query = $this->db->get();
        	$var['coms'] = $query->result_array();
    
    		$params = array();
    		$params['fields'] = array('id','user_name','user_manage_flag');
    		$params['conditions'] = array('id = ?',array($_GET['id']));
    		
    		$rs = $userDao->findFirst($params);
    		$var['user'] = $rs;
    
    		$pDao = new ScrudDao('crud_user_permissions', $this->db);
    		$params = array();
    		$params['conditions'] = array('user_id = ?',array($_GET['id']));
    
    		$rs = $pDao->find($params);
    		$pt = array();
    		if (!empty($rs)){
    			foreach($rs as $k => $v){
    				$pt[$v['user_id'].'_'.$v['com_id'].'_'.$v['permission_type']] = $v['permission_type'];
    			}
    		}
    
    		$var['pt'] = $pt;
    		
    		$this->load->view('admin/user/user_permission', $var);
    	}
    }

    public function savePermission() {
    	$this->load->library('session');
    	$groupDao = new ScrudDao('crud_groups', $this->db);
    	$pDao = new ScrudDao('crud_permissions', $this->db);
    	$data = $this->input->post('data');
    	$this->db->query('TRUNCATE TABLE `crud_permissions`');
    	
    	if (count($data) > 0) {
    		foreach ($data as $k => $v) {
    			$group = array();
    			$group['group_manage_flag'] = $v['group_manage_flag'];
    			$group['group_setting_management'] = $v['group_setting_management'];
    			$group['group_global_access'] = $v['group_global_access'];
    			$groupDao->update($group,array('id = ?',array($v['group_id'])));
    			$crudAuth = $this->session->userdata('CRUD_AUTH');
    			if ($v['group_id'] == $crudAuth['group']['id']){
    				$crudAuth['group']['group_manage_flag'] = $v['group_manage_flag'];
    				$crudAuth['group']['group_setting_management'] = $v['group_setting_management'];
    				$crudAuth['group']['group_global_access'] = $v['group_global_access'];
    			}
    			if (count($v['coms']) > 0){
    				$coms = $v['coms'];
    				foreach ($coms as $k1 => $v1){
    					if (count($v1['permission_type']) > 0){
    						foreach ($v1['permission_type'] as $permission){
    							if ((int)$permission > 0){
    								$p = array();
    								$p['group_id'] = $v['group_id'];
    								$p['com_id'] = $v1['com_id'];
    								$p['permission_type'] = $permission;
    								$pDao->save($p);
    							}
    						}
    					}
    				}
    			}
    		}
    	}
    }
	public  function saveUserPermission(){
		$this->load->library('session');
		$userDao = new ScrudDao('crud_users', $this->db);
		$pDao = new ScrudDao('crud_user_permissions', $this->db);
		$data = $this->input->post('data');
		$this->db->delete('crud_user_permissions', array('user_id' => $data[0]['user_id']));
		
		if (count($data) > 0) {
			foreach ($data as $k => $v) {
				$user = array();
				$user['user_manage_flag'] = $v['user_manage_flag'];
				$user['user_setting_management'] = $v['user_setting_management'];
				$user['user_global_access'] = $v['user_global_access'];
				$userDao->update($user,array('id = ?',array($v['user_id'])));
				$crudAuth = $this->session->userdata('CRUD_AUTH');
				if ($v['user_id'] == $crudAuth['id']){
					$crudAuth['user_manage_flag'] = $v['user_manage_flag'];
					$crudAuth['user_setting_management'] = $v['user_setting_management'];
					$crudAuth['user_global_access'] = $v['user_global_access'];
				}
				if (count($v['coms']) > 0){
					$coms = $v['coms'];
					foreach ($coms as $k1 => $v1){
						if (count($v1['permission_type']) > 0){
							foreach ($v1['permission_type'] as $permission){
								if ((int)$permission > 0){
									$p = array();
									$p['user_id'] = $v['user_id'];
									$p['com_id'] = $v1['com_id'];
									$p['permission_type'] = $permission;
									$pDao->save($p);
								}
							}
						}
					}
				}
			}
		}
	}
}