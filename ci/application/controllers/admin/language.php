<?php
class Language extends Admin_Controller{
	public function __construct(){
		parent::__construct();
	
		$this->load->model('crud_auth');
		$this->crud_auth->checkToolManagement();
	}
	public function index(){
		$this->load->model('admin/admin_menu');
		$this->load->add_package_path(APPPATH . 'third_party/scrud/');
		
		$_GET['table'] = 'crud_languages';
		$var = array();
		$conf = array();
		$var['main_menu'] = $this->admin_menu->fetch('tool');
		
		if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/'.$_GET['table'].'.php')) {
			exit;
		}else{
			require __DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/'.$_GET['table'].'.php';
		}
		
		$hook = Hook::singleton();
		$hook->addFunction('SCRUD_EDIT_FORM', 'edit_form');
		$hook->addFunction('SCRUD_VALIDATE','validate_language_code');
		$hook->addFunction('SCRUD_BEFORE_UPDATE','before_update');
		$hook->addFunction('SCRUD_COMPLETE_SAVE', 'complete_save');
		$hook->addFunction('SCRUD_COMPLETE_DELETE', 'complete_delete');
		
		$conf['theme_path'] = FCPATH . 'application/views/admin/language/templates';
		
		$this->load->library('crud', array('table' => $_GET['table'], 'conf' => $conf));
		$var['main_content'] = $this->load->view('admin/language/index', array('content' => $this->crud->process()), true);
		
		$this->load->model('admin/admin_footer');
		$var['main_footer'] = $this->admin_footer->fetch();
		
		$this->load->view('layouts/admin/user/default', $var);
	}
	
	public function translate(){
		if (!empty($_POST)){
			$var = array();
			$var['error'] = 0;
			$language = $_POST;
			unset($language['language_code']);
			$language_file = FCPATH.'application/language/'.$_POST['language_code'].'/message_lang.php';
				
			if (!is_writable($language_file)) {
				$var['error'] = 1;
				$var['error_message'] = sprintf($this->lang->line('file_is_not_allowed_write'), $language_file);
			}
			if (file_exists($language_file) && $var['error'] == 0){
				file_put_contents($language_file, "<?php \n");
				foreach ($language as $key => $lang){
					$lang = str_replace("'", "&#039;", $lang);
					$message =<<<HTML
\$lang['$key'] = '$lang'; \n
HTML;
					file_put_contents($language_file, $message, FILE_APPEND);
						
				}
				$message =<<<HTML
\$lang['date_text'] = array('days' => array(\$lang['datepicker_sunday'], \$lang['datepicker_monday'], \$lang['datepicker_tuesday'], \$lang['datepicker_wednesday'], \$lang['datepicker_thursday'], \$lang['datepicker_friday'],  \$lang['datepicker_saturday'], \$lang['datepicker_sunday']), \n
							'daysShort' => array(\$lang['datepicker_sun'], \$lang['datepicker_mon'], \$lang['datepicker_tue'], \$lang['datepicker_wed'], \$lang['datepicker_thu'], \$lang['datepicker_fri'], \$lang['datepicker_sat'], \$lang['datepicker_sun']), \n
							'daysMin' => array(\$lang['datepicker_su'], \$lang['datepicker_mo'], \$lang['datepicker_tu'], \$lang['datepicker_we'], \$lang['datepicker_th'], \$lang['datepicker_fr'], \$lang['datepicker_sa'], \$lang['datepicker_su']), \n
							'months' => array(\$lang['datepicker_january'], \$lang['datepicker_february'], \$lang['datepicker_march'], \$lang['datepicker_april'], \$lang['datepicker_may'], \$lang['datepicker_june'], \$lang['datepicker_july'], \$lang['datepicker_august'], \$lang['datepicker_september'], \$lang['datepicker_october'], \$lang['datepicker_november'], \$lang['datepicker_december']), \n
							'monthsShort' => array(\$lang['datepicker_jan'], \$lang['datepicker_feb'], \$lang['datepicker_mar'], \$lang['datepicker_apr'], \$lang['datepicker_may'], \$lang['datepicker_jun'], \$lang['datepicker_jul'], \$lang['datepicker_aug'], \$lang['datepicker_sep'], \$lang['datepicker_oct'], \$lang['datepicker_nov'], \$lang['datepicker_dec'])); \n
HTML;
				file_put_contents($language_file, $message, FILE_APPEND);
	
			}
				
			echo json_encode($var);
			exit;
		}else{
			$this->load->model('admin/admin_menu');
			$this->load->add_package_path(APPPATH . 'third_party/scrud/');
			$var = array();
			$var['main_menu'] = $this->admin_menu->fetch('tool');
			
			$this->db->select('*');
			$this->db->from('crud_languages');
			$this->db->where('id',trim($_GET['id']));
			$query = $this->db->get();
			
			$rs = $query->row_array();
			
			$var['rs'] = $rs;
				
			$lang = array();
			if (!empty($rs)){
				if (file_exists(FCPATH.'application/language/default/message_lang.php')){
					require FCPATH.'application/language/default/message_lang.php';
				}
			}
			$var['lang_default'] = $lang;
				
			$lang = array();
			if (!empty($rs)){
				if (file_exists(FCPATH.'application/language/'.$rs['language_code'].'/message_lang.php')){
					require FCPATH.'application/language/'.$rs['language_code'].'/message_lang.php';
				}
			}
			$var['lang'] = $lang;
				
			$var['main_content'] = $this->load->view('admin/language/translate', $var, true);
			
			$this->load->model('admin/admin_footer');
			$var['main_footer'] = $this->admin_footer->fetch();
			
			$this->load->view('layouts/admin/user/default', $var);
				
		}
	}
}
