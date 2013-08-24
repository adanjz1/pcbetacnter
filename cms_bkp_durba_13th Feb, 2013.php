<?php
	include("includes/header.php");
?>
<?php
	$sql_cms = "select * from ".MANAGE_CONTENT." where content_id = ".$_REQUEST['content_id']." and is_active=1";
	$res_cms = mysql_query($sql_cms);
	$row_cms = mysql_fetch_array($res_cms);
?>
<div id="maincontent">
	<div class="topbox">
		<div class="topbox_1">
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
				<div class="left_top"><h1><?php echo stripslashes($row_cms['content_name']); ?></h1></div>
				<div class="left_mid" style="padding: 10px 10px 10px 10px; width: 790px;">
					<?php echo stripslashes($row_cms['content_desc']); ?>
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