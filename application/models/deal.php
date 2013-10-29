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
    var $id = 0;
    var $deal_sources_id = '';
    var $cat_id = '';
    var $sub_cat_id = '';
    var $mainMenuOrder = ''; //if 0, no main menu
    var $title = '';
    var $display_name = '';
    var $description = '';
    var $short_description = '';
    var $deal_url = '';
    var $image_url = '';
    var $deal_end_date = '';
    var $deal_start_date = '';
    var $deal_price = '';
    var $actual_price = '';
    var $savings_amount = '';
    var $discount_perc = '';
    var $deal_type = '';
    var $sku = '';
    var $keywords='';
    var $isDailyDeal='';
    var $is_active='';
    var $deal_coupon='';
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function get_mainMenuDeals($qty)
    {
        $this->db->where('mainMenuOrder >', '0');
        $this->db->where('is_active', '1');
        $this->db->where('cat_id >', '0');
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
        
        //$this->db->order_by("title", "random");  
        $this->db->limit($qty);
        $this->db->where('(mainMenuOrder is NULL or mainMenuOrder = 0)');
        $this->db->where('deal_sources_id', $dealSourceId);
        $this->db->where('cat_id >', '0');
        $this->db->where('is_active', '1');
        $query = $this->db->get('deals');
        //var_dump($this->db->last_query());
        return $query->result();
    }
    function get_pageDeals($qty,$from='',$idPages=0){
         
        $this->db->limit($qty,$from);
        $this->db->like('specialPages',','.$idPages.',');
        $this->db->where('is_active', '1');
        $this->db->where('cat_id >', '0');
        $query = $this->db->get('deals');
        
        return $query->result();
    }
    function getUnoptimizedImages($qty){
         $this->db->not_like('image_url','dr30wky7ya0nu.cloudfront.net/');
         $this->db->limit($qty);
         $this->db->order_by("title", "random"); 
         $query = $this->db->get('deals');
         return $query->result();
    }
    function getImages($qty){
         $this->db->limit($qty);
         $this->db->order_by("title", "random"); 
         $query = $this->db->get('deals');
         return $query->result();
    }
    function saveImage($idDeal='',$image){
        $this->db->where('id',$idDeal);
        $data = array(
               'image_url' => $image,
            );
        $this->db->update('deals',$data);
    }
    function setInactive($idCsv){
        $this->db->where('id',$idCsv);
        $data = array("status"=>"1");
        $this->db->update("csvDeals",$data);
    }
    function delete($idDeal=''){
        $this->db->where('id',$idDeal);
        $this->db->delete('deals');
    }
    function get_totalDeals_page($idPages=0){
        $this->db->where('specialPages',','.$idPages.',');
        $this->db->where('is_active', '1');
        $this->db->where('cat_id >', '0');
        $this->db->where('sub_cat_id >', '0');
        $this->db->get('deals');
        return $this->db->count_all_results();
    }
    
    function get_lastDeals($qty,$from=''/*Paginator*/,$q=''/*Search*/,$category='',$subcat='',$store='')
    {
        
        $this->db->limit($qty,$from);
        
        if($subcat != '' && $subcat != 'null'){
            $this->db->where('sub_cat_id',$subcat);
        }
        if($category != '' && $category != 'null'){
            $this->db->where('cat_id',$category);
        }
        if($store != '' && $store != 'null'){
            $this->db->where('deal_sources_id',$store);
        }
        if($q != ''){
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
        $this->db->where('coupon_code',null);
        $query = $this->db->get('deals');
       // var_dump($this->db->last_query());
        return $query->result();
    }
       
    function get_lastStarredSubcatDeals($qty,$from=''/*Paginator*/,$q=''/*Search*/,$category='',$subcat='',$store='')
    {
        
        $this->db->limit($qty,$from);
        if($q != ''){
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
        if($subcat != '' && $subcat != 'null'){
            $this->db->where('sub_cat_id',$subcat);
        }
        if($category != '' && $category != 'null'){
            $this->db->where('cat_id',$category);
        }
        if($store != '' && $store != 'null'){
            $this->db->where('deal_sources_id',$store);
        }
        $this->db->where('is_active', '1');
        $this->db->where('cat_id >', '0');
        $this->db->where('hotSubCategoty', '1');
        $query = $this->db->get('deals');
        
        return $query->result();
    }
    function get_lastStarredCatDeals($qty,$from=''/*Paginator*/,$q=''/*Search*/,$category='',$subcat='',$store='')
    {
         
        $this->db->limit($qty,$from);
       if($q != ''){
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
        if($subcat != '' && $subcat != 'null'){
            $this->db->where('sub_cat_id',$subcat);
        }
        if($category != '' && $category != 'null'){
            $this->db->where('cat_id',$category);
        }
        if($store != '' && $store != 'null'){
            $this->db->where('deal_sources_id',$store);
        }
        $this->db->where('hotCategory', '1');
        $this->db->where('cat_id >', '0');
        $this->db->where('is_active', '1');
        $query = $this->db->get('deals');
        
        return $query->result();
    }
    function get_lastStarredDeals($qty,$from=''/*Paginator*/,$q=''/*Search*/,$category='',$subcat='',$store='')
    {
         
        $this->db->limit($qty,$from);
        if($q != ''){
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
        if($subcat != '' && $subcat != 'null'){
            $this->db->where('sub_cat_id',$subcat);
        }
        if($category != '' && $category != 'null'){
            $this->db->where('cat_id',$category);
        }
        if($store != '' && $store != 'null'){
            $this->db->where('deal_sources_id',$store);
        }
        $this->db->where('is_active', '1');
        $this->db->where('hotDeals', '1');
        $this->db->where('cat_id >', '0');
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
        $this->db->where('coupon_code !=','');
        $this->db->order_by("id", "desc"); 
        $this->db->limit($qty);
        $this->db->where('is_active', '1');
        $query = $this->db->get('deals');
        return $query->result();
    }
    function get_totalDeals($q='',$category,$subcat='',$store=''){
         if($q != ''){
            $this->db->like('title',$q);
            $this->db->or_like('description',$q);
        }
        if($subcat != '' && $subcat != 'null'){
            $this->db->where('sub_cat_id',$subcat);
        }
        if($category != '' && $category != 'null'){
            $this->db->where('cat_id',$category);
        }
        if($store != '' && $store != 'null'){
            $this->db->where('deal_sources_id',$store);
        }
        $this->db->where('is_active', '1');
        $this->db->where('cat_id >', '0');
        $this->db->where('sub_cat_id >', '0');
        $this->db->where('coupon_code',null);
        $this->db->from('deals');
        return $this->db->count_all_results();
    }
    function get_totalCoupons($cat=''){
        $this->db->where('coupon_code !=','');
         if($cat != ''){
            $this->db->where('cat_id',$cat);
        }
        
        $this->db->where('is_active', '1');
        $this->db->from('deals');
        return $this->db->count_all_results();
    }
    function get_lastCoupons($qty,$from=''/*Paginator*/,$cat=''/*Category*/)
    {
        $this->db->where('coupon_code !=','');
        $this->db->order_by("id", "desc");  
        $this->db->limit($qty,$from);
        if($cat != ''){
            
            $this->db->where('cat_id',$cat);
        }
        $this->db->where('is_active', '1');
        $query = $this->db->get('deals');
        return $query->result();
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
               'is_active' => $value,
            );
        $this->db->update('deals',$data);
    }
    function set_plusOnedeal($idDeal='',$dealLikes=0){
        $this->db->where('id',$idDeal);
        $data = array(
               'thumbs' => $dealLikes,
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
