<?php
	include("includes/header.php");
	
	if($_REQUEST['mode'] == "update_newsletter")		newsletter_update();
	elseif($_REQUEST['action'] == "user_nwsltr")		update_user_newsletter();
?>


<style>
.lising_box{
	width: 98%;
	height: auto;
	float: none;
	margin: 10px auto 0 auto;
	background: none;
	border: 0;
}
.lising_box div, .lising_box div p{
	font: normal 13px/15px Arial, Helvetica, sans-serif;
	color: #4c4c4c;
	padding: 4px 0 4px 10px; 
	margin: 0px;
}
.lising_box div label{
	font: bold 13px/15px Arial, Helvetica, sans-serif;
	color: #4c4c4c;
	padding: 0px;
	margin: 0px;
}
.lising_box_btn{
	width: auto;
	height: 32px;
	color: #fff;
	display: inline-block;
	padding: 3px 12px;
	background: #2275a4;
	behavior:url(js/PIE.htc);
	position:relative;
	border-radius: 4px;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	border: solid 1px #e2e2e2;
	font: bold 15px/32px Arial, Helvetica, sans-serif;
	border: 0px;
	cursor: pointer;
	text-transform: uppercase;
}
.lising_box input{
	float: left;
}

</style>

<div id="maincontent">
	<div class="lising_box">
		<div>
			  <h1>Thank you for signing up</h1>
			  <div>Your PC Counter.net email subscription has been confimed for unified.durba@gmail.com.<br>
				You can look forward to receiving your first email within the next week.</div>
			  <img src="https://www.offers.com/images/mail/welcome/flying-email.png" alt="image" id="flying-email">
		</div>
		<form id="newswelcome" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<input type="hidden" name="mode" value="update_newsletter" />
			<input type="hidden" name="email" value="<?php echo $_REQUEST['email']; ?>" />
			<div style="width:740px; float: left; border-right:1px solid #d3d3d3; padding-right:50px;">
				  <h1 style="color:#333; font-size:15px;">Add Another Subscription&nbsp;Personalize your savings by adding email options to your account</h1>
				  <div id="more-subscriptions">
					<div>
						  <div>
								<input name="check[]" value="weekly" id="check[]" type="checkbox">
								<label for="weekly">Weekly Newsletter</label>
						  </div>
						  <div>
							  Receive the best of PC Counter.net every week + an occasional "special" seasonal email. This is a great option for keeping up with the best coupons and deals of the week.
						  </div>
					</div>
					<div>
						  <div>
								<input name="check[]" id="check[]" value="daily" type="checkbox" checked="checked" disabled="disabled">
								<label for="deals">Today's Best Deals</label>
						  </div>
					  	  <div>
						  		Daily digest of the best deals on PC Counter.net, overflowing with savings.
						  </div>
					</div>
					<div>
						  <div>
								<input name="check[]" id="check[]" value="sweep" type="checkbox">
								<label for="sweeps">Sweepstakes Updates</label>
						  </div>
					  	  <div>
						 		 Whenever we launch a new sweepstakes, we'll let you know. There's typically 1 new sweepstakes per week.
						  </div>
					</div>
					<div>
						  <div>
								<input name="check[]" id="check[]" value="holiday" type="checkbox">
								<label for="holiday">Holiday Updates</label>
						  </div>
					  	  <div>
						  		This is a great way to catch the best savings for your next holiday gift. We only send this email before major holidays, including Christmas, Valentine's Day and Mother's Day.
						  </div>
					</div>
					<div>
							<div>
							  	<input type="submit" name="Subscribe" id="Subscribe" class="lising_box_btn" value="Subscribe">
							</div>
					</div>
				  </div>
			</div>
		</form>
		<div style="width:250px; float:right; padding-left:0px;">
			  <h1 style="color:#333; font-size:15px;">Getting Started on PC Counter.net</h1>
			  <div style="padding-left:0px;">
				<p>Learn more about&nbsp;The PC Counter.net Promise&nbsp;and why it makes PC Counter.net different. We help you find the right coupons and deals so you save time and money online and we promise that our offers work.</p>
				<p>If you are new to coupon codes, take a look at our&nbsp;Savings Guide&nbsp;for savings ideas and our simple&nbsp;How to Use a Coupon Code&nbsp;for a step-by-step tutorial covering how to find codes on PC Counter.net, how to use the code or identify your savings at checkout, and how to make sure that the savings were applied.</p>
				<p>You're going to love these offers,</p>
			  </div>
	    </div>
	</div>
</div>

<?php
	include("includes/footer.php");
?>
<?php

	function update_user_newsletter()
	{
		$sql_newsltr_update = "update ".MANAGE_DAILY_DEAL_EMAIL." set is_active = '1' where deal_email = '".$_REQUEST['email']."' and newsletter_type = 'daily' and is_active = '0'";
		$res_newsltr_update = mysql_query($sql_newsltr_update);
		
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
	}

	function newsletter_update()
	{
		for($i=0; $i <= count($_REQUEST['check']); $i++)
		{
			$sql_news_check = "select * from ".MANAGE_DAILY_DEAL_EMAIL." where deal_email = '".$_REQUEST['email']."' and newsletter_type = '".$_REQUEST['check'][$i]."'";
			$res_news_check = mysql_query($sql_news_check);
			$num_news_check = mysql_num_rows($res_news_check);
			
			if($num_news_check == 0)
			{
				$sql_insert_newsletter = "INSERT INTO  ".MANAGE_DAILY_DEAL_EMAIL." (`deal_email` ,`newsletter_type` ,`is_active` ,`status` ,`update`)
										 VALUES ('".$_REQUEST['email']."',  '".$_REQUEST['check'][$i]."',  '1',  'Subscribe',  NOW())";
				$res_insert_newsletter = mysql_query($sql_insert_newsletter);
				
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
				
				header("location: ".SITE_URL."welcome_subscriber.php?msg=newslettersuccess");		
			}	
			
			else
			{
				header("location: ".SITE_URL."welcome_subscriber.php?msg=newsletterfailed");	
			}
				
		}
			
	}
?>