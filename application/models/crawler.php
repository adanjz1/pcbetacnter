<?php
class Crawler extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function get_keywords(){
        $this->db->select('keyword');
        $query = $this->db->get('crawlerKeys');
        $data = $query->result();
        $ret = array();
        foreach($data as $d){
            $ret[] = $d->keyword;
        }
        return $ret;
    }
    function get_advertisers($qty,$limit){
        $this->db->select('code');
        $this->db->limit($qty,$limit);
        $query = $this->db->get('cjadvertisers');
        $data = $query->result();
        $ret = array();
        foreach($data as $d){
            $ret[] = $d->code;
        }
        return $ret;
    }

}
