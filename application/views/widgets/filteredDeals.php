<div id="encapsuledDeals">
<script type='text/javascript'>
$(function(){
    $('.share').click(function(){
                $(this).parent().parent().find('.shareBox').toggle();
            });
            $('.thumbs, .thumbActive').click(function(){
                var thisThumb = $(this);
                $.ajax({
                type: "POST",
                url: '{siteUrl}ajax/like/'+$(this).attr('rel'),
                data: { null:0}
              }).done(function( msg ) {
                 
                 if(thisThumb.parent().parent().hasClass('item')){
                     thisThumb.find('.thumbsValue').html(msg+'| APPRECIATE THIS');
                 }else{
                     thisThumb.find('.thumbsValue').html(msg);
                 }
                 if(thisThumb.attr('class') == 'thumbs'){
                     thisThumb.addClass('thumbActive');
                     thisThumb.removeClass('thumbs');
                 }else{
                     thisThumb.addClass('thumbs');
                     thisThumb.removeClass('thumbActive');
                 }
                 
              });
            });
            $('.subTitle').click(function(){
                $(this).parent().find('.hidden').toggle();
            });
            $('.deleteFilter').click(function(){
                $.ajax({
                type: "POST",
                url: '{siteUrl}ajax/removeFilter/'+$(this).parent().attr('rel')+'/'+$(this).parent().attr('value'),
                data: { null:0}
              }).done(function( msg ) {
                 $('#encapsuledDeals').html(msg);
              });
            });
});
 </script>
 <div class="filters">
     <div class="selectedFilters">
         <div class="title">SEARCH</div>
         <div class="content">
             <ul>
                 {filters}
                 <li val="{name}" rel="{typeText}" class="selectedFiltersLi"><div class="deleteFilter"></div><div class="Type">{type}</div>{value}<div class="clear"></div></li>
                 {/filters}
                 <li id="deleteAllFilters">DELETE ALL</li>
             </ul>
         </div>
     </div>
     <div class="filtersToSelect">
        <div class="title">FILTER BY</div>
         <div class="content">
             <div class="categoryFilter">
                 <ul class="filterList">
                     <li class="subTitle">CATEGORY<div class="arrowFilter"></div></li>
                   {categories}
                   <li rel="{id}" class="hidden"><a href="{siteUrl}{url}">{name}({qtyDeals})</a></li>
                   {/categories}
                </ul>
             </div>
             <div class="subcategoryFilter">
                 <ul class="filterList">
                    <li class="subTitle">SUB-CATEGORY<div class="arrowFilter"></div></li>
                   {subCategories}
                   <li rel="{id}" class="hidden"><a href="{siteUrl}{url}">{name}({qtyDeals})</a></li>
                   {/subCategories}
                </ul>
             </div>
             <div class="subcategoryFilter">
                 <ul class="filterList">
                    <li class="subTitle">STORES<div class="arrowFilter"></div></li>
                   {stores}
                   <li rel="{deal_source_id}" class="hidden"><a href="{siteUrl}{url}">{name}({qtyDeals})</a></li>
                   {/stores}
                </ul>
             </div>
             
         </div>
     </div>
 </div>
 <div class="listDeals">
     <div class="list">
         <div class="topBarDeals">
             <div class="countDeals">{totalDeals} Deals was found</div>
             <div class="orderByDeals">{orderDeals}</div>
             <div class="clear"></div>
         </div>
         <ul class="deals">
             {deals}
             <?php include('widgets/dealListElem_new.php')?>
            {/deals}
            <div class="clear"></div>
         </ul>
     </div>
     <div class="paginator"><div class="paginData">{paginator}</div></div>
 </div>
    <div class="clear"></div>
</div>
</div>
