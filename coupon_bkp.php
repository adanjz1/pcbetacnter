<?php
	include("includes/header.php");
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
			<h1>Coupon Codes, Sales and Deals - Verified Daily</h1>
			<p>We publish the top product deals and online coupons every day so you get the biggest savings. PCCounter.net - our  work.</p>
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
		<div class="leftcol">
			<div class="latest_deal">
				<div class="left_top">
					<h1>Online Coupons</h1>
				</div>
				<div class="left_mid">
					<?php
						$items = 9;
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

						$sql_coupon = "select * from ".TABLE_PRODUCT." where deal_coupon = 'c' and is_active = 1 order by product_id desc ".$GLOBALS[sql_page]."";
						
						$sqlStrAux = "SELECT count(*) as total FROM ".TABLE_PRODUCT." where deal_coupon = 'c' and is_active = 1";
						$aux = mysql_fetch_assoc(mysql_query($sqlStrAux));
						
						$res_coupon = mysql_query($sql_coupon.$limit);
						$num_coupon = mysql_num_rows($res_coupon);
						if($num_coupon != 0)
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
								while($row_coupon = mysql_fetch_array($res_coupon))
								{
									$sqlcoupon_sourcename = "select * from ".MANAGE_DEAL_SOURCE." where deal_source_id = ".$row_coupon['deal_sources_id']."";
									$rescoupon_sourcename = mysql_query($sqlcoupon_sourcename);
									$rowcoupon_sourcename = mysql_fetch_array($rescoupon_sourcename);
					?>
									<div class="coupon_box">
										<div class="coupon" style="margin: 10px auto 0 6px;">
											<?php
											if($row_coupon['image_url'] != '')
											{
											?>
												<img src="<?php echo $row_coupon['image_url']; ?>" alt="" width="162" height="77" border="0" class="border"/>
											<?php
												}
												else
												{
											?>
												<img src="images/noImage.jpg" alt="" width="188" height="137" class="border" border="0"/>
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
                                    
										<?php /*?><div class="hot_dealbtn3"><a href="<?php echo $row_coupon['deal_url']; ?>" onclick="window.open('<?php echo SITE_URL; ?>offerid.php?action=review&productid=<?php echo $row_coupon['product_id']; ?>','popup','width=560,height=700,scrollbars=no,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0');" target="_blank">Reveal Code</a> <span><?php echo substr($row_coupon['sku'], -2); ?></span></div><?php */?>
                                        
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
								
									<div style="float:right; margin: 0 0 15px 0;"><?php $p->show();?></div>
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