<?php


       function getConstData ($t){
         // $this->output->cache(5);
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
                                    $data['msg'] = '<div style="color:#FF0000;">You can\'t view this page as you are not a Registered user.</div>';
                                break;
                                case "cannotrate":
                                    $data['msg'] = '<div style="color:#FF0000;">You can\'t RATE as you are not a Registered user.</div>';
                                break;
                            
                        }
            
            }
            $data['siteUrl']  = $data['base_url'];

            //$data['siteUrlMedia']  = 'http://ec2-54-213-191-45.us-west-2.compute.amazonaws.com/';
            $data['siteUrlMedia']  = 'http://pccounter/ci/';
            $data['dealsUrl']  = $data['base_url'].$t->config->item('index_page').'/deals';
            $data['couponsUrl']  = $data['base_url'].$t->config->item('index_page').'/coupons/index';
            $data['categoriesUrl']  = $data['base_url'].$t->config->item('index_page').'/categories/index';
            $data['storesUrl']  = $data['base_url'].$t->config->item('index_page').'/stores/index';
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
                    $specialPages[$key]->specialPageUrl = $data['siteUrlMedia'].'specialPage/index/0/'.$val->id;
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
                    $staticPages[$key]->url = $data['siteUrlMedia'].'staticPage/index/'.$val->id;
                }
                $data['mapUrl'] = $data['siteUrlMedia'].'siteMap/';
                $data['staticPages'] = $staticPages;
                
                
            /**************************/
            return $data;
    }

?>
