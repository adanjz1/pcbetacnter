<?php require_once("include/top_menu.php"); ?>
<?php
if($_REQUEST['convert']!='')
{
	$sql = mysql_query("SELECT P.*, E.* FROM ".TABLE_PRODUCT." as P, ".TABLE_PRODUCT_EXTRA." as E WHERE E.product_id=P.product_id");
	while($row = mysql_fetch_array($sql))
	{
		$id = $row['product_id'];
		//$address = $row['address'];
		$market_city = $row['market_city'];
		
		if($market_city!='')
		{
			/*if(strpos($address,"</adility:location>")==false)
			{*/
				$str = str_replace("/","%2F",str_replace("#","%23",str_replace(" ","+",trim($market_city))));
				$xml = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$str."&sensor=false";
			/*}
			else
			{
				$str_1 = str_replace("<%2Fadility:location>","",str_replace("/","%2F",str_replace("#","%23",str_replace(" ","+",trim($address)))));
				$str = substr(strrchr($str_1,">"),1);
				$xml = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$str."&sensor=false";
			}*/
			
			// create a new object
			$parser = new SimpleLargeXMLParser();
			// load the XML
			$parser->loadXML($xml);
			$pr= $parser->parseXML("//result/geometry/location");
			//print_r($pr);
			$location = $pr[0];
			//print_r($location);
			$lat = $location[lat][0];
			$lng = $location[lng][0];
			
			echo $data['longitude']=$lng;
			echo "||";			
			echo $data['latitude']=$lat;
			echo "<br>";
			$id=$db->query_update(TABLE_PRODUCT_EXTRA, $data, "product_id='".$id."'");
		}
	}
}
?>
<!-- Background wrapper -->
<div id="bgwrap">

<!-- Main Content -->
<div id="content">
	<div id="main">
		<h1>Welcome To Convert Address to Longitude and Latitude</h1>
		<form name="frm_cont" id="frm_cont" action="<?=$_SERVER['PHP_SELF']?>" method="post">
		<table border="0" cellpadding="0" cellspacing="10" align="left" width="100%">
		<tr>
			<td align="left"><input type="submit" class="button" name="convert" value="Convert Address"/></td>
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