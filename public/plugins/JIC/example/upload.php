<?php

  ini_set("display_errors", 0);
  $name = key($_FILES);
  var_dump($_FILES);

  // var_dump($name);

  if ($_FILES[$name]["error"] > 0){
    // echo "Return Code: " . $_FILES[$name]["error"] . "<br />";
  }else{

    echo "Upload: " . $_FILES[$name]["name"] . "<br />";
    echo "Type:   " . $_FILES[$name]["type"] . "<br />";
    echo "Size:   " . ($_FILES[$name]["size"] / 1024) . " Kb<br />";


    if (file_exists($_FILES[$name]["name"])){
        unlink($_FILES[$name]["name"]);
    }
    $carpeta_destino=$_SERVER['DOCUMENT_ROOT'].'/tmp/';
    move_uploaded_file($_FILES[$name]["tmp_name"],$carpeta_destino);


    // if(move_uploaded_file($_FILES[$name]["tmp_name"],$_FILES[$name]["name"])){
    //   echo "View image <a href='" . $_FILES["file"]["name"]."' target='_blank'>here</a>";
    // }else{
    //   echo "The file wasn't uploaded";
    // }
  }


?>
