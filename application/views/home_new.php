<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css" rel="stylesheet">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
 <script type='text/javascript'>
$(function(){
    $('.carousel1').carousel({
     interval: 2000
    });
    $('.plusLessButton').click(function(){
       if($(this).hasClass('plus')){
           $(this).removeClass('plus');
           $(this).addClass('less');
           $(this).parent().find('.hiddenCat').css("display","table");
       }else{
           $(this).removeClass('less');
           $(this).addClass('plus');
           $(this).parent().find('.hiddenCat').hide();
       }
    });
       $('.share').click(function(){
                $(this).parent().parent().find('.shareBox').toggle();
            });
            $('.thumbs, .thumbActive').click(function(){
                var thisThumb = $(this);
                $.ajax({
                type: "POST",
                url: '{siteUrl}/ajax/like/'+$(this).attr('rel'),
                data: { null:0}
              }).done(function( msg ) {
                 thisThumb.find('.thumbsValue').html(msg);
                 if(thisThumb.attr('class') == 'thumbs'){
                     thisThumb.addClass('thumbActive');
                     thisThumb.removeClass('thumbs');
                 }else{
                     thisThumb.addClass('thumbs');
                     thisThumb.removeClass('thumbActive');
                 }
                 
              });
            });
});
 </script>
 <div id="carousel-example-generic" class="carousel1 homeTop" data-ride="carousel">
    <ol class="carousel-indicators">
        {bannerDealsIndicator}
            <li data-target="#carousel-example-generic" data-slide-to="{count}" class="{activeDeal}"></li>
        {/bannerDealsIndicator}
    </ol>
    <div class="carousel-inner">
    {bannerDeals}
        <div class="item {activeDeal}">
                <div class="dealImage">
                     <img src="{image}" alt="{display_name}" class="border" border="0"/>
                 </div>
                 <div class="dealContent">
                    <div class="dealTitle">
                        <a href="{offerUrl}">{short_display_name}</a>
                    </div>
                    <div class="dealProvider">
                        <span>From {provider}</span>
                    </div>
                    <div class="price dealPriceList">
                       <span class='oldPrice'>{showActualPrice}</span>
                       <span class="redtext bold">
                           ${deal_price}
                       </span> 
                    </div>
                </div>
                <a class="dealBtn" href="{deal_url}" target="_blank">
                    <div class="getDealStr">GET THIS DEAL</div>
                </a>
                 <div class="dealActions">
                    <div class="{thumbsClass}" rel="{id}"><div class="thumbsValue">{thumbs}| APPRECIATE THIS</div></div>
                    <div class="comment" onclick="document.location='deals/review/{id}/0/true#TabbedPanels1'"><div class="commentQty">{qtyComments} | COMMENT</div></div>
                    <div class="share"><div class="shareValue">| SHARE LINK</div></div>
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
                           </div>     
                        
        </div>
    {/bannerDeals}
    </div>
</div>
 <div class="homeTop newsletter">
     <div class="newsletterBox">
         <form name="newsletter" method="post" onsubmit="return newscheck();">
            <input type="hidden" name="mode" value="addnewsletter" />
            {newsletterMessage}

        </form>
     </div>
 </div>
 <div class="clear"></div>
 <div class="categories">
     <div class="catTitle">CATEGORY</div>
     <div class="plusLessButton plus"></div>
     <div class="clear"></div>
     <div class="list">
         <ul>
             {categories}
             <li class="categoryIcon categ_{id} {extraClass}" onclick="document.location='{dealCategoryUrl}'">
                 
            </li>
            {/categories}   
            <li class="categoryIcon placeHolder hiddenCat"></li>
            <div class="clear"></div>
         </ul>
     </div>
 </div>
 <div class="stores">
     <div class="catTitle">STORES</div>
     <div class="plusLessButton plus"></div>
     <div class="clear"></div>
     <div class="list">
         <ul>
             {stores}
             <li class="storeIcon {extraClass}" onclick="document.location='{dealsStore}'">
                  <div style="display: table-cell; vertical-align: middle;text-align: center;">
                    <img src="{image}">
                  </div>
                 
            </li>
            {/stores}
            <div class="clear"></div>
         </ul>
     </div>
 </div>
 
 <div class="topDeals">
     <div class="catTitle">TOP DEALS</div>
     <div class="plusLessButton plus"></div>
     <div class="clear"></div>
     <div class="list">
         <ul>
             {topDeals}
             <?php include('widgets/dealListElem_new.php')?>
            {/topDeals}
            <div class="clear"></div>
         </ul>
     </div>
 </div>
 <div class="lastestDeals">
     <div class="catTitle">LASTEST DEALS</div>
     <div class="plusLessButton plus"></div>
     <div class="clear"></div>
     <div class="list">
         <ul>
             {lastestDeals}
             <?php include('widgets/dealListElem_new.php')?>
            {/lastestDeals}
            <div class="clear"></div>
         </ul>
     </div>
 </div>
 
 <div class="topCoupons">
     <div class="catTitle">TOP COUPONS</div>
     <div class="plusLessButton plus"></div>
     <div class="clear"></div>
     <div class="list">
         <ul>
             {topCoupons}
             <?php include('widgets/couponListElem_new.php')?>
            {/topCoupons}
            <div class="clear"></div>
         </ul>
     </div>
 </div>
 <div class="lastestCoupons">
     <div class="catTitle">LASTEST COUPONS</div>
     <div class="plusLessButton plus"></div>
     <div class="clear"></div>
     <div class="list">
         <ul>
             {lastestCoupons}
             <?php include('widgets/couponListElem_new.php')?>
            {/lastestCoupons}
            <div class="clear"></div>
         </ul>
     </div>
 </div>
 
</div>