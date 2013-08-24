<?php 
require_once("include/top_menu.php"); 

if($_REQUEST['parsing']!='')
{
	/*$sql_delete_dealsourcename = "TRUNCATE TABLE ".MANAGE_DEAL_SOURCE."";
	$res_delete_dealsourcename = mysql_query($sql_delete_dealsourcename);
	
	$sql_delete_dealcategory = "TRUNCATE TABLE ".MANAGE_E_CATEGORY."";
	$res_delete_dealcategory = mysql_query($sql_delete_dealcategory);
	
	$sql_delete_deal_maincategory = "TRUNCATE TABLE ".MANAGE_E_MAIN_CATEGORY."";
	$res_delete_deal_maincategory = mysql_query($sql_delete_deal_maincategory);
	
	$sql_delete_deal_product = "TRUNCATE TABLE ".TABLE_PRODUCT."";
	$res_delete_deal_product = mysql_query($sql_delete_deal_product);

	$sql_delete_feedback = "TRUNCATE TABLE ".FEEDBACK."";
	$res_delete_feedback = mysql_query($sql_delete_feedback);
	
	$sql_delete_rating = "TRUNCATE TABLE ".RATING."";
	$res_delete_rating = mysql_query($sql_delete_rating);
	
	$sql_delete_review = "TRUNCATE TABLE ".TABLE_REVIEW."";
	$res_delete_review = mysql_query($sql_delete_review);*/
	
	$output1 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/wondershare.php >/dev/null &"); //executing
	$output2 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/ipswitch.php >/dev/null &"); //executing
	$output3 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/best_buy_product_catalog.php >/dev/null &"); //executing
	$output4 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/hp_home_office_store.php >/dev/null &"); //executing
	$output5 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/miniinthebox_product_catalog.php >/dev/null &"); //executing, but no data
	$output6 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/miniinthebox_ru_pc.php >/dev/null &"); //executing, but no data
	$output7 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/inksmile.php >/dev/null &"); //executing
	$output8 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/tigergps.php >/dev/null &"); //executing
	$output9 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/spot_product_catalog.php >/dev/null &"); //executing
	$output10 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/hp_home_office_store2.php >/dev/null &"); //executing
	$output11 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/miniinbox_deskpc.php >/dev/null &"); //executing, but no data
	$output12 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/allbattery_product_catalog.php >/dev/null &"); //executing
	$output13 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/miniinbox_cad_product.php >/dev/null &"); //executing, but no data
	$output14 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/godaddy_product_catalog.php >/dev/null &"); //executing
	$output15 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/cyberlink_affiliate.php >/dev/null &"); //executing
	$output16 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/panda_security_product_feed.php >/dev/null &"); //executing
	$output17 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/lenovo_uk_product.php >/dev/null &"); //executing
	$output18 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/miniinbox_pt_product_catalog.php >/dev/null &"); //executing, but no data
	$output19 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/ipswitch_nl_product.php >/dev/null &"); //executing
	$output20 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/eforchina_product_catalog.php >/dev/null &"); //executing
	$output21 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/carrotink.php >/dev/null &"); //executing
	$output22 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/hp_home_office_store3.php >/dev/null &"); //executing, but no data
	$output23 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/factoryextreme.php >/dev/null &"); //executing
	$output24 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/ipswitch_product_catalog.php >/dev/null &"); //executing
	$output25 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/hp_home_office_store_photography.php >/dev/null &"); //executing
	$output26 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/inksmile_catridge.php >/dev/null &"); //executing
	$output27 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/digitalrev_camera.php >/dev/null &"); //executing
	$output28 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/best_buy_partsstore.php >/dev/null &"); //executing
	$output29 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/miniinbox_product_catalog2.php >/dev/null &"); //executing
	$output30 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/tomtom_product_catalog.php >/dev/null &"); //executing
	$output31 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/digitalrev_camera2.php >/dev/null &"); //executing
	$output32 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/core_corporation_product.php >/dev/null &"); //executing
	$output33 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/best_buy_movie.php >/dev/null &"); //executing
	$output34 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/digitalrev_camera3.php >/dev/null &"); //executing
	$output35 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/miniinbox_fr_product_catalog.php >/dev/null &"); //executing, but no data
	$output36 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/miniinbox_top_selling_product.php >/dev/null &"); //executing, but no data
	$output37 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/inkjet_toner.php >/dev/null &"); //executing
	$output38 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/onsale_daily_deal.php >/dev/null &"); //executing
	$output39 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/neato_product_catalog.php >/dev/null &"); //executing
	$output40 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/iskin_product_catalog.php >/dev/null &"); //executing
	$output41 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/miniinbox_it_pc.php >/dev/null &"); //executing, but no data
	$output42 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/hp_home_office_store_notebook.php >/dev/null &"); //executing
	$output43 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/wondershare_product.php >/dev/null &"); //executing
	$output44 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/miniinbox_pc.php >/dev/null &"); //executing, but no data
	$output45 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/miniinbox_nl_pc.php >/dev/null &"); //executing, but no data
	$output46 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/acronis_product.php >/dev/null &"); //executing
	$output47 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/linotype_product.php >/dev/null &"); //executing
	$output48 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/panda_security2.php >/dev/null &"); //executing
	$output49 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/muvee_product_catalog.php >/dev/null &"); //executing
	$output50 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/secondipity_product_catalog.php >/dev/null &"); //executing
	$output51 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/hp_home_office_store_printer.php >/dev/null &"); //executing
	$output52 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/paretologic_product_catalog.php >/dev/null &"); //executing
	$output53 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/hp_home_office_store_handheld.php >/dev/null &"); //executing
	$output54 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/cj/hp_home_office_store_desktop.php >/dev/null &"); //executing
	
	$output55 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/linksynergy_deal.php >/dev/null &"); //executing
	$output56 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/linksynergy_coupon.php >/dev/null &"); //executing
	$output57 = exec("/web/cgi-bin/php5_3 -q /var/chroot/home/content/75/9711075/html/admin/sharesale/shareasale.php >/dev/null &"); //executing
	
}
?>			

<!-- Background wrapper -->

<div id="bgwrap">



<!-- Main Content -->

<div id="content">

	<div id="main">

		<h1>Welcome To XML and API Parsing Manager</h1>

		<form name="frm_pars" id="frm_pars" action="<?=$_SERVER['file:///E|/alldeals_client_server/modify_02_06_2011/admin/PHP_SELF']?>" method="post">
			<table border="0" cellpadding="0" cellspacing="10" align="left" width="100%">
	
			<tr>
	
				<td align="left" style="font-family:Verdana, Arial, Helvetica, sans-serif;">1> http://datatransfer.cj.com/datatransfer/files/1805267/outgoing/productcatalog/116371/HP_Home_Home_Office_Store-Product_Catalog.xml.gz</td>
	
			</tr>
	
			<tr>
	
				<td align="left" style="font-family:Verdana, Arial, Helvetica, sans-serif;">2> http://datatransfer.cj.com/datatransfer/files/1805267/outgoing/productcatalog/116371/CarrotInk_com_Save_a_Bunch_on_Printing_Supplies-Product_Catalog.xml.gz</td>
	
			</tr>
	
			<tr>
	
				<td align="left" style="font-family:Verdana, Arial, Helvetica, sans-serif;">3> http://datatransfer.cj.com/datatransfer/files/1805267/outgoing/productcatalog/116371/OnSale-OnSale_Daily_Deal_Coupon_Catalog.xml.gz</td>
	
			</tr>
	
			<tr>
	
				<td align="left" style="font-family:Verdana, Arial, Helvetica, sans-serif;">4> http://datatransfer.cj.com/datatransfer/files/1805267/outgoing/productcatalog/116371/Best_Buy-Product_Catalog.xml.gz</td>
	
			</tr>
	
			<tr>
	
				<td align="left" style="font-family:Verdana, Arial, Helvetica, sans-serif;">5> http://datatransfer.cj.com/datatransfer/files/1805267/outgoing/productcatalog/116371/All_Battery_com-Product_Catalog.xml.gz</td>
	
			</tr>
	
			<tr>
				<td align="left" style="font-family:Verdana, Arial, Helvetica, sans-serif;">6> http://datatransfer.cj.com/datatransfer/files/1805267/outgoing/productcatalog/116371/HP_Home_Home_Office_Store-Promotions.xml.gz</td>
			</tr>
			
			<tr>
				<td align="left" style="font-family:Verdana, Arial, Helvetica, sans-serif;">7> http://datatransfer.cj.com/datatransfer/files/1805267/outgoing/productcatalog/116371/OnSale-Product_Catalog.xml.gz</td>
			</tr>
			
			<tr>
				<td align="left" style="font-family:Verdana, Arial, Helvetica, sans-serif;">8> http://datatransfer.cj.com/datatransfer/files/1805267/outgoing/productcatalog/116371/Best_Buy-Movies_and_Music_Feed.xml.gz</td>
			</tr>
			
			<tr>
				<td align="left" style="font-family:Verdana, Arial, Helvetica, sans-serif;">9> http://datatransfer.cj.com/datatransfer/files/1805267/outgoing/productcatalog/116371/HP_Home_Home_Office_Store-Ink_Toner_Paper.xml.gz</td>
			</tr>
			
			<tr>
				<td align="left" style="font-family:Verdana, Arial, Helvetica, sans-serif;">10> http://datatransfer.cj.com/datatransfer/files/1805267/outgoing/productcatalog/116371/HP_Home_Home_Office_Store-Notebooks.xml.gz</td>
			</tr>
			
			<tr>
				<td align="left" style="font-family:Verdana, Arial, Helvetica, sans-serif;">11> http://datatransfer.cj.com/datatransfer/files/1805267/outgoing/productcatalog/116371/HP_Home_Home_Office_Store-Desktops.xml.gz</td>
			</tr>
			
			<tr>
				<td align="left" style="font-family:Verdana, Arial, Helvetica, sans-serif;">12> http://datatransfer.cj.com/datatransfer/files/1805267/outgoing/productcatalog/116371/HP_Home_Home_Office_Store-Printers.xml.gz</td>
			</tr>
			
			<tr>
				<td align="left" style="font-family:Verdana, Arial, Helvetica, sans-serif;">13> http://datatransfer.cj.com/datatransfer/files/1805267/outgoing/productcatalog/116371/HP_Home_Home_Office_Store-Handhelds.xml.gz</td>
			</tr>
			
			<tr>
				<td align="left" style="font-family:Verdana, Arial, Helvetica, sans-serif;">14> http://datatransfer.cj.com/datatransfer/files/1805267/outgoing/productcatalog/116371/HP_Home_Home_Office_Store-Photography.xml.gz</td>
			</tr>
			
			<tr>
				<td align="left" style="font-family:Verdana, Arial, Helvetica, sans-serif;">15> http://datatransfer.cj.com/datatransfer/files/1805267/outgoing/productcatalog/116371/OnSale-Hot_Deal_Feed_Latest_Rebate_Offers_Updated_Daily_.xml.gz</td>
			</tr>
			
			<tr>
				<td align="left" style="font-family:Verdana, Arial, Helvetica, sans-serif;">16> Deals from LinkSynergy</td>
			</tr>
			
			<tr>
				<td align="left" style="font-family:Verdana, Arial, Helvetica, sans-serif;">17> Coupons from Sharesale</td>
			</tr>
			
			<tr>
	
				<td align="left"><input type="submit" class="button" name="parsing" value="XML and API Parsing"/></td>
	
			</tr>
			
	
			</table>
		</form>
		

	</div>

</div>

<!-- End of Main Content -->



<!-- Sidebar -->



<?php require_once("include/left_menu.php"); ?>				



<!-- End of Sidebar -->



</div>

<!-- End of bgwrap -->



<!-- Footer -->

<?php require_once("include/footer.php"); ?>				

<!-- End of Footer -->