<?php
 
    /* Example usage of the Amazon Product Advertising API */
    include("amazon_api_class.php");
 
    $obj = new AmazonProductAPI();
 
    try
    {
        /* Returns a SimpleXML object */
         $result = $obj->searchProducts("X-Men Origins",
                                       AmazonProductAPI::DVD,
                                       "TITLE");
									   
		print_r($result);
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
    }
 
    print_r($result);
 
?>