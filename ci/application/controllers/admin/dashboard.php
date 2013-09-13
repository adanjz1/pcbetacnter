<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

    public function index() {
        $this->load->model('crud_auth');
        $this->load->model('admin/admin_menu');

        $var = array();
        
        $var['main_menu'] = $this->admin_menu->fetch();
        $var['main_content'] = $this->load->view('admin/common/dashboard',$var,true);
        
        $this->load->model('admin/admin_footer');
        $var['main_footer'] = $this->admin_footer->fetch();

        $this->load->view('layouts/admin/default', $var);
    }

}