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
        $this->db->select('categories.id,categories.url, categories.couponCatUrl,categories.name, count(deals.id) as dealsQty');
        if($qty != ''){
            $this->db->limit($qty,$limit);
        }
        $this->db->join('deals','deals.cat_id = categories.id');
        $this->db->where('deals.coupon_code',NULL);
        $this->db->where('is_active', '1');
        $this->db->where('cat_id >', '0');
        $this->db->where('sub_cat_id >', '0');
        $this->db->where('coupon_code',null);
       
        $this->db->group_by('categories.id');
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
    function get_totalSubCategories($category){
        $this->db->where('idCategory',$category);
         $this->db->from('subcategories');
        return $this->db->count_all_results();
    }
    
    
}

?>
