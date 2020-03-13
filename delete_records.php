<!--

delete_records.php
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
    <div class='jumbotron'>
      <h1>Delete A Record</h1>
    </div>

  <?php
    session_start();

    //*******************************************************************
    //Logic that will ensure the user will not be able to delete a record
    //if they are not logged in.
    //*******************************************************************
    if (isset($_SESSION['username']))
    {
      $username = htmlspecialchars($_SESSION['username']);
      $email = htmlspecialchars($_SESSION['email']);

      echo "<div class='alert alert-info'>Which record would you like to delete,
      $username?</div><br>";
    }
    else
    {
      die ("<div class='alert alert-danger'>Error: You are not logged in!</div>
      <br><a href='user_login.php'><button type='button'
      class='btn btn-default'>Click Here To Login</button></a></div>");
    }
  ?>

  <a href='main_menu.php'><button type='button' class='btn btn-primary'>
    Back to Main Menu</button></a><br><br>

  <?php
    require_once 'login.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Fatal Error");

    //Checks to see if a record requires to be deleted
    if (isset($_POST['delete']) && isset($_POST['title']))
    {
      $title   = get_post($conn, 'title');
      $query  = "DELETE FROM videogames WHERE Title = '$title'";
      $result = $conn->query($query);
      if (!$result) echo "DELETE failed<br><br>";
    }

    $query  = "SELECT * FROM videogames";
    $result = $conn->query($query);
    if (!$result) die ("Database access failed");

    $rows = $result->num_rows;

    //*************************************************************************
    //For-loop that will display each record avaliable in a neat format through
    //a table element.
    //*************************************************************************
    for ($j = 0 ; $j < $rows ; ++$j)
    {
      $row = $result->fetch_array(MYSQLI_NUM);

      $r0 = htmlspecialchars($row[0]);
      $r1 = htmlspecialchars($row[1]);
      $r2 = htmlspecialchars($row[2]);
      $r3 = htmlspecialchars($row[3]);
      $r4 = htmlspecialchars($row[4]);
      $r5 = htmlspecialchars($row[5]);

      echo "<table class='table table-hover'>
              <tr>
                <td>Title:</td>
                <td class='text-right'>$r0</td>
              </tr>
              <tr>
                <td>Platform:</td>
                <td class='text-right'>$r1</td>
              </tr>
              <tr>
                <td>Year:</td>
                <td class='text-right'>$r2</td>
              </tr>
              <tr>
                <td>Genre:</td>
                <td class='text-right'>$r3</td>
              </tr>
              <tr>
                <td>Publisher:</td>
                <td class='text-right'>$r4</td>
              </tr>
              <tr>
                <td>Rating:</td>
                <td class='text-right'>$r5</td>
              </tr>
            </table>";


        echo "<form action='delete_records.php' method='post'>
        <input type='hidden' name='delete' value='yes'>
        <input type='hidden' name='title' value='$r0'>
        <input class='btn btn-info' type='submit'
        value='DELETE RECORD'></form>";
        echo "<br>";
    }

    $result->close();
    $conn->close();

    function get_post($conn, $var)
    {
      return $conn->real_escape_string($_POST[$var]);
    }
  ?>
  <a href='main_menu.php'><button type='button' class='btn btn-primary'>
    Back to Main Menu</button></a><br />

<?php include('templates/footer.php') ?>
