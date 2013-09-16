<div class="leftcol">
    <div class="registration_bg">
			<? echo form_open(current_url()); ?>
			<input type="hidden" name="mode" value="register">
			  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="registration">
					<tbody><tr>
						  <td colspan="2">
							  <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
									<tbody><tr>
										  <td width="23%"><h1>Sign up</h1></td>
										  <td width="12%">&nbsp;</td>
										  <td width="37%">Already have an account?</td>
										  <td width="28%"><a href="#dialog" name="modal"><input type="button" name="Submit2" value="Login" class="signin_btn"></a></td>
									</tr>
							  </tbody></table>
						  </td>
					</tr>
					<tr>
					  	  <td colspan="2">&nbsp;</td>
					</tr>
					<tr>
					  	  <td colspan="2" style="padding: 15px;">
						  				<?php foreach ($this->config->item('third_party_auth_providers') as $provider) : ?>
                                                      <div class="third_party <?php echo $provider; ?>" style='float: left;'><?php echo anchor('account/connect_'.$provider, ' ', array('title' => sprintf(lang('sign_in_with'), lang('connect_'.$provider)))); ?></div>
                            <?php endforeach; ?>
                                    <fb:login-button style='float: left;margin-top: 10px'></fb:login-button>
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
						  		Email<br><input type="text" name="register_email" class="txtfieldbg" style="margin:6px 0 0 0;"><br>
								<span style="color:#FF0000;" id="err_register_email"></span>
						  </td>
					</tr>
					<tr>
					  	  <td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						  <td colspan="2" style="padding: 0px 0 0 15px;">
						  		Password<br><input type="password" name="register_password" class="txtfieldbg" style="margin:6px 0 0 0;"><br>
								<span style="color:#FF0000;" id="err_register_password"></span>
						  </td>
					</tr>
					<tr>
					  	  <td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						  <td colspan="2" style="padding: 0px 0 0 15px;">
						  		Confirm Password<br><input type="password" name="register_confirm_password" class="txtfieldbg" style="margin:6px 0 0 0;"><br>
								<span style="color:#FF0000;" id="err_register_confirm_password"></span>
						  </td>
					</tr>       
					<tr>
						  <td colspan="2"></td>
					</tr>
					<tr>
					  	  <td colspan="2" style="padding: 15px 0 0 15px;">
						  		<input type="submit" name="Submit3" class="create_btn" value="Create an account">
						  </td>
					</tr>
					<tr>
					  	  <td colspan="2" style="padding: 15px 0 0 15px;">
						  		By signing up, I agree with Pccounter's <a href="http://www.pccounter.net/cms.php?content_id=2">policy</a> and <a href="http://www.pccounter.net/cms.php?content_id=1">terms of use</a>
						  </td>
					</tr>
					<tr>
					  	  <td colspan="2" style="padding: 0 0 0 15px;">&nbsp;</td>
					</tr>
					<tr>
					  	  <td width="72%" style="padding: 0 0 0 15px;">&nbsp;</td>
					  	  <td width="28%" style="padding: 8px 0 0 15px;">
                                                        <a href="http://www.pccounter.net/cms.php?content_id=26">Need Help 
                                                                <img src="images/question_mark.gif" alt="" width="25" height="27" border="0" align="absmiddle">
                                                        </a>
						  </td>
					</tr>
				</tbody></table>
			 <?
                                echo form_close();
                        ?>
		</div>
</div>
