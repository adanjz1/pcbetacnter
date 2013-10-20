<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Routes extends CI_Controller {

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
   

	public function index() {
            $this->load->model('RoutesModel');
            $category = $this->RoutesModel->getCategoryRoutes();
            $category2 = $this->RoutesModel->getCategoryCouponRoutes();
            $subcategory = $this->RoutesModel->getSubCategoryRoutes();
            $sources = $this->RoutesModel->getSourcesRoutes();
            $spPages = $this->RoutesModel->getStaticRoutes();
            $stPages = $this->RoutesModel->getSpecialRoutes();
            
            
            foreach($category as $cat){
                $allRoutes[] = array('route' => $cat->url,
                                     'controller'=> 'categories/subcategories/',
                                     'vars'=>'/'.$cat->id);
            }
            foreach($category2 as $cat){
                $allRoutes[] = array('route' => $cat->couponCatUrl,
                                     'controller'=> 'coupons/index/',
                                     'vars'=>'/___'.$cat->id);
            }
            foreach($subcategory as $scat){
                $allRoutes[] = array('route' => $scat->url,
                                     'controller'=> 'deals/index/',
                                    'vars'=>'/category/'.$scat->idCategory.'/'.$scat->id);
            }
            foreach($sources as $s){
                $allRoutes[] = array('route' => $s->url,
                                     'controller'=> 'deals/index/',
                                    'vars'=>'/_/null/null/'.$s->deal_source_id);
            }
            
            foreach($spPages as $s){
                $allRoutes[] = array('route' => $s->url,
                                     'controller'=> 'specialPage/index/',
                                    'vars'=>'/0/'.$s->id);
            }
            
            foreach($stPages as $s){
                $allRoutes[] = array('route' => $s->url,
                                     'controller'=> 'staticPage/index/',
                                    'vars'=>'/0/'.$s->id);
            }
            
            $this->RoutesModel->cache($allRoutes);
	}
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
