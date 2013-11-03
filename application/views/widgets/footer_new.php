<div class="footer">
    <div class="centerScreen">
        <div class="sector">
            <div class="title">COMPANY</div>
            <div class="list">
                {staticPages}
                <div class="link">
                    <a href="{url}">{name}</a>
                </div>
                {/staticPages}
            </div>
        </div>
        <div class="sector">
            <div class="title">GET STARTED</div>
            <div class="list">
                <div class="link">
                    <a href="{categoriesUrl}">Categories</a></div>
                <div class="link">
                    <a href="{storesUrl}">Stores</a></div>
                <div class="link">
                    <a href="{blogUrl}">Blog</a></div>	
            </div>
        </div>
        <div class="sector">
            <div class="title">BROWSE THE LASTEST SAVINGS</div>
            <div class="list">
                 <div class="link">
                    <a href="{couponsUrl}">Coupon Codes</a>
                 </div>  
                 <div class="link">
                    <a href="{dealsUrl}">Deals & Clearance</a>
                 </div>	
            </div>
        </div>
        <div class="sector" style="margin-right: 40px;">

            <div class="title">HOLIDAY & LIFESTYLE SAVINGS</div>
            <div class="list">
                {specialPages_1}
                  <div class="link">
                    <a href="{specialPageUrl}">{name}</a>
                  </div>	
                {/specialPages_1}
            </div>
        </div>
        <div class="newsletterFooter">
            <div class="title">SUBSCRIBRE TO OUR NEWSLETTER</div>
            <form name="newsletter" method="post" onsubmit="return newscheck();">
                <input type="hidden" name="mode" value="addnewsletter" />
                <input type="text" class="search_bg1" name="email" placeholder="Enter Your Email address here"/><br/>
                <input type="submit" name="Submit2" class="search_btn1" value=""/>
            </form>
        </div>
    </div>
</div>
<div class="bottomFooter">
    <div class="centerScreen">
        Copyright 2013 pccounter.net | <a href="{contactUrl}">Contact Us</a>  |  <a href="{mapUrl}">Site Map</a>
    </div>
</div>
<script type="text/javascript">
    function loadFBConnect(){
        (function() {
            var e = document.createElement('script');
            e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
            e.async = true;
            document.getElementById('fb-root').appendChild(e);
        }());
    }
</script>
</body>
</html>