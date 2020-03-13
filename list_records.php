<!--

list_records.php
Displays all records currently within the database.

Author: Joe Salinas
GitHub: plantonmars

-->

<?php include('templates/header.php') ?>

  <div class="jumbotron">
    <h1>Records</h1>
  </div>

  <?php
    session_start();

    //**************************************************************************
    //Logic that will ensure the user will not be able to list records if they
    //are not logged in.
    //**************************************************************************
    if (isset($_SESSION['username']))
    {
      $username = htmlspecialchars($_SESSION['username']);
      $email = htmlspecialchars($_SESSION['email']);

      echo "<div class='alert alert-info'>Here are all the current records,
      $username.</div><br>";
    }
    else
    {
      die ("<div class='alert alert-danger'>Error: You are not logged in!</div>
      <br><a href='user_login.php'><button type='button'
      class='btn btn-default'>Click Here To Login</button></a></div>");
    }
  ?>

  <a href='main_menu.php'><button type='button' class='btn btn-primary'>
    Back to Main Menu</button></a><br>
  <br>

  <?php
    require_once 'login.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Fatal Error");

    $query  = "SELECT * FROM videogames"; //Retrieve existing records

    $result = $conn->query($query);
    if (!$result) die ("Database access failed");

    $rows = $result->num_rows;


    echo "<table class='table table-hover'>
            <tr>
                <th>Title</th>
                <th>Platform</th>
                <th>Year</th>
                <th>Genre</th>
                <th>Publisher</th>
                <th>Rating</th>
            </tr>";

    //For-loop used to retrieve and display each record in a table.
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
    echo "<a href='main_menu.php'><button type='button' class='btn btn-primary'>
    Back to Main Menu</button></a><br />";
    echo "</div>";
   ?>

<?php include('templates/footer.php') ?>
