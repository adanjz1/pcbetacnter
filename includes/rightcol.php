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
		'".$_REQUEST['email']."',  'daily',  '1',  'Subscribe',  NOW()
		)";
		mysql_query($news_sql);
	
		$email=$_REQUEST['email'];
		$subject="PC Counter News Subcription";
		$message.="<p>Welcome to our PC Counter</p>";
		$message.="<p>We are pleased and proud that you have decided to join us and your news subscription is activated. </p>";
		$message.="<p>Thanking you for newsletter activation</p>";
		$headers='MIME-Version: 1.0' . "\r\n";
		$headers.='Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers.='To: Newsletter User' . "\r\n";
		$headers.='From: PC Counter Admin' . "\r\n";
		
		mail($email, $subject, $message, $headers);
		
		header("location: ".SITE_URL."index.php?msg=newslettersuccess");
	}
	else
	{
		header("location: ".SITE_URL."index.php?msg=newsletterfailed");
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

		<div class="rightcol">
		
			<!--NEWSLETTER SECTION STARTS-->
			
				<form name="newsletter" method="post" onsubmit="return newscheck();">
				<input type="hidden" name="mode" value="addnewsletter" />
					<div class="right_box">
						<div class="right_top">
							<h1>Newsletter</h1>
						</div>
						<div class="right_mid">
							<h1>The Best Coupons & Deals</h1>
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
							<ul>
								<li>Get one daily email featuring our very best offers</li>
								<li><input type="text" class="search_bg1" name="email" placeholder="Enter Your Email address here"/>
								<br /><span style="color:#FF0000;" id="err_email"></span>
								</li>
								<li><input type="submit" name="Submit2" class="search_btn1" value=""/></li>
								<li><span><a href="<?php echo SITE_URL; ?>cms.php?content_id=7">Sample Email</a>  |  <a href="<?php echo SITE_URL; ?>cms.php?content_id=5">Privacy Policy</a></span></li>
							</ul>
						</div>
						<div class="right_bot"></div>
					</div>
				</form>
				
			<!--NEWSLETTER SECTION STOPS-->
			
			<div class="clear"></div>
			
			<!--STORES AND BRANDS STARTS-->
			
				<div class="right_box">
					<div class="right_top">
						<h1>Stores & Brands</h1>
					</div>
					<div class="right_mid">
					<?php
						$sql_store = "select * from ".MANAGE_DEAL_SOURCE." where is_active = 1 order by deal_source_id asc limit 0, 9";
						$res_store = mysql_query($sql_store);
						while($row_store = mysql_fetch_array($res_store))
						{
					?>
							<div class="pic_box">
								<?php
									if($row_store['deal_source_logo_url'] == '')
									{
								?>
									<a href="<?php echo SITE_URL; ?>deal_store_category.php?brand=<?php echo $row_store['deal_source_id']; ?>"><img src="images/noImage.jpg" alt="" width="69" height="60" class="border" border="0"/></a>
								<?php
									}
									else
									{
								?>
									<a href="<?php echo SITE_URL; ?>deal_store_category.php?brand=<?php echo $row_store['deal_source_id']; ?>"><img src="<?php echo SITE_URL; ?>upload/brand/thumbnail/thumb_<?php echo $row_store['deal_source_logo_url']; ?>" alt="" width="69" height="60" class="border" border="0"/></a>
								<?php
									}
								?>
							</div>
					<?php
						}
					?>
					</div>
					<div class="right_bot"></div>
				</div>
			
			<!--STORES AND BRANDS ENDS-->
			
			<div class="clear"></div>
			
			<!--OUR OFFERS CMS STARTS-->
			
			<?php
				$sql_cms_content = "select * from ".MANAGE_CONTENT." where content_id = 8";
				$res_cms_content = mysql_query($sql_cms_content);
				$row_cms_content = mysql_fetch_array($res_cms_content);
			?>
			
			<div class="right_box">
				<div class="right_top">
					<h1><?php echo $row_cms_content['content_name']; ?></h1>
				</div>
				<div class="right_mid">
					<!--<ul>
						<li>At PCCounter.net, you'll always find thousands of money-saving offers that work<br/> – guaranteed.</li>
						<li style="padding: 16px  14px;">That's because our savings experts scour the Internet every day and check every offer we publish.</li>
						<li><a href="#" style="color: #1a4c92;">That's the PCCounter.net Promise</a></li>
					</ul>-->
					<?php echo stripslashes($row_cms_content['content_desc']); ?>
				</div>
				<div class="right_bot"></div>
			</div>
			
			<!--OUR OFFERS CMS ENDS-->
			
			<div class="clear"></div>
			
			<!--LATEST BLOG POST STARTS-->
			
			<div class="right_box">
				<div class="right_top">
					<h1>Latest Blog Posts</h1>
				</div>
				<div class="right_mid">
					<ul>
						<?php
							$sqlblogpost = "select * from ".MANAGE_COUNTER_POSTS." order by post_date desc limit 0,3";
							$resblogpost = mysql_query($sqlblogpost);
							$numblogpost = mysql_num_rows($resblogpost);
							if($numblogpost != 0)
							{
								while($rowblogpost = mysql_fetch_array($resblogpost))
								{
									$today = date("Y-m-d");
									$blogdate = explode(" ", $rowblogpost['post_date']);
									$difference = abs(strtotime($blogdate[0])-strtotime($today));
									
									$years = floor($difference / (365*60*60*24));
									$months = floor(($difference - $years * 365*60*60*24) / (30*60*60*24));
									$days = floor(($difference - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
						?>
								<li style="padding: 13px 14px;">
									<strong><?php echo stripslashes($rowblogpost['post_title']); ?></strong><br/>
									<span style="font: normal 11px/14px Arial, Helvetica, sans-serif; padding:0; margin: 0;">Posted <?php printf("%d days\n", $days); ?> days ago by <?php echo stripslashes($rowblogpost['post_name']); ?></span>
								</li>
						<?php
								}
						?>
								<li>
									<span style="padding: 0 0 0 120px;"><a href="<?php echo SITE_URL; ?>blog/">Read More</a></span>
								</li>
						<?php
							}
							else
							{
						?>	
								<li style="padding: 13px 14px;">
									<strong>No Latest Blog has been posted.</strong><br/>
								</li>
						<?php
							}
						?>					
						<!--<li><strong>Labor Day 2012 Sales Roundup</strong><br/><span style="font: normal 11px/14px Arial, Helvetica, sans-serif; padding:0; margin: 0;">Posted 3 days ago by</span></li>
						<li style="padding: 13px 14px;"><strong>Best Back-to-School Devices for Apps</strong><br/><span style="font: normal 11px/14px Arial, Helvetica, sans-serif; padding:0; margin: 0;">
						Posted 2 days ago by</span></li>-->
					</ul>
				</div>
				<div class="right_bot"></div>
			</div>
			
			<!--LATEST BLOG POST ENDS-->
			
			<div class="clear"></div>
			
			<!--BANNER IMAGE STARTS HERE-->
			
			<?php
				$sqlbanner = "select * from ".MANAGE_BANNER." where is_active = 1 order by banner_id desc limit 0, 1";
				$resbanner = mysql_query($sqlbanner);
				$rowbanner = mysql_fetch_array($resbanner);
			?>
			
				<div class="right_box">
					<img src="<?php echo SITE_URL; ?>/upload/banner/<?php echo $rowbanner['banner_image']; ?>" alt="" width="278" height="231" border="0"/>
				</div>
				
			<?php
			
			?>
			
			<!--BANNER IMAGE ENDS HERE-->
			
		</div>