<?php
	include("includes/header.php");
?>
<div id="maincontent">
	<div class="topbox">
		<div class="topbox_1">
			<h1>
				Most Popular Categories on PCcounter.net
			</h1>
			<p>
				You're just one click away from unbeatable savings from all your favorite stores and brands. 
				Pick a category below and we'll show you the best savings:
			</p>
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

			<div class="fb-like" data-href="http://www.unifiedinfotech.net/pc_counter/" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true" style="float: right; width: 81px; margin: 0 auto;"></div>

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
				<div class="left_top"><h1>All category</h1></div>
				<div class="left_mid">
					<?php
						$items = 12;
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
						
						$sql_category = "select * from ".MANAGE_E_CATEGORY." where is_active = 1 and cat_id = 0 order by in_order asc ".$GLOBALS[sql_page]."";
						
						$sqlStrAux = "SELECT count(*) as total FROM ".MANAGE_E_CATEGORY." where is_active = 1 and cat_id = 0";
						$aux = mysql_fetch_assoc(mysql_query($sqlStrAux));
						
						$res_category = mysql_query($sql_category.$limit);
						$num_category = mysql_num_rows($res_category);
						if($num_category != '')
						{
							if($aux['total']>0)
							{
								$p = new pagination;
								$p->Items($aux['total']);
								$p->limit($items);
								$p->target($target);
								$p->currentPage($page);
								$p->calculate();
								$p->changeClass("pagination");	
								while($row_category = mysql_fetch_array($res_category))
								{
					?>
									<div class="category_box">
										<div class="category_top">
                                            <ul>
                                              <li class="dc"><a style="height:31px; width:187px; display:inline-block;"><?php echo $row_category['category_name']; ?></a>
													<ul>
											  		<?php
														$sql_sub_category = "select * from ".MANAGE_E_CATEGORY." where cat_id = '".$row_category['id']."' and is_active = 1 order by category_name desc";
														$res_sub_category = mysql_query($sql_sub_category);
														$num_sub_category = mysql_num_rows($res_sub_category);
														if($num_sub_category != 0)
														{
															while($row_sub_category = mysql_fetch_array($res_sub_category))
															{
													?>
																<li>
																	<a href="<?php echo SITE_URL; ?>deal_store_category.php?category=<?php echo $row_sub_category['id']; ?>"><?php echo $row_sub_category['category_name']; ?></a>
																</li>
													<?php	
															}
														}
													?>
													</ul>
                                             </li>
                                           </ul>
										</div>
										<div class="category_mid" style="text-align:center;">
											<?php
												if($row_category['cat_image'] == "")
												{
											?>
												<a href="<?php echo SITE_URL; ?>deal_store_category.php?category=<?php echo $row_category['id']; ?>"><img src="images/noImage.jpg" alt="" width="147" height="133" border="0"/></a>
												<?php /*?><a href="<?php echo SITE_URL; ?>deal_sub_category.php?category=<?php echo $row_category['id']; ?>"><img src="images/noImage.jpg" alt="" width="147" height="133" border="0"/></a><?php */?>
											<?php
												}
												else
												{
											?>
												<a href="<?php echo SITE_URL; ?>deal_store_category.php?category=<?php echo $row_category['id']; ?>"><img src="<?php echo SITE_URL; ?>upload/category/thumbnail/thumb_<?php echo $row_category['cat_image']; ?>" alt="" width="157" height="133" border="0"/></a>
												<?php /*?><a href="<?php echo SITE_URL; ?>deal_sub_category.php?category=<?php echo $row_category['id']; ?>"><img src="<?php echo SITE_URL;?>upload/<?php echo $row_category['cat_image']; ?>" alt="" width="147" height="133" border="0"/></a><?php */?>
											<?php
												}
											?>
										</div>
										<div class="category_bot"></div>
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
									<div class="clear"></div>
									<div style="float:right; margin: 0 0 15px 0;"><?php $p->show();?></div>
					<?php
							}
						}
						else
						{
					?>
								<div class="category_box">
									<span style="color:#FF0000;"><?php echo "NO CATEGORIES ARE THERE."; ?></span>
								</div>
					<?php
						}
					?>
				</div>
				<div class="left_bot"></div>
			</div>
			<div class="clear"></div>
			<!--<div class="latest_deal">
				<div class="category_bg">
					<h1>Computers</h1>
					<div style="padding: 0 18px 0 0;">
						<a href="#">Computer Bags & Accessories</a> | 
						<a href="#">Computer Monitors</a> | 
						<a href="#">Computer Networking</a> | 
						<a href="#">Desktop Computers</a> | 
						<a href="#">Hardware & Peripherals</a> | 
						<a href="#">Ink & Toner</a> | 
						<a href="#">Laptops</a> | 
						<a href="#">Printers & Office Electronics</a> | 
						<a href="#">Tablets & eReaders</a> |
					</div>
					<div class="clear"></div>
					<div>
						<span><a href="#">All stores for Computers</a></span>
					</div>
					<h1>Entertainment</h1>
					<div style="padding: 0 18px 0 0;">
						<a href="#">Attractions & Tours</a> | 
						<a href="#">Dining Discounts</a> | 
						<a href="#">Event Tickets</a> | 
						<a href="#">Fast Food |</a> |
					</div>
					<div class="clear"></div>
					<div>
						<span><a href="#">All Entertainment companies</a></span>
					</div>
					<h1>Software</h1>
					<div style="padding: 0 18px 0 0;">
						<a href="#">Anti-spyware</a> | 
						<a href="#">Antivirus</a> | 
						<a href="#">Audio & Video Editing</a> | 
						<a href="#">Complete Protection</a> | 
						<a href="#">Graphics & Photo Editing</a> | 
						<a href="#">Internet Security Suite</a> | 
						<a href="#">Maintenance & Utilities</a> | 
						<a href="#">Online Backup</a> | 
						<a href="#">Parental Control</a> | 
						<a href="#">Personal Finance</a> | 
						<a href="#">Productivity</a> | 
						<a href="#">Tax Preparation</a> | 
						<a href="#">Web Design & Development</a> |
					</div>
					<div class="clear"></div>
					<div>
						<span><a href="#">All Software companies</a></span>
					</div>
				</div>
				<div class="category_bg">
					<h1>Credit Cards</h1>
					<div style="padding: 0 18px 0 0;">
						<a href="#">Airline Miles Credit Cards</a> | 
						<a href="#">Balance Transfer Credit Cards</a> | 
						<a href="#">Cash Back Cards</a> | 
						<a href="#">Charge Cards</a> | 
						<a href="#">Gas Cards</a> | 
						<a href="#">Limited Credit History Cards</a> | 
						<a href="#">Low APR Cards</a> | 
						<a href="#">No Annual Fee</a> | 
						<a href="#">Points Cards</a> | 
						<a href="#">Poor Credit</a> | 
						<a href="#">Prepaid/Debit Cards</a> | 
						<a href="#">Rewards Cards</a> | 
						<a href="#">Small Business Cards</a> | 
						<a href="#">Student Cards</a> | 
						<a href="#">Travel & Hotel Cards</a> |
					</div>
					<div class="clear"></div>
					<div>
						<span><a href="#">All Credit Cards companies</a></span>
					</div>
					<h1>Financial services</h1>
					<div style="padding: 0 18px 0 0;">
						<a href="#">Credit Reporting</a> | 
						<a href="#">Identity Theft Protection</a> | 
						<a href="#">Online Banking & Checking</a> | 
						<a href="#">Online Trading</a> |
					</div>
					<div class="clear"></div>
					<div>
						<span><a href="#">All Financial Services companies</a></span>
					</div>
				</div>
				<div class="category_bg">
					<h1>Electronics</h1>
					<div style="padding: 0 18px 0 0;">
						<a href="#">Cameras & Camcorders</a> | 
						<a href="#">Car Audio, Video & GPS</a> | 
						<a href="#">Cell Phone Accessories</a> | 
						<a href="#">Cell Phones & Plans</a> | 
						<a href="#">Electronics Accessories</a> | 
						<a href="#">Gadgets</a> | 
						<a href="#">Home Theater & Audio</a> | 
						<a href="#">MP3 & Media Players</a> | 
						<a href="#">TVs & HDTVs</a> |
					</div>
					<div class="clear"></div>
					<div>
						<span><a href="#">All stores for Electronics</a></span>
					</div>
					<h1>Flowers & Gifts</h1>
					<div style="padding: 0 18px 0 0;">
						<a href="#">Coffee</a> | 
						<a href="#">Collectibles</a> | 
						<a href="#">Flower Delivery</a> | 
						<a href="#">Gift Certificates and Gift Cards</a> | 
						<a href="#">Gift Clubs</a> | 
						<a href="#">Personalized Gifts</a> | 
						<a href="#">Photo Gifts & Prints</a> | 
						<a href="#">Specialty Food & Gifts</a> | 
						<a href="#">Stationery & Invitations</a> | 
						<a href="#">Wine</a> |
					</div>
					<div class="clear"></div>
					<div>
						<span><a href="#">All stores for Flowers & Gifts</a></span>
					</div>
					<h1>Music & Video</h1>
					<div style="padding: 0 18px 0 0;">
						<a href="#">DVD & Game Rentals</a> | 
						<a href="#">DVDs & Blu-rays</a> | 
						<a href="#">MP3 Music Services</a> | 
						<a href="#">Musical Instruments</a> | 
						<a href="#">Online Media</a> | 
						<a href="#">Sheet Music</a> |
					</div>
					<div class="clear"></div>
					<div>
						<span><a href="#">All Software companies</a></span>
					</div>
				</div>
			</div>-->
		</div>
		
		<?php
			include("includes/rightcol.php");
		?>
	
	</div>
</div>
<?php
	include("includes/footer.php");
?>