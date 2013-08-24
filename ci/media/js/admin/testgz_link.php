<?php
//fopen("test.xml","w");
set_time_limit(0);

$arr = array("http://productdata.zanox.com/exportservice/v1/rest/18939525C1929432841.xml?ticket=CCFC91472561713F8A35A466542E92402F82FE97D7983D4032E564DF510EC042&gZipCompress=null");


/* gets the data from a URL */
function get_zip_data($url,$dest_zip_files)
{
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
$output = curl_exec($ch);

$fh = fopen($dest_zip_files, 'w');
fwrite($fh, $output);
fclose($fh);
}



function get_xml_dt($dest_xml,$dest_zip)
{
fopen($dest_xml,"w");
$handle = fopen($dest_xml, 'a');
 $zh = gzopen($dest_zip,'r')
   or die("can't open: $php_errormsg");
 while ($line = gzgets($zh,10240)) {
    // $line is the next line of uncompressed data, up to 1024 bytes 
    fwrite($handle, $line);
  }
 gzclose($zh) or die("can't close: $php_errormsg");
 fclose($handle);

}

$file_dir = dirname($_SERVER['SCRIPT_FILENAME']);


foreach ($arr as $file)
{

############ Get File name ################
preg_match("|([^\/]+)$|",$file,$s);
list($file_s,$xml) = explode(".",$s[1]);
if(empty($file_s))
$file_s = uniqid();
$dest_zip_files = $file_dir."/gzip/".$file_s.".xml.gz";
$dest_xml = $file_dir."/xml/".$file_s.".xml";
//$dest_json = $file_dir."/xml/".$file_s.".json";
#######################################
$returned_zip_content = get_zip_data($file,$dest_zip_files);
get_xml_dt($dest_xml,$dest_zip_files);
}



?> 