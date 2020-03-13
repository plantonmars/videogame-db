<!--

user_login.php
Presents a form for a user to login, checks to see if the information entered
is within the databasea and either logs the user in or provides an error
message.

Author: Joe Salinas
GitHub: plantonmars

-->

<?php
  if (isset($_SESSION['username'])) {
    include('templates/header.php');
  } else {
    include('templates/nli_header.php');
  }
?>

  <div class="jumbotron">
    <h1>User Login</h1>
    <h3>Welcome Back!</h3>
  </div>

  <?php
    require_once 'login.php';
    $connection = new mysqli($hn, $un, $pw, $db);
    if ($connection->connect_error) die("Fatal Error");
  ?>

   <!-- From used to login user. -->
   <?php if ($_SERVER['REQUEST_METHOD'] != 'POST') { ?>
     <form method="post" action="user_login.php">
       <div class="form-group">
         <label class="title">Username</label>
         <input type="text" class="form-control" name="username"
         placeholder="Username">
       </div>
       <div class="form-group">
         <label class="title">Password</label>
         <input type="password" class="form-control" name="password"
         placeholder="Password">
       </div>
       <input type="submit" class="btn btn-primary" value="Login">
       <br><br>
       <a href="user_registration.php"><button type="button"
         class="btn btn-primary">
         Don't Have An Account? Click Here To Register!</button></a>
     </form>
   <?php } else { ?>

   <?php

     require_once 'login.php';
     $connection = new mysqli($hn, $un, $pw, $db);
     if ($connection->connect_error) die("Fatal Error");

     if (isset($_POST['username']) && isset($_POST['password']))
     {
       //Stores username and variable in passwords, after
       //sanitizing the strings.
       $tempUser = mysql_entities_fix_string($connection, $_POST['username']);
       $tempPass = mysql_entities_fix_string($connection, $_POST['password']);
       //Query used to find the record containing information
       //about the requested user.
       $query = "SELECT * FROM users WHERE Username = '$tempUser'";
       $result = $connection->query($query);

       //If the username is not found the user will be alerted.
       if (!$result) die("Invalid Username was provided.<br>
       <a href='userLogin.php'>Return to Login Page</a>");
       else if ($result->num_rows)
       {
         $row = $result->fetch_array(MYSQLI_NUM);
         $result->close();

         if(password_verify($tempPass, $row[2]))
         {
           session_start();
           $_SESSION['username'] = $row[0];
           $_SESSION['email'] = $row[1];
           echo "<div class='alert alert-success'>You have been logged in!
           </div><br><a href='main_menu.php'><button type='button'
           class='btn btn-primary'>Continue To Main Menu</button></a>";
           echo "</div>";
           exit;
         }
         else {
           login_error();
         }
       }
       else {
         login_error();
       }
     }
     else {
       login_error();
     }

     $connection->close();

   }

   //Functions used to sanitize strings and protect agianst
   //SQL injection attack.
   function mysql_entities_fix_string($connection, $string)
   {
     return htmlentities(mysql_fix_string($connection, $string));
   }

   function mysql_fix_string($connection, $string)
   {
     if (get_magic_quotes_gpc()) $string = stripslashes($string);
     return $connection->real_escape_string($string);
   }

   //Function to handle a login error.
   function login_error() {
     echo "<div class='alert alert-danger'>Invalid username/password
     combination.</div><br><a href='user_login.php'><button type='button'
     class='btn btn-primary'>Return To Login Page</button></a>";
     echo "</div>";
     exit;
   }

  ?>

<?php include('templates/footer.php') ?>
