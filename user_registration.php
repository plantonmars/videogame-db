<!--

user_registration.php
Presents a form for a user to create a record for the Users table. If
the data is valid and the user is not already within the database, the user
will be logged in and the session will start.

Author: Joe Salinas
GitHub: plantonmars

-->

<script>

  //Function that will provide errors if the form is incorrectly filled out.
  function validate(form)
  {
    fail = validateUsername(form.username.value);
    fail += validateEmail(form.email.value);
    fail += validatePassword(form.password.value, form.cpassword.value);

    if (fail == "")
      return true
    else
    {
      alert(fail);
      return false
    }
  }

  //Function used to validate the username field.
  function validateUsername(field)
  {
    if (field == "")
      return "No Username was provided.\n"
    else if (field.length < 6)
      return "Usernames must contain at least 6 characters.\n"
    else if (/[^a-zA-Z0-9_-]/.test(field))
      return "Only a-z, A-Z, 0-9, - and _ allowed in Usernames.\n"
    return "";
  }

  //Function used to validate the email field.
  function validateEmail(field)
  {
    if (field == "")
      return "No Email was provided.\n"
    else if (!((field.indexOf(".") > 0) &&
               (field.indexOf("@") > 0)) ||
               /[^a-zA-Z0-9.@_-]/.test(field))
      return "The Email address is invalid.\n"
    return ""
  }

  //Function used to validate the password, and that it matches the
  //confirm password field.
  function validatePassword(password, cpassword)
  {
    if (password == "" && cpassword == "")
      return "Password was not provided in both fields.";
    else if (password == "" || cpassword == "")
      return "Password was not provided in one field.";
    else if (password != cpassword)
      return "Passwords do not match.\n"
    else if (password.length < 8)
      return "Passwords must be at least 8 characters.\n"
    else if (! /[A-Z]/.test(password) ||
             ! /[a-z]/.test(password) ||
             ! /[0-9]/.test(password))
      return "Password must require one of each: a-z. A-Z and 0-9.\n"
    return ""
  }

</script>

<?php include('templates/nli_header.php'); ?>

  <div class="jumbotron">
    <h1>User Registration</h1>
    <h3>Let's get you signed up!</h3>
  </div>

  <?php if($_SERVER['REQUEST_METHOD'] != 'POST') { ?>

  <form method="post" action="user_registration.php"
  onsubmit="return validate(this)">

   <div class="form-group">
     <label class="title">Username</label>
     <input type="text" class="form-control" name="username"
     placeholder="Username">
   </div>

   <div class="form-group">
     <label class="title">Email</label>
     <input type="text" class="form-control" name="email" placeholder="Email">
   </div>

   <div class="form-group">
     <label class="title">Password</label>
     <input type="password" class="form-control" name="password"
     placeholder="Password">
   </div>
   <div class="form-group">
     <label class="title">Confirm Password</label>
     <input type="password" class="form-control" name="cpassword"
     placeholder="Confirm Password">
   </div>
   <input type="submit" class="btn btn-primary" value="Sign Up!">
  </form>

  <a href="user_login.php">
    <button type="button" class="btn btn-primary">
      Already Have An Account? Click Here To Login!</button></a>
<?php } else { ?>

  <?php

    require_once 'login.php';
    $connection = new mysqli($hn, $un, $pw, $db);
    if ($connection->connect_error) die("Fatal Error");

    $username = $email = $password = $cpassword = "";

    //Checks if all parts of the form are filled out,
    //and sanitizes strings before assignment to a variable.
    if (isset($_POST['username']))
      $username = sanitizeString($_POST['username']);
    if (isset($_POST['email']))
      $email = sanitizeString($_POST['email']);
    if (isset($_POST['password']))
      $password = sanitizeString($_POST['password']);
    if (isset($_POST['cpassword']))
      $cpassword = sanitizeString($_POST['cpassword']);

    $fail = validate_username($username);
    $fail .= validate_email($email);
    $fail .= validate_password($password, $cpassword);

    echo $fail;

    //If all tests pass, the record will be added and the
    //user will be prompted to login.
    if ($fail == "")
    {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      add_user($connection, $username, $email, $hash);
      echo "<div class='alert alert-info'>User was added successfully.
      </div><br><a href='user_login.php'><button type='button'
      class='btn btn-primary'>Click Here To Login</button></a>";
      echo "</div>";
      exit;
    }
    //If there were to be errors within PHP validation that JavaScript didn't
    //catch, the errors would of been displayed.
    else
    {
      echo "<div class='alert alert-danger'>
      The following errors exist within PHP validation:</div><br>";
      echo $fail;
      echo "<br>";
      echo "<a href='user_registration.php'>
      <button type='button' class='btn btn-primary'>
      Back to User Registration</button></a>";
    }

    }

    //Function used to validate the username field.
    function validate_username($field)
    {
      if ($field == "")
        return "No Username was provided.<br>";
      else if (strlen($field) < 6)
        return "Username must contain at least 6 characters.<br>";
      else if (preg_match("/[^a-zA-Z0-9_-]/", $field))
        return "Only a-z, A-Z, 0-9, - and _ allowed in Usernames.<br>";
      return "";
    }

    //Function used to validate the password field.
    function validate_password($password, $cpassword)
    {
      if ($password == "" && $cpassword == "")
        return "Password was not provided in both fields.<br>";
      else if ($password == "" || $cpassword == "")
        return "Password was not provided in one field.<br>";
      else if ($password != $cpassword)
        return "Passwords do not match.<br>";
      else if (strlen($password) < 8)
        return "Passwords must be at least 8 characters.<br>";
      else if (!preg_match("/[a-z]/", $password) ||
               !preg_match("/[A-Z]/", $password) ||
               !preg_match("/[0-9]/", $password))
        return "Password must require one of each: a-z. A-Z and 0-9.<br>";
      return "";
    }

    //Function used to validate the email field.
    function validate_email($field)
    {
      if ($field == "")
        return "No Email was provided.<br>";
      else if (!((strpos($field, ".") > 0) &&
                 (strpos($field, "@") > 0)) ||
                 preg_match("/[^a-zA-Z0-9.@_-]/", $field))
        return "The Email address is invalid.<br>";
      return "";
    }

    //Function used to add a user to the users table.
    function add_user($connection, $username, $email, $hash)
    {

      $query  = "SELECT * FROM users WHERE Username = '$username'";
      $result = $connection->query($query);
      $rows = $result->num_rows;

      //Error message will be displayed if the user already exists.
      if ($rows != 0)
      {
        echo "<div class='alert alert-danger'>
        Username has already been taken.</div><br>";
        echo "<a href='user_registration.php'><button type='button'
        class='btn btn-primary'>Back to User Registration</button></a>";
        echo "</div>";
        exit;
      }

      //Prepared statement is used to securely add a new user to the table.
      $statement = $connection->prepare('INSERT INTO users VALUES(?,?,?)');
      $statement->bind_param('sss', $username, $email, $hash);
      $statement->execute();
      $statement->close();
    }

    //Function used to sanitize a string.
    function sanitizeString($string)
    {
      if (get_magic_quotes_gpc())
        $string = stripslashes($string);
      return htmlentities($string);
    }
   ?>

<?php include('templates/footer.php') ?>
