<?php
	ini_set('default_charset', 'charset=iso-8859-1');
	ob_start();
	session_start();
	require("config.inc.php");
	require("class/Database.class.php");
	require("includes/functions.php");
	ini_set("display_errors","0");
	error_reporting(0);
	
	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);			
	$db->connect();
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Welcome</title>
<link href="css/popup_style.css" rel="stylesheet" type="text/css" />
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
<script type="text/javascript" language="javascript">
  function goBack()
  {
  	window.history.go(-1)
  }
</script>
</head>

<body>
<div id="maindiv">
<div id="offerid_top_box">
	<div class="offerid_top">
		<div class="back_to"><a onblur="return goBack();">go back to previous page</a></div>
		<div><a href="<?php echo SITE_URL; ?>">PC Counter.net home</a></div>
	<div class="offerid_top_heading">Success! PC Counter.net Savings Coming Up</div>
	</div>
</div>
<div class="clear"></div>
<div class="offerid_left">
	<?php 
		$sql_deal_source_logo = "select * from ".MANAGE_DEAL_SOURCE." where deal_source_id = '".$row_deal['deal_sources_id']."'";
		$res_deal_source_logo = mysql_query($sql_deal_source_logo);
		$row_deal_source_logo = mysql_fetch_array($res_deal_source_logo);
		
		if($row_deal_source_logo['deal_source_logo_url'] != '')
		{
	?>
			<img src="<?php echo $row_deal_source_logo['deal_source_logo_url']; ?>" border="0" width="126" height="53" style="vertical-align: top;" />
	<?php
		}
		else
		{
	?>
			<img src="images/noImage.jpg" border="0" width="126" height="53" style="vertical-align: top;" />
	<?php
		}
	?>
</div>

<div class="offerid_right">
	<div class="your_order"><?php echo $row_deal['title']; ?></div>
	<div class="code_box">
		<?php
			if($row_deal['deal_coupon'] == "d")
			{
		?>
			<div class="code">
				No Coupon Code Needed.
			</div>	
		<?php
			}
			else
			{
		?>
			<div class="code">
				<!--<div class="code_top">Use this code <span><img src="images/click_to_copy.png" border="0" alt="click to copy" /></span></div>-->
				<div class="main_code"><?php echo $row_deal['sku']; ?></div>
			</div>	
		<?php
			}
		?>
	</div>
	
	<div class="offerid_actions">
		<ul>
			<?php
				$seller = $_REQUEST['seller'];
				$sel_feedbk = "select productid,rate_item as itemasdescribed from ".RATING." where productid ='".$_REQUEST['productid']."' ";
				$res_feedbk = mysql_query($sel_feedbk);
				$num_feedbk = mysql_num_rows($res_feedbk);
				$row_feedbk = mysql_fetch_array($res_feedbk);
			?>
			<li><a href="<?php echo SITE_URL; ?>review.php?seller=<?php echo $_REQUEST['productid']; ?>"><span><img src="images/thumb-on.png" border="0" /></span><?php if($num_feedbk != 0) { echo $row_feedbk['itemasdescribed']; } else { echo "0"; } ?> Review (s)</a></li>
			<?php
				 $sel_fdbk = "select * from ".FEEDBACK." where productid='".$_REQUEST['productid']."'";
				 $res_fdbk = mysql_query($sel_fdbk);
				 $num_fdbk = mysql_num_rows($res_fdbk);
			 ?>
			<li><a style="padding-left:0px;" href="<?php echo SITE_URL; ?>review.php?seller=<?php echo $_REQUEST['productid']; ?>"><span><img src="images/comment.png" border="0" /></span><?php echo $num_fdbk; ?> comment(s)</a></li>
			<!--<li><a href="#"><span><img src="images/share.png" border="0" /></span>share</a></li>-->
		</ul>
	</div>
<div class="clear"></div>	
<div class="how_to">
	<h4>How to use this code:</h4>
	<ul>
		<li>Add items to your shopping cart.</li>
		<li>When you have completed your shopping, proceed to checkout.</li>
		<li>Look for the "Promo Code" box near your order total.</li>
		<li>Copy the code shown here and type it into the promo code field, or copy (highlight it with your mouse and right click and select copy) and paste this code: FSA-QO12 into the promo code field.</li>
		<li>Click "Apply" to see your savings reflected in your order total.</li>
		<li>Checkout, and enjoy your savings!</li>
	</ul>	
</div>	
<div class="clear"></div>	
<div class="how_to" style="margin: 5px 0; border-bottom: 0;">
	<h4 style=" padding: 0;">Report a problem with this offer</h4>
</div>	
</div>
<div class="clear"></div>
<div class="inner_box">
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
			<h4>PC Counter Email Updates</h4>
			<p>Get email updates whenever new PC Counter.net offers are added</p>
			<div>
				<input type="text" id="email" class="textfield" name="email" placeholder="Enter Your Email address here"/> 
				<input type="submit" name="Submit2" class="sign_up_btn" value=""/>
				<br /><span style="color:#FF0000;" id="err_email"></span>
			</div>
			<div class="email_on">
				<span>Add the Offers.com daily Top Deals Email </span><input name="" type="checkbox" value="" checked="checked" disabled="disabled" style="vertical-align: middle;" />
			</div>
			<div class="sample">
				<ul>
					<li><a href="<?php echo SITE_URL; ?>cms.php?content_id=7">Sample Email</a></li>
					<li>| </li>
					<li><a href="<?php echo SITE_URL; ?>cms.php?content_id=5">Privacy Policy</a></li>
				</ul>
			</div>
	</form>
</div>
</div>
</body>
</html>
