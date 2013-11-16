<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    public function __construct()
       {
        parent::__construct();
       }
	public function index($limit = ''){
           
        }
        public function twlogin(){
            require_once('/media/twitteroauth_new/twitteroauth.php');
            $CONSUMER_KEY='cChZNFj6T5R0TigYB9yd1w';
            $CONSUMER_SECRET='L8qq9PZyRg6ieKGEKhZolGC0vJWLw8iEJ88DRdyOg';
            $OAUTH_CALLBACK='http://www.pccounter.net';
            if(isset($_SESSION['name']) && isset($_SESSION['twitter_id'])) //check whether user already logged in with twitter
            {

                    echo "Name :".$_SESSION['name']."<br>";
                    echo "Twitter ID :".$_SESSION['twitter_id']."<br>";
                    echo "Image :<img src='".$_SESSION['image']."'/><br>";
                    echo "<br/><a href='logout.php'>Logout</a>";


            }
            else // Not logged in
            {

                    $connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET);
                    $request_token = $connection->getRequestToken($OAUTH_CALLBACK); //get Request Token

                    if(	$request_token)
                    {
                            $token = $request_token['oauth_token'];
                            $_SESSION['request_token'] = $token ;
                            $_SESSION['request_token_secret'] = $request_token['oauth_token_secret'];

                            switch ($connection->http_code) 
                            {
                                    case 200:
                                            $url = $connection->getAuthorizeURL($token);
                                            //redirect to Twitter .
                                    header('Location: ' . $url); 
                                        break;
                                    default:
                                        echo "Coonection with twitter Failed";
                                    break;
                            }

                    }
                    else //error receiving request token
                    {
                            echo "Error Receiving Request Token";
                    }


            }



        }
        public function like($id=0){
            $this->load->library('session');
            $this->load->model('Deal');
            $dealLikes = $this->Deal->get_dealLikes($id);
            $dealLikes = $dealLikes[0]->thumbs;
            $likes = $this->session->all_userdata();
            if(empty($likes[$id])){
                
                $this->session->set_userdata($id, true);
                $dealLikes = $dealLikes +1;
                $this->Deal->set_plusOnedeal($id,$dealLikes);
            }else{
                 
                $this->session->unset_userdata($id);
                $dealLikes = $dealLikes -1;
                $this->Deal->set_plusOnedeal($id,$dealLikes);
            }
            echo $dealLikes;
        }
        private function ajaxResultFilter(){
            $q='';
            
            $this->load->model('pages');
            $this->load->helper(array('form', 'url')); 
            $limit = 0;
            $data = getConstData($this);
            $arrayOrder = array(
                                array('val'=>'id','rel'=>'desc','text'=>'Newest'),
                                array('val'=>'id','rel'=>'asc','text'=>'Oldest'),
                                array('val'=>'deal_price','rel'=>'asc','text'=>'Price: lowest first'),
                                array('val'=>'deal_price','rel'=>'desc','text'=>'Price: highest first'),
                                array('val'=>'thumbs','rel'=>'desc','text'=>'Recommended')
                );
            $orderTx = '';
            if(empty($_SESSION['orderBy'])){
               $orderTx .= '<li val="id" rel="desc" class="elemOrder displayable">Newest</li>'; 
               unset($arrayOrder[0]);
            }else{
                $k=0;
                foreach($arrayOrder as $arr){
                    if($_SESSION['orderBy'][0] == $arr['val'] && $_SESSION['orderBy'][1]==$arr['rel']){
                        $orderTx .= '<li val="'.$arr['val'].'" rel="'.$arr['rel'].'" class="elemOrder displayable">'.$arr['text'].'</li>'; 
                        unset($arrayOrder[$k]);
                        break;
                    }
                    $k++;
                }
            }
            foreach($arrayOrder as $arr){
                $orderTx .= '<li val="'.$arr['val'].'" rel="'.$arr['rel'].'" class="elemOrder orderHidden">'.$arr['text'].'</li>'; 
            }
            $data['orderDeals'] = '<ul>'.$orderTx. '</ul>';
            $data['filters'] = array();
            if(count($_SESSION['categories']) > 0 && count($_SESSION['subcategories'])>0 && count($_SESSION['stores'])>0 && !empty($_SESSION['priceMax'])){
                $data['deleteAllFilter']  = '<li id="deleteAllFilters">DELETE ALL</li>';
            }else{
                $data['filters'] = array();
                $data['deleteAllFilter']  = '';
            }
            
            foreach($_SESSION['categories'] as $filter){
                $data['filters'][] = array('name'=>$filter,'typeText'=>'categories','type'=>'Category','value'=>$this->Category->getCategoryNameById($filter));
            }
            foreach($_SESSION['subcategories'] as $filter){
                $data['filters'][] = array('name'=>$filter,'typeText'=>'subcategories','type'=>'Subcategory','value'=>$this->Category->getSubCategoryNameById($filter));
            }
            foreach($_SESSION['stores'] as $filter){
                $data['filters'][] = array('name'=>$filter,'typeText'=>'stores','type'=>'Store','value'=>$this->Source->get_dealSourceStr($filter));
            }
            if(!empty($_SESSION['priceMax']) || !empty($_SESSION['priceMin'])){
                $data['filters'][] = array('value'=>'u$s'.$_SESSION['priceMin'].' to u$s'.$_SESSION['priceMax'],'type'=>'Price','typeText'=>'priceMax','name'=>'Price');
            }
            
            if(!empty($store)){
                $seoPg = $this->pages->getSEOPage('deals');
                $seoPg = $seoPg[0];
                $data['pageTitle'] = $seoPg->Title;//Title tag
                $data['headerText'] = $seoPg->Header;//H1 tag
                $data['metaTitle'] = $seoPg->Meta_title;
                $data['metaKeywords'] = $seoPg->Meta_keywords;
                $data['metaDescription'] = $seoPg->Meta_Description;
            }
            /**
             * Selected Menu deals and lastest deals
             */
            
            $deals = array();
            $merge = array();
            $this->load->model('Deal');
            
            
            if($limit == ''){
                $limit = 0;
            }
            $starred = array();
            $merge = $this->Deal->get_lastDeals(15-count($starred),$limit,$q,$_SESSION['categories'],$_SESSION['subcategories'],$_SESSION['stores'],$_SESSION['priceMin'],$_SESSION['priceMax'],$_SESSION['orderBy']); //Get the other deals
            $merge = array_merge($starred,$merge);
            $data['deals'] = encapsuleDeals($merge,$this,false,3);
            $data['totalDeals'] = $this->Deal->get_totalDeals($q,$_SESSION['categories'],$_SESSION['subcategories'],$_SESSION['stores'],$_SESSION['priceMin'],$_SESSION['priceMax']);
            $this->load->library('pagination');
            //$config['base_url'] = $this->config->item('base_url').$this->config->item('index_page').'/deals/paginator/'.$qSearch.'/'.$category;
            $config['base_url'] = $this->config->item('base_url').$this->config->item('index_page').$_SESSION['uriSegment'];
            $config['total_rows'] = $data['totalDeals'];
            $config['uri_segment'] = 2;
            $config['per_page'] = 15; 
            $config['num_links'] = 3; 
            $this->pagination->initialize($config); 
            $data['paginator'] = $this->pagination->create_links();
            $data['subCategories'] = array();
            if(count($_SESSION['subcategories']) > 0){
                $data['categories'] = array();
            }
            if(count($_SESSION['categories']) == 1){
                $_SESSION['categories'] = array_values($_SESSION['categories']);
                $categ_list = $this->Category->get_Subcategories(null,null,$_SESSION['categories'][0]);
                foreach ($categ_list as $categ){
                    if(empty($categ->url)){
                        $categ->subCategoryUrl = $this->config->item('base_url').$this->config->item('index_page').'deals/index/0/category/'.$_SESSION['categories'][0].'/'.$categ->id;
                    }else{
                        $categ->subCategoryUrl = $this->config->item('base_url').$this->config->item('index_page').$categ->url;
                    }
                    $categ->dealsQty = $this->Deal->getCountDealsBySubCategory($categ->id);
                }
                $data['subCategories'] = $categ_list;
            }
            /********************************************************/
            if(!empty($data['categories'])){
                $data['categories'] = deleteUsed($data['categories'],'id',$_SESSION['categories'],'categories',$this);
                $data['categories'] = array_filter($data['categories'],'normalizeArray');
                
            }
            if(!empty($data['subCategories'])){
                $data['subCategories'] = deleteUsed($data['subCategories'],'id',$_SESSION['subcategories'],'subcategories',$this);
                $data['subCategories'] = array_filter($data['subCategories'],'normalizeArray');
                
            }
            
            if(!empty($data['stores'])){
                $data['stores'] = deleteUsed($data['stores'],'deal_source_id',$_SESSION['stores'],'stores',$this);
                $data['stores'] = array_filter($data['stores'],'normalizeArray');
             
            }
              $data['noDeals'] =  ((count($data['deals'])==0)?'<div class="pro_box">
                                                        <span style="color:#FF0000;">NO DEALS ARE THERE.</span>
                                                 </div>':'');
                $data['topStores'] = array();
              /**
               * Footer
               */
              /**********************************************/
                $this->load->library('parser');
                $this->parser->parse('deals_new', $data);
        }
        public function removeFilter($rel='',$id=''){
            $this->load->helper('metaHelper');
            session_start();
            if($rel == 'priceMax'){
                $_SESSION['priceMax'] = 0;
                $_SESSION['priceMin'] = 0;
            }else{
                if (($key = array_search($id, $_SESSION[$rel])) !== false) {
                    unset($_SESSION[$rel][$key]);
                }
            }
            $this->ajaxResultFilter();
            
        }
        public function addFilter($rel='',$id=''){
            $this->load->helper('metaHelper');
            session_start();
            $_SESSION[$rel][] = $id;
            $this->ajaxResultFilter();
        }
        public function addPrice($priceMin=0,$priceMax=0){
            $this->load->helper('metaHelper');
            session_start();
            if(!empty($priceMin) || !empty($priceMax)){
                $_SESSION['priceMax'] = $priceMax;
                $_SESSION['priceMin'] = $priceMin;
            }
            $this->ajaxResultFilter();
        }
        public function addOrder($elem,$order){
            $this->load->helper('metaHelper');
            session_start();
            if(!empty($elem) && !empty($order)){
                $_SESSION['orderBy'][0] = $elem;
                $_SESSION['orderBy'][1] = $order;
            }
            $this->ajaxResultFilter();
        }
}