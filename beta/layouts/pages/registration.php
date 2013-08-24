
<script language="javascript" type="text/javascript">
function checkregistration()
	{
		if(document.regitrationform.register_email.value.search(/\S/) == -1)
		{
			document.getElementById("err_register_email").innerHTML="Please enter your valid Email";
			document.regitrationform.register_email.value="";
			document.regitrationform.register_email.focus();
			return false;
		}
		else
		{
			document.getElementById("err_register_email").innerHTML="";
		}
		
		var x = document.regitrationform.register_email.value;
	    var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	   
	    if (!filter.test(x))
	    { 
			document.getElementById("err_register_email").innerHTML="Please enter valid Email-ID";
			document.regitrationform.register_email.value="";
			document.regitrationform.register_email.focus();
			return false;
	    }
		else
		{
			document.getElementById("err_register_email").innerHTML="";
		}
		
		if(document.regitrationform.register_password.value.search(/\S/) == -1)
		{
			document.getElementById("err_register_password").innerHTML="Please enter your valid Password";
			document.regitrationform.register_password.value="";
			document.regitrationform.register_password.focus();
			return false;
		}
		else
		{
			document.getElementById("err_register_password").innerHTML="";
		}
		
		if(document.regitrationform.register_password.value.length < 5)
		{
			document.getElementById("err_register_password").innerHTML="Password should be minimum five character long";
			document.regitrationform.register_password.value="";
			document.regitrationform.register_password.focus();
			return false;
		}
		else
		{
			document.getElementById("err_register_password").innerHTML="";
		}
		
		if(document.regitrationform.register_confirm_password.value.search(/\S/) == -1)
		{
			document.getElementById("err_register_confirm_password").innerHTML="Please enter your Confirm Password";
			document.regitrationform.register_confirm_password.value="";
			document.regitrationform.register_confirm_password.focus();
			return false;
		}
		else
		{
			document.getElementById("err_register_confirm_password").innerHTML="";
		}
		
		if(document.regitrationform.register_password.value != document.regitrationform.register_confirm_password.value)
		{
			document.getElementById("err_register_confirm_password").innerHTML="Confirm Password should be matched with Password";
			document.regitrationform.register_confirm_password.value="";
			document.regitrationform.register_confirm_password.focus();
			return false;
		}
		else
		{
			document.getElementById("err_register_confirm_password").innerHTML="";
		}
		
		return true;
	}
</script>
<div id="maincontent">
	<div id="registration_box">
		<div class="registration_left">
			<p>
				RetailMeNot has been my go-to site for years. I won't purchase anything online without checking RetailMeNot first.
				<br /><br />
				<span>
					<strong>Deb Ragno</strong><br/> 
					South Mountain, PA
				</span>
			</p>
		</div>
		<div class="clear"></div>
		<div class="registration_bg">
			<form name="regitrationform" method="post" action="<?php echo SITE_URL; ?>?view=password" onsubmit="return checkregistration();">
			<input type="hidden" name="mode" value="register">
			  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="registration">
					<tr>
						  <td colspan="2">
							  <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
									<tr>
										  <td width="23%"><h1>Sign up</h1></td>
										  <td width="12%">&nbsp;</td>
										  <td width="37%">Already have an account?</td>
										  <td width="28%"><a href="#dialog" name="modal"><input type="button" name="Submit2" value="Login" class="signin_btn"/></a></td>
									</tr>
							  </table>
						  </td>
					</tr>
					<tr>
					  	  <td colspan="2">&nbsp;</td>
					</tr>
					<tr>
					  	  <td colspan="2" style="padding: 15px;">
						  		<?php if (!$user) { ?>
									<a href="<?php echo $loginUrl; ?>" >
										<img src="images/signup.gif" alt="" width="265" height="35" border="0" />
									</a>
								<?php } ?>
						  </td>
					</tr>
					<tr>
					 	  <td colspan="2" style="border-top: 1px solid #CCCCCC;">&nbsp;</td>
					</tr>
					<tr>
					  	  <td colspan="2">
						  		<h1>Or create a PC Counter account</h1>
						  </td>
					</tr>
					<tr>
					  	  <td colspan="2" style="padding: 15px 0 0 15px;">
						  		Email<br /><input type="text" name="register_email" class="txtfieldbg" style="margin:6px 0 0 0;"/><br />
								<span style="color:#FF0000;" id="err_register_email"></span>
						  </td>
					</tr>
					<tr>
					  	  <td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						  <td colspan="2" style="padding: 0px 0 0 15px;">
						  		Password<br/><input type="password" name="register_password" class="txtfieldbg" style="margin:6px 0 0 0;"/><br />
								<span style="color:#FF0000;" id="err_register_password"></span>
						  </td>
					</tr>
					<tr>
					  	  <td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						  <td colspan="2" style="padding: 0px 0 0 15px;">
						  		Confirm Password<br/><input type="password" name="register_confirm_password" class="txtfieldbg" style="margin:6px 0 0 0;"/><br />
								<span style="color:#FF0000;" id="err_register_confirm_password"></span>
						  </td>
					</tr>       
					<tr>
						  <td colspan="2"></td>
					</tr>
					<tr>
					  	  <td colspan="2" style="padding: 15px 0 0 15px;">
						  		<input type="submit" name="Submit3" class="create_btn" value="Create an account"/>
						  </td>
					</tr>
					<tr>
					  	  <td colspan="2" style="padding: 15px 0 0 15px;">
						  		By signing up, I agree with RetailMeNot's <a href="<?php echo SITE_URL; ?>cms.php?content_id=2">policy</a> and <a href="<?php echo SITE_URL; ?>cms.php?content_id=1">terms of use</a>
						  </td>
					</tr>
					<tr>
					  	  <td colspan="2" style="padding: 0 0 0 15px;">&nbsp;</td>
					</tr>
					<tr>
					  	  <td width="72%" style="padding: 0 0 0 15px;">&nbsp;</td>
					  	  <td width="28%" style="padding: 8px 0 0 15px;">
								<a href="<?php echo SITE_URL; ?>cms.php?content_id=26">Need Help 
									<img src="images/question_mark.gif" alt="" width="25" height="27" border="0" align="absmiddle"/>
								</a>
						  </td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>