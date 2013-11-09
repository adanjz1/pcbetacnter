<li class="couponItem {extraClass} {lastInRow}">
                 <div class="couponImage">
                     <img src="{image}" alt="{display_name}" class="border" border="0"/>
                 </div>
                 <div class="couponContent">
                    <div class="dealCategoryData">
                        <span class="redtext">{categoryStr}</span> ({categoryCount})
                    </div>
                    <div class="dealTitle">
                        <a href="{offerUrl}">{short_display_name}</a>
                    </div>
                    <div class="couponProvider">
                        <span>From {provider}</span>
                    </div>
                </div>
                <a class="couponBtn copy_to_clip" href="javascript:void(0)" target="_blank" rel="{deal_url}" data-clipboard-text="{coupon_code}" >
                    <div class="getDealStr">{coupon_code}</div>
                </a>
                 <div class="couponActions">
                    <div class="{thumbsClass}" rel="{id}"><div class="thumbsValue">{thumbs}</div></div>
                    <div class="comment" onclick="document.location='deals/review/{id}/0/true#TabbedPanels1'"><div class="commentQty">{qtyComments}</div></div>
                    <div class="share"></div>
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
             </li>