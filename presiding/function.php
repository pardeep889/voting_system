<?php

//Login
 if($_GET['select']=='login'){
   require "../db/conn.php";
  $username = htmlentities($_GET['username']);
  $password = htmlentities($_GET['password']);
  $qr =$conn->query("CALL loginProcedure('".$username."', '".$password."')");
  $res = mysqli_num_rows($qr);
  if($res>0){
     $result = $qr->fetch_assoc();
     // $_SESSION['user_role'] = $result['role'];
     echo json_encode($result);
  }
  else{
    echo "fails";
  }
}

//logout
function logout(){
  echo "working";
}

//Forgot
