<?php
	include("includes/header.php");
	/*if($_SESSION['userid'] == "")
	{
		header("location: ".SITE_URL."index.php?msg=cantview");
	}*/
	require("twitter/twitteroauth.php");
	require('config/twconfig.php');
?>

<!-----------------------------FACEBOOK LOGIN STARTS HEREIN----------------------------->

<?php
if($user != '')
{
	$fname = $userInfo[first_name] ;
	$lname = $userInfo[last_name] ;
	$email = $userInfo[email] ;
	$home_town = $userInfo[hometown][name];
	$address = explode(',',$home_town);
	$add1 = $address[0];
	$loc = $userInfo[location][name];
	$location = explode(',',$loc);
	$city = $location[0];
	$country = $location[1];
	$dob = date('Y-m-d',strtotime($userInfo[birthday])) ;
	$gender = $userInfo[gender] ;
	
	$sqlcheck_user = "select * from ".MANAGE_USER." where user_email = '".$email."'";
	$rescheck_user = mysql_query($sqlcheck_user);
	$numcheck_user = mysql_num_rows($rescheck_user);
	$rowcheck_user = mysql_fetch_array($rescheck_user);
	
	if($numcheck_user == 0)
	{
		$sql_insert_user = "insert into ".MANAGE_USER." (user_firstname,user_lastname,user_email,value_from,is_active) values('".$fname."','".$lname."','".$email."','F',1)";
		$res_insert_user = mysql_query($sql_insert_user);
		
		$_SESSION['userid'] = mysql_insert_id(); 
	}
	else
	{
		$_SESSION['userid'] = $rowcheck_user['user_id'];
	}
}	
?>

<!-----------------------------FACEBOOK LOGIN STOPS HEREIN----------------------------->


<!-----------------------------TWITTER LOGIN STARTS HEREIN----------------------------->
<?php
	if (!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])) 
	//if (!empty($_REQUEST['oauth_verifier']) && !empty($_REQUEST['oauth_token'])) 
	{
		// We've got everything we need
		$twitteroauth = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
		// Let's request the access token
		$access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']);
		// Save it in a session var
		$_SESSION['access_token'] = $access_token;
		// Let's get the user's info
		$user_info = $twitteroauth->get('account/verify_credentials');
		
		//Take the values in SESSION
		
		$_SESSION['users'] = $user_info;
		$user_information = $_SESSION['users'];

		// Print user's info
		/*echo '<pre>';
		print_r($user_information);
		echo '</pre><br/>';
		exit;*/
		
		// INSERT THE VALUES IN DATABASE FROM TWITTER
		$user_id = $user_information->id;
		$screen_name = $user_information->screen_name;
		$user_name = $user_information->name;
		$user_twitter_name = explode(" ", $user_name);
		$fname = $user_twitter_name[0];
		$lname = $user_twitter_name[1];
		
		//$sql_check_twitter_user = "select * from ".MANAGE_USER." where twitter_id = '".$user_id."'";
		$sql_check_twitter_user = "select * from ".MANAGE_USER." where user_screen_name = '".$screen_name."' and value_from = 'T'";
		$res_check_twitter_user = mysql_query($sql_check_twitter_user);
		$num_check_twitter_user = mysql_num_rows($res_check_twitter_user);
		$row_check_twitter_user = mysql_fetch_array($res_check_twitter_user);
		
		if($num_check_twitter_user == 0)
		{
			//$sql_insert_twitter_user = "insert into ".MANAGE_USER." (user_firstname,user_lastname,twitter_id,value_from,is_active) values('".$fname."','".$lname."','".$user_id."','T',1)";
			$sql_insert_twitter_user = "insert into ".MANAGE_USER." (user_firstname,user_lastname,user_screen_name,value_from,is_active) values('".$fname."','".$lname."','".$screen_name."','T',1)";
			$res_insert_twitter_user = mysql_query($sql_insert_twitter_user);
			$_SESSION['userid'] = mysql_insert_id(); 
		}
		else
		{
			$_SESSION['userid'] = $row_check_twitter_user['user_id'];
		}
	}
?>

<!-----------------------------TWITTER LOGIN STOPS HEREIN----------------------------->

<?php
	$sqluser = "select * from ".MANAGE_USER." where user_id = ".$_SESSION['userid']."";
	$resuser = mysql_query($sqluser);
	$rowuser = mysql_fetch_array($resuser);
	
	if($_REQUEST['mode'] == "editaccount")	editaccount();
?>
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
function checkemail()
	{
		if(document.editaccount.user_email.value.search(/\S/) == -1)
		{
			document.getElementById("err_user_email").innerHTML="Please enter your Email";
			document.editaccount.user_email.value="";
			document.editaccount.user_email.focus();
			return false;
		}
		else
		{
			document.getElementById("err_user_email").innerHTML="";
		}
		
		var x = document.editaccount.user_email.value;
	    var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	   
	    if (!filter.test(x))
	    { 
			document.getElementById("err_user_email").innerHTML="Please enter valid Email-ID";
			document.editaccount.user_email.value="";
			document.editaccount.user_email.focus();
			return false;
	    }
		else
		{
			document.getElementById("err_user_email").innerHTML="";
		}
	}
</script>
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css"/>
<div id="maincontent">
	<div id="TabbedPanels1" class="TabbedPanels">
		<ul class="TabbedPanelsTabGroup">
			<li class="TabbedPanelsTab" tabindex="0" style="border-bottom:0;">My Account</li>	    
			<li class="TabbedPanelsTab" tabindex="0" style="border-bottom:0;">Edit Account</li>
			<li class="TabbedPanelsTab" tabindex="0" style="border-bottom:0;">Preferred Deals</li>    
		</ul>
		<div class="TabbedPanelsContentGroup">
			  <div class="TabbedPanelsContent">
				  <div style="font: normal 12px/14px Arial, Helvetica, sans-serif; color:#FF0000;">
					 <?php
						if($_REQUEST['msg'] == "successedit")
						{
							echo "You have successfully updated your credentials.";
						}
						elseif($_REQUEST['msg'] == "emailexist")
						{
							echo "Please edit with some other email Id as this one already exists.";
						}
					 ?>
				  </div><br />
				   Name : <?php echo $rowuser['user_firstname']; ?> <?php echo $rowuser['user_lastname']; ?><br /><br /><br />
				   Email: <?php echo $rowuser['user_email']; ?><br /><br /><br />
				   Password: <?php echo $rowuser['user_pass']; ?>
			  </div>
			  <div class="TabbedPanelsContent">
					<div class="additional_information_base">
						<form name="editaccount" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return checkemail();">
							<input type="hidden" name="mode" value="editaccount" />
							   <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
									<tr>
										  <td colspan="2" style="padding: 15px 0 0 15px;">
												First Name<br /><input type="text" name="user_firstname" class="txtfieldbg" style="margin:6px 0 0 0;" value="<?php echo $rowuser['user_firstname']; ?>" /><br />
												<span style="color:#FF0000;" id="err_user_firstname"></span>
										  </td>
									</tr>
									<tr>
										  <td colspan="2">&nbsp;</td>
									</tr>
									<tr>
										  <td colspan="2" style="padding: 15px 0 0 15px;">
												Last Name<br /><input type="text" name="user_lastname" class="txtfieldbg" style="margin:6px 0 0 0;" value="<?php echo $rowuser['user_lastname']; ?>" /><br />
												<span style="color:#FF0000;" id="err_user_lastname"></span>
										  </td>
									</tr>
									<tr>
										  <td colspan="2">&nbsp;</td>
									</tr>
									<tr>
										  <td colspan="2" style="padding: 15px 0 0 15px;">
												Email<br /><input type="text" name="user_email" class="txtfieldbg" style="margin:6px 0 0 0;" value="<?php echo $rowuser['user_email']; ?>" <?php if($rowuser['user_email'] != ''){ echo "disabled"; } ?> /><br />
												<span style="color:#FF0000;" id="err_user_email"></span>
										  </td>
									</tr>
									<tr>
										  <td colspan="2">&nbsp;</td>
									</tr>
									<tr>
										  <td colspan="2" style="padding: 0px 0 0 15px;">
												Password<br/><input type="password" name="user_pass" class="txtfieldbg" style="margin:6px 0 0 0;" value="<?php echo $rowuser['user_pass']; ?>" /><br />
												<span style="color:#FF0000;" id="err_user_pass"></span>
										  </td>
									</tr>   
									<tr>
										  <td colspan="2">&nbsp;</td>
									</tr>
									<tr>
										  <td colspan="2" style="padding: 0px 0 0 15px;">
												Category<br/>
													<?php
														$sql_category = "select * from ".MANAGE_E_MAIN_CATEGORY." where is_active = 1";
														$res_category = mysql_query($sql_category);
														while($row_category = mysql_fetch_array($res_category))
														{
														 $cat_arr = explode(',',$rowuser['categories']);
														 $check = "";
														 for($i=0; $i<count($cat_arr); $i++)
														 {
														 	if($row_category['id'] == $cat_arr[$i]) {
																$check = 'checked="checked"';
																break;
															}
																
														 }
													?>
															<input type="checkbox" name="categories[]" <?=$check?> value="<?php echo $row_category['id']; ?>"><?php echo $row_category['category_name']; ?>
													<?php
														}
													?>
												<br />
												<span style="color:#FF0000;" id="err_user_pass"></span>
										  </td>
									</tr>   
									<tr>
										  <td colspan="2"></td>
									</tr>
									<tr>
										  <td colspan="2" style="padding: 15px 0 0 15px;">
												<input type="submit" name="Submit3" class="create_btn" value="Save"/>
										  </td>
									</tr>
							   </table>
					   	</form>
					</div>          
			  </div>		
			  <div class="TabbedPanelsContent">
					<div class="reviews_base">
						<div class="latest_deal">
							<!--<div class="left_mid">-->
								<?php
								
									$sqluser_cat = "select * from ".MANAGE_USER." where user_id = ".$_SESSION['userid']."";
									$resuser_cat = mysql_query($sqluser_cat);
									$rowuser_cat = mysql_fetch_array($resuser_cat);
									
									$user_cat = explode("," , $rowuser_cat['categories']);
									
									for($j=0; $j<count($user_cat); $j++)
									{
										$user_category = $user_cat[$j];	
										
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
										
										$sql_deal = "select * from ".TABLE_PRODUCT." where deal_coupon = 'd' and cat_id = ".$user_category." and is_active = 1 order by product_id desc ".$GLOBALS[sql_page]."";
										
										
										$sqlStrAux = "SELECT count(*) as total FROM ".TABLE_PRODUCT." where deal_coupon = 'd' and cat_id = ".$user_category." and is_active = 1";
										$aux = mysql_fetch_assoc(mysql_query($sqlStrAux));
										
										$res_deal = mysql_query($sql_deal.$limit);
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
															<div class="hot_deal"></div>
															<h1><?php echo wrptxt(stripslashes($row_deal['title']),37); ?></h1>
															<div class="border_bg"><a href="<?php echo SITE_URL; ?>deal_detail.php?productid=<?php echo $row_deal['product_id']; ?>"><img src="<?php echo $row_deal['image_url']; ?>" alt="" width="188" height="137" border="0"/></a></div>
															<ul>
																<li><span>From <?php echo stripslashes($rowdeal_sourcename['deal_source_name']); ?></span></li>
																<li>List Price: <strong>$<?php echo $row_deal['actual_price']; ?></strong></li>
																<li>Price: <span class="redtext">$<?php echo $row_deal['deal_price']; ?></span> <strong>+ FREE SHIPPING</strong></li>
																<li>
																	<img src="images/comm_bg.gif" alt="" width="139" height="32" border="0"/>
																</li>
																<li>
																	<img src="images/spacer.gif" alt="" width="1" height="10" border="0"/>
																</li>
															</ul>
														</div>
														<div class="hot_dealbtn"><a href="#">Reveal Code</a></div>
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
							
												<div style="float:right; margin: 0 0 15px 0;"><?php $p->show();?></div>
									<?php
											}
									}
									?>
							<!--</div>-->
						</div>
					</div>           
			  </div>
			  <div class="clear"></div>      
		</div>
	</div>
</div>
<?php
	include("includes/footer.php");
?>
<?php
	function editaccount()
	{
		$cat = implode("," , $_REQUEST['categories']);
		
		$sqlcheckemail = "select * from ".MANAGE_USER." where user_email = '".$_REQUEST['user_email']."'";
		$rescheckemail = mysql_query($sqlcheckemail);
		$numcheckemail = mysql_num_rows($rescheckemail);
		
		if($numcheckemail == 0 && $_REQUEST['user_email'] != '')
		{
			$sqledit = "update ".MANAGE_USER." set user_firstname = '".$_REQUEST['user_firstname']."', user_lastname = '".$_REQUEST['user_lastname']."', user_email = '".$_REQUEST['user_email']."', user_pass = '".$_REQUEST['user_pass']."', categories = '".$cat."' where user_id = ".$_SESSION['userid']."";	
			$resedit = mysql_query($sqledit);
			header("location: ".SITE_URL."user_account.php?msg=successedit");
		}
		else
		{
			header("location: ".SITE_URL."user_account.php?msg=emailexist");
		}
		
	}
?>