<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dealsources
 *
 * @author adan
 */
class Category extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function get_categories($qty='',$limit='')
    {
        $this->db->select('*');
        if($qty != ''){
            $this->db->limit($qty,$limit);
        }
        
        $this->db->order_by("id", "asc"); 
        $query = $this->db->get('categories');
        
        return $query->result();
    }
    
    function get_categoryById($cat){
        $this->db->where('id',$cat);
        $query = $this->db->get('categories');
        $row = $query->result();
        return $row[0];
    }
    function getCategoryNameById($cat){
        
        $this->db->where('id',$cat);
        $query = $this->db->get('categories');
        $row = $query->result();
        return $row[0]->name;
    }
    function getSubCategoryNameById($cat){
        $this->db->where('id',$cat);
        $query = $this->db->get('subcategories');
        $row = $query->result();
        return $row[0]->name;
    }
    function get_subcategoryById($cat){
        $this->db->like('id',$cat);
        $query = $this->db->get('subcategories');
        $row = $query->result();
        return $row[0];
    }
    function get_categoryByStr($catName){
        $this->db->like('name',$catName);
        $query = $this->db->get('categories');
        $row = $query->result();
        if(!empty($row)){
            return $row[0]->id;
        }else{
            return false;
        }
    }
    function get_CatUrl($category)
    {
        $this->db->where('id',$category);
        $query = $this->db->get('categories');
        $result = $query->result();
        if(!empty($result[0])){
            return $result[0]->url;
        }else{
            return '';
        }
    }
    function get_subCategoryByStr($catName){
        $this->db->like('name',$catName);
        $query = $this->db->get('subcategories');
        $row = $query->result();
        if(!empty($row)){
            return $row[0]->id;
        }else{
            return false;
        }
    }
    function set_newCategory($catName){
        $this->db->set('name', $catName);
        $this->db->insert('categories');
        return $this->db->insert_id();
    }
    function set_newSubCategory($catName,$catId){
        $this->db->set('name', $catName);
        $this->db->set('idCategory', $catId);
        $this->db->insert('subcategories');
        return $this->db->insert_id();
    }
    
    
    function get_CatName($category)
    {
        $this->db->where('id',$category);
        $query = $this->db->get('categories');
        $result = $query->result();
        if(!empty($result[0])){
            return $result[0]->name;
        }else{
            return '';
        }
    }
    function get_catCant($category)
    {
        
        $this->db->where('cat_id',$category);
        $this->db->from('deals');
        return $this->db->count_all_results();
    }
    function get_totalCategories(){
         $this->db->from('categories');
        return $this->db->count_all_results();
    }
    function getFirstSubcategory($category){
        //var_dump($category->idCategory);
        $this->db->select('id');
        $this->db->where('idCategory',$category);
        $this->db->order_by("id", "asc"); 
        $query = $this->db->get('subcategories');
        return $query->result();
    }
    function get_Subcategories($qty='',$limit='',$category)
    {
        if(!empty($qty)){
            $this->db->limit($qty,$limit);
        }
        $this->db->where('idCategory',$category);
        $this->db->order_by("id", "asc"); 
        $query = $this->db->get('subcategories');
        return $query->result();
    }
    function get_AllSubcategories()
    {
        $query = $this->db->get('subcategories');
        return $query->result();
    }
    function UpdateDealsQty()
    {
        $this->db->query('update categories set dealsQty = (select count(*) from deals where deals.cat_id = categories.id and deal_start_date < NOW() and deal_end_date > NOW() and coupon_code="" and sub_cat_id > 0) ,couponsQty = (select count(*) from deals where deals.cat_id = categories.id and deal_start_date < NOW() and deal_end_date > NOW() and coupon_code!="" and sub_cat_id > 0)');
    }
    function UpdateDealsQtySubCat()
    {
        $this->db->query('update subcategories set dealsQty = (select count(*) from deals where deals.sub_cat_id = subcategories.id and deal_start_date < NOW() and deal_end_date > NOW() and coupon_code="" and sub_cat_id > 0) ,couponsQty = (select count(*) from deals where deals.sub_cat_id = subcategories.id and deal_start_date < NOW() and deal_end_date > NOW() and coupon_code!="" and sub_cat_id > 0)');
    }
    function get_totalSubCategories($category){
        $this->db->where('idCategory',$category);
         $this->db->from('subcategories');
        return $this->db->count_all_results();
    }
    
    
}

?>
