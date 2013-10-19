<?php

function removeDir($dirPath) {
    if (!is_dir($dirPath)) {
        throw new Exception("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            removeDir($file);
        } else {
            @unlink($file);
        }
    }
    @rmdir($dirPath);
}

function recurse_copy($src, $dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while (false !== ( $file = readdir($dir))) {
        if (( $file != '.' ) && ( $file != '..' ) && ( $file != '.svn' )) {
            if (is_dir($src . '/' . $file)) {
                recurse_copy($src . '/' . $file, $dst . '/' . $file);
            } else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

function str2mysqltime($str,$format = 'Y-m-d H:i:s'){
	$date = '';
	$date = date ( $format, strtotime ( $str ) );
	if (date ( 'Y-m-d', strtotime ( $date ) ) <= '1970-01-01') {
		$str = str_replace ( '/', '-', $str );
		$date = date ( $format, strtotime ( $str ) );
		if (date ( 'Y-m-d', strtotime ( $date ) ) <= '1970-01-01') {
			$str = str_replace ( '-', '/', $str );
			$date = date ( $format, strtotime ( $str ) );
		}
	}

	return $date;
}

function is_date($str){
	if (!empty($str) && trim($str) != ''){
		$str = str2mysqltime($str,'Y-m-d');
		if ($str <= '1970-01-01'){
			return false;
		}else{
			return true;
		}
	}else{
		return false;
	}
}

function f_scrud_init($conf) {
    $CI = & get_instance();
    $CI->load->model('crud_auth');
    $CI->crud_auth->checkBrowsePermission();

    return $conf;
}

function f_global_access($conf){
	
	if (isset($_GET['com_id'])){
		$CI = & get_instance();
		$CI->load->model('crud_auth');
		$conf['global_access'] = $CI->crud_auth->isGlobalAccess();
	}

	return $conf;
}

function addPasswordConfirmElement($element) {
    $tmp = array();
    foreach ($element as $k => $v) {
        if (isset($_REQUEST['key']) && $k == 'crud_users.user_name') {
            $v['element'][1]['readonly'] = "readonly";
        }

        $tmp[$k] = $v;
        if ($k == 'crud_users.user_password') {
            $tmp['crud_users.user_password_confirm'] = Array(
                'alias' => 'User confirm password ',
                'element' => Array(
                    0 => 'password',
                    1 => Array(
                        'style' => 'width:210px;'
                    )
                )
            );
        }
    }
    $element = $tmp;

    return $element;
}

function passwordConfirmValidate($validate) {
    if (isset($_GET['xtype']) && $_GET['xtype'] != 'update') {
        $validate['crud_users.user_password_confirm'] = array('rule' => 'notEmpty',
            'message' => 'Please enter the value for User confirm password .');
    }
    return $validate;
}

function comparePassAndConfirmPass($error) {
    $CI = & get_instance();
    $data = $CI->input->post('data');
    if (!empty($data['crud_users']['user_password']) &&
            !empty($data['crud_users']['user_password_confirm'])) {
        if ($data['crud_users']['user_password'] != $data['crud_users']['user_password_confirm']) {
            $error['crud_users.user_password'][] = 'User password doesn\'t match User confirm password ';
            $error['crud_users.user_password_confirm'] = array();
        }
    }

    return $error;
}

function encryptPassword($data) {
    $data['crud_users']['user_password'] = sha1($data['crud_users']['user_password']);

    return $data;
}

function checkUser($error) {
    $CI = & get_instance();
    $key = $CI->input->post('key');
    $data = $CI->input->post('data');
    if (empty($key)) {
        $CI->db->select('*');
        $CI->db->from('crud_users');
        $CI->db->where('user_name', $data['crud_users']['user_name']);

        $query = $CI->db->get();
        $rs = $query->row_array();

        if (!empty($rs)) {
            $error['crud_users.user_name'][] = 'Someone already has that username. Try another? ';
        }
    }

    return $error;
}

function removeElement($element) {
    unset($element['crud_users.user_name']);
    unset($element['crud_users.user_password']);
    unset($element['crud_users.group_id']);
    unset($element['crud_users.user_status']);

    return $element;
}

function removeElementData($data) {

    if (isset($data['crud_users']['user_name'])) {
        unset($data['crud_users']['user_name']);
    }
    if (isset($data['crud_users']['user_password'])) {
        unset($data['crud_users']['user_password']);
    }
    if (isset($data['crud_users']['group_id'])) {
        unset($data['crud_users']['group_id']);
    }

    return $data;
}

function removeValidate($validate) {
    unset($validate['crud_users.user_name']);
    unset($validate['crud_users.user_password']);
    unset($validate['crud_users.group_id']);

    return $validate;
}

function completeUpdate($data) {
    redirect('/user/editprofile');
}

function validate_language_code($error){
	$CI = & get_instance();
	if (empty($_POST['key'])) {
		$CI->db->select('*');
		$CI->db->from('crud_languages');
		$CI->db->where('language_code',trim($_POST['data']['crud_languages']['language_code']));
		$query = $CI->db->get();
		$rs = $query->row_array();

		if (!empty($rs)) {
			$error['crud_languages.language_code'][] = $CI->lang->line('language_code_is_existed');
		}

		if (!is_writable(FCPATH.'application/language')) {
			$error['error_directory_write'][] = sprintf($CI->lang->line('directory_is_not_allowed_write'), FCPATH.'application/language');
		}
	}
	return $error;
}

function edit_form($element){
	$tmp = array();
	foreach ($element as $k => $v) {
		if (isset($_REQUEST['key']) && $k == 'crud_languages.language_code'){
			$v['element'][1]['readonly'] = "readonly";
		}
		$tmp[$k] = $v;
	}
	$element = $tmp;

	return $element;
}

function before_update($data){
	if (isset($data['crud_languages']['language_code'])){
		unset($data['crud_languages']['language_code']);
	}

	return $data;
}

function complete_save($data){
	if (empty($_POST['key'])) {
		if (!is_dir(FCPATH.'application/language/'.$data['crud_languages']['language_code'])) {
			$oldumask = umask(0);
			mkdir(FCPATH.'application/language/'.$data['crud_languages']['language_code']);
			umask($oldumask);
		}
		if (!file_exists(FCPATH.'application/language/'.$data['crud_languages']['language_code'].'/message_lang.php')){
			$oldumask = umask(0);
			$fcontent = file_get_contents(FCPATH.'application/language/default/message_lang.php');
			file_put_contents(FCPATH.'application/language/'.$data['crud_languages']['language_code'].'/message_lang.php', $fcontent);
			umask($oldumask);
		}
	}

}

function complete_delete($data){
	if (!empty($data['crud_languages']['language_code']) && trim($data['crud_languages']['language_code']) != ''){
		if (is_dir(FCPATH.'application/language/'.$data['crud_languages']['language_code'])) {
			removeDir(FCPATH.'application/language/'.$data['crud_languages']['language_code']);
		}
	}
}