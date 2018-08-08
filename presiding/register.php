<?php
include "session.php";
include "../db/conn.php";
if(!empty($_SESSION['id']) && $_SESSION['user_role'] == 3 ){
$county_name = $_POST['county_name'];
$center_code = $_POST['center_code'];
$voter_name = $_POST['voter_name'];
$voter_gender = $_POST['voter_gender'];
$voter_email = $_POST['voter_email'];
$voter_contactNO = $_POST['voter_contact_no'];
$voter_address = $_POST['voter_address'];
$voter_photo = $_POST['voter_photo'];
$voter_barcode = $_POST['voter_barcode'];
$created_at = date("h:i:s");
$updated_at = date("h:i:s");
$uni = rand(1111111,9999999);
$voter_uniqueID = '7'.$uni.'7';
$voter_verifyStatus = 0;
$voter_role = 0;
$voter_status = 1;
$voter_age = $_POST['voter_age'];

    $qr = mysqli_query($conn,"CALL addNewVoter('".$county_name."','".$center_code."', '".$voter_name."', '".$voter_gender."'
            , '".$voter_age."', '".$voter_email."', '".$voter_contactNO."', '".$voter_address."', '".$voter_photo."', '".$voter_uniqueID."', '".$voter_barcode."'
            , '".$voter_verifyStatus."', '".$voter_status."', '".$voter_role."', '".$created_at."', '".$updated_at."')") or die(mysqli_error($conn));

        if($qr){
                header('location: pre_dashboard.php');
        }
        else{
            echo "Something went wrong";
        }
//echo $country_name.$center_code.$voter_name.$voter_gender.$voter_email.$voter_contactNO.$voter_photo.$voter_barcode.$voter_address;

}
else {
  echo "You Must be LoggedIN";
}

 ?>
