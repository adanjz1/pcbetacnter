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
                $(this).parent().find('.elemToFilter').toggle();
            });
            $('.deleteFilter').click(function(){
                if($('#linkGoTo').val() || ($('#linkGoToCat').val() && $(this).attr('rel') == 'subcategories')){
                    document.location= "/"+$(this).attr('link');
                }else{
                
                    $('#encapsuledDeals').html($('#encapsuledDeals').html()+'<div class="overlayLoading"></div><img class="overOver" src="/media/images/new/loading.gif">');
                    $.ajax({
                    type: "POST",
                    url: '{siteUrl}ajax/removeFilter/'+$(this).parent().attr('rel')+'/'+$(this).parent().attr('val')+'/'+$('#urlFlag').val(),
                    data: { null:0}
                  }).done(function( msg ) {
                     $('#encapsuledDeals').html(msg);
                     if($('.paginData').html() == ''){
                         $('.paginator').hide();
                     }
                  });
                }
            });
            $('.elemToFilter').click(function(){
                if($('#linkGoTo').val() || ($('#linkGoToCat').val() && $(this).attr('rel') == 'subcategories')){
                    document.location= "/"+$(this).attr('link');
                }else{
                    $('#encapsuledDeals').html($('#encapsuledDeals').html()+'<div class="overlayLoading"></div><img class="overOver" src="/media/images/new/loading.gif">');
                        $.ajax({
                        type: "POST",
                        url: '{siteUrl}ajax/addFilter/'+$(this).attr('rel')+'/'+$(this).attr('val')+'/'+$('#urlFlag').val(),
                        data: { null:0}
                      }).done(function( msg ) {
                         $('#encapsuledDeals').html(msg);
                         if($('.paginData').html() == ''){
                             $('.paginator').hide();
                         }
                      });
                  }
            });
            $('.goArrow').click(function(){
                $('#encapsuledDeals').html($('#encapsuledDeals').html()+'<div class="overlayLoading"></div><img class="overOver" src="/media/images/new/loading.gif">');
                $.ajax({
                type: "POST",
                url: '{siteUrl}ajax/addPrice/'+$(this).parent().find('#priceMin').val()+'/'+$(this).parent().find('#priceMax').val(),
                data: { null:0}
              }).done(function( msg ) {
                 $('#encapsuledDeals').html(msg);
                 if($('.paginData').html() == ''){
                     $('.paginator').hide();
                 }
              });
            });
            $('.displayable').click(function(){
                $(this).parent().find('.orderHidden').toggle();
            });
            $('.orderHidden').click(function(){
                 $('#encapsuledDeals').html($('#encapsuledDeals').html()+'<div class="overlayLoading"></div><img class="overOver" src="/media/images/new/loading.gif">');
                $.ajax({
                type: "POST",
                url: '{siteUrl}ajax/addOrder/'+$(this).attr('val')+'/'+$(this).attr('rel'),
                data: { null:0}
              }).done(function( msg ) {
                 $('#encapsuledDeals').html(msg);
                 if($('.paginData').html() == ''){
                     $('.paginator').hide();
                 }
              });
                
            });
});
 </script>
 <input type="hidden" value="<?=$linkGoToCat?>" id="linkGoToCat">
 <input type="hidden" value="<?=$linkGoTo?>" id="linkGoTo">
 <input type="hidden" value="<?=$urlFlag?>" id="urlFlag">
 <div class="filters">
     <div class="selectedFilters">
         <div class="title">SEARCH</div>
         <div class="content">
             <ul>
                 {filters}
                 <li val="{name}" rel="{typeText}" class="selectedFiltersLi"><div class="deleteFilter"></div><div class="Type">{type}</div>{value}<div class="clear"></div></li>
                 {/filters}
                 {deleteAllFilter}
             </ul>
         </div>
     </div>
     <div class="filtersToSelect">
        <div class="title">FILTER BY</div>
         <div class="content">
             <?php
                $filterCat = '<div class="categoryFilter">
                 <ul class="filterList">
                     <li class="subTitle">CATEGORY<div class="arrowFilter"></div></li>
                   {categories}
                   <li val="{id}" rel="categories" link="{url}" class="elemToFilter">{name}({dealsQty})</li>
                   {/categories}
                </ul>
             </div>';
                $subCatFilter = '<div class="subcategoryFilter">
                 <ul class="filterList">
                    <li class="subTitle">SUB-CATEGORY<div class="arrowFilter"></div></li>
                   {subCategories}
                   <li val="{id}" rel="subcategories" link="{url}" class="elemToFilter">{name}({dealsQty})</li>
                   {/subCategories}
                </ul>
             </div>
             <div class="subcategoryFilter">
                 <ul class="filterList">
                    <li class="subTitle">STORES<div class="arrowFilter"></div></li>
                   {stores}
                   <li val="{deal_source_id}" rel="stores" link="{url}" class="elemToFilter">{name}({dealsQty})</li>
                   {/stores}
                </ul>
             </div>
             <div class="priceFilter">
                 <ul class="filterList">
                    <li class="subTitle">Price</li>
                   
                    <li rel="price">u$s <input type="text" id="priceMin" value="0"/> to u$s <input type="text" id="priceMax" value="0"/><div class="arrowFilter goArrow"></div></li>
                   
                </ul>
             </div>';
                if(!empty($catSelected)){
                    echo $subCatFilter;
                    echo $filterCat;
                }else{
                    echo $filterCat;
                    echo $subCatFilter;
                }
             ?>
             
             
             
         </div>
     </div>
 </div>
 <div class="listDeals">
     <div class="list">
         <div class="topBarDeals">
             <div class="countDeals">{totalDeals} Deals was found</div>
             <div class="orderByDeals"><div class="text">Sort by: </div><div class="orderList">{orderDeals}</div></div>
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