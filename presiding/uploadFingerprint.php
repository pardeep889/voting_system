<?php
include "header.php";
include "nav.php";
include "session.php";
include "../db/conn.php";
if(!empty($_SESSION['id']) && $_SESSION['user_role'] == 3 ){
$unique = $_GET['unique'];

?>
<div class="container fixed-min-height">
    <h2 class="text-center large-heading-margin-top">Upload Finger Prints</h2>
    <a href="#" class="btn btn-primary">Scan Finger Print</a>
    <a href="pre_dashboard.php" class="btn btn-danger">Skip</a>
<input type="text" id="unique" value="<?php echo $unique ?>">
<div class="text-center">
</div>
</div>

<?php
include "footer.php";
}
else{
  header('location: login.php');
}

?>
