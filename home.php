<style>
    body {
        background: url("https://images.unsplash.com/photo-1531594896955-305cf81269f1?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2550&q=80");
        background-size: cover;
        background-position: center;

    }

    h1, h3, hr {
        color: white;
        text-shadow: 0px 4px 3px black,
                     0px 8px 13px blue;

    }
</style>

<?php
  session_start();
  if (isset($_SESSION['username'])) {
    include('templates/header.php');
  } else {
    include('templates/nli_header.php');
  }
?>

<div class="container text-center" style="padding-top:20%;" >
    <div class="row">
        <div class="mx-auto">
            <div class="col-lg-12">
                <h1 class="display-1">Video Game DB</h1>
                <hr>
                <h3>Home of top video game information</h3>
                <?php
                if (isset($_SESSION['username'])) {
                ?>
                <a href="main_menu.php">
                    <button class="btn btn-primary btn-lg mt-2">
                      View Menu!</button></a>
                <?php
              } else {
                ?>
                <a href="user_login.php">
                    <button class="btn btn-primary btn-lg mt-2">
                      Login!</button></a>
                <?php
              }
                 ?>
            </div>
        </div>
    </div>
</div>


<?php include('templates/footer.php') ?>
