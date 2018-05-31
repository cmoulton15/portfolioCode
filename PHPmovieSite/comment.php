<?php
    //verify if user is already logged in
    require_once('variables.php');


    $comment = $_POST[comment];
    $starRating = $_POST[starRating];
    $user = $_POST[user];
    $movieID = $_POST[movieID];

    $comment = addslashes($comment);

    //BUILD CONNECTION TO DB - localhost means it's on the same server
    $databaseConnect = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME) or die('Could not connect to Database');


    //BUILD THE QUERY - MATCHES FIELDS IN DB
    $query = "INSERT INTO final_reviews(user, userRating, comment, movie_id) ".

    "VALUES ('$user', '$starRating', '$comment', '$movieID')"; //no ID because it will auto increment in the DB


    //WORK WITH THE DB
    $result = mysqli_query($databaseConnect, $query) or die('Query failed!');

    //CLOSE CONNECTION
    mysqli_close($databaseConnect);

    $movieID = (string)$movieID;

    header('Location: viewDetails.php?id='.$movieID);


?>
