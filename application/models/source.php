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
        $this->db->set('name', $name);
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
    function get_source($idDealSource)
    {
        $this->db->where('deal_source_id', $idDealSource);
        $query = $this->db->get('deal_sources');
        $this->db->order_by("deal_source_name", "asc"); 
        $row = $query->result();
        return $row[0];
    }
    function get_dealSourceImg($idDealSource)
    {
        $this->db->where('deal_source_id', $idDealSource);
        $query = $this->db->get('deal_sources');
        $row = $query->result();
        return $row[0]->deal_source_logo_url;
    }
    function getNonEmptyStores(){
        
        $query = $this->db->query('SELECT Distinct deal_sources_id FROM deals');
        $ids = array();
        foreach ($query->result_array() as $dealSourceId){
            //var_dump($dealSourceId['deal_sources_id']);
            $ids[]=$dealSourceId['deal_sources_id'];
        }
        return $ids;
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
        
        $this->db->order_by("deal_source_name", "asc"); 
        $idStoresNonEmpty = (array)$this->getNonEmptyStores();
        $this->db->where_in('deal_source_id',$idStoresNonEmpty);
        $this->db->from('deal_sources');
        $t = $this->db->count_all_results();
        return $t;
    }
    function get_stores($qty='',$limit='',$initial=''){
        $this->db->select('deal_sources.deal_source_id, deal_sources.deal_source_name, deal_sources.name, deal_sources.deal_source_url, deal_sources.deal_source_logo_url,deal_sources.url, count(deals.id) as dealsQty');
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
        $this->db->join('deals','deals.deal_sources_id = deal_sources.deal_source_id');
        $this->db->group_by('deal_sources.deal_source_id');
        $this->db->limit($qty,$limit);
        $this->db->order_by("deal_source_name", "asc"); 
        $idStoresNonEmpty = (array)$this->getNonEmptyStores();
        $this->db->where_in('deal_source_id',$idStoresNonEmpty);
        $this->db->where('deals.coupon_code','');
        $this->db->where('deals.is_active',1);
        $this->db->where('deals.cat_id >',0);
        $this->db->where('deals.sub_cat_id >',0);
       //var_dump($idStoresNonEmpty);
        $query = $this->db->get('deal_sources');
        return $query->result();
    }
}

?>
