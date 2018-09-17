<?php
include "header.php";
include "nav.php";
include "session.php";
if(!empty($_SESSION['id']) && $_SESSION['user_role'] == 3 ){




    include "footer.php";
}
else{
    header("location: login.php");
}
?>
