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
            $('.orderHidden').click(function(){
               document.location=$(this).attr('url');
                
            });
            $('.subTitle').click(function(){
                $(this).parent().find('.elemToFilter').toggle();
            });
            $('#deleteAllFilters').click(function(){
                  $.ajax({
                    type: "POST",
                    url: '{siteUrl}ajax/c_removeAllFilters/',
                    data: { null:0}
                  }).done(function( msg ) {
                     $('#encapsuledDeals').html(msg);
                     if($('.paginData').html() == ''){
                         $('.paginator').hide();
                     }
                  });
            });
            $('.deleteFilter').click(function(){
                if($('#linkGoTo').val() || ($('#linkGoToCat').val() && $(this).attr('rel') == 'subcategories')){
                    document.location= "/"+$(this).attr('link');
                }else{
                
                    $('#encapsuledDeals').html($('#encapsuledDeals').html()+'<div class="overlayLoading"></div><img class="overOver" src="/media/images/new/loading.gif">');
                    $.ajax({
                    type: "POST",
                    url: '{siteUrl}ajax/c_removeFilter/c_'+$(this).parent().attr('rel')+'/'+$(this).parent().attr('val')+'/'+$('#urlFlag').val(),
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
                        url: '{siteUrl}ajax/c_addFilter/c_'+$(this).attr('rel')+'/'+$(this).attr('val')+'/'+$('#urlFlag').val(),
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
                url: '{siteUrl}ajax/c_addPrice/'+$(this).parent().find('#priceMin').val()+'/'+$(this).parent().find('#priceMax').val(),
                data: { null:0}
              }).done(function( msg ) {
                 $('#encapsuledDeals').html(msg);
                 if($('.paginData').html() == ''){
                     $('.paginator').hide();
                 }
              });
            });
            
            $('.orderHidden').click(function(){
                 $('#encapsuledDeals').html($('#encapsuledDeals').html()+'<div class="overlayLoading"></div><img class="overOver" src="/media/images/new/loading.gif">');
                $.ajax({
                    type: "POST",
                    url: '{siteUrl}ajax/c_addOrder/'+$(this).attr('val')+'/'+$(this).attr('rel'),
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
                 <?php 
                 if(!empty($filters)){ 
                     echo $deleteAllFilter; 
                    } 
                 ?>
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
                   <li val="{id}" rel="categories" link="{couponCatUrl}" class="elemToFilter">{name}({couponsQty})</li>
                   {/categories}
                </ul>
             </div>';
                $subCatFilter = '<div class="subcategoryFilter">
                 <ul class="filterList">
                    <li class="subTitle">SUB-CATEGORY<div class="arrowFilter"></div></li>
                   {subCategories}
                   <li val="{id}" rel="subcategories" link="{couponUrl}" class="elemToFilter">{name}({couponsQty})</li>
                   {/subCategories}
                </ul>
             </div>
             <div class="subcategoryFilter">
                 <ul class="filterList">
                    <li class="subTitle">STORES<div class="arrowFilter"></div></li>
                   {stores}
                   <li val="{deal_source_id}" rel="stores" link="{couponUrl}" class="elemToFilter">{name}({couponsQty})</li>
                   {/stores}
                </ul>
             </div>
             ';
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
 
 <div class="listDeals coupons">
     <div class="list">
         <div class="topBarDeals">
             <div class="countDeals">{totalDeals} Coupons was found</div>
                         <div class="orderByDeals"><div class="text">Sort by: </div><div class="orderList">{orderDeals}</div></div>
             <div class="clear"></div>
         </div>
         <ul class="deals">
             {deals}
             <?php include('widgets/couponListElem_new.php')?>
            {/deals}
            <div class="clear"></div>
         </ul>
     </div>
     <div class="paginator"><div class="paginData">{paginator}</div></div>
 </div>
    <div class="clear"></div>
</div>
</div>