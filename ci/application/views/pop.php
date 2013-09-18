<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Welcome</title>
<link href="http://pccounter.net/media/css/popup_style.css" rel="stylesheet" type="text/css" />
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
</head>

<body>
<div id="maindiv">
{deal}
    <div id="offerid_top_box">
	<div class="offerid_top">
		<div class="back_to"><a onClick="window.close();">go back to previous page</a></div>
		<div><a href="{siteUrl}">PC Counter.net home</a></div>
	<div class="offerid_top_heading">Success! PC Counter.net Savings Coming Up</div>
	</div>
</div>

<div class="clear"></div>
<div class="offerid_left">
	
			<img src="{deal_source_logo_url}" border="0" style="max-width:126px;max-height:53px" style="vertical-align: top;" />
</div>

<div class="offerid_right">
	<div class="your_order">{title}</div>
	<div class="code_box">
               {couponCode}

	
	</div>
	
	<div class="offerid_actions">
		<ul>
			
			<li><a href="{productReviewUrl}"><span><img src="http://pccounter.net/media/images/thumb-on.png" border="0" /></span>{qtyReviews} Review (s)</a></li>
			<li><a style="padding-left:0px;" href="{productReviewUrl}"><span><img src="http://pccounter.net/media/images/comment.png" border="0" /></span>{qtyComments} comment(s)</a></li>
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
    {newsletterMsg}
	
		<!--<div style="color:#FF0000; text-align:center;">Your Email-ID has been succesfully subscribed to our Site.</div>-->
	
		<!--<div style="color:#FF0000; text-align:center;">Your are already subscribed to our Daily Deal Newsletter.</div>-->
	
	<form name="newsletter" method="post" onsubmit="return newscheck();">
	<input type="hidden" name="mode" value="addnewsletter" />
	<input type="hidden" name="productid" value="{id}" />
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
					<li><a href="{CmsUrl}">Sample Email</a></li>
					<li>| </li>
					<li><a href="{CmsUrl}">Privacy Policy</a></li>
				</ul>
			</div>
	</form>
</div>
{/deal}
</div>
</body>
</html>
