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
        <h1>Rebuild of ok.com - Home</h1>
        <?php //Adding in the nav bar
            include_once('navbar.php');
        ?>

    </header>



    <form method="POST" action="index.php">
    <fieldset>
    

    <!--ROW 1-->
    <div class="row">
        <div class="col col-12 col-md-9">
            <input class="searchBar" type="text" name="searchBar" placeholder="Search Movies...">
            <input class="searchSubmit" type="submit" value="Go" name="submit">
        </div>

        <div class="col col-12 col-md-3">
        <?php
            require_once('variables.php');

            $feedback = '<p class="feedback"><a href="login.php" >Login</a></p>';

            if (isset($_COOKIE['username'])) {
                $feedback = '<p class="feedback">Welcome, '.$_COOKIE['username'].' | <a href="signout.php" >Sign Out</a></p>';
            } 

            
            echo $feedback;
        ?>
        </div>
    </div>
    <!--ROW 1 END-->



        <h2>Current Movie Listings</h2>
                       
        <?php 
            //BUILD CONNECTION TO DB - localhost means it's on the same server
            $databaseConnect = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME) or die('Could not connect to Database');

            
            //BUILD THE QUERY
            $query = "SELECT * FROM final_movies ORDER BY title ASC";


            //WORK WITH THE DB
            $result = mysqli_query($databaseConnect, $query) or die('Query failed!');


            
            if(isset($_POST['submit'])) {
                $moviesSearch = strtolower($_POST['searchBar']);

                //REMOVE COMMAS FROM SEARCH INPUT (what is being replaced, what it's being replaced with, what text group)
                $moviesSearchClean = str_replace(',', ' ', $moviesSearch);
                //CREATE AN ARRAY FROM THE LIST OF SEARCH TERMS - every time you see first item, explode
                $moviesSearchTerms = explode( ' ', $moviesSearchClean);

                foreach ($moviesSearchTerms as $temp) {
                    //only select actual terms (avoid commas, spaces)
                    if(!empty($temp)) {
                        $searchArray[] = $temp;
                    }
                } //END FOREACH LOOP

                //THIS WILL PUT THE VARIABLE FOR EACH ARRAY ITEM INTO THE PROPER SEARCH TERMS FOR SQL QUERY
                $whereList = array();
                foreach($searchArray as $temp) {
                    $whereList[] = "title LIKE '%$temp%'";
                } //END THIS SECOND FOREACH
                //THIS CONNECTS EACH ARRAY ITEM WITH OR BETWEEN EACH ONE
                $whereQuery = implode(' OR ', $whereList);


                //BUILD THE QUERY - MATCHES FIELDS IN DB
                $searchQuery = "SELECT * FROM final_movies";
                if(!empty($whereQuery)) {
                    $searchQuery .= " WHERE $whereQuery";
                }
                //echo $query;
                
                echo '<h2>Search results for "'.$moviesSearchClean.'":</h2>';

                //echo $query;

                //WORK WITH THE DB
                $searchResult = mysqli_query($databaseConnect, $searchQuery) or die('Query failed!');

                if (mysqli_num_rows($searchResult) > 0) {
                    while ($row = mysqli_fetch_array($searchResult)) {
                        
                        //ROW START
                        echo '<div class="row border-bottom">';
                        echo '<div class="col col-12 col-md-3">';
                        echo '<a href="viewDetails.php?id='.$row['movie_id'].'">';
                        echo '<img class="movieImage" src="moviepics/'.$row['photo'].'" />';
                        echo '</div>';

                        /////////////////HIGHLIGHT SEARCH TERMS IN RESULTS
                        $myResults = strtolower($row['title']);
                        foreach($searchArray as $temp) {
                            $insert = '<***>'.$temp.'</***>';
                            $myResults = str_replace($temp, $insert, $myResults);
                        }//END FOREACH

                        //adding span tags back in - used stars earlier to keep people from adding in "span" text to break the query
                        $myResults = str_replace('***', 'span', $myResults);
                        ///////////////////////////////////////////////

                        echo '<div class="col col-12 col-md-9">';
                        echo '<h3 class="highlights">'.$myResults.' ('. $row['rating'] .')</h3></a>'; 
                        echo '<p>'.$row['description'].'</p>';
                        
                        if ($_COOKIE['username'] == 'admin') {
                            echo '</a><a href="update.php?id='.$row['movie_id'].'"> - Update Title (Admins Only)</a>';
                        }
                        echo '</div>';//END COLUMN
                        echo '</div>';//END ROW
                    }
                }
            }else {
                //DISPLAY THE  REMAINING RECORDS
                while($row = mysqli_fetch_array($result)) {
                    
                    //ROW START
                    echo '<div class="row border-bottom">';
                    echo '<div class="col col-12 col-md-3">';
                    echo '<a href="viewDetails.php?id='.$row['movie_id'].'">';
                    echo '<img class="movieImage" src="moviepics/'.$row['photo'].'" />';
                    echo '</div>';

                    echo '<div class="col col-12 col-md-9">';
                    echo '<h3>'.$row['title'] .' ('. $row['rating'] .')</h3></a>'; 
                    echo '<p>'.$row['description'].'</p>';
                    
                    if ($_COOKIE['username'] == 'admin') {
                        echo '</a><a href="update.php?id='.$row['movie_id'].'"> - Update Title (Admins Only)</a>';
                    }

                    echo '</div>';//END COLUMN
                    echo '</div>';//END ROW
                }
            }

            //CLOSE CONNECTION
            mysqli_close($databaseConnect);

        ?>   

            

            
    </fieldset>
    </form>



    <main>


    </main>
</div>

</body>
</html>