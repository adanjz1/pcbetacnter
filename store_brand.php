<?php
	include("includes/header.php");
?>

<div id="maincontent">
	<div class="topbox">
		<div class="topbox_1">
			<h1>
				<?php echo $rowtitle['title_name']; ?>
			</h1>
			<p>
				<?php echo $rowtitle['title_desc']; ?>
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
				<div class="left_top">
					<h1>Newest Online Coupons</h1>
				</div>
				<div class="left_mid">
					<div id='carousel_container' class="carousel_container">
						<div id='left_scroll' style="width:28px; float:left; z-index:1000;"><a href='javascript:slide("left");'><img src='images/left.png' width="26" height="60" border="0" /></a></div>
						<div id='carousel_inner' style="width:715px; float:left; z-index:0; overflow:hidden; padding-left:2px;">
							<ul id='carousel_ul'>
								<?php
									$sql_store_brand = "select * from ".MANAGE_DEAL_SOURCE." where is_active = 1 order by deal_source_id asc";
									$res_store_brand = mysql_query($sql_store_brand);
									while($row_store_brand = mysql_fetch_array($res_store_brand))
									{
								?>
										<li>
											<a href="<?php echo SITE_URL; ?>deal_store_category.php?brand=<?php echo $row_store_brand['deal_source_id']; ?>">
												<?php
													if($row_store_brand['deal_source_logo_url'] == "")
													{
												?>
														<img src="images/noImage.jpg" width="86" height="60" border="0" />
												<?php
													}
													else
													{
												?>
														<img src="<?php echo SITE_URL; ?>upload/brand/thumbnail/thumb_<?php echo $row_store_brand['deal_source_logo_url']; ?>" width="86" height="60" border="0" />
												<?php
													}
												?>
											</a>
										</li>
								<?php
									}
								?>		            
							</ul>
						</div>
						<div id='right_scroll' style="width:30px; float:left;"><a href='javascript:slide("right");'><img src='images/right.png' width="26" height="60" border="0"/></a></div>
						<input type='hidden' id='hidden_auto_slide_seconds' value=0 />
					</div>
				</div>
				<div class="left_bot"></div>
			</div>
			<div class="clear"></div>
			<div class="latest_deal">
				<div class="left_top">
					<h1>Stores</h1>
				</div>
				<div class="left_mid">
					<div class="alpha_text">
						<ul>
							<li>
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=numeric">0-9</a>  |  
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=a">a</a>  |  
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=b">b</a>  |  
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=c">c</a>  |  
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=d">d</a>  |  
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=e">e</a>  |  
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=f">f</a>  |  
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=g">g</a>  |  
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=h">h</a>  |  
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=i">i</a>  |  
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=j">j</a>  |  
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=k">k</a>  |  
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=l">l</a>  |  
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=m">m</a>  |  
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=n">n</a>  |  
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=o">o</a>  |  
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=p">p</a>  |  
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=q">q</a>  |  
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=r">r</a>  |  
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=s">s</a>  |  
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=t">t</a>  |  
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=u">u </a> |  
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=v">v </a> |  
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=w">w</a>  |  
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=x">x</a>  |  
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=y">y </a> |   
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=z">z </a> |  
							</li>
							<li style="margin: 6px 0;">
								<a href="<?php echo SITE_URL; ?>store_brand.php?brand_name=all">
									<img src="images/all_btn.gif" alt="" width="89" height="22" border="0"/>
								</a>
							</li>
						</ul>
					</div>
					<div class="clear"></div>
					<div class="store_bg">
						<?php
							$items = 21;
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
							
							$srch_str = $_REQUEST['brand_name'];
							if($srch_str != '')
							{
								if($srch_str == "numeric")
								{
									$numeric = "-0-1-2-3-4-5-6-7-8-9";
									$numeral = explode("-",$numeric);
									for($i = 1; $i < count($numeral); $i++)
									{
										$sql_store_and_brand = "select * from ".MANAGE_DEAL_SOURCE." where is_active = 1 and deal_source_name like '$numeral[$i]%' order by deal_source_id asc ".$GLOBALS[sql_page]."";
										$sqlStrAux = "SELECT count(*) as total FROM ".MANAGE_DEAL_SOURCE." where is_active = 1 and deal_source_name like '$numeral[$i]%'";
									}
								}
								elseif($srch_str == "all")
								{
									$sql_store_and_brand = "select * from ".MANAGE_DEAL_SOURCE." where is_active = 1 order by deal_source_id asc ".$GLOBALS[sql_page]."";
									$sqlStrAux = "SELECT count(*) as total FROM ".MANAGE_DEAL_SOURCE." where is_active = 1";
								}
								else
								{
									$sql_store_and_brand = "select * from ".MANAGE_DEAL_SOURCE." where is_active = 1 and deal_source_name like '$srch_str%' order by deal_source_id asc ".$GLOBALS[sql_page]."";
									$sqlStrAux = "SELECT count(*) as total FROM ".MANAGE_DEAL_SOURCE." where is_active = 1 and deal_source_name like '$srch_str%'";
								}
							}
							else
							{
								$sql_store_and_brand = "select * from ".MANAGE_DEAL_SOURCE." where is_active = 1 order by deal_source_id asc ".$GLOBALS[sql_page]."";
								$sqlStrAux = "SELECT count(*) as total FROM ".MANAGE_DEAL_SOURCE." where is_active = 1";
							}
							
							
							$aux = mysql_fetch_assoc(mysql_query($sqlStrAux));
							
							$res_store_and_brand = mysql_query($sql_store_and_brand.$limit);
							$num_store_and_brand = mysql_num_rows($res_store_and_brand);
							if($num_store_and_brand != 0)
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
									while($row_store_and_brand = mysql_fetch_array($res_store_and_brand))
									{
						?>
							
							<div class="store_box">
								<ul class="store_box_left">
									<li>
										<!--<img src="images/dell1.gif" alt="" width="102" height="42" border="0"/>-->
										<?php
											if($row_store_and_brand['deal_source_logo_url'] == "")
											{
										?>
											<a href="<?php echo SITE_URL; ?>deal_store_category.php?brand=<?php echo $row_store_and_brand['deal_source_id']; ?>"><img src="images/noImage.jpg" alt="" width="102" height="42" border="0"/></a>
										<?php
											}
											else
											{
										?>
											<a href="<?php echo SITE_URL; ?>deal_store_category.php?brand=<?php echo $row_store_and_brand['deal_source_id']; ?>"><img src="<?php echo SITE_URL; ?>upload/brand_next/thumbnail/thumb_<?php echo $row_store_and_brand['deal_source_logo_url']; ?>" alt="" width="102" height="42" border="0"/></a>
										<?php
											}
										?>
									</li>
                                    </ul>
                                    <ul class="store_box_right">
									  <li>
										<a href="<?php echo SITE_URL; ?>deal_store_category.php?brand=<?php echo $row_store_and_brand['deal_source_id']; ?>"><?php echo $row_store_and_brand['deal_source_name']; ?></a>
									</li>
								</ul>
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
								<div class="store_box">
									<span style="color:#FF0000;"><?php echo "NO STORES OR BRANDS ARE THERE."; ?></span>
								</div>
						<?php
							}
						?>
					</div>
				</div>
				<div class="left_bot"></div>
			</div>
			<div class="clear"></div>
			
			<?php
				$sqlcms = "select * from ".MANAGE_CONTENT." where content_id = 11 and is_active=1";
				$rescms = mysql_query($sqlcms);
				$rowcms = mysql_fetch_array($rescms);
			?>
						
			<div class="best_stores">
			   <div class="sumit_base">
					<h1>
						<?php echo stripslashes($rowcms['content_name']); ?>
					</h1> 
			   </div>
					
			   <div class="clear"></div>
			   <div>
					<!--<p>
						With so many fantastic retailers to choose from, picking the best wasn't easy. These guys really stand out from the pack, and if they're not part of your regular savings circuit, it's definitely time to check them out.<br/><br/>
		
						No matter what you're shopping for, we've got you covered with great deals. Check out these top categories and the stellar stores that go with them:
					</p>
					<ul>
						<li>Cutting-edge electronics - Best Buy, Dell, and HP</li>
						<li>Specialty gifts like flowers and treats - FTD and Personal Creations</li>
						<li>Clothes from the hottest designers - Dillard's, JCPenney, Macy's, and Nordstrom</li>
						<li>Vacations, including airfare and hotels - Expedia and Travelocity</li>
						<li>Furnishings and décor - Home Depot, Kohl's, Overstock, and Pottery Barn</li>
						<li>Books, movies, and video games - Amazon, Target, and Walmart</li>
					</ul>-->
					<?php
						echo stripslashes($rowcms['content_desc']);
					?>
			   </div>
			   <div class="clear"></div>
			   <div style="margin: 16px auto;">Thank you for saving with PCCounter.Net! </div>   
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
