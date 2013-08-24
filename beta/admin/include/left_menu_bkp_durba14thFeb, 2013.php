<div id="sidebar">					
	<!-- List Starts -->
	<h2>Navigation</h2>
	<ul>
	<?php
		$select_links=mysql_query("select * from ".TABLE_ADMIN." where admin_id = '".$_SESSION['admin_id']."'");
		$links=mysql_fetch_assoc($select_links);
		
		$link_id=explode(",",$links['access_link_id']);
				
				$len=count($link_id);
		
		if($links['user_type']=='B')
		{
			for($i=1;$i<$len;$i++)
			{
				if($link_id[$i]=='1') 
				{
	?>
					<!--Admin Home Starts-->
					<li><a href="admin_user_manager.php" title="Admin User Manager" class="tooltip">Admin User Manager</a>
						<ul>
							<li><a href="admin_user_manager.php?mode=add" title="Add Admin User" class="tooltip">Add Admin User</a></li>
							<li><a href="subadmin.php?mode=add" title="Add Sub Admin User" class="tooltip">Add Sub Admin User</a></li>
							<li><a href="subadmin.php" title="View Sub Admin User" class="tooltip">View Sub Admin User</a></li>
						</ul>
					</li>
					<!--Admin Home Ends-->
	<?php
				}
			}	
			for($i=1;$i<$len;$i++)
			{
				if($link_id[$i]=='2') 
				{	
	?>
					<!--Setting Starts-->
					<li><a href="#" title="Admin User Manager" class="tooltip">Setting</a>
						<ul>
							<li><a href="general.php?general_id=1&&mode=edit" title="General" class="tooltip">General Configuration</a></li>
							<li><a href="logo.php" title="Logo Manager" class="tooltip">Logo Settings</a></li>
							<li><a href="metadetails.php?meta_id=1&&mode=edit" title="Edit Meta Details" class="tooltip">Edit Meta Details</a></li>
						</ul>
					</li>
					<!--Setting Ends-->
	<?php
				}
			}	
			for($i=1;$i<$len;$i++)
			{
				if($link_id[$i]=='3') 
				{	
	?>
					<!--Banner Management Starts-->
					<li><a href="#" title="Users Manager" class="tooltip">Banner Management</a>
						<ul>
							<li><a href="banner.php" title="Users Manager" class="tooltip">Manage Banner</a></li>
							<li><a href="banner.php?mode=add_banner" title="Add Users" class="tooltip">Add Banner</a></li>
						</ul>
					</li>
					<!--Banner Management Ends-->
	<?php
				}
			}	
			for($i=1;$i<$len;$i++)
			{
				if($link_id[$i]=='4') 
				{	
	?>
					<!--Member Management Starts-->
					<li><a href="#" title="Users Manager" class="tooltip">Member Management</a>
						<ul>
							<li><a href="user_manager.php" title="Users Manager" class="tooltip">Manage Users</a></li>
							<li><a href="user_manager.php?mode=add" title="Add Users" class="tooltip">Add Users</a></li>
							<!--<li><a href="request_info.php" title="Tequested Information" class="tooltip">Submitted Site Information</a></li>
							<li><a href="clickuser.php" title="Click User" class="tooltip">Number of Clicks for Deals</a></li>-->
						</ul>
					</li>
					<!--Member Management Ends-->
	<?php
				}
			}	
			for($i=1;$i<$len;$i++)
			{
				if($link_id[$i]=='5') 
				{	
	?>				
					<!--Category Management Starts-->
					<li><a href="#" title="Deal Manager" class="tooltip">Category Management</a>
						<ul>
							<li><a href="deal_category_manager.php?mode=add_cat" title="Add Category" class="tooltip">Add Deal Category</a></li>
							<li><a href="deal_category_manager.php" title="Categories Manager" class="tooltip">Manage Deal Category</a></li>
							<!--<li><a href="deal_sub_category_manager.php?mode=add_cat" title="Add Category" class="tooltip">Add Deal Sub-Category</a></li>
							<li><a href="deal_sub_category_manager.php" title="Categories Manager" class="tooltip">Manage Deal Sub-Category</a></li>-->
						</ul>
					</li>
					<!--Category Management Ends-->
	<?php
				}
			}	
			for($i=1;$i<$len;$i++)
			{
				if($link_id[$i]=='6') 
				{	
	?>				
					<!--Deal Store/Brand Management Starts-->
					<li><a href="#" title="Deal Manager" class="tooltip"><strong>Store/Brand Management</strong></a>
						<ul>
							<li><a href="dealconfig.php" title="Deal Configuration" class="tooltip">Manage Deal Store/Brand</a></li>
							<li><a href="dealconfig.php?mode=add_deal" title="Categories Manager" class="tooltip">Add Deal Store/Brand</a></li>
						</ul>
					</li>
					<!--Deal Store/Brand Management Ends-->
	<?php
				}
			}	
			for($i=1;$i<$len;$i++)
			{
				if($link_id[$i]=='7') 
				{	
	?>
					<!--Deal Configuration Management Starts-->
					<li><a href="#" title="Deal Manager" class="tooltip">Deals Management</a>
						<ul>
							<!--<li><a href="city_manager.php?mode=add" title="Add City" class="tooltip">Add City</a></li>
							<li><a href="city_manager.php" title="City Manager" class="tooltip">City Manager</a></li>
							<li><a href="country_manager.php?mode=add" title="Add Country" class="tooltip">Add Country</a></li>
							<li><a href="country_manager.php" title="Country Manager" class="tooltip">Country Manager</a></li>-->
							<li><a href="deal_manager.php?mode=add" title="Add Deal" class="tooltip">Add Deal</a></li>
							<li><a href="deal_manager.php" title="Deal Manager" class="tooltip">Manage Deals</a></li>
							<!--<li><a href="feed_manager.php?mode=add" title="Add Feed" class="tooltip">Add Deal Source</a></li>
							<li><a href="feed_manager.php" title="Feed Manager" class="tooltip">Manage Deal Source</a></li>-->
						</ul>
					</li>
					<!--Deal Configuration Management Ends-->
	<?php
				}
			}	
			for($i=1;$i<$len;$i++)
			{
				if($link_id[$i]=='8') 
				{	
	?>				
					<!--Coupon Manager Starts-->
					<li><a href="#" title="Coupon Manager" class="tooltip">Coupons Management</a>
						<ul>
							<li><a href="dealconfig.php" title="Deal Configuration" class="tooltip">Coupons Configuration</a></li>
							<li><a href="deal_category_manager.php?mode=add_cat" title="Add Category" class="tooltip">Add Coupon Category</a></li>
							<li><a href="deal_category_manager.php" title="Categories Manager" class="tooltip">Manage Coupon Category</a></li>
							<li><a href="coupon_manager.php?mode=add" title="Add Coupon" class="tooltip">Add Coupon</a></li>
							<li><a href="coupon_manager.php" title="Coupon Manager" class="tooltip">Manage Coupons</a></li>
						</ul>
					</li>
					<!--Coupon Manager Starts-->
					
	<?php
				}
			}	
			for($i=1;$i<$len;$i++)
			{
				if($link_id[$i]=='9') 
				{	
	?>
					<!--General Management Starts-->
					<li><a href="#" title="Banner Manager" class="tooltip">General</a>
						<ul>
							<!--<li><a href="mile_manager.php?mode=add" title="Add Miles" class="tooltip">Add Miles</a></li>
							<li><a href="mile_manager.php" title="Manage Miles" class="tooltip">Manage Miles</a></li>-->
							<li><a href="content_manager.php" title="Content Manager" class="tooltip">Manage Static Pages</a></li>
							<li><a href="newslettermanage.php?mode=add" title="Newsletter" class="tooltip">Add Newsletter</a></li>
							<li><a href="newslettermanage.php" title="Newsletter" class="tooltip">Manage Newsletter</a></li>
							<!--<li><a href="emailtemplate.php" title="Email Template" class="tooltip">Email Template</a></li>-->
							<li><a href="newsletter.php" title="Newsletter" class="tooltip">Manage Daily Deals Newsletter</a></li>
						</ul>				
					</li>
					<!--General Management Ends-->
	<?php
				}
			}	
			for($i=1;$i<$len;$i++)
			{
				if($link_id[$i]=='10') 
				{	
	?>
					<!--Parsing Manager Starts-->
					<li><a href="parsing_manager.php" title="Parsing Manager" class="tooltip">Parsing Manager</a></li>
					<!--Parsing Manager Ends-->
	<?php
				}
			}
		}
		else
		{
	?>
			<!--Admin Home Starts-->
			<li><a href="admin_user_manager.php" title="Admin User Manager" class="tooltip"><strong>Admin User Manager</strong></a>
				<ul>
					<li><a href="admin_user_manager.php?mode=add" title="Add Admin User" class="tooltip">Add Admin User</a></li>
					<li><a href="subadmin.php?mode=add" title="Add Sub Admin User" class="tooltip">Add Sub Admin User</a></li>
					<li><a href="subadmin.php" title="View Sub Admin User" class="tooltip">View Sub Admin User</a></li>
				</ul>
			</li>
			<!--Admin Home Ends-->
			
			<!--Setting Starts-->
			
			<!--<li><a href="#" title="Admin User Manager" class="tooltip"><strong>Setting</strong></a>
				<ul>
					<li><a href="general.php?general_id=1&&mode=edit" title="General" class="tooltip">General Configuration</a></li>
					<li><a href="logo.php" title="Logo Manager" class="tooltip">Logo Settings</a></li>
					<li><a href="metadetails.php?meta_id=1&&mode=edit" title="Edit Meta Details" class="tooltip">Edit Meta Details</a></li>
				</ul>
			</li>-->
			
			<!--Setting Ends-->
			
			<!--Banner Management Starts-->
			<li><a href="#" title="Users Manager" class="tooltip"><strong>Banner Management</strong></a>
				<ul>
					<li><a href="banner.php" title="Users Manager" class="tooltip">Manage Banner</a></li>
					<li><a href="banner.php?mode=add_banner" title="Add Users" class="tooltip">Add Banner</a></li>
				</ul>
			</li>
			<!--Banner Management Ends-->
			
			<!--Member Management Starts-->
			<li><a href="#" title="Users Manager" class="tooltip"><strong>Member Management</strong></a>
				<ul>
					<li><a href="user_manager.php" title="Users Manager" class="tooltip">Manage Users</a></li>
					<li><a href="user_manager.php?mode=add" title="Add Users" class="tooltip">Add Users</a></li>
					<!--<li><a href="request_info.php" title="Tequested Information" class="tooltip">Submitted Site Information</a></li>
					<li><a href="clickuser.php" title="Click User" class="tooltip">Number of Clicks for Deals</a></li>-->
				</ul>
			</li>
			<!--Member Management Ends-->
			
			<!--Category Management Starts-->
			<li><a href="#" title="Deal Manager" class="tooltip"><strong>Category Management</strong></a>
				<ul>
					<li><a href="deal_category_manager.php?mode=add_cat" title="Add Category" class="tooltip">Add Deal Category</a></li>
					<li><a href="deal_category_manager.php" title="Categories Manager" class="tooltip">Manage Deal Category</a></li>
					<!--<li><a href="deal_sub_category_manager.php?mode=add_cat" title="Add Category" class="tooltip">Add Deal Sub-Category</a></li>
					<li><a href="deal_sub_category_manager.php" title="Categories Manager" class="tooltip">Manage Deal Sub-Category</a></li>-->
				</ul>
			</li>
			<!--Category Management Ends-->
			
			<!--Deal Store/Brand Management Starts-->
			<li><a href="#" title="Deal Manager" class="tooltip"><strong>Store/Brand Management</strong></a>
				<ul>
					<li><a href="dealconfig.php" title="Deal Configuration" class="tooltip">Manage Deal Store/Brand</a></li>
					<li><a href="dealconfig.php?mode=add_deal" title="Categories Manager" class="tooltip">Add Deal Store/Brand</a></li>
				</ul>
			</li>
			<!--Deal Store/Brand Management Ends-->
			
			<!--Deal Configuration Management Starts-->
			<li><a href="#" title="Deal Manager" class="tooltip"><strong>Deals Management</strong></a>
				<ul>
					<!--<li><a href="city_manager.php?mode=add" title="Add City" class="tooltip">Add City</a></li>
					<li><a href="city_manager.php" title="City Manager" class="tooltip">City Manager</a></li>
					<li><a href="country_manager.php?mode=add" title="Add Country" class="tooltip">Add Country</a></li>
					<li><a href="country_manager.php" title="Country Manager" class="tooltip">Country Manager</a></li>-->
					<li><a href="deal_manager.php?mode=add" title="Add Deal" class="tooltip">Add Deal</a></li>
					<li><a href="deal_manager.php" title="Deal Manager" class="tooltip">Manage Deals</a></li>
					<!--<li><a href="feed_manager.php?mode=add" title="Add Feed" class="tooltip">Add Deal Source</a></li>
					<li><a href="feed_manager.php" title="Feed Manager" class="tooltip">Manage Deal Source</a></li>-->
				</ul>
			</li>
			<!--Deal Configuration Management Ends-->
			
			<!--Coupon Manager Starts-->
			<li><a href="#" title="Coupon Manager" class="tooltip"><strong>Coupons Management</strong></a>
				<ul>
					<li><a href="coupon_manager.php?mode=add" title="Add Coupon" class="tooltip">Add Coupon</a></li>
					<li><a href="coupon_manager.php" title="Coupon Manager" class="tooltip">Manage Coupons</a></li>
				</ul>
			</li>
			<!--Coupon Manager Ends-->
			
			<!--General Management Starts-->
			<li><a href="#" title="Banner Manager" class="tooltip"><strong>General</strong></a>
				<ul>
					<!--<li><a href="mile_manager.php?mode=add" title="Add Miles" class="tooltip">Add Miles</a></li>
					<li><a href="mile_manager.php" title="Manage Miles" class="tooltip">Manage Miles</a></li>-->
					<li><a href="content_manager.php" title="Content Manager" class="tooltip">Manage Static Pages</a></li>
					<li><a href="newslettermanage.php?mode=add" title="Newsletter" class="tooltip">Add Newsletter</a></li>
					<li><a href="newslettermanage.php" title="Newsletter" class="tooltip">Manage Newsletter</a></li>
					<!--<li><a href="emailtemplate.php" title="Email Template" class="tooltip">Email Template</a></li>-->
					<li><a href="newsletter.php" title="Newsletter" class="tooltip">Manage Daily Deals Newsletter</a></li>
				</ul>				
			</li>
			<!--General Management Ends-->
			
			<!--Parsing Manager Starts-->
			<li><a href="parsing_manager.php" title="Parsing Manager" class="tooltip"><strong>Parsing Manager</strong></a></li>
			<!--Parsing Manager Ends-->
	<?php
		}
	?>
	</ul>					
	<!-- List Ends -->
</div>