<?php
 if($_GET['select']=='login'){
  require "../db/conn.php";
  require "session.php";
  $username = htmlentities($_GET['username']);
  $password = htmlentities($_GET['password']);
  $hash_pass = hash('sha256', $password);
  $qr =$conn->query("CALL loginProcedure('".$username."', '".$hash_pass."')");
  $res = mysqli_num_rows($qr);
  if($res>0){
     $result = $qr->fetch_assoc();
     $_SESSION['id'] = $result['id'];
     $_SESSION['user_role'] = $result['role'];
     echo "success";
  }
  else{
    echo "fails";
  }
}
//logout
if($_GET['select'] == 'logout') {
  require "session.php";
  session_destroy();
  echo "success";
}


//show voter
if($_GET['select'] == 'show_voter'){
    require "../db/conn.php";
    require "session.php";
    $unique_id = $_GET['data'];
    $sql = "SELECT * FROM vs_voters where voter_uniqueID = '$unique_id'";
    $result = mysqli_query($conn,$sql);
    $response=[];
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $response[]=$row;
        }
    }
    else{
        echo "fails";
    }
    header("content-type:application/json");
    echo json_encode($response);
}
