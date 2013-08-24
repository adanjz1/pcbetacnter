<?php
include('includes/boot.php');

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

$page = basename($_SERVER['REQUEST_URI']);

$page_link = explode("?", $page);

$precised_link = explode("=", $page_link[1]);


$row_seo = $db->getSEOLinks($precised_link[1], $link_page);
?>

<?php
$rowtitle = $db->getPageTitle($link_page, $page_link[0], $precised_link[0], $_REQUEST['subcategory'], $_REQUEST['category']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <title><?php
if ($page_link[0] == "deal_store_subcategory.php" && $precised_link[0] == "category") {
    echo $rowtitle['title'];
} else {
    echo $row_seo['title'];
}
?>
        </title>
        <meta name="keywords" content="<?php
if ($page_link[0] == "deal_store_subcategory.php" && $precised_link[0] == "category") {
    echo $rowtitle['meta_tag'];
} else {
    echo $row_seo['meta_tag'];
}
?> "/>
        <meta name="description" content="<?php
            if ($page_link[0] == "deal_store_subcategory.php" && $precised_link[0] == "category") {
                echo $rowtitle['meta_content'];
            } else {
                echo $row_seo['meta_content'];
            }
            ?>"/>

        <link href="media/css/style.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>
        <script type="text/javascript" src="media/js/main.js"></script>
        <script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
        <script type="text/javascript" src="media/js/code.js"></script>
        
    </head>
    <body>
        <div id="maindiv">
            <div id="header">
                <div class="header_left">
                    <a href="<?php echo SITE_URL; ?>">
                        <img src="media/images/logo.png" alt="" width="360" height="48" border="0"/>
                    </a>
                </div>

                <!--PRODUCT SEARCH STARTS-->

                <div class="header_right">
                    <div class="search_box">
                        <ul style="margin: 10px 0 0 12px;">
                            <form name="productsearch" method="get" action="<?php echo SITE_URL; ?>?view=productsearch" onsubmit="return productcheck();">
                                <li class="search_bg">
                                    <input type="text" name="Search_for" placeholder="Search Pccounter.net for over 4,500 stores" class="search_field"/><br />
                                    <span style="color:#FF0000;" id="err_productsearch"></span>
                                </li>
                                <li>
                                    <input type="submit" class="search_btn" name="Submit" value="GO"/>
                                </li>
                            </form>
                        </ul>
                    </div>
                </div>

                <!--PRODUCT SEARCH ENDS-->

                <div class="clear"></div>
                <div id="navigation_bg">
                    <div id="nav">
                        <ul>
                            <li>
                                <a href="<?php echo SITE_URL; ?>">							
                                    <img src="media/images/home_icon.png" alt="" width="16" height="18" border="0" style="margin-bottom: 6px;"/> Home
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo SITE_URL; ?>deals">
                                    <img src="media/images/tag1.png" alt="" width="16" height="23" border="0"/> Deals
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo SITE_URL; ?>coupons">
                                    <img src="media/images/tag2.png" alt="" width="20" height="18" border="0"/> Coupon Codes
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo SITE_URL; ?>categories">
                                    <img src="media/images/tag3.png" alt="" width="16" height="15" border="0"/> Categories
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo SITE_URL; ?>stores">
                                    <img src="media/images/tag4.png" alt="" width="16" height="16" border="0"/> Stores
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="sighin_box">
                        <ul>
                        <?php
                        if ($_SESSION['userid'] == '') {
                            ?>
                            <li>
                                <a href="<?php echo SITE_URL; ?>register">Register</a>
                            </li>
                            <li>
                                <a href="#dialog" name="modal">Sign in</a>
                            </li>
                            <li>
                            <?php if (!$user) { ?>
                                <a href="<?php echo $loginUrl; ?>" >
                                    <img src="media/images/signin.png" alt="" width="73" height="44" border="0"/>
                                </a>
                            <?php } else { ?>
                                <form name="logout" style="padding:0px; margin:0px; float:none;" method="post" action="<?php echo SITE_URL; ?>password.php">
                                    <input type="hidden" name="mode" value="logout" />
                                    <input type="submit" value="Log Out" name="logout" />
                                </form>
                                <?php } ?>
                            </li>
                            <?php
                            if (array_key_exists("login", $_GET)) {
                                $oauth_provider = $_GET['oauth_provider'];
                                if ($oauth_provider == 'twitter') {
                                    header("location: login-twitter.php");
                                }
                            }
                            ?>
                            <li style="background:none;">
                                <a href="?login&oauth_provider=twitter">
                                    <img src="media/images/signin1.png" alt="" width="73" height="44" border="0"/>
                                </a>
                            </li>
                            <?php
                            } else {
                                ?>	
                                <li>
                                    <a href="<?php echo SITE_URL; ?>user_account.php">
                                        My Account
                                    </a>
                                </li>
                                <li style="background:none;">
                                    <a href="<?php echo SITE_URL; ?>password.php?mode=logout">Log Out</a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="clear"></div>	
            