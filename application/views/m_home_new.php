<div class="leftCatBar">
    <ul>
        <?php foreach($categories as $cat){?>
                <li class="<?=($cat->id==$selCat)?'selected':''?>">
                    <img src="{siteUrlMedia}media/images/new/cat_icon_<?= $cat->id?>.png">
                </li>
        <? } ?>
    </ul>
    
</div>
<div class="subcat" id="<?= $cat->id?>">
    <ul>
        <?php foreach($subcategories as $sub){?>
            <li id="<?= $sub->id?>" class="<?=($sub->id==$selSubCat)?'selected':''?>">
                <?=$sub->name?>
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
<div class="coupons">
    {topCoupons}
    {/topCoupons}
</div>
<div class="clear"></div>
