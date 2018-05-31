<?php
    //verify if useris already logged in
    if ($_COOKIE['username'] != 'admin') {
        echo '<p>You must be logged in as the Administrator to view this page!</p>';
        echo '<a href="login.php">Go to Login</a>';
        exit();
    } 


?>