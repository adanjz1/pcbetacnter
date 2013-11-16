<script>
    $(document).ready(function(){
        $('.contactForm').click(function(){
            if($('#name').val() != '' && $('#email').val() != '' && $('#subject').val() != '' && $('#message').val() != ''){
                $('#contact').submit();
            }else{
                alert('You must enter all the fields to contact us.');
            }
        });
    });
</script>
<div class="contactBox">
    <div class="latest_deal">
        <div class="left_top"><h1>Contact US</h1></div>
        <div class="left_mid">
            <form method="post" id="contact" action="{siteUrl}contact"> 
                <table>
                    <?php
                    echo form_label('Name: ', 'name') . ' <br/>'
                    . '<input type="text" name="name" id="name">';

                    echo form_label('Email: ', 'email') . "<br/>"
                    . '<input type="text" name="email" id="email">';

                    echo form_label('Subject: ', 'subject') . "<br/>"
                    . '<input type="text" name="subject" id="subject">';

                    echo form_label('Message: ', 'message') . "<br/>
                        <textarea name='message'  id='message'>" . set_value("message") . "</textarea>";

                    echo '<br/><br/><div class="contactForm">Submit</div>';
                    ?>
                </table>
            </form>
        </div>
        <div class="left_bot"></div>
    </div>
    <div class="clear"></div>
</div>
</div>