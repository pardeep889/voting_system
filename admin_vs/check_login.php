<?php
require "session.php";
if(!empty($_SESSION['id']) && $_SESSION['user_role'] == 1 ){
    header("location: index.php");
}
?>
