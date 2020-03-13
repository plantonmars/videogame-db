<!--

search_records.php
Presents a form for a user to search a video game record, error handling will
take place if the record does not exist.

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
        <h1>Record Search</h1>
      </div>

    <?php

      //*******************************************************************
      //Logic that will ensure the user will not be able to search for
      //a record if they are not logged in.
      //*******************************************************************
      if (isset($_SESSION['username']))
      {
        $username = htmlspecialchars($_SESSION['username']);
        $email = htmlspecialchars($_SESSION['email']);

        echo "<div class='alert alert-info'>What would you like to search for,
        $username?</div><br>";
      }
      else
      {
        die ("<div class='alert alert-danger'>Error: You are not logged in!
        </div><br><a href='user_login.php'><button type='button'
        class='btn btn-primary'>Click Here To Login</button></a></div>");
      }
    ?>

    <form method="post" action="search_records.php" class="mb-2">
      <div class="row">
        <div class="form-group col-lg-3 col-xs-4">
          <select name="search" class="form-control">
            <option value="Title">Title</option>
            <option value="Platform">Platform</option>
            <option value="Year">Year</option>
            <option value="Genre">Genre</option>
            <option value="Publisher">Publisher</option>
            <option value="Rating">Rating</option>
          </select>
        </div>
        <div class="form-group col-lg-9 col-xs-8">
          <input name="field" class="form-control" type="text"
          placeholder="Search Criteria..." required>
        </div>
      </div>
      <input type="submit" class="btn btn-success" value="Search">
    </form>

    <?php
      require_once 'login.php';
      $conn = new mysqli($hn, $un, $pw, $db);
      if ($conn->connect_error) die("Fatal Error");

      function sanitizeString($var)
      {
        if (get_magic_quotes_gpc())
          $var = stripslashes($var);
        $var = htmlentities($var);
        return $var;
      }

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $search = $_POST['search'];
        $search = sanitizeString($search);
        $field = $_POST['field'];
        $field = sanitizeString($field);

        //Query used depending on user's selected field and search criteria.
        $query  = "SELECT * FROM videogames WHERE $search = '$field'";

        $result = $conn->query($query);

        $rows = $result->num_rows;

        if ($rows != 0)
        {
          echo "<table class='table table-hover'>
                  <tr>
                      <th>Title</th>
                      <th>Platform</th>
                      <th>Year</th>
                      <th>Genre</th>
                      <th>Publisher</th>
                      <th>Rating</th>
                  </tr>";

          //All records found will be displayed within a table.
          for ($i = 0; $i < $rows; ++$i)
          {

            $result->data_seek($i);

            $row = $result->fetch_array(MYSQLI_NUM);

            echo "<tr>";
            for ($j = 0; $j < 6; ++$j)
              echo "<td>" . htmlspecialchars($row[$j]) . "</td>";
            echo "</tr>";
          }

          echo "</table>";
        }
        else
        {
          echo "<div class='alert alert-danger'>No Records found.</div><br>";
        }
      }

     ?>

     <a href='main_menu.php'><button type='button'
       class='btn btn-primary'>Back to Main Menu</button></a>

<?php include('templates/footer.php') ?>
