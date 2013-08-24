<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <title>
            {pageTitle}
        </title>
        <meta name="keywords" content="{metaKeywords}"/>
        <meta name="description" content="{metaDescription}"/>
        <link href="{siteUrlMedia}media/css/style.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>
        <script type="text/javascript" src="{siteUrlMedia}media/js/main.js"></script>
        <script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
        <script type="text/javascript" src="{siteUrlMedia}media/js/code.js"></script>
        
    </head>
    <body>
        <div id="maindiv">
            <div id="header">
                <div class="header_left">
                    <a href="{siteUrl}">
                        <img src="{siteUrlMedia}media/images/logo.png" alt="" width="360" height="48" border="0"/>
                    </a>
                </div>

                <!--PRODUCT SEARCH STARTS-->

                <div class="header_right">
                    <div class="search_box">
                        <ul style="margin: 10px 0 0 12px;">
                            <form action="<?php echo site_url('deals/search');?>" method = "post">
                                <li class="search_bg">
                                    <input type="text" name="search" placeholder="Search Pccounter.net for over 4,500 stores" class="search_field"/><br />
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
                                <a href="{siteUrl}">							
                                    <img src="{siteUrlMedia}media/images/home_icon.png" alt="" width="16" height="18" border="0" style="margin-bottom: 6px;"/> Home
                                </a>
                            </li>
                            <li>
                                <a href="{dealsUrl}">
                                    <img src="{siteUrlMedia}media/images/tag1.png" alt="" width="16" height="23" border="0"/> Deals
                                </a>
                            </li>
                            <li>
                                <a href="{couponsUrl}">
                                    <img src="{siteUrlMedia}media/images/tag2.png" alt="" width="20" height="18" border="0"/> Coupon Codes
                                </a>
                            </li>
                            <li>
                                <a href="{categoriesUrl}">
                                    <img src="{siteUrlMedia}media/images/tag3.png" alt="" width="16" height="15" border="0"/> Categories
                                </a>
                            </li>
                            <li>
                                <a href="{storesUrl}">
                                    <img src="{siteUrlMedia}media/images/tag4.png" alt="" width="16" height="16" border="0"/> Stores
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="sighin_box">
                        <ul>
                        <?php
                        if ('{userId}' == '') {
                            ?>
                            <li>
                                <a href="{registerUrl}">Register</a>
                            </li>
                            <li>
                                <a href="#dialog" name="modal">Sign in</a>
                            </li>
                            <li>
                            <?php if (!'{userPost}'){ ?>
                                <a href="{loginUrl}" >
                                    <img src="{siteUrlMedia}media/images/signin.png" alt="" width="73" height="44" border="0"/>
                                </a>
                            <?php } else { ?>
                                <form name="logout" style="padding:0px; margin:0px; float:none;" method="post" action="{loginUrl}">
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
                                    <img src="{siteUrlMedia}media/images/signin1.png" alt="" width="73" height="44" border="0"/>
                                </a>
                            </li>
                            <?php
                            } else {
                                ?>	
                                <li>
                                    <a href="{userAccountUrl}">
                                        My Account
                                    </a>
                                </li>
                                <li style="background:none;">
                                    <a href="{logoutUrl}">Log Out</a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="clear"></div>	
            
<div id="maincontent">
	<div class="topbox">
		<div class="topbox_1">
			{msg}
			<h1>{page_title}</h1>
			<p>{page_desc}</p>
		</div>
        
		<div class="topbox_r">

			<div id="fb-root" style="float:left;  width: 60px; margin: 0 auto 0 40px;"></div>

			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
            </script>
             
			<div class="fb-like" data-href="http://www.unifiedinfotech.net/pc_counter/" data-send="false" data-layout="button_count" data-width="100" data-show-faces="true" style="float: right; width: 81px;"></div>

			

			<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>

			<div class="g-plusone"></div>
		</div>
        
	</div>
	<div class="clear"></div>
	<div id="content">