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
        <h1>Rebuild of ok.com - Login</h1>
        <?php //Adding in the nav bar
            include_once('navbar.php');
        ?>

    </header>

    <form method="POST" action="login.php">
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

        $feedback = '<p class="feedback"><a href="createAccount.php" >Create Acount</a></p>';

        

        if (isset($_POST[submit])) {
            //BUILD CONNECTION TO DB - localhost means it's on the same server---------------------------------------------------
            $databaseConnect = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME) or die('Could not connect to Database');

            $user = mysqli_real_escape_string($databaseConnect, trim($_POST[user]));
            $pass = mysqli_real_escape_string($databaseConnect, trim($_POST[pass]));

            $query = "SELECT * FROM final_users WHERE username = '$user' AND password = SHA('$pass')";
            $checkUser = mysqli_query($databaseConnect, $query) or die('Checking user failed!');


            //check if user and password match in DB
            if (mysqli_num_rows($checkUser) == 0) {
                $feedback = '<p class="feedback">An account does not exist for '.$user.' with that password.<br>
                <a href="createAccount.php" >Create Acount</a></p>';

            } else { //if returns one row
                $row = mysqli_fetch_array($checkUser); //these cookies expire in 30 days
                setcookie('username', $row['username'], time() + (60*60*24*30));
                setcookie('firstname', $row['firstname'], time() + (60*60*24*30));
                setcookie('lastname', $row['lastname'], time() + (60*60*24*30)); 

                header('Location: index.php');
            }


        }



        echo $feedback;
    ?>

        <h2>Login Info for an Existing Account:</h2>
                       
            <label><p>Username:<input name="user" type="text" value="<?php if (!empty($user)) { echo $user; } ?>" required></p></label>

            <label><p>Password:<input name="pass" type="text" value="<?php if (!empty($pass)) { echo $pass; } ?>" required></p></label>

            <br>

            <input class="submit" type="submit" value="Login" name="submit">

            <br><br>
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