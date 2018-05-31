<?php
    //verify if user is already logged in
    include_once('protectAdmin.php');
    require_once('variables.php');


    $title = $_POST[title];
    $rating = $_POST[rating];
    $description = $_POST[description];
    $movieID = $_POST[movieID];
    
    $description = addslashes($description);


    //BUILD CONNECTION TO DB - localhost means it's on the same server
    $databaseConnect = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME) or die('Could not connect to Database');


    //BUILD THE QUERY - MATCHES FIELDS IN DB
    $query = "UPDATE final_movies SET title='$title', rating='$rating', description='$description' WHERE movie_id=$movieID";

    //WORK WITH THE DB
    $result = mysqli_query($databaseConnect, $query) or die('Query failed!');

    //CLOSE CONNECTION
    mysqli_close($databaseConnect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Movie Confirmation</title>

    <!--BOOTSTRAP PLUGIN-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

    <!--STYLING-->
    <link href="css/main.css" rel="stylesheet" type="text/css">

    <!--GOOGLE FONT-->
    <link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">
</head>


<body>

<div class="container">
    <header>
        <h1>Rebuild of ok.com - Update Movie</h1>
        <?php //Adding in the nav bar
            include_once('navbar.php');
        ?>
    </header>

    <form method="POST" action="addMovie2.php" enctype="multipart/form-data" name="01form">
    <fieldset>
        <div class="row">
        <div class="col col-12 offset-md-2 col-md-8">


    <?php
        require_once('variables.php');

        $feedback = '<p class="feedback">Welcome, '.$_COOKIE['username'].' | <a href="signout.php" >Sign Out</a></p>';

        echo $feedback;
    ?>

    
        <?php 
            echo '<h2>Your Movie, '.$title.' (Rated '.$rating.'), Has Been Updated</h2>'; 
            echo '<a href="update.php?id='.$movieID.'">Back to '.$title.'</a>';

        ?>
                       
        </div>
        </div>
            
    </fieldset>
    </form>

    <?php //Adding in the nav bar
        //include_once('navbar.php');
    ?>


    <main>


    </main>
</div>

</body>
</html>