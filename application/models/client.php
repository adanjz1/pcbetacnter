<?php

class Client extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function insertEmail($email){
        $this->db->insert('Clients',array('email'=>$email));
        
    }
}

?>
