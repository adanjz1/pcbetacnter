<?php
	include("includes/header.php");
	
	if($_REQUEST['mode'] == "update_newsletter")		newsletter_update();
?>
<div id="maincontent">
	<div>
		<div style="color:#FF0000; text-align:center;">
			<?php
				if($_REQUEST['msg'] == "newslettersuccess")
				{
			?>
					Your Email-ID has been succesfully subscribed to our Site.
			<?php
				}
				elseif($_REQUEST['msg'] == "newsletterfailed")
				{
			?>
					Your are already subscribed to our Daily Deal Newsletter.
			<?php
				}
			?>
			
		</div>
	</div>
</div>
<?php
	include("includes/footer.php");
?>