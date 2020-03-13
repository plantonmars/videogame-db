<!--

logout.php
Destroys the current session, thus logging the user out and redirecting them
away from main menu.

Author: Joe Salinas
GitHub: plantonmars

-->

<?php include('templates/nli_header.php'); ?>

    <?php

      session_start();

      //************************************************************************
      //If the username is found within the current session, the session will be
      //deleted and the user will be provided with a message indicating this.
      //************************************************************************
      if (isset($_SESSION['username']))
      {
        $username = htmlspecialchars($_SESSION['username']);
        $email = htmlspecialchars($_SESSION['email']);

        destroySession();

        echo "<div class='jumbotron'><h1>Goodbye, $username!</h1></div>
        <br><div class='alert alert-info'>You Have Been Logged Out!</div>
        <br><a href='user_login.php'><button type='button'
        class='btn btn-primary'>Back to Login Page</button></a><br>";
      }
      else
      {
        die ("<div class='jumbotron'><h1>Logout</h1></div>
        <div class='alert alert-danger'>Error: You are not logged in!</div>
        <br><a href='user_login.php'><button type='button'
        class='btn btn-primary'>Click Here To Login</button></a></div>");
      }

      //Function used to destroy the current session.
      function destroySession()
      {
        $_SESSION = array(); //Session superglobal variable set to empty array.
        setcookie(session_name(), '', $time - 90000000, '/'); //Cookie set to
                                                  //previous time from creation.
      }
    ?>

<?php include('templates/footer.php') ?>
