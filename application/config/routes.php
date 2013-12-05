<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
include APPPATH."cache/routes.php"; 

$route['default_controller'] = "home";
$route['404_override'] = 'error';
$route['sitemap'] = 'siteMap';

$route['coupon-codes'] = 'coupons';
$route['deals-search-(:any)'] = 'deals/index/0/___$1';
$route['coupon-codes/(:num)'] = 'coupons/index/$1';
$route['deals-list'] = 'deals';
$route['Multiple-Deals'] = 'deals/index/_';
$route['deals-list/(:num)'] = 'deals/index/$1';
$route['all-stores'] = 'stores/index';
$route['all-stores/(:num)'] = 'stores/index/$1';
$route['all-stores/(:num)/(:any)'] = 'stores/index/$1/$2';
$route["categories/(:num)"] = "categories/index/$1";
$route["web-hosting-deals"] = "deals/index/0/20/20";
$route["web-hosting-deals/(:num)"] ="deals/index/$1/20/20";
$route["EST"] ="home/index/EST";
$route["PST"] ="home/index/GMT+8";//
$route["CST"] ="home/index/GMT+6";//
$route["MST"] ="home/index/MST";


/* End of file routes.php */
/* Location: ./application/config/routes.php */