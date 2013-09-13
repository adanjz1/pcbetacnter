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
class Pages extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function getAllSpecialPages(){
        $query = $this->db->get('specialPages');
        $row = $query->result();
        return $row;
    }
    function getAllStaticPages(){
        $query = $this->db->get('staticPages');
        $row = $query->result();
        return $row;
    }
    function getStaticPage($id){
        $this->db->where('id',$id);
        $query = $this->db->get('staticPages');
        $row = $query->result();
        return $row;
    }
    function getSpecialPage($id){
        $this->db->where('id',$id);
        $query = $this->db->get('specialPages');
        $row = $query->result();
        return $row;
    }
    function getSEOPage($identifier){
        $this->db->where('Identifier',$identifier);
        $query = $this->db->get('pages');
        $row = $query->result();
        return $row;
    }
}

?>
