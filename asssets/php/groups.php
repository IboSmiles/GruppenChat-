<?php
  session_start();
  include '../../class.php';
  $obj = new main();
  switch ($_POST["type_group"]) {
    case 'create':
      $obj->createGroup($_POST["Gname"],$_POST["Gpw"],$_POST["Gadmins"]);
      break;
      case 'read':
        $obj->readGroups();
        break;

    default:
      // code...
      break;
  }

 ?>
