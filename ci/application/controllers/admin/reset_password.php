<?php
class Reset_password extends MY_Controller{
	public function index(){
		require_once FCPATH . 'application/third_party/scrud/class/Validation.php';
		$var = array();
		$code = $this->input->get('code');
		
		if (!empty($_POST)){
			$errors = array();
			$resetFlag = false;
			
			$this->db->select('*');
			$this->db->from('crud_users');
			$this->db->where('user_code',$code);
			$this->db->where('user_status','1');
			$query = $this->db->get();
			$user = $query->row_array();
			
			if (!empty($user)){
				if (!empty($user['user_code'])){
					$ary = explode('-', $code);
					if ($code == sha1('reset_password'.$user['user_email'].$ary[1]).'-'.$ary[1]){
						if (time() - $ary[1] < 24*60*60){
							$validate = Validation::singleton();
		
							if (!$validate->notEmpty($_POST['data']['user_password'])){
								$errors[] = sprintf($this->lang->line('please_enter_value'), $this->lang->line('password'));
							}
		
							if (!$validate->notEmpty($_POST['data']['user_confirm_password'])){
								$errors[] = sprintf($this->lang->line('please_enter_value'), $this->lang->line('confirm_password'));
							}
		
							if ($validate->notEmpty($_POST['data']['user_password']) && $validate->notEmpty($_POST['data']['user_confirm_password'])){
								if ($_POST['data']['user_password'] != $_POST['data']['user_confirm_password']){
									$errors[] = $this->lang->line('password_confirm_password_do_not_match');
								}
							}
							if (count($errors) == 0){
								$user['user_code'] = '';
								$user['user_password'] = sha1($_POST['data']['user_password']);
								
								$this->db->where('id', $user['id']);
								$this->db->update('crud_users', $user);
		
								$this->db->select('*');
								$this->db->from('crud_settings');
								$this->db->where('setting_key',sha1('general'));
								$query = $this->db->get();
								$setting = $query->row_array();
								$setting = unserialize($setting['setting_value']);
		
								$this->db->select('*');
								$this->db->from('crud_settings');
								$this->db->where('setting_key',sha1('reset_password'));
								$query = $this->db->get();
								$resetPasswordEmail = $query->row_array();
								$resetPasswordEmail = unserialize($resetPasswordEmail['setting_value']);
		
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
		
								$mail->Subject = $resetPasswordEmail['success_subject'];
		
								$body = $resetPasswordEmail['success_body'];
		
								$siteAddress = base_url();
		
								$body = str_replace('{site_address}', $siteAddress, $body);
								$body = str_replace('{user_name}', $user['user_name'], $body);
								$body = str_replace('{user_email}', $user['user_email'], $body);
		
								$mail->Body = $body;
								$mail->Send();
								$this->session->set_userdata('reset_password_complete', 1);
								$resetFlag = true;
							}
						}else{
							$errors['user_code'] = $this->lang->line('your_reset_password_code_is_expired');
						}
					}
				}
			}else{
				$errors['user_code'] =  $this->lang->line('your_reset_password_code_id_not_existed');
			}
		
			if ($resetFlag == true){
				redirect('/admin/reset_password_complete');
			}else{
				$var['code'] = $code;
				$var['errors'] = $errors;
				
				$var['main_content'] = $this->load->view('admin/common/reset_password', $var, true);
				$this->load->view('layouts/admin/login', $var);
			}
		
		}else{
			$var['code'] = $code;
			$var['errors'] = array();
			
			$var['main_content'] = $this->load->view('admin/common/reset_password', $var, true);
			$this->load->view('layouts/admin/login', $var);
		}
	}
}