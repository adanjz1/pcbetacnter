<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
       error_reporting(E_ALL);  
       ini_set('display_errors','On');
        if(empty($_GET['secure']) || $_GET['secure'] != md5('securepccounter123456')){
            die('Unauthorized Request');
        }
    //}
    //public function linkShare() {
        $this->load->model('Deal');
        $this->load->model('Source');
        $this->load->model('Category');
        
        $this->Deal->set_activation(); //deactivate all deals
        
    if(empty($_GET['debug']) || $_GET['debug'] == 'linkshare'){
        
        set_time_limit(0);
        $keyword = array("MP3", "Camera", "Software", "Hardware", "DVD Player", "Computer", "Xerox", "Printer", "telephone", "ipaq", "Notebook", "Antivirus", "Keyboard", "Mouse", "HP", "Mac", "Sony", "Samsung", "Amazon");

        $totalRecords = 1000; //AUXILIAR
        $i = 0;
        $sleepBetweenPages = 5; //Every 5 pages, sleeps 1 Second
        $sleepI = 0;
        for ($k = 0; $k < count($keyword); $k++) {
            $totalPages = 1;
            $page = 1;

            $r = 0;
            while ($page <= $totalPages) {

                $xmlLink = "http://productsearch.linksynergy.com/productsearch?token=9c572896dedff9f2f640edaceeff1e37ead2a7a844ceb2ca7360d19f89807f07&keyword=" . $keyword[$k] . "&MaxResults=100&pagenumber=" . $page . "&sort=retailprice&sorttype=asc&sort=productname&sorttype=asc";
                $xml = simpleXML_load_file($xmlLink, "SimpleXMLElement", LIBXML_NOCDATA);
                
                foreach ($xml->item as $product) {
                    if (intVal($product->price) > 0) {
                        $longDesc = htmlentities($product->description->long);
                        $shortDesc = htmlentities($product->description->short);
                        $params = array(
                            'title' => "$product->productname",
                            'description' => "$longDesc",
                            'short_description' => "$shortDesc",
                            'deal_url' => "$product->linkurl",
                            'image_url' => "$product->imageurl",
                            'deal_start_date' => str_replace('/', ' ', $product->createdon),
                            'deal_price' => $product->price,
                            'actual_price' => $product->saleprice,
                            'meta_keywords' => "$product->keywords",
                            'savings_amount' => $product->saleprice - $product->price,
                            'keywords' => "$product->keywords",
                            'sku' => "$product->sku"
                        );
                        $matchDeal = $this->Deal->findMatchDeals($params);
                        if (empty($matchDeal)) {
                            $SourceId = $this->Source->get_dealSourceIdByStr("$product->merchantname");
                            if (empty($SourceId)) {
                                $SourceId = $this->Source->set_newSource("$product->merchantname", $product->mid);
                            }
                            $params['deal_sources_id'] = $SourceId;
                            
                            if($product->price > 0 && !strpos($product->linkurl,'language%3Dfr-CA')){
                                
                            $params['cat_id'] = detectPosibleCat(array($product->productname,$longDesc,$product->keywords),$this);
                            $params['sub_cat_id'] = detectPosibleSubCat(array($product->productname,$longDesc),$params['cat_id'],$this);
                            $params['is_active'] = 1;
                            $this->Deal->set_deal($params);
                            }
                            //Search text in deal title
                        }else{
                            if(is_array($matchDeal)){
                                $this->Deal->set_activation($matchDeal[0]->id,1);
                            }else{
                                $this->Deal->set_activation($matchDeal->id,1);
                            }
                            
                        }
                    }
                }

                $page++;
            }
            if ($xml->TotalMatches > 100) {
                $totalPages = $xml->TotalPages;
            }
            $sleepI++;
            if ($sleepBetweenPages == $sleepI) {
                $sleepI = 0;
                sleep(1);
            }
        }
    }
    
   // }
    //public function linkShareCoupon() {
//        $this->load->model('Deal');
//        $this->load->model('Source');
    if(empty($_GET['debug']) || $_GET['debug'] == 'linkshareCoupons'){
        sleep(2);
        $xmlLink = "http://couponfeed.linksynergy.com/coupon?token=9c572896dedff9f2f640edaceeff1e37ead2a7a844ceb2ca7360d19f89807f07&category=10|13|27|29";
        $xml = simpleXML_load_file($xmlLink, "SimpleXMLElement", LIBXML_NOCDATA);
        //
        //$prod->category can be array
        foreach ($xml->link as $product) {
            $longDesc = htmlentities($product->offerdescription);
            $params = array(
                'title' => "$product->offerdescription",
                'description' => "$longDesc",
                'deal_url' => "$product->clickurl",
                'deal_start_date' => $product->offerstartdate,
                'deal_end_date' => str_replace('ongoing', '', $product->offerenddate),
                'coupon_code' => "$product->couponcode",
                'image_url' => "$product->imageurl"
            );
            $matchDeal = $this->Deal->findMatchDeals($params);
            if (empty($matchDeal)) {
                $SourceId = $this->Source->get_dealSourceIdByStr("$product->advertisername");
                if (empty($SourceId)) {
                    $SourceId = $this->Source->set_newSource("$product->advertisername", $product->advertiserid);
                }
                $params['deal_sources_id'] = $SourceId;
                //Search text in deal title
                
                $params['cat_id'] = detectPosibleCat(array($product->offerdescription,$longDesc),$this);
                $params['sub_cat_id'] = detectPosibleSubCat(array($product->offerdescription,$longDesc),$params['cat_id'],$this);
                $params['is_active'] = 1;
                $this->Deal->set_deal($params);
            }else{
                 if(is_array($matchDeal)){
                    $this->Deal->set_activation($matchDeal[0]->id,1);
                }else{
                    $this->Deal->set_activation($matchDeal->id,1);
                }
            }
        }
    }
    
//    }
//
//    public function comissionJunction() {
//        $this->load->model('Deal');
//        $this->load->model('Source');
//        $this->load->model('Category');
    if(empty($_GET['debug']) || $_GET['debug'] == 'comissionJunction'){
        $dbug = 0;
        sleep(2);
        set_time_limit(0);
        $CJ_ID = '009d3d49b3a21ad21e29bc4e88997388512c6f3bc7a2396d33ddab99df3297f12a42f56699f46a92d4696ed1a32323ba08325dab5d62fcefd5f65dac9c68261445/2c605fac92d37ef9844de0dc2c72aec63a042a9aecedc8241b2b9301ab05b6ca040b826ae03916508a7b3beb226719a0cd9a5b05005f9fbb91bc976318972301';
        $advertisers = array('3015561', '2948661', '3054995', '2069963', '2758031', '1513033', '2743018', '1637643', '3776933', '1596784', '1957211', '2125808', '3124983', '1818328', '3274480', '2446104', '2395398', '242732', '3295320', '2728387', '2540350', '3800140', '1357495', '237343', '777292', '3718229', '1808802', '3144657', '3768420', '2461402', '3579991', '3132762', '2503677', '2906885', '2837956', '1983932', '1525519', '2452483', '1880125', '3194603', '3739663', '3410489', '2431611', '2443929', '2136193', '2292829', '2461829', '2641935', '3727174', '1097361', '1560854', '2381550', '998086', '2833145', '2529698', '3413608', '2503687', '3099532', '2461831', '1529833', '2057995', '1646298', '3692834', '2045991', '3413974', '1552894', '1826017');
        foreach ($advertisers as $advId) {
            $websiteid = '2033446';
            $pagenumber = 1;
            $howmany = 1000;
            $totalPages = 1;
            while ($pagenumber <= $totalPages) {
                $url = "https://product-search.api.cj.com/v2/product-search?website-id=$websiteid&advertiser-ids=$advId&page-number=$pagenumber&records-per-page=$howmany";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, FAlSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: ' . $CJ_ID));
                $curl_results = curl_exec($ch);
                curl_close($ch);
                $returnXML = simplexml_load_string($curl_results);
               
                foreach ($returnXML->products->product as $product) {
                    $bu = $product->{'buy-url'};
                    $iu = $product->{'image-url'};

                    $sp = intVal($product->{'sale-price'});
                    $mn = $product->{'manufacturer-name'};

                    $ms = $product->{'manufacturer-sku'};
                    $is = $product->{'in-stock'};
                    $an = $product->{'advertiser-name'};

                    $ai = $product->{'ad-id'};
                    $desc = utf8_decode($product->description);
                    $pname = utf8_decode($product->name);
                    $params = array(
                        'deal_url' => "$bu",
                        'image_url' => "$iu",
                        'actual_price' => $sp,
                        'deal_price' => $product->price,
                        'savings_amount' => $sp - $product->price,
                        'manufacturer' => "$mn",
                        'manufacturerid' => "$ms",
                        'instock' => "$is",
                        'sku' => "$product->sku"
                    );
                    $matchDeal = $this->Deal->findMatchDeals($params);
                    if (empty($matchDeal)) {
                        $SourceId = $this->Source->get_dealSourceIdByStr("$an");
                        if (empty($SourceId)) {
                            $SourceId = $this->Source->set_newSource("$an", $ai);
                        }
                        $params['description'] = "$desc";
                        $params['title'] = "$pname";
                        $params['deal_sources_id'] = $SourceId;
                        $fullCat = $product->{'advertiser-category'};
                        //****//
                        
                        $pcat = htmlentities(utf8_decode(substr($fullCat, 0, strpos($fullCat, '>'))));
                        $pcat = trim($pcat);
                        $catStr = str_replace(';',' ',$pcat);
                        if($product->price >0 && !strpos($bu,'language%3Dfr-CA')){
                            $params['cat_id'] = detectPosibleCat(array($pcat,$pname,$desc),$this);
                            $params['sub_cat_id'] = detectPosibleSubCat(array($pcat,$pname,$desc),$params['cat_id'],$this);
                            $params['is_active'] = 1;
                            $this->Deal->set_deal($params);
                        }
                        
                    }else{
                         if(is_array($matchDeal)){
                                $this->Deal->set_activation($matchDeal[0]->id,1);
                            }else{
                                $this->Deal->set_activation($matchDeal->id,1);
                            }
                    }
//                    var_dump($params);
//                    die();
                }
                $tm = 'total-matched';
                $totalProducts = $returnXML->products->attributes()->{$tm};
                $totalPages = intval($totalProducts) / 1000;
                $pagenumber++;
                sleep(10);
                
            }
        }
    }
//    }
//
//    public function shareSale() {
//        $this->load->model('Deal');
//        $this->load->model('Source');
//        $this->load->model('Category');
    if(empty($_GET['debug']) || $_GET['debug'] == 'shareSale'){
        sleep(2);
        set_time_limit(0);

        $myAffiliateID = '245502';
        $APIToken = "CcwWfQgGO569gCLn";
        $APISecretKey = "LGf0tk4t2KPcxz8jDTv0cf5j0YImni2z";
        $myTimeStamp = gmdate(DATE_RFC1123);

        $APIVersion = 1.7;
        $actionVerb = "couponDeals";
        $sig = $APIToken . ':' . $myTimeStamp . ':' . $actionVerb . ':' . $APISecretKey;

        $sigHash = hash("sha256", $sig);

        $myHeaders = array("x-ShareASale-Date: $myTimeStamp", "x-ShareASale-Authentication: $sigHash");

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://shareasale.com/x.cfm?affiliateId=$myAffiliateID&token=$APIToken&version=$APIVersion&action=$actionVerb&approvedonly=1&XMLFormat=1");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $myHeaders);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $returnResult = curl_exec($ch);

        if (!empty($returnResult)) {
                    
            $xml = simplexml_load_string($returnResult);
            
            foreach ($xml->dealcouponlistreportrecord as $product) {
                $image = ($product->bigimage=='http://')?'':$product->bigimage;
                        $params = array(
                            'title' => "$product->title",
                            'description' => "$product->description",
                            'deal_url' => "$product->trackingurl",
                            'image_url' => "$image",
                            'deal_start_date' => substr($product->startdate,0,strlen($product->startdate)-2),
                            'deal_end_date' => substr($product->enddate,0,strlen($product->enddate)-2),
                            'meta_keywords' => "$product->keywords",
                            'keywords' => "$product->keywords",
                            'coupon_code'=>"$product->couponcode"
                        );
                        $matchDeal = $this->Deal->findMatchDeals($params);
                        if (empty($matchDeal)) {
                            $SourceId = $this->Source->get_dealSourceIdByStr("$product->merchant");
                            if (empty($SourceId)) {
                                $SourceId = $this->Source->set_newSource("$product->merchant", $product->merchantid);
                            }
                            $params['deal_sources_id'] = $SourceId;
                            if(!strpos($product->trackingurl,'language%3Dfr-CA')){
                                $params['cat_id'] = detectPosibleCat(array($product->title,$product->description,$product->keywords),$this);
                                $params['sub_cat_id'] = detectPosibleSubCat(array($product->title,$product->description,$product->keywords),$params['cat_id'],$this);
                                $params['is_active'] = 1;
                                $this->Deal->set_deal($params);
                            }
                        }else{
                             if(is_array($matchDeal)){
                                $this->Deal->set_activation($matchDeal[0]->id,1);
                            }else{
                                $this->Deal->set_activation($matchDeal->id,1);
                            }
                        }
                }
        }

        curl_close($ch);
        }
    }
    
}


function detectPosibleCat($strings,$cron){
           $categories['1'] = array(
               array('points'=>'10',
                     'str'=> 'apple'),
               array('points'=>'15',
                     'str'=> 'notebook'),
               array('points'=>'15',
                     'str'=> 'laptop'),
               array('points'=>'10',
                     'str'=> 'acer'),
               array('points'=>'10',
                     'str'=> 'HP'),
               array('points'=>'7',
                     'str'=> 'refurbished'),
               array('points'=>'10',
                     'str'=> 'toshiba'),
               array('points'=>'10',
                     'str'=> 'Dell'),
               array('points'=>'10',
                     'str'=> 'Computer'),
               array('points'=>'10',
                     'str'=> 'Alienware'),
           );
           $categories['2'] = array(
               array('points'=>'10',
                     'str'=> 'apple'),
               array('points'=>'15',
                     'str'=> 'desktop'),
               array('points'=>'10',
                     'str'=> 'acer'),
               array('points'=>'10',
                     'str'=> 'HP'),
               array('points'=>'10',
                     'str'=> 'Dell'),
           );
           $categories['3'] = array(
               array('points'=>'10',
                     'str'=> 'nikon'),
               array('points'=>'10',
                     'str'=> 'canon'),
               array('points'=>'15',
                     'str'=> 'camera'),
               array('points'=>'7',
                     'str'=> 'Sony'),
               array('points'=>'10',
                     'str'=> 'Olympus'),
               array('points'=>'10',
                     'str'=> 'Panasonic'),
               array('points'=>'12',
                     'str'=> 'Photo'),
               array('points'=>'10',
                     'str'=> 'zoom'),
           );
           $categories['4'] = array(
               array('points'=>'10',
                     'str'=> 'jvc'),
               array('points'=>'15',
                     'str'=> 'camcorder'),
               array('points'=>'7',
                     'str'=> 'flip'),
               array('points'=>'7',
                     'str'=> 'sony'),
               array('points'=>'10',
                     'str'=> 'Panasonic'),
               array('points'=>'12',
                     'str'=> 'film'),
               array('points'=>'7',
                     'str'=> 'canon'),
           );
           $categories['5'] = array(
               array('points'=>'10',
                     'str'=> 'laser'),
               array('points'=>'10',
                     'str'=> 'inkjet'),
               array('points'=>'15',
                     'str'=> 'printer'),
               array('points'=>'7',
                     'str'=> 'brother'),
               array('points'=>'7',
                     'str'=> 'samsung'),
           );
           $categories['6'] = array(
               array('points'=>'10',
                     'str'=> 'game'),
               array('points'=>'10',
                     'str'=> 'gaming'),
               array('points'=>'15',
                     'str'=> 'nintendo'),
               array('points'=>'7',
                     'str'=> 'sony'),
               array('points'=>'7',
                     'str'=> 'xbox'),
               array('points'=>'7',
                     'str'=> 'playstation'),
               array('points'=>'7',
                     'str'=> 'psp'),
               array('points'=>'7',
                     'str'=> 'ps 3'),
           );
           $categories['7'] = array(
               array('points'=>'10',
                     'str'=> 'headset'),
               array('points'=>'10',
                     'str'=> 'keyboard'),
               array('points'=>'10',
                     'str'=> 'mouse'),
               array('points'=>'7',
                     'str'=> 'speaker'),
               array('points'=>'7',
                     'str'=> 'power adapter'),
               array('points'=>'7',
                     'str'=> 'webcam'),
               array('points'=>'3',
                     'str'=> 'bag'),
               array('points'=>'7',
                     'str'=> 'battery'),
               array('points'=>'7',
                     'str'=> 'cord'),
               array('points'=>'7',
                     'str'=> 'notebook cart'),
               array('points'=>'7',
                     'str'=> 'cart'),
               array('points'=>'7',
                     'str'=> 'notebook battery'),
               
               array('points'=>'7',
                     'str'=> 'Charging Cart'),
               array('points'=>'7',
                     'str'=> 'notebook carrying case'),
               array('points'=>'7',
                     'str'=> 'Laptop Portfolio'),
               array('points'=>'7',
                     'str'=> 'notebook carrying case'),
               array('points'=>'7',
                     'str'=> 'notebook sleeve'),
               array('points'=>'7',
                     'str'=> 'notebook carrying case'),
               
           );
           $categories['8'] = array(
               array('points'=>'10',
                     'str'=> 'case'),
               array('points'=>'10',
                     'str'=> 'monitor'),
               array('points'=>'10',
                     'str'=> 'motherboard'),
               array('points'=>'10',
                     'str'=> 'cpu'),
               array('points'=>'10',
                     'str'=> 'card'),
               array('points'=>'10',
                     'str'=> 'sound'),
               array('points'=>'10',
                     'str'=> 'video'),
               array('points'=>'10',
                     'str'=> 'ram'),
               array('points'=>'10',
                     'str'=> 'pcie'),
               array('points'=>'10',
                     'str'=> 'nvidia'),
               array('points'=>'10',
                     'str'=> 'ati'),
           );
           $categories['9'] = array(
               array('points'=>'10',
                     'str'=> 'cd'),
               array('points'=>'10',
                     'str'=> 'dvd'),
               array('points'=>'10',
                     'str'=> 'diskette'),
               array('points'=>'10',
                     'str'=> 'drive'),
               array('points'=>'10',
                     'str'=> 'hard drive'),
               array('points'=>'10',
                     'str'=> 'solid disk'),
           );
           $categories['10'] = array(
               array('points'=>'10',
                     'str'=> 'network'),
               array('points'=>'10',
                     'str'=> 'switch'),
               array('points'=>'10',
                     'str'=> 'router'),
               array('points'=>'10',
                     'str'=> 'ethernet'),
               array('points'=>'10',
                     'str'=> 'modem'),
               array('points'=>'10',
                     'str'=> 'Patch Cable'),
               array('points'=>'10',
                     'str'=> 'cat 6'),
           );
           $categories['11'] = array(
               array('points'=>'15',
                     'str'=> 'tablet'),
               array('points'=>'10',
                     'str'=> 'ipad'),
               array('points'=>'10',
                     'str'=> 'tab'),
               array('points'=>'10',
                     'str'=> 'sony'),
               array('points'=>'10',
                     'str'=> 'dell'),
               array('points'=>'10',
                     'str'=> 'samsung'),
               array('points'=>'10',
                     'str'=> 'hp'),
               array('points'=>'10',
                     'str'=> 'asus'),
               array('points'=>'10',
                     'str'=> 'acer'),
               array('points'=>'10',
                     'str'=> 'blackberry'),
           );
           
           $categories['12'] = array(
               array('points'=>'15',
                     'str'=> 'netbook'),
               array('points'=>'10',
                     'str'=> 'acer'),
               array('points'=>'10',
                     'str'=> 'asus'),
               array('points'=>'10',
                     'str'=> 'hp'),
               array('points'=>'10',
                     'str'=> 'lenovo'),
               array('points'=>'10',
                     'str'=> 'dell'),
               array('points'=>'10',
                     'str'=> 'sony'),
               array('points'=>'10',
                     'str'=> 'samsung'),
           );
           $categories['13'] = array(
               array('points'=>'15',
                     'str'=> 'home theatre'),
               array('points'=>'10',
                     'str'=> 'ipod'),
               array('points'=>'10',
                     'str'=> 'mp3'),
               array('points'=>'10',
                     'str'=> 'speaker'),
               array('points'=>'10',
                     'str'=> 'zune'),
               array('points'=>'10',
                     'str'=> 'headphone'),
               array('points'=>'10',
                     'str'=> 'music'),
               array('points'=>'10',
                     'str'=> 'surround'),
               array('points'=>'10',
                     'str'=> 'dolby'),
               array('points'=>'10',
                     'str'=> 'stereo'),
               array('points'=>'10',
                     'str'=> 'audio'),
               array('points'=>'10',
                     'str'=> 'sound'),
           );
           
           $categories['14'] = array(
               array('points'=>'10',
                    'str'=>'blackberry'),
               array('points'=>'10',
                    'str'=>'samsung'),
               array('points'=>'10',
                    'str'=>'galaxy'),
               array('points'=>'10',
                    'str'=>'iphone'),
               array('points'=>'10',
                    'str'=>'smartphone'),
               array('points'=>'10',
                    'str'=>'mobile'),
               array('points'=>'10',
                    'str'=>'phone'),
               array('points'=>'10',
                    'str'=>'LG'),
               array('points'=>'10',
                    'str'=>'htc'),
               array('points'=>'10',
                    'str'=>'nokia'),
               array('points'=>'6',
                    'str'=>'sony'),
               array('points'=>'10',
                    'str'=>'T-mobile'),
               array('points'=>'10',
                    'str'=>'Verizone'),
               array('points'=>'10',
                    'str'=>'AT&T'),
              
           );
          $categories['15'] = array(
               array('points'=>'5',
                     'str'=> 'gps'),
               array('points'=>'15',
                     'str'=> 'garmin'),
               array('points'=>'15',
                     'str'=> 'tomtom'),
               array('points'=>'7',
                     'str'=> 'maps'),
               array('points'=>'7',
                     'str'=> 'map'),
               array('points'=>'15',
                     'str'=> 'magellan'),
               array('points'=>'15',
                     'str'=> 'navigon'),
           );
          $categories['16'] = array(
               array('points'=>'10',
                     'str'=> 'tv'),
               array('points'=>'15',
                     'str'=> 'lcd'),
               array('points'=>'15',
                     'str'=> 'crt'),
               array('points'=>'10',
                     'str'=> 'led'),
               array('points'=>'10',
                     'str'=> 'sony'),
               array('points'=>'10',
                     'str'=> 'samsung'),
               array('points'=>'10',
                     'str'=> 'vizio'),
               array('points'=>'10',
                     'str'=> 'sanyo'),
               array('points'=>'10',
                     'str'=> 'toshiba'),
               array('points'=>'10',
                     'str'=> 'panasonic'),
               array('points'=>'10',
                     'str'=> 'sharp'),
               array('points'=>'10',
                     'str'=> 'smart'),
               array('points'=>'10',
                     'str'=> '3d'),
           );
           $categories['17'] = array(
               array('points'=>'10',
                     'str'=> 'kindle'),
               array('points'=>'10',
                     'str'=> 'amazon'),
               array('points'=>'10',
                     'str'=> 'ebook'),
               array('points'=>'10',
                     'str'=> 'kobo'),
               array('points'=>'10',
                     'str'=> 'nook'),
               array('points'=>'10',
                     'str'=> 'sony'),
           );
           $categories['18'] = array(
               array('points'=>'10',
                     'str'=> 'dvd'),
               array('points'=>'10',
                     'str'=> 'blueray'),
               array('points'=>'10',
                     'str'=> 'blu ray'),
               array('points'=>'10',
                     'str'=> 'movie'),
           );
           $categories['19'] = array(
               array('points'=>'10',
                     'str'=> 'flash'),
               array('points'=>'10',
                     'str'=> 'drive'),
               array('points'=>'10',
                     'str'=> 'ram'),
               array('points'=>'10',
                     'str'=> 'micro sd'),
               array('points'=>'10',
                     'str'=> 'memory stick'),
               array('points'=>'10',
                     'str'=> 'usd drive'),
               array('points'=>'10',
                     'str'=> 'ddr3'),
               array('points'=>'10',
                     'str'=> 'memory'),
               array('points'=>'10',
                     'str'=> 'memory'),
           );
           $categories['20'] = array(
               array('points'=>'10',
                     'str'=> 'hosting'),
               array('points'=>'10',
                     'str'=> 'server'),
               array('points'=>'10',
                     'str'=> 'godaddy'),
               array('points'=>'10',
                     'str'=> 'go daddy'),
               array('points'=>'10',
                     'str'=> 'bluehost'),
               array('points'=>'10',
                     'str'=> 'dreamhost'),
               array('points'=>'10',
                     'str'=> 'cloud'),
               array('points'=>'10',
                     'str'=> 'domain'),
           );
           $categories['21'] = array(
               array('points'=>'10',
                     'str'=> 'antivirus'),
               array('points'=>'10',
                     'str'=> 'software'),
               array('points'=>'10',
                     'str'=> 'productivity'),
               array('points'=>'10',
                     'str'=> 'operating system'),
               array('points'=>'10',
                     'str'=> 'windows'),
               array('points'=>'10',
                     'str'=> 'mac os'),
               array('points'=>'10',
                     'str'=> 'business'),
               array('points'=>'10',
                     'str'=> 'communication'),
               array('points'=>'10',
                     'str'=> 'spyware'),
               array('points'=>'10',
                     'str'=> 'multimedia'),
               array('points'=>'10',
                     'str'=> 'utilities'),
               array('points'=>'10',
                     'str'=> 'trojan'),
           );
           
           
           foreach($categories as $k=>$cat){
               $contCat[$k]['count'] = 0;
               $contCat[$k]['sum'] = 0;
               foreach($cat as $catKey){
                  foreach($strings as $txt){
                    if(strpos(strtolower($txt), $catKey['str']) !== false){
                        $contCat[$k]['count']++;
                        $contCat[$k]['sum'] += $catKey['points'];
                    }
                  }
               }
           }
           $maxCount = 0;
           $catMaxCount = '';
           $maxSum = 0;
           $catMaxSum='';
           foreach($contCat as $k=>$cat){
               if($cat['count'] > $maxCount){
                   $maxCount = $cat['count'];
                   $catMaxCount = $k;
               }
               if($cat['sum'] > $maxCount){
                   $maxCount = $cat['sum'];
                   $catMaxCount = $k;
               }
               
           }
           return $catMaxCount;
    }
     function detectPosibleSubCat($strings, $cat,$cron){
         $subcats = $cron->Category->get_Subcategories(50,null,$cat);
         foreach($subcats as $cat){
               $contCat[$cat->id]['count'] = 0;
               $keys = explode(',',$cat->keyword);
               foreach($keys as $key){
                   foreach($strings as $txt){
                       if(!empty($key)){
                            if(strpos(strtolower($txt), strtolower($key)) !== false){
                             $contCat[$cat->id]['count']++;
                       }
                    }
                  }
               }
                  
           }
           $maxCount = 0;
           $catMaxCount = '';
           foreach($contCat as $k=>$cat){
               if($cat['count'] > $maxCount){
                   $maxCount = $cat['count'];
                   $catMaxCount = $k;
               }
               
           }
           return $catMaxCount;
    }
?>
