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
	<div class="clear"></div><?php						$catid =0;						$cat_header ="All category";												if(isset($_REQUEST['category']) and is_numeric($_REQUEST['category']) and  $_REQUEST['category'] !=0)						{							$catid = mysql_real_escape_string($_REQUEST['category']);							$catres= mysql_query( "select * from ".MANAGE_E_CATEGORY." where is_active = 1 and id = '". $catid ."' and type='d' order by in_order asc ".$GLOBALS[sql_page]."" );							$cCat = mysql_fetch_array($catres);							$cat_header = $cCat['category_name'];													}						?>
	<div id="content">
		<div class="leftcol">
			<div class="latest_deal">
				<div class="left_top"><h1><?=$cat_header ?></h1></div>
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
						
						$sql_category = "select * from ".MANAGE_E_CATEGORY." where is_active = 1 and cat_id = '". $catid ."' and type='d' order by in_order asc ".$GLOBALS[sql_page]."";
						$sqlStrAux = "SELECT count(*) as total FROM ".MANAGE_E_CATEGORY." where is_active = 1 and cat_id = '". $catid."'";
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
                                              <li class="dc"><a style="height:31px; width:187px; display:inline-block;"  											  <?php 											  if(!$catid){ 												echo 'href="category.php?category='.$row_category['id'].'"';											  }											  ?> ><?php echo $row_category['category_name']; ?></a>											  <?php 											  if(!$catid){											  ?>
													<ul>
											  		<?php
														$sql_sub_category = "select * from ".MANAGE_E_CATEGORY." where cat_id = '".$row_category['id']."' and is_active = 1 and type='d' order by in_order asc";
														$res_sub_category = mysql_query($sql_sub_category);
														$num_sub_category = mysql_num_rows($res_sub_category);
														if($num_sub_category != 0)
														{
															while($row_sub_category = mysql_fetch_array($res_sub_category))
															{
													?>
																
													<?php	
															}
														}
													?>
													</ul>																									<?php } ?>
                                             </li>
                                           </ul>
										</div>
										<div class="category_mid" style="text-align:center;">
											<?php
												if($row_category['cat_image'] == "")
												{
											?>
												<a href="<?php echo SITE_URL; ?>deal_store_subcategory.php?category=<?php echo $row_category['id']; ?>"><img src="images/noImage.jpg" alt="" width="147" height="133" border="0"/></a>
												<?php /*?><a href="<?php echo SITE_URL; ?>deal_sub_category.php?category=<?php echo $row_category['id']; ?>"><img src="images/noImage.jpg" alt="" width="147" height="133" border="0"/></a><?php */?>
											<?php
												}
												else
												{													if($catid){											?>																										<a href="<?php echo SITE_URL; ?>deal_store_category.php?category=<?=$catid ?>&subcategory=<?php echo $row_category['id']; ?>"><img src="<?php echo SITE_URL;?>upload/<?php echo $row_category['cat_image']; ?>" alt="" width="147" height="133" border="0"/></a>											<?php																																							}													else {
											?>		
												<a href="<?php echo SITE_URL; ?>deal_store_subcategory.php?category=<?php echo $row_category['id']; ?>"><img src="<?php echo SITE_URL; ?>upload/category/thumbnail/thumb_<?php echo $row_category['cat_image']; ?>" alt="" width="157" height="133" border="0"/></a>
												<?php /*?><a href="<?php echo SITE_URL; ?>deal_sub_category.php?category=<?php echo $row_category['id']; ?>"><img src="<?php echo SITE_URL;?>upload/<?php echo $row_category['cat_image']; ?>" alt="" width="147" height="133" border="0"/></a><?php */?>
											<?php													}
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
		</div>
		
		<?php
			include("includes/rightcol.php");
		?>
	
	</div>
</div>
<?php
	include("includes/footer.php");
?>