<?php
	include("includes/header.php");
	include("timtim.php");
?>
<div id="maincontent">
	<div class="topbox">
		<div class="topbox_1">
			<?php
				if($_REQUEST['msg'] == "loginsuccess")
				{
			?>
					<div style="color:#FF0000;">You have successfully logged in into our Site.</div>
			<?php
				}
				elseif($_REQUEST['msg'] == "loginerror")
				{
			?>
					<div style="color:#FF0000;">Please provide your Login credentials correctly.</div>
			<?php
				}
				elseif($_REQUEST['msg'] == "logoutsuccess")
				{
			?>
					<div style="color:#FF0000;">You have successfully Logged Out from the Site.</div>
			<?php
				}
				elseif($_REQUEST['msg'] == "registersuccess")
				{
			?>
					<div style="color:#FF0000;">You have successfully Registered in our Site. Please check your email to find the Login Credentials.</div>
			<?php
				}
			?>
			<h1><?php echo $rowtitle['title_name']; ?></h1>
			<p><?php echo $rowtitle['title_desc']; ?></p>
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
			
			<div class="fb-like" data-href="http://www.unifiedinfotech.net/pc_counter/" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true" style="float: right; width: 81px; margin: 0 auto;"></div>
			
			<!--FACEBOOK LIKE BUTTON STOPS-->
			
			<!--GOOGLE PLUS LIKE BUTTON STARTS-->
			
			<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
			<div class="g-plusone"></div>
			
			<!--GOOGLE PLUS LIKE BUTTON STOPS-->
			
		</div>
	</div>
	
	<div class="clear"></div>
	
	<div id="content">
	
		<!--DEAL SECTION STARTS-->
		
			<div class="leftcol">
				<div class="latest_deal">
					<div class="left_top"><h1> Online Deals </h1></div>
					<div class="left_mid">
						<?php
							$items = 100;
							$page = 1;
									
							if(isset($_REQUEST['page']) and is_numeric($_REQUEST['page']) and $page = $_REQUEST['page'] and $page!=1)
							{
								$limit = " LIMIT ".(($page-1)*$items).",$items";
								$i = $items*($page-1)+1;
							}
							else
							{
								$limit = " LIMIT $items";
								$i = 1;
							}

							$sql_deal = "select * from ".TABLE_PRODUCT." where deal_coupon = 'd' and is_active = 1 and deal_price >= '5' order by discount_perc desc, title desc, deal_price desc ".$GLOBALS[sql_page]."";
							
							$sqlStrAux = "SELECT count(*) as total FROM ".TABLE_PRODUCT." where deal_coupon = 'd' and is_active = 1 and deal_price >= '5'";
							$aux = mysql_fetch_assoc(mysql_query($sqlStrAux));
							
							$res_deal = mysql_query($sql_deal.$limit);
							$num_deal = mysql_num_rows($res_deal);
							if($num_deal != 0)
							{
								if($aux['total']>0)
								{
									$p = new pagination;
									$p->Items($aux['total']);
									$p->limit($items);
									$p->target($target);
									$p->currentPage($page);
									$p->calculate();
									$p->changeClass("pagination");		
									while($row_deal = mysql_fetch_array($res_deal))
									{
										$sqldeal_sourcename = "select * from ".MANAGE_DEAL_SOURCE." where deal_source_id = ".$row_deal['deal_sources_id']."";
										$resdeal_sourcename = mysql_query($sqldeal_sourcename);
										$rowdeal_sourcename = mysql_fetch_array($resdeal_sourcename);
							?>
										<div class="pro_box">
											<div class="pro_top"></div>
											<div class="pro_mid">
												<?php
													if($row_deal['deal_type'] == "hot")
													{
												?>
													<div class="hot_deal"></div>
												<?php
													}
												?>
												<h1 style="height:43px;"><a href="<?php echo SITE_URL; ?>deal_detail.php?action=review&productid=<?php echo $row_deal['product_id']; ?>" style="color: #2B2B2B; font: bold 16px/20px Arial,Helvetica,sans-serif;	margin: 0;	padding: 0; text-transform: none; text-decoration: none;"><?php echo wrptxt(stripslashes(($row_deal['display_name'])?$row_deal['display_name']: $row_deal['title']),40); ?></a></h1>
												<div class="border_bg">
													<a href="<?php echo SITE_URL; ?>deal_detail.php?action=review&productid=<?php echo $row_deal['product_id']; ?>">
													<?php
														if($row_deal['image_url'] == '')
														{
													?>
															<img src="images/noImage.jpg" alt="" width="188" height="137" border="0"/>
													<?php
														}
														else
														{
															
													?>	
															
                                                             <img src="<?php echo $row_deal['image_url']; ?>" border="0"/> 
													<?php
															
														}
													?>	
													</a>
												</div>
												<ul>
													<li><span>From <?php echo stripslashes($rowdeal_sourcename['deal_source_name']); ?></span></li>
													<?php if($row_deal['actual_price'] != '0.00') { ?>
														<li>List Price: <strong>$<?php echo $row_deal['actual_price']; ?></strong></li>
													<?php } ?>
													<li>Price: <span class="redtext">$<?php echo $row_deal['deal_price']; ?></span> <strong>+ FREE SHIPPING</strong></li>
													
													<?php if($row_deal['discount_perc'] != '0.00') { ?>	
													<li>												
														You Save: <span class="redtext"><?php echo $row_deal['discount_perc']."%"; ?></span>
													</li>
													<?php } ?>	
													
													<?php /*?><li style="text-align: center; padding-bottom:6px;">
														<?php
															$url='http://unifiedinfotech.net/pc_counter/deal_detail.php?action=view&productid='.$row_deal['product_id'];
															$a=urlencode(strip_tags($url));
															$desc=urlencode(strip_tags($row_deal['description']));
														?>
															<a target="_blank" href="http://www.facebook.com/dialog/feed?app_id=158698274267858&link=<?php echo $a;?>&picture=<?php echo $row_deal['image_url'];?>&name=<?php echo $row_deal['title'];?>&description=<?php echo $row_deal['description'];?>&redirect_uri=<?php echo SITE_URL; ?>deal_detail.php?action=review&productid=<?php echo $row_deal['product_id']; ?>"><img src="images/fb_share.png" alt="" width="165" height="25" border="0"/>	</a>
															<script src='http://connect.facebook.net/en_US/all.js'></script>
															<!--<img src="images/comm_bg.gif" alt="" width="139" height="32" border="0"/>-->
													</li><?php */?>
													<li>
															<span style="font:bold 12px/16px Arial, Helvetica, sans-serif; color: #515151; padding: 0 5px 0 0;">Share :</span>
				
															<!--TWITTER SHARE STARTS-->
				
															<span id="custom-tweet-button">
																<a href="javascript: void(0);"  data-via="unifiedinfotech"  data-count="none" onclick="window.open('https://twitter.com/share?url=<?php echo SITE_URL; ?>deal_detail.php?productid=<?php echo $row_deal['product_id']?>&action=review','Twitter','width=500,height=500');"><img src="images/twitter.gif" alt="" width="16" height="16" border="0" align="top"/></a>
															</span>
															<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				
				
															<?php /*?> <a href="#"><img src="images/twitter.gif" alt="" width="16" height="16" border="0" align="top"/></a>
				
															<a href="http://twitter.com/share" class="twitter-share-button"	style="width:27px; height:27px;" data-url="http://www.unifiedinfotech.net/pc_counter/deal_detail.php?action=review&productid=<?php echo $row_deal['product_id']?>&action=twitter" data-text="Please Tweet Here." data-count="none"><img src="images/twitter.gif" alt="" width="16" height="16" border="0" align="top"/></a>
															<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
															<script type="text/javascript">
															   twttr.events.bind('tweet', function(event) {
																	 //alert("Lottery Entry Successful");
																	 window.location = "<?php echo SITE_URL; ?>deal_detail.php?action=review&productid=<?php echo $row_deal['product_id']; ?>"
																  });
															</script><?php */?>
				
															<!--TWITTER SHARE ENDS-->
				
															<!--FACEBOOK SHARE STARTS-->
				
															<?php
																$url='http://unifiedinfotech.net/pc_counter/deal_detail.php?action=view&productid='.$row_deal['product_id'];
																$a=urlencode(strip_tags($url));
																$desc=urlencode(strip_tags($row_deal['description']));
															?>
																<a target="_blank" href="http://www.facebook.com/dialog/feed?app_id=158698274267858&link=<?php echo $a;?>&picture=<?php echo $row_deal['image_url'];?>&name=<?php echo  str_replace('"',"'", $row_deal['title']);?>&description=<?php echo str_replace('"',"'",$row_deal['description']);?>&redirect_uri=<?php echo SITE_URL; ?>deal_detail.php?productid=<?php echo $row_deal['product_id']; ?>&action=review"><img src="images/facebook.gif" alt="" width="16" height="16" border="0" align="top"/></a>
																<script src='http://connect.facebook.net/en_US/all.js'></script>
				
															<!--FACEBOOK SHARE ENDS-->
				
															<!--GOOGLE PLUS SHARE STARTS-->
				
																<!-- <a href="#"><img src="images/g1+.gif" alt="" width="16" height="16" border="0" align="top"/></a> -->
				
																<a href="javascript: void(0);" onclick="popUp=window.open('https://plus.google.com/share?url=<?php echo SITE_URL; ?>deal_detail.php?productid=<?php echo $row_deal['product_id']?>&action=review', 'popupwindow', 'scrollbars=yes,width=800,height=400');popUp.focus();return false">
																	<img src="images/g1+.gif" alt="Google+" title="Google+"/>
																</a>
				
																<?php /*?><!-- Place this tag where you want the share button to render. -->
																<div class="g-plus" data-action="share" data-annotation="none">
																	<img src="images/g1+.gif" alt="" width="16" height="16" border="0" align="top"/>
																</div>
				
																<!-- Place this tag after the last share tag. -->
																<script type="text/javascript">
																  (function() {
																	var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
																	po.src = 'https://apis.google.com/js/plusone.js';
																	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
																  })();
																</script><?php */?>
				
															<!--GOOGLE PLUS SHARE ENDS-->
															
															<!--PINTEREST SHARE STARTS-->
															
															<a href="http://pinterest.com/pin/create/button/?url=<?php echo SITE_URL; ?>deal_detail.php?action=review&productid=<?php echo $row_deal['product_id']?>&media=<?php echo SITE_URL; ?>deal_detail.php?productid=<?php echo $row_deal['product_id']?>&action=review" target="_blank">
																<img src="images/pinterest.gif" alt="Pinterest" title="Pinterest"/>
															</a>
															<!--PINTEREST SHARE ENDS-->
				
															<!--FACEBOOK LIKE STARTS-->
				
																<?php /*?><a href="#"><img src="images/likeface.gif" alt="" width="44" height="20" border="0" align="top"/></a>
																<a href="#"><img src="images/zero.gif" alt="" width="26" height="20" border="0" align="top"/></a>
				
																<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#appId=158698274267858&amp;xfbml=1"></script>
																<div id="fblikeblock"></div>
																<script>
																	var url = "http://apps.facebook.com/inflatableicons/image_preview.html?productid=<?php echo $row_deal['product_id']; ?>";
																	jQuery("#fblikeblock").html('<fb:like id="fbLike" href="'+url+'" send="true" width="450" show_faces="true" font=""></fb:like>');
																	FB.XFBML.parse(document.getElementById('fblikeblock'));
																	console.log(document.getElementById('fblikeblock'));
																  </script><?php */?>
				
				
															<!--FACEBOOK LIKE ENDS-->
															
													</li>
													<li>
														<img src="images/spacer.gif" alt="" width="1" height="20" border="0"/>
													</li>
												</ul>
											</div>
											<div><a class="hot_dealbtn2" href="<?php echo $row_deal['deal_url']; ?>" onclick="window.open('<?php echo SITE_URL; ?>offerid.php?action=review&productid=<?php echo $row_deal['product_id']; ?>','popup','width=560,height=700,scrollbars=no,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0');" target="_blank">Get Deal</a></div>
											<div class="pro_bot"></div>
										</div>
						<?php
									}
						?>
									<style>
										.pagination{
											width: 100%;
											height: auto;
										}
										.pagination a{
											font: normal 12px/26px Arial, Helvetica, sans-serif;
											background: #f0f0f0;
											padding: 0 6px;
											color: #333;
											float: left;
											margin-right:2px;
										}
										.pagination a:hover, .pagination span.disabled:hover, .pagination a.next:hover{
											background: #333;
											color: #fff;
											text-decoration: none;
										}
										.pagination span.disabled{
											font: normal 12px/26px Arial, Helvetica, sans-serif;
											background: #f0f0f0;
											padding: 0 6px;
											float: left;
											margin-right:2px;
										}
										.pagination a.next{
											font: normal 12px/26px Arial, Helvetica, sans-serif;
											background: #f0f0f0;
											padding: 0 6px;
											float: right;
											margin-right:12px;
										}
										.pagination span.current{
											font: normal 12px/26px Arial, Helvetica, sans-serif;
											background: #333;
											padding: 0 6px;
											color: #fff;
											float: left;
											margin-right:2px;
										}
									</style>
									<div class="clear"></div>
									<div style="float:right; margin: 0 0 15px 0;"><?php $p->show();?></div>
						<?php
								}
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
			</div>
		
		<!--DEAL SECTION ENDS-->
		
		<?php
			include("includes/rightcol.php");
		?>
		
	</div>
	
</div>
<?php
	include("includes/footer.php");
?>