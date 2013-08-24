<?php
	include("includes/header.php");
?>
<?php
	$sqlproduct = "select * from ".TABLE_PRODUCT." where product_id = ".$_REQUEST['productid']."";
	$resproduct = mysql_query($sqlproduct);
	$row_deal = mysql_fetch_array($resproduct);
	
	$savings = ($row_deal['actual_price'] - $row_deal['deal_price']);
	
	$savingspercentage = (($savings * 100) / $row_deal['actual_price']);
?>
<?php
if($_REQUEST['mode'] == "addnewsletter")
{
	$sql_email = "select * from ".MANAGE_DAILY_DEAL_EMAIL." where deal_email = '".$_REQUEST['email']."' and newsletter_type = 'daily'";
	$res_email = mysql_query($sql_email);
	$num_email = mysql_num_rows($res_email);
	
	if($num_email == 0)
	{
		/*$news_sql="insert into ".MANAGE_DAILY_DEAL_EMAIL." 
		(deal_email,newsletter_type,is_active,status,update) 
		values('".$_REQUEST['email']."', 'daily', '1', 'subscribe', NOW())";*/
		$news_sql= "INSERT INTO  ".MANAGE_DAILY_DEAL_EMAIL." (
		`deal_email` ,
		`newsletter_type` ,
		`is_active` ,
		`status` ,
		`update`
		)
		VALUES (
		'".$_REQUEST['email']."',  'daily',  '0',  'Subscribe',  NOW()
		)";
		mysql_query($news_sql);
	
		$email=$_REQUEST['email'];
		$subject="PC Counter News Subcription";
		$message.="<p>Welcome to our PC Counter</p>";
		$message.="<p>We are pleased and proud that you have decided to join us and your news subscription will be activated in few more minutes. </p>";
		$message.="<p>To complete the process please click on the below link. </p>";
		$message.="<p>Please Click on the link : ".SITE_URL."user_newsletter.php?email=".$_REQUEST['email']."&action=user_nwsltr</p>";
		$message.="<p>Thanking you for newsletter activation</p>";
		$headers='MIME-Version: 1.0' . "\r\n";
		$headers.='Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers.='To: Newsletter User' . "\r\n";
		$headers.='From: PC Counter Admin' . "\r\n";
		
		mail($email, $subject, $message, $headers);
		
		header("location: ".SITE_URL."popup.php?productid=".$_REQUEST['productid']."&msg=newslettersuccess");
	}
	else
	{
		header("location: ".SITE_URL."popup.php?productid=".$_REQUEST['productid']."&msg=newsletterfailed");
	}
}
?>
<script language="javascript" type="text/javascript">
	function newscheck()
	{
		if(document.newsletter.email.value.search(/\S/) == -1)
		{
			document.getElementById("err_email").innerHTML="Please enter email to subscribe";
			document.newsletter.email.value="";
			document.newsletter.email.focus();
			return false;
		}
		else
		{
			document.getElementById("err_email").innerHTML="";
		}
	}
</script>
<div id="maincontent">

	<div class="topbox">
		<div class="topbox_1">
			<h1>Success! PC Counter Savings Coming Up.</h1>
		</div>
	</div>
	
	<div class="clear"></div>
	
	<div id="content">
	
		<div class="leftcol">
			<div class="latest_deal">
				<div class="left_top">
					<?php
						$sqlcategory = "select * from ".MANAGE_E_CATEGORY." where id = ".$row_deal['cat_id']."";
						$rescategory = mysql_query($sqlcategory);
						$rowcategory = mysql_fetch_array($rescategory);
					?>
					<h1><?php echo stripslashes($rowcategory['category_name']); ?></h1>
				</div>
				<div class="left_mid">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="details">
						  <tr>
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									  <tr>
										<td colspan="2">
											<img src="<?php echo $row_deal['image_url']; ?>" alt="" width="338" height="272" border="0" class="border"/>
										</td>
									  </tr>
									  <!--<tr>
											<td width="7%"  style="padding: 10px 0 0 0;">
												<img src="images/large_icon.gif" alt="" width="20" height="18" />
											</td>
											<td width="93%" style="padding: 10px 0 0 0;">
												<strong><a href="#"> Click to Enlarge</a></strong>
											</td>
									  </tr>-->
								</table>
							</td>
							<td align="left" valign="top">
								  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="details_right">
									  <tr>
											<td colspan="2">
												<a><?php echo stripslashes($row_deal['title']); ?></a>
											</td>
									  </tr>
								      <tr>
											<td colspan="2">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													  <tr>
															<td>
																List Price: <span>$<?php echo $row_deal['actual_price']; ?></span><br/>
																Price: <span class="textred">$<?php echo $row_deal['deal_price']; ?></span> + <span class="textblack">FREE SHIPPING</span><br/>
																You Save: <span class="textred1">$<?php echo $savings; ?> (<?php echo round($savingspercentage,2); ?>%)</span><br/>
																Condition: <span class="textgrey">New</span><br/>
																Expires: <span class="textgrey"><?php echo date("F j, Y, g:i a",strtotime($row_deal['deal_end_date'])); ?> or sooner</span><br/>
																Submitted By: <span class="textgrey">Sourabh Kalantri (20 hours ago)</span>
																<br/>
															</td>
													  </tr>
												</table>
											</td>
								  	  </tr>
									  <tr>
											<td colspan="2">
												<table width="100%" border="0" cellspacing="0" cellpadding="0" class="details_right">
													  <tr>
															<style>
																.review a{
																	padding: 0 10px;
																}
															</style>
															<th colspan="2" width="94%" class="review" style="text-align:left;">
																<?php
																	 $sel_fdbk = "select * from ".FEEDBACK." where productid='".$_REQUEST['productid']."'";
																	 $res_fdbk = mysql_query($sel_fdbk);
																	 $num_fdbk = mysql_num_rows($res_fdbk);
																 ?>
																<a style="padding-left:0px;" href="<?php echo SITE_URL; ?>review.php?seller=<?php echo $_REQUEST['productid']; ?>"><?php echo $num_fdbk; ?> Comment (s)</a>  |
																<?php
																	$seller = $_REQUEST['seller'];
																	$sel_feedbk = "select productid,rate_item as itemasdescribed from ".RATING." where productid ='".$_REQUEST['productid']."' ";
																	$res_feedbk = mysql_query($sel_feedbk);
																	$num_feedbk = mysql_num_rows($res_feedbk);
																	$row_feedbk = mysql_fetch_array($res_feedbk);
																?>
																<a href="<?php echo SITE_URL; ?>review.php?seller=<?php echo $_REQUEST['productid']; ?>"><?php if($num_feedbk != 0) { echo $row_feedbk['itemasdescribed']; } else { echo "0"; } ?> Review (s)</a>
															</th>
													  </tr>
												</table>
											</td>
								  	  </tr>
								      <!--<tr>
											<td colspan="2">
												<img src="images/like_face.gif" alt="" width="243" height="30" border="0" />
											</td>
									  </tr>-->
								  	  <tr>
											<!--<td width="44%">
												<a href="#">
													<img src="images/getdeal_btn.gif" alt="" width="158" height="49" border="0" />
												</a>
											</td>-->
											<?php
												$sqlcoupon_sourcename = "select * from ".MANAGE_DEAL_SOURCE." where deal_source_id = ".$row_deal['deal_sources_id']."";
												$rescoupon_sourcename = mysql_query($sqlcoupon_sourcename);
												$rowcoupon_sourcename = mysql_fetch_array($rescoupon_sourcename);
											?>
											<td width="56%">
												<a href="#" style="color: #ff6600;font: normal 12px/47px Arial, Helvetica, sans-serif;">From <?php echo stripslashes($rowcoupon_sourcename['deal_source_name']); ?></a>
											</td>
								  	  </tr>
								</table>
							</td>
						  </tr>
					</table>
				</div>
				<div class="left_bot"></div>
			</div>
			<div>
				<?php
					if($_REQUEST['msg'] == "newslettersuccess")
					{
				?>
					<div style="color:#FF0000; text-align:center;">Your Email-ID has been succesfully subscribed to our Site.</div>
				<?php
					}
					elseif($_REQUEST['msg'] == "newsletterfailed")
					{
				?>
					<div style="color:#FF0000; text-align:center;">Your are already subscribed to our Daily Deal Newsletter.</div>
				<?php
					}
				?>
				<form name="newsletter" method="post" onsubmit="return newscheck();">
					<input type="hidden" name="mode" value="addnewsletter" />
					<input type="hidden" name="productid" value="<?php echo $_REQUEST['productid']; ?>" />
					<div>
						<ul>
							<li>Get one daily email featuring our very best offers</li>
							<li><input type="text" class="search_bg1" name="email" placeholder="Enter Your Email address here"/>
							<br /><span style="color:#FF0000;" id="err_email"></span>
							</li>
							<li><input type="submit" name="Submit2" class="search_btn1" value=""/></li>
							<li><span><a href="<?php echo SITE_URL; ?>cms.php?content_id=7">Sample Email</a>  |  <a href="<?php echo SITE_URL; ?>cms.php?content_id=5">Privacy Policy</a></span></li>
						</ul>
					</div>
				</form>
			</div>
		</div>
	</div>
	
</div>
<?php
	include("includes/footer.php");
?>
