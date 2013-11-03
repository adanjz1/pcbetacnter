<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

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
           
        }
        public function twlogin(){
            require_once('/media/twitteroauth_new/twitteroauth.php');
            $CONSUMER_KEY='cChZNFj6T5R0TigYB9yd1w';
            $CONSUMER_SECRET='L8qq9PZyRg6ieKGEKhZolGC0vJWLw8iEJ88DRdyOg';
            $OAUTH_CALLBACK='http://www.pccounter.net';
            if(isset($_SESSION['name']) && isset($_SESSION['twitter_id'])) //check whether user already logged in with twitter
            {

                    echo "Name :".$_SESSION['name']."<br>";
                    echo "Twitter ID :".$_SESSION['twitter_id']."<br>";
                    echo "Image :<img src='".$_SESSION['image']."'/><br>";
                    echo "<br/><a href='logout.php'>Logout</a>";


            }
            else // Not logged in
            {

                    $connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET);
                    $request_token = $connection->getRequestToken($OAUTH_CALLBACK); //get Request Token

                    if(	$request_token)
                    {
                            $token = $request_token['oauth_token'];
                            $_SESSION['request_token'] = $token ;
                            $_SESSION['request_token_secret'] = $request_token['oauth_token_secret'];

                            switch ($connection->http_code) 
                            {
                                    case 200:
                                            $url = $connection->getAuthorizeURL($token);
                                            //redirect to Twitter .
                                    header('Location: ' . $url); 
                                        break;
                                    default:
                                        echo "Coonection with twitter Failed";
                                    break;
                            }

                    }
                    else //error receiving request token
                    {
                            echo "Error Receiving Request Token";
                    }


            }



        }
        public function like($id=0){
            $this->load->library('session');
            $this->load->model('Deal');
            $dealLikes = $this->Deal->get_dealLikes($id);
            $dealLikes = $dealLikes[0]->thumbs;
            $likes = $this->session->all_userdata();
            if(empty($likes[$id])){
                
                $this->session->set_userdata($id, true);
                $dealLikes = $dealLikes +1;
                $this->Deal->set_plusOnedeal($id,$dealLikes);
            }else{
                 
                $this->session->unset_userdata($id);
                $dealLikes = $dealLikes -1;
                $this->Deal->set_plusOnedeal($id,$dealLikes);
            }
            echo $dealLikes;
        }
}