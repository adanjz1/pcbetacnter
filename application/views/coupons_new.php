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
            $('.displayable').click(function(){
                $(this).parent().find('.orderHidden').toggle();
            });
            $('.orderHidden').click(function(){
               document.location=$(this).attr('url');
                
            });
});
 </script>
 <div class="listDeals coupons">
     <div class="list">
         <div class="topBarDeals">
             <div class="countDeals">{totalDeals} Coupons was found</div>
             <div class="orderByDeals">
                 <div class="text">Category: </div>
                 <div class="orderList">    
                     {categoriesSelect}
                 </div>
             </div>
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