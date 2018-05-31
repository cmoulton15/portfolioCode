<?php
    //verify if useris already logged in
    include_once('protectAdmin.php');

    require_once('variables.php');
    
    $movie_id = $_GET['id'];

    //BUILD CONNECTION TO DB - localhost means it's on the same server
    $databaseConnect = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME) or die('Could not connect to Database');

    //BUILD THE QUERY
    $query = "SELECT * FROM final_movies WHERE movie_id = $movie_id";

    //WORK WITH THE DB
    $result = mysqli_query($databaseConnect, $query) or die('Query failed!');

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
        <h1>Rebuild of ok.com - Update Movie</h1>
        <?php //Adding in the nav bar
            include_once('navbar.php');
        ?>
    </header>

    <form method="POST" action="update2.php" enctype="multipart/form-data" name="01form">
    <fieldset>

        <div class="row">
        <div class="col col-12 offset-md-2 col-md-8">

    <?php
        require_once('variables.php');

        $feedback = '<p class="feedback">Welcome, '.$_COOKIE['username'].' | <a href="signout.php" >Sign Out</a></p>';

        echo $feedback;
    
    
        echo '<h2>Update Movie info</h2>';
                       
        while($row = mysqli_fetch_array($result)) {
        
            echo '<label><p>Movie Title:</p><input name="title" type="text" pattern="[a-zA-Z0-9 .]{2,99}" value="'.$row['title'].'" required> </label>';

            echo '<label><p>Rating (G, PG, PG-13, R, MA):
                <select name="rating">
                  <option value="'.$row['rating'].'">'.$row['rating'].'</option>
                  <option>-----</option>
                  <option value="G">G</option>
                  <option value="PG">PG</option>
                  <option value="PG-13">PG-13</option>
                  <option value="R">R</option>
                  <option value="MA">MA</option>
                </select>
                </p>
            </label>';

            echo '<label><p>Description (under 255 characters):</p></label><textarea name="description" type="text" rows="5">'.$row['description'].'</textarea>';

            echo '<input type="hidden" value="'.$movie_id.'" name="movieID">';

        }
        
        ?>

            <h3>*Cannot Update Image</h3>
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