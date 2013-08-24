<?php
	include("includes/header.php");
	
	if($_REQUEST['mode'] == "contactsform") 			contactuser();
?>
<script language="javascript" type="text/javascript">
function checkcontact()
	{
		if(document.contactus.contact_username.value.search(/\S/) == -1)
		{
			document.getElementById("err_contact_username").innerHTML="Please enter your Full Name";
			document.contactus.contact_username.value="";
			document.contactus.contact_username.focus();
			return false;
		}
		else
		{
			document.getElementById("err_contact_username").innerHTML="";
		}	
		
		if(document.contactus.contact_email.value.search(/\S/) == -1)
		{
			document.getElementById("err_contact_email").innerHTML="Please enter your valid Email";
			document.contactus.contact_email.value="";
			document.contactus.contact_email.focus();
			return false;
		}
		else
		{
			document.getElementById("err_contact_email").innerHTML="";
		}
		
		var x = document.contactus.contact_email.value;
	    var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	   
	    if (!filter.test(x))
	    { 
			document.getElementById("err_contact_email").innerHTML="Please enter valid Email-ID";
			document.contactus.contact_email.value="";
			document.contactus.contact_email.focus();
			return false;
	    }
		else
		{
			document.getElementById("err_contact_email").innerHTML="";
		}
		
		if(document.contactus.contact_subject.value.search(/\S/) == -1)
		{
			document.getElementById("err_contact_subject").innerHTML="Please enter your Related Query Subject";
			document.contactus.contact_subject.value="";
			document.contactus.contact_subject.focus();
			return false;
		}
		else
		{
			document.getElementById("err_contact_subject").innerHTML="";
		}
		
		if(document.contactus.contact_message.value.search(/\S/) == -1)
		{
			document.getElementById("err_contact_message").innerHTML="Please enter your Contact Us Message";
			document.contactus.contact_message.value="";
			document.contactus.contact_message.focus();
			return false;
		}
		else
		{
			document.getElementById("err_contact_message").innerHTML="";
		}
		return true;
	}
</script>
<div id="maincontent">
	<div class="topbox">
		<div class="topbox_1">
			<h1>Contact Us</h1>
			<p>Please put your query on any relevant Topics. We will try to meet you up with your need as soon as possible.</p>
		</div>
		<div class="topbox_r">
		
			<!--<img src="images/like.gif" alt="" width="81" height="22" />&nbsp;&nbsp;&nbsp; 
			<img src="images/g+.gif" alt="" width="75" height="22" />-->
			
			<!--FACEBOOK LIKE BUTTON STARTS-->
			
			<div id="fb-root" style="float:left;  width: 60px; margin: 0 auto 0 40px;"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			
			<div class="fb-like" data-href="http://durba/pc_counter/" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true" style="float: right; width: 81px; margin: 0 auto;"></div>
			
			<!--FACEBOOK LIKE BUTTON STOPS-->
			
			<!--GOOGLE PLUS LIKE BUTTON STARTS-->
			
			<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
			<div class="g-plusone"></div>
			
			<!--GOOGLE PLUS LIKE BUTTON STOPS-->
			
		</div>
	</div>
	<div class="clear"></div>
	<div id="content">
		<div class="leftcol">
			<div class="latest_deal">
				<div class="left_top"><h1>Please put in the required credentials for the below form</h1></div>
				<div class="left_mid">
					<form name="contactus" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return checkcontact();">
						<input type="hidden" name="mode" value="contactsform" />
						<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="registration">
						<tr>
							<td>
								<?php
									if($_REQUEST['msg'] == "successcontact")
									{
										echo "We have already got your Contact Message. We will reach with our response soon in your mail.";
									}
									elseif($_REQUEST['msg'] == "failedcontact")
									{
										echo "We have already got your Contact Messages. Get back to you soon. Don't Worry. ";
									}
								?>
							</td>
						</tr>						
						<tr>
							  <td colspan="2" style="padding: 15px 0 0 15px;">
									Full Name<br /><input type="text" name="contact_username" class="txtfieldbg" style="margin:6px 0 0 0;"/><br />
									<span style="color:#FF0000;" id="err_contact_username"></span>
							  </td>
						</tr>
						<tr>
							  <td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							  <td colspan="2" style="padding: 15px 0 0 15px;">
									Email<br /><input type="text" name="contact_email" class="txtfieldbg" style="margin:6px 0 0 0;"/><br />
									<span style="color:#FF0000;" id="err_contact_email"></span>
							  </td>
						</tr>
						<tr>
							  <td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							  <td colspan="2" style="padding: 0px 0 0 15px;">
									Subject<br/><input type="text" name="contact_subject" class="txtfieldbg" style="margin:6px 0 0 0;"/><br />
									<span style="color:#FF0000;" id="err_contact_subject"></span>
							  </td>
						</tr>
						<tr>
							  <td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							  <td colspan="2" style="padding: 0px 0 0 15px;">
									Message<br/><textarea name="contact_message" class="txtfieldbg" style="margin:6px 0 0 0;" cols="20"></textarea><br />
									<span style="color:#FF0000;" id="err_contact_message"></span>
							  </td>
						</tr>       
						<tr>
							  <td colspan="2"></td>
						</tr>
						<tr>
							  <td colspan="2" style="padding: 15px 0 0 15px;">
									<input type="submit" name="Submit3" class="create_btn" value="Submit Your Query"/>
							  </td>
						</tr>
					</table>
					</form>				
				</div>
				<div class="left_bot"></div>
			</div>
		</div>
		
		<?php
			include("includes/rightcol.php");
		?>
		
	</div>
</div>
<?php
	include("includes/footer.php");
?>

<?php
	function contactuser()
	{
		$sqlcheck_email = "select * from ".MANAGE_CONTACTUS_MAIL." where contact_username = '".$_REQUEST['contact_username']."' and contact_email = '".$_REQUEST['contact_email']."' and contact_subject = '".$_REQUEST['contact_subject']."' and contact_message = '".$_REQUEST['contact_message']."' and is_active = 1";
		$rescheck_email = mysql_query($sqlcheck_email);
		$numcheck_email = mysql_num_rows($rescheck_email);
		
		if($numcheck_email == 0)
		{
			$sqlinsert_contact = "insert into ".MANAGE_CONTACTUS_MAIL." (contact_username,contact_email,contact_subject,contact_message,is_active,posted_on) values('".$_REQUEST['contact_username']."','".$_REQUEST['contact_email']."','".$_REQUEST['contact_subject']."','".$_REQUEST['contact_message']."',1,NOW())";
			$resinsert_contact = mysql_query($sqlinsert_contact);
		$sqladmin = "select admin_id,admin_email from ".TABLE_ADMIN." where admin_id = 1";
		$resadmin = mysql_query($sqladmin);
		$rowadmin = mysql_fetch_array($resadmin);
		
		$to = $rowadmin['admin_email'];
		$subject = "Contact Us Email";
		$message = '<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td align="left">Hi !! Myself '.stripslashes($_REQUEST['contact_username']).' have a query below.</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td align="left">
									<b>Please go through the details and let me know as soon as possible.</b>
								</td>
							</tr>
							<tr>
								<td>Subject: '.stripslashes($_REQUEST['contact_subject']).' </td>
							</tr>
							<tr>
								<td>Message: '.stripslashes($_REQUEST['contact_message']).' </td>
							</tr>
							<tr>
								<td>Contact Me via my Mail Address: '.stripslashes($_REQUEST['contact_email']).' </td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td align="left">
								Thanks,<br />
								PC Counter Contact Us User
								</td>
							</tr>
						</table>';
		$headers='MIME-Version: 1.0' . "\r\n";
		$headers.='Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers.='To: Admin' . "\r\n";
		$headers.='From: PC Counter Contact Us User' . "\r\n";
		
		mail($to, $subject, $message, $headers);
		
		header("location:contactus.php?msg=successcontact");
		}
		
		else
		{
		header("location:contactus.php?msg=failedcontact");
		}
			
	}
?>