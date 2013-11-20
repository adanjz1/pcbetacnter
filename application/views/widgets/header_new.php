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
        <link href="{siteUrlMedia}media/css/style_new.css" rel="stylesheet" type="text/css"/>
        <meta http-equiv="Cache-control" content="public">
        <meta http-equiv="content-language" content="en-US"></meta>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"></meta>
        <meta http-equiv="set-cookie" content="w3scookie=myContent;expires=Fri, 30 Dec 2020 12:00:00 GMT; path=http://www.w3schools.com">
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>        
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css" rel="stylesheet">
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
    </head>
    <!--<body onload="loadFBConnect();">-->
    <body>
 <script type='text/javascript'>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-43197448-2', 'pccounter.net');
  ga('send', 'pageview');

</script>

<script type="text/javascript" src="/media/js/new/zclip.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.unchecked').click(function(){
            $(this).removeClass('unchecked');
            $(this).addClass('checked');
        });
        $('.checked').click(function(){
            $(this).removeClass('checked');
            $(this).addClass('unchecked');
        });
        $('.closeLogin').click(function(){
            $('.loginDiv').hide();
            $('.overlay').hide();
        });
        $('.createLogin').click(function(){
            $('.loginDiv').show();
            $('.overlay').show();
        });
        $('.fbloginButton').click(function(){
         FB.login(function(response) {

            if (response.authResponse) {
                console.log('Welcome!  Fetching your information.... ');
                //console.log(response); // dump complete info
                access_token = response.authResponse.accessToken; //get access token
                user_id = response.authResponse.userID; //get FB UID

                FB.api('/me', function(response) {
                    user_email = response.email; //get user email
                    console.log(user_email);
                    $('.fbloginButton').html('FACEBOOK LOGOUT');
                    $('.overlay').hide();
                    $('.loginDiv').hide();
                    alert('You have succesfully logged in');
              // you can store this data into your database             
                });

            } else {
                //user hit cancel button
                console.log('User cancelled login or did not fully authorize.');

            }
        }, {
            scope: 'publish_stream,email'
        });
        });
        $('.copyme').zclip({
            path: 'http://beardy.co/wp-content/uploads/2013/02/ZeroClipboard.swf',
            copy: function(){
            var copythis = $(this).attr('data-clipboard-text');
            return copythis;
        },
            afterCopy: function(){
                alert('Coupon code has been copied in clipboard');
                var a = document.createElement('a');
                a.href=$(this).attr('rel');
                a.target = '_blank';
                document.body.appendChild(a);
                a.click();
            }
        });
           $('.menuHead').click(function(){
               $("."+$(this).attr('rel')).toggle()
           });
    });
    
    window.fbAsyncInit = function() {
        FB.init({
            appId: '607430695967375',
            oauth   : true,
            status  : true, // check login status
            cookie  : true, // enable cookies to allow the server to access the session
            xfbml   : true // parse XFBML
        });

      };
</script>
<div class="topHeader">
<div class="centerScreen">
    <div class="logo" onclick="document.location='/'">
        <img src="{siteUrlMedia}media/images/new/logo.png" alt="" border="0"/>
    </div>
    <div class="search">
        <form action="<?php echo site_url('deals/search');?>" method="post">
            <ul>
                <li class="search_bg">
                    <input type="text" name="search" placeholder="Search Pccounter.net for over 4,500 stores" class="search_field"/><br />
                    <span style="color:#FF0000;" id="err_productsearch"></span>
                </li>
                <li>
                    <input type="submit" class="search_btn" name="Submit" value=""/>
                </li>
            </ul>
        </form>
    </div>
</div>
</div>
<div class="clear"></div>
<div class="headerMenu">
    <div class="centerScreen">
        <ul>
            <li>
                <a href="{siteUrl}" class="{activeHome}">							
                    Home
                </a>
            </li>
            <li>
                <a href="{dealsUrl}" class="{activeDeals}">
                    Deals
                </a>
            </li>
            <li>
                <a href="{couponsUrl}" class="{activeCoupons}">
                    Coupon Codes
                </a>
            </li>
            <li>
                <a href="#" rel="categoryMenuList" class="{activeCategory} menuHead">
                    Browse by category<div class="downArrow"></div>
                </a>
                <div class="categoryMenuList">
                    {categoriesMenu}
                    <div class="elem">
                        <a href="{subCategoryUrl}" >
                                {name}
                        </a>
                    </div>
                    {/categoriesMenu}
                    <div class="elem allCateg">
                        <a href="{dealsUrl}" >
                            <b>All Categories(21)</b>
                        </a>
                    </div>
                </div>
            </li>
            <li>
                <a href="#" rel="storeMenuList" class="{activeStores} menuHead">
                    Browse by stores<div class="downArrow" style="margin-left: 130px;"></div>
                </a>
                <div class="storeMenuList">
                    {storesMenu}
                    <div class="elem">
                        <a href="{dealsStore}" >
                                {short_name}
                        </a>
                    </div>
                    {/storesMenu}
                    <div class="elem allCateg">
                        <a href="{storesUrl}" >
                            <b>All Stores({qtyStores})</b>
                        </a>
                    </div>
                </div>
            </li>
            <li class="login">
                <a href="javascript:void()" class="createLogin">
                    LOGIN OR <span class="orange">CREATE AN ACCOUNT</span>
                </a>
            </li>
        </ul>
        </div>
</div>
<div class="body">
    <div class="centerScreen">
        <div class="path">{pathLocation}</div>
<div class="mainTitle">
    {msg}
    {headerText}
</div>
<div class="overlay"></div>
<div class='loginDiv'>
    <div class='registerAccount'>
        <div class="title">Create a new account</div>
        <?php echo form_open("/register"); ?>
            	<input type="text" name="register_email" class="txtfieldbg" placeholder="E-mail"><br>
                <span style="color:#FF0000;" id="err_register_email"></span><br/>
                <input type="password" name="register_password" class="txtfieldbg" placeholder="Password"><br>
                <span style="color:#FF0000;" id="err_register_password"></span><br/>
                <input type="password" name="register_confirm_password" class="txtfieldbg" placeholder="Confirm password"><br>
                <span style="color:#FF0000;" id="err_register_confirm_password"></span>
                <input type="submit" value="CREATE NOW"/>
        </form>
    </div>
    
    <div class='loginAccount'>
        <div class="title">Sign into your PCCOUNTER account</div>
        <div id="fb-root"></div>
        <div class="fbloginButton">Sign in with FACEBOOK</div>
        <?php
           if (array_key_exists("login", $_GET)) {
               $oauth_provider = $_GET['oauth_provider'];
               if ($oauth_provider == 'twitter') {
                   header("location: login-twitter.php");
               }
           }
           ?>

           <?php foreach ($this->config->item('third_party_auth_providers') as $provider) : ?>
               <div class="twloginButton">
                   <a href="{siteUrl}account/connect_twitter">Sign in with TWITTER</a></div>
           <?php endforeach; ?>
        <div class="center">or</div>
        <?php echo form_open("register/login"); ?>
            	<input type="text" name="register_email" class="txtfieldbg" placeholder="E-mail"><br>
                <span style="color:#FF0000;" id="err_register_email"></span><br/>
                <input type="password" name="register_password" class="txtfieldbg" placeholder="Password"><br>
                <span style="color:#FF0000;" id="err_register_password"></span>
                <input type="submit" value="SIGN IN"/>
        </form>
        
    </div>
    <div class="clear"></div>
    <div class='policyAgreement'>
        <div class='unchecked'></div>
        I agree with Pccounter's <span class="orange">policy</span> and <span class="orange">terms of use</span>
        <div class="clear"></div>
    </div>
    <div class="closeLogin orange">Not now</div>
</div>
<div class="socialNetworks">
    <div class="blog" onclick="document.location='{blogUrl}'"></div>
    <div class="facebook" onclick="document.location='http://www.facebook.com/PcCounterProducts'"></div>
    <div class="twitter" onclick="document.location='https://twitter.com/pccounter'"></div>
    <div class="googleplus" onclick="document.location='http://www.facebook.com/pccounter'"></div>
</div>