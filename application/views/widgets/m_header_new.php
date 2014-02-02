<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <title>
            {pageTitle}
        </title>
        <link rel="shortcut icon" href="media/images/new/favicon.ico" />
        <meta name="Title" content="{metaTitle}">
        <meta name="keywords" content="{metaKeywords}"/>
        <meta name="description" content="{metaDescription}"/>
        <link href="{siteUrlMedia}media/css/m_style_new.css" rel="stylesheet" type="text/css"/>
        <meta http-equiv="Cache-control" content="public">
        <meta http-equiv="content-language" content="en-US"></meta>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"></meta>
        <meta http-equiv="set-cookie" content="w3scookie=myContent;expires=Fri, 30 Dec 2020 12:00:00 GMT; path=http://www.w3schools.com">
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>        
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css" rel="stylesheet">
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
    </head>
    <body>
 <script type='text/javascript'>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-43197448-2', 'pccounter.net');
  ga('send', 'pageview');

</script>


<script type="text/javascript">
    function acomodar(){
            console.log('asdasd');
        $('.subcat').css('top',$('.leftCatBar').position().top);
        $('.subcat').css('left',$('.leftCatBar').width());
        $('.subcat').css('height',$('.leftCatBar').height());
    }
    $(document).ready(function(){
            $('.unchecked').click(function(){
            $(this).removeClass('unchecked');
            $(this).addClass('checked');
        });
        $('.checked').click(function(){
            $(this).removeClass('checked');
            $(this).addClass('unchecked');
        });
        $('.closeLogin').click(function(){
            $('.loginDiv').hide();
            $('.overlay').hide();
        });
        $('.createLogin').click(function(){
            $('.loginDiv').show();
            $('.overlay').show();
        });
        setInterval(acomodar, 1000);

        $('.subcat').css('top',$('.leftCatBar').position().top);
        $('.subcat').css('left',$('.leftCatBar').width());
        $('.subcat').css('height',$('.leftCatBar').height());
        $('.dealsbtn').click(function(){
            $(this).addClass('selected');
            $('.couponsbtn').removeClass('selected');
            $('.deals').show();
            $('.coupons').hide();
        });
        $('.couponsbtn').click(function(){
            $(this).addClass('selected');
            $('.dealsbtn').removeClass('selected');
            $('.deals').hide();
            $('.coupons').show();
        });
    });
    
    
</script>
<div class="topHeader">
<div class="centerScreen">
    <div class="logo" onclick="document.location='/'">
        <img src="{siteUrlMedia}media/images/new/logo.png" alt="" border="0"/>
    </div>
</div>    
    