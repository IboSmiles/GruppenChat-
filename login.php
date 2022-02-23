<?php
  session_start();
 ?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
  </head>
  <body>
    <form class="form1" action="" method="post">
      <label for="user">Username:</label>
      <input type="text" name="user" value=""><br>
      <label for="pw">Passwort</label><input type="text" name="pw" value=""><br>
      <input type="submit" name="" value="Login">
    </form>
    <?php
    /**
     *
     */
    class Login
    {

      function __construct($user,$pw)
      {
        include 'asssets/php/db.inc.php';
        $sql = "SELECT username,pw FROM members WHERE username = ?";
        if($stmt = $mysql->prepare($sql)){
          $stmt->bind_param("s",$user);
            $stmt->execute();
          $stmt->bind_result($userdb,$pwdb);
          while ($stmt->fetch()) {

            if($user == $userdb && $pw == $pwdb){
              $_SESSION["login"] = $user;
              header("Location:index.php");


            }else{
              echo "NOS";
            }
          }
        }else{
          echo "NOOOO";
        }
      }
    }
    if(isset($_POST["user"])){
      $obj = new Login($_POST["user"],$_POST["pw"]);

    }

     ?>

  </body>
</html>
