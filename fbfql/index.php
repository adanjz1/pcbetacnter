<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
<?php

#App ID:	290064754377171
#App Secret:	5a3b2a90b58a5a3260d3244f99f4bd1d

include_once "fbmain.php";

     if (!$user) { ?>
        You've to login using FB Login Button to see api calling result.
        <a href="<?=$loginUrl?>"><img src="fbconnect.png" /></a>
    <?php } else { ?>
        <a href="logout.php">Facebook Logout</a>
    <?php } ?>


