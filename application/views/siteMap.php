<div class="leftcol">
    <div class="latest_deal">
        <div class="left_top"><h1>{pageName}</h1></div>
        <div class="left_mid">
            <div class="categories"><h1 style="color:#000;">CATEGORIES</h1></div>
            <div class="clear"></div>
            {categories}
            <div class="categories">
                <a href="{categoryUrl}"><h1>{name}</h1></a>
                <div>
                    <ul>
                        {subcategories}
                        <li><a href="{subUrl}">{subName}</a></li>
                        {/subcategories}
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
            {/categories}
            <div class="categories"><h1 style="color:#000;">SPECIAL FEATURES</h1></div>
            <div class="clear"></div>
            <div class="categories">
                <h1>Special offers</h1>
                <div>
                    <ul>
                        {specialPages_1}
                        <li><a href="{specialPageUrl}">{name}</a></li>
                        {/specialPages_1}
                        {specialPages_2}
                        <li><a href="{specialPageUrl}">{name}</a></li>
                        {/specialPages_2}
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
            <div class="categories"><h1 style="color:#000;">PCCOUNTER.NET</h1></div>
            <div class="clear"></div>
            <div class="categories">
                <h1>Page info</h1>
                <div>
                    <ul>
                        {staticPages}
                        <li><a href="{url}">{name}</a></li>
                        {/staticPages}
                       
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="left_bot"></div>
    </div>
    <div class="clear"></div>
</div>