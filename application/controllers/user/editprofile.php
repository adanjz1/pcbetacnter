<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Editprofile extends Admin_Controller {

    public function index() {
        $this->load->model('crud_auth');
        $this->load->model('admin/admin_menu');
        $this->load->model('user/user_menu');
        $this->load->add_package_path(APPPATH . 'third_party/scrud/');

        $crudAuth = $this->session->userdata('CRUD_AUTH');
        $var = array();
        $conf = array();
        $var['main_menu'] = $this->admin_menu->fetch('account');
        
        
        $hook = Hook::singleton();

        $hook->addFunction('SCRUD_EDIT_FORM', 'removeElement');
        $hook->addFunction('SCRUD_EDIT_CONFIRM', 'removeElement');
        $hook->addFunction('SCRUD_BEFORE_VALIDATE', 'removeValidate');
        $hook->addFunction('SCRUD_COMPLETE_UPDATE', 'completeUpdate');
        $hook->addFunction('SCRUD_BEFORE_SAVE', 'removeElementData');
        
        
        if (!isset($_GET['xtype'])){
            $_GET['xtype'] = 'form';
        }
        $_GET['table'] = 'crud_users';
        $_GET['key']['crud_users.id'] = $crudAuth['id'];
        
        $_SERVER['QUERY_STRING'] = $_SERVER['QUERY_STRING'].'&key[crud_users.id]='.$crudAuth['id'];

        if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' . $this->input->get('table') . '.php')) {
            exit;
        }else{
        	require __DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' . $this->input->get('table') . '.php';
        }

        $conf['theme_path'] = FCPATH . 'application/views/user/profile/crud';
        $this->load->library('crud', array('table' => $this->input->get('table'), 'conf' => $conf));
        
        $var['main_content'] = $this->load->view('user/profile/profile', array('content' => $this->crud->process(),'user_menu' => $this->user_menu->fetch('profile')), true);
        
        $this->load->model('admin/admin_footer');
        $var['main_footer'] = $this->admin_footer->fetch();

        $this->load->view('layouts/user/default', $var);
    }

}