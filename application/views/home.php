<script>
     $(document).ready(function(){
            $('.share').click(function(){
                $(this).parent().parent().find('.shareBox').toggle();
            });
            $('.thumbs, .thumbActive').click(function(){
                var thisThumb = $(this);
                $.ajax({
                type: "POST",
                url: "{base_url}/ajax/like/"+$(this).attr('rel'),
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
<div class="leftcol">
    <div class="latest_deal">
        <div class="left_top"><h1>Latest Online Deals </h1></div>
        <div class="left_mid">
            {deals}
            <? include('widgets/dealListElem.php')?>
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
                    <img src="{image}" alt="" style="max-width: 162px;max-height:77px;" border="0" class="border"/>
                </div>
                <div class="coupon" style="width: 414px; padding: 0 0 0 19px;">
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