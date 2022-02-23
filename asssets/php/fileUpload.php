<?php
session_start();
  include '../../class.php';
  $obj = new main();
  $mainVar = $_POST["type"];
  if($mainVar == "readFiles"){
    $obj->readFiles();
  }else if($_POST["type"] == "removeChatValue"){
      $obj->removeChatValue($_POST["group"]);
  }elseif ($_POST["type"] == "addMember") {
    $obj->addMember($_POST["user"],$_POST["group"]);
  }


  ?>
