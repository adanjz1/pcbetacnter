
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

                        <li class="price dealPriceList">
                            {showActualPrice}
                            <span class="redtext">
                                ${deal_price}
                            </span> 
                        </li>
                        <li class="dealShareList">
                            <div class="shareLinks">
                                <div class="{thumbsClass}" rel="{id}"><div class="thumbsValue">{thumbs}</div></div>
                                <div class="share"></div>
                                <div class="comment" onclick="document.location='deals/view/<?= urlencode('{display_name}');?>-{id}/0/true#TabbedPanels1'"></div>
                                <div class="clear"></div>
                            </div>
                           <div class="shareBox">
                            <span style="font:bold 12px/16px Arial, Helvetica, sans-serif; color: #515151; padding: 0 5px 0 0;">
                                Share this deal on:<br/>
                            </span>
                            
                            <!--TWITTER SHARE STARTS-->
                            <span id="custom-tweet-button">
                                <a href="javascript: void(0);"  data-via="unifiedinfotech"  data-count="none" onclick="window.open('https://twitter.com/share?url={offerUrl}', 'Twitter', 'width=500,height=500');"><img src="http://pccounter.net/media/images/twitter.gif" alt="" width="16" height="16" border="0" align="top"/></a>
                            </span>
                            
                            <!--TWITTER SHARE ENDS-->

                            <!--FACEBOOK SHARE STARTS-->
                            <a target="_blank" href="http://www.facebook.com/dialog/feed?app_id=158698274267858&link={encodedUrl}&picture={image}&name={display_name}&description={encodedDesc}&redirect_uri={offerUrl}"><img src="http://pccounter.net/media/images/facebook.gif" alt="" width="16" height="16" border="0" align="top"/></a>
                            
                            <!--FACEBOOK SHARE ENDS-->

                            <!--GOOGLE PLUS SHARE STARTS-->
                            <a href="javascript: void(0);" onclick="popUp = window.open('https://plus.google.com/share?url={reviewUrl}{id}', 'popupwindow', 'scrollbars=yes,width=800,height=400');
                                        popUp.focus();
                                        return false">
                                <img src="http://pccounter.net/media/images/g1+.gif" alt="Google+" title="Google+"/>
                            </a>
                            <!--GOOGLE PLUS SHARE ENDS-->

                            <!--PINTEREST SHARE STARTS-->
                            <a href="http://pinterest.com/pin/create/button/?url={offerUrl}&media={offerUrl}" target="_blank">
                                <img src="http://pccounter.net/media/images/pinterest.gif" alt="Pinterest" title="Pinterest"/>
                            </a>
                            <!--PINTEREST SHARE ENDS-->
                                
                        </li>
                        <li>
                            <img src="http://pccounter.net/media/images/spacer.gif" alt="" width="1" height="20" border="0"/>
                        </li>
                    </ul>
                </div>
                <div>
                    <a class="hot_dealbtn2" href="{deal_url}" target="_blank">
                        <div class="getDealStr">Get Deal</div>
                    </a>
                </div>
                <div class="dealCategoryList">
                    <a href="{siteUrl}{catUrl}">{categoryStr}</a>
                </div>
            </div>