<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends CI_Controller {
    function index(){
            $this->load->helper('metaHelper');
            $this->load->helper(array('form', 'url'));
            $data = getConstData($this);
            /**
             * HEADER
             */
            $data['pathLocation']='<a class="prevPath" href="/">HOME</a> > <a href="/siteMap" class="activePath">Blog</a> ';
            $data['headerText'] ='<h1>Blog</h1>';
            $this->load->library('parser');
             $this->parser->parse('widgets/header_new', $data);
             $this->parser->parse('blog_new', $data);
             $this->parser->parse('widgets/footer_new', $data);
    }
}