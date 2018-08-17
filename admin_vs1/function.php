<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// --------------- Auth Section -----------------
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

    //forgot password
    if($_GET['select'] == 'forgot'){
        require "../db/conn.php";
        require "session.php";
        $email = $_GET['email'];
        $sql = "SELECT id,email FROM vs_users WHERE email = '$email' AND role = 1";
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
                $mail->Password = '*******';                           // SMTP password
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

// -------------End Auth Section-------------------

// -------------Add New Section-------------------

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

            $sql = "INSERT INTO vs_district(district_name, precincts, polling_places, county_id,status, magisterial_area ,created_at, updated_at)
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
        $sql = "INSERT INTO vs_precincts(precinct_name, precinct_address, status, county_id,district_id,created_at,updated_at)
                    VALUES('$name','$address',1,'$c_id','$d_id', NOW(), NOW())";
        if($conn->query($sql) === TRUE ){
            $data['message'] = "success";
        }
        else{
            $data['message'] = "fails";
        }

        header("content-type:application/json");
        echo json_encode($data);
    }
    // add polling
    if($_GET['select'] == 'pollingAdd'){
        require "../db/conn.php";
        require "session.php";
        $c_id =$_GET['county'];
        $d_id = $_GET['district'];
        $p_id = $_GET['precinct'];
        $p_name = $_GET['name'];
        $address =$_GET['address'];
        $sql = "INSERT INTO vs_polling(county_id, district_id,precinct_id, polling_placeName, polling_placeAddress,status,created_at,updated_at)
                    VALUES('$c_id','$d_id','$p_id','$p_name','$address',1,NOW(), NOW())";
        if($conn->query($sql) === TRUE ){
            $data['message'] = "success";
        }
        else{
            $data['message'] = "fails";
        }

        header("content-type:application/json");
        echo json_encode($data);
    }

// -----------Add Section End-------

// --------- update status Section ----------------
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
    // change District status
    if($_GET['select'] == 'upate_status_d'){
        require "../db/conn.php";
        require "session.php";
        $id = $_GET['id'];
        if($_SESSION['user_role'] == 1){
            $sql = "UPDATE vs_district SET status = IF(status=1, 0, 1) where id = '$id'";
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
    // change precinct status
    if($_GET['select'] == 'upate_status_p'){
        require "../db/conn.php";
        require "session.php";
        $id = $_GET['id'];
        if($_SESSION['user_role'] == 1){
            $sql = "UPDATE vs_precincts SET status = IF(status=1, 0, 1) where id = '$id'";
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
    // change polling status
    if($_GET['select'] == 'upate_status_po'){
        require "../db/conn.php";
        require "session.php";
        $id = $_GET['id'];
        if($_SESSION['user_role'] == 1){
            $sql = "UPDATE vs_polling SET status = IF(status=1, 0, 1) where id = '$id'";
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

// ---------End update status Section ----------------



// -----------Update Section--------------
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
    //update District
    if($_GET['select'] == 'districtUpdate'){
        require "../db/conn.php";
        require "session.php";
        $id = $_GET['id'];
        $D_name = $_GET['D_name'];
        $M_area = $_GET['M_area'];
        $pre = $_GET['pre'];
        $poll = $_GET['poll'];
        if($_SESSION['user_role'] == 1){
            $sql = "UPDATE vs_district SET magisterial_area = '$M_area', district_name = '$D_name',
                precincts = '$pre', polling_places = '$poll' where id = '$id'";

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
    //update precinct
    if($_GET['select'] == 'precinctUpdate'){
        require "../db/conn.php";
        require "session.php";
        $id = $_GET['id'];
        $pre_name = $_GET['pre_name'];
        $address = $_GET['address'];
    //    echo $pre_name.$address; die;
        if($_SESSION['user_role'] == 1){
            $sql = "UPDATE vs_precincts SET precinct_name = '$pre_name', precinct_address = '$address'
                where id = '$id'";
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
//    update polling
    if($_GET['select'] == 'pollingUpdate'){
    require "../db/conn.php";
    require "session.php";
    $id = $_GET['id'];
    $p_name = $_GET['p_name'];
    $address = $_GET['address'];
    //    echo $pre_name.$address; die;
    if($_SESSION['user_role'] == 1){
        $sql = "UPDATE vs_polling SET polling_placeName = '$p_name',polling_placeAddress = '$address'
                where id = '$id'";
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

if($_GET['select'] == "updateCandidate") {
    require "../db/conn.php";
    require "session.php";
    $id = $_GET['id'];
    $fname = $_GET['fname'];
    $lname = $_GET['lname'];
    $party = $_GET['party'];
    $pos = $_GET['pos'];
    $gender = $_GET['gender'];
    if ($_SESSION['user_role'] == 1) {
        $sql = "UPDATE vs_candidates SET first_name = '$fname',	last_name = '$lname', gender = '$gender'
              ,candidate_position = '$pos', party = '$party' where id = '$id'";

        if ($conn->query($sql) === TRUE) {
            $response['message'] = "success";
        } else {
            $response['message'] = "fails";
        }
    }else{
        $response['message'] = "unAuth";
    }
    header("content-type:application/json");
    echo json_encode($response);
}
// ------------ End Update Section -----------------------





// ----------------- update call ------------------

    // county update call
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
    // District update call
    if($_GET['select'] == 'district_update'){
        require "../db/conn.php";
        require "session.php";
        $id = $_GET['id'];
        if($_SESSION['user_role'] == 1) {
            $sql = "SELECT * FROM vs_district where id = '$id'";
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
    // precinct Update call
    if($_GET['select'] == 'precinct_update'){
        require "../db/conn.php";
        require "session.php";
        $id = $_GET['id'];
        if($_SESSION['user_role'] == 1) {
            $sql = "SELECT * FROM vs_precincts where id = '$id'";
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
    // pooling update call
    if($_GET['select'] == 'polling_update'){
    require "../db/conn.php";
    require "session.php";
    $id = $_GET['id'];
    if($_SESSION['user_role'] == 1) {
        $sql = "SELECT id,polling_placeName,polling_placeAddress FROM vs_polling where id = '$id'";
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
    //candidate
    if($_GET['select'] == "candidateUpdate"){
    require "../db/conn.php";
    require "session.php";
    $id = $_GET['id'];
    $sql = "SELECT * FROM vs_candidates where id = '$id'";
    $result = mysqli_query($conn,$sql);
    $response=[];
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $response=$row;
        }
    }else{
        $response['message'] = "success";
    }


    header("content-type:application/json");
    echo json_encode($response);

}
    // logo
    if($_GET['select'] == "imageUpdate"){
        require "../db/conn.php";
        require "session.php";
        $id = $_GET['id'];
        $sql = "SELECT logo FROM vs_candidates where id = '$id'";
        $result = mysqli_query($conn,$sql);
        $response=[];
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $response=$row;
            }
        }else{
            $response['message'] = "fails";
        }


        header("content-type:application/json");
        echo json_encode($response);
    }

//-----------update call end-------------


// -----------Filters----------
    if($_GET['select'] == 'filterDistrict'){
        require "../db/conn.php";
        require "session.php";
        $id = $_GET['id'];
        if($_SESSION['user_role'] == 1) {
            $sql = "SELECT * FROM `vs_district` WHERE county_id = '$id'";
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
            header("content-type:application/json");
            echo json_encode($response);


        }
    }

if($_GET['select'] == 'filterPrecinct'){
    require "../db/conn.php";
    require "session.php";
    $id = $_GET['id'];
    if($_SESSION['user_role'] == 1) {
        $sql = "SELECT * FROM `vs_precincts` WHERE district_id = '$id'";
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
        header("content-type:application/json");
        echo json_encode($response);


    }
}


// ----------Filters End--------

// --- Chart Section Starts------

if($_GET['select'] == "byCountyChart"){
    require "../db/conn.php";
    require "session.php";
    if($_SESSION['user_role'] == 1){
        $sql = "SELECT county_name from vs_county";
        $result = mysqli_query($conn,$sql);
        $response=[];
        if (mysqli_num_rows($result) > 0) {
            while ($row = $result->fetch_assoc()) {
//                    echo json_encode($row);
                $response[] = $row;
            }
        }else{
            $response['data'] = "fails";
        }
    }else{
        $response['data'] = "unAuth";
    }
    header("content-type:application/json");
    echo json_encode($response);
}

//----chat section ends-----