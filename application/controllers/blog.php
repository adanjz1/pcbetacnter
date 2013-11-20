<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends CI_Controller {
    function index(){
            $this->load->helper('metaHelper');
            $this->load->helper(array('form', 'url'));
            $data = getConstData($this);
            /**
             * HEADER
             */
            $data['pageTitle'] = "Blog pccounter.net";//Title tag
            $data['metaTitle'] = "Blog, great deals";
            $data['metaKeywords'] = "blog,deals,pccounter";
            $data['metaDescription'] = "In this blog you will see the lastest deals notices";
            $data['pathLocation']='<a class="prevPath" href="/">HOME</a> > <a href="/siteMap" class="activePath">Blog</a> ';
            $data['headerText'] ='<h1>Blog</h1>';
            $this->load->library('parser');
             $this->parser->parse('widgets/header_new', $data);
             $this->parser->parse('blog_new', $data);
             $this->parser->parse('widgets/footer_new', $data);
    }
}