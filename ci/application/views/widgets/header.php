<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <title>
            {pageTitle}
        </title>
        <meta name="Title" content="{metaTitle}">
        <meta name="keywords" content="{metaKeywords}"/>
        <meta name="description" content="{metaDescription}"/>
        <link href="{siteUrlMedia}media/css/style.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>
        <script type="text/javascript" src="{siteUrlMedia}media/js/main.js"></script>
        <script type="text/javascript" src="{siteUrlMedia}media/js/code.js"></script>
        <meta http-equiv="cache-control" content="no-cache"></meta>
        <meta http-equiv="content-language" content="en-US"></meta>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"></meta>
        <meta http-equiv="set-cookie" content="w3scookie=myContent;expires=Fri, 30 Dec 2020 12:00:00 GMT; path=http://www.w3schools.com">
        
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
                        if ('' == '') {//{userId}
                            ?>
                            <li>
                                <a href="{registerUrl}">Register</a>
                            </li>
                            <?php
                            if (array_key_exists("login", $_GET)) {
                                $oauth_provider = $_GET['oauth_provider'];
                                if ($oauth_provider == 'twitter') {
                                    header("location: login-twitter.php");
                                }
                            }
                            ?>
                            
                            <?php foreach ($this->config->item('third_party_auth_providers') as $provider) : ?>
                                <li class="third_party <?php echo $provider; ?>"><?php echo anchor('account/connect_'.$provider, ' ', array('title' => sprintf(lang('sign_in_with'), lang('connect_'.$provider)))); ?></li>
                            <?php endforeach; ?>
                                <li class="third_party facebook">
                                    <fb:login-button></fb:login-button>
                                </li>
                        	<div id="fb-root"></div>
                                <script>
                                        window.fbAsyncInit = function() {
                                                FB.init({
                                                        appId: '607430695967375',
                                                        cookie: true,
                                                        xfbml: true,
                                                        oauth: true
                                                });
                                                FB.Event.subscribe('auth.login', function(response) {
                                                        window.location.reload();
                                                });
                                                FB.Event.subscribe('auth.logout', function(response) {
                                                        window.location.reload();
                                                });
                                        };
                                        (function() {
                                                var e = document.createElement('script'); e.async = true;
                                                e.src = document.location.protocol +
                                                '//connect.facebook.net/en_US/all.js';
                                                document.getElementById('fb-root').appendChild(e);
                                        }());
                                </script>
                            <?php
                            } else {
                                ?>	
                                <li>
<!--                                    <a href="{userAccountUrl}">
                                        My Account
                                    </a>-->
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
                        {headerText}
		</div>
        
		<div class="topbox_r">

			<div id="fb-root"></div>
		<script src="http://connect.facebook.net/en_US/all.js"></script>
		<script type="text/javascript">
		  	FB.init({appId: "<?php echo $this->config->item('facebook_app_id'); ?>", status: true, cookie: true, xfbml: true});
		  	FB.Event.subscribe('auth.sessionChange', function(response) {
		    	if (response.session) 
		    	{
		      		// A user has logged in, and a new cookie has been saved
					//window.location.reload(true);
		    	} 
		    	else 
		    	{
		      		// The user has logged out, and the cookie has been cleared
		    	}
		  	});
		</script>
             
			<div class="fb-like" data-href="http://www.unifiedinfotech.net/pc_counter/" data-send="false" data-layout="button_count" data-width="100" data-show-faces="true" style="float: right; width: 81px;"></div>

			

			<script type="text/javascript">
                            (function() {
                              var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                              po.src = 'https://apis.google.com/js/plusone.js';
                              var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                            })();
                          </script>

			<div class="g-plusone"></div>
		</div>
        
	</div>
	<div class="clear"></div>
	<div id="content">