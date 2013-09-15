<?php
class Activate extends MY_Controller{
	public function index(){
		$this->load->library('session');
		$code = $this->input->get('code');
		if (!empty($code)){
		
			$this->db->select('*');
			$this->db->from('crud_users');
			$this->db->where('user_code',$code);
			$query = $this->db->get();
			$user = $query->row_array();
			
			if (!empty($user)){
				$ary = explode('-', $code);
				if ($code == sha1('activate'.$user['user_email'].$ary[1]).'-'.$ary[1]){
					$user['user_code'] = '';
					$user['user_status'] = 1;
					
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
		
					$mail->Subject = $newUserEmail['activated_subject'];
		
					$body = $newUserEmail['activated_body'];
		
					$siteAddress = base_url();
		
					$body = str_replace('{site_address}', $siteAddress, $body);
					$body = str_replace('{user_name}', $user['user_name'], $body);
					$body = str_replace('{user_email}', $user['user_email'], $body);
		
					$mail->Body = $body;
					$mail->Send();
					$this->session->set_userdata('activate_complete', 1);
		
					redirect('/admin/activate_complete');
				}
			}
		
		}
	}
}