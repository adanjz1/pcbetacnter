<?php
	error_reporting(0);
	ini_set('default_charset', 'charset=iso-8859-1');
	ob_start();
	session_start();
	require("config.inc.php");
	require("class/Database.class.php");
	require("class/pagination.class.php");
	require("includes/functions.php");
	include "fbmain.php";
	//require("twitter/twitteroauth.php");
	//require 'config/twconfig.php';
	require("class/SimpleLargeXMLParser.class.php");
	require("includes/pagination.php");
	ini_set("display_errors","0");
	
	
	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);			
	$db->connect();
	
	$page = basename($_SERVER['REQUEST_URI']);
	
	function wrptxt($strtouse,$len) 
	{
		if(strlen($strtouse)>$len)
		{
			$strtouse=substr($strtouse, 0,$len);
			
			if(substr($strtouse,-1)!=" ")
				$strtouse=substr($strtouse, 0,strrpos($strtouse, " "))." ... ";
			else 
			   $strtouse=$strtouse." ....";
			return $strtouse;
		}
		else 
		return $strtouse;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Welcome to our site</title>
<link href="css/style.css" rel="stylesheet" type="text/css"/>

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>

<script type="text/javascript" language="javascript">

	$(document).ready(function() {	

	//select all the a tag with name equal to modal
		$('a[name=modal]').click(function(e) {
		//Cancel the link behavior
		e.preventDefault();
		
		//Get the A tag
		var tid = $(this).attr('href');
		
		var arr = tid.split("?");
		var id = arr[0];
		
		var pid = arr[1];
		
		var price  = $("#price_"+pid).val();
		var name  = $("#name_"+pid).val();
		$("#pop_id").val(pid);
		$("#pop_price").val(price);
		$("#pop_pname").val(name);

		//Get the screen height and width
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
	
		//Set heigth and width to mask to fill up the whole screen
		$('#mask').css({'width':maskWidth,'height':maskHeight});
		
		//transition effect		
		$('#mask').fadeIn(1000);	
		$('#mask').fadeTo("slow",0.8);	
	
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();
              
		//Set the popup window to center
		$(id).css('top',  winH/2-$(id).height()/2);
		$(id).css('left', winW/2-$(id).width()/2);
	
		//transition effect
		$(id).fadeIn(2000); 
	
	});
	
	//if close button is clicked
	$('.window .close').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		
		$('#mask').hide();
		$('.window').hide();
	});		
	
	//if mask is clicked
	$('#mask').click(function () {
		$(this).show();
		$('.window').show();
	});			
	
});

</script>
<style>
	iframe{
		width: 100px !important;
		height: auto;
	}				
 </style>
<script language="javascript" type="text/javascript">
	function checklogin()
	{
		if(document.loginform.login_email.value.search(/\S/) == -1)
		{
			document.getElementById("err_login_email").innerHTML="Please enter your valid Email";
			document.loginform.login_email.value="";
			document.loginform.login_email.focus();
			return false;
		}
		else
		{
			document.getElementById("err_login_email").innerHTML="";
		}
		
		var x = document.loginform.login_email.value;
	    var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	   
	    if (!filter.test(x))
	    { 
			document.getElementById("err_login_email").innerHTML="Please enter valid Email-ID";
			document.loginform.login_email.value="";
			document.loginform.login_email.focus();
			return false;
	    }
		else
		{
			document.getElementById("err_login_email").innerHTML="";
		}
		
		if(document.loginform.login_password.value.search(/\S/) == -1)
		{
			document.getElementById("err_login_password").innerHTML="Please enter your valid Password";
			document.loginform.login_password.value="";
			document.loginform.login_password.focus();
			return false;
		}
		else
		{
			document.getElementById("err_login_password").innerHTML="";
		}
		
	return true;
	}
</script>

<style type="text/css">
	#mask {
	  position:absolute;
	  left:0;
	  top:0;
	  z-index:9000;
	  background-color:#fff;
	  display:none;
	}
	  
	#boxes .window {
	  position:absolute;
	  left:0;
	  top:0;
	  width:440px;
	  height:200px;
	  display:none;
	  z-index:9999;
	  }
	
	#boxes #dialog {
	  width:400px; 
	  height:400px;
	  margin-top:255px;
	  padding:10px;
	  border-radius: 14px;
	  -moz-box-shadow:  1px 1px 6px 6px #c5c5c5;
	  -webkit-box-shadow: 1px 1px 6px 6px #c5c5c5;
	  box-shadow: 1px 1px 6px 6px #c5c5c5;
	  border:1px solid #000000;
	  background-color:#fff;
	}
	
	#boxes #dialog1 {
	  width:375px; 
	  height:203px;
	}
	
	#dialog1 .d-header {
	  background:url(images/login-header.png) no-repeat 0 0 transparent; 
	  width:375px; 
	  height:150px;
	}
	
	#dialog1 .d-header input {
	  position:relative;
	  top:60px;
	  left:100px;
	  border:3px solid #cccccc;
	  height:22px;
	  width:200px;
	  font-size:15px;
	  padding:5px;
	  margin-top:4px;
	}
	
	#dialog1 .d-blank {
	  float:left;
	  background:url(images/login-blank.png) no-repeat 0 0 transparent; 
	  width:267px; 
	  height:53px;
	}
	
	#dialog1 .d-login {
	  float:left;
	  width:108px; 
	  height:53px;
	}
	
	#boxes #dialog2 {
	  background:url(images/notice.png) no-repeat 0 0 transparent; 
	  width:326px; 
	  height:229px;
	  padding:50px 0 20px 25px;
	}
	.textstyle{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:14px;
	font-color:#888888;
	}
	
	table.dialogbox{
		width: 100%;
		height: auto;
		float: left;
		margin: 0 auto;
	}
	table.dialogbox td{
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:12px;
		font-color:#000;
		text-align: left;
		padding: 4px;
		vertical-align: middle;
	}
	table.dialogbox h1{
		font: bold 18px/20px Arial, Helvetica, sans-serif;	
		color:#639adf;
		text-align: center;
		vertical-align: middle;
	}
	
	table.dialogbox  a{
		font-family: Arial, Helvetica, sans-serif;
		font-size:11px;
		color:#264687;
		text-align: left;
		text-decoration: underline;
		padding: 4px;
		vertical-align: middle;
	}
	table.dialogbox a:hover{
		font-family: Arial, Helvetica, sans-serif;
		font-size:11px;
		color:#264687;
		text-align: left;
		text-decoration: none;
		padding: 4px;
		vertical-align: middle;
	}
</style>

<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>

<script language="javascript" type="text/javascript">
	function productcheck()
	{
		if(document.productsearch.Search_for.value.search(/\S/) == -1)
		{
			document.getElementById("err_productsearch").innerHTML="Please enter something atleast to get a related Search Result.";
			document.productsearch.Search_for.value="";
			document.productsearch.Search_for.focus();
			return false;
		}
		else
		{
			document.getElementById("err_productsearch").innerHTML="";
		}
	}
</script>

<script type="text/javascript" src="<?php echo SITE_URL; ?>js/code.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL; ?>js/jquery.js"></script>
<script type="text/javascript">

  $(document).ready(function() {
        
        //options( 1 - ON , 0 - OFF)
        var auto_slide = 1;
            var hover_pause = 1;
        var key_slide = 1;
        
        //speed of auto slide(
        var auto_slide_seconds = 5000;
        /* IMPORTANT: i know the variable is called ...seconds but it's 
        in milliseconds ( multiplied with 1000) '*/
        
        /*move he last list item before the first item. The purpose of this is 
        if the user clicks to slide left he will be able to see the last item.*/
        $('#carousel_ul li:first').before($('#carousel_ul li:last')); 
        
        //check if auto sliding is enabled
        if(auto_slide == 1){
            /*set the interval (loop) to call function slide with option 'right' 
            and set the interval time to the variable we declared previously */
            var timer = setInterval('slide("right")', auto_slide_seconds); 
            
            /*and change the value of our hidden field that hold info about
            the interval, setting it to the number of milliseconds we declared previously*/
            $('#hidden_auto_slide_seconds').val(auto_slide_seconds);
        }
  
        //check if hover pause is enabled
        if(hover_pause == 1){
            //when hovered over the list 
            $('#carousel_ul').hover(function(){
                //stop the interval
                clearInterval(timer)
            },function(){
                //and when mouseout start it again
                timer = setInterval('slide("right")', auto_slide_seconds); 
            });
  
        }
  
        //check if key sliding is enabled
        if(key_slide == 1){
            
            //binding keypress function
            $(document).bind('keypress', function(e) {
                //keyCode for left arrow is 37 and for right it's 39 '
                if(e.keyCode==37){
                        //initialize the slide to left function
                        slide('left');
                }else if(e.keyCode==39){
                        //initialize the slide to right function
                        slide('right');
                }
            });

        }
        
        
  });

//FUNCTIONS BELLOW

//slide function  
function slide(where){
    
            //get the item width
            var item_width = $('#carousel_ul li').outerWidth() + 10;
            
            /* using a if statement and the where variable check 
            we will check where the user wants to slide (left or right)*/
            if(where == 'left'){
                //...calculating the new left indent of the unordered list (ul) for left sliding
                var left_indent = parseInt($('#carousel_ul').css('left')) + item_width;
            }else{
                //...calculating the new left indent of the unordered list (ul) for right sliding
                var left_indent = parseInt($('#carousel_ul').css('left')) - item_width;
            
            }
            
            //make the sliding effect using jQuery's animate function... '
            $('#carousel_ul:not(:animated)').animate({'left' : left_indent},500,function(){    
                
                /* when the animation finishes use the if statement again, and make an ilussion
                of infinity by changing place of last or first item*/
                if(where == 'left'){
                    //...and if it slided to left we put the last item before the first item
                    $('#carousel_ul li:first').before($('#carousel_ul li:last'));
                }else{
                    //...and if it slided to right we put the first item after the last item
                    $('#carousel_ul li:last').after($('#carousel_ul li:first')); 
                }
                
                //...and then just get back the default left indent
                $('#carousel_ul').css({'left' : '-210px'});
            });
            
}
  
</script>

<script type="text/javascript">

  $(document).ready(function() {
        
        //options( 1 - ON , 0 - OFF)
        var auto_slide = 1;
            var hover_pause = 1;
        var key_slide = 1;
        
        //speed of auto slide(
        var auto_slide_seconds = 5000;
        /* IMPORTANT: i know the variable is called ...seconds but it's 
        in milliseconds ( multiplied with 1000) '*/
        
        /*move he last list item before the first item. The purpose of this is 
        if the user clicks to slide left he will be able to see the last item.*/
        $('#carousel_ul li:first').before($('#carousel_ul li:last')); 
        
        //check if auto sliding is enabled
        if(auto_slide == 1){
            /*set the interval (loop) to call function slide with option 'right' 
            and set the interval time to the variable we declared previously */
            var timer = setInterval('slide("right")', auto_slide_seconds); 
            
            /*and change the value of our hidden field that hold info about
            the interval, setting it to the number of milliseconds we declared previously*/
            $('#hidden_auto_slide_seconds').val(auto_slide_seconds);
        }
  
        //check if hover pause is enabled
        if(hover_pause == 1){
            //when hovered over the list 
            $('#carousel_ul').hover(function(){
                //stop the interval
                clearInterval(timer)
            },function(){
                //and when mouseout start it again
                timer = setInterval('slide("right")', auto_slide_seconds); 
            });
  
        }
  
        //check if key sliding is enabled
        if(key_slide == 1){
            
            //binding keypress function
            $(document).bind('keypress', function(e) {
                //keyCode for left arrow is 37 and for right it's 39 '
                if(e.keyCode==37){
                        //initialize the slide to left function
                        slide('left');
                }else if(e.keyCode==39){
                        //initialize the slide to right function
                        slide('right');
                }
            });

        } 
        
        
  });

//FUNCTIONS BELLOW

//slide function  
function slide(where){
    
            //get the item width
            var item_width = $('#carousel_ul li').outerWidth() + 10;
            
            /* using a if statement and the where variable check 
            we will check where the user wants to slide (left or right)*/
            if(where == 'left'){
                //...calculating the new left indent of the unordered list (ul) for left sliding
                var left_indent = parseInt($('#carousel_ul').css('left')) + item_width;
            }else{
                //...calculating the new left indent of the unordered list (ul) for right sliding
                var left_indent = parseInt($('#carousel_ul').css('left')) - item_width;
            
            }
            
            //make the sliding effect using jQuery's animate function... '
            $('#carousel_ul:not(:animated)').animate({'left' : left_indent},500,function(){    
                
                /* when the animation finishes use the if statement again, and make an ilussion
                of infinity by changing place of last or first item*/
                if(where == 'left'){
                    //...and if it slided to left we put the last item before the first item
                    $('#carousel_ul li:first').before($('#carousel_ul li:last'));
                }else{
                    //...and if it slided to right we put the first item after the last item
                    $('#carousel_ul li:last').after($('#carousel_ul li:first')); 
                }
                
                //...and then just get back the default left indent
                $('#carousel_ul').css({'left' : '-0px'});
            });
            
}
  
</script>    

<script type="text/javascript" src="<?php echo SITE_URL; ?>js/code.js"></script> 

</head>
<body>
<div id="maindiv">
	<div id="header">
		<div class="header_left">
			<a href="<?php echo SITE_URL; ?>">
				<img src="images/logo.png" alt="" width="360" height="48" border="0"/>
			</a>
		</div>
				
		<!--PRODUCT SEARCH STARTS-->
		
			<div class="header_right">
				<div class="search_box">
					<ul style="margin: 10px 0 0 12px;">
						<form name="productsearch" method="get" action="<?php echo SITE_URL; ?>productsearch.php" onsubmit="return productcheck();">
							<li class="search_bg">
								<input type="text" name="Search_for" placeholder="Search Pccounter.net for over 4,500 stores" class="search_field"/><br />
								<span style="color:#FF0000;" id="err_productsearch"></span>
							</li>
							<li>
								<input type="submit" class="search_btn" name="Submit" value="GO"/>
							</li>
						</form>
					</ul>
				</div>
			</div>
		
		<!--PRODUCT SEARCH ENDS-->
		
		<div class="clear"></div>
		<div id="navigation_bg">
			<div id="nav">
				<ul>
					<li>
						<a href="<?php echo SITE_URL; ?>deal.php">
							<img src="images/tag1.png" alt="" width="16" height="23" border="0"/> Deals
						</a>
					</li>
					<li>
						<a href="<?php echo SITE_URL; ?>coupon.php">
							<img src="images/tag2.png" alt="" width="20" height="18" border="0"/> Coupon Codes
						</a>
					</li>
					<li>
						<a href="<?php echo SITE_URL; ?>category.php">
							<img src="images/tag3.png" alt="" width="16" height="15" border="0"/> Categories
						</a>
					</li>
					<li>
						<a href="<?php echo SITE_URL; ?>store_brand.php">
							<img src="images/tag4.png" alt="" width="16" height="16" border="0"/> Stores
						</a>
					</li>
				</ul>
			</div>
			<div class="sighin_box">
				<ul>
					<?php
						if($_SESSION['userid'] == '')
						{
					?>
						<li>
								<a href="<?php echo SITE_URL;?>registration.php">Register</a>
						</li>
						<li>
								<a href="#dialog" name="modal">Sign in</a>
						</li>
						<li>
							<?php if (!$user) { ?>
								<a href="<?php echo $loginUrl; ?>" >
									<img src="images/signin.png" alt="" width="73" height="44" border="0"/>
								</a>
							<?php } else { ?>
								<form name="logout" style="padding:0px; margin:0px; float:none;" method="post" action="<?php echo SITE_URL; ?>password.php">
									<input type="hidden" name="mode" value="logout" />
									<input type="submit" value="Log Out" name="logout" />
								</form>
							<?php } ?>
						</li>
						<?php
							if (array_key_exists("login", $_GET)) 
							{
								$oauth_provider = $_GET['oauth_provider'];
								if ($oauth_provider == 'twitter') 
									{
										header("location: login-twitter.php");
									}
							}
						?>
							<li style="background:none;">
								<a href="?login&oauth_provider=twitter">
									<img src="images/signin1.png" alt="" width="73" height="44" border="0"/>
								</a>
							</li>
						<?php
							}
							else
							{
						?>	
								<li style="float:right; background:none; padding:8px 10px 0 10px;">
								<form name="logout" style="padding:0px; margin:0px; float:none;" method="post" action="<?php echo SITE_URL; ?>password.php">
									<input type="hidden" name="mode" value="logout" />
									<input type="submit" value="Log Out" name="logout" />
								</form>
								</li>
								<li style="float:right;">
									<a href="<?php echo SITE_URL; ?>user_account.php">
										My Account
									</a>
								</li>
						<?php
							}
						?>
				</ul>
			</div>
		</div>
	</div>
	<div class="clear"></div>