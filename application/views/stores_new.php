
    <div class="latest_deal">
        <div class="left_mid">
            <div class="storeFinderBar">
                <ul>
                    <li>
                        {initials}
                            <a href="{storesUrlBrandSearch}{id}">{id}</a>
                        {/initials}
                            <a href="{storesUrl}" class="floatRight">
                                ALL STORES
                            </a>
                        <div class="clear"></div>
                    </li>
                </ul>
            </div>
            <div class="clear"></div>
            <div class="store_bg">
            <ul class="store_box">
            {stores}
                <li class="store {lastInRow}">
                    <div class="image">
                        <a href="{dealsStore}">
                            <img src="{image}" alt="" style="max-width: 102px;max-height: 42px;" border="0"/>
                        </a>
                    </div>
                    <div class="text">
                        <a href="{dealsStore}">{name}</a>
                    </div>
                </li>
           {/stores}  
                <li class="clear"></li>
           </ul>       
                <div class="clear"></div>
                <div class="paginator">{paginator}</div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    </div>