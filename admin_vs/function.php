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
  $qr =$conn->query("CALL loginProcedureForAdmin('".$username."', '".$hash_pass."')");
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


//add new county
if($_GET['select'] == 'countyAdd'){
    require "../db/conn.php";
    require "session.php";
    $county = $_GET['county'];

    $sql = "INSERT INTO vs_county(county_name, status, created_at, updated_at) values ('$county',1, NOW(),NOW())";
    if ($conn->query($sql) === TRUE) {
        $data['message'] = "success";
    }
    else{
        $data['message'] = "fails";
    }
    header("content-type:application/json");
    echo json_encode($data);

}


//change county status
if($_GET['select'] == 'countyStatus'){
    require "../db/conn.php";
    require "session.php";
    $id = $_GET['id'];
    if($_SESSION['user_role'] == 1){
        $sql = "UPDATE vs_county SET status = IF(status=1, 0, 1) where id = '$id'";
        if ($conn->query($sql) === TRUE) {
            $data['message'] = "success";
        }else{
            $data['message'] = "fails";
        }
    }else{
        $data['message'] = "unauth";
    }
    header("content-type:application/json");
    echo json_encode($data);
}

// update county call
if($_GET['select'] == 'countyUpdate'){
    require "../db/conn.php";
    require "session.php";
    $id = $_GET['id'];
    if($_SESSION['user_role'] == 1) {
        $sql = "SELECT * FROM vs_county where id = '$id'";
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
    }
    header("content-type:application/json");
    echo json_encode($response);
}

//update county name
if($_GET['select'] == 'countyUpdateName'){
    require "../db/conn.php";
    require "session.php";
    $name = $_GET['name'];
    $id = $_GET['id'];
    if($_SESSION['user_role'] == 1){
        $sql = "UPDATE vs_county SET county_name = '$name' where id = '$id'";
        if ($conn->query($sql) === TRUE) {
            $data['message'] = "success";
        }else{
            $data['message'] = "fails";
        }
    }else{
        $data['message'] = "unauth";
    }
    header("content-type:application/json");
    echo json_encode($data);
}

//add district
if($_GET['select']== 'districtAdd'){
    require "../db/conn.php";
    require "session.php";
    if($_SESSION['user_role'] == 1) {
        $id = $_GET['id'];
        $meg_area = $_GET['meg_area'];
        $dname = $_GET['dname'];
        $pre = $_GET['pre'];
        $poll = $_GET['poll'];

        $sql = "INSERT INTO vs_district(destrict_name, precincts, polling_places, county_id,status, magisterial_area ,created_at, updated_at)
                VALUES('$dname', '$pre','$poll', '$id',1, '$meg_area', NOW(),NOW()) ";
        if ($conn->query($sql) === TRUE) {
            $data["message"] = "success";
        }
        else{
            $data["message"] = "fails";
        }


    }
    else{
        $data['message'] = "unauth";
    }
    header("content-type:application/json");
    echo json_encode($data);
}

//add precinct
if($_GET['select'] == 'precinctAdd'){
    require "../db/conn.php";
    require "session.php";
        $c_id =$_GET['c_id'];
        $d_id = $_GET['district_id'];
        $name = $_GET['precinct'];
        $address =$_GET['address'];
        $sql = "INSERT INTO vs_precincts(precinct_name, precinct_address, status, county_id,created_at,updated_at)
                VALUES('$name','$address',1,'$c_id', NOW(), NOW())";
        if($conn->query($sql) === TRUE ){
            $data['message'] = "success";
        }
        else{
            $data['message'] = "fails";
        }

    header("content-type:application/json");
    echo json_encode($data);
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
