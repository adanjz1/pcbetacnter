<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dealmodel
 *
 * @author adan
 */
class Deal extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function get_mainMenuDeals($qty)
    {
        if(!empty($this->db->ar_orderby)){
            $this->db->ar_orderby = array();
        }
        $this->db->where('mainMenuOrderStart <=', date('Y-m-d'));
        $this->db->where('mainMenuOrderEnd >', date('Y-m-d'));
        $this->db->where('is_active', '1');
        $this->db->where('cat_id >', '0');
        $this->db->where('sub_cat_id >', '0');
        $this->db->limit($qty);
        $query = $this->db->get('deals');
        return $query->result();
    }
    function getActiveCSV()
    {
        $this->db->where('status', '0');
        $query = $this->db->get('csvDeals');
        
        return $query->result();
    }
    
    function get_homeDeals($qty,$dealSourceId){
        if(!empty($this->db->ar_orderby)){
            $this->db->ar_orderby = array();
        }
        //$this->db->order_by("title", "random");  
        $this->db->limit($qty);
        $this->db->where('(mainMenuOrderStart is NULL or mainMenuOrderStart > NOW() or mainMenuOrderEnd < NOW())');
        $this->db->where('deal_sources_id', $dealSourceId);
        $this->db->where('cat_id >', '0');
        $this->db->where('is_active', '1');
        $query = $this->db->from('deals');
        //var_dump($this->db->last_query());
        return $query->result();
    }
    function get_pageDeals($qty,$from='',$idPages=0){
         if(!empty($this->db->ar_orderby)){
            $this->db->ar_orderby = array();
        }
        $this->db->limit($qty,$from);
        $this->db->like('specialpages',','.$idPages.',');
        $this->db->where('is_active', '1');
        $this->db->where('cat_id >', '0');
        $this->db->where('sub_cat_id >', '0');
        $query = $this->db->get('deals');
        
        return $query->result();
    }
    function getUnoptimizedImages($qty){
         $this->db->not_like('image_url','dr30wky7ya0nu.cloudfront.net/');
         $this->db->limit($qty);
         $this->db->order_by("title", "random"); 
         $query = $this->db->from('deals');
         return $query->result();
    }
    function getImages($qty){
         $this->db->limit($qty);
         $this->db->order_by("title", "random"); 
         $query = $this->db->from('deals');
         return $query->result();
    }
    function saveImage($idDeal='',$image){
        $this->db->where('id',$idDeal);
        $data = array(
               'image_url' >= $image,
            );
        $this->db->update('deals',$data);
    }
    function setInactive($idCsv){
        $this->db->where('id',$idCsv);
        $data = array("status">="1");
        $this->db->update("csvDeals",$data);
    }
    function delete($idDeal=''){
        $this->db->where('id',$idDeal);
        $this->db->delete('deals');
    }
    function get_totalDeals_page($idPages=0){
        if(!empty($this->db->ar_orderby)){
            $this->db->ar_orderby = array();
        }
        $this->db->where('specialpages',','.$idPages.',');
        $this->db->where('is_active', '1');
        $this->db->where('cat_id >', '0');
        $this->db->where('sub_cat_id >', '0');
        $this->db->from('deals');
        $total = $this->db->count_all_results();
        return $total;
    }
    function get_lastDealsHome($qty=0,$usedDeals=array()){
        if(!empty($this->db->ar_orderby)){
            $this->db->ar_orderby = array();
        }
        $this->db->limit($qty);
        $this->db->where('is_active', '1');
        $this->db->where('cat_id >', '0');
        $this->db->where('deal_price !=', '');        
        $this->db->where('coupon_code',''); 
        ////$this->db->where('((deal_start_date <= NOW() and deal_end_date > NOW()) or (deal_start_date = "0000-00-00 00:00:00" or deal_end_date = "0000-00-00 00:00:00") or (deal_end_date is null or deal_start_date is null))');
        if(!empty($usedDeals)){
            $this->db->where_not_in('id',$usedDeals);
        }
        $this->db->order_by('id','desc');
        $query = $this->db->get('deals');
       //var_dump($this->db->last_query());
        return $query->result();
    }
    function get_lastCouponsHome($qty=0){
        if(!empty($this->db->ar_orderby)){
            $this->db->ar_orderby = array();
        }
        $this->db->limit($qty);
        $this->db->where('is_active', '1');
        $this->db->where('cat_id >', '0');
        $this->db->where('coupon_code !=',''); 
        ////$this->db->where('((deal_start_date <= NOW() and deal_end_date > NOW()) or (deal_start_date = "0000-00-00 00:00:00" or deal_end_date = "0000-00-00 00:00:00") or (deal_end_date is null or deal_start_date is null))');
        $this->db->order_by('id','desc');
        $query = $this->db->get('deals');
       //var_dump($this->db->last_query());
        return $query->result();
    }
    function get_topDeals($qty=0,$usedDeals=array()){
        if(!empty($this->db->ar_orderby)){
            $this->db->ar_orderby = array();
        }
        $this->db->order_by('thumbs','desc');
        $this->db->limit($qty);
        $this->db->where('is_active', '1');
        $this->db->where('cat_id >', '0');
        $this->db->where('deal_price !=', '');        $this->db->where('coupon_code',''); 
        ////$this->db->where('((deal_start_date <= NOW() and deal_end_date > NOW()) or (deal_start_date = "0000-00-00 00:00:00" or deal_end_date = "0000-00-00 00:00:00") or (deal_end_date is null or deal_start_date is null))');
        $this->db->where_not_in('id',$usedDeals);
        $query = $this->db->get('deals');
       
        return $query->result();
    }
    function get_topCoupons($qty=0,$usedDeals=array()){
        if(!empty($this->db->ar_orderby)){
            $this->db->ar_orderby = array();
        }
        $this->db->order_by('thumbs','desc');
        $this->db->limit($qty);
        $this->db->where('is_active', '1');
        $this->db->where('cat_id >', '0');
        $this->db->where('coupon_code !=',''); 
        ////$this->db->where('((deal_start_date <= NOW() and deal_end_date > NOW()) or (deal_start_date = "0000-00-00 00:00:00" or deal_end_date = "0000-00-00 00:00:00") or (deal_end_date is null or deal_start_date is null))');
        $this->db->where_not_in('id',$usedDeals);
        $query = $this->db->get('deals');
       
        return $query->result();
    }
    function get_lastDeals($qty,$from=''/*Paginator*/,$q=''/*Search*/,$category=array(),$subcat=array(),$store=array(),$minPrice=0,$maxPrice=0,$orderBy=array('id','desc'))
    {   
        if(!empty($this->db->ar_orderby)){
            $this->db->ar_orderby = array();
        }
        if(!empty($orderBy)){
            $this->db->order_by($orderBy[0], $orderBy[1]);
        }
        
        $this->db->limit($qty,$from);
        
        if(!empty($subcat)){
            $this->db->where_in('sub_cat_id',$subcat);
        }
        if(!empty($category)){
            $this->db->where_in('cat_id',$category);
        }
        if(!empty($store)){
            $this->db->where_in('deal_sources_id',$store);
        }
        if(!empty($minPrice)){
            $this->db->where('deal_price > ',$minPrice);
        }
        if(!empty($maxPrice)){
            $this->db->where('deal_price < ',$maxPrice);
        }
        if(!empty($q)){
            $str = explode('%20',$q);
            $sep = '';
            $like='((';
            foreach($str as $qsearch){
                $like .= $sep.' title like "%'.$qsearch.'%"';
                $sep = ' and';
            }
            $sep = '';
            $like.=') or (';
            foreach($str as $qsearch){
                $like .= $sep.' description like "%'.$qsearch.'%"';
                $sep = ' and';
            }
            $like .= '))';
            $this->db->where($like);
        }
        
        
        $this->db->where('is_active', '1');
        $this->db->where('cat_id >', '0');
        $this->db->where('sub_cat_id >', '0');
        $this->db->where('deal_price !=', '');
        $this->db->where('coupon_code',''); 
        ////$this->db->where('((deal_start_date <= NOW() and deal_end_date > NOW()) or (deal_start_date = "0000-00-00 00:00:00" or deal_end_date = "0000-00-00 00:00:00") or (deal_end_date is null or deal_start_date is null))');
        $query = $this->db->get('deals');
        //vd($this->db->last_query());
        return $query->result();
    }
    function get_lastCoupons($qty,$from=''/*Paginator*/,$q=''/*Search*/,$category=array(),$subcat=array(),$store=array(),$minPrice=0,$maxPrice=0,$orderBy=array('id','desc'))
    {   
        if(!empty($this->db->ar_orderby)){
            $this->db->ar_orderby = array();
        }
        if(!empty($order_by)){
            //$this->db->order_by($orderBy[0], $orderBy[1]);
        }
        $this->db->limit($qty,$from);
        
        if(!empty($subcat)){
            $this->db->where_in('sub_cat_id',$subcat);
        }
        if(!empty($category)){
            $this->db->where_in('cat_id',$category);
        }
        if(!empty($store)){
            $this->db->where_in('deal_sources_id',$store);
        }
        if(!empty($q)){
            $str = explode('%20',$q);
            $sep = '';
            $like='((';
            foreach($str as $qsearch){
                $like .= $sep.' title like "%'.$qsearch.'%"';
                $sep = ' and';
            }
            $sep = '';
            $like.=') or (';
            foreach($str as $qsearch){
                $like .= $sep.' description like "%'.$qsearch.'%"';
                $sep = ' and';
            }
            $like .= '))';
            $this->db->where($like);
        }
        
        
        $this->db->where('is_active', '1');
        $this->db->where('cat_id >', '0');
        $this->db->where('sub_cat_id >', '0');
        $this->db->where('coupon_code !=','');
        //$this->db->where('((deal_start_date <= NOW() and deal_end_date > NOW()) or (deal_start_date = "0000-00-00 00:00:00" or deal_end_date = "0000-00-00 00:00:00") or (deal_end_date is null or deal_start_date is null))');
        $query = $this->db->get('deals');
//        var_dump($this->db->last_query());
        return $query->result();
    }
       
    function get_lastStarredSubcatDeals($qty,$from=''/*Paginator*/,$q=''/*Search*/,$category='',$subcat='',$store='')
    {
        if(!empty($this->db->ar_orderby)){
            $this->db->ar_orderby = array();
        }
        $this->db->limit($qty,$from);
        if(!empty($q)){
            $str = explode('%20',$q);
            $sep = '';
            $like='((';
            foreach($str as $qsearch){
                $like .= $sep.' title like "%'.$qsearch.'%"';
                $sep = ' and';
            }
            $sep = '';
            $like.=') or (';
            foreach($str as $qsearch){
                $like .= $sep.' description like "%'.$qsearch.'%"';
                $sep = ' and';
            }
            $like .= '))';
            $this->db->where($like);
        }
        if(!empty($subcat) && $subcat != 'null'){
            $this->db->where_in('sub_cat_id',$subcat);
        }
        if(!empty($category) && $category != 'null'){
            $this->db->where_in('cat_id',$category);
        }
        if(!empty($store) && $store != 'null'){
            $this->db->where_in('deal_sources_id',$store);
        }
        $this->db->where('is_active', '1');
        $this->db->where('cat_id >', '0');
        $this->db->where('hotSubCategoryStart <=', date('Y-m-d'));
        $this->db->where('hotSubCategoryEnd >', date('Y-m-d'));
        $this->db->where('deal_price !=', '');
        $this->db->where('coupon_code','');
        //$this->db->where('((deal_start_date <= NOW() and deal_end_date > NOW()) or (deal_start_date = "0000-00-00 00:00:00" or deal_end_date = "0000-00-00 00:00:00") or (deal_end_date is null or deal_start_date is null))');
        $query = $this->db->get('deals');
        
        return $query->result();
    }
    function get_lastStarredSubcatCoupons($qty,$from=''/*Paginator*/,$q=''/*Search*/,$category='',$subcat='',$store='')
    {
        if(!empty($this->db->ar_orderby)){
            $this->db->ar_orderby = array();
        }
        $this->db->limit($qty,$from);
        if(!empty($q)){
            $str = explode('%20',$q);
            $sep = '';
            $like='((';
            foreach($str as $qsearch){
                $like .= $sep.' title like "%'.$qsearch.'%"';
                $sep = ' and';
            }
            $sep = '';
            $like.=') or (';
            foreach($str as $qsearch){
                $like .= $sep.' description like "%'.$qsearch.'%"';
                $sep = ' and';
            }
            $like .= '))';
            $this->db->where($like);
        }
        if(!empty($subcat)){
            $this->db->where_in('sub_cat_id',$subcat);
        }
        if(!empty($category)){
            $this->db->where_in('cat_id',$category);
        }
        if(!empty($store)){
            $this->db->where_in('deal_sources_id',$store);
        }
        $this->db->where('is_active', '1');
        $this->db->where('cat_id >', '0');
        $this->db->where('hotSubCategoryStart <=', date('Y-m-d'));
        $this->db->where('hotSubCategoryEnd >', date('Y-m-d'));
        $this->db->where('coupon_code !=',''); 
        //$this->db->where('((deal_start_date <= NOW() and deal_end_date > NOW()) or (deal_start_date = "0000-00-00 00:00:00" or deal_end_date = "0000-00-00 00:00:00") or (deal_end_date is null or deal_start_date is null))');
        $query = $this->db->get('deals');
        
        return $query->result();
    }
    function get_lastStarredCatDeals($qty,$from=''/*Paginator*/,$q=''/*Search*/,$category='',$subcat='',$store='')
    {
         if(!empty($this->db->ar_orderby)){
            $this->db->ar_orderby = array();
        }
        $this->db->limit($qty,$from);
       if(!empty($q)){
            $str = explode('%20',$q);
            $sep = '';
            $like='((';
            foreach($str as $qsearch){
                $like .= $sep.' title like "%'.$qsearch.'%"';
                $sep = ' and';
            }
            $sep = '';
            $like.=') or (';
            foreach($str as $qsearch){
                $like .= $sep.' description like "%'.$qsearch.'%"';
                $sep = ' and';
            }
            $like .= '))';
            $this->db->where($like);
        }
        if(!empty($subcat)){
            $this->db->where_in('sub_cat_id',$subcat);
        }
        if(!empty($category)){
            $this->db->where_in('cat_id',$category);
        }
        if(!empty($store)){
            $this->db->where_in('deal_sources_id',$store);
        }
        $this->db->where('hotCategoryStart <=', date('Y-m-d'));
        $this->db->where('hotCategoryEnd >', date('Y-m-d'));
        $this->db->where('cat_id >', '0');
        $this->db->where('is_active', '1');
        $this->db->where('deal_price !=', '');        $this->db->where('coupon_code',''); 
        //$this->db->where('((deal_start_date <= NOW() and deal_end_date > NOW()) or (deal_start_date = "0000-00-00 00:00:00" or deal_end_date = "0000-00-00 00:00:00") or (deal_end_date is null or deal_start_date is null))');
        $query = $this->db->get('deals');
        
        return $query->result();
    }
    function get_lastStarredCatCoupons($qty,$from=''/*Paginator*/,$q=''/*Search*/,$category='',$subcat='',$store='')
    {
         if(!empty($this->db->ar_orderby)){
            $this->db->ar_orderby = array();
        }
        $this->db->limit($qty,$from);
       if(!empty($q)){
            $str = explode('%20',$q);
            $sep = '';
            $like='((';
            foreach($str as $qsearch){
                $like .= $sep.' title like "%'.$qsearch.'%"';
                $sep = ' and';
            }
            $sep = '';
            $like.=') or (';
            foreach($str as $qsearch){
                $like .= $sep.' description like "%'.$qsearch.'%"';
                $sep = ' and';
            }
            $like .= '))';
            $this->db->where($like);
        }
        if(!empty($subcat)){
            $this->db->where_in('sub_cat_id',$subcat);
        }
        if(!empty($category)){
            $this->db->where_in('cat_id',$category);
        }
        if(!empty($store)){
            $this->db->where_in('deal_sources_id',$store);
        }
        $this->db->where('hotCategoryStart <=', date('Y-m-d'));
        $this->db->where('hotCategoryEnd >', date('Y-m-d'));
        $this->db->where('cat_id >', '0');
        $this->db->where('is_active', '1');
        $this->db->where('coupon_code !=',''); 
        //$this->db->where('((deal_start_date <= NOW() and deal_end_date > NOW()) or (deal_start_date = "0000-00-00 00:00:00" or deal_end_date = "0000-00-00 00:00:00") or (deal_end_date is null or deal_start_date is null))');
        $query = $this->db->get('deals');
        
        return $query->result();
    }
    function get_lastStarredDeals($qty,$from=''/*Paginator*/,$q=''/*Search*/,$category='',$subcat='',$store='')
    {
         if(!empty($this->db->ar_orderby)){
            $this->db->ar_orderby = array();
        }
        $this->db->limit($qty,$from);
        if(!empty($q)){
            $str = explode('%20',$q);
            $sep = '';
            $like='((';
            foreach($str as $qsearch){
                $like .= $sep.' title like "%'.$qsearch.'%"';
                $sep = ' and';
            }
            $sep = '';
            $like.=') or (';
            foreach($str as $qsearch){
                $like .= $sep.' description like "%'.$qsearch.'%"';
                $sep = ' and';
            }
            $like .= '))';
            $this->db->where($like);
        }
        if(!empty($subcat)){
            $this->db->where_in('sub_cat_id',$subcat);
        }
        if(!empty($category)){
            $this->db->where_in('cat_id',$category);
        }
        if(!empty($store)){
            $this->db->where_in('deal_sources_id',$store);
        }
        $this->db->where('is_active', '1');
        $this->db->where('hotDealsStart >=', date('Y-m-d'));
        $this->db->where('hotDealsEnd <', date('Y-m-d'));
        $this->db->where('cat_id >', '0');
        $this->db->where('deal_price !=', '');        $this->db->where('coupon_code',''); 
        //$this->db->where('((deal_start_date <= NOW() and deal_end_date > NOW()) or (deal_start_date = "0000-00-00 00:00:00" or deal_end_date = "0000-00-00 00:00:00") or (deal_end_date is null or deal_start_date is null))');
        
        $query = $this->db->get('deals');
        
        return $query->result();
    }
    function get_lastStarredCoupons($qty,$from=''/*Paginator*/,$q=''/*Search*/,$category='',$subcat='',$store='')
    {
         if(!empty($this->db->ar_orderby)){
            $this->db->ar_orderby = array();
        }
        $this->db->limit($qty,$from);
        if(!empty($q)){
            $str = explode('%20',$q);
            $sep = '';
            $like='((';
            foreach($str as $qsearch){
                $like .= $sep.' title like "%'.$qsearch.'%"';
                $sep = ' and';
            }
            $sep = '';
            $like.=') or (';
            foreach($str as $qsearch){
                $like .= $sep.' description like "%'.$qsearch.'%"';
                $sep = ' and';
            }
            $like .= '))';
            $this->db->where($like);
        }
        if(!empty($subcat)){
            $this->db->where_in('sub_cat_id',$subcat);
        }
        if(!empty($category)){
            $this->db->where_in('cat_id',$category);
        }
        if(!empty($store)){
            $this->db->where_in('deal_sources_id',$store);
        }
        $this->db->where('is_active', '1');
        $this->db->where('hotDealsStart >=', date('Y-m-d'));
        $this->db->where('hotDealsEnd <', date('Y-m-d'));
        $this->db->where('cat_id >', '0');
        $this->db->where('coupon_code !=',''); 
        //$this->db->where('((deal_start_date <= NOW() and deal_end_date > NOW()) or (deal_start_date = "0000-00-00 00:00:00" or deal_end_date = "0000-00-00 00:00:00") or (deal_end_date is null or deal_start_date is null))');
        $query = $this->db->get('deals');
        
        return $query->result();
    }
   
    function findMatchDeals($params){
        $this->db->select('id');
        $this->db->where($params); 
        $query = $this->db->get('deals');
        
        return $query->result();
    }
    function get_dealsWithCode($qty)
    {
        if(!empty($this->db->ar_orderby)){
            $this->db->ar_orderby = array();
        }
        $this->db->where('coupon_code !=',''); 
        //$this->db->where('((deal_start_date <= NOW() and deal_end_date > NOW()) or (deal_start_date = "0000-00-00 00:00:00" or deal_end_date = "0000-00-00 00:00:00") or (deal_end_date is null or deal_start_date is null))');
        $this->db->order_by("id", "desc"); 
        $this->db->limit($qty);
        $this->db->where('is_active', '1');
        $query = $this->db->get('deals');
        return $query->result();
    }
    function getCountDealsByStore($store=''){
        $this->db->where('deal_sources_id',$store);
        $this->db->where('is_active', '1');
        $this->db->where('cat_id >', '0');
        $this->db->where('sub_cat_id >', '0');
        $this->db->where('deal_price !=', '');        $this->db->where('coupon_code',''); 
        //$this->db->where('((deal_start_date <= NOW() and deal_end_date > NOW()) or (deal_start_date = "0000-00-00 00:00:00" or deal_end_date = "0000-00-00 00:00:00") or (deal_end_date is null or deal_start_date is null))');
        $this->db->from('deals');
        return $this->db->count_all_results();
    }
    function getCountDealsByStoreAndCategoryFilters($store='',$categories=array(),$subcategories=array()){
        $this->db->where('deal_sources_id',$store);
        if(!empty($categories)){
            $this->db->where_in('cat_id',$categories);
        }
        if(!empty($subcategories)){
            $this->db->where_in('sub_cat_id',$subcategories);
        }
        $this->db->where('is_active', '1');
        $this->db->where('cat_id >', '0');
        $this->db->where('sub_cat_id >', '0');
        $this->db->where('deal_price !=', '');        $this->db->where('coupon_code',''); 
        //$this->db->where('((deal_start_date <= NOW() and deal_end_date > NOW()) or (deal_start_date = "0000-00-00 00:00:00" or deal_end_date = "0000-00-00 00:00:00") or (deal_end_date is null or deal_start_date is null))');
        $this->db->from('deals');
        return $this->db->count_all_results();
    }
    function getCountDealsBySubCategory($subcat=''){
        $this->db->where('sub_cat_id',$subcat);
        $this->db->where('is_active', '1');
        $this->db->where('cat_id >', '0');
        $this->db->where('sub_cat_id >', '0');
        $this->db->where('deal_price !=', '');        $this->db->where('coupon_code',''); 
        //$this->db->where('((deal_start_date <= NOW() and deal_end_date > NOW()) or (deal_start_date = "0000-00-00 00:00:00" or deal_end_date = "0000-00-00 00:00:00") or (deal_end_date is null or deal_start_date is null))');
        $this->db->from('deals');
        return $this->db->count_all_results();
    }
    function getCountDealsByCategoryAndStoreFilters($subcat='',$stores = array()){
        $this->db->where('cat_id',$subcat);
        if(!empty($stores)){
            $this->db->where_in('deal_sources_id',$stores);
        }
        $this->db->where('is_active', '1');
        $this->db->where('cat_id >', '0');
        $this->db->where('sub_cat_id >', '0');
        $this->db->where('deal_price !=', '');        $this->db->where('coupon_code',''); 
        //$this->db->where('((deal_start_date <= NOW() and deal_end_date > NOW()) or (deal_start_date = "0000-00-00 00:00:00" or deal_end_date = "0000-00-00 00:00:00") or (deal_end_date is null or deal_start_date is null))');
        $this->db->from('deals');
        return $this->db->count_all_results();
    }
    function getCountDealsBySubCategoryAndStoreFilters($cat='',$stores=array()){
        $this->db->where('sub_cat_id',$cat);
        if(!empty($stores)){
            $this->db->where_in('deal_sources_id',$stores);
        }
        $this->db->where('is_active', '1');
        $this->db->where('cat_id >', '0');
        $this->db->where('sub_cat_id >', '0');
        $this->db->where('deal_price !=', '');        $this->db->where('coupon_code',''); 
        //$this->db->where('((deal_start_date <= NOW() and deal_end_date > NOW()) or (deal_start_date = "0000-00-00 00:00:00" or deal_end_date = "0000-00-00 00:00:00") or (deal_end_date is null or deal_start_date is null))');
        $this->db->from('deals');
        return $this->db->count_all_results();
    }
    function getCountDealsByCategory($cat=''){
        $this->db->where('cat_id',$cat);
        $this->db->where('is_active', '1');
        $this->db->where('cat_id >', '0');
        $this->db->where('sub_cat_id >', '0');
        $this->db->where('deal_price !=', '');        $this->db->where('coupon_code',''); 
        //$this->db->where('((deal_start_date <= NOW() and deal_end_date > NOW()) or (deal_start_date = "0000-00-00 00:00:00" or deal_end_date = "0000-00-00 00:00:00") or (deal_end_date is null or deal_start_date is null))');
        $this->db->from('deals');
        return $this->db->count_all_results();
    }
    function get_totalDeals($q='',$category='',$subcat='',$store='',$minPrice=0,$maxPrice=0){
       if(!empty($this->db->ar_orderby)){
            $this->db->ar_orderby = array();
        }
        if(!empty($subcat)){
            $this->db->where_in('sub_cat_id',$subcat);
        }
        if(!empty($category)){
            $this->db->where_in('cat_id',$category);
        }
        if(!empty($store)){
            $this->db->where_in('deal_sources_id',$store);
        }
        if(!empty($minPrice)){
            $this->db->where('deal_price > ',$minPrice);
        }
        if(!empty($maxPrice)){
            $this->db->where('deal_price < ',$maxPrice);
        }
        if(!empty($q)){
            $str = explode('%20',$q);
            $sep = '';
            $like='((';
            foreach($str as $qsearch){
                $like .= $sep.' title like "%'.$qsearch.'%"';
                $sep = ' and';
            }
            $sep = '';
            $like.=') or (';
            foreach($str as $qsearch){
                $like .= $sep.' description like "%'.$qsearch.'%"';
                $sep = ' and';
            }
            $like .= '))';
            $this->db->where($like);
        }
        $this->db->where('is_active', '1');
        $this->db->where('cat_id >', '0');
        $this->db->where('sub_cat_id >', '0');
        $this->db->where('deal_price !=', '');        $this->db->where('coupon_code',''); 
        //$this->db->where('((deal_start_date <= NOW() and deal_end_date > NOW()) or (deal_start_date = "0000-00-00 00:00:00" or deal_end_date = "0000-00-00 00:00:00") or (deal_end_date is null or deal_start_date is null))');
        $this->db->from('deals');
        
        $t  = $this->db->count_all_results();
//        vd($this->db->last_query());
        return $t;
    }
    function get_totalCoupons($q='',$category='',$subcat='',$store=''){
       if(!empty($this->db->ar_orderby)){
            $this->db->ar_orderby = array();
        }
        if(!empty($subcat)){
            $this->db->where_in('sub_cat_id',$subcat);
        }
        if(!empty($category)){
            $this->db->where_in('cat_id',$category);
        }
        if(!empty($store)){
            $this->db->where_in('deal_sources_id',$store);
        }
        if(!empty($q)){
            $this->db->like('title',$q);
            $this->db->or_like('description',$q);
        }
        $this->db->where('is_active', '1');
        $this->db->where('cat_id >', '0');
        $this->db->where('sub_cat_id >', '0');
        $this->db->where('coupon_code !=',''); 
        //$this->db->where('((deal_start_date <= NOW() and deal_end_date > NOW()) or (deal_start_date = "0000-00-00 00:00:00" or deal_end_date = "0000-00-00 00:00:00") or (deal_end_date is null or deal_start_date is null))');
        $this->db->from('deals');
        $total  = $this->db->count_all_results();
        //vd($this->db->last_query());
        return $total;
    }
    
    function get_dealById($id){
        $this->db->where('id',$id);
        $query = $this->db->get('deals');
        return $query->result();
    }
    function set_deal($params){
        if(count($params) > 1){
            $this->db->insert_batch('deals', $params); 
        }else{
            $this->db->insert('deals', $params[0]); 
        }
        
    }
    function set_activation($idDeal='', $value=0){
        if(!empty($idDeal)){
            $this->db->where('id',$idDeal);
        }
        $data = array(
               'is_active' >= $value,
            );
        $this->db->update('deals',$data);
    }
    function set_plusOnedeal($idDeal='',$dealLikes=0){
        $this->db->where('id',$idDeal);
        $data = array(
               'thumbs' >= $dealLikes,
            );
        $this->db->update('deals',$data);
    }
    function get_dealLikes($idDeal=''){
        $this->db->select('thumbs');
        $this->db->where('id',$idDeal);
        $query = $this->db->get('deals');
        return $query->result();
    }
}

?>
