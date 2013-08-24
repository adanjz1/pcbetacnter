</div>
		<div class="clear"></div>
		<div id="footer_bg">
			<div class="footer">
				<div class="footer_link" style="width: 325px;">
						  <h1>BROWSE THE LATEST SAVINGS</h1>          
						  <ul>
							<li><a href="<?php echo SITE_URL; ?>coupon.php">Coupon Codes</a></li>  
							<li><a href="<?php echo SITE_URL; ?>deal.php">Deals & Clearance</a></li>  
							<li><a href="<?php echo SITE_URL; ?>cms.php?content_id=18">Local Offers</a></li>  
							<li><a href="<?php echo SITE_URL; ?>cms.php?content_id=19">Grocery Coupons</a></li>  
							<li><a href="<?php echo SITE_URL; ?>cms.php?content_id=20">Free Offers</a></li>
							<li><a href="<?php echo SITE_URL; ?>cms.php?content_id=21">Travel</a></li>
							<li><a href="<?php echo SITE_URL; ?>cms.php?content_id=22">Computers</a></li>
							<li><a href="<?php echo SITE_URL; ?>cms.php?content_id=23">Software</a></li>
							<li><a href="<?php echo SITE_URL; ?>cms.php?content_id=24">Home & Kitchen</a></li>
							<li><a href="<?php echo SITE_URL; ?>cms.php?content_id=25">Credit Cards</a></li>   		     
						  </ul>
				</div>
				<div class="footer_link" style="width: 220px;padding-left: 20px;">
						  <h1>GET STARTED</h1>          
						  <ul>
								<li><a href="<?php echo SITE_URL; ?>category.php">Categories</a></li>
								<li><a href="<?php echo SITE_URL; ?>store_brand.php">Brands</a></li>
								<li><a href="<?php echo SITE_URL; ?>store_brand.php">Stores</a></li>
								<li><a href="<?php echo SITE_URL; ?>cms.php?content_id=9">Savings Guides</a></li>
								<li><a href="<?php echo SITE_URL; ?>/blog/">Blog</a></li>			
						  </ul>
				</div>
				<div class="footer_link1">
						  <h1>HOLIDAY & LIFESTYLE SAVINGS</h1>          
						  <ul>
							  <li><a href="#">Labor Day 2012 Deals, Sales and Coupons</a></li>	
							  <li><a href="#">Halloween 2012 Coupons, Sales, and Deals</a></li>	
							  <li><a href="#">Black Friday 2012 Deals and Sales</a></li>	
							  <li><a href="#">Cyber Monday 2012 Deals and Sales</a></li>
						  </ul>
				</div>
				<div class="footer_link2">                  
						  <ul>
							  <li><a href="#">Small Business</a></li>
							  <li><a href="#">Vacation Planning</a></li>
							  <li><a href="#">Weddings</a></li>
							 <li><a href="#">Spring Cleaning</a></li>		
						  </ul>
				</div>					
				<div class="clear"></div>
				<div class="footer_brands">			
						   <h1>TOP STORES & BRANDS</h1>          
						   <ul>
						   	  <?php
							  	$sql_store_brand = "select * from ".MANAGE_DEAL_SOURCE." where is_active = 1 order by deal_source_id asc limit 0, 12";
								$res_store_brand = mysql_query($sql_store_brand);
								while($row_store_brand = mysql_fetch_array($res_store_brand))
								{
							  ?>
									  <li><a href="<?php echo SITE_URL; ?>deal_store_category.php?brand=<?php echo $row_store_brand['deal_source_id']; ?>"><?php echo stripslashes($row_store_brand['deal_source_name']); ?></a></li>	
							  <?php
							  	 }
							  ?>	
						  </ul>
			    </div>
				<div class="clear"></div>
			    <div class="footer2">
				  <div class="footer_left">
						  &copy; Copyright 2012 <a href="#">pccounter.net</a>  |   
						  <!--<span><a href="<?php echo SITE_URL; ?>cms.php?content_id=1">Terms of Use</a></span>  |  
						  <span><a href="<?php echo SITE_URL; ?>cms.php?content_id=2">Privacy Policy</a></span>  |  
						  <a href="<?php echo SITE_URL; ?>cms.php?content_id=3">Partner</a>  |  
						  <a href="<?php echo SITE_URL; ?>cms.php?content_id=4">Careers</a>  |  
						  <a href="<?php echo SITE_URL; ?>contactus.php">Contact Us</a>  |  
						  <a href="<?php echo SITE_URL; ?>cms.php?content_id=10">Site Map</a>-->
						  <a href="<?php echo SITE_URL; ?>contactus.php">Contact Us</a>  |  
						  <?php
						  	$sqlfooter = "select * from pc_counter_manage_content where is_active = 1 and content_id != 12 and content_id != 13 and content_id != 13 and content_id != 14 and content_id != 15 and content_id != 16 and content_id != 17";
							$resfooter = mysql_query($sqlfooter);
							while($rowfooter = mysql_fetch_array($resfooter))
							{
						  ?>
						  		<a href="<?php echo SITE_URL; ?>cms.php?content_id=<?php echo $rowfooter['content_id']; ?>"><?php echo $rowfooter['content_name']; ?></a>  |  
						  <?php
						  	}
						  ?>
                          <a href="<?php echo SITE_URL; ?>sitemap.php">Site Map</a>
				  </div>
				  <div class="footer_right">Follow us: <a href="http://www.facebook.com/PcCounterProducts" target="_blank"><img src="images/facebook1.png" alt="" width="35" height="37" border="0" align="absmiddle"/></a> <a href="#" target="_blank"><img src="images/twitter.png" alt="" width="36" height="37" border="0" align="absmiddle"/></a> <a href="<?php echo SITE_URL; ?>rss.php" target="_blank"><img src="images/rss.png" alt="" width="35" height="37" border="0" align="absmiddle"/></a>
				  </div>
			    </div>		
				</div>
		         </div>
		  
		   
		   <!--POPPING UP OF LOGIN FORM STARTS HERE-->
		   
		   <div id="boxes" align="center">
				<div id="dialog" class="window">
				   <div>
					<a href="#" style="position:absolute; margin: -12px 0 0 198px; width:19px; height:19px;" class="close">
						<img src="images/modal-close.png" alt="" width="19" height="19" border="0" align="absmiddle"/>
					</a>
					</div>
				  <div style="clear:both; height:10px; line-height:0px;"></div>
				  
					<div class="d-header" align="center">	
							
						<!-- Start of Login Form --> 
						
							<form name="loginform" method="post" action="<?php echo SITE_URL; ?>password.php" onsubmit="return checklogin()">
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
												<?php 
													if (!$user) 
													{ 
												?>
													<a href="<?php echo $loginUrl; ?>" >
														<img src="images/fblogin.png" alt="" width="261" height="58" border="0" align="absmiddle"/>
													</a>
												<?php
													}
												?>
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
														<td>Password (<a href="<?php echo SITE_URL;?>forgetpassword.php">forgot password</a>)</td>
													</tr>
													<tr>
														<td>
															<input type="password" name="login_password" class="txtfieldbg"/><br />
															<span style="color:#FF0000;" id="err_login_password"></span>
														</td>
													</tr>
													<tr>
														<td>
															<table width="300" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	  <!--<td width="7%"><input type="checkbox" name="checkbox" value="checkbox" style="padding:0; margin: 0;"/></td>
																	  <td width="43%">remember me</td>-->
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
														<td>New to pccounter.net? <a href="<?php echo SITE_URL;?>registration.php">Sign up here</a></td>
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
		   
		  <script type="text/javascript">
				var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
		  </script> 
		  
	</body>
</html>