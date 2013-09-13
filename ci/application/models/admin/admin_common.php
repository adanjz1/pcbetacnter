<?php

class Admin_common extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function login() {
        $return = false;

        $sysUser = $this->config->item('sysUser');
        $crudUser = $this->input->post('crudUser', true);
        
        if (!empty($crudUser) && isset($crudUser['name']) && isset($crudUser['password'])) {
            if ($sysUser['enable'] == true) {
                if ($crudUser['name'] == $sysUser['name'] &&
                        $crudUser['password'] == $sysUser['password']) {
                    $auth = array();
                    $auth['user_name'] = $sysUser['name'];
                    
                    $group = array('group_name' => 'SystemAdmin',
                    		'group_manage_flag' => 3,
                    		'group_setting_management' => 1,
                    		'group_global_access' => 1
                    );
                    
                    $auth['group'] = $group;
                    $auth['__system_admin__'] = 1;

                    $this->session->set_userdata('CRUD_AUTH', $auth);
                    $return = true;
                }
            }
            $this->db->select('*');
            $this->db->from('crud_users');
            $this->db->where('user_name', $crudUser['name']);
            $this->db->where('user_password', sha1($crudUser['password']));

            $query = $this->db->get();
            $rs = $query->row_array();

            if (!empty($rs)) {

                $this->db->select('*');
                $this->db->from('crud_groups');
                $this->db->where('id', $rs['group_id']);

                $query = $this->db->get();
                $rs1 = $query->row_array();

                if (!empty($rs1)) {
                    $rs['group'] = $rs1;
                } else {
                    $rs['group'] = array('group_name' => 'None',
							'group_manage_flag' => 0,
							'group_setting_management' => 0,
							'group_global_access' => 0
					);
                }
                unset($rs['group_id']);
                unset($rs['user_password']);
                unset($rs['user_info']);
                $rs['__system_admin__'] = 0;
                $this->session->set_userdata('CRUD_AUTH', $rs);
                $return = true;
                require_once FCPATH . 'application/third_party/scrud/class/Cookie.php';
                if (isset($_POST['remember_me']) && (int)$_POST['remember_me'] == 1){
                	Cookie::Set('CRUD_AUTH', serialize(array(base64_encode($crudUser['name']), base64_encode(sha1($crudUser['password'])))),Cookie::SevenDays);
                }else{
                	Cookie::Delete('CRUD_AUTH');
                }
            }
        }

        return $return;
    }

}