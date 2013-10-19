<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<div class="leftcol">
    <div class="latest_deal">
        <div class="left_top"><h1>Contact US</h1></div>
        <div class="left_mid">
<?

	echo form_open(current_url()); 

?>

<table>
<?php

	echo  form_label('Name: ', 'name').' <br/>'
            . form_input('name', set_value('name'));
	
        echo  form_label('Email: ', 'email') . "<br/>"
            . form_input('email', set_value('email'));

	echo form_label('Subject: ', 'subject'). "<br/>"
             . form_input('subject', set_value('subject'));

	echo form_label('Message: ', 'message'). "<br/>
             <textarea name='message'>" . set_value("message") . "</textarea>";
	
	echo '<br/><br/><input type="submit" name="Submit2" class="search_btn1" value=""/>';

?>
</table>

<?
	echo form_close();
?>
        </div>
        <div class="left_bot"></div>
    </div>
    <div class="clear"></div>
</div>