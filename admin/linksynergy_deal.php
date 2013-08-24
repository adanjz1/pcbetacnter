<?php

        set_time_limit(0); 

    
	$keyword = array("DVD Player", "Computer", "Xerox", "Printer", "telephone", "ipaq", "Notebook" ,"Antivirus", "Keyboard","Mouse", "HP", "Mac", "Sony", "Samsung", "Amazon");
	
	$totalRecords = 1000;
        $i=0;
	for($k=0; $k<count($keyword); $k++)
	{
            $totalPages = 2;
            $page = 1;
            while($page <= $totalPages){
		$xmlLink = "http://productsearch.linksynergy.com/productsearch?token=9c572896dedff9f2f640edaceeff1e37ead2a7a844ceb2ca7360d19f89807f07&keyword=".$keyword[$k]."&MaxResults=100&pagenumber=".$page."&sort=retailprice&sorttype=asc&sort=productname&sorttype=asc";
                $xml = simpleXML_load_file($xmlLink,"SimpleXMLElement",LIBXML_NOCDATA); 
                foreach($xml->item as $product){
                    $k = $product->mid; //MERCHANT ID
                    $r = $product->merchantname; //MERCHANT NAME (IF NOT EXISTS, ADD)
                    var_dump($product);    
                    $i++;
                    if($i == $totalRecords){
                        die();
                    }
                    
                }
                $totalPages = $xml->TotalPages;
            }
	}
?>			
