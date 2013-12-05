<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Deals extends CI_Controller {

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
	
        public function index( $limit='',$qSearch='',$category='',$subcat='',$store='',$priceMin=0,$priceMax=0,$orderBy='[json]'){
            
            $time = microtime();
            $time = explode(' ', $time);
            $time = $time[1] + $time[0];
            $start = $time;

            $q = $qSearch;
            $resetSession = false;
            
            $this->load->helper('metaHelper');
            
            $data = getConstData($this);
            
            if(empty($limit) ){
                $resetSession = true;
            }
            $data['urlFlag']=0;
            if($limit == '_'){
                $limit = 0;
                $resetSession = false;
                $data['urlFlag']=1;
            }
            //IF is a category search
            if($q == 'category'){
                $q = '';
            }
            
            if(!empty($q)){
                $q = substr($qSearch, 3);
                if(!empty($q)){
                    $resetSession  = true;
                }
            }
            $this->load->library('session');
            
            $this->load->model('pages');
            $this->load->helper(array('form', 'url')); 
            if(empty($_SESSION['orderBy']) || $resetSession){
                $_SESSION['orderBy'] = array();
            }
            if(empty($_SESSION['categories']) || $resetSession){
                $_SESSION['categories'] = array();
            }
            if(empty($_SESSION['subcategories']) || $resetSession){
                $_SESSION['subcategories'] = array();
            }
            if(empty($_SESSION['stores']) || $resetSession){
                $_SESSION['stores'] = array();
            }   
            if(empty($_SESSION['priceMin']) || $resetSession){
                $_SESSION['priceMin'] = 0;
            }
            if(empty($_SESSION['priceMax']) || $resetSession){
                $_SESSION['priceMax'] = 0;
            }
            
            if(!empty($category) && !in_array($category, $_SESSION['categories']) &&  $category != 'null'){
                $_SESSION['categories'][] = $category;
            }
            if(!empty($subcat) && !in_array($subcat, $_SESSION['subcategories']) &&  $subcat != 'null'){
                $_SESSION['subcategories'][] = $subcat;
            }
            if(!empty($store) && !in_array($store, $_SESSION['stores'])){
                $_SESSION['stores'][] = $store;
            }
            $_SESSION['priceMin'] = $priceMin;
            $_SESSION['priceMax'] = $priceMin;
            
            
            
            
            
            
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
            if($resetSession){
                $data['filters'] = array();
                $data['deleteAllFilter']  = '';
                
            }else{
                $data['deleteAllFilter']  = '<li id="deleteAllFilters">DELETE ALL</li>';
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
                $data['filters'][] = array('name'=>'Min price:'.$_SESSION['priceMin'].' - Max price:'.$_SESSION['priceMax'],'type'=>'Price','typeText'=>'priceMax');
            }
            
            if(!empty($store)){
                $seoPg = $this->Source->get_source($store);
                $data['pageTitle'] = $seoPg->title_tag;//Title tag
                $data['headerText'] = $seoPg->htmlHeader;//H1 tag
                $data['metaTitle'] = $seoPg->meta_title;
                $data['metaKeywords'] = $seoPg->meta_keywords;
                $data['metaDescription'] = $seoPg->meta_description;
                $data['activeStores'] = 'active';
            }elseif(!empty($subcat)){
                $seoPg = $this->Category->get_subcategoryById($subcat);
                $data['pageTitle'] = $seoPg->title;//Title tag
                $data['headerText'] = $seoPg->header;//H1 tag
                $data['metaTitle'] = $seoPg->meta_title;
                $data['metaKeywords'] = $seoPg->meta_keywords;
                $data['metaDescription'] = $seoPg->meta_description;
                $data['activeCategory'] = 'active';
            }elseif(!empty($category)){
                $seoPg = $this->Category->get_categoryById($category);
                $data['pageTitle'] = $seoPg->title;//Title tag
                $data['headerText'] = $seoPg->header;//H1 tag
                $data['metaTitle'] = $seoPg->meta_title;
                $data['metaKeywords'] = $seoPg->meta_keywords;
                $data['metaDescription'] = $seoPg->meta_description;
                $data['activeCategory'] = 'active';
            }else{
                if(!empty($data['urlFlag'])){
                    $seoPg = $this->pages->getSEOPage('multi-filter-deals');
                    if(!empty($seoPg)){
                        $seoPg = $seoPg[0];
                        $data['pageTitle'] = $seoPg->Title;//Title tag
                        $data['headerText'] = $seoPg->Header;//H1 tag
                        $data['metaTitle'] = $seoPg->Meta_title;
                        $data['metaKeywords'] = $seoPg->Meta_keywords;
                        $data['metaDescription'] = $seoPg->Meta_Description;
                        $data['activeDeals'] = 'active';
                    }
                }else{
                    $seoPg = $this->pages->getSEOPage('deals');
                    $seoPg = $seoPg[0];
                    $data['pageTitle'] = $seoPg->Title;//Title tag
                    $data['headerText'] = $seoPg->Header;//H1 tag
                    $data['metaTitle'] = $seoPg->Meta_title;
                    $data['metaKeywords'] = $seoPg->Meta_keywords;
                    $data['metaDescription'] = $seoPg->Meta_Description;
                    $data['activeDeals'] = 'active';
                }
            }
            /**
             * Selected Menu deals and lastest deals
             */
            $path='';
            $class='activePath';
            if(!empty($category) && $category != 'null'){
                if(!empty($subcat)){
                    $class='prevPath';
                }else{
                    $class='activePath';
                }
                $cat = $this->Category->get_categoryById($category);
                $path .= '> <a href="'.$cat->url.'" class="'.$class.'">'.$cat->name.'</a> ';
            }
            if(!empty($subcat) && $subcat != 'null'){
                $cat = $this->Category->get_subcategoryById($subcat);
                $path .= '> <a href="'.$cat->url.'" class="activePath">'.$cat->name.'</a> ';
                $class='prevPath';
            }
            if(!empty($store) && $store != 'null'){
                $cat = $this->Source->get_source($store);
                $path .= '> <a href="'.$cat->url.'" class="'.$class.'">'.$cat->deal_source_name.'</a> ';
                $class='prevPath';
            }
            if(empty($path)){
                $class='activePath';
            }
            if(!empty($q)){
                $path .= '> <a href="#" class="activePath">'.str_replace("%20"," ",$q).'</a> ';
            }
            $data['pathLocation']='<a class="prevPath" href="/">HOME</a> > <a href="/deals-list" class="'.$class.'">DEALS</a> '.$path;
            $deals = array();
            $merge = array();
            $this->load->model('Deal');
            
            
            if($limit == ''){
                $limit = 0;
            }
            $starred = array();
            if($limit == 0){
                if(!empty($subcat) && $subcat != 'null'){
                    $starred = $this->Deal->get_lastStarredSubcatDeals(15,$limit,$q,$category,$subcat,$store); //Get the other deals
                }elseif(!empty($category) && $category != 'null'){
                    $starred = $this->Deal->get_lastStarredCatDeals(15,$limit,$q,$category,$subcat,$store); //Get the other deals
                }else{
                    $starred = $this->Deal->get_lastStarredDeals(15,$limit,$q,$category,$subcat,$store); //Get the other deals
                }
            }
            
            $merge = $this->Deal->get_lastDeals(15-count($starred),$limit,$q,$_SESSION['categories'],$_SESSION['subcategories'],$_SESSION['stores'],$_SESSION['priceMin'],$_SESSION['priceMax'],$_SESSION['orderBy']); //Get the other deals
            
            $data['deals'] = encapsuleDeals($merge,$this,false,3);
            
            $data['totalDeals'] = $this->Deal->get_totalDeals($q,$_SESSION['categories'],$_SESSION['subcategories'],$_SESSION['stores'],$_SESSION['priceMin'],$_SESSION['priceMax']);
            $merge = array_merge($starred,$merge);
            
            $this->load->library('pagination');
            //$config['base_url'] = $this->config->item('base_url').$this->config->item('index_page').'/deals/paginator/'.$qSearch.'/'.$category;
            
            $_SESSION['uriSegment'] = $this->uri->segments[1];
            
            $config['base_url'] = $this->config->item('base_url').$this->config->item('index_page').$this->uri->segments[1];
            $config['total_rows'] = $data['totalDeals'];
            
            $config['uri_segment'] = 2;
            $config['per_page'] = 15; 
            $config['num_links'] = 3; 
            $this->pagination->initialize($config); 
            $data['paginator'] = $this->pagination->create_links();
            $data['subCategories'] = array();
           //arraymap, eliminar elementos con dealsQty == 0
            if(count($_SESSION['subcategories']) > 0){
                $data['categories'] = array();
            }
            $data['subCategories'] = array();
            if(count($_SESSION['categories']) == 1){
                $data['catSelected'] = true;
                $_SESSION['categories'] = array_values($_SESSION['categories']);
                $this->load->model('Category');
                $categ_list = $this->Category->get_Subcategories(null,null,$_SESSION['categories'][0]);
                foreach ($categ_list as $categ){
                    if(!in_array($categ,$_SESSION['subcategories'])){
                        if(empty($categ->url)){
                            $categ->subCategoryUrl = $this->config->item('base_url').$this->config->item('index_page').'deals/index/0/category/'.$_SESSION['categories'][0].'/'.$categ->id;
                        }else{
                            $categ->subCategoryUrl = $this->config->item('base_url').$this->config->item('index_page').$categ->url;
                        }
                        $categ->dealsQty = $this->Deal->getCountDealsBySubCategory($categ->id);
                    }else{
                        unset($categ);
                    }
                    
                }
                $data['subCategories'] = $categ_list;
            }
            $data['linkGoTo']=false;
            $data['linkGoToCat']=false;
            if(count($_SESSION['categories']) == 0 && count($_SESSION['subcategories']) == 0 && count($_SESSION['stores'])==0){
                $data['linkGoTo'] = true;
            }
            if(count($_SESSION['categories']) == 1 && count($_SESSION['subcategories']) == 0 && count($_SESSION['stores'])==0){
                $data['linkGoToCat'] = true;
            }
            
            /*************************FORMATING FILTERS*******************************/
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
//            die();
              $data['noDeals'] =  ((count($data['deals'])==0)?'<div class="pro_box">
                                                        <span style="color:#FF0000;">NO DEALS ARE THERE.</span>
                                                 </div>':'');
                $data['topStores'] = array();
              /**
               * Footer
               */
              /**********************************************/
                
                $this->load->library('parser');
                $this->parser->parse('widgets/header_new', $data);
                $this->parser->parse('deals_new', $data);
                $this->parser->parse('widgets/footer_new', $data);
        }
        /* HACKS TO CENTRALIZE SEARCH AND PAGINATOR*/
        public function search(){
            $this->load->helper('url');
            redirect('/deals-search-'.$this->input->post('search'));
        }
        public function paginator($var1='',$var2='',$var3=''){
            $this->load->helper('url');
            // category pagination
            if($var1 == 'category'){
                redirect('/deals/index/'.$var3.'/'.$var1.'/'.$var2);    
            }
            /*IF is active search*/
            if(substr($var1, 0,3) == '___'){
                redirect('/deals/index/'.$var2.'/'.$var1);
            }else{
                redirect('/deals/index/'.$var1.'/'.$var2);
            }
        }
        public function review($id='',$saved=false,$dat=false,$err = false){
            $this->load->helper('metaHelper');
            $this->load->helper(array('form', 'url')); 
            $data = getConstData($this);
            
            $this->load->library('captcha');
            $data['recaptcha_html'] = $this->captcha->recaptcha_get_html();
            $this->load->model('pages');
            $seoPg = $this->pages->getSEOPage('deals');
            $seoPg = $seoPg[0];
            $data['message'] = '';
            $data['pageTitle'] = $seoPg->Title;//Title tag
            $data['headerText'] = $seoPg->Header;//H1 tag
            $data['metaTitle'] = $seoPg->Meta_title;
            $data['metaKeywords'] = $seoPg->Meta_keywords;
            $data['metaDescription'] = $seoPg->Meta_Description;
           
            $this->load->model('Deal');
            $this->load->model('Category');
            $deals = $this->Deal->get_dealById($id);
            foreach($deals as $deal){
                 
                 
                 if($deal->actual_price > 0){
                    $deal->showActualPrice = 'List Price: <span>$'.$deal->actual_price.'</span><br/>';
                    $deal->showSavings = ' You Save: <span class="textred1">$'. ($deal->actual_price - $deal->deal_price).' ('.round((($deal->actual_price - $deal->deal_price) * 100) / $deal->actual_price,2).'%)</span><br/>';
                }else{
                    $deal->showActualPrice = '';
                    $deal->showSavings= '';
                }
                if(empty($deal->display_name)){
                    $deal->display_name = $deal->title;
                }
                $data['pathLocation']='<a class="prevPath" href="/">HOME</a> > <a href="/all-deals" class="prevPath">Deals</a> > <a href="/all-deals" class="activePath">'.$deal->display_name.'</a>';
                if(empty($deal->image_url)){
                    $deal->image = 'http://pccounter.net/media/images/noImage.jpg';
                }else{
                    $deal->image =$deal->image_url;
                }
                 if(!Imageexists($deal->image)){
                    $deal->image = $this->Source->get_dealSourceImg($deal->deal_sources_id);
                }
                if(!empty($deal->deal_sources_id)){
                    $deal->provider = $this->Source->get_dealSourceStr($deal->deal_sources_id);
                }
                $deal->category='';
                $catName = $this->Category->get_CatName($deal->cat_id);
                if(!empty($catName) && (!empty($catName[0]->name))){
                    $deal->category = $catName[0]->name;
                }
                if(!empty($deal->hot)){
                    $deal->hot = '<div class="hot_deal"></div>';
                }else{
                    $deal->hot = '';
                }
                $deal->offerUrl = $this->config->item('base_url').$this->config->item('index_page').'deals/review/'.$deal->id;
                
               
                $this->load->model('Review');
                $reviews = $this->Review->get_reviews($deal->id);
                $deal->qtyComments = $this->Review->get_qtyComments($deal->id);
                $deal->qtyReviews = $this->Review->get_qtyReviews($deal->id);
                $deal->rate_item = 1;
                $deal->counter = 10;
                $deal->itemsDescribed = $deal->qtyReviews;
                $sumStars = $this->Review->get_sumStars($deal->id);
                if($deal->qtyReviews > 0){
                    $deal->starPerc = intval((intval($sumStars[0]->stars) / intval($deal->qtyReviews)));
                }else{
                    $deal->starPerc = intval(0);
                }
                $deal->avgStars='';
                for ($i = 1; $i <= 10; $i++) {
                    if (intval($i) <= intval($deal->starPerc)) {
                        $deal->avgStars.='<img class="star" src="http://pccounter.net/media/images/star2.gif">';
                    } else {
                        $deal->avgStars.='<img class="star" src="http://pccounter.net/media/images/star1.gif">';
                    }
                }

                
                $deal->feedback = $reviews;
                $deal->noReviewes='';
                if(count($deal->feedback) == 0){
                    $deal->noReviewes = '<td colspan="5" style="text-align:center;">No Reviews Yet.</td>';
                }
                $deal->comments = $reviews;
                $deal->noComments='';
                if(count($deal->comments) == 0){
                    $deal->noComments = '<td colspan="5" style="text-align:center;">No Reviews Yet.</td>';
                }
                foreach($deal->comments as $comment){
                    $comment->comId = $comment->id;
                }
            }
            if(!$dat){
                $data['reviewForm'] = 'TabbedPanelsContentVisible" style="display:none"';
                $data['descriptionForm'] = "";
            }else{
                $data['descriptionForm'] = 'TabbedPanelsContentVisible" style="display:none"';
                $data['reviewForm'] = "";
            }
            //$data['shcms'] = array('false');
             $data['formSubmitted'] = '';
            if(!empty($saved)){
                $data['message'] = '<font color="#FF0000">Your rating successfully submitted.</font> ';
            }
            if($err){
                $data['message'] = '<font color="#FF0000">Captcha was invalid.</font> ';
            }
            $data['deal'] = $deals;
            
              /**
               * Footer
               */
              $data['dealReviewForm'] = $this->config->item('base_url').$this->config->item('index_page').'deals/reviewForm/';
              
              /**********************************************/
                $this->load->library('parser');
                $this->parser->parse('widgets/header_new', $data);
                $this->parser->parse('review_new', $data);
                $this->parser->parse('widgets/footer_new', $data);
        }
        public function reviewForm(){
            $this->load->library('captcha');
            $this->captcha->recaptcha_check_answer();
            if($this->captcha->getIsValid()){
                $this->load->model('Review');
                $this->Review->saveReview($_REQUEST['productid'],$_REQUEST['item_rating'],$_REQUEST['feedbk_cont'],$_REQUEST['feedbk_btn']);
                $this->load->helper('url');
                redirect('/deals/review/'.$_REQUEST['productid'].'/1/1');
            }else{
                $this->load->helper('url');
                redirect('/deals/review/'.$_REQUEST['productid'].'/0/1/1'); 
             }
                
        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */