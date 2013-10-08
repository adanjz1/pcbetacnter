<?
class RoutesModel extends CI_Model {
function getCategoryRoutes(){
     $this->db->select('id,url');
     $query = $this->db->get('categories');
     return $query->result();
}
function getCategoryCouponRoutes(){
     $this->db->select('id,couponCatUrl');
     $query = $this->db->get('categories');
     return $query->result();
}
function getSubCategoryRoutes(){
     $this->db->select('id,idCategory,url');
     $query = $this->db->get('subCategories');
     return $query->result();
}
function getSourcesRoutes(){
     $this->db->select('deal_source_id,url');
     $query = $this->db->get('deal_sources');
     return $query->result();
}
function getStaticRoutes(){
     $this->db->select('id,url');
     $query = $this->db->get('staticPages');
     return $query->result();
}
function getSpecialRoutes(){
     $this->db->select('id,url');
     $query = $this->db->get('specialPages');
     return $query->result();
}
/**
 * Writes contents of database table to a cache file.
 *
 * @return void
 */
function cache($routes)
{
    $this->load->helper('file');
    $data[] = "<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');";
    foreach($routes as $value) 
    {
        $data[] = '$route["' . $value['route'] . '"] = "' . $value['controller'].'0'.$value['vars'] . '";';
        $data[] = '$route["' . $value['route'] . '/(:num)"] = "' . $value['controller'] . '$1'.$value['vars'].'";';
    }

    $output = implode("\n", $data);
    if ( ! write_file(APPPATH."cache/routes.php", $output)){
        echo 'Unable to write the file';
    }else{
        echo 'Able to write the file';
    }
} 
}