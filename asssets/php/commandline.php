<?php
session_start();
  include '../../class.php';
  $obj = new main();
  $mainVar = $_POST["type"];
  if($mainVar == "checkAdmin"){
    $obj->checkAdmin($_POST["group"]);
  }else if($_POST["type"] == "removeChatValue"){
      $obj->removeChatValue($_POST["group"]);
  }elseif ($_POST["type"] == "addMember") {
    $obj->addMember($_POST["user"],$_POST["group"]);
  }elseif ($_POST["type"] == "joinGroup") {
    $obj->joinGroup($_POST["pw"],$_POST["group"]);
  }elseif ($_POST["type"] == "removeMember") {
    $obj->removeMember($_POST["user"],$_POST["group"]);
  }elseif ($_POST["type"] == 'showTable') {
    $obj->showTable($_POST["group"],$_POST["select"]);
  }else if($_POST["type"] == "addAdmin"){
    $obj->addAdmins($_POST["user"],$_POST["group"],"groupMembers");
  }


 ?>
