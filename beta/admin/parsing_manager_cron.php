<?php 
//mail('santanu.uss@gmail.com', 'Test cron', 'Test message', 'santanu.patra85@gmail.com');
require_once("/var/chroot/home/content/75/9711075/html/admin/include/top_menu.php"); 

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
	
?>