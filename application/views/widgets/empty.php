<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <title>
            {pageTitle}
        </title>
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
    
</script>
<div class="topHeader">
<div class="centerScreen">
    <div class="logo">
        <img src="{siteUrlMedia}media/images/new/logo.png" alt="" border="0"/>
    </div>
    <div class="search">
        
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
<div class="mainTitle">
    {msg}
    {headerText}
</div>
<div class="overlay"></div>
<div class='loginDiv'>
    <div class='registerAccount'>
        <div class="title">Create a new account</div>
       
    </div>
    
    <div class='loginAccount'>
        <div class="title">Sign into your PCCOUNTER account</div>
        <div id="fb-root"></div>
        <div class="fbloginButton">Sign in with FACEBOOK</div>

        <div class="center">or</div>
      
        
    </div>
    <div class="clear"></div>
    
    <div class="closeLogin orange">Not now</div>
</div>
<div class="socialNetworks">
    <div class="blog" onclick="document.location='http://blog.pccounter.com/'"></div>
    <div class="facebook" onclick="document.location='http://www.facebook.com/PcCounterProducts'"></div>
    <div class="twitter" onclick="document.location='http://www.facebook.com/pccounter'"></div>
    <div class="googleplus" onclick="document.location='http://www.facebook.com/pccounter'"></div>
</div>