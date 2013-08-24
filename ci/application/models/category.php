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
        if($qty != ''){
            $this->db->limit($qty,$limit);
        }
        $this->db->order_by("id", "asc"); 
        $query = $this->db->get('categories');
        
        return $query->result();
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
    function get_subCategoryByStr($catName){
        $this->db->like('name',$catName);
        $query = $this->db->get('subCategories');
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
        $this->db->insert('subCategories');
        return $this->db->insert_id();
    }
    
    
    function get_CatName($category)
    {
        $this->db->where('id',$category);
        $query = $this->db->get('categories');
        return $query->result();
    }
    function get_totalCategories(){
         $this->db->from('categories');
        return $this->db->count_all_results();
    }
    function get_Subcategories($qty,$limit='',$category)
    {
        if(!empty($qty)){
            $this->db->limit($qty,$limit);
        }
        $this->db->where('idCategory',$category);
        $this->db->order_by("id", "asc"); 
        $query = $this->db->get('subCategories');
        return $query->result();
    }
    function get_totalSubCategories($category){
        $this->db->where('idCategory',$category);
         $this->db->from('subCategories');
        return $this->db->count_all_results();
    }
    
    
}

?>
