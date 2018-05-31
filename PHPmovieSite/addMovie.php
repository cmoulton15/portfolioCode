<?php
    //verify if useris already logged in
    include_once('protectAdmin.php');


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

    <?php
        require_once('variables.php');

        $feedback = '<p class="feedback">Welcome, '.$_COOKIE['username'].' | <a href="signout.php" >Sign Out</a></p>';

        echo $feedback;
    ?>

        <div class="row">
        <div class="col col-12 offset-md-2 col-md-8">
        <h2>Add New Movie</h2>
                       
            
            <!--START MOVIE FORM ADDING INFO-->
            <label><p>Movie Title:<input name="title" type="text" pattern="[a-zA-Z0-9 .]{2,99}" required></p></label>

            <label><p>Rating (G, PG, PG-13, R, MA):
                <select name="rating">
                  <option value="G">G</option>
                  <option value="PG">PG</option>
                  <option value="PG-13">PG-13</option>
                  <option value="R">R</option>
                  <option value="MA">MA</option>
                </select>
                </p>
            </label><br>
            <!--<input name="rating" type="number" min="1" max="5"  required> </label>-->

            <label>Description (under 255 characters):</label><textarea name="description" type="text" rows="5"></textarea>
            <br>
            <h2>Upload a Picture:</h2>
            <input type="file" name="photo">
            <p>*File must be a 300px wide by 200px tall in order to upload.<br>
            *File must be a .jpg format.<br>
            *File must be under 150kb in size.</p>
            <!--END MOVIE FORM ADDING INFO-->

            <input class="submit" type="submit" value="Submit" name="submit">

            <br>
            <a href="index.php">Go Back</a>

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