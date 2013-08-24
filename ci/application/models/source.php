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
class Source extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function set_newSource($name, $programId){
        $this->db->set('programId', $programId);
        $this->db->set('deal_source_name', $name);
        $this->db->insert('deal_sources');
        return $this->db->insert_id();
    }
    function get_dealSourceIdByStr($dealSourceStr)
    {
        $this->db->where('deal_source_name', $dealSourceStr);
        $query = $this->db->get('deal_sources');
        $row = $query->result();
        if(!empty($row)){
            return $row[0]->deal_source_id;
        }else{
            return false;
        }
    }
    function get_dealSourceStr($idDealSource)
    {
        $this->db->where('deal_source_id', $idDealSource);
        $query = $this->db->get('deal_sources');
        $row = $query->result();
        return $row[0]->deal_source_name;
    }
    function get_dealSourceImg($idDealSource)
    {
        $this->db->where('deal_source_id', $idDealSource);
        $query = $this->db->get('deal_sources');
        $row = $query->result();
        return $row[0]->deal_source_logo_url;
    }
    function get_totalStores($initial='')
    {
        if(!empty($initial)){
            if($initial == '0-9'){
                $this->db->or_like('deal_source_name','0','after');
                $this->db->or_like('deal_source_name','1','after');
                $this->db->or_like('deal_source_name','2','after');
                $this->db->or_like('deal_source_name','3','after');
                $this->db->or_like('deal_source_name','4','after');
                $this->db->or_like('deal_source_name','5','after');
                $this->db->or_like('deal_source_name','6','after');
                $this->db->or_like('deal_source_name','7','after');
                $this->db->or_like('deal_source_name','8','after');
                $this->db->or_like('deal_source_name','9','after');
            }else{
                $this->db->like('deal_source_name',$initial,'after');
            }
        }
        $this->db->from('deal_sources');
        return $this->db->count_all_results();
    }
    function get_stores($qty,$limit='',$initial=''){
        if($initial != ''){
            $this->db->like('deal_source_name',$initial,'after');
        }
        $this->db->limit($qty,$limit);
        $this->db->order_by("deal_source_id", "desc"); 
        $query = $this->db->get('deal_sources');
        return $query->result();
    }
}

?>
