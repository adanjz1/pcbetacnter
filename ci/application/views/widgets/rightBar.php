
<script language="javascript" type="text/javascript">
	function newscheck()
	{
		if(document.newsletter.email.value.search(/\S/) == -1)
		{
			document.getElementById("err_email").innerHTML="Please enter email to subscribe";
			document.newsletter.email.value="";
			document.newsletter.email.focus();
			return false;
		}
		else
		{
			document.getElementById("err_email").innerHTML="";
		}
	}
</script>

		<div class="rightcol">
		
			<!--NEWSLETTER SECTION STARTS-->
			
				<form name="newsletter" method="post" onsubmit="return newscheck();">
				<input type="hidden" name="mode" value="addnewsletter" />
					<div class="right_box">
						<div class="right_top">
							<h1>Newsletter</h1>
						</div>
						<div class="right_mid">
							<h1>The Best Coupons & Deals</h1>
                                                        {newsletterMsg}
							<ul>
								<li>Get one daily email featuring our very best offers</li>
								<li><input type="text" class="search_bg1" name="email" placeholder="Enter Your Email address here"/>
								<br /><span style="color:#FF0000;" id="err_email"></span>
								</li>
								<li><input type="submit" name="Submit2" class="search_btn1" value=""/></li>
								<li><span><a href="{static_sampleEmailUrl}">Sample Email</a>  |  <a href="{static_privacyPolicyUrl}">Privacy Policy</a></span></li>
							</ul>
						</div>
						<div class="right_bot"></div>
					</div>
				</form>
				
			<!--NEWSLETTER SECTION STOPS-->
			
			<div class="clear"></div>
			
			<!--STORES AND BRANDS STARTS-->
			
				<div class="right_box">
					<div class="right_top">
						<h1>Stores & Brands</h1>
					</div>
					<div class="right_mid">
                                            {dealSources}
                                                <div class="pic_box">
                                                    <a href="{deal_source_url}"><img src="{image}" alt="" max-width="69" max-height="60" class="border" border="0"/></a>   
                                                </div>
                                            {/dealSources}
					</div>
					<div class="right_bot"></div>
				</div>
			
			<!--STORES AND BRANDS ENDS-->
			
			<div class="clear"></div>
			
			<!--OUR OFFERS CMS STARTS-->
			
			{rightBox}
			<div class="right_box">
				<div class="right_top">
					<h1>{title}</h1>
				</div>
				<div class="right_mid">
					{text}
				</div>
				<div class="right_bot"></div>
			</div>
                        {/rightBox}
			
			<!--OUR OFFERS CMS ENDS-->
			
			<div class="clear"></div>
			
			<!--LATEST BLOG POST STARTS-->
			
			<div class="right_box">
				<div class="right_top">
					<h1>Latest Blog Posts</h1>
				</div>
				<div class="right_mid">
					<ul>
                                            {blogPosts}
						
                                                <li style="padding: 13px 14px;">
                                                        <strong>{title}</strong><br/>
                                                        <span style="font: normal 11px/14px Arial, Helvetica, sans-serif; padding:0; margin: 0;">Posted {days} days ago by {author}</span>
                                                </li>
                                            {/blogPosts}
                                            {blogUrl}
                                            {noBlogPosts}
											
						<!--<li><strong>Labor Day 2012 Sales Roundup</strong><br/><span style="font: normal 11px/14px Arial, Helvetica, sans-serif; padding:0; margin: 0;">Posted 3 days ago by</span></li>
						<li style="padding: 13px 14px;"><strong>Best Back-to-School Devices for Apps</strong><br/><span style="font: normal 11px/14px Arial, Helvetica, sans-serif; padding:0; margin: 0;">
						Posted 2 days ago by</span></li>-->
					</ul>
				</div>
				<div class="right_bot"></div>
			</div>
			
			<!--LATEST BLOG POST ENDS-->
			
			<div class="clear"></div>
			
			<!--BANNER IMAGE STARTS HERE-->
			{banners_type1}
                            <div class="right_box">
                                    <img src="{image}" alt="" width="278" height="231" border="0"/>
                            </div>
			{/banners_type1}
			<!--BANNER IMAGE ENDS HERE-->
			
		</div>