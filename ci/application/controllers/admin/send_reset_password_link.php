<?php
class Send_reset_password_link extends MY_Controller{
	public function index(){
		$userEmail = $this->input->post('user_email');
		if (!empty($userEmail) && $this->input->is_ajax_request() == true){
			$sendLink = true;

			$this->db->select('*');
			$this->db->from('crud_settings');
			$this->db->where('setting_key',sha1('general'));
			$query = $this->db->get();
			$setting = $query->row_array();
			$setting = unserialize($setting['setting_value']);
				
			if ((int)$setting['disable_reset_password'] == 1){
				exit;
			}
			
			$this->db->select('*');
			$this->db->from('crud_users');
			$this->db->where('user_email',trim($userEmail));
			$this->db->where('user_status','1');
			$query = $this->db->get();
			$user = $query->row_array();
			
			if (!empty($user)){
				if (!empty($user['user_code'])){
					$aryCode = explode('-', $user['user_code']);
					if ($user['user_code'] != sha1('reset_password'.$user['user_email'].$aryCode[1]).'-'.$aryCode[1]){
						$sendLink = false;
					}
				}
			}else{
				$sendLink = false;
			}

			if ($sendLink == true){
				$time = time();
				$code = sha1('reset_password'.$user['user_email'].$time).'-'.$time;
				
				$user['user_code'] = $code;
				$this->db->where('id', $user['id']);
				$this->db->update('crud_users', $user);

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
					
				$mail->Subject = $resetPasswordEmail['request_subject'];
					
				$body = $resetPasswordEmail['request_body'];
					
				$siteAddress = base_url();
				$resetLink = base_url().'index.php/admin/reset_password?code='.$code;
					
				$body = str_replace('{site_address}', $siteAddress, $body);
				$body = str_replace('{user_name}', $user['user_name'], $body);
				$body = str_replace('{user_email}', $user['user_email'], $body);
				$body = str_replace('{reset_link}', $resetLink, $body);
					
				$mail->Body = $body;
				$mail->Send();
			}

			if ($sendLink == true){
				$var['send_link'] = 1;
			}else{
				$var['send_link'] = 0;
			}

			echo json_encode($var);
		}
	}
}