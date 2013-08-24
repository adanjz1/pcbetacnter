<?php
	include("includes/header.php");
?>
<script language="javascript" type="text/javascript">
function checkforget()
{
	if(document.forgetform.forget_email.value.search(/\S/) == -1)
	{
		document.getElementById("err_forget_email").innerHTML="Please enter your valid Email";
		document.forgetform.forget_email.value="";
		document.forgetform.forget_email.focus();
		return false;
	}
	else
	{
		document.getElementById("err_forget_email").innerHTML="";
	}
	
	var x = document.forgetform.forget_email.value;
	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
   
	if (!filter.test(x))
	{ 
		document.getElementById("err_forget_email").innerHTML="Please enter your valid Email-ID";
		document.forgetform.forget_email.value="";
		document.forgetform.forget_email.focus();
		return false;
	}
	else
	{
		document.getElementById("err_forget_email").innerHTML="";
	}
return true;	
}
</script>
<div id="maincontent">
	<div class="forgot_box">
		<div>
			<h1>Forgot your password?</h1>
			<p>No problem! We'll email you</p>
			<p>a link to create a new one.</p>
		</div>
		<div class="clear"></div>
		<?php
			if($_REQUEST['msg'] == "success")
			{
		?>
			<div align="center" style="padding: 20px 10px 0 10px; color:#FF0000;">
				Your Password has been retrieved by the Site Admin. Please check your personal Email-ID to track it out.
			</div>
		<?php
			}
			elseif($_REQUEST['msg'] == "failed")
			{
		?>
			<div align="center" style="padding: 20px 10px 0 10px; color:#FF0000;">
				You didn't provide the right Email-ID that you used during the Registration. Without the proper Email-ID we can not track the right one hence can't help you.
			</div>
		<?php
			}
		?>
		<div class="clear"></div>
		<div>
			<form name="forgetform" method="post" action="<?php echo SITE_URL; ?>password.php" onsubmit="return checkforget();">
				<input type="hidden" name="mode" value="forgot" />
				<table width="700" align="center" border="0" cellspacing="0" cellpadding="0" style="background: #FFFFFF; height: 150px; margin: 30px auto;">
					<tr>
						<td>
							<table width="570" border="0" align="center" cellpadding="0" cellspacing="0">
								  <tr>
									   <td width="312" colspan="2" align="center">
									   		<span style="color:#FF0000;" id="err_forget_email"></span>
									   </td>
								  </tr>
								  <tr>
									   <td width="45">Email</td>
									   <td width="312">
									   		<input type="text" name="forget_email" class="txtfieldbg"/>
									   </td>
									   <td width="189">
									   		<input type="submit" name="Submit2" class="signin_btn" value="Send"/>
									   </td> 
								  </tr>
							</table>
						</td>      
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>
<?php
	include("includes/footer.php");
?>