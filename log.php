<?php
session_start();

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
    session_destroy();
    header("Location:index.php");
     ?>
  </body>
</html>
