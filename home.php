<?php
  session_start();
  if (isset($_SESSION['username'])) {
    include('templates/header.php')
  } else {
    include('templates/nli_header.php')
  }
?>
