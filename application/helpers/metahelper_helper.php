<?php
  function Imageexists($uri)
    {
        $ch = curl_init($uri);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $code == 200;
    }

       function getConstData ($t){
          //$t->output->cache(10);
           $data['base_url'] = $t->config->item('base_url');
            $data['msg']='';
            if(!empty($_REQUEST['msg'])){
            switch($_REQUEST['msg']){
                                case "loginsuccess":
                                    $data['msg'] = '<div style="color:#FF0000;">You have successfully logged in into our Site.</div>';
                                break;
                                case "loginerror":
                                    $data['msg'] = '<div style="color:#FF0000;">Please provide your Login credentials correctly.</div>';
                                break;
                                case "logoutsuccess":
                                    $data['msg'] = '<div style="color:#FF0000;">You have successfully Logged Out from the Site.</div>';
                                break;
                                case "registersuccess":
                                    $data['msg'] = '<div style="color:#FF0000;">You have successfully Registered in our Site. Please check your email to find the Login Credentials.</div>';
                                break;
                                case "cantview":
                                    $data['msg'] = '<div style="color:#FF0000;">You can\'t view t page as you are not a Registered user.</div>';
                                break;
                                case "cannotrate":
                                    $data['msg'] = '<div style="color:#FF0000;">You can\'t RATE as you are not a Registered user.</div>';
                                break;
                            
                        }
            
            }
            $data['siteUrl']  = $data['base_url'];

            //$data['siteUrlMedia']  = 'http://ec2-54-213-191-45.us-west-2.compute.amazonaws.com/';
            $data['siteUrlMedia']  = 'http://pccounter/';
            $data['dealsUrl']  = $data['base_url'].$t->config->item('index_page').'deals-list';
            $data['couponsUrl']  = $data['base_url'].$t->config->item('index_page').'coupon-codes';
            $data['categoriesUrl']  = $data['base_url'].$t->config->item('index_page').'categories';
            $data['storesUrl']  = $data['base_url'].$t->config->item('index_page').'all-stores';
            $data['contactUrl']  = $data['base_url'].$t->config->item('index_page').'contact';
            $data['registerUrl']  = $data['base_url'].$t->config->item('index_page').'register';
            $data['offerUrlPop'] = $data['base_url'].$t->config->item('index_page').'/deals/pop';

             /***********************************/
            
            /**
             * Right Column
             */
            
            $data['newsletterMsg'] = '';
            $t->load->model('Source');
            $stor =$t->Source->get_stores(9);
            foreach($stor as $st){
                if(strpos($st->deal_source_logo_url,'ttp://') || strpos($st->deal_source_logo_url,'ttps://')){
                    $st->image = $st->deal_source_logo_url;
                }else{
                    $st->image = $data['siteUrlMedia'].'/media/images/'.$st->deal_source_logo_url;
                }
                
            }
            $data['dealSources'] = $stor;
            $data['rightContentTitle'] = 'OUR PROMISE';
            $data['rightContentDescription'] = 'At pccounter.net its all about saving money on your online purchases, we scout the internet 24/7 looking for deals & discount coupon codes. You will find hundereds of thousands of offers that works and let you save money instantly, whether it is an instant discount or free shipping';
            
            $data['blogPosts'] = array();
            $data['noBlogPosts'] = (count($data['blogPosts']==0))?'<li style="padding: 13px 14px;">
									<strong>No Latest Blog has been posted.</strong><br/>
								</li>':'';
            $data['blogUrl'] = (count($data['blogPosts'])>0)?'<li>
                                                <span style="padding: 0 0 0 120px;"><a href="'.'">Read More</a></span>
                                            </li>':'';
            $t->load->model('Banner');
            $ban = $t->Banner->get_banners();
            foreach($ban as $st){
                if(strpos($st->image,'ttp://') || strpos($st->image,'ttps://')){
                    $st->image = $st->image;
                }else{
                    $st->image = $data['siteUrlMedia'].'/media/images/'.$st->image;
                }
                
            }
            $data['banners_type1'] = $ban;
            $t->load->model('Rightbox');
            $data['rightBox'] = $t->Rightbox->get_boxes();
            /*********************************/
            
            
            
            /****FOOTER****/
                $t->load->model('Pages');
                $specialPages = $t->Pages->getAllSpecialPages();
                foreach($specialPages as $key=>$val){
                    if(empty($val->url)){
                        $specialPages[$key]->specialPageUrl = $data['siteUrlMedia'].'specialPage/index/0/'.$val->id;
                    }else{
                        $specialPages[$key]->specialPageUrl = $data['siteUrlMedia'].$val->url;
                    }
                }
                $cantSpecialPages = ceil(count($specialPages)/2);
                for($i=0;$i<$cantSpecialPages;$i++){
                    $data['specialPages_1'][] = $specialPages[$i];
                }
                
                for($i=$cantSpecialPages;$i<count($specialPages);$i++){
                    $data['specialPages_2'][] = $specialPages[$i];
                }
                
                $staticPages = $t->Pages->getAllStaticPages();
                
                foreach( $staticPages as $key=>$val){
                    if(empty($val->url)){
                        $staticPages[$key]->url = $data['siteUrlMedia'].'staticPage/index/'.$val->id;
                    }else{
                        $staticPages[$key]->url = $data['siteUrlMedia'].$val->url;
                    }
                    
                }
                $data['mapUrl'] = $data['siteUrlMedia'].'siteMap/';
                $data['staticPages'] = $staticPages;
                
                
            /**************************/
                /**LOGIN**/
                $t->load->config('account/account');
		$t->load->helper(array('language', 'account/ssl', 'url'));
		$t->load->library(array('account/authentication', 'account/authorization', 'account/recaptcha', 'form_validation'));
		$t->load->model(array('account/account_model'));
		$t->load->language(array('account/sign_in', 'account/connect_third_party'));
                
                
                // Enable SSL?
		maintain_ssl($t->config->item("ssl_enabled"));

		// Redirect signed in users to homepage
		if ($t->authentication->is_signed_in()) redirect('');

		// Set default recaptcha pass
		$recaptcha_pass = $t->session->userdata('sign_in_failed_attempts') < $t->config->item('sign_in_recaptcha_offset') ? TRUE : FALSE;

		// Check recaptcha
		$recaptcha_result = $t->recaptcha->check();

		// Setup form validation
		$t->form_validation->set_error_delimiters('<span class="field_error">', '</span>');
		$t->form_validation->set_rules(array(
			array(
				'field' => 'sign_in_username_email',
				'label' => 'lang:sign_in_username_email',
				'rules' => 'trim|required'
			),
			array(
				'field' => 'sign_in_password',
				'label' => 'lang:sign_in_password',
				'rules' => 'trim|required'
			)
		));

		// Run form validation
		if ($t->form_validation->run() === TRUE)
		{
			// Get user by username / email
			if ( ! $user = $t->account_model->get_by_username_email($t->input->post('sign_in_username_email', TRUE)))
			{
				// Username / email doesn't exist
				$data['sign_in_username_email_error'] = lang('sign_in_username_email_does_not_exist');
			}
			else
			{
				// Either don't need to pass recaptcha or just passed recaptcha
				if ( ! ($recaptcha_pass === TRUE || $recaptcha_result === TRUE) && $t->config->item("sign_in_recaptcha_enabled") === TRUE)
				{
					$data['sign_in_recaptcha_error'] = $t->input->post('recaptcha_response_field') ? lang('sign_in_recaptcha_incorrect') : lang('sign_in_recaptcha_required');
				}
				else
				{
					// Check password
					if ( ! $t->authentication->check_password($user->password, $t->input->post('sign_in_password', TRUE)))
					{
						// Increment sign in failed attempts
						$t->session->set_userdata('sign_in_failed_attempts', (int)$t->session->userdata('sign_in_failed_attempts') + 1);

						$data['sign_in_error'] = lang('sign_in_combination_incorrect');
					}
					else
					{
						// Clear sign in fail counter
						$t->session->unset_userdata('sign_in_failed_attempts');

						// Run sign in routine
						$t->authentication->sign_in($user->id, $t->input->post('sign_in_remember', TRUE));
					}
				}
			}
		}

		// Load recaptcha code
		if ($t->config->item("sign_in_recaptcha_enabled") === TRUE)
			if ($t->config->item('sign_in_recaptcha_offset') <= $t->session->userdata('sign_in_failed_attempts'))
				$data['recaptcha'] = $t->recaptcha->load($recaptcha_result, $t->config->item("ssl_enabled"));

		// Load sign in view
		
                  $t->load->helper(array('form', 'url'));
                  $t->load->helper('url');
                  $email = $t->input->post('email');
                  if(empty($email)) {
			// show the form
			$data['newsletterMessage']='<ul>
								<li><input type="text" class="search_bg1" name="email" placeholder="Enter Your Email address here"/>
								<br /><span style="color:#FF0000;" id="err_email"></span>
								</li>
								<li><input type="submit" name="Submit2" class="search_btn1" value="SUBSCRIBE"/></li>
							</ul>';
                  }else{
                        $t->load->model('Client');
                        $t->Client->insertEmail($email);
                        $data['newsletterMessage']='<div class="newsletterAdded"></div>';
                  }
                
                  
              $t->load->model('Category');
                $categ_list_menu = $t->Category->get_categories(21);
                foreach ($categ_list_menu as $categ){
                    if(empty($categ->url)){
                        $categ->subCategoryUrl = $t->config->item('base_url').$t->config->item('index_page').'/categories/subcategories/0/'.$categ->id;
                        $categ->dealCategoryUrl = $t->config->item('base_url').$t->config->item('index_page').'/categories/subcategories/0/'.$categ->id;
                    }else{
                        $categ->subCategoryUrl = $t->config->item('base_url').$t->config->item('index_page').$categ->url;
                        $categ->dealCategoryUrl = $t->config->item('base_url').$t->config->item('index_page').$categ->url;
                    }
                    if(empty($categ->image)){
                        $categ->image = 'http://pccounter.net/media/images/noImage.jpg';
                    }
                    if($categ->id > 6){
                        $categ->extraClass = 'hiddenCat';
                    }elsE{
                        $categ->extraClass = '';
                    }
                }
                $data['categoriesMenu'] = $categ_list_menu;

                
                $t->load->model('Source');
            $stor = $t->Source->get_stores(23);
            $storcount =1;
            foreach($stor as $st){
                if(strpos($st->deal_source_logo_url,'ttp://') || strpos($st->deal_source_logo_url,'ttps://')){
                    $st->image = $st->deal_source_logo_url;
                }else{
                    $st->image = $data['siteUrlMedia'].'/media/images/'.$st->deal_source_logo_url;
                }
                if(empty($st->url)){
                    $st->dealsStore = $t->config->item('base_url').$t->config->item('index_page').'deals/index/0/_/null/null/'.$st->deal_source_id;
                }else{
                    $st->dealsStore = $t->config->item('base_url').$t->config->item('index_page').$st->url;
                }
                if($storcount > 8){
                    $st->extraClass = 'hiddenCat';
                }else{
                    $st->extraClass = '';
                }
                if(strlen($st->name) > 22){
                    $st->short_name  = substr($st->name,0,22).'...';
                }else{
                    $st->short_name  = $st->name;
                }
                $storcount++;
            }
            $data['storesMenu'] = $stor;
            $data['qtyStores'] = $t->Source->get_totalStores();     
                $data['activeHome'] = '';
                $data['activeDeals'] = '';
                $data['activeCoupons'] = '';
                $data['activeCategory'] = '';
                $data['activeStores'] = '';
                
            return $data;
    }
    function encapsuleDeals($deals,$t){
        
            $dealcount=1;
            $lastRowDealCount=1;
            foreach($deals as $deal){
                if($deal->actual_price > 0){
                    $deal->showActualPrice = '<span class="actualPriceList">
                                $'.$deal->actual_price.'
                            </span> ';
                }else{
                    $deal->showActualPrice = '';
                }
                if(empty($deal->display_name)){
                    $deal->display_name = $deal->title;
                }
                if(empty($deal->image_url)){
                    $deal->image = 'media/images/noImage.jpg';
                }else{
                    $deal->image = str_replace("https://pccounter.s3.amazonaws.com/","http://dr30wky7ya0nu.cloudfront.net/",$deal->image_url);
                }
                if(!Imageexists($deal->image)){
                    $deal->image = $t->Source->get_dealSourceImg($deal->deal_sources_id);
                }
                if(!strpos($deal->image,"ttp://") && !strpos($deal->image,'ttps://')){
                    $deal->image = 'http://beta.pccounter.net/media/images/'.$deal->image;
                }

                if(!empty($deal->deal_sources_id)){
                    $deal->provider = $t->Source->get_dealSourceStr($deal->deal_sources_id);
                }
                if($deal->hot){
                    $deal->hot = '<div class="hot_deal"></div>';
                }else{
                    $deal->hot = '';
                }
                if(strlen($deal->display_name)> 60){
                    $deal->short_display_name = substr($deal->display_name,0,60).'...';
                }else{
                    $deal->short_display_name = $deal->display_name;
                }
                
                $deal->offerUrl = $t->config->item('base_url').$t->config->item('index_page').'/deals/review/'.$deal->id;
                $deal->encodedUrl = urlencode($deal->offerUrl);
                $sess = $t->session->all_userdata();
                if(!empty($sess[$deal->id])){
                     $deal->thumbsClass = 'thumbActive';
                }else{
                    $deal->thumbsClass = 'thumbs';
                }
                 if($dealcount > 4){
                    $deal->extraClass = 'hiddenCat';
                }else{
                    $deal->extraClass = '';
                }
                if($lastRowDealCount==4){
                    $deal->lastInRow= 'lastInRow';
                    $lastRowDealCount = 0;
                }else{
                    $deal->lastInRow= '';
                }
                $deal->categoryStr = $t->Category->get_CatName($deal->cat_id);
                $deal->catUrl = $t->Category->get_CatUrl($deal->cat_id);
                $deal->categoryCount = $t->Category->get_catCant($deal->cat_id);
                if($dealcount == 1 ){
                    $deal->activeDeal = 'active';
                }else{
                    $deal->activeDeal = '';
                }
                
                $deal->count = $dealcount-1;
                $deal->qtyComments = $t->Review->get_qtyComments($deal->id);
                $lastRowDealCount++;
                $dealcount++;
            }
            return $deals;
    }
?>
