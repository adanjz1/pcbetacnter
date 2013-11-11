<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <title>
            {pageTitle}
        </title>
    </head>
    <!--<body onload="loadFBConnect();">-->
    <body>

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
</body>
</html>