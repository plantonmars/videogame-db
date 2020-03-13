<!--

main_menu.php
Presents a menu to the user of the various operations that can be performed
on the site.

Author: Joe Salinas
GitHub: plantonmars

-->

<?php
  session_start();
  if (isset($_SESSION['username'])) {
    include('templates/header.php');
  } else {
    include('templates/nli_header.php');
  }
?>

  <div class="jumbotron">
    <h1>Main Menu</h1>
  </div>

  <?php

    //*******************************************************************
    //Logic that will be used to check if the current user is logged in,
    //and if so they wil be presented with a welcome message, if not they
    //will be presented with an error message.
    //*******************************************************************
    if (isset($_SESSION['username']))
    {
      $username = htmlspecialchars($_SESSION['username']);
      $email = htmlspecialchars($_SESSION['email']);

      echo "<div class='alert alert-info'>Welcome back $username,
      <br>Please make a selection.</div><br>";
    }
    else
    {
      echo "<div class='alert alert-danger'>
      Error: You are not logged in!</div><br>";
    }
  ?>


  <ul class="list-group mx-auto text-center" style='width:15rem;'>
    <!-- Anchor tags indicating a link to a different item. -->
    <li class="list-group-item"><a href="list_records.php">
      List Records</a></li>
    <li class="list-group-item"><a href="add_records.php">
      Add Records</a><br></li>
    <li class="list-group-item"><a href="search_records.php">
      Search for Records</a><br></li>
    <li class="list-group-item"><a href="delete_records.php">
      Delete Records</a></li>
    <li class="list-group-item"><a href="logout.php">
      Logout</a></li>
  </ul>

<?php include('templates/footer.php') ?>
