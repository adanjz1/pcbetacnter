<div class="leftcol">
    <div class="latest_deal">
        <div class="left_top"><h1>Latest Online Deals </h1></div>
        <div class="left_mid">
            {deals}
            <div class="pro_box">
                <div class="pro_mid">
                    {hot}
                    <h1>
                        <a href="{offerUrl}">{display_name}</a>
                    </h1>
                    <div class="border_bg">
                        <a href="{offerUrl}">
                            <img src="{image}" alt="{display_name}" class="border" border="0"/>
                        </a>
                    </div>
                    <ul>
                        <li><span>From {provider}</span></li>
                        <?php if('{actual_price}' != '0.00') { ?>
                        <li style="display:none">List Price: <strong>${actual_price}</strong></li>
                        <?php } ?>

                        <li class="price">
                            Price: 
                            <span class="redtext">
                                ${deal_price}
                            </span> 
                            <strong>
                                + FREE SHIPPING
                            </strong>
                        </li>
                        <li>
                            <span style="font:bold 12px/16px Arial, Helvetica, sans-serif; color: #515151; padding: 0 5px 0 0;">
                                Share :
                            </span>

                            <!--TWITTER SHARE STARTS-->
                            <span id="custom-tweet-button">
                                <a href="javascript: void(0);"  data-via="unifiedinfotech"  data-count="none" onclick="window.open('https://twitter.com/share?url={offerUrl}', 'Twitter', 'width=500,height=500');"><img src="media/images/twitter.gif" alt="" width="16" height="16" border="0" align="top"/></a>
                            </span>
                            <script>!function(d, s, id) {
                                        var js, fjs = d.getElementsByTagName(s)[0];
                                        if (!d.getElementById(id)) {
                                            js = d.createElement(s);
                                            js.id = id;
                                            js.src = "//platform.twitter.com/widgets.js";
                                            fjs.parentNode.insertBefore(js, fjs);
                                        }
                                    }(document, "script", "twitter-wjs");</script>
                            <!--TWITTER SHARE ENDS-->

                            <!--FACEBOOK SHARE STARTS-->
                            <a target="_blank" href="http://www.facebook.com/dialog/feed?app_id=158698274267858&link={encodedUrl}&picture={image}&name={display_name}&description={encodedDesc}&redirect_uri={offerUrl}"><img src="media/images/facebook.gif" alt="" width="16" height="16" border="0" align="top"/></a>
                            <script src='http://connect.facebook.net/en_US/all.js'></script>
                            <!--FACEBOOK SHARE ENDS-->

                            <!--GOOGLE PLUS SHARE STARTS-->
                            <a href="javascript: void(0);" onclick="popUp = window.open('https://plus.google.com/share?url={reviewUrl}{id}', 'popupwindow', 'scrollbars=yes,width=800,height=400');
                                        popUp.focus();
                                        return false">
                                <img src="media/images/g1+.gif" alt="Google+" title="Google+"/>
                            </a>
                            <!--GOOGLE PLUS SHARE ENDS-->

                            <!--PINTEREST SHARE STARTS-->
                            <a href="http://pinterest.com/pin/create/button/?url={offerUrl}&media={offerUrl}" target="_blank">
                                <img src="media/images/pinterest.gif" alt="Pinterest" title="Pinterest"/>
                            </a>
                            <!--PINTEREST SHARE ENDS-->

                        </li>
                        <li>
                            <img src="images/spacer.gif" alt="" width="1" height="20" border="0"/>
                        </li>
                    </ul>
                </div>
                <div>
                    <a class="hot_dealbtn2" href="{deal_url}" target="_blank">
                        Get Deal
                    </a>
                </div>
            </div>
            {/deals}
            <div class="clear"></div>
            {noDeals}
        </div>
        <div class="left_bot"></div>
    </div>
    <div class="clear"></div>
    <div class="latest_deal">
        <div class="left_top">
            <h1>Newest Online Coupons</h1>
        </div>
        <div class="left_mid">
            {newestCoupons}
            <div class="coupon_box">
                <div class="coupon" style="margin: 10px auto 0 6px;">
                    <img src="{image}" alt="" width="162" height="77" border="0" class="border"/>
                </div>
                <div class="coupon" style="width: 184px; padding: 0 0 0 19px;">
                    <ul>
                        <li>
                            <h1>
                                {display_name}
                            </h1>
                        </li>
                        <li>
                            <span>
                                From: {provider}
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="coupon" style="width: 230px;">
                    <ul>
                        <?php if('{actual_price}' != '0.00') { ?>
                        <li>
                            List Price: 
                            <strong>
                                ${actual_price}
                            </strong>
                        </li>
                        <?php } ?>
                        <li>
                            Price: 
                            <span class="redtext">
                                ${deal_price}
                            </span> 
                            <strong>
                                + FREE SHIPPING
                            </strong>
                        </li>
                        <li>You Save: <span class="redtext">{savingsPercentage}%</span></li>
                    </ul>
                </div>
                <div class="coupon" style="border:0; width: 160px;">



                    <div class="buy">
                        <div class="pricing-container"></div>
                        <div class="button-outer code" data-href="{deal_url}">
                            <a target="_blank">
                                <div class="button code">
                                    <div class="coupon-code">
                                        {couponCode}
                                    </div>
                                    <div style="width: 93px;" class="button-inner code">Reveal Code</div>
                                    <div style="left: 95px;" class="peelie">&nbsp;</div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
 {/newestCoupons}
 {noNewestCoupons}
        </div>
        <div class="left_bot"></div>
    </div>
</div>