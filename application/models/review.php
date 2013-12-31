<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of review
 *
 * @author adan
 */
class Review extends CI_Model {
    //put your code here
    public function get_reviews($product=''){
        $this->db->where('product_id', $product);
        $query = $this->db->get('product_review');
        return $query->result();
    }
    public function get_qtyComments($product=''){
        $this->db->where('product_id',$product);
        $this->db->where('review !=','');
        $this->db->from('product_review');
        return $this->db->count_all_results();
    }
    public function get_qtyReviews($product=''){
        $this->db->where('product_id',$product);
        $this->db->from('product_review');
        return $this->db->count_all_results();
    }
    public function saveReview($product_id,$rating=0,$comment='',$btn){
        $this->db->set('product_id', $product_id);
        $this->db->set('review', $comment);
        $this->db->set('datetime', date('Y-m-d H:i:s'));
        $this->db->set('stars', $rating);
        return $this->db->insert('product_review');
    }
    public function get_sumStars($product=''){
        $this->db->where('product_id',$product);
        $this->db->select_sum('stars');
        $query = $this->db->get('product_review');
        return $query->result();
    }
}

?>
