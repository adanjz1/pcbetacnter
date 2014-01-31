<div class="leftCatBar">
    <ul>
        <?php foreach($categories as $cat){?>
                <li class="<?=($cat->id==$selCat)?'selected':''?>">
                    <a href="/home/index/<?=$cat->id?>/{flagMobile}"><img src="{siteUrlMedia}media/images/new/cat_icon_<?= $cat->id?>.png"></a>
                </li>
        <? } ?>
    </ul>
    
</div>
<div class="subcat" id="<?= $cat->id?>">
    <ul>
        <?php foreach($subcategories as $sub){?>
            <li id="<?= $sub->id?>" class="<?=($sub->id==$selSubCat)?'selected':''?>">
                <a href="/home/index/<?=$selCat?>/<?=$sub->id?>{flagMobile}"><?=$sub->name?></a>
            </li>
        <? } ?>
    </ul>
</div>
<div class="deals">
    {topDeals}
        <div class="dealEncapsulated">
            <div class="centerImage">
                <div class="image">
                    <img src="{image}"/>
                </div>
            </div>      
            <div class="dealData">
                <div class="title">
                    {title}
                </div>
                <div class="dealProvider">
                    From {provider}
                </div>
                <div class="dealPrice">
                    ${deal_price}
                </div>
            </div>
        </div>
    {/topDeals}
</div>
<div class="coupons deals">
    {topCoupons}
    <div class="dealEncapsulated">
            <div class="centerImage">
                <div class="image">
                    <img src="{image}"/>
                </div>
            </div>      
            <div class="dealData">
                <div class="title">
                    {title}
                </div>
                <div class="dealProvider">
                    From {provider}
                </div>
                <div class="dealPrice">
                    {coupon_code}
                </div>
            </div>
        </div>
    {/topCoupons}
</div>
<div class="clear"></div>
