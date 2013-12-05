<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coupons extends CI_Controller {

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
            $q = $qSearch;
            $resetSession = false;
            if(empty($limit)){
                $resetSession = true;
            }
            //IF is a category search
            if($q == 'category'){
                $q = '';
            }
            $this->load->helper('metaHelper');
            if(!empty($q)){
                $q = substr($qSearch, 3);
                if(!empty($q)){
                    $resetSession  = true;
                }
            }
            $this->load->library('session');
            
            $this->load->model('pages');
            $this->load->helper(array('form', 'url')); 
            //session_start();
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
            
            if(!empty($category) && !in_array($category, $_SESSION['categories'])){
                $_SESSION['categories'][] = $category;
            }
            if(!empty($subcat) && !in_array($subcat, $_SESSION['subcategories'])){
                $_SESSION['subcategories'][] = $subcat;
            }
            if(!empty($store) && !in_array($store, $_SESSION['stores'])){
                $_SESSION['stores'][] = $store;
            }
            
            $data = getConstData($this);
            
            
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
                $seoPg = $this->pages->getSEOPage('coupons');
                $seoPg = $seoPg[0];
                $data['pageTitle'] = $seoPg->Title;//Title tag
                $data['headerText'] = $seoPg->Header;//H1 tag
                $data['metaTitle'] = $seoPg->Meta_title;
                $data['metaKeywords'] = $seoPg->Meta_keywords;
                $data['metaDescription'] = $seoPg->Meta_Description;
            }
            $data['activeCoupons'] = 'active';
            $data['pathLocation']='<a class="prevPath" href="/">HOME</a> > <a href="#" class="activePath">COUPONS</a>';

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
            if($limit == 0){
                if(!empty($subcat)){
                    $starred = $this->Deal->get_lastStarredSubcatCoupons(16,$limit,$q,$category,$subcat,$store); //Get the other deals
                }elseif(!empty($category)){
                    $starred = $this->Deal->get_lastStarredCatCoupons(16,$limit,$q,$category,$subcat,$store); //Get the other deals
                }else{
                    $starred = $this->Deal->get_lastStarredCoupons(16,$limit,$q,$category,$subcat,$store); //Get the other deals
                }
            }
            $merge = $this->Deal->get_lastCoupons(16-count($starred),$limit,$q,$_SESSION['categories'],$_SESSION['subcategories'],$_SESSION['stores'],$_SESSION['orderBy']); //Get the other deals
            $merge = array_merge($starred,$merge);
            $data['deals'] = encapsuleDeals($merge,$this,false,3);
            $data['totalDeals'] = $this->Deal->get_totalCoupons($q,$_SESSION['categories'],$_SESSION['subcategories'],$_SESSION['stores']);
            $this->load->library('pagination');
            //$config['base_url'] = $this->config->item('base_url').$this->config->item('index_page').'/deals/paginator/'.$qSearch.'/'.$category;
            $_SESSION['uriSegment'] = $this->uri->segments[1];
            $config['base_url'] = $this->config->item('base_url').$this->config->item('index_page').$this->uri->segments[1];
            $config['total_rows'] = $data['totalDeals'];
            
            $config['uri_segment'] = 2;
            $config['per_page'] = 16; 
            $config['num_links'] = 3; 
            $this->pagination->initialize($config); 
            $data['paginator'] = $this->pagination->create_links();
            $data['subCategories'] = array();
           //arraymap, eliminar elementos con dealsQty == 0
            if(count($_SESSION['subcategories']) > 0){
                $data['categories'] = array();
            }
            $data['subCategories'] = array();
            
            /*************************FORMATING FILTERS*******************************/
            if(!empty($data['categories'])){
                $data['categories'] = deleteUsed($data['categories'],'id',$_SESSION['categories'],'categories',$this);
                $data['categories'] = array_filter($data['categories'],'normalizeArray');
            }
            $arrayOrder = $data['categories'];
            $orderTx = '';
            $orderAll = false;
            if(empty($category)){
               $orderTx .= '<li url="/coupon-codes" class="elemOrder displayable">All</li>';
               $orderAll = true;
            }else{
                $k=0;
                foreach($arrayOrder as $arr){
                    if($category == $arr->id){
                        $orderTx .= '<li url="'.$arr->couponCatUrl.'" class="elemOrder displayable">'.$arr->name.'</li>'; 
                        unset($arrayOrder[$k]);
                        break;
                    }
                    $k++;
                }
            }
            if (!$orderAll){
                $orderTx .= '<li url="/coupon-codes" class="elemOrder orderHidden">All</li>';
            }
            foreach($arrayOrder as $arr){
                $orderTx .= '<li url="'.$arr->couponCatUrl.'" class="elemOrder orderHidden">'.$arr->name.'</li>'; 
            }
            $data['categoriesSelect'] = '<ul>'.$orderTx. '</ul>';
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
                $this->parser->parse('coupons_new', $data);
                $this->parser->parse('widgets/footer_new', $data);
        }
        /* HACKS TO CENTRALIZE SEARCH AND PAGINATOR*/
        public function search(){
            $this->load->helper('url');
            redirect('/coupons/index/0/___'.$this->input->post('search'));
        }
        public function paginator($var1='',$var2='',$var3=''){
            $this->load->helper('url');
            // category pagination
            if($var1 == 'category'){
                redirect('/coupons/index/'.$var3.'/'.$var1.'/'.$var2);    
            }
            /*IF is active search*/
            if(substr($var1, 0,3) == '___'){
                redirect('/coupons/index/'.$var2.'/'.$var1);
            }else{
                redirect('/coupons/index/'.$var1.'/'.$var2);
            }
            
        }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */