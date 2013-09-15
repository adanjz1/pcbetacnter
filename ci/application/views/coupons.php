<script>
    function chkCatCoupan(){
        document.location = '{couponsPaginatorUrl}'+'/'+$('#cat_id').val();
    }
</script>
<div class="leftcol">
    <div class="latest_deal">
        <div class="left_top">
            <h1>Online Coupons<div style="float:right; margin-top:12px;">

                    <select name="cat_id" id="cat_id" onchange="chkCatCoupan();">
                        <option value="___0">-- Select Category --</option>
                        {categories}
                        <option value="___{id}" {selected}>{name}</option>
                        {/categories}
                    </select>
                </div></h1>

        </div>
        <div class="left_mid">
            {deals}
            <div class = "coupon_box">
                <div class = "coupon" style = "margin: 10px auto 0 6px;">
                    <img src="{image}"  alt="{display_name}" border="0" width="162" height="77"  class="border"/>
                </div>
                <div class="coupon" style="width: 184px; padding: 0 0 0 19px;">
                    <ul>
                        <li><h1>{display_name}</h1></li>
                        <li><span>From: {provider}</span></li>
                    </ul>
                </div>
                <div class="coupon" style="width: 230px;">
                    <ul>
                        <?php if('{actual_price}' != '0.00') { ?>
                        <li style="display:none">List Price: <strong>${actual_price}</strong></li>
                        <?php } ?>

                        <li class="price">
                            Price: 
                            <span class="redtext">
                                ${deal_price}
                            </span> 
                            <strong>
                                + FREE SHIPPING
                            </strong>
                        </li>
                        <li>You Save: <span class="redtext">({savingsPercentage}%)</span></li>
                    </ul>
                </div>
                <div class="coupon" style="border:0; width: 160px;">

                    

                    <div class="buy">
                        <div class="pricing-container"></div>
                         <div class="button-outer code" data-href="{deal_url}">
                            <a target="_blank">
                                <div class="button code">
                                    <div class="coupon-code">
                                       {couponCode}
                                    </div>
                                    <div style="width: 93px;" class="button-inner code">Reveal Code</div>
                                    <div style="left: 95px;" class="peelie">&nbsp;</div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            {/deals}

            <style>
                .pagination{
                    width: 100%;
                    height: auto;
                }
                .pagination a{
                    font: normal 12px/26px Arial, Helvetica, sans-serif;
                    background: #f0f0f0;
                    padding: 0 6px;
                    color: #333;
                    float: left;
                    margin-right:2px;
                }
                .pagination a:hover, .pagination span.disabled:hover, .pagination a.next:hover{
                    background: #333;
                    color: #fff;
                    text-decoration: none;
                }
                .pagination span.disabled{
                    font: normal 12px/26px Arial, Helvetica, sans-serif;
                    background: #f0f0f0;
                    padding: 0 6px;
                    float: left;
                    margin-right:2px;
                }
                .pagination a.next{
                    font: normal 12px/26px Arial, Helvetica, sans-serif;
                    background: #f0f0f0;
                    padding: 0 6px;
                    float: right;
                    margin-right:12px;
                }
                .pagination span.current{
                    font: normal 12px/26px Arial, Helvetica, sans-serif;
                    background: #333;
                    padding: 0 6px;
                    color: #fff;
                    float: left;
                    margin-right:2px;
                }
            </style>

            <div class="paginator">{paginator}</div>
            
            {noCoupons}
        </div>
        <div class="left_bot"></div>
    </div>
</div>