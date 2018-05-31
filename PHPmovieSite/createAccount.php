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
        <h1>Rebuild of ok.com - Create Account</h1>
        <?php //Adding in the nav bar
            include_once('navbar.php');
        ?>

    </header>


    <form method="POST" action="createAccount.php">
    <fieldset>

        <div class="row">
        <div class="col col-12 offset-md-2 col-md-8">


    <?php
        require_once('variables.php');

        $feedback = '<p class="feedback"><a href="login.php" >Login</a></p>';

        if (isset($_COOKIE['username'])) {
            $feedback = '<p class="feedback">Welcome, '.$_COOKIE['username'].' | <a href="signout.php" >Sign Out</a></p>';
        } 

        
        echo $feedback;
    ?>

    <?php
        require_once('variables.php');

        //BUILD CONNECTION TO DB - localhost means it's on the same server---------------------------------------------------
        $databaseConnect = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME) or die('Could not connect to Database');

        if (isset($_POST['submit'])) {
            //preventing hacking issues or misused characters
            $firstname = mysqli_real_escape_string($databaseConnect, trim($_POST[firstname]));        
            $lastname = mysqli_real_escape_string($databaseConnect, trim($_POST[lastname]));
            $user = mysqli_real_escape_string($databaseConnect, trim($_POST[user]));
            $pass = mysqli_real_escape_string($databaseConnect, trim($_POST[pass]));
            $pass2 = mysqli_real_escape_string($databaseConnect, trim($_POST[pass2]));


            //check to see if information has been added - EMPTY CHECK
            if (!empty($user) && !empty($pass) && !empty($pass2) && ($pass == $pass2)) {

                $query = "SELECT * FROM final_users WHERE username = '$user'";
                $alreadyExists = mysqli_query($databaseConnect, $query) or die('Query failed!');

                if (mysqli_num_rows($alreadyExists) == 0) {
                    //insert the data
                    $addQuery = "INSERT INTO final_users (firstname, lastname, username, password, currentDate) ".
                    "VALUES ('$firstname', '$lastname', '$user', SHA('$pass'), NOW() )";

                    $result = mysqli_query($databaseConnect, $addQuery) or die('Adding to DB failed!');

                    
                    //confirmation message
                    echo '<h2>Your account has been created!</h2>';
                    echo '<h2><a href="index.php">Return to Home</a></h2>';

                    setcookie('username', $user, time() + (60*60*24*30));
                    setcookie('firstname', $firstname, time() + (60*60*24*30));
                    setcookie('lastname', $lastname, time() + (60*60*24*30)); //seconds,minutes,hours, days = 30 days when username will expire

                    //exit the page
                    exit();


                } else {
                    echo '<h2 style="color: red;">Username already exists - please choose a different name.</h2>';
                } //end of existing user check

            } else {
                echo 'Passwords must match! Username and Password must be entered!';
            }//end of empty check
        }



        //CLOSE CONNECTION
        mysqli_close($databaseConnect);
        //--------------------------------------------------------------------------------------

    ?> 



        <h2>Create an Account:</h2>
            <label><p>First Name:<input name="firstname" type="text"  pattern="[a-zA-Z0-9 .]{2,99}" value="<?php if (!empty($firstname)) { echo $firstname; } ?>"></p></label>

            <label><p>Last Name:<input name="lastname" type="text"  pattern="[a-zA-Z0-9 .]{2,99}" value="<?php if (!empty($lastname)) { echo $lastname; } ?>" ></p></label>
            
            <label><p>Username:<input name="user" type="text" value="<?php if (!empty($user)) { echo $user; } ?>"> </p></label>

            <label><p>Password:<input name="pass" type="text" value="<?php if (!empty($pass)) { echo $pass; } ?>"> </p></label>

            <label><p>Retype Password:<input name="pass2" type="text" value="<?php if (!empty($pass2)) { echo $pass2; } ?>"></p></label>

            <br>
            <input class="submit" type="submit" value="Submit" name="submit">


            <br><br>
            <a href="login.php">Back to login</a>

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