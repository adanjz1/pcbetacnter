<?php
	include("includes/header.php");
?>
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css"/>

<script>
function bottom() {
    document.getElementById( 'bottom' ).scrollIntoView();
    window.setTimeout( function () { top(); }, 2000 );
};
</script>

<!---------------------------------------REVIEW SECTION STARTS--------------------------------------->
<?php
	//$seller = $_REQUEST['productid'];
	$sel_feedbk = "select productid,rate_item as itemasdescribed from ".RATING." where productid ='".$_REQUEST['productid']."' ";
	$res_feedbk = mysql_query($sel_feedbk);
	$num_feedbk = mysql_num_rows($res_feedbk);
	$row_feedbk = mysql_fetch_array($res_feedbk);
	
	$sql_basic = "select * from ".RATING." where productid='".$_REQUEST['productid']."'";
	$row_basic = mysql_fetch_assoc(mysql_query($sql_basic));
?>
<!---------------------------------------REVIEW SECTION STOPS--------------------------------------->
<?php
	$sqlproduct = "select * from ".TABLE_PRODUCT." where product_id = ".$_REQUEST['productid']."";
	$resproduct = mysql_query($sqlproduct);
	$row_deal = mysql_fetch_array($resproduct);
	
	$savings = ($row_deal['actual_price'] - $row_deal['deal_price']);
	if($savings < 0)
	{
		$savings = "0";
	}
	else
	{
		$savings;
	}
	
	$savingspercentage = (($savings * 100) / $row_deal['actual_price']);
?>

<?php
	$sql_cms = "select * from ".MANAGE_CONTENT." where content_id = 5 and is_active=1";
	$res_cms = mysql_query($sql_cms);
	$row_cms = mysql_fetch_array($res_cms);
?>

<?php
$today = date("Y-m-d");
$sqlprod = mysql_fetch_array(mysql_query("SELECT * FROM ".TABLE_PRODUCT." WHERE `product_id` = '".$_REQUEST['productid']."'"));

$sqlcomp = mysql_query("SELECT * FROM ".TABLE_REVIEW." WHERE `categoryid` = '".$sqlprod['cat_id']."' && `productid` = '".$sqlprod['product_id']."' && `userid` = '".$_SESSION['userid']."' && `productname` = '".$sqlprod['productname']."'");
$num_rows = mysql_num_rows($sqlcomp);

if($num_rows == 0 && $_REQUEST['action'] == 'review')
{
	$sqlcompare = mysql_query("INSERT INTO ".TABLE_REVIEW." (
	`categoryid` ,`productid` ,`userid` ,`productname` ,`quantity` ,`productcost` ,`total` ,`date`)
	VALUES ('".$sqlprod['cat_id']."', '".$sqlprod['product_id']."', '".$_SESSION['userid']."', '".$sqlprod['title']."', '1', '".$sqlprod['deal_price']."', '".$sqlprod['deal_price']."', '".$today."')");
}
elseif($num_rows != 0)
{
	$row = mysql_fetch_array($sqlcomp);
	$quantity = 1 + $row['quantity'];
	$sqlupdateshop = mysql_query("UPDATE ".TABLE_REVIEW." SET `quantity` = '".$quantity."' WHERE `categoryid` = '".$sqlprod['categoryid']."' && `productid` = '".$sqlprod['productid']."'");
}
?>
<?php
	$seller = $_REQUEST['productid'];

	if($_REQUEST['feedbk_btn'])
	{
		if($_SESSION['userid'] == "")
		{
			header("location: ".SITE_URL."index.php?msg=cannotrate");
		}
		else
		{
			 $feedback = $_POST['feedbk_cont'];
			 $itemrating = $_POST['item_rating'];
			
			
			 $sel_rate = "select * from ".RATING." where productid='".$seller."'";
			 $res_rate = mysql_query($sel_rate);
			 $num_rate = mysql_num_rows($res_rate);
			 $row_rate = mysql_fetch_array($res_rate);
			 if($num_rate>0)
			 {
				 $itemrate		= $row_rate['rate_item']+$itemrating;
				 $counterrate	= $row_rate['counter']+1;
				 $in_selrate = "update ".RATING." set rate_item='".$itemrate."', counter='".$counterrate."' where productid='".$seller."'";
			 }
			 else
			 {
				$in_selrate = "Insert into ".RATING." set productid='".$seller."', rate_item='".$itemrating."', counter='1'";
			 }
			 mysql_query($in_selrate);
			 if($feedback!="")
			 {
				$in_feedbk = "Insert into ".FEEDBACK." set productid='".$seller."', feedback='".$feedback."', time='".$today."'";
				mysql_query($in_feedbk);
			 }
				header("location:deal_detail.php?productid=".$seller);
		}
	}

	$staticvar = "feedback";
	$sql_basic = "select * from ".RATING." where productid='".$seller."'";
	$row_basic = mysql_fetch_assoc(mysql_query($sql_basic));
?>



<script language=javascript>
  function selstar(val,field,name)
  {
  	for(var x=1;x<=10;x++)
	{
		document[name+x].src="images/star1.gif";
	}
	for(var x=1;x<=val;x++)
	{
		document[name+x].src="images/star2.gif";
	}
	document.getElementById(field).value = val;
	
  }
  function remstar(val)
  {
	for(var x=1;x<=val;x++)
	{
		document[name+x].src="images/star1.gif";
	}
  }

  function setrate(val,field,name)
  {
  //alert(val);
  //alert(field);
  //alert(name);
  for(var x=1;x<=val;x++)
	{
		document[name+x].src="images/star2.gif";
	}
	document.getElementById('ratimg').value = val;
  }
  
  function textCounter(field,cntfield,maxlimit) {
	if (field.value.length > maxlimit) // if too long...trim it!
	field.value = field.value.substring(0, maxlimit);
	// otherwise, update 'characters left' counter
	else
	cntfield.value = maxlimit - field.value.length;
 }
 </script>
 <script type="text/javascript">
	var name = new Array();
	name[0]= "images/star2.gif";
	if(document.images)
	{
		var ss = new Image();
		ss.src = name[0];	
		//alert(ss.src);	
	}			
</script>
<!-- form validation -->
<script>
function validate_feedback()
{
if(document.rateform.feedbk_cont.value=='')
{
alert('Please write your feedback');
document.rateform.feedbk_cont.focus();
return false;
}
}
</script>
<div id="maincontent">

	<div class="topbox">
		<div class="topbox_1">
			<h1>Deal Detail</h1>
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
												<a href="<?php echo $row_deal['deal_url']; ?>"><?php echo stripslashes($row_deal['title']); ?></a>
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
																<!--Condition: <span class="textgrey">New</span><br/>-->
																<?php 
																	if(strtotime($row_deal['deal_end_date']) < strtotime(date('Y-m-d H:i:s')))
																	{ 
																?>
																<?php 
																	} 
																	else
																	{ 
																?> 
																	Expires: 
																	<span class="textgrey">
																		<?php echo date("F j, Y, g:i a",strtotime($row_deal['deal_end_date'])); ?> or sooner 
																	</span><!--<br/>-->
																<?php 
																	} 
																?>
																<!--Submitted By: <span class="textgrey">Sourabh Kalantri (20 hours ago)</span>-->
																<!--<br/>-->
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
																<!--<a style="padding-left:0px;" href="<?php echo SITE_URL; ?>review.php?seller=<?php echo $_REQUEST['productid']; ?>">--><a style="padding-left:0px; cursor: pointer;" onclick="return bottom();"><?php echo $num_fdbk; ?> Comment (s)</a>  |
																<?php
																	$seller = $_REQUEST['seller'];
																	$sel_feedbk = "select productid,rate_item as itemasdescribed from ".RATING." where productid ='".$_REQUEST['productid']."' ";
																	$res_feedbk = mysql_query($sel_feedbk);
																	$num_feedbk = mysql_num_rows($res_feedbk);
																	$row_feedbk = mysql_fetch_array($res_feedbk);
																?>
																<!--<a href="<?php echo SITE_URL; ?>review.php?seller=<?php echo $_REQUEST['productid']; ?>">--><a style="cursor: pointer;" onclick="return bottom();"><?php if($num_feedbk != 0) { echo $row_feedbk['itemasdescribed']; } else { echo "0"; } ?> Review (s)</a>
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
												<a href="#" style="color: #ff6600;font: normal 12px/21px Arial, Helvetica, sans-serif;">From <?php echo stripslashes($rowcoupon_sourcename['deal_source_name']); ?></a>
											</td>
								  	  </tr>
									  <tr>
											<td colspan="2">
												<a class="get_deal" href="<?php echo $row_deal['deal_url']; ?>" onclick="window.open('<?php echo SITE_URL; ?>offerid.php?action=review&productid=<?php echo $row_deal['product_id']; ?>','popup','width=560,height=700,scrollbars=no,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0');" target="_blank">Get Deal</a>
											</td>
									  </tr>
								</table>
							</td>
						  </tr>
					</table>
				</div>
				<div class="left_bot"></div>
			</div>
			
			<div class="clear"></div>
		
			<div id="TabbedPanels1" class="TabbedPanels">
				<ul class="TabbedPanelsTabGroup">
					<li class="TabbedPanelsTab" tabindex="0" style="border-bottom:0;">Deal Description</li>	    
					<!--<li class="TabbedPanelsTab" tabindex="0" style="border-bottom:0;"><?php //echo stripslashes($row_cms['content_name']); ?></li>-->
					<li class="TabbedPanelsTab" tabindex="0" style="border-bottom:0;">Reviews</li>    
				</ul>
				<div class="TabbedPanelsContentGroup">
					  <div class="TabbedPanelsContent">
						   <div class="sumit_base">
								<h1><?php echo stripslashes($row_deal['title']); ?></h1> 
						   </div>
								<?php echo stripslashes($row_deal['description']); ?>
					  </div>
					  <?php /*?><div class="TabbedPanelsContent">
							<div class="additional_information_base">
								<?php echo stripslashes($row_cms['content_desc']); ?>
							</div>          
					  </div><?php */?>		
					  <div class="TabbedPanelsContent">
							<div class="reviews_base">
								<form name="rateform" method="post" action="deal_detail.php?productid=<?=$_REQUEST['productid']?>" onsubmit="return validate_feedback();">
									<input name="productid" id="productid" type="hidden" value="<?=$_REQUEST['productid']?>" />
									<table width="680" border="0" align="center" cellpadding="0" cellspacing="0" class="reply_box">
									
									<tr>
									<td width="200"><strong style="font-size:14px; color:#ff6600; display:inline-block; padding-bottom:10px;">Detailed Product Rating </strong></td>
									<td>&nbsp;</td>
									</tr>
									
								 <tr>
							    <td><strong>Item as described</strong></td>
								<td>
									<input type="hidden" name="item_rating" value="<?=$row_basic['rate_item']?>" id="item_rating" />
										<?php
											for($i=1; $i<=10; $i++)
											{
											if($row_basic['counter'] == '')
											{
												$counter = 1;
											}
											else
											{
												$counter = $row_basic['counter'];
											}
												if($i <= $row_basic['rate_item']/$counter)
												{
										?>
											<img name=i<?=$i?> class=star onmouseover="selstar(<?=$i?>,'item_rating','i')" onclick="setrate(<?=$i?>,'item_rating','i')" src="images/star2.gif">&nbsp;&nbsp;
										<?php
										}
										else
										{
										?>
											<img name=i<?=$i?> class=star onmouseover="selstar(<?=$i?>,'item_rating','i')" onclick="setrate(<?=$i?>,'item_rating','i')" src="images/star1.gif">&nbsp;&nbsp;
										<?php
										}
										}
										?>
										<span style="font: normal 12px/18px Arial, Helvetica, sans-serif;">(Rate It)</span>		
									</td>
								</tr>                
								
								
				
									
														<tr>
									<td valign="top"><strong>Write Comment</strong></td>
									<td><textarea name="feedbk_cont" cols="38" rows="5"></textarea></td>
									</tr>
								<tr>
								 <td>
								 <?php
								 if($_REQUEST['feedbk_btn']!=''){
								 ?>
								 <font color="#FF0000">Your rating successfully submitted.</font> 
								 <?php } ?>
								 </td>
									<td><input name="feedbk_btn" type="submit" value="Submit"/></td>
								</tr>
						  </table>
	    						</form>
							</div>           
					  </div>
				   	  <div class="clear"></div>      
				</div>
			</div>
			
			<div class="clear"></div>
			
			<div class="latest_deal" id="bottom" style="margin-top: 10px;">
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
								  <?php $sqlprod = mysql_fetch_array(mysql_query("SELECT * FROM ".TABLE_PRODUCT." where `product_id` = '".$_REQUEST['productid']."'")); ?>
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
					 $sel_fdbk = "select * from ".FEEDBACK." where productid='".$_REQUEST['productid']."'";
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
				  
		</div>
		
		<?php
			include("includes/rightcol.php");
		?>
		
	</div>
	
</div>
<?php
	include("includes/footer.php");
?>
