<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Index extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if (file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/v_1.0.txt')) {
            exit;
        }
        if (count($_POST) > 0) {
            return $this->update();
        } else {
            return $this->dispay();
        }
    }

    private function dispay() {
        $var = array();
        $var['errors'] = array();
        $var['main_content'] = $this->load->view('install/install', $var, true);
        $this->load->view('layouts/install', $var);
    }

    private function update() {
        $errors = array();
        if (!is_writable(__DATABASE_CONFIG_PATH__)) {
            $errors[] = 'Sorry, <b>' . __DATABASE_CONFIG_PATH__ . '</b> directory is not allowed to write.';
        }

        if (count($errors) > 0) {
            $var = array();
            $var['errors'] = $errors;
            $var['main_content'] = $this->load->view('install/install', $var, true);
            $this->load->view('layouts/install', $var);
        } else {
            require dirname(__FILE__) . '/phpMyImporter.php';

            if (!is_dir(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database)) {
                $oldumask = umask(0);
                mkdir(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database, 0777);
                umask($oldumask);
            }

            // install user data

            $connection = @mysql_connect($this->db->hostname, $this->db->username, $this->db->password);

            // install new

            ob_start();
            $filename = dirname(__FILE__) . '/data/user/sql/crud_components.sql';
            $compress = false;
            $dump = new phpMyImporter($this->db->database, $connection, $filename, $compress);
            $dump->utf8 = true;
            $dump->doImport();
            ob_get_clean();
            
            ob_start();
            $filename = dirname(__FILE__) . '/data/user/sql/crud_group_components.sql';
            $compress = false;
            $dump = new phpMyImporter($this->db->database, $connection, $filename, $compress);
            $dump->utf8 = true;
            $dump->doImport();
            ob_get_clean();

            ob_start();
            $filename = dirname(__FILE__) . '/data/user/sql/crud_groups.sql';
            $compress = false;
            $dump = new phpMyImporter($this->db->database, $connection, $filename, $compress);
            $dump->utf8 = true;
            $dump->doImport();
            ob_get_clean();
            
            ob_start();
            $filename = dirname(__FILE__) . '/data/user/sql/crud_histories.sql';
            $compress = false;
            $dump = new phpMyImporter($this->db->database, $connection, $filename, $compress);
            $dump->utf8 = true;
            $dump->doImport();
            ob_get_clean();

            ob_start();
            $filename = dirname(__FILE__) . '/data/user/sql/crud_languages.sql';
            $compress = false;
            $dump = new phpMyImporter($this->db->database, $connection, $filename, $compress);
            $dump->utf8 = true;
            $dump->doImport();
            ob_get_clean();
            
            ob_start();
            $filename = dirname(__FILE__) . '/data/user/sql/crud_permissions.sql';
            $compress = false;
            $dump = new phpMyImporter($this->db->database, $connection, $filename, $compress);
            $dump->utf8 = true;
            $dump->doImport();
            ob_get_clean();
            
            ob_start();
            $filename = dirname(__FILE__) . '/data/user/sql/crud_settings.sql';
            $compress = false;
            $dump = new phpMyImporter($this->db->database, $connection, $filename, $compress);
            $dump->utf8 = true;
            $dump->doImport();
            ob_get_clean();
            
            ob_start();
            $filename = dirname(__FILE__) . '/data/user/sql/crud_user_permissions.sql';
            $compress = false;
            $dump = new phpMyImporter($this->db->database, $connection, $filename, $compress);
            $dump->utf8 = true;
            $dump->doImport();
            ob_get_clean();
            
            ob_start();
            $filename = dirname(__FILE__) . '/data/user/sql/crud_users.sql';
            $compress = false;
            $dump = new phpMyImporter($this->db->database, $connection, $filename, $compress);
            $dump->utf8 = true;
            $dump->doImport();
            ob_get_clean();
            
            $oldumask = umask(0);
            recurse_copy(dirname(__FILE__) . '/data/user/config', __DATABASE_CONFIG_PATH__ . '/' . $this->db->database);
            umask($oldumask);

            // install sample data
            if ((int) $this->input->post('sample_data') == 1) {
                ob_start();
                $filename = dirname(__FILE__) . '/data/sampledata/sql/articles.sql';
                $compress = false;
                $dump = new phpMyImporter($this->db->database, $connection, $filename, $compress);
                $dump->utf8 = true;
                $dump->doImport();
                ob_get_clean();
                
                ob_start();
                $filename = dirname(__FILE__) . '/data/sampledata/sql/categories.sql';
                $compress = false;
                $dump = new phpMyImporter($this->db->database, $connection, $filename, $compress);
                $dump->utf8 = true;
                $dump->doImport();
                ob_get_clean();
                
                ob_start();
                $filename = dirname(__FILE__) . '/data/sampledata/sql/countries.sql';
                $compress = false;
                $dump = new phpMyImporter($this->db->database, $connection, $filename, $compress);
                $dump->utf8 = true;
                $dump->doImport();
                ob_get_clean();

                $oldumask = umask(0);
                recurse_copy(dirname(__FILE__) . '/data/sampledata/config', __DATABASE_CONFIG_PATH__ . '/' . $this->db->database);
                umask($oldumask);
            }

            $oldumask = umask(0);
            file_put_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/v_1.0.txt', "");
            umask($oldumask);

            $var = array();
            $var['main_content'] = $this->load->view('install/complete', $var, true);
            $this->load->view('layouts/install', $var);
        }
    }

}

