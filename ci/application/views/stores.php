<div class="leftcol">
    <div class="latest_deal">
        <div class="left_top">
            <h1>Newest Online Coupons</h1>
        </div>
        <div class="left_mid">
            <div id='carousel_container' class="carousel_container">
                <div id='left_scroll' style="width:28px; float:left; z-index:1000;">
                    <a href='javascript:slide("left");'>
                        <img src='http://pccounter.net/ci/media/images/left.png' width="26" height="60" border="0" />
                    </a>
                </div>
                <div id='carousel_inner' style="width:715px; float:left; z-index:0; overflow:hidden; padding-left:2px;">
                    <ul id='carousel_ul'>
                       {stores}
                            <li style="background-color:transparent;">
                                <a href="{dealsStore}{deal_source_id}" style="display: table-cell;vertical-align: middle;height: 60px;">
                                    <img src="{image}" style="max-width:80px;max-height:60px;" border="0" />    
                                </a>
                            </li>
                        {/stores}		            
                    </ul>
                </div>
                <div id='right_scroll' style="width:30px; float:left;">
                    <a href='javascript:slide("right");'>
                        <img src='http://pccounter.net/ci/media/images/right.png' width="26" height="60" border="0"/>
                    </a>
                </div>
                <input type='hidden' id='hidden_auto_slide_seconds' value=0 />
            </div>
        </div>
        <div class="left_bot"></div>
    </div>
    <div class="clear"></div>
    <div class="latest_deal">
        <div class="left_top">
            <h1>Stores</h1>
        </div>
        <div class="left_mid">
            <div class="alpha_text">
                <ul>
                    <li>
                        {initials}
                            <a href="{storesUrlBrandSearch}{id}">{id}</a>  |  
                        {/initials}
                       
                    </li>
                    <li style="margin: 6px 0;">
                        <a href="{storesUrl}">
                            <img src="http://pccounter.net/ci/media/images/all_btn.gif" alt="" width="89" height="22" border="0"/>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="clear"></div>
            <div class="store_bg">
            {stores2}

                            <div class="store_box">
                                <ul class="store_box_left">
                                    <li>
                                        
                            
                                            <a href="{dealsStore}{deal_source_id}"><img src="{image}" alt="" style="max-width: 102px;max-height: 42px;" border="0"/></a>
                               
                                    </li>
                                </ul>
                                <ul class="store_box_right">
                                    <li>
                                        <a href="{dealsStore}{deal_source_id}">{name}</a>
                                    </li>
                                </ul>
                            </div>
                       {/stores2}               
                       
                        <div class="clear"></div>
                        <div class="paginator">{paginator}</div>
                        {noStores}
            </div>
        </div>
        <div class="left_bot"></div>
    </div>
    <div class="clear"></div>
</div>