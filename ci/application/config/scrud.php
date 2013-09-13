<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$config['codeigniter_admin_pro_version'] = '1.0';

$sysUser = array();
$sysUser['name'] = "systemAdmin";
$sysUser['password'] = "123456";
$sysUser['enable'] = false;

$config['sysUser'] = $sysUser;

define('__DATABASE_CONFIG_PATH__', FCPATH.'application/config/database');
define('__IMAGE_UPLOAD_REAL_PATH__', FCPATH.'media/images/');
define('__FILE_UPLOAD_REAL_PATH__', FCPATH.'media/files/');

$CI =& get_instance();
define('__MEDIA_PATH__', $CI->config->base_url('') .'/media/');

$config['imageExtensions'] = array(".png", ".jpg", ".gif");
$config['fileExtensions'] = array(".png", ".jpg", ".gif",".doc",".docx",".xls",".xlsx",".zip",".rar",".7z");

define('__HTML_CHARSET__','utf-8');


global $date_format_convert;
$date_format_convert = array();

$date_format_convert['MM/dd/yyyy'] = 'm/d/Y';
$date_format_convert['dd/MM/yyyy'] = 'd/m/Y';
$date_format_convert['MM-dd-yyyy'] = 'm-d-Y';
$date_format_convert['dd-MM-yyyy'] = 'd-m-Y';

define('__DATE_FORMAT__', 'MM/dd/yyyy'); // MM/dd/yyyy | dd/MM/yyyy | MM-dd-yyyy | dd-MM-yyyy



