<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//login presiding officer
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
     $_SESSION['polling_place'] = $result['polling_placeID'];
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
            $response=$row;
        }
    }
    else{
        echo "fails";
    }
    header("content-type:application/json");
    echo json_encode($response);
}

//forgot password
if($_GET['select'] == 'forgot'){
    require "../db/conn.php";
    require "session.php";
    $email = $_GET['email'];
    $sql = "SELECT id,email FROM vs_users WHERE email = '$email'";
    $result = mysqli_query($conn,$sql);
    $response=[];
    if(mysqli_num_rows($result) > 0){
        $row = $result->fetch_assoc();
        $_SESSION['forgot_id'] = $row['id'];
        $row['message'] = 'success';
        $response=$row;
        header("content-type:application/json");
        echo json_encode($response);
    }
    else{
        echo "fails";
    }
}

//fogot password reqquest Email
if($_GET['select'] == 'forgot_request') {
    require "../db/conn.php";
    require "session.php";

    require 'mailer/src/Exception.php';
    require 'mailer/src/PHPMailer.php';
    require 'mailer/src/SMTP.php';
    require 'mailer/src/POP3.php';
    require 'mailer/PHPMailerAutoload.php';
    $email = $_GET['email'];
    $mail = new PHPMailer(true);

    try {
        if(empty($_SESSION['otp'])){
            $otp = rand(11111,99999);
            $_SESSION['otp']= $otp;

            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'pardeepprotolabz@gmail.com';                 // SMTP username
            $mail->Password = '********';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;
            $mail->setFrom("pardeep889@hotmail.com", 'pardeep test');
            $mail->addAddress($email, 'Voting System');
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Forgot password request Voting System';
            $mail->Body = "<html>
                                <head>
                                </head>
                                <body>
                                            <h1>Voting System Forgot Password</h1>
                                            <div class='container'>
                                                    <p>We have recieve password request of Your Account:  ".$email." </p>
                                                    <h5 class='text-success'>Your OTP is: ".$otp."</h5>
                                                    <p class='text-danger'>If you did not raise this request you simply can ignore this email</p>
                                             </div>
                                  </body>
                           </html>";
            $mail->AltBody = 'alt body ';
            $mail->send();
        }
        else{
            $data['errForMessage']= 'duplicate';
            header("content-type:application/json");
            echo json_encode($data);
        }

    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        $data['message']= 'fails';
        header("content-type:application/json");
        echo json_encode($data);
    }


}

//request otp
if($_GET['select'] == 'forgot_request_pass'){
    require "../db/conn.php";
    require "session.php";
    $otp = (int)$_SESSION['otp'];
    $req = (int)$_GET['code'];

    if($req === $otp){
        $data['message'] = "success";
        $secret_changepassword = hash('sha256', 'secret_data');
        $_SESSION['secret'] = $secret_changepassword;
    }
    else{
        $data['message'] = "fails";
    }
    header("content-type:application/json");
    echo json_encode($data);
}

//change password
if($_GET['select'] == 'changePassword'){
    require "../db/conn.php";
    require "session.php";
    if(isset($_SESSION['forgot_id'])) {
        if ($_SESSION['secret'] == '594fe9cd56ba213c385ba5b92f752662d6485aa366d350be792ee82ef7c596eb') {
            $pass1 = $_GET['pass1'];
            $pass2 = $_GET['pass2'];
            $id = $_SESSION['forgot_id'];
            if ($pass1 === $pass2) {
                $hash_pass = hash('sha256', $pass1);
                $sql = "UPDATE vs_users SET password = '$hash_pass' where id = '$id'";
                if ($conn->query($sql) === TRUE) {
                    session_destroy();
                    $data['message'] = 'success';
                } else {
                    $data['message'] = 'fails';
                }
            } else {
                $data['message'] = 'fails';
            }
            header("content-type:application/json");
            echo json_encode($data);
        }
    }
    else{
        $data['message'] = 'fails';
        header("content-type:application/json");
        echo json_encode($data);
    }
}

//change password for logged in user
if($_GET['select'] == 'change_password'){
    $pass1 = $_GET['passA'];
    $pass2 = $_GET['passB'];
    $pass = $_GET['passold'];
    if ($pass1 === $pass2) {
        require "../db/conn.php";
        require "session.php";
        $id = $_SESSION['id'];
        $sql = "SELECT * FROM vs_users WHERE id = '$id'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result) > 0) {
            $row = $result->fetch_assoc();
            $id1 = $row['id'];
            $pass_hash = hash('sha256', $pass);
//            echo $pass."hash".$pass_hash."inc".$row['password'] ;
            if($pass_hash == $row['password'] ){
                $hash_pass1 = hash('sha256', $pass1);
                $sql1 = "UPDATE vs_users SET password = '$hash_pass1' where id = '$id1'";
                if ($conn->query($sql1) === TRUE) {
                session_destroy();
                    $data['message'] = 'success';
                }else{
                    $data['message'] = 'fails';
                }
            }else{
                $data['message'] = 'wrong';
            }
        }
        else{
            $data['message'] = 'fails';
        }
    }else{
            $data['message'] = 'fails';
    }
    header("content-type:application/json");
    echo json_encode($data);
}

if($_GET['select'] == 'filterDistrict'){
       require "../db/conn.php";
       require "session.php";
       $id = $_GET['id'];
       if($_SESSION['user_role'] == 3) {
           $sql = "SELECT * FROM `vs_district` WHERE county_id = '$id'";
           $result = mysqli_query($conn,$sql);
           $response=[];
           if (mysqli_num_rows($result) > 0) {
               // output data of each row
               while($row = $result->fetch_assoc()) {
                   $response[]=$row;
               }
           }
           else{
               $response['no'] =  'fails';
           }
           header("content-type:application/json");
           echo json_encode($response);
       }
   }

if($_GET['select'] == 'filterPrecinct'){
    require "../db/conn.php";
    require "session.php";
    $id = $_GET['id'];
    if($_SESSION['user_role'] == 3) {
        $sql = "SELECT * FROM `vs_precincts` WHERE district_id = '$id'";
        $result = mysqli_query($conn,$sql);
        $response=[];
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $response[]=$row;
            }
        }
        else{
            $response['no'] =  'fails';

        }
    }
    else{
        $response['no'] =  'unauth';
    }
    header("content-type:application/json");
    echo json_encode($response);
}
if($_GET['select'] == 'filterPolling'){
    require "../db/conn.php";
    require "session.php";
    $id = $_GET['id'];
    if($_SESSION['user_role'] == 3) {
        $sql = "SELECT * FROM `vs_polling` WHERE precinct_id = '$id'";
//            $sql = "SELECT id,district_name FROM vs_district where county_id = '$id'";
        $result = mysqli_query($conn,$sql);
        $response=[];
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
//                    echo json_encode($row);
                $response[]=$row;
//                    echo '<option  data-subtext="'.$row['id'].'" class="district_id" value="'.$row['id'].'">'.$row['district_name'].'</option>';
            }
        }
        else{
            $response['no'] =  'fails';
        }
    }
    else{
        $response['no'] =  'unauth';
    }
    header("content-type:application/json");
    echo json_encode($response);
}

if($_GET['select'] == 'update_voter'){
  require "../db/conn.php";
  require "session.php";
  $unique = $_GET['unique'];
$c_id = $_GET['c_id'];
$d_id = $_GET['d_id'];
$p_id = $_GET['p_id'];
$pol_id = $_GET['pol_id'];
$center = $_GET['center'];
$center_address = $_GET['center_address'];
$name = $_GET['name'];
$gender = $_GET['gender'];
$voter_age = $_GET['voter_age'];
$email = $_GET['email'];
$number = $_GET['number'];
$voter_address = $_GET['voter_address'];
     if($_SESSION['user_role'] == 3){
       $sql = "UPDATE vs_voters SET county_id = '$c_id',district_id = '$d_id', precinct_id='$p_id',polling_placeID = '$pol_id', center_code = '$center',
                center_address = '$center_address', voter_name ='$name', voter_gender = '$gender', 	voter_age = '$voter_age', voter_email = '$email', voter_contactNO = '$number',
                voter_address = '$voter_address', voter_verifyStatus	= 2
             where voter_uniqueID = '$unique'";
     if ($conn->query($sql) === TRUE) {
          $response['message'] = "success";
      }
      else {
        $response['message'] = "fails";
      }
     }
     else{
        $response['message'] = "unAuth";
     }

  header("content-type:application/json");
  echo json_encode($response);
}
if($_GET['select'] == "flag"){
  require "../db/conn.php";
  require "session.php";
  $unique = $_GET['unique'];
     if($_SESSION['user_role'] == 3){
          $sql = "UPDATE vs_voters SET voter_status = 0 WHERE voter_uniqueID = '$unique' ";
          if($conn->query($sql) === TRUE){
            $response['message'] = "success";
          }
          else{
              $response['message'] = "fails";
          }

     }else{
         $response['message'] = "unAuth";
     }


  header("content-type:application/json");
  echo json_encode($response);
}
if($_GET['select'] == "verify"){
  require "../db/conn.php";
  require "session.php";
  $unique = $_GET['unique'];
  if($_SESSION['user_role'] == 3){
       $sql = "UPDATE vs_voters SET voter_verifyStatus = 1 WHERE voter_uniqueID = '$unique' ";
       if($conn->query($sql) === TRUE){
         $response['message'] = "success";
       }
       else{
           $response['message'] = "fails";
       }

  }else{
      $response['message'] = "unAuth";
  }


header("content-type:application/json");
echo json_encode($response);
}

if($_GET['select'] == "ballot"){
  require "../db/conn.php";
  require "session.php";
  $unique = $_GET['unique'];
  $ballot = $_GET['ballot'];
  if($_SESSION['user_role'] == 3){
       $sql = "UPDATE vs_voters SET voter_ballotNO = '$ballot' WHERE voter_uniqueID = '$unique' ";
       if($conn->query($sql) === TRUE){
         $response['message'] = "success";
       }
       else{
           $response['message'] = "fails";
       }

  }else{
      $response['message'] = "unAuth";
  }
header("content-type:application/json");
echo json_encode($response);
}
