<?php
	include "fbmain.php";
	
	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);			
	$db->connect();
	
	if($_REQUEST['mode'] == "login") 			login();
	elseif($_REQUEST['mode'] == "logout")		logout();
	elseif($_REQUEST['mode'] == "register")		register();
	elseif($_REQUEST['mode'] == "forgot")		forgot_password();
	
	#################################LOGIN STARTS HERE#################################
	
	function login()
	{
		$sqllog = "select * from ".MANAGE_USER." where user_email = BINARY '".$_REQUEST['login_email']."' and user_pass = BINARY '".$_REQUEST['login_password']."' and is_active = '1'";
		$reslog = mysql_query($sqllog) or die (mysql_error());
		$numlog = mysql_num_rows($reslog);
		if($rowlog = mysql_fetch_array($reslog))
			{
				$_SESSION['userid'] = $rowlog['user_id']; 
				$_SESSION['email'] = $rowlog['login_email'];
				header("location: ".SITE_URL."index.php?msg=loginsuccess");
			}
		elseif($numlog == 0)
			{
				header("location: ".SITE_URL."index.php?msg=loginerror");		
			}	
	}
	
	#################################LOGIN ENDS HERE#################################
	
	#################################LOGOUT STARTS HERE#################################
	
	function logout()
	{
		$_SESSION['userid'] = "";
		$_SESSION['email'] = "";
		unset($_SESSION['userid']);
		unset($_SESSION['email']);
		
		session_destroy();
		
		header("location: ".SITE_URL."index.php?msg=logoutsuccess");
		//header("Location: " . $facebook->getLogoutUrl(array('next'=>SITE_URL)));
	}
	
	#################################LOGOUT ENDS HERE#################################
	
	#################################REGISTRATION STARTS HERE#################################
	
	function register()
	{
		/*echo $_REQUEST['register_password'];
		die(">>>>>>>>>>>>>>>>>>");*/
		
		$sql_reg = "insert into ".MANAGE_USER." set user_email = '".$_REQUEST['register_email']."', user_pass = '".$_REQUEST['register_password']."', is_active = 1";
		$res_reg = mysql_query($sql_reg);
		
		$_SESSION['userid'] = mysql_insert_id(); 
		
		$email=$_REQUEST['register_email'];
		$subject="PC Counter Registered User Subcription";
		$message.="<p>Welcome to our PC Counter</p>";
		$message.="<p>We are pleased and proud that you have decided to join us and registered in our Site. </p>";
		$message.="<p>Below are your Login credentials:</p>";
		$message.="<p>Email:".$_REQUEST['register_email']."</p>";
		$message.="<p>Password:".$_REQUEST['register_password']."</p>";
		$message.="<p>Thanking you for user Registration</p>";
		$headers='MIME-Version: 1.0' . "\r\n";
		$headers.='Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers.='To: Registered User' . "\r\n";
		$headers.='From: PC Counter Admin' . "\r\n";
		
		mail($email, $subject, $message, $headers);
		
		header("location: ".SITE_URL."index.php?msg=registersuccess");
	}
	
	#################################REGISTRATION ENDS HERE#################################
	
	#################################FORGET PASSWORD STARTS HERE#################################
	
	function forgot_password()
	{
		$login_sql = "select 	* from ".MANAGE_USER." where user_email='".$_REQUEST['forget_email']."'";
		$login_rs = mysql_query($login_sql) or die (mysql_error());
		if(mysql_num_rows($login_rs) > 0)
		{
			$login_row = mysql_fetch_array($login_rs);
			
			$to = $_REQUEST['forget_email'];
			$subject = "Password Reset Confirmation.";
			$message = '<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td align="left">Hi '.stripslashes($login_row['user_email']).',</td>
								</tr>
								<tr><td>&nbsp;</td></tr>
								<tr>
									<td align="left">
										<b>Your login credentials are:</b>
									</td>
								</tr>
								<tr>
									<td>User Name: '.stripslashes($login_row['user_email']).' </td>
								</tr>
								<tr>
									<td>Password: '.stripslashes($login_row['user_pass']).' </td>
								</tr>
								<tr><td>&nbsp;</td></tr>
								<tr>
									<td align="left">
									Thanks,<br />
									PC Counter Team
									</td>
								</tr>
							</table>';
			$headers='MIME-Version: 1.0' . "\r\n";
			$headers.='Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers.='To: Forget Password User' . "\r\n";
			$headers.='From: PC Counter Admin' . "\r\n";
			
			mail($to, $subject, $message, $headers);
			
			header("location: ".SITE_URL."forgetpassword.php?msg=success");
			
		}
		else
		{
		
			header("location: ".SITE_URL."forgetpassword.php?msg=failed");
			
		}
	}
	
	#################################FORGET PASSWORD ENDS HERE#################################
	
?>