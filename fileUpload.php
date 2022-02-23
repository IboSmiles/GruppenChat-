<?php
if(isset($_FILES['fupload'])){
  $filename = $_FILES["fupload"]["name"];

  $array = explode(".",$filename);
  $name = $array[0];
  $ext = $array[1];
  if ($ext == 'zip') {
    $path = "Uploads/";
    $location = $path . $filename;
    if (move_uploaded_file($_FILES['fupload']["tmp_name"],$location)) {
    echo "nice";
    }
  }
}
 ?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Zip Upload</title>
  </head>
  <body>
      <h1>Zip Upload</h1>
      <form enctype="multipart/form-data" class="form1" action="" method="post">
          <input type="file" name="fupload" ><br>
          <input type="submit" value="Upload Zip File">
      </form>
  </body>
</html>
