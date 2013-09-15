<div class="leftcol">
    <div class="latest_deal">
        <div class="left_top"><h1>{catHeader}</h1></div>
        <div class="left_mid">
            {categories}

            <div class="category_box">
                <div class="category_top">
                    <ul>
                        <li class="dc">
                            <a style="height:31px; width:187px; display:inline-block;" href="{subCategoryUrl}" >
                                {name}
                            </a>											  
                        </li>
                    </ul>
                </div>
                <div class="category_mid" style="text-align:center;">
                    <img src="http://pccounter.net/ci/media/images/categories/{image}" onclick="document.location='{dealCategoryUrl}' " alt="" style="max-width:147px; max-height: 133px; cursor:pointer;"  border="0"/>
                </div>
                <div class="category_bot"></div>
            </div>
            {/categories}    
            <div class="clear"></div>
            <div class="paginator">{paginator}</div>

            <div class="category_box">
                {noCategories}
            </div>
        </div>
        <div class="left_bot"></div>
    </div>
    <div class="clear"></div>
</div>