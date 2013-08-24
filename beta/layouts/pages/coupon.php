

<script>
function chkCatCoupan()
{
	var valId=document.getElementById('cat_id').value;
	if(valId!='')
		window.location='coupon.php?cat_id='+valId;
	else
		window.location='coupon.php';
}	
</script>
		<div class="leftcol">
			<div class="latest_deal">
				<div class="left_top">
					<h1>Online Coupons<div style="float:right; margin-top:12px;">
                    <?php
					$sqlCat="SELECT * FROM ".MANAGE_E_CATEGORY." where cat_id = 0 and is_active='1' and type='c' ORDER BY in_order asc";
					$resCat=mysql_query($sqlCat);
					?>
                    	<select name="cat_id" id="cat_id" onchange="chkCatCoupan();">
                        	<option value="">-- Select Category --</option>
                            <?php
							while($rowCat=mysql_fetch_assoc($resCat))
							{
							?>
                            <option value="<?php echo $rowCat['id']; ?>" <?php if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id']==$rowCat['id']) { ?> selected="selected" <?php } ?>><?php echo htmlentities($rowCat['category_name']); ?></option>
							<?php
							}
							?>
                        </select>
                    </div></h1>
                    
				</div>
				<div class="left_mid">
					<?php
						$items = 9;
						$page = 1;
						$condition = "";	
						if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id']!='')
						{
							$condition = " and cat_id='".$_REQUEST['cat_id']."'";
						}
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

						$sql_coupon = "select * from ".TABLE_PRODUCT." where deal_coupon = 'c' and is_active = 1 ".$condition." order by product_id desc ".$GLOBALS[sql_page]."";
						
						$sqlStrAux = "SELECT count(*) as total FROM ".TABLE_PRODUCT." where deal_coupon = 'c' and is_active = 1 ".$condition."";
						$aux = mysql_fetch_assoc(mysql_query($sqlStrAux));
						
						$res_coupon = mysql_query($sql_coupon.$limit);
						$num_coupon = mysql_num_rows($res_coupon);
						if($num_coupon != 0)
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
								//$i=1;
								while($row_coupon = mysql_fetch_array($res_coupon))
								{
									//echo $i."<br>";
									//$i++;
									$sqlcoupon_sourcename = "select * from ".MANAGE_DEAL_SOURCE." where deal_source_id = ".$row_coupon['deal_sources_id']."";
									$rescoupon_sourcename = mysql_query($sqlcoupon_sourcename);
									$rowcoupon_sourcename = mysql_fetch_array($rescoupon_sourcename);
					?>
									<div class="coupon_box">
										<div class="coupon" style="margin: 10px auto 0 6px;">
											<?php
											if($row_coupon['image_url'] != '')
											{											
												
											?>
												<img src="<?php echo $row_coupon['image_url']; ?>" alt="" border="0" class="border"/>
											<?php
												
												
											}
											else
											{
											?>
												<img src="images/noImage.jpg" alt="" width="162" height="77" class="border" border="0"/>
											<?php
											}
											?>
										</div>
										<div class="coupon" style="width: 184px; padding: 0 0 0 19px;">
											<ul>
												<li><h1><?php echo wrptxt(stripslashes(($row_coupon['display_name'])?$row_coupon['display_name']: $row_coupon['title']),50); ?></h1></li>
												<li><span>From: <?php echo stripslashes($rowcoupon_sourcename['deal_source_name']); ?></span></li>
											</ul>
										</div>
										<div class="coupon" style="width: 230px;">
											<ul>
												<?php if($row_coupon['actual_price'] != '0.00') { ?>
													<li>List Price: <strong>$<?php echo $row_coupon['actual_price']; ?></strong></li>
												<?php } ?>
												<li>Price: <span class="redtext">$<?php echo $row_coupon['deal_price']; ?></span> <strong>+ FREE SHIPPING</strong></li>
												<?php
													$savings = ($row_coupon['actual_price'] - $row_coupon['deal_price']);
													$savingspercentage = (($savings * 100) / $row_coupon['actual_price']);
												?>
												<li>You Save: <span class="redtext">(<?php echo round($savingspercentage,2); ?>%)</span></li>
											</ul>
										</div>
										<div class="coupon" style="border:0; width: 160px;">
                                    
										<?php /*?><div class="hot_dealbtn3"><a href="<?php echo $row_coupon['deal_url']; ?>" onclick="window.open('<?php echo SITE_URL; ?>offerid.php?action=review&productid=<?php echo $row_coupon['product_id']; ?>','popup','width=560,height=700,scrollbars=no,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0');" target="_blank">Reveal Code</a> <span><?php echo substr($row_coupon['sku'], -2); ?></span></div><?php */?>
                                        
										  <div class="buy">
												<div class="pricing-container"></div>
												<div class="button-outer code" data-href="<?php echo $row_coupon['deal_url']; ?>">
												   <a target="_blank" onclick="window.open('<?php echo SITE_URL; ?>offerid.php?action=review&productid=<?php echo $row_coupon['product_id']; ?>','popup','width=560,height=700,scrollbars=no,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0');">
														<div class="button code">
															<div class="coupon-code">
																<?php 
																	if($row_coupon['sku'] == "") 
																	{ 
																		echo "FREE"; 
																	} 
																	else 
																	{ 
																		echo substr($row_coupon['sku'], -2); 
																	} 
																?>
															</div>
														 	<div style="width: 93px;" class="button-inner code">Reveal Code</div>
														 	<div style="left: 95px;" class="peelie">&nbsp;</div>
														</div>
												   </a>
												</div>
										  </div>
                                        
									</div>
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
						else
						{
					?>
									<div class="coupon_box">
										<span style="color:#FF0000; padding: 0 0 0 320px;"><?php echo "NO COUPONS ARE THERE."; ?></span>
									</div>
					<?php
						}
					?>
				</div>
				<div class="left_bot"></div>
			</div>
		</div>
