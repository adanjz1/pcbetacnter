<?php
include("includes/header.php");
$time_start = microtime(true);
//include("timtim.php"); //Library to resize files, WHY IN HOMEPAGE?
?>

<div id="maincontent">
	<div class="topbox">
		<div class="topbox_1">
			<?php
                            switch($_REQUEST['msg']){
                                case "loginsuccess":
                                    ?><div style="color:#FF0000;">You have successfully logged in into our Site.</div><?
                                break;
                                case "loginerror":
                                    ?><div style="color:#FF0000;">Please provide your Login credentials correctly.</div><?
                                break;
                                case "logoutsuccess":
                                    ?><div style="color:#FF0000;">You have successfully Logged Out from the Site.</div><?
                                break;
                                case "registersuccess":
                                    ?><div style="color:#FF0000;">You have successfully Registered in our Site. Please check your email to find the Login Credentials.</div><?
                                break;
                                case "cantview":
                                    ?><div style="color:#FF0000;">You can't view this page as you are not a Registered user.</div><?
                                break;
                                case "cannotrate":
                                    ?><div style="color:#FF0000;">You can't RATE as you are not a Registered user.</div><?
                                break;
                            }
                            ?>
			<h1><?php echo $rowtitle['title_name']; ?></h1>
			<p><?php echo $rowtitle['title_desc']; ?></p>
		</div>
        
		<div class="topbox_r">

			<div id="fb-root" style="float:left;  width: 60px; margin: 0 auto 0 40px;"></div>

			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
            </script>
             
			<div class="fb-like" data-href="http://www.unifiedinfotech.net/pc_counter/" data-send="false" data-layout="button_count" data-width="100" data-show-faces="true" style="float: right; width: 81px;"></div>

			

			<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>

			<div class="g-plusone"></div>
		</div>
        
	</div>
	<div class="clear"></div>
	<div id="content">
		<div class="leftcol">
			<div class="latest_deal">
				<div class="left_top"><h1>Latest Online Deals </h1></div>
				<div class="left_mid">
					<?php
                                            $deals = $db->getLastOnlineDeals();
                                            	if(count($deals) > 0){
                                                            foreach($deals as $row_deal){
                                                                
                                                                $rowdeal_sourcename = $db->dealSourceName($row_deal['deal_sources_id']);
                						?>
									<div class="pro_box">
										<div class="pro_mid">
											<?php
											
												if($row_deal['deal_type'] == "hot")
												{
											?>
												<div class="hot_deal"></div>
											<?php
												}
											?>
											<h1><a href="<?php echo SITE_URL; ?>deal_detail.php?action=review&productid=<?php echo $row_deal['product_id']; ?>" ><?php echo wrptxt(stripslashes(($row_deal['display_name'])?$row_deal['display_name']: $row_deal['title']),40); ?></a></h1>
											<div class="border_bg"><a href="<?php echo SITE_URL; ?>deal_detail.php?action=review&productid=<?php echo $row_deal['product_id']; ?>"><?php

													if($row_deal['image_url'] != '' )  //&& extImgCheck($row_deal['image_url'])
													{
														
												?><img src="<?php echo $row_deal['image_url']; ?>" alt="<?php echo $row_deal['title'] ?>"  border="0"/><?php
														
													}
													else
													{
												?><img src="images/noImage.jpg" alt="" width="188" height="137" class="border" border="0"/><?php
													}
												?></a>
											</div>
											<ul>
												<li><span>From <?php echo stripslashes($rowdeal_sourcename['deal_source_name']); ?></span></li>
												<?php if($row_deal['actual_price'] != '0.00') { ?>
													<li style="display:none">List Price: <strong>$<?php echo $row_deal['actual_price']; ?></strong></li>
												<?php } ?>
												<li class="price">Price: <span class="redtext">$<?php echo $row_deal['deal_price']; ?></span> <strong>+ FREE SHIPPING</strong></li>
												
												<li>
														<span style="font:bold 12px/16px Arial, Helvetica, sans-serif; color: #515151; padding: 0 5px 0 0;">Share :</span>
			
														<!--TWITTER SHARE STARTS-->
			
														<span id="custom-tweet-button">
															<a href="javascript: void(0);"  data-via="unifiedinfotech"  data-count="none" onclick="window.open('https://twitter.com/share?url=<?php echo SITE_URL; ?>deal_detail.php?action=review&productid=<?php echo $row_deal['product_id']?>','Twitter','width=500,height=500');"><img src="images/twitter.gif" alt="" width="16" height="16" border="0" align="top"/></a>
														</span>
														<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			
			
													
			
														<!--TWITTER SHARE ENDS-->
			
														<!--FACEBOOK SHARE STARTS-->
			
														<?php
															$url='http://unifiedinfotech.net/pc_counter/deal_detail.php?action=view&productid='.$row_deal['product_id'];
															$a=urlencode(strip_tags($url));
															$desc=urlencode(strip_tags($row_deal['description']));
														?>
															<a target="_blank" href="http://www.facebook.com/dialog/feed?app_id=158698274267858&link=<?php echo $a;?>&picture=<?php echo $row_deal['image_url'];?>&name=<?php echo $row_deal['title'];?>&description=<?php echo $row_deal['description'];?>&redirect_uri=<?php echo SITE_URL; ?>deal_detail.php?productid=<?php echo $row_deal['product_id']; ?>&action=review"><img src="images/facebook.gif" alt="" width="16" height="16" border="0" align="top"/></a>
															<script src='http://connect.facebook.net/en_US/all.js'></script>
			
														<!--FACEBOOK SHARE ENDS-->
			
														<!--GOOGLE PLUS SHARE STARTS-->
			
															
			
															<a href="javascript: void(0);" onclick="popUp=window.open('https://plus.google.com/share?url=<?php echo SITE_URL; ?>deal_detail.php?productid=<?php echo $row_deal['product_id']?>&action=review', 'popupwindow', 'scrollbars=yes,width=800,height=400');popUp.focus();return false">
																<img src="images/g1+.gif" alt="Google+" title="Google+"/>
															</a>
			
															
			
														<!--GOOGLE PLUS SHARE ENDS-->
														
														<!--PINTEREST SHARE STARTS-->
														
														<a href="http://pinterest.com/pin/create/button/?url=<?php echo SITE_URL; ?>deal_detail.php?action=review&productid=<?php echo $row_deal['product_id']?>&media=<?php echo SITE_URL; ?>deal_detail.php?action=review&productid=<?php echo $row_deal['product_id']?>" target="_blank">
															<img src="images/pinterest.gif" alt="Pinterest" title="Pinterest"/>
														</a>
														<!--PINTEREST SHARE ENDS-->
			
														
												</li>
												<li>
													<img src="images/spacer.gif" alt="" width="1" height="20" border="0"/>
												</li>
											</ul>
										</div>
										<div><a class="hot_dealbtn2" href="<?php echo $row_deal['deal_url']; ?>" onclick="window.open('<?php echo SITE_URL; ?>offerid.php?action=review&productid=<?php echo $row_deal['product_id']; ?>','popup','width=560,height=700,scrollbars=no,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0');" target="_blank">Get Deal</a></div>
										
									</div>
						<?php
								}
						?>
								<div class="clear"></div>
						<?php
							}
							else
							{
					?>
								<div class="pro_box">
									<span style="color:#FF0000;"><?php echo "NO DEALS ARE THERE."; ?></span>
								</div>
					<?php
							}
					?>
				</div>
				<div class="left_bot"></div>
			</div>
			<div class="clear"></div>
			<div class="latest_deal">
				<div class="left_top">
					<h1>Newest Online Coupons</h1>
				</div>
				<div class="left_mid">
					<?php
                                            $coupons = $db->getNewestOnlineCoupons();
						
						if(count($coupons) > 0){
							foreach($row_coupon as $coupons){
                                                                $rowdeal_sourcename = $db->dealSourceName($row_coupon['deal_sources_id']);
								?>
								<div class="coupon_box">
									<div class="coupon" style="margin: 10px auto 0 6px;">
										<?php
											
											if($row_coupon['image_url'] != '' )  //&& extImgCheck($row_coupon['image_url'])
											{
												
										?>
											<img src="<?php echo $row_coupon['image_url']; ?>" alt="" width="162" height="77" border="0" class="border"/>
									
									<?php
											}
											else
											{
										?>
											<img src="images/noImage.jpg" alt="" width="162" height="77" class="border" border="0"/>
										<?php
											}
										?>
									</div>
									<div class="coupon" style="width: 184px; padding: 0 0 0 19px;">
										<ul>
											<li><h1><?php echo stripslashes($row_coupon['title']); ?></h1></li>
											<li><span>From: <?php echo stripslashes($rowcoupon_sourcename['deal_source_name']); ?></span></li>
										</ul>
									</div>
									<div class="coupon" style="width: 230px;">
										<ul>
											<?php if($row_coupon['actual_price'] != '0.00') { ?>
												<li>List Price: <strong>$<?php echo $row_coupon['actual_price']; ?></strong></li>
											<?php } ?>
											<li>Price: <span class="redtext">$<?php echo $row_coupon['deal_price']; ?></span> <strong>+ FREE SHIPPING</strong></li>
											<?php
												$savings = ($row_coupon['actual_price'] - $row_coupon['deal_price']);
												$savingspercentage = (($savings * 100) / $row_coupon['actual_price']);
											?>
											<li>You Save: <span class="redtext">(<?php echo round($savingspercentage,2); ?>%)</span></li>
										</ul>
									</div>
									<div class="coupon" style="border:0; width: 160px;">
                                    
										
                                        
										  <div class="buy">
												<div class="pricing-container"></div>
												<div class="button-outer code" data-href="<?php echo $row_coupon['deal_url']; ?>">
												   <a target="_blank" onclick="window.open('<?php echo SITE_URL; ?>offerid.php?action=review&productid=<?php echo $row_coupon['product_id']; ?>','popup','width=560,height=700,scrollbars=no,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0');">
														<div class="button code">
															<div class="coupon-code">
																<?php 
																	if($row_coupon['sku'] == "") 
																	{ 
																		echo "FREE"; 
																	} 
																	else 
																	{ 
																		echo substr($row_coupon['sku'], -2); 
																	} 
																?>
															</div>
														 	<div style="width: 93px;" class="button-inner code">Reveal Code</div>
														 	<div style="left: 95px;" class="peelie">&nbsp;</div>
														</div>
												   </a>
												</div>
										  </div>
                                        
									</div>
								</div>
					<?php
							}
						}
						else
						{
					?>
								<div class="coupon_box">
									<span style="color:#FF0000; padding: 0 0 0 320px;"><?php echo "NO COUPONS ARE THERE."; ?></span>
								</div>
					<?php
						}
					?>
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