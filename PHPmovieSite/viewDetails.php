<?php 
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
        <h1>Rebuild of ok.com - Movie Details</h1>
        <?php //Adding in the nav bar
            include_once('navbar.php');
        ?>

    </header>

    <form method="POST" action="comment.php">
    <fieldset>

    <?php
        
        $feedback = '<p class="feedback"><a href="login.php" >Login</a></p>';

        if (isset($_COOKIE['username'])) {
            $feedback = '<p class="feedback">Welcome, '.$_COOKIE['username'].' | <a href="signout.php" >Sign Out</a></p>';
        } 

        
        echo $feedback;
    ?>

                       
        <?php 
            
            //DISPLAY THE  MOVIE RECORDS
            while($row = mysqli_fetch_array($result)) {

                echo '<div class="row border-bottom">';
                    echo '<div class="col col-12 col-md-4">';
                    echo '<img class="movieImage" src="moviepics/'.$row['photo'].'" />';
                    echo '</div>';

                    echo '<div class="col col-12 col-md-8">';
                    echo '<h2>'.$row['title'] .' ('. $row['rating'] .')</h2>'; 
                    echo '<p>'.$row['description'].'</p>';
                echo '</div></div>';


                //LOAD IN REVIEWS
                    //BUILD THE QUERY
                    $reviewQuery = "SELECT * FROM final_reviews WHERE movie_id = $movie_id";

                    //WORK WITH THE DB
                    $reviewResult = mysqli_query($databaseConnect, $reviewQuery) or die('Review Query failed!');

                    echo '<div class="row border-bottom">';
                    echo '<div class="col col-12 col-md-8 offset-md-4">';
                        echo '<h2>Comments</h2>';
                        while($row2 = mysqli_fetch_array($reviewResult)) {
                        
                        if ($row2['userRating'] < 2) {
                            echo '<h3 class="commentUser">'.$row2['user'].' (<span class="stars">'.$row2['userRating'].' STAR</span> out of 5)</h3>'; 
                        } else {
                        echo '<h3 class="commentUser">'.$row2['user'].' (<span class="stars">'.$row2['userRating'].' STARS</span> out of 5)</h3>'; 
                        }
                        
                        echo '<p class="comments">'.$row2['comment'].'</p>';
                        echo '<hr>';
                    
                }


                if (isset($_COOKIE['username'])) {

                        echo '<p>Leave a Comment as '.$_COOKIE['username'].':</p>';
                        echo '<textarea name="comment" type="text" rows="5"></textarea>';
                        echo '<label><p>Rating (from 1-5 stars):</p>';
                        echo '<input name="starRating" type="number" min="1" max="5"  required></label>';
                        
                        echo '<input type="hidden" value="'.$_COOKIE['username'].'" name="user">';
                        echo '<input type="hidden" value="'.$movie_id.'" name="movieID">';

                        echo '<input class="submit" type="submit" value="Submit" name="submit">';
                    echo '</div></div>';
                }
            }

            //CLOSE CONNECTION
            mysqli_close($databaseConnect);

        ?>   

        
         
            
    </fieldset>
    </form>

    <?php //Adding in the nav bar
        include_once('navbar.php');
    ?>


    <main>


    </main>
</div>

</body>
</html>