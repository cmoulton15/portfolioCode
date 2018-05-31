<?php
    //verify if useris already logged in
    if (!isset($_COOKIE['username'])) {
        echo '<p>You must be logged in to view this page!</p>';
        echo '<a href="login.php">Go to Login</a>';
        exit();
    } 


?>