<?php
    //verify if user is already logged in
    include_once('protectAdmin.php');
    require_once('variables.php');


    $title = $_POST[title];
    $rating = $_POST[rating];
    $description = $_POST[description];

    $title = addslashes($title);
    $rating = addslashes($rating);
    $description = addslashes($description);

    //make photo path
    $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);

    $filename = time().'.'.$ext; //adds in server time so no overwrites occur
    $filepath = 'moviepics/';

    //VALIDATE TO SEE IF AN IMAGE HAS BEEN UPLOADED
    $validImage = true;

    if ($_FILES['photo']['size'] == 0) {
        echo "An image must be uploaded!";
        $validImage = false;
    }

    //MAKE SURE IMAGE ISN"T TOO LARGE > 150 KB (1024 bytes per KB)
    if ($_FILES['photo']['size'] > 153600) {
        echo "Image is over the 150 KB size limit!";
        $validImage = false;
    }

    //CHECKING FILE TYPE
    if ($_FILES['photo']['type'] == 'image/gif' || 
        $_FILES['photo']['type'] == 'image/jpeg' ||
        $_FILES['photo']['type'] == 'image/pjpeg' ||
        $_FILES['photo']['type'] == 'image/png'){

        //should be the correct format    
    } else {
        echo "You have uploaded a photo that is not the right format!";
        $validImage = false;      
    }




    //UPLOAD THE FILES AFTER VALIDATION
    if ($validImage == true) {
        //upload code
        $tmp_name = $_FILES['photo']['tmp_name'];
        move_uploaded_file($tmp_name, "$filepath$filename");
        @unlink($_FILES['photo']['tmp_name']); //empties this temp file from the server



        //BUILD CONNECTION TO DB - localhost means it's on the same server
        $databaseConnect = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME) or die('Could not connect to Database');

        echo $title;
        echo $rating;
        echo $description;
        echo $filename;


        //BUILD THE QUERY - MATCHES FIELDS IN DB
        $query = "INSERT INTO final_movies(title, rating, description, photo) ".

        "VALUES ('$title', '$rating', '$description', '$filename')"; //no ID because it will auto increment in the DB

        echo $query;

        //WORK WITH THE DB
        $result = mysqli_query($databaseConnect, $query) or die('Query failed!');

        //CLOSE CONNECTION
        mysqli_close($databaseConnect);

    } else {
        //redirect the user to try again
        echo '<br><a href="addMovie.php">Please try to upload a file that meets the requirements.</a>';
        exit(); 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Form</title>

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
        <h1>Rebuild of ok.com - Add Movie</h1>
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
            echo '<h2>Your Movie, '.$title.' (Rated '.$rating.'), Has Been Added</h2>'; 
        ?>
                       
            


            <a href="addMovie.php">Add Another Movie</a><br>
            <a href="index.php">Back to Movie Listings</a>

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