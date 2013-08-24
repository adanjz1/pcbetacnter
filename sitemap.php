<?php
	include("includes/header.php");
?>
<style>
iframe {
	width: 100px !important;
	height: auto;
}
</style>

<div id="maincontent">
  <div class="topbox">
    <div class="topbox_1">
      <h1>Most Popular Categories on PCcounter.net</h1>
      <p>You're just one click away from unbeatable savings from all your favorite stores and brands. Pick a category below and we'll show you the best savings:</p>
    </div>
    <div class="topbox_r"><img src="images/like.gif" alt="" width="81" height="22" />&nbsp;&nbsp;&nbsp; <img src="images/g+.gif" alt="" width="75" height="22" /></div>
  </div>
  <div class="clear"></div>
  <div id="content">
    <div class="leftcol"> 
      <!--<img src="images/left_product.jpg" alt="" width="807" height="1789" border="0"/>-->
      <div class="latest_deal">
        <div class="left_top">
          <h1>Site Map</h1>
        </div>
        <div class="left_mid">
        <div class="categories"><h1 style="color:#000;">CATEGORIES</h1></div>
        <div class="clear"></div>
         <?php
		 $SelectMainCategory=mysql_query("SELECT * FROM ".MANAGE_E_CATEGORY." WHERE cat_id=0 ORDER BY in_order asc");
		  while($ArrayMainCategory=mysql_fetch_array($SelectMainCategory)){
		  ?>
          <div class="categories">
         
           <a href="deal_store_category.php?category=<?php echo $ArrayMainCategory['id'];?>"><h1><?php echo $ArrayMainCategory['category_name']; ?></h1></a>
            <div>
             <ul>
            <?php $SelectSubCategory=mysql_query("SELECT * FROM ".MANAGE_E_CATEGORY." WHERE cat_id='".$ArrayMainCategory['id']."' ORDER BY in_order asc"); 
            while($ArraySubCategory=mysql_fetch_array($SelectSubCategory)){
			?>
             
                <li><a href="deal_store_category.php?category=<?php echo $ArraySubCategory['id'];?>"><?php echo $ArraySubCategory['category_name'];?></a></li>
               
               <?php } ?> 
                </ul>
            </div>
            <div class="clear"></div>
          </div>
          <?php } ?>
          <div class="clear"></div>
          <div class="categories"><h1 style="color:#000;">Special Features</h1></div>
          <div class="categories">
        	<h1>BROWSE THE LATEST SAVINGS</h1>
            <div>
            	<ul>
                			<li><a href="<?php echo SITE_URL; ?>coupon.php">Coupon Codes</a></li>  
							<li><a href="<?php echo SITE_URL; ?>deal.php">Deals & Clearance</a></li>  
							<li><a href="<?php echo SITE_URL; ?>cms.php?content_id=18">Local Offers</a></li>  
							<li><a href="<?php echo SITE_URL; ?>cms.php?content_id=19">Grocery Coupons</a></li> 
							<li><a href="<?php echo SITE_URL; ?>cms.php?content_id=20">Free Offers</a></li>
							<li><a href="<?php echo SITE_URL; ?>cms.php?content_id=21">Travel</a></li>
							<li><a href="<?php echo SITE_URL; ?>cms.php?content_id=22">Computers</a></li>
							<li><a href="<?php echo SITE_URL; ?>cms.php?content_id=23">Software</a></li>     
							<li><a href="<?php echo SITE_URL; ?>cms.php?content_id=24">Home & Kitchen</a></li>
							<li><a href="<?php echo SITE_URL; ?>cms.php?content_id=25">Credit Cards</a></li> 
                 </ul>       		     
						  
                
                
              </div>
           	 <div class="clear"></div>
             
        <div class="clear"></div>
    </div>
    <div class="categories">
        	<h1>GET STARTED</h1>
            <div>
            	<ul>
                				<li><a href="<?php echo SITE_URL; ?>category.php">Categories</a></li>
								<li><a href="<?php echo SITE_URL; ?>store_brand.php">Brands</a></li>
								<li><a href="<?php echo SITE_URL; ?>store_brand.php">Stores</a></li>
								<li><a href="<?php echo SITE_URL; ?>cms.php?content_id=9">Savings Guides</a></li>
								<li><a href="<?php echo SITE_URL; ?>/blog/">Blog</a></li>	 
                 </ul>       		     
						  
                
                
              </div>
           	 <div class="clear"></div>
             
        <div class="clear"></div>
    </div>
    <div class="categories">
        	<h1>TOP STORES & BRANDS</h1>
            <div>
            	<ul>
						   	  <?php
							  	$sql_store_brand = "select * from ".MANAGE_DEAL_SOURCE." where is_active = 1 order by deal_source_id asc limit 0, 12";
								$res_store_brand = mysql_query($sql_store_brand);
								while($row_store_brand = mysql_fetch_array($res_store_brand))
								{
							  ?>
									  <li><a href="<?php echo SITE_URL; ?>deal_store_category.php?brand=<?php echo $row_store_brand['deal_source_id']; ?>"><?php echo stripslashes($row_store_brand['deal_source_name']); ?></a></li>	
							  <?php
							  	 }
							  ?>	
						  </ul>       		     
						  
                
                
              </div>
           	 <div class="clear"></div>
             
        <div class="clear"></div>
    </div>
    <div class="categories">
    <h1>Home</h1>
            <div>
            	<ul>
                				
            <?php
			$sqlfooter = "select * from pc_counter_manage_content where is_active = 1 and content_id != 12 and content_id != 13 and content_id != 13 and content_id != 14 and content_id != 15 and content_id != 16 and content_id != 17";
							$resfooter = mysql_query($sqlfooter);
							while($rowfooter = mysql_fetch_array($resfooter)){
						  ?>
						  		<li><a href="<?php echo SITE_URL; ?>cms.php?content_id=<?php echo $rowfooter['content_id']; ?>"><?php echo $rowfooter['content_name']; ?></a> </li>  
						  <?php
						  	}
						  ?>
                 </ul>       		     
						  
                
                
              </div>
           	 <div class="clear"></div>
             
        <div class="clear"></div>
    </div>
    
    
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
