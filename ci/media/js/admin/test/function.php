<?php

function getData($url,$id)
{
	$file_zip = 'abc_'.$id.'.xml.gz';
	$fp = fopen("download/$file_zip", "w"); 
	$request = curl_init();
	$headers = array('Content-type: application/x-gzip','Connection: Close');
	curl_setopt($request, CURLOPT_URL, $url);
	curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($request, CURLOPT_TIMEOUT, 0);
	curl_setopt($request, CURLOPT_CONNECTTIMEOUT,0);
	curl_setopt($request, CURLOPT_HTTPHEADER,$headers);
	curl_setopt($request, CURLOPT_FAILONERROR, true);
	curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($request, CURLOPT_AUTOREFERER, true);
	curl_setopt($request, CURLOPT_BINARYTRANSFER,true);
	
	curl_setopt($request, CURLOPT_FILE, $fp);
	
	$zipFile = curl_exec($request);
	
	/*$linkToXmlFile = 'download/'.$file_zip;
	$xmlfile = "download/file_".$id.".xml"; 
	$fp = fopen($xmlfile, "a") or die("Couldn't open $file for writing!");
	
	$zh = gzopen($linkToXmlFile,'r') or die("can't open: $php_errormsg");
	while ($line = gzgets($zh,10240)) 
	{
		fwrite($fp, $line);
	}*/
	$dest_zip = 'download/'.$file_zip;
	$dest_xml = "download/file_".$id.".xml"; 
	fopen($dest_xml,"w");
	$handle = fopen($dest_xml, 'a');
	 $zh = gzopen($dest_zip,'r')
	   or die("can't open: $php_errormsg");
	 while ($line = gzgets($zh,12000)) {
		// $line is the next line of uncompressed data, up to 1024 bytes 
		fwrite($handle, $line);
	  }
	 gzclose($zh) or die("can't close: $php_errormsg");
	 fclose($handle);
	
	//chmod($xmlfile,777);
	//$line1 = '</description></product></catalog>';
	//fwrite($fp, $line1);
	
	
	
	
	//gzclose($zh) or die("can't close: $php_errormsg");
	//fclose($fp);
	
	
	$doc = simplexml_load_file('download/file_'.$id.'.xml');
	$data = json_decode(json_encode($doc), TRUE);
	//@unlink('download/'.$file_zip); 
	$arrData= array();
	for($i=0; $i<count($data["product"]); $i++)
	{
		$arrData[$i]["site_name"] = $data["product"][$i]["programname"];
		$arrData[$i]["site_url"] = $data["product"][$i]["programurl"];
		$arrData[$i]["cat_name"] = $data["product"][$i]["catalogname"];
		$arrData[$i]["product_title"] = $data["product"][$i]["name"];
		$arrData[$i]["description"] = $data["product"][$i]["description"];
		$arrData[$i]["currency"] = $data["product"][$i]["currency"];
		$arrData[$i]["deal_price"] =str_replace(',','',$data["product"][$i]["price"]);
		$arrData[$i]["actual_price"] =str_replace(',','',$data["product"][$i]["retailprice"]);
		$arrData[$i]["img_url"] =$data["product"][$i]["imageurl"];
		$arrData[$i]["deal_start_time"] =date('Y-m-d H:i:s',strtotime($data["product"][$i]["startdate"]));
		$arrData[$i]["deal_end_time"] =date('Y-m-d H:i:s',strtotime($data["product"][$i]["enddate"]));
		$arrData[$i]["buy_url"] = $data["product"][$i]["buyurl"];
		
		$lat_long = $data["product"][$i]["publisher"];
		$lat_long_arr = explode(' ',$lat_long);
		$arrData[$i]["latitude"] = $lat_long_arr[0];
		$arrData[$i]["longitude"] = $lat_long_arr[1];
		
	}
	return $arrData;
}

function gzDeleteAll()
{
	$files = glob('download/*'); 
	foreach($files as $file)
	{ 
		if(is_file($file))
		@unlink($file); 
	}	
}




?>