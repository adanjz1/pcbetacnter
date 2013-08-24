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
        $this->db->limit($qty);
        $query = $this->db->get('deals');
        return $query->result();
    }
    
    function get_lastDeals($qty,$from=''/*Paginator*/,$q=''/*Search*/,$category='',$subcat='',$store='')
    {
        $this->db->order_by("id", "desc");  
        $this->db->limit($qty,$from);
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
        $query = $this->db->get('deals');
        return $query->result();
    }
   
    function findMatchDeals($params){
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
        $this->db->insert('deals', $params); 
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
}

?>