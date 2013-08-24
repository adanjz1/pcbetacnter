<?php
	include("includes/header.php");
?>
<?php
	$seller = $_REQUEST['seller'];
	$sel_feedbk = "select productid,rate_item as itemasdescribed from ".RATING." where productid ='".$seller."' ";
	$res_feedbk = mysql_query($sel_feedbk);
	$num_feedbk = mysql_num_rows($res_feedbk);
	$row_feedbk = mysql_fetch_array($res_feedbk);
	
	$sql_basic = "select * from ".RATING." where productid='".$seller."'";
	$row_basic = mysql_fetch_assoc(mysql_query($sql_basic));
?>
<div id="maincontent">

	<div class="topbox">
		<div class="topbox_1">
			<h1>User Rated Teview For the Mentioned Product</h1>
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
				<div class="left_top">
					<h1>Review</h1>
				</div>
				<div class="left_mid">
                 
					<table width="97%" border="0"  cellspacing="0" cellpadding="0">
					  <tr>
						<td style="padding-left:15px;">
						
						
                        	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="filter_box">
							<tr>
							  <th width="5%">&nbsp;</th>
							  <th width="50%"><strong>Product Name</strong></th>
							  <th width="30%"><strong>Average Rating</strong></th>
							  <th width="10%"><strong>Total</strong></th>
							  <th width="5%">&nbsp;</th>
							</tr>
                            
							<?php
								if($num_feedbk != 0)
								{
							?>
								<tr>
								  <td width="5%">&nbsp;</td>
								  <?php $sqlprod = mysql_fetch_array(mysql_query("SELECT * FROM ".TABLE_PRODUCT." where `product_id` = '$seller'")); ?>
								  <td width="50%"><?php echo $sqlprod['title']; ?></td>
								  <td width="30%">
										<input type="hidden" name="item_rating" value="<?=$row_basic['rate_item']?>" id="item_rating" />
										<?php
											for($i=1; $i<=10; $i++)
											{
												if($i <= $row_basic['rate_item']/$row_basic['counter'])
												{
										?>
													<img name=i<?=$i?> class="star" src="images/star2.gif">
										<?php
												}
												else
												{
										?>
													<img name=i<?=$i?> class="star" src="images/star1.gif">
										<?php
												}
											}
										?>
								  </td>
								  <td width="10%"><?=$row_feedbk['itemasdescribed']?></td>
								  <td width="5%">&nbsp;</td>
								</tr>
							<?php
								}
								else
								{
							?>	
								<td colspan="5" style="text-align:center;">No Reviews Yet.</td>							
							<?php
								}
							?>
						</table>
                        </td>
					  </tr>                   
					</table>
                    
					 <?php
					 $sel_fdbk = "select * from ".FEEDBACK." where productid='$seller'";
					 $res_fdbk = mysql_query($sel_fdbk);
					 $num_fdbk = mysql_num_rows($res_fdbk);
					 ?>
                  
                          
					<table width="97%" border="0" align="center" cellspacing="0" cellpadding="0">
					  <tr>
						<td style="font: bold 15px Arial, Helvetica, sans-serif;	color: #737373; padding-top:12px;"><?php echo $num_fdbk; ?> Comment(s) received</td>
					  </tr>
					  <tr>
						<td>
                         <table width="100%" border="0" cellpadding="0" cellspacing="0" class="filter_box">
							<tr>
							  <th width="5%">&nbsp;</th>
							  <th width="50%"><strong>Serial Number</strong></th>
							  <th width="8%"><strong>Comment</strong></th>
							  <th width="22%">&nbsp;</th>
							  <th width="15%"><strong>Date</strong></th>
							</tr>
							<?php
								$i=1;
								if($num_fdbk != 0)
								{
									while($row_fdbk = mysql_fetch_array($res_fdbk))
									{
							?>
									<tr>
									  <td width="5%">&nbsp;</td>
									  <td width="50%"><?php echo $i++; ?></td>
									  <td width="2%">
									  	<?php echo stripslashes($row_fdbk['feedback']); ?>
									  </td>
									  <td width="28%">&nbsp;</td>
									  <td width="15%"><?php echo $row_fdbk['time']; ?></td>
									</tr>
							<?php
									}
								}
								else
								{
							?>
                            <tr>
                              <td colspan="5" style="text-align:center;">No Comments Yet.</td>
                            </tr>
							<?php
								}
							?>
							
						</table>
                        </td>
					  </tr>                   
					</table>
                  
                  <div class="clear"></div>  
				</div>
				<div class="left_bot"></div>
			</div>
			<div class="clear"></div>
		</div>
		
		<?php
			include("includes/rightcol.php");
		?>
		
	</div>
	
</div>
<?php
	include("includes/footer.php");
?>
