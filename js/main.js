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