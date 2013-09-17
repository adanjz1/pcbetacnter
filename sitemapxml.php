 <?php

	require_once("config.inc.php");

	require_once("class/Database.class.php");

	require_once("class/pagination.class.php");

	require_once("includes/functions.php");
	require_once("class/class.xml.sitemap.generator.php");
	

	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);			

	$db->connect();

	
  $entries[] = new xml_sitemap_entry('/', '1.00', 'hourly');
  $entries[] = new xml_sitemap_entry('/category.php', '0.9', 'daily');
  $entries[] = new xml_sitemap_entry('/store_brand.php', '0.9', 'daily');
  $entries[] = new xml_sitemap_entry('/cms.php?content_id=9', '0.9', 'daily');
  $entries[] = new xml_sitemap_entry('/deal.php', '0.9', 'daily');
  $entries[] = new xml_sitemap_entry('/coupon.php', '0.9', 'daily');
  $entries[] = new xml_sitemap_entry('/cms.php?content_id=18', '0.9', 'daily');
  $entries[] = new xml_sitemap_entry('/cms.php?content_id=19', '0.9', 'daily');
  $entries[] = new xml_sitemap_entry('/cms.php?content_id=20', '0.9', 'daily');
  $entries[] = new xml_sitemap_entry('/cms.php?content_id=21', '0.9', 'daily');
  $entries[] = new xml_sitemap_entry('/cms.php?content_id=22', '0.9', 'daily');
  $entries[] = new xml_sitemap_entry('/cms.php?content_id=23', '0.9', 'daily');
  $entries[] = new xml_sitemap_entry('/cms.php?content_id=24', '0.9', 'daily');
  $entries[] = new xml_sitemap_entry('/cms.php?content_id=25', '0.9', 'daily');

 

   $SelectMainCategory=mysql_query("SELECT * FROM ".MANAGE_E_CATEGORY." WHERE cat_id=0 ORDER BY in_order asc");

		  while($ArrayMainCategory=mysql_fetch_array($SelectMainCategory)){
		  
		         $SelectSubCategory=mysql_query("SELECT * FROM ".MANAGE_E_CATEGORY." WHERE cat_id='".$ArrayMainCategory['id']."' ORDER BY in_order asc"); 

            while($ArraySubCategory=mysql_fetch_array($SelectSubCategory)){
		  
		  
				$entries[] = new xml_sitemap_entry('/deal_store_category.php?category='.  $ArraySubCategory['id'], '0.9', 'daily');
			}
			
			
		  
		  }
  
  
 
  // set up the xml generator config object
  $conf = new xml_sitemap_generator_config();
  $conf->setDomain('pccounter.net');
  $conf->setPath('/var/chroot/home/content/75/9711075/html/');
  $conf->setFilename('sitemap.xml');
  $conf->setEntries($entries);
 
  // instantiate and execute
  $generator = new xml_sitemap_generator($conf);
  $generator->write(); // or $generator->toString();

?>