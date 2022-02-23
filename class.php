<?php
/**
 *
 */
class main
{

  public function showMembers()
  {
    include 'asssets/php/db.inc.php';
    $sql = 'SELECT username FROM members';
    if($stmt = $mysql->prepare($sql)){
      $stmt->execute();
      $stmt->bind_result($user);
      echo '<select class="Gadmins" multiple>';
      while($stmt->fetch()){
        if($user != $_SESSION["login"]){
                echo '   <option value="'.$user.'">'.$user.'</option>';
        }

      }
      echo '</select>';
    }
  }

  public function createGroup($name,$pw,$admin)

  {
    if($admin =="null" ){
        $admins = $_SESSION["login"].",";
    }else{
        $admins = $_SESSION["login"].",".$admin.",";
    }
    $session = $_SESSION["login"].",";
    include 'asssets/php/db.inc.php';
    $sql = 'INSERT INTO groups (groupName,groupMembers,groupAdmins,groupPasswort) VALUES (?,?,?,?)';
    if($stmt = $mysql->prepare($sql)){
      $stmt->bind_param('ssss',$name,$admins,$session,$pw);
      $stmt->execute();
    }

    $sql2 = "CREATE TABLE $name (id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
                                 name VARCHAR(50),
                                 inhalt TEXT);";
    if($stmt2 = $mysql->prepare($sql2)){
      $stmt2->execute();
    }
  }

  public function readGroups()
  {
    include 'asssets/php/db.inc.php';
    $sql = 'SELECT * FROM Groups';
    if($stmt = $mysql->prepare($sql)){
      //  $stmt->bind_param("s",$_SESSION["login"]);
      $stmt->execute();
      $stmt->bind_result($id,$Gname,$Gmem,$Gadmin,$Gpw);
      while($stmt->fetch()){

        $array = explode(",",$Gmem);
        foreach ($array as $key => $value) {
          if($value == $_SESSION["login"] ){
            echo "<div class='use'><li class='contact' value='$Gname'>
      <div class='wrap'>
        <span class='contact-status busy'></span>
        <div class='meta'>
          <img src='http://emilcarlsson.se/assets/haroldgunderson.png'  />
          <p class='name'>$Gname</p>
          <p class='preview'>You just got LITT up, Mike.</p>
        </div>
      </div>
    </li></div>";
          }
        }
      }
    }
  } // end func

public function readStart($value)
{
      include 'asssets/php/db.inc.php';
      $sql = "SELECT * FROM $value ";
      if($stmt = $mysql->prepare($sql)){
        $stmt->execute();
        $stmt->bind_result($id,$name,$inhalt);
        while ($stmt->fetch()) {
          if($name == $_SESSION["login"]){
            echo "<li class='sent'><img src='http://emilcarlsson.se/assets/mikeross.png'  /><p>$inhalt</p></li>";
          }else{
            echo "<li class='replies'>	<img src='http://emilcarlsson.se/assets/harveyspecter.png' /><p><b>".$name.":</b> <br>$inhalt</p></li>";
          }
        }
      }
}

public function writeChat($message,$group){
    include 'asssets/php/db.inc.php';
    $sql = "INSERT INTO $group (name,inhalt) VALUES (?,?)";
    if($stmt = $mysql->prepare($sql)){
      $stmt->bind_param("ss",$_SESSION["login"],$message);
      $stmt->execute();
    }
}

public function readID($group)
{
  include 'asssets/php/db.inc.php';
  $sql = "SELECT id FROM $group ORDER BY id DESC LIMIT 1";
  if($stmt = $mysql->prepare($sql)){
    $stmt->execute();
    $stmt->bind_result($id);
    while ($stmt->fetch()) {
        echo $id;
    }

  }else{
    echo "NOOOO";
  }
}
public function load($group,$id)
{

    include 'asssets/php/db.inc.php';
  $sql = "SELECT name,inhalt FROM $group WHERE id = ?";
  if($stmt = $mysql->prepare($sql)){
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->bind_result($name,$inhalt);
    while($stmt->fetch()){
      if($name != $_SESSION["login"]){
          echo "<li class='replies'>	<img src='http://emilcarlsson.se/assets/harveyspecter.png' /><p><b>".$name.":</b> <br>$inhalt</p></li>";
      }
    }
  }
}


public function checkAdmin($group)
{
    include 'asssets/php/db.inc.php';
    $sql  = "SELECT groupAdmins FROM groups WHERE groupName = ?";
    if($stmt = $mysql->prepare($sql)){
      $stmt->bind_param("s",$group);
      $stmt->execute();
      $stmt->bind_result($admins);
      while ($stmt->fetch()) {
        $explode = explode(",",$admins);
        foreach ($explode as $key => $value) {
          if($value == $_SESSION["login"]){
            echo "<li class='replies'>	<img src='http://emilcarlsson.se/assets/harveyspecter.png' /><p><b>Server:</b> <br>Use Group '$group' Succeded</p></li>";

          }else{
            echo "";
          }
        }
      }
    }
}

public function removeChatValue($group)
{
    include 'asssets/php/db.inc.php';
    $sql = "TRUNCATE $group";
    if($stmt = $mysql->prepare($sql)){
      if($stmt->execute()){
        echo "<li class='replies'>	<img src='http://emilcarlsson.se/assets/harveyspecter.png' /><p><b>Server:</b> <br>Remove Chat Value Success</p></li>";

      }
    }
}
private $mem;
public function addMember($user,$group)
{
  include 'asssets/php/db.inc.php';
  $sql = "SELECT groupMembers FROM groups WHERE groupName = ? ";
    if($stmt = $mysql->prepare($sql)){
      $stmt->bind_param("s",$group);
      $stmt->execute();
      $stmt->bind_result($allMem);
      while ($stmt->fetch()) {
          $this->mem = $allMem."".$user.",";
      }
    }
    $sql2 = "UPDATE groups set groupMembers=? WHERE groupName = ?";
      if($stmt2 = $mysql->prepare($sql2)){
        $stmt2->bind_param("ss",$this->mem,$group);
        if($stmt2->execute()){
          echo "<li class='replies'>	<img src='http://emilcarlsson.se/assets/harveyspecter.png' /><p><b>Server:</b> <br>Add '$user' as  new Member Succeded</p></li>";

        }

      }


}

private $ad;
public function addAdmins($user,$group)
{
  include 'asssets/php/db.inc.php';
  $sql = "SELECT groupAdmins FROM groups WHERE groupName = ? ";
    if($stmt = $mysql->prepare($sql)){
      $stmt->bind_param("s",$group);
      $stmt->execute();
      $stmt->bind_result($allAd);
      while ($stmt->fetch()) {
          $this->ad = $allAd."".$user.",";
      }
    }
    $sql2 = "UPDATE groups set groupAdmins=? WHERE groupName = ?";
      if($stmt2 = $mysql->prepare($sql2)){
        $stmt2->bind_param("ss",$this->ad,$group);
        if($stmt2->execute()){
          echo "<li class='replies'>	<img src='http://emilcarlsson.se/assets/harveyspecter.png' /><p><b>Server:</b> <br>Add '$user' as  new Admin Succeded</p></li>";

        }else{
          echo "no";
        }

      }else{
        echo "NPOO";
      }


}
public function addMemGoroup($group)
{

}

public function joinGroup($pw,$group)
{
    include 'asssets/php/db.inc.php';
    $sql = "SELECT groupName,groupPasswort FROM groups WHERE groupName = ?";
    if($stmt = $mysql->prepare($sql)){
      $stmt->bind_param("s",$group);
      $stmt->execute();
      $stmt->bind_result($name,$pwdb);
      while($stmt->fetch()){
        if($pw == $pwdb ){
          $this->addMember($_SESSION["login"],$name);
        }else{
          echo "as";
        }
      }
    }else{
      echo "NOOOO";
    }
}

public function removeMember($user,$group)
{
  $mem = "";
  include 'asssets/php/db.inc.php';
  $sql = "SELECT groupMembers FROM groups WHERE groupName = ? ";
    if($stmt = $mysql->prepare($sql)){
      $stmt->bind_param("s",$group);
      $stmt->execute();
      $stmt->bind_result($allMem);
      while ($stmt->fetch()) {
        $exp = explode(",",$allMem);
        foreach ($exp as $key => $value) {
          echo $value."<br>";
        }

      }
    }

    $sql2 = "UPDATE groups set groupMembers=? WHERE groupName = ?";
      if($stmt2 = $mysql->prepare($sql2)){
        $stmt2->bind_param("ss",$mem,$group);
        if($stmt2->execute()){
          echo "<li class='replies'>	<img src='http://emilcarlsson.se/assets/harveyspecter.png' /><p><b>Server:</b> <br>Reomove '$user' from '$group' Succeded</p></li>";

        }

      }
}


public function showTable($group,$select)
{
include 'asssets/php/db.inc.php';
  $sql = "SELECT * FROM groups WHERE groupName = ?";
  if($stmt = $mysql->prepare($sql)){
    $stmt->bind_param("s",$group);
    $stmt->execute();
        $stmt->bind_result($id,$groupname,$groupmembers,$groupadmins,$grouppasswort);
        echo ' <table class="table">
         <thead>
         <tr>
         <th scope="col">#</th>
         <th scope="col">Group Name</th>
         <th scope="col">Group Members</th>
         <th scope="col">Group Admins</th>
         <th scope="col">Group Passwort</th>
         </tr>
         </thead>
         <tbody>';
        while ($stmt->fetch()) {
          echo " <tr>
           <th scope='row'>$id</th>
           <td>$groupname</td>
           <td>$groupmembers</td>
           <td>$groupadmins</td>
            <td>$grouppasswort</td>
           </tr>";
        }
        echo '</tbody>
        </table>';


  }

}

public function readFiles()
{
  include 'asssets/php/db.inc.php';
  $sql = "SELECT *	FROM dataforinput	";
  if ($stmt = $mysql->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result($id,$user,$name,$inhalt,$location);

    while ($stmt->fetch()) {
      if($user == $_SESSION["login"]){
        echo "<li class='sent'><img src='http://emilcarlsson.se/assets/mikeross.png'  /><p>$inhalt<br><span style='color:blue'>Mit gesendete Datei: </span><a  style='color:white !important' href='".$location.".zip'>$name</a></p></li>";
      }else{
        echo "<li class='replies'><img src='http://emilcarlsson.se/assets/mikeross.png'  /><p><b>$user:</b><br>$inhalt<br><span style='color:blue'>Mit gesendete Datei: </span><a style='color:black !important' href='".$location.".zip'>$name</a></p></li>";
      }
    }
  }
}


  //end class
}


 ?>
