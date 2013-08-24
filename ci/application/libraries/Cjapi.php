<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @author  Michael Pauley
 * @copyright Copyright (c) 2011, MP5, Inc.
 * @link  http://mdpauley.com
 * @since  Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Cjapi Class
 *
 * Searches Commision Junction Products, Links and Advertisers via SOAP API
 *
 * @package  CodeIgniter
 * @subpackage Libraries
 * @category Libraries
 * @author  Michael Pauley
 * @link  http://mdpauley.com
 */
class Cjapi {

	/**
	 * Constructor
	 *
	 * @access public
	 */
	function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->config->load('cjapi');
		$this->ini = ini_set("soap.wsdl_cache_enabled","0");

		log_message('debug', "Cjapi Class Initialized");
	}

	// --------------------------------------------------------------------

	/**
	 * Product Catalog Search
	 *
	 * @access public
	 * @param array
	 * @return array
	 */
	function products_catalog_search ($data = array())
	{
		/* See http://help.cj.com/en/web_services/web_services.htm#product_catalog_search_service_rest.htm */
//		$client = new SoapClient("https://product-search.api.cj.com/v2/product-search?",
//			array('trace'=> true));
		$client = new SoapClient("https://product.api.cj.com/wsdl/version2/productSearchServiceV2.wsdl",
			array('trace'=> true));

		$data = array_merge($this->ci->config->item('cjapi'), $data);
		
		$results = $client->search($data);

		return $results;
	}

	// --------------------------------------------------------------------

	/**
	 * Link Search Service
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function link_search_service($data = array())
	{
		/* See http://help.cj.com/en/web_services/web_services.htm#product_catalog_search_service_rest.htm */
		$client = new SoapClient("https://linksearch.api.cj.com/wsdl/version2/linkSearchServiceV2.wsdl",
			array('trace'=> true));

		$data = array_merge($this->ci->config->item('cjapi'), $data);
		
		$results = $client->searchLinks($data);

		return $results;
	}

	// --------------------------------------------------------------------

	/**
	 * Advertiser Search
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function advertiser_search($data = array())
	{
		/* http://help.cj.com/en/web_services/web_services.htm#product_catalog_search_service_rest.htm */
		$client = new SoapClient("https://linksearch.api.cj.com/wsdl/version2/advertiserSearchServiceV2.wsdl",
			array('trace'=> true));

		$data = array_merge($this->ci->config->item('cjapi'), $data);

		$results = $client->search($data);
		
		return $results;
	}
}
