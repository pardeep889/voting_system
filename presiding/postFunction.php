<?php
if($_POST['select'] == "saveSnap"){
  require "../db/conn.php";
  require "session.php";
  $unique = $_POST['unique'];
  $img_data = $_POST['image_data'];
  $sql = "UPDATE vs_voters SET voter_photo = '$img_data' WHERE voter_uniqueID = '$unique'";
  if($conn->query($sql) === TRUE){
    $response['message'] = "success";
    $response['unique'] = $unique;
  }
  else{
      $response['message'] = "fails";
  }
  header("content-type:application/json");
  echo json_encode($response);
}
?>
