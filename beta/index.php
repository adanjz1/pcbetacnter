<?php
include("layouts/header.php");
$time_start = microtime(true);
//include("timtim.php"); //Library to resize files, WHY IN HOMEPAGE?
?>

<div id="maincontent">
	<div class="topbox">
		<div class="topbox_1">
			<?php
                            switch($_REQUEST['msg']){
                                case "loginsuccess":
                                    ?><div style="color:#FF0000;">You have successfully logged in into our Site.</div><?
                                break;
                                case "loginerror":
                                    ?><div style="color:#FF0000;">Please provide your Login credentials correctly.</div><?
                                break;
                                case "logoutsuccess":
                                    ?><div style="color:#FF0000;">You have successfully Logged Out from the Site.</div><?
                                break;
                                case "registersuccess":
                                    ?><div style="color:#FF0000;">You have successfully Registered in our Site. Please check your email to find the Login Credentials.</div><?
                                break;
                                case "cantview":
                                    ?><div style="color:#FF0000;">You can't view this page as you are not a Registered user.</div><?
                                break;
                                case "cannotrate":
                                    ?><div style="color:#FF0000;">You can't RATE as you are not a Registered user.</div><?
                                break;
                            }
                            ?>
			<h1><?php echo $rowtitle['title_name']; ?></h1>
			<p><?php echo $rowtitle['title_desc']; ?></p>
		</div>
        
		<div class="topbox_r">

			<div id="fb-root" style="float:left;  width: 60px; margin: 0 auto 0 40px;"></div>

			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
            </script>
             
			<div class="fb-like" data-href="http://www.unifiedinfotech.net/pc_counter/" data-send="false" data-layout="button_count" data-width="100" data-show-faces="true" style="float: right; width: 81px;"></div>

			

			<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>

			<div class="g-plusone"></div>
		</div>
        
	</div>
	<div class="clear"></div>
	<div id="content">
		

		<?php
                $cols = 2;
		if(empty($_GET['view'])){	
                    include("layouts/pages/index.php");
                }else{
                    include("layouts/pages/".$_GET['view'].".php");
                    if($_GET['view'] == 'registration'){
                        $cols = 1;
                    }
                }    
                if($cols != 1){
			include("layouts/rightcol.php");
                }
		?>

	</div>
</div>
<?php
	include("layouts/footer.php");
?>