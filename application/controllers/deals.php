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
	
        public function index( $limit='',$qSearch='',$category='',$subcat='',$store=''){
            $q = $qSearch;
            //IF is a category search
            if($q == 'category'){
                $q = '';
                
            }
            if($q != ''){
                $q = substr($qSearch, 3);
            }
            $this->load->helper('metaHelper');
            $this->load->helper(array('form', 'url')); 
            $data = getConstData($this);
            $this->load->model('pages');
            $this->load->model('Source');
            $this->load->model('Category');
            if(!empty($store)){
                $seoPg = $this->Source->get_source($store);
                $data['pageTitle'] = $seoPg->title_tag;//Title tag
                $data['headerText'] = $seoPg->htmlHeader;//H1 tag
                $data['metaTitle'] = $seoPg->meta_title;
                $data['metaKeywords'] = $seoPg->meta_keywords;
                $data['metaDescription'] = $seoPg->meta_description;
            }elseif(!empty($subcat)){
                $seoPg = $this->Category->get_subcategoryById($subcat);
                $data['pageTitle'] = $seoPg->title;//Title tag
                $data['headerText'] = $seoPg->header;//H1 tag
                $data['metaTitle'] = $seoPg->meta_title;
                $data['metaKeywords'] = $seoPg->meta_keywords;
                $data['metaDescription'] = $seoPg->meta_description;
            }elseif(!empty($category)){
                $seoPg = $this->Category->get_categoryById($category);
                $data['pageTitle'] = $seoPg->title;//Title tag
                $data['headerText'] = $seoPg->header;//H1 tag
                $data['metaTitle'] = $seoPg->meta_title;
                $data['metaKeywords'] = $seoPg->meta_keywords;
                $data['metaDescription'] = $seoPg->meta_description;
            }else{
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
            $this->load->model('Deal');
            
            
            if($limit == ''){
                $limit = 0;
            }
            $starred = array();
            if(!empty($subcat)){
                $starred = $this->Deal->get_lastStarredSubcatDeals(24,$limit,$q,$category,$subcat,$store); //Get the other deals
            }elseif(!empty($category)){
                $starred = $this->Deal->get_lastStarredCatDeals(24,$limit,$q,$category,$subcat,$store); //Get the other deals
            }else{
                $starred = $this->Deal->get_lastStarredDeals(24,$limit,$q,$category,$subcat,$store); //Get the other deals
            }
            
            $merge = $this->Deal->get_lastDeals(24-count($starred),$limit,$q,$category,$subcat,$store); //Get the other deals
            $merge = array_merge($starred,$merge);
            $this->load->library('session');
            foreach($merge as $deal){
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
                    $deal->image = 'http://pccounter.net/media/images/noImage.jpg';
                }else{
                    $deal->image = str_replace("pccounter.s3.amazonaws.com","dr30wky7ya0nu.cloudfront.net",$deal->image_url);
                }
                if(!empty($deal->deal_sources_id)){
                    $deal->provider = $this->Source->get_dealSourceStr($deal->deal_sources_id);
                }
                if($deal->hot){
                    $deal->hot = '<div class="hot_deal"></div>';
                }else{
                    $deal->hot = '';
                }
                $deal->offerUrl = $this->config->item('base_url').$this->config->item('index_page').'/deals/review/'.$deal->id;
                $sess = $this->session->all_userdata();
                if(!empty($sess[$deal->id])){
                     $deal->thumbsClass = 'thumbActive';
                }else{
                    $deal->thumbsClass = 'thumbs';
                }
                $deal->categoryStr = $this->Category->get_CatName($deal->cat_id);
                
                $deal->categoryCount = $this->Category->get_catCant($deal->cat_id);
                $deal->catUrl = $this->Category->get_CatUrl($deal->cat_id);
                
            }
            $data['deals'] = $merge;
            $data['totalDeals'] = $this->Deal->get_totalDeals($q,$category,$subcat,$store);
            $this->load->library('pagination');
            //$config['base_url'] = $this->config->item('base_url').$this->config->item('index_page').'/deals/paginator/'.$qSearch.'/'.$category;
            $config['base_url'] = $this->config->item('base_url').$this->config->item('index_page').$this->uri->segments[1];
            $config['total_rows'] = $data['totalDeals'];
            $config['uri_segment'] = 2;
            $config['per_page'] = 52; 
            $this->pagination->initialize($config); 
            $data['paginator'] = $this->pagination->create_links();
            
            if($category != ''){
                $this->load->model('Category');
                $categ_list = $this->Category->get_Subcategories(null,null,$category);
                foreach ($categ_list as $categ){
                    if(empty($categ->url)){
                        $categ->subCategoryUrl = $this->config->item('base_url').$this->config->item('index_page').'/deals/index/0/category/'.$category.'/'.$categ->id;
                    }else{
                        $categ->subCategoryUrl = $this->config->item('base_url').$this->config->item('index_page').$categ->url;
                    }
                }
                $data['subCategories'] = $categ_list;
            }
            /********************************************************/
            
              $data['noDeals'] =  ((count($data['deals'])==0)?'<div class="pro_box">
                                                        <span style="color:#FF0000;">NO DEALS ARE THERE.</span>
                                                 </div>':'');
                $data['topStores'] = array();
              /**
               * Footer
               */
              /**********************************************/
                $this->load->library('parser');
                $this->parser->parse('widgets/header', $data);
                $this->parser->parse('deals', $data);
                
                $this->parser->parse('widgets/rightBar', $data);
                $this->parser->parse('widgets/footer', $data);
        }
        /* HACKS TO CENTRALIZE SEARCH AND PAGINATOR*/
        public function search(){
            $this->load->helper('url');
            redirect('/deals/index/0/___'.$this->input->post('search'));
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
        public function review($id='',$saved=false,$dat=false){
            $this->load->helper('metaHelper');
            $this->load->helper(array('form', 'url')); 
            $data = getConstData($this);
            
            
             $this->load->model('pages');
            $seoPg = $this->pages->getSEOPage('deals');
            $seoPg = $seoPg[0];
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
                if(empty($deal->image_url)){
                    $deal->image = 'http://pccounter.net/media/images/noImage.jpg';
                }else{
                    $deal->image =$deal->image_url;
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
                $deal->offerUrl = $this->config->item('base_url').$this->config->item('index_page').'/deals/review/'.$deal->id;
                
               
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
                $data['formSubmitted'] = '<font color="#FF0000">Your rating successfully submitted.</font> ';
            }
            $data['deal'] = $deals;
            
              /**
               * Footer
               */
              $data['dealReviewForm'] = $this->config->item('base_url').$this->config->item('index_page').'/deals/reviewForm/';
              
              /**********************************************/
                $this->load->library('parser');
                $this->parser->parse('widgets/header', $data);
                $this->parser->parse('review', $data);
                
                $this->parser->parse('widgets/rightBar', $data);
                $this->parser->parse('widgets/footer', $data);
        }
        public function pop($id=''){
            $this->load->helper('metaHelper');
            $this->load->helper(array('form', 'url')); 
            $data = getConstData($this);
           
            $data['pageTitle'] = 'Dell Coupons, HP Coupons, Cheap Laptops, Computer Sales';//Title tag
            $data['page_title'] = '';//H1 tag
            $data['page_desc'] = '';
           
            $this->load->model('Deal');
            $this->load->model('Category');
            $deals = $this->Deal->get_dealById($id);
            foreach($deals as $deal){
                if(empty($deal->display_name)){
                    $deal->display_name = $deal->title;
                }
                if(empty($deal->image_url)){
                    $deal->image = 'http://pccounter.net/media/images/noImage.jpg';
                }else{
                    $deal->image =$deal->image_url;
                }
                if(!empty($deal->deal_sources_id)){
                    $deal->provider = $this->Source->get_dealSourceStr($deal->deal_sources_id);
                    $deal->deal_source_logo_url = $this->Source->get_dealSourceImg($deal->deal_sources_id);
                }
                
                $deal->category='';
                $catName = $this->Category->get_CatName($deal->cat_id);
                $deal->catUrl = $this->Categoty->get_CatUrl($deal->cat_id);
                if(!empty($catName)){
                    $deal->category = $catName[0]->name;
                }
                if($deal->hot){
                    $deal->hot = '<div class="hot_deal"></div>';
                }else{
                    $deal->hot = '';
                }
                $deal->offerUrl = $this->config->item('base_url').$this->config->item('index_page').'/deals/review/'.$deal->id;
                
                if($deal->actual_price >0){
                    $deal->saving = ($deal->actual_price - $deal->deal_price);
                    $deal->savingPercentage  = round(($deal->saving * 100) / $deal->actual_price,2);
                }else{
                    $deal->savingPercentage  = 0;
                    $deal->saving = 0;
                }
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
                
                if(empty($deal->coupon_code)){
                  $deal->couponCode = '<div class="code">
				No Coupon Code Needed.
			</div>';
                }else{
			$deal->couponCode ='<div class="code">
				<div class="code_top">Use this code <span><img src="http://pccounter.net/media/images/click_to_copy.png" border="0" alt="click to copy" /></span></div>
				<div class="main_code">'.$deal->coupon_code.'</div>
			</div> ';
                }
            }
             $data['formSubmitted'] = '';
            if(!empty($saved)){
                $data['formSubmitted'] = '<font color="#FF0000">Your rating successfully submitted.</font> ';
            }
            $data['deal'] = $deals;
              /**
               * Footer
               */
              $data['dealReviewForm'] = $this->config->item('base_url').$this->config->item('index_page').'/deals/reviewForm/';
              
              /**********************************************/
                $this->load->library('parser');
                $this->parser->parse('pop', $data);
        }
        public function reviewForm(){
            $this->load->model('Review');
            $this->Review->saveReview($_REQUEST['productid'],$_REQUEST['item_rating'],$_REQUEST['feedbk_cont'],$_REQUEST['feedbk_btn']);
            $this->load->helper('url');
            redirect('/deals/review/'.$_REQUEST['productid'].'/1');
        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */