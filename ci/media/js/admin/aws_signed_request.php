<?php
 
function  aws_signed_request($region,
                             $params,
                             $public_key,
                             $private_key,
                             $associate_tag)
{
 
    $method = "GET";
    $host = "ecs.amazonaws.".$region;
    $uri = "/onca/xml";
 
 
    $params["Service"]          = "AWSECommerceService";
    $params["AWSAccessKeyId"]   = $public_key;
    $params["AssociateTag"]     = $associate_tag;
 
    $params["Timestamp"]        = gmdate("Y-m-d\TH:i:s\Z");
    $params["Version"]          = "2009-03-31";
 
    /* The params need to be sorted by the key, as Amazon does this at
      their end and then generates the hash of the same. If the params
      are not in order then the generated hash will be different from
      Amazon thus failing the authentication process.
    */
    ksort($params);
 
    $canonicalized_query = array();
 
    foreach ($params as $param=>$value)
    {
        $param = str_replace("%7E", "~", rawurlencode($param));
        $value = str_replace("%7E", "~", rawurlencode($value));
        $canonicalized_query[] = $param."=".$value;
    }
 
    $canonicalized_query = implode("&", $canonicalized_query);
 
    $string_to_sign = $method."\n".$host."\n".$uri."\n".
                            $canonicalized_query;
 
    /* calculate the signature using HMAC, SHA256 and base64-encoding */
    $signature = base64_encode(hash_hmac("sha256", 
                                  $string_to_sign, $private_key, True));
 
    /* encode the signature for the request */
    $signature = str_replace("%7E", "~", rawurlencode($signature));
 
    /* create request */
    $request = "http://".$host.$uri."?".$canonicalized_query."&Signature=".$signature;
 
    /* I prefer using CURL */
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$request);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
 
    $xml_response = curl_exec($ch);
 
    if ($xml_response === False)
    {
        return False;
    }
    else
    {
        /* parse XML and return a SimpleXML object, if you would
           rather like raw xml then just return the $xml_response.
         */
        $parsed_xml = @simplexml_load_string($xml_response);
        return ($parsed_xml === False) ? False : $parsed_xml;
    }
}
?>