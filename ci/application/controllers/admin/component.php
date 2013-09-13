<?php
class component extends Admin_Controller{
	public function __construct(){
		parent::__construct();
		
		$this->load->model('crud_auth');
		$this->crud_auth->checkToolManagement();
	}
	public function builder(){
		$this->load->model('admin/admin_menu');
		$this->load->add_package_path(APPPATH . 'third_party/scrud/');
		$var = array();
		$_GET['crud_components'] = 'crud_components';
		
		$var['main_menu'] = $this->admin_menu->fetch('tool');
		
		$conf = array();
		if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/crud_components.php')) {
			exit;
		}else{
			require __DATABASE_CONFIG_PATH__ . '/' .$this->db->database . '/crud_components.php';
		}
		
		$hook = Hook::singleton();
		
		$hook->addFunction('SCRUD_ADD_FORM', 'addTableElement');
		$hook->addFunction('SCRUD_EDIT_FORM', 'addTableElement');
		$hook->addFunction('SCRUD_ADD_CONFIRM', 'addTableElement');
		$hook->addFunction('SCRUD_EDIT_CONFIRM', 'addTableElement');
		$hook->addFunction('SCRUD_VIEW_FORM', 'addTableElement');
		$hook->addFunction('SCRUD_CONFRIM_DELETE_FORM', 'addTableElement');
		
		$hook->addFunction('SCRUD_BEFORE_UPDATE', 'removeConfig');
		$hook->addFunction('SCRUD_BEFORE_SAVE', 'checkGroup');
		$hook->addFunction('SCRUD_COMPLETE_DELETE', 'completeDelete');
		
		$conf['theme_path'] = FCPATH . 'application/views/admin/component/templates/builder';
		$this->load->library('crud', array('table' => 'crud_components', 'conf' => $conf));
		
		$var['main_content'] = $this->load->view('admin/component/builder',array('content' => $this->crud->process()),true);
		
		$this->load->model('admin/admin_footer');
		$var['main_footer'] = $this->admin_footer->fetch();
		
		$this->load->view('layouts/admin/scrud/browse', $var);
	}
	
	public function groups(){
		$this->load->model('admin/admin_menu');
		$this->load->add_package_path(APPPATH . 'third_party/scrud/');
		$var = array();
		$_GET['crud_components'] = 'crud_group_components';
		
		$var['main_menu'] = $this->admin_menu->fetch('tool');
		
		$conf = array();
		if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/crud_group_components.php')) {
			exit;
		}else{
			require __DATABASE_CONFIG_PATH__ . '/' .$this->db->database . '/crud_group_components.php';
		}
		
		$conf['theme_path'] = FCPATH . 'application/views/admin/component/templates/group';
		$this->load->library('crud', array('table' => 'crud_group_components', 'conf' => $conf));
		
		$var['main_content'] = $this->load->view('admin/component/group',array('content' => $this->crud->process()),true);
		
		$this->load->model('admin/admin_footer');
		$var['main_footer'] = $this->admin_footer->fetch();
		
		$this->load->view('layouts/admin/scrud/browse', $var);
	}
}

function addTableElement($element){
	$CI = & get_instance();
	$tables = array();
	$query = $CI->db->query('SHOW TABLES');
	if (!empty($query)) {
		foreach ($query->result_array() as $row) {
			if (strpos($row['Tables_in_' . $CI->db->database], 'crud_') !== false)
				continue;
			$tables[$row['Tables_in_' . $CI->db->database]] = $row['Tables_in_' . $CI->db->database];
		}
	}
	$element['crud_components.component_table'] = Array(
			'alias' => 'Table ',
			'element' => Array(
					0 => 'autocomplete',
					1 => $tables,
					2 => array(
							'style' => 'width:220px;'
					)
			)
	);

	return $element;

}

function checkGroup($data){
	if (empty($data['crud_components']['group_id'])){
		unset($data['crud_components']['group_id']);
	}
	
	return $data;
}

function removeConfig($data){
	$CI = & get_instance();
	$comDao = new ScrudDao('crud_components', $CI->db);
	$params = array();
	$params['conditions'] = array('id = ?',array($_POST['key']['crud_components']['id']));
	$com = $comDao->findFirst($params);
	if ($data['crud_components']['component_table'] != $com['component_table']) {
		if (file_exists(__DATABASE_CONFIG_PATH__ . '/' . $CI->db->database . '/' .sha1('com_'.$_POST['key']['crud_components']['id']))) {
			removeDir(__DATABASE_CONFIG_PATH__ . '/' . $CI->db->database  . '/'.sha1('com_'.$_POST['key']['crud_components']['id']));
		}
	}

	return $data;
}

function completeDelete($data){
	$CI = & get_instance();
	if (file_exists(__DATABASE_CONFIG_PATH__ . '/' . $CI->db->database . '/' .sha1('com_'.$_GET['key']['crud_components.id']))) {
		removeDir(__DATABASE_CONFIG_PATH__ . '/' . $CI->db->database  . '/'.sha1('com_'.$_GET['key']['crud_components.id']));
	}

	return $data;
}