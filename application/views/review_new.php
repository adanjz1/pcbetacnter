<div class="reviewBox">
<script src="http://pccounter.net/media/js/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="http://pccounter.net/media/css/SpryTabbedPanels.css" rel="stylesheet" type="text/css"/>
<script language=javascript>
    $(document).ready(function(){
        $('.TabbedPanelsTab').click(function(){
            $('.TabbedPanelsTabSelected').removeClass('TabbedPanelsTabSelected');
            $('.TabbedPanelsContent').hide();
            $('#'+$(this).attr('rel')).show();
            $(this).addClass('TabbedPanelsTabSelected');
            
        });
    });
  function selstar(val,field,name)
  {
  	for(var x=1;x<=10;x++)
	{
		$('#'+name+x).attr('src',"http://pccounter.net/media/images/star1.gif");
	}
	for(var x=1;x<=val;x++)
	{
            $('#'+name+x).attr('src',"http://pccounter.net/media/images/star2.gif");
	}
	document.getElementById(field).value = val;
	
  }
  function remstar(val)
  {
	for(var x=1;x<=val;x++)
	{
		document[name+x].src="http://pccounter.net/media/images/star1.gif";
	}
  }

  function setrate(val,field,name)
  {
  //alert(val);
  //alert(field);
  //alert(name);
  for(var x=1;x<=val;x++)
	{
		document[name+x].src="images/star2.gif";
	}
	document.getElementById(field).value = val;
  }
  
  function textCounter(field,cntfield,maxlimit) {
	if (field.value.length > maxlimit) // if too long...trim it!
	field.value = field.value.substring(0, maxlimit);
	// otherwise, update 'characters left' counter
	else
	cntfield.value = maxlimit - field.value.length;
 }
 </script>
 <script type="text/javascript">
	var name = new Array();
	name[0]= "images/star2.gif";
	if(document.images)
	{
		var ss = new Image();
		ss.src = name[0];	
		//alert(ss.src);	
	}			
</script>
{deal}
<div class="leftcol">
    <div class="latest_deal">
        <div class="topReview">
            <div class="image">
                <img src="{image_url}"/>
            </div>
            <div class="description">
                <div class="title">
                    <a href="{deal_url}">{display_name}</a>
                </div>
                <div class="storeDesc">
                    From {provider}
                </div>
                <div class="priceDesc">
                    {showActualPrice}
                    Price: <span class="textred">${deal_price}</span><br/>
                    {showSavings}
                </div>
                <div class="btnGetDeal">
                    <a class="dealBtn" href="{deal_url}" target="_blank">
                        <div class="getDealStr">GET THIS DEAL</div>
                    </a>
                </div>
                <div class="status">
                    {qtyComments} Comment (s) | {qtyReviews} Review (s)
                </div>
                <div class="messageSaved">
                    {message}
                </div>
            </div>
            <div class="clear"></div>
        </div>

    

    <div id="TabbedPanels1" class="TabbedPanels">
        <ul class="TabbedPanelsTabGroup">
            <li class="TabbedPanelsTab TabbedPanelsTabSelected" rel="desc" tabindex="0" style="border-bottom:0;">Deal Description</li>	    
            <li class="TabbedPanelsTab" rel="rev" tabindex="0" style="border-bottom:0;">Reviews</li>    
        </ul>
        <div class="TabbedPanelsContentGroup">  
            
            
            <div class="TabbedPanelsContent {descriptionForm}" id="desc">
                <div class="sumit_base">
                    <h1>{title}</h1> 
                </div> 
                {description}
            </div>
            <div class="TabbedPanelsContent {reviewForm}" id="rev">
                <div class="average">
                    Average Rating {avgStars} Total:  {itemsDescribed}
                </div>          
                <div class="reviews_base">
                    <form name="rateform" method="post" action="{dealReviewForm}" onsubmit="return validate_feedback();">
                        <input name="productid" id="productid" type="hidden" value="{id}" />
                        <table width="920" border="0" align="center" cellpadding="0" cellspacing="0" class="reply_box">

                            <tr>
                                <td width="200"><strong style="font-size:14px; color:#ff6600; display:inline-block; padding-bottom:10px;">Detailed Product Rating </strong></td>
                                <td>&nbsp;</td>
                            </tr>

                            <tr>
                                <td><strong>Item as described</strong></td>
                                <td>
                                    <input type="hidden" name="item_rating" value="{rate_item}" id="item_rating" />
                                    <?php
                                    for ($i = 1; $i <= 10; $i++) {
                                        if ('{counter}' == '') {
                                            $counter = 1;
                                        } else {
                                            $counter = '{counter}';
                                        }
                                        if ($i <= '{starPerc}') {
                                            ?>
                                            <img name=i<?= $i ?> id="i<?= $i ?>" class=star onmouseover="selstar(<?= $i ?>, 'item_rating', 'i')" onclick="setrate(<?= $i ?>, 'item_rating', 'i')" src="http://pccounter.net/media/images/star2.gif">&nbsp;&nbsp;
                                            <?php
                                        } else {
                                            ?>
                                            <img name=i<?= $i ?> id="i<?= $i ?>" class=star onmouseover="selstar(<?= $i ?>, 'item_rating', 'i')" onclick="setrate(<?= $i ?>, 'item_rating', 'i')" src="http://pccounter.net/media/images/star1.gif">&nbsp;&nbsp;
                                            <?php
                                        }
                                    }
                                    ?>
                                    <span style="font: normal 12px/18px Arial, Helvetica, sans-serif;">(Rate It)</span>		
                                </td>
                            </tr>                




                            <tr>
                                <td valign="top"><strong>Write Comment</strong></td>
                                <td><textarea name="feedbk_cont" cols="115" rows="10"></textarea></td>
                            </tr>
                            <tr>
                                <td>
                                    {formSubmitted}
                                </td>
                                <td><input name="feedbk_btn" type="submit" class="btnCommentSubmit" value="Submit"/></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="latest_deal" id="bottom" style="margin-top: 10px;">
        
        <div class="left_mid">

            <table width="97%" border="0" align="center" cellspacing="0" cellpadding="0">
                <tr>
                    <td style="font: bold 15px Arial, Helvetica, sans-serif;	color: #737373; padding-top:12px;">{qtyComments} Comment(s) received</td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="filter_box">
                            <tr>
                                <th width="5%">&nbsp;</th>
                                <th width="15%"><strong>Serial Number</strong></th>
                                <th width="40%"><strong>Comment</strong></th>
                                <th width="5%">&nbsp;</th>
                                <th width="35%"><strong>Date</strong></th>
                            </tr>
                            {comments}
                            <tr>
                                <td width="5%">&nbsp;</td>
                                <td width="15%">{comId}</td>
                                <td width="40%">
                                    {review}
                                </td>
                                <td width="5%">&nbsp;</td>
                                <td width="35%"><?php echo date("F j, Y, g:i a", strtotime('{datetime}')); ?></td>
                            </tr>
                            {/comments}
                            {noComments}


                        </table>
                    </td>
                </tr>                   
            </table>

            <div class="clear"></div>  
        </div>
        <div class="left_bot"></div>
    </div>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>           
            </div>
            <div class="clear"></div>      
        </div>
    </div>

    <div class="clear"></div>

    

</div>
{/deal}
</div>
</div>
</div>