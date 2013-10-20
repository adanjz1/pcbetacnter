<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {

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
    // settings
	protected 	$sendEmailTo 	= 	'asif@pccounter.net';
	protected	$subjectLine 	= 	""; // actually set on line 39.
	
	// views
	protected 	$formView		= 	'contact';
	protected	$successView	= 	'contact_success';
	protected 	$headerView 	= 	'template/header'; //null to disable
	protected 	$footerView 	= 	'template/footer'; //null to disable

	// other
	public 		$data 			= 	array(); // used for the views


	public function index() {
            $this->load->helper('metaHelper');
            $this->load->helper(array('form', 'url'));
            $this->load->library('session');
            $data = getConstData($this);
                $this->load->model('pages');
               $seoPg = $this->pages->getSEOPage('contact');
               $seoPg = $seoPg[0];
               $data['pageTitle'] = $seoPg->Title;//Title tag
               $data['headerText'] = $seoPg->Header;//H1 tag
               $data['metaTitle'] = $seoPg->Meta_title;
               $data['metaKeywords'] = $seoPg->Meta_keywords;
               $data['metaDescription'] = $seoPg->Meta_Description;
		$this->load->helper('url');
		$this->subjectLine = "Contact form response from " . $_SERVER['HTTP_HOST'];
                
                $name = $this->input->post('name');
                $email = $this->input->post('email');
                $subject = $this->input->post('subject');
                $message = $this->input->post('message');
		if(empty($name) || empty($email) || empty($subject) || empty($message)) {
			// show the form
			$this->load->library('parser');
                        $this->parser->parse('widgets/header', $data);
                        $this->parser->parse('contact', $data);

                        $this->parser->parse('widgets/rightBar', $data);
                        $this->parser->parse('widgets/footer', $data);


		} else {
			// success! email it, assume it sent, then show contact success view.
			
			$this->load->library('email');
			$this->email->from($this->input->post('email'), $this->input->post('name'));
			$this->email->to($this->sendEmailTo);
			$this->email->subject($this->subjectLine);
			$this->email->message($this->input->post('message'));
			$this->email->send();

			$this->load->library('parser');
                        $this->parser->parse('widgets/header', $data);
                        $this->parser->parse('contact_success', $data);

                        $this->parser->parse('widgets/rightBar', $data);
                        $this->parser->parse('widgets/footer', $data);


		}
	}
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
