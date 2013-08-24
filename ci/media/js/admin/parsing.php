<?php
$file = "http://www.unifiedinfotech.net/pc_counter/admin/xml/OnSale-Product_Catalog.xml";

$curr_tag = "";
$curr_data = "";
$pro_name = "";
$pro_sku = "";
function startElement($parser, $name, $attrs) 
{
	global $curr_tag;
    $curr_tag = strtolower($name);
}

function endElement($parser, $name){
	global $curr_tag,$curr_data,$pro_name,$pro_sku;
	if("name"==$curr_tag){
		$pro_name = trim($curr_data);
		$curr_data = "";
		return;
	}
	if("sku"==$curr_tag){
		$pro_sku = trim($curr_data);
		$curr_data = "";
		return;
	}
	$end_tag = strtolower($name);
	if("product"==$end_tag){
		echo "Product<br>";
		echo "name: ".$pro_name."<br>";
		echo "sku: ".$pro_sku."<br>";
		return;
	}
}
function characterData($parser, $data) 
{
	global $curr_tag,$curr_data;
	
	if("name"==$curr_tag){
		$curr_data.=$data;
		return;
	}
	if("sku"==$curr_tag){
		$curr_data.=$data;
		return;
	}
}


$xml_parser = xml_parser_create();
xml_set_element_handler($xml_parser, "startElement", "endElement");
xml_set_character_data_handler($xml_parser, "characterData");

if (!($fp = fopen($file, "r"))) {
    die("could not open XML input");
}

while ($data = fread($fp, 10000)) {
    if (!xml_parse($xml_parser, $data, feof($fp))) {
        die(sprintf("XML error: %s at line %d",
                    xml_error_string(xml_get_error_code($xml_parser)),
                    xml_get_current_line_number($xml_parser)));
    }
}
xml_parser_free($xml_parser);
?> 