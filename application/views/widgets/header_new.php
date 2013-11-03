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
        
    </head>
    <body>
 <script type='text/javascript'>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-43197448-2', 'pccounter.net');
  ga('send', 'pageview');

</script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>
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
        $('.twloginButton').click(function(){
            var thistw = $(this);
                $.ajax({
                type: "POST",
                url: '{siteUrl}/ajax/twlogin/',
                data: { null:0}
              }).done(function( msg ) {
                 
                 
              });
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
    (function() {
        var e = document.createElement('script');
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
    }());
</script>
<div class="topHeader">
<div class="centerScreen">
    <div class="logo">
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
            <li class="{activeHome}">
                <a href="{siteUrl}">							
                    Home
                </a>
            </li>
            <li class="{activeDeals}">
                <a href="{dealsUrl}">
                    Deals
                </a>
            </li>
            <li class="{activeCoupons}">
                <a href="{couponsUrl}">
                    Coupon Codes
                </a>
            </li>
            <li class="{activeCategory}">
                <a href="javascript:$('.categoryMenuList').toggle()">
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
            <li class="{activeStores}">
                <a href="javascript:$('.storeMenuList').toggle();">
                    Browse by stores<div class="downArrow" style="margin-left: 120px;"></div>
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
<div class="mainTitle">
    {msg}
    {headerText}
</div>
<div class="overlay"></div>
<div class='loginDiv'>
    <div class='registerAccount'>
        <div class="title">Create a new account</div>
        <?php echo form_open("/{siteUrl}/register"); ?>
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
        <div class="fbloginButton">Sign in with FACEBOOK</div>
        <div class="twloginButton">Sign in with TWITTER</div>
        <div class="center">or</div>
        <?php echo form_open("/{siteUrl}/register"); ?>
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