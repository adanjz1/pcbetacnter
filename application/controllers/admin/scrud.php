<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Scrud extends Admin_Controller {

    public function browse() {
    	$this->load->model('crud_auth');
		$this->crud_auth->checkBrowsePermission();
    	
        $this->load->model('admin/admin_menu');
        $this->load->add_package_path(APPPATH . 'third_party/scrud/');
        
        $var = array();
        $var['main_menu'] = $this->admin_menu->fetch('component');
        
        $comId = $this->input->get('com_id');
        
        $this->db->select('*');
        $this->db->from('crud_components');
        $this->db->where('id',$comId);
        $query = $this->db->get();
        $com = $query->row_array();
        
        $_GET['table'] = $com['component_table'];
        
        if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$comId). '/' . $com['component_table'] . '.php')) {
        	exit;
        }
        
        $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$comId) . '/' . $com['component_table'] . '.php'));
        $conf = unserialize($content);
        
        $hook = Hook::singleton();
        $hook->addFunction('SCRUD_INIT', 'f_scrud_init');
        $hook->addFunction('SCRUD_INIT', 'f_global_access');
        
        $components = array();
        $this->db->select('crud_components.*');
        $this->db->from('crud_components');
        $this->db->join('crud_group_components', 'crud_group_components.id = crud_components.group_id');
        $this->db->where('crud_components.group_id',$com['group_id']);
        $query = $this->db->get();
        $components = $query->result_array();
        $var['components'] = $components;
        if (!empty($components)){
        	$conf['theme_path'] = APPPATH.'views/admin/scrud/templates/browse';
        }
        
        $var['conf'] = $conf;
        
        $this->load->library('crud', array('table' => $com['component_table'], 'conf' => $conf,'restriction' => $com['component_restriction']));
        
        $var['content'] = $this->crud->process();
        
        $var['main_content'] = $this->load->view('admin/scrud/browse', $var, true);
        
        $this->load->model('admin/admin_footer');
        $var['main_footer'] = $this->admin_footer->fetch();
        
        $this->load->view('layouts/admin/scrud/browse', $var);
    }
    
    public function editorupload(){
    	$CRUD_AUTH = $this->session->userdata('CRUD_AUTH');
    	if (empty($CRUD_AUTH)){
    		exit;
    	}
    	if (isset($_GET['CKEditorFuncNum'])){
	    	require FCPATH.'/application/third_party/scrud/class/FileUpload.php';
	    	$msg = '';                                     // Will be returned empty if no problems
	    	$callback = ($_GET['CKEditorFuncNum']);        // Tells CKeditor which function you are executing
	    	
	    	$fileUpload = new FileUpload();
	    	$fileUpload->uploadDir = __IMAGE_UPLOAD_REAL_PATH__;
	    	$fileUpload->extensions = array('.bmp','.jpeg','.jpg','.png','.gif');
	    	$fileUpload->tmpFileName = $_FILES['upload']['tmp_name'];
	    	$fileUpload->fileName = $_FILES['upload']['name'];
	    	$fileUpload->httpError = $_FILES['upload']['error'];
	    	
	    	if ($fileUpload->upload()) {
	    		$image_url = __MEDIA_PATH__ . "images/".$fileUpload->newFileName;
	    	}
	    	
	    	$error = $fileUpload->getMessage();
	    	if (!empty($error)) {
	    		$msg =  'error : '. implode("\n",$error);
	    	}
	    	$output = '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$callback.', "'.$image_url .'","'.$msg.'");</script>';
	    	echo $output;
	    	
    	}
    	
    }

    public function config() {
    	$this->load->model('crud_auth');
    	$this->crud_auth->checkToolManagement();
    	
        $var = array();
        $this->load->model('admin/admin_menu');

        $comId = $this->input->get('com_id');
        $this->db->select('*');
        $this->db->from('crud_components');
        $this->db->where('id',$comId);
        $query = $this->db->get();
        $com = $query->row_array();
        $var['com'] = $com;
        $_GET['table'] = $com['component_table'];
        
        $table = $this->input->get('table', true);
        

        $fields = array();
        if($table == 'subCategories'){
            $table  = 'subcategories';
        }
        $sql = "SHOW COLUMNS FROM `" . $table . "`";
        $query = $this->db->query($sql);
        if (!empty($query)) {
            foreach ($query->result_array() as $row) {
                $fields[] = $row;
            }
        }
        $var['fields'] = $fields;

        if (file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $table . '/' . $table . '.php')) {
            $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $table . '/' . $table . '.php'));
            if (empty($content)) {
                $content = "{}";
            }
        } else {
            $content = "{}";
        }

        $var['crudConfigTable'] = $content;

        $tables = array();
        $query = $this->db->query('SHOW TABLES');
        if (!empty($query)) {
            foreach ($query->result_array() as $row) {
                $tables[] = $row['Tables_in_' . $this->db->database];
            }
        }
        $var['tables'] = $tables;

        $fieldConfig = array();
        foreach ($fields as $f) {
            if (file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $table . '/' . $f['Field'] . '.php')) {
                $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $table . '/' . $f['Field'] . '.php'));
                if (!empty($content)) {
                    $fieldConfig[$f['Field']] = $content;
                }
            }
        }
        $var['fieldConfig'] = $fieldConfig;

        $var['main_menu'] = $this->admin_menu->fetch('config');
        $var['main_content'] = $this->load->view('admin/scrud/config', $var, true);
        
        $this->load->model('admin/admin_footer');
        $var['main_footer'] = $this->admin_footer->fetch();

        $this->load->view('layouts/admin/scrud/config', $var);
    }

    public function getoptions() {
        $var = array();
        $config = $this->input->post('config');
        if (!empty($config)) {
            $crudDao = new ScrudDao($config['table'], $this->db);


            if (isset($config['key']) &&
                    trim($config['key']) != '' &&
                    isset($config['value']) &&
                    trim($config['value']) != '') {
                $params = array();
                $params['fields'] = array($config['key'], $config['value']);
                $rs = $crudDao->find($params);
                if (!empty($rs)) {
                    foreach ($rs as $v) {
                        $var[$v[$config['key']]] = $v[$config['value']];
                    }
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($var);
    }

    public function getfields() {
        $table = $this->input->get('table');
        $fields = array();
        $sql = "SHOW COLUMNS FROM `" . $table . "`";
        $query = $this->db->query($sql);
        if (!empty($query)) {
            foreach ($query->result_array() as $row) {
                $fields[] = $row['Field'];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($fields);
    }

    public function delfile() {
        $this->load->add_package_path(APPPATH . 'third_party/scrud/');
        $comId = $this->input->get('com_id');
        if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$comId) . '/' . $_GET['table'] . '.php')) {
            exit;
        }
        $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$comId) . '/' . $_GET['table'] . '.php'));
        $conf = unserialize($content);
        $this->load->library('crud', array('table' => $this->input->get('table'), 'conf' => $conf));
        $data = $this->crud->process();
        die($data);
    }

    public function removeconfig() {
        $this->load->model('crud_auth');
        $this->crud_auth->checkToolManagement();

        $comId = $this->input->get('com_id');
        if (!empty($comId) && trim($comId) != '') {
        	if (file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$comId))) {
        		removeDir(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$comId));
        	}
        }
        redirect('/admin/component/builder?xtype=index');
    }

    public function exportcsv() {
    	$this->load->add_package_path(APPPATH . 'third_party/scrud/');
    	$hook = Hook::singleton();
		$comId = $this->input->get('com_id');
		$conf = array();
    	if (!empty($comId)){
    		$this->db->select('*');
    		$this->db->from('crud_components');
    		$this->db->where('id',$comId);
    		$query = $this->db->get();
    		$com = $query->row_array();
    		$table = $com['component_table'];
    		$_GET['table'] = $com['component_name'];
    		if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$comId) . '/' . $com['component_table'] . '.php')) {
    			exit;
    		}
    		$content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database  . '/' .sha1('com_'.$comId). '/' . $com['component_table'] . '.php'));
    		$conf = unserialize($content);
    	}else{
    		$table = $this->input->get('table');
    		if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' . $table . '.php')) {
    			exit;
    		}
    		switch ($table){
    			case 'crud_users':
    			case 'crud_groups':
    				require __DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' . $table . '.php';
    				break;
    			default:
		    		$content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' . $table . '.php'));
		    		$conf = unserialize($content);
    			break;
    		}
    	}
    	
    	$hook->addFunction('SCRUD_INIT', 'f_global_access');
    	
    	
        $this->load->library('crud', array('table' => $table, 'conf' => $conf));
        echo $this->crud->process();
    }

    public function saveconfig() {
    	$this->load->model('crud_auth');
        $this->crud_auth->checkToolManagement();
    	
    	$comId = $this->input->post('com_id');
    	$this->db->select('*');
    	$this->db->from('crud_components');
    	$this->db->where('id',$comId);
    	$query = $this->db->get();
    	$com = $query->row_array();
    	
    	if (!empty($com) && isset($com['component_table'])) {
    	
    		if (!is_dir(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database)) {
    			$oldumask = umask(0);
    			mkdir(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database, 0777);
    			umask($oldumask);
    		}
    		if (!is_dir(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId))) {
    			$oldumask = umask(0);
    			mkdir(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId), 0777);
    			umask($oldumask);
    		}
    	
    		if (!is_dir(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $com['component_table'])) {
    			$oldumask = umask(0);
    			mkdir(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $com['component_table'], 0777);
    			umask($oldumask);
    		}
    		
    		$fields = array();
                $tab = $com['component_table'];
                if($tab == 'subCategories'){
                    $tab = 'subcategories';
                }
    		$sql = "SHOW COLUMNS FROM `" . $tab . "`";
    		$query = $this->db->query($sql);
    		if (!empty($query)) {
    			foreach ($query->result_array() as $row) {
    				$fields[] = $row;
    			}
    		}
    		

    		if (isset($_POST['config'])) {
    			if (file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $com['component_table'] . '/' . $com['component_table'] . '.php')) {
    				@unlink(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $com['component_table'] . '/' . $com['component_table'] . '.php');
    			}
    			$oldumask = umask(0);
    			file_put_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $com['component_table'] . '/' . $com['component_table'] . '.php', "<?php exit; ?>\n" . json_encode($_POST['config']));
    			umask($oldumask);
    		}
    		 
    		if (isset($_POST['scrud'])) {
    			$crud = $_POST['scrud'];
    			foreach ($fields as $field) {
    				if (file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $com['component_table'] . '/' . $field['Field'] . '.php')) {
    					@unlink(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $com['component_table'] . '/' . $field['Field'] . '.php');
    				}
    			}
    			foreach ($crud as $f => $v) {
    				$oldumask = umask(0);
    				file_put_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $com['component_table'] . '/' . $f . '.php', "<?php exit; ?>\n" . json_encode($v));
    				umask($oldumask);
    			}
    		}
    	
    		$conf = array();
    		$conf['title'] = $_POST['config']['table']['crudTitle'];
    		$conf['limit'] = $_POST['config']['table']['crudRowsPerPage'];
    		$conf['frm_type'] = $_POST['config']['frm_type'];
    		$join = array();
    	
    		if (isset($_POST['config']['join']) && count($_POST['config']['join']) > 0) {
    			foreach ($_POST['config']['join'] as $v) {
    				$join[$v['table']] = array($v['type'], $v['table'], $v['currentField'] . ' = ' . $v['targetField']);
    			}
    		}
    	
    		$conf['join'] = $join;
    	
    		if (isset($_POST['config']['table']['crudOrderField'])) {
    			$conf['order_field'] = $com['component_table'] . '.' . $_POST['config']['table']['crudOrderField'];
    		}
    	
    		if (isset($_POST['config']['table']['crudOrderType'])) {
    			$conf['order_type'] = $_POST['config']['table']['crudOrderType'];
    		}
    		$validate = array();
    		$dataList = array();
    		if (isset($_POST['config']['table']['noColumn']) &&
    		(int) $_POST['config']['table']['noColumn'] == 1) {
    			$dataList['no'] = array('alias' => $this->lang->line('no_'), 'width' => 40, 'align' => 'center', 'format' => '{no}');
    		}
    		foreach ($_POST['scrud'] as $field => $v) {
    			$elements[$com['component_table'] . '.' . $field] = array();
    			$element = array();
    			$element[] = $v['type'];
    			$attributes = array();
    			switch ($v['type']) {
    				case 'checkbox':
    				case 'radio':
    					if (!empty($v['options'])) {
    						$options = array();
    						foreach ($v['options'] as $key => $value) {
    							$options[$v['values'][$key]] = $value;
    						}
    						$element[] = $options;
    					}
    					break;
    				case 'select':
    					if (!empty($v['multiple'])) {
    						$attributes['multiple'] = $v['multiple'];
    					}
    				case 'autocomplete':
    					if ($v['list_choose'] == 'default') {
    						if (!empty($v['options'])) {
    							$options = array();
    							foreach ($v['options'] as $key => $value) {
    								$options[$key + 1] = $value;
    							}
    							$element[] = $options;
    						}
    					} else if ($v['list_choose'] == 'database') {
    						$opt = array();
    						$opt['option_table'] = $v['db_options']['table'];
    						$opt['option_key'] = $v['db_options']['key'];
    						$opt['option_value'] = $v['db_options']['value'];
    						$element[] = $opt;
    					}
    					break;
    				case 'text':
    				case 'password':
    					$style = "";
    					if (!empty($v['type_options']['size'])) {
    						$style .= "width:" . $v['type_options']['size'] . "px;";
    					}
    					if ($style != "") {
    						$attributes['style'] = $style;
    					}
    					break;
    				case 'textarea':
    					$style = "";
    					if (!empty($v['type_options']['width'])) {
    						$style .= "width:" . $v['type_options']['width'] . "px;";
    					}
    					if (!empty($v['type_options']['height'])) {
    						$style .= "height:" . $v['type_options']['height'] . "px;";
    					}
    					if ($style != "") {
    						$attributes['style'] = $style;
    					}
    					break;
    				case 'image':
    					$attributes['thumbnail'] = "mini";
    					$attributes['width'] = "";
    					$attributes['height'] = "";
    					if (!empty($v['type_options']['thumbnail'])) {
    						$attributes['thumbnail'] = $v['type_options']['thumbnail'];
    					}
    					if (!empty($v['type_options']['img_width'])) {
    						$attributes['width'] = $v['type_options']['img_width'];
    					}
    					if (!empty($v['type_options']['img_height'])) {
    						$attributes['height'] = $v['type_options']['img_height'];
    					}
    					break;
    			}
    			if (!empty($attributes)) {
    				$element[] = $attributes;
    			}
    			$tmpField = $field;
    			if (!empty($v['label'])) {
    				$tmpField = $formElements[$com['component_table'] . '.' . $field]['alias'] = $v['label'];
    				$elements[$com['component_table'] . '.' . $field]['alias'] = $v['label'];
    			} else {
    				$formElements[$com['component_table'] . '.' . $field]['alias'] = $v['field'];
    				$elements[$com['component_table'] . '.' . $field]['alias'] = $v['field'];
    			}
    	
    			$elements[$com['component_table'] . '.' . $field]['element'] = $element;
    			$formElements[$com['component_table'] . '.' . $field]['element'] = $element;
    	
    			if (!empty($_POST['scrud'][$field]['validation'])) {
    				switch ($_POST['scrud'][$field]['validation']) {
    					case 'notEmpty':
    						$validate[$com['component_table'] . '.' . $field] = array('rule' => $_POST['scrud'][$field]['validation'], 'message' => sprintf($this->lang->line('please_enter_value'), $tmpField));
    						break;
    					default :
    						switch ($_POST['scrud'][$field]['validation']) {
    							case 'alpha':
    								$tmpMessage = sprintf($this->lang->line('please_provide_alphabetic_input'), $tmpField);
    								break;
    							case 'alphaSpace':
    								$tmpMessage = sprintf($this->lang->line('please_provide_alphabetic_with_space_input'), $tmpField);
    								break;
    							case 'numeric':
    								$tmpMessage = sprintf($this->lang->line('please_provide_numeric_input'), $tmpField);
    								break;
    							case 'alphaNumeric':
    								$tmpMessage = sprintf($this->lang->line('please_provide_alphan_numeric_input'), $tmpField);
    								break;
    							case 'alphaNumericSpace':
    								$tmpMessage = sprintf($this->lang->line('please_provide_alpha_numeric_with_space_input'), $tmpField);
    								break;
    							case 'date':
    								$tmpMessage = sprintf($this->lang->line('please_provide_valid_date'), $tmpField);
    								break;
    							case 'datetime':
    								$tmpMessage = sprintf($this->lang->line('please_provide_valid_date_time'), $tmpField);
    								break;
    							case 'email':
    								$tmpMessage = sprintf($this->lang->line('please_provide_valid_email'), $tmpField);
    								break;
    							case 'ip':
    								$tmpMessage = sprintf($this->lang->line('please_provide_valid_ip'), $tmpField);
    								break;
    							case 'url':
    								$tmpMessage = sprintf($this->lang->line('please_provide_valid_url'), $tmpField);
    								break;
    						}
    						$validate[$com['component_table'] . '.' . $field][] = array('rule' => 'notEmpty', 'message' => $tmpMessage);
    						$validate[$com['component_table'] . '.' . $field][] = array('rule' => $_POST['scrud'][$field]['validation'], 'message' => $tmpMessage);
    						break;
    				}
    			}
    		}
    		if (isset($_POST['config']['column']['actived']) && count($_POST['config']['column']['actived']) > 0) {
    			foreach ($_POST['config']['column']['actived'] as $field) {
    				if (isset($_POST['config']['column']['atrr'][$field])) {
    					$attr = $_POST['config']['column']['atrr'][$field];
    				} else {
    					$attr = array();
    				}
    	
    				$tmpField = (strpos($field, '.') === false) ? $com['component_table'] . '.' . $field : $field;
    	
    				if (!empty($attr['alias'])) {
    					$dataList[$tmpField]['alias'] = $attr['alias'];
    				} else {
    					$dataList[$tmpField]['alias'] = $field;
    				}
    	
    				if (!empty($attr['width'])) {
    					$dataList[$tmpField]['width'] = $attr['width'];
    				}
    	
    				if (!empty($attr['align'])) {
    					$dataList[$tmpField]['align'] = $attr['align'];
    				}
    	
    				if (!empty($attr['format'])) {
    					$dataList[$tmpField]['format'] = $attr['format'];
    				}
    			}
    		}
    		if (isset($_POST['config']['filter']['actived']) && count($_POST['config']['filter']['actived']) > 0) {
    			foreach ($_POST['config']['filter']['actived'] as $field) {
    				$ary = array();
    				if (isset($_POST['config']['filter']['atrr'][$field]) &&
    				isset($_POST['config']['filter']['atrr'][$field]['alias'])) {
    					$ary['alias'] = $_POST['config']['filter']['atrr'][$field]['alias'];
    				}
    	
    				$ary['field'] = $com['component_table'] . '.' . $field;
    				$searchForm[] = $ary;
    			}
    		}
    	
    		if (!empty($searchForm)) {
    			$conf['search_form'] = $searchForm;
    		}
    	
    		if (!empty($validate)) {
    			$conf['validate'] = $validate;
    		}
    	
    		$width = 50;
    		if (!empty($formElements)) {
    			$format = '<a type="button" onclick="__view(\'{ppri}\'); return false;" class="btn btn-mini">' . $this->lang->line('view') . '</a>';
    			$format .= ' <a type="button" onclick="__edit(\'{ppri}\'); return false;" class="btn btn-mini btn-info">' . $this->lang->line('edit') . '</a>';
    			$width += 80;
    		}
    		$format .= ' <a type="button" onclick="__delete(\'{ppri}\'); return false;" class="btn btn-mini btn-danger">' . $this->lang->line('delete') . '</a>';
    	
    		$dataList['action'] = array('alias' => $this->lang->line('actions'), 'format' => $format, 'width' => $width, 'align' => 'center');
    	
    		if (!empty($dataList)) {
    			$conf['data_list'] = $dataList;
    		}
    	
    	
    		if (!empty($formElements)) {
    			$conf['form_elements'] = $formElements;
    		}
    	
    		if (!empty($elements)) {
    			$conf['elements'] = $elements;
    		}
    	
    		if (file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $com['component_table'] . '.php')) {
    			@unlink(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $com['component_table'] . '.php');
    		}
    		$oldumask = umask(0);
    		file_put_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $com['component_table'] . '.php', "<?php exit; ?>\n" . serialize($conf));
    		umask($oldumask);
    		
    		$vfields = array();
    		foreach ($fields as $v) {
    			$vfields[] = $v['Field'];
    		}
    		
    		if (!in_array('created_by', $vfields)){
    			$this->db->query("ALTER TABLE `".$com['component_table']."` ADD COLUMN created_by bigint(20)");
    		}
    		if (!in_array('created', $vfields)){
    			$this->db->query("ALTER TABLE `".$com['component_table']."` ADD COLUMN created TIMESTAMP NULL");
    		}
    		if (!in_array('modified_by', $vfields)){
    			$this->db->query("ALTER TABLE `".$com['component_table']."` ADD COLUMN modified_by bigint(20)");
    		}
    		if (!in_array('modified', $vfields)){
    			$this->db->query("ALTER TABLE `".$com['component_table']."` ADD COLUMN modified TIMESTAMP NULL");
    		}
    	
    	}
    }

}