<?php exit; ?>
a:9:{s:5:"title";s:13:"deals manager";s:5:"limit";s:2:"20";s:8:"frm_type";s:1:"2";s:4:"join";a:3:{s:12:"deal_sources";a:3:{i:0;s:5:"INNER";i:1;s:12:"deal_sources";i:2;s:51:"deals.deal_sources_id = deal_sources.deal_source_id";}s:10:"categories";a:3:{i:0;s:5:"INNER";i:1;s:10:"categories";i:2;s:28:"deals.cat_id = categories.id";}s:13:"subCategories";a:3:{i:0;s:5:"INNER";i:1;s:13:"subCategories";i:2;s:35:"deals.sub_cat_id = subCategories.id";}}s:11:"search_form";a:2:{i:0;a:2:{s:5:"alias";s:11:"Deal source";s:5:"field";s:21:"deals.deal_sources_id";}i:1;a:2:{s:5:"alias";s:11:"Subcategory";s:5:"field";s:16:"deals.sub_cat_id";}}s:8:"validate";a:7:{s:12:"deals.cat_id";a:2:{s:4:"rule";s:8:"notEmpty";s:7:"message";s:36:"Please enter the value for Category.";}s:16:"deals.sub_cat_id";a:2:{s:4:"rule";s:8:"notEmpty";s:7:"message";s:39:"Please enter the value for Subcategory.";}s:21:"deals.deal_sources_id";a:2:{s:4:"rule";s:8:"notEmpty";s:7:"message";s:39:"Please enter the value for Deal source.";}s:18:"deals.actual_price";a:2:{i:0;a:2:{s:4:"rule";s:8:"notEmpty";s:7:"message";s:46:"Please provide numeric input for Actual price.";}i:1;a:2:{s:4:"rule";s:7:"numeric";s:7:"message";s:46:"Please provide numeric input for Actual price.";}}s:16:"deals.deal_price";a:2:{i:0;a:2:{s:4:"rule";s:8:"notEmpty";s:7:"message";s:46:"Please provide numeric input for Before price.";}i:1;a:2:{s:4:"rule";s:7:"numeric";s:7:"message";s:46:"Please provide numeric input for Before price.";}}s:14:"deals.deal_url";a:2:{s:4:"rule";s:8:"notEmpty";s:7:"message";s:36:"Please enter the value for Deal Url.";}s:17:"deals.description";a:2:{s:4:"rule";s:8:"notEmpty";s:7:"message";s:39:"Please enter the value for Description.";}}s:9:"data_list";a:10:{s:16:"deals.deal_price";a:1:{s:5:"alias";s:12:"Before price";}s:18:"deals.actual_price";a:1:{s:5:"alias";s:12:"Actual price";}s:9:"deals.sku";a:1:{s:5:"alias";s:3:"SKU";}s:15:"deals.is_active";a:1:{s:5:"alias";s:7:"Active?";}s:18:"deals.display_name";a:1:{s:5:"alias";s:5:"Title";}s:17:"deals.coupon_code";a:1:{s:5:"alias";s:11:"Coupon Code";}s:29:"deal_sources.deal_source_name";a:1:{s:5:"alias";s:11:"Deal source";}s:15:"categories.name";a:1:{s:5:"alias";s:8:"category";}s:18:"subCategories.name";a:1:{s:5:"alias";s:11:"subCategory";}s:6:"action";a:4:{s:5:"alias";s:7:"Actions";s:6:"format";s:290:"<a type="button" onclick="__view('{ppri}'); return false;" class="btn btn-mini">View</a> <a type="button" onclick="__edit('{ppri}'); return false;" class="btn btn-mini btn-info">Edit</a> <a type="button" onclick="__delete('{ppri}'); return false;" class="btn btn-mini btn-danger">Delete</a>";s:5:"width";i:130;s:5:"align";s:6:"center";}}s:13:"form_elements";a:23:{s:18:"deals.display_name";a:2:{s:5:"alias";s:5:"Title";s:7:"element";a:2:{i:0;s:4:"text";i:1;a:1:{s:5:"style";s:12:"width:210px;";}}}s:15:"deals.image_url";a:2:{s:5:"alias";s:5:"Image";s:7:"element";a:2:{i:0;s:5:"image";i:1;a:3:{s:9:"thumbnail";s:6:"medium";s:5:"width";s:0:"";s:6:"height";s:0:"";}}}s:12:"deals.cat_id";a:2:{s:5:"alias";s:8:"Category";s:7:"element";a:2:{i:0;s:5:"radio";i:1;a:1:{i:1;s:15:"Computer storage";}}}s:16:"deals.sub_cat_id";a:2:{s:5:"alias";s:11:"Subcategory";s:7:"element";a:2:{i:0;s:12:"autocomplete";i:1;a:3:{s:12:"option_table";s:13:"subCategories";s:10:"option_key";s:2:"id";s:12:"option_value";s:4:"name";}}}s:21:"deals.deal_sources_id";a:2:{s:5:"alias";s:11:"Deal source";s:7:"element";a:2:{i:0;s:12:"autocomplete";i:1;a:3:{s:12:"option_table";s:12:"deal_sources";s:10:"option_key";s:14:"deal_source_id";s:12:"option_value";s:16:"deal_source_name";}}}s:9:"deals.sku";a:2:{s:5:"alias";s:3:"SKU";s:7:"element";a:2:{i:0;s:4:"text";i:1;a:1:{s:5:"style";s:12:"width:210px;";}}}s:17:"deals.coupon_code";a:2:{s:5:"alias";s:11:"Coupon Code";s:7:"element";a:2:{i:0;s:4:"text";i:1;a:1:{s:5:"style";s:12:"width:210px;";}}}s:18:"deals.actual_price";a:2:{s:5:"alias";s:12:"Actual price";s:7:"element";a:2:{i:0;s:4:"text";i:1;a:1:{s:5:"style";s:12:"width:210px;";}}}s:16:"deals.deal_price";a:2:{s:5:"alias";s:12:"Before price";s:7:"element";a:2:{i:0;s:4:"text";i:1;a:1:{s:5:"style";s:12:"width:210px;";}}}s:21:"deals.deal_start_date";a:2:{s:5:"alias";s:10:"Start date";s:7:"element";a:1:{i:0;s:4:"date";}}s:19:"deals.deal_end_date";a:2:{s:5:"alias";s:8:"End date";s:7:"element";a:1:{i:0;s:4:"date";}}s:14:"deals.deal_url";a:2:{s:5:"alias";s:8:"Deal Url";s:7:"element";a:2:{i:0;s:4:"text";i:1;a:1:{s:5:"style";s:12:"width:210px;";}}}s:23:"deals.short_description";a:2:{s:5:"alias";s:17:"Short Description";s:7:"element";a:2:{i:0;s:8:"textarea";i:1;a:1:{s:5:"style";s:25:"width:300px;height:100px;";}}}s:17:"deals.description";a:2:{s:5:"alias";s:11:"Description";s:7:"element";a:1:{i:0;s:6:"editor";}}s:14:"deals.keywords";a:2:{s:5:"alias";s:8:"keywords";s:7:"element";a:2:{i:0;s:8:"textarea";i:1;a:1:{s:5:"style";s:25:"width:300px;height:100px;";}}}s:9:"deals.hot";a:2:{s:5:"alias";s:3:"Hot";s:7:"element";a:2:{i:0;s:8:"checkbox";i:1;a:1:{i:1;s:3:"Yes";}}}s:15:"deals.is_active";a:2:{s:5:"alias";s:6:"Active";s:7:"element";a:2:{i:0;s:8:"checkbox";i:1;a:1:{i:1;s:3:"Yes";}}}s:17:"deals.IsDailyDeal";a:2:{s:5:"alias";s:12:"IsDailyDeal?";s:7:"element";a:2:{i:0;s:8:"checkbox";i:1;a:1:{i:1;s:3:"Yes";}}}s:19:"deals.mainMenuOrder";a:2:{s:5:"alias";s:9:"Home Page";s:7:"element";a:2:{i:0;s:8:"checkbox";i:1;a:1:{i:1;s:3:"Yes";}}}s:14:"deals.hotDeals";a:2:{s:5:"alias";s:10:"Deals Page";s:7:"element";a:2:{i:0;s:8:"checkbox";i:1;a:1:{i:1;s:3:"Yes";}}}s:20:"deals.hotSubCategoty";a:2:{s:5:"alias";s:16:"Subcategory Page";s:7:"element";a:2:{i:0;s:8:"checkbox";i:1;a:1:{i:1;s:3:"Yes";}}}s:17:"deals.hotCategory";a:2:{s:5:"alias";s:13:"Category Page";s:7:"element";a:2:{i:0;s:8:"checkbox";i:1;a:1:{i:1;s:3:"Yes";}}}s:18:"deals.specialPages";a:2:{s:5:"alias";s:13:"Special pages";s:7:"element";a:3:{i:0;s:6:"select";i:1;a:3:{s:12:"option_table";s:12:"specialPages";s:10:"option_key";s:2:"id";s:12:"option_value";s:4:"name";}i:2;a:1:{s:8:"multiple";s:8:"multiple";}}}}s:8:"elements";a:23:{s:18:"deals.display_name";a:2:{s:5:"alias";s:5:"Title";s:7:"element";a:2:{i:0;s:4:"text";i:1;a:1:{s:5:"style";s:12:"width:210px;";}}}s:15:"deals.image_url";a:2:{s:5:"alias";s:5:"Image";s:7:"element";a:2:{i:0;s:5:"image";i:1;a:3:{s:9:"thumbnail";s:6:"medium";s:5:"width";s:0:"";s:6:"height";s:0:"";}}}s:12:"deals.cat_id";a:2:{s:5:"alias";s:8:"Category";s:7:"element";a:2:{i:0;s:5:"radio";i:1;a:1:{i:1;s:15:"Computer storage";}}}s:16:"deals.sub_cat_id";a:2:{s:5:"alias";s:11:"Subcategory";s:7:"element";a:2:{i:0;s:12:"autocomplete";i:1;a:3:{s:12:"option_table";s:13:"subCategories";s:10:"option_key";s:2:"id";s:12:"option_value";s:4:"name";}}}s:21:"deals.deal_sources_id";a:2:{s:5:"alias";s:11:"Deal source";s:7:"element";a:2:{i:0;s:12:"autocomplete";i:1;a:3:{s:12:"option_table";s:12:"deal_sources";s:10:"option_key";s:14:"deal_source_id";s:12:"option_value";s:16:"deal_source_name";}}}s:9:"deals.sku";a:2:{s:5:"alias";s:3:"SKU";s:7:"element";a:2:{i:0;s:4:"text";i:1;a:1:{s:5:"style";s:12:"width:210px;";}}}s:17:"deals.coupon_code";a:2:{s:5:"alias";s:11:"Coupon Code";s:7:"element";a:2:{i:0;s:4:"text";i:1;a:1:{s:5:"style";s:12:"width:210px;";}}}s:18:"deals.actual_price";a:2:{s:5:"alias";s:12:"Actual price";s:7:"element";a:2:{i:0;s:4:"text";i:1;a:1:{s:5:"style";s:12:"width:210px;";}}}s:16:"deals.deal_price";a:2:{s:5:"alias";s:12:"Before price";s:7:"element";a:2:{i:0;s:4:"text";i:1;a:1:{s:5:"style";s:12:"width:210px;";}}}s:21:"deals.deal_start_date";a:2:{s:5:"alias";s:10:"Start date";s:7:"element";a:1:{i:0;s:4:"date";}}s:19:"deals.deal_end_date";a:2:{s:5:"alias";s:8:"End date";s:7:"element";a:1:{i:0;s:4:"date";}}s:14:"deals.deal_url";a:2:{s:5:"alias";s:8:"Deal Url";s:7:"element";a:2:{i:0;s:4:"text";i:1;a:1:{s:5:"style";s:12:"width:210px;";}}}s:23:"deals.short_description";a:2:{s:5:"alias";s:17:"Short Description";s:7:"element";a:2:{i:0;s:8:"textarea";i:1;a:1:{s:5:"style";s:25:"width:300px;height:100px;";}}}s:17:"deals.description";a:2:{s:5:"alias";s:11:"Description";s:7:"element";a:1:{i:0;s:6:"editor";}}s:14:"deals.keywords";a:2:{s:5:"alias";s:8:"keywords";s:7:"element";a:2:{i:0;s:8:"textarea";i:1;a:1:{s:5:"style";s:25:"width:300px;height:100px;";}}}s:9:"deals.hot";a:2:{s:5:"alias";s:3:"Hot";s:7:"element";a:2:{i:0;s:8:"checkbox";i:1;a:1:{i:1;s:3:"Yes";}}}s:15:"deals.is_active";a:2:{s:5:"alias";s:6:"Active";s:7:"element";a:2:{i:0;s:8:"checkbox";i:1;a:1:{i:1;s:3:"Yes";}}}s:17:"deals.IsDailyDeal";a:2:{s:5:"alias";s:12:"IsDailyDeal?";s:7:"element";a:2:{i:0;s:8:"checkbox";i:1;a:1:{i:1;s:3:"Yes";}}}s:19:"deals.mainMenuOrder";a:2:{s:5:"alias";s:9:"Home Page";s:7:"element";a:2:{i:0;s:8:"checkbox";i:1;a:1:{i:1;s:3:"Yes";}}}s:14:"deals.hotDeals";a:2:{s:5:"alias";s:10:"Deals Page";s:7:"element";a:2:{i:0;s:8:"checkbox";i:1;a:1:{i:1;s:3:"Yes";}}}s:20:"deals.hotSubCategoty";a:2:{s:5:"alias";s:16:"Subcategory Page";s:7:"element";a:2:{i:0;s:8:"checkbox";i:1;a:1:{i:1;s:3:"Yes";}}}s:17:"deals.hotCategory";a:2:{s:5:"alias";s:13:"Category Page";s:7:"element";a:2:{i:0;s:8:"checkbox";i:1;a:1:{i:1;s:3:"Yes";}}}s:18:"deals.specialPages";a:2:{s:5:"alias";s:13:"Special pages";s:7:"element";a:3:{i:0;s:6:"select";i:1;a:3:{s:12:"option_table";s:12:"specialPages";s:10:"option_key";s:2:"id";s:12:"option_value";s:4:"name";}i:2;a:1:{s:8:"multiple";s:8:"multiple";}}}}}