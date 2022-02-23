<?php
session_start();
  include '../../class.php';
    $obj = new main();
    if($_POST["type"] ==  'readStart'){
      $obj->readStart($_POST["value"]);
    }else if($_POST["type"] == 'write') {
         $obj->writeChat($_POST["message"],$_POST["group"]);
    }else if($_POST["type"] == 'readID'){
      $obj->readID($_POST["group"]);
    }else if($_POST["type"] == 'load'){
      $obj->load($_POST["group"],$_POST["id"]);

    }




 ?>
