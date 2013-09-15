<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Signup extends MY_Controller {

	public function index(){
		require_once FCPATH . 'application/third_party/scrud/class/recaptchalib.php';
		require_once FCPATH . 'application/third_party/scrud/class/Validation.php';
		$this->load->library('session');
		
		$settingKey = sha1('general');

		$var = array();
		$errors = array();
		$var['setting_key'] = $settingKey;

		$this->db->select('*');
		$this->db->from('crud_settings');
		$this->db->where('setting_key',$settingKey);
		$query = $this->db->get();
		$setting = $query->row_array();
		$setting = unserialize($setting['setting_value']);
		
		if ((int)$setting['disable_registration'] == 1){
			exit;
		}
		
		$crudUser = $this->input->post('crudUser');
		if (!empty($crudUser)){
		$validate = Validation::singleton();
			if (!$validate->notEmpty($crudUser['name'])){
				$errors[] = sprintf($this->lang->line('please_enter_value'), $this->lang->line('user_name'));
			}else{
				$this->db->select('id');
				$this->db->from('crud_users');
				$this->db->where('user_name',trim($crudUser['name']));
				$query = $this->db->get();
				$user = $query->row_array();
				if (!empty($user)){
					$errors[] = $this->lang->line('account_already_exits');
				}

			}

			if (!$validate->notEmpty($crudUser['password'])){
				$errors[] = sprintf($this->lang->line('please_enter_value'), $this->lang->line('password'));
			}

			if (!$validate->notEmpty($crudUser['confirm_password'])){
				$errors[] = sprintf($this->lang->line('please_enter_value'), $this->lang->line('confirm_password'));
			}

			if ($validate->notEmpty($crudUser['password']) && $validate->notEmpty($crudUser['confirm_password'])){
				if ($crudUser['password'] != $crudUser['confirm_password']){
					$errors[] = $this->lang->line('password_confirm_password_do_not_match');
				}
			}

			if (!$validate->notEmpty($crudUser['email'])){
				$errors[] = sprintf($this->lang->line('please_enter_value'), $this->lang->line('email'));
			}else if (!$validate->email($crudUser['email'])){
				$errors[] = sprintf($this->lang->line('please_provide_valid_email'), $this->lang->line('email'));
			}else{
				$this->db->select('id');
				$this->db->from('crud_users');
				$this->db->where('user_email',trim($crudUser['email']));
				$query = $this->db->get();
				$user = $query->row_array();
				if (!empty($user)){
					$errors[] = $this->lang->line('email_already_exits');
				}
			}

			if ((int)$setting['enable_recaptcha'] == 1){
				$privatekey = $setting['recaptcha_private_key'];
				$resp = recaptcha_check_answer ($privatekey,
						$_SERVER["REMOTE_ADDR"],
						$_POST["recaptcha_challenge_field"],
						$_POST["recaptcha_response_field"]);

				if (!$resp->is_valid) {
					$errors[] = $this->lang->line('recaptcha_was_not_correct');
				}
			}
			if (count($errors) == 0){
				$this->session->set_userdata('signup_complete', 1);
				$user = array();
				
				$user['user_name'] = $crudUser['name'];
				$user['user_password'] = sha1($crudUser['password']);
				$user['user_email'] = $crudUser['email'];
				
				if (isset($setting['require_email_activation']) && (int)$setting['require_email_activation'] == 1){
					$time = time();
					$code = sha1('activate'.$user['user_email'].$time).'-'.$time;
					$user['user_code'] = $code;
					$user['user_status'] = 0;
				}else{
					$user['user_status'] = 1;
				}
				
				if (isset($setting['default_group'])){
					$user['group_id'] = $setting['default_group'];
				}else{
					$user['group_id'] = 0;
				}
				$this->db->insert('crud_users', $user);
				if (isset($setting['require_email_activation']) && (int)$setting['require_email_activation'] == 1){
					$this->db->select('*');
					$this->db->from('crud_settings');
					$this->db->where('setting_key',sha1('new_user'));
					$query = $this->db->get();
					$newUserEmail = $query->row_array();
					$newUserEmail = unserialize($newUserEmail['setting_value']);
				
					require_once FCPATH . 'application/third_party/scrud/class/PHPMailer/class.phpmailer.php';
				
					$mail = new PHPMailer();
					if ((int)$setting['enable_smtp'] == 1){
						$mail->IsSMTP();
						if (isset($setting['smtp_auth']) && !empty($setting['smtp_auth'])){
							$mail->SMTPSecure = $setting['smtp_auth'];
						}
						$mail->Host       = $setting['smtp_host']; // SMTP server
						$mail->Port       = $setting['smtp_port'];  // set the SMTP port for the GMAIL server
						if ((int)$setting['enable_smtp_auth'] == 1){
							$mail->SMTPAuth   = true;                  // enable SMTP authentication
							$mail->Username   = $setting['smtp_account']; // SMTP account username
							$mail->Password   = $setting['smtp_password'];        // SMTP account password
						}
					}
				
					$mail->AddAddress($user['user_email']);
					$mail->SetFrom($setting['email_address'], $this->lang->line('please_do_not_reply'));
				
					$mail->Subject = $newUserEmail['send_link_subject'];
				
					$body = $newUserEmail['send_link_body'];
				
					$siteAddress = base_url();
					$activationLink = base_url().'index.php/admin/activate?code='.$code;
				
					$body = str_replace('{site_address}', $siteAddress, $body);
					$body = str_replace('{user_name}', $user['user_name'], $body);
					$body = str_replace('{user_email}', $user['user_email'], $body);
					$body = str_replace('{activation_link}', $activationLink, $body);
				
					$mail->Body = $body;
					$mail->Send();
				}
				
				redirect('/admin/signup_complete');
				
			}
		}
		
		$var['setting'] = $setting;
		$var['errors'] = $errors;
		
		$var['main_content'] = $this->load->view('admin/common/signup', $var, true);
		$this->load->view('layouts/admin/login', $var);
	}

}