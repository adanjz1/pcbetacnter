<script src='http://connect.facebook.net/en_US/all.js'></script>
<script>!function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (!d.getElementById(id)) {
                js = d.createElement(s);
                js.id = id;
                js.src = "//platform.twitter.com/widgets.js";
                fjs.parentNode.insertBefore(js, fjs);
            }
        }(document, "script", "twitter-wjs");
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
        <div class="left_top"><h1>ONLINE DEALS</h1></div>
        <div class="left_mid">
            {deals}
                <? include('widgets/dealListElem.php')?>
            {/deals}
            <div class="clear"></div>
            <div class="paginator">{paginator}</div>
            {noDeals}
        </div>
        <div class="left_bot"></div>
    </div>
    <div class="clear"></div>
</div>