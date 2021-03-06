<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    public function __construct()
       {
        parent::__construct();
       }
	public function index($limit = ''){
            /**
             * Common
             */
            $this->load->helper('metaHelper');
            $this->load->helper(array('form', 'url'));
            $data = getConstData($this);
            /**
             * HEADER
             */
            $data['categoriesPaginatorUrl'] = $this->config->item('base_url').$this->config->item('index_page').'/categories/paginator';
            $this->load->model('pages');
            $seoPg = $this->pages->getSEOPage('categories');
            $seoPg = $seoPg[0];
            $data['pageTitle'] = $seoPg->Title;//Title tag
            $data['headerText'] = $seoPg->Header;//H1 tag
            $data['metaTitle'] = $seoPg->Meta_title;
            $data['metaKeywords'] = $seoPg->Meta_keywords;
            $data['metaDescription'] = $seoPg->Meta_Description;
           
            
            /***********************************/
             /**
             * Categories
             */
                $this->load->model('Category');
                $categ_list = $this->Category->get_categories(12,$limit);
                foreach ($categ_list as $categ){
                    if(empty($categ->url)){
                        $categ->subCategoryUrl = $this->config->item('base_url').$this->config->item('index_page').'/categories/subcategories/0/'.$categ->id;
                        $categ->dealCategoryUrl = $this->config->item('base_url').$this->config->item('index_page').'/categories/subcategories/0/'.$categ->id;
                    }else{
                        $categ->subCategoryUrl = $this->config->item('base_url').$this->config->item('index_page').$categ->url;
                        $categ->dealCategoryUrl = $this->config->item('base_url').$this->config->item('index_page').$categ->url;
                    }
                    if(empty($categ->image)){
                        $categ->image = 'http://pccounter.net/media/images/noImage.jpg';
                    }
                }
                $data['categories'] = $categ_list;
                
                $this->load->library('pagination');
                $config['base_url'] = $this->config->item('base_url').$this->config->item('index_page').'categories';
                $config['total_rows'] = $this->Category->get_totalCategories();
                $config['per_page'] = 12; 
                $config['uri_segment'] = 2;
                $this->pagination->initialize($config); 
                $data['paginator'] = $this->pagination->create_links();
            /*****************/
                
                $data['catHeader'] = 'All Category';
                
                $data['noCategories'] =  ((count($data['categories'])==0)?'<div class="pro_box">
                                                        <span style="color:#FF0000;">NO CATEGORIES ARE THERE.</span>
                                                 </div>':'');
                 /**
               * Footer
               */
              /**********************************************/
                $this->load->library('parser');
                $this->parser->parse('widgets/header', $data);
                $this->parser->parse('categories', $data);
                
                $this->parser->parse('widgets/rightBar', $data);
                $this->parser->parse('widgets/footer', $data);
        }
	public function subcategories($limit = '',$cat){
            /**
             * Common
             */
            $this->load->helper('metaHelper');
            $this->load->helper(array('form', 'url'));
            $data = getConstData($this);
            /**
             * HEADER
             */
            $data['SubcategoriesPaginatorUrl'] = $this->config->item('base_url').$this->config->item('index_page').'/categories/paginator';
            $this->load->model('pages');
            $seoPg = $this->pages->getSEOPage('subcategories');
            $seoPg = $seoPg[0];
            $data['pageTitle'] = $seoPg->Title;//Title tag
            $data['headerText'] = $seoPg->Header;//H1 tag
            $data['metaTitle'] = $seoPg->Meta_title;
            $data['metaKeywords'] = $seoPg->Meta_keywords;
            $data['metaDescription'] = $seoPg->Meta_Description;
           
            
            /***********************************/
             /**
             * Categories
             */
                $this->load->model('Category');
                $categ_list = $this->Category->get_Subcategories(12,$limit,$cat);
                foreach ($categ_list as $categ){
                    if(empty($categ->url)){
                        $categ->subCategoryUrl = $this->config->item('base_url').$this->config->item('index_page').'/deals/index/0/category/'.$cat.'/'.$categ->id;
                        $categ->dealCategoryUrl = $this->config->item('base_url').$this->config->item('index_page').'/deals/index/0/category/'.$cat.'/'.$categ->id;
                    }else{
                        $categ->subCategoryUrl = $this->config->item('base_url').$this->config->item('index_page').$categ->url;
                        $categ->dealCategoryUrl = $this->config->item('base_url').$this->config->item('index_page').$categ->url;
                    }
                    if(empty($categ->image)){
                        $categ->image = 'http://pccounter.net/media/images/noImage.jpg';
                    }
                }
                $data['categories'] = $categ_list;
                
                $this->load->library('pagination');
                $config['base_url'] = $this->config->item('base_url').$this->config->item('index_page').'/categories/';
                $config['total_rows'] = $this->Category->get_totalSubCategories($cat);
                $config['per_page'] = 12; 
                $this->pagination->initialize($config); 
                $data['paginator'] = $this->pagination->create_links();
            /*****************/
                
                $data['catHeader'] = 'All Category';
                
                $data['noCategories'] =  ((count($data['categories'])==0)?'<div class="pro_box">
                                                        <span style="color:#FF0000;">NO CATEGORIES ARE THERE.</span>
                                                 </div>':'');
                 /**
               * Footer
               */
              /**********************************************/
                $this->load->library('parser');
                $this->parser->parse('widgets/header', $data);
                $this->parser->parse('categories', $data);
                
                $this->parser->parse('widgets/rightBar', $data);
                $this->parser->parse('widgets/footer', $data);
        }
}