</div>
</div>
		<div class="clear"></div>
</div>
		<div id="footer_bg">
			<div class="footer">
				<div class="footer_link" style="width: 325px;">
						  <h1>BROWSE THE LATEST SAVINGS</h1>          
						  <ul>
							<li><a href="{couponsUrl}">Coupon Codes</a></li>  
							<li><a href="{dealsUrl}">Deals & Clearance</a></li>	     
						  </ul>
				</div>
				<div class="footer_link" style="width: 220px;padding-left: 20px;">
						  <h1>GET STARTED</h1>          
						  <ul>
								<li><a href="{categoriesUrl}">Categories</a></li>
								<li><a href="{storesUrl}">Stores</a></li>
								<li><a href="{blogUrl}">Blog</a></li>			
						  </ul>
				</div>
				<div class="footer_link1">
                                        <h1>HOLIDAY & LIFESTYLE SAVINGS</h1>          
                                        <ul>
                                            {specialPages_1}
                                              <li><a href="{specialPageUrl}">{name}</a></li>	
                                            {/specialPages_1}

                                        </ul>
				</div>
				<div class="footer_link2">                  
                                    <ul>
                                        {specialPages_2}
                                          <li><a href="{specialPageUrl}">{name}</a></li>	
                                        {/specialPages_2}
                                    </ul>
				</div>					
				<div class="clear"></div>
				<div class="footer_brands">			
                                    <h1>TOP STORES & BRANDS</h1>          
                                    <ul>
                                        {dealSources}
                                             <li><a href={deal_source_url}">{deal_source_name}</a></li>	
                                        {/dealSources}
                                   </ul>
			    </div>
				<div class="clear"></div>
			    <div class="footer2">
				  <div class="footer_left">
						  &copy; Copyright 2012 <a href="#">pccounter.net</a>  |   
						  <a href="{contactUrl}">Contact Us</a>  |  
						  {staticPages}
                                                        <a href="{url}">{name}</a>  |  
                                                  {/staticPages}
                                                  <a href="{mapUrl}">Site Map</a>
				  </div>
				  <div class="footer_right">Follow us: <a href="http://www.facebook.com/PcCounterProducts" target="_blank"><img src="http://pccounter.net/media/images/facebook1.png" alt="" width="35" height="37" border="0" align="absmiddle"/></a> <a href="#" target="_blank"><img src="http://pccounter.net/cidia/images/twitter.png" alt="" width="36" height="37" border="0" align="absmiddle"/></a> <a href="{rssUrl}" target="_blank"><img src="http://pccounter.net/ci/me/images/rss.png" alt="" width="35" height="37" border="0" align="absmiddle"/></a>
				  </div>
			    </div>		
				</div>
		         </div>
		  
		   
		   <!--POPPING UP OF LOGIN FORM STARTS HERE-->
		   
		   <div id="boxes" align="center">
				<div id="dialog" class="window">
				   <div>
					<a href="#" style="position:absolute; margin: -12px 0 0 198px; width:19px; height:19px;" class="close">
						<img src="http://pccounter.net/media/images/modal-close.png" alt="" width="19" height="19" border="0" align="absmiddle"/>
					</a>
					</div>
				  <div style="clear:both; height:10px; line-height:0px;"></div>
				  
					<div class="d-header" align="center">	
							
						<!-- Start of Login Form --> 
						
							<form name="loginform" method="post" action="{loginUrl}" onsubmit="return checklogin()">
							<input type="hidden" name="mode" value="login" />
								<table width="100%" border="0" cellspacing="0" cellpadding="0" class="dialogbox">
									  <tr>
											<td bgcolor="#fefefe" ><h1>Welcome Back</h1></td>
									  </tr>
									  <tr>
											<td bgcolor="#fefefe" style="text-align:center;">Find the best offers from people like you.</td>
									  </tr>
									  <tr>
											<td bgcolor="#fefefe" style="text-align:center;">
											{userFBLogin}	
                                                                                            
											</td>				
									  </tr>
									  <tr>
											<td style="border-top: 1px solid #CCCCCC;">&nbsp;</td>
									  </tr>
									  <tr>
											<td>
												<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="dialogbox">
													<tr>
														<td>E-mail Address</td>
													</tr>
													<tr>
														<td>
															<input type="text" name="login_email" class="txtfieldbg"/><br />
															<span style="color:#FF0000;" id="err_login_email"></span>
														</td>
													</tr>
													<tr>
														<td>Password (<a href="{forgotPassword}">forgot password</a>)</td>
													</tr>
													<tr>
														<td>
															<input type="passw}ord" name="login_password" class="txtfieldbg"/><br />
															<span style="color:#FF0000;" id="err_login_password"></span>
														</td>
													</tr>
													<tr>
														<td>
															<table width="300" border="0" cellspacing="0" cellpadding="0">
																<tr>
																
																	  <td width="24%">&nbsp;</td>
																	  <td width="26%"><input type="submit" name="Submit" class="signin_btn" value="Sign in"/>
																		</label>
																	  </form>
																	  </td>
																</tr>
															</table>
														</td>
													</tr>
													<tr>
														<td>New to pccounter.net? <a href="{registerUrl}">Sign up here</a></td>
													</tr>
												  </table>
											</td>
									  </tr>
								</table>
							</form>
							
						<!-- End of Login Form -->
						
					</div>
				</div>
				<div id="mask"></div>
		   </div>
		   
		   <!--POPPING UP OF LOGIN FORM STOPS HERE-->
		   
<!--		  <script type="text/javascript">
				var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
		  </script> -->
		  
	</body>
</html>