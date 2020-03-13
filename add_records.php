<!--

add_records.php
Presents a form for a user to add a video game record to the database,
data validation will take place and if the record is valid it will be added.

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

    <div class='container'>
      <div class='jumbotron'>
        <h1>Add a Record</h1>
      </div>

    <?php

      //************************************************************************
      //Logic that will ensure the user will not be able to add a record if they
      //are not logged in.
      //************************************************************************
      if (isset($_SESSION['username']))
      {
        $username = htmlspecialchars($_SESSION['username']);
        $email = htmlspecialchars($_SESSION['email']);

        if($_SERVER['REQUEST_METHOD'] != 'POST') {
          echo "<div class='alert alert-info'>
          What type of record would you like to add, $username?</div><br>";
        }
      }
      else
      {
        die ("<div class='alert alert-danger'>Error: You are not logged in!
        </div><br><a href='user_login.php'>
        <button type='button' class='btn btn-primary'>
        Click Here To Login</button></a></div>");
      }
    ?>

    <?php if($_SERVER['REQUEST_METHOD'] == 'POST') {

      require_once 'login.php';
      $conn = new mysqli($hn, $un, $pw, $db);
      if ($conn->connect_error) die("Fatal Error");

      //Function used to sanitize a string.
      function sanitizeString($var)
      {
        if (get_magic_quotes_gpc())
          $var = stripslashes($var);
        $var = htmlentities($var);
        return $var;
      }

      //Obtaining information about the records
      $Title = $_POST['title'];
      $Title = sanitizeString($Title);
      $Publisher = $_POST['publisher'];
      $Publisher = sanitizeString($Publisher);
      $Platform = $_POST['platform'];
      $Year = $_POST['year'];
      $Genre = $_POST['genre'];
      $Rating = $_POST['rating'];

      //Using prepared statements to insert a record.
      $statement = $conn->prepare('INSERT INTO videogames
        VALUES (?, ?, ?, ?, ?, ?)');
      $statement->bind_param('ssssss', $Title, $Platform, $Year,
      $Genre, $Publisher, $Rating);

      //If the record can be added, the page will display the information
      //about the record added.
      if ($statement->execute())
      {
        echo "<div class='alert alert-info'>Record was added succesfully.
        </div><br>";
        echo "<div class='page-header'><h2>Record Added</h2></div><br>";
        echo "<table class='table table-hover'>
                <tr>
                  <td>Title:</td>
                  <td>$Title</td>
                </tr>
                <tr>
                  <td>Platform:</td>
                  <td>$Platform</td>
                </tr>
                <tr>
                  <td>Year:</td>
                  <td>$Year</td>
                </tr>
                <tr>
                  <td>Genre:</td>
                  <td>$Genre</td>
                </tr>
                <tr>
                  <td>Pubisher:</td>
                  <td>$Publisher</td>
                </tr>
                <tr>
                  <td>Rating:</td>
                  <td>$Rating</td>
                </tr>
              </table>";
      }
      else
      {
        echo "<div class='alert alert-danger'>Record was unable to be added.
        </div><br>";
      };

      $statement->close(); }
     ?>

    <form method="post" action="add_records.php" class="mb-2">

      <div class='form-group'>
        <label class='title'>Title</label>
        <input name="title" type="text" class="form-control"
        placeholder="Title" required>
      </div>

      <div class="form-group">
        <label class="title">Publisher</label>
        <input name="publisher" type="text" class="form-control"
        placeholder="Publisher" required>
      </div>

      <div class="form-group">
        <label class="title">Platform</label>
        <select class="form-control" name="platform">
          <option selected="selected" value="DS">DS</option>
          <option value="3DS">3DS</option>
          <option value="GBA">GBA</option>
          <option value="GC">GC</option>
          <option value="NES">NES</option>
          <option value="N64">N64</option>
          <option value="PC">PC</option>
          <option value="PS">PS</option>
          <option value="PS2">PS2</option>
          <option value="PS3">PS3</option>
          <option value="PS4">PS4</option>
          <option value="SWITCH">SWITCH</option>
          <option value="Wii">Wii</option>
          <option value="X360">X360</option>
          <option value="XBONE">XBONE</option>
          <option value="2600">2600</option>
        </select>
      </div>

      <div class="form-group">
        <label class="title">Year</label>
        <select class="form-control" name="year">
          <option selected="selected" value="2020">2020</option>
          <?php
            $current_year = 2019;
            $min_year = 1950;
            for ($current_year; $current_year >= $min_year; $current_year--) {
              echo "<option value='$current_year'>$current_year</option>";
            }
          ?>
        </select>
      </div>

      <div class="form-group">
        <label class="title">Genre</label>
        <select class="form-control" name="genre">
          <option selected="selected" value="Action">Action</option>
          <option value="Fighting">Fighting</option>
          <option value="Misc">Misc</option>
          <option value="Platform">Platform</option>
          <option value="Puzzle">Puzzle</option>
          <option value="Role-Playing">Role-Playing</option>
          <option value="Shooter">Shooter</option>
          <option value="Simulation">Simulation</option>
          <option value="Sports">Sports</option>
        </select>
      </div>

      <div class="form-group">
        <label class="title">Rating</label>
        <select class="form-control" name="rating">
          <option selected="selected" value="Everyone">Everyone</option>
          <option value="Teen">Teen</option>
          <option value="Mature">Mature</option>
        </select>
      </div>
      <input type="submit" class="btn btn-success" value="Add Record">

    </form>

      <a href='main_menu.php'><button type='button' class='btn btn-primary'>
      Back to Main Menu</button></a><br />

<?php include('templates/footer.php') ?>
