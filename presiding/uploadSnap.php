<?php
include "header.php";
include "nav.php";
include "session.php";
include "../db/conn.php";

if(!empty($_SESSION['id']) && $_SESSION['user_role'] == 3){
  $unique = $_GET['unique'];

  if(isset($_POST['uploadFILE'])){
    // echo "test"; die;
    $file = addslashes(file_get_contents($_FILES['imagefile']['tmp_name']));
    $sql = "UPDATE vs_voters SET voter_photo = '$file' WHERE voter_uniqueID = '$unique'";
    if($conn->query($sql) === TRUE){
      $previous = "javascript:history.go(-1)";
        if(isset($_SERVER['HTTP_REFERER'])) {
           $previous = $_SERVER['HTTP_REFERER'];
        }
    }else{
      echo "<script>alert(Something went wrong please try again)</script>";
    }

  }
?>
<div class="container fixed-min-height">
    <h2 class="text-center large-heading-margin-top">Upload Voter Image</h2>
    <form method="post" enctype="multipart/form-data">
      <div class="form-group text-center">
        <input type="file" name='imagefile' id='image' class="form-control" accept="image/*;capture=camera"> <br>
        <input type="submit" name="uploadFILE" value="Upload New Image" id="uploadSnap" class="btn btn-warning" >
      </div>
    </form>

    <div class="text-center">
        <?php
            $sql1 = "SELECT voter_photo from vs_voters WHERE voter_uniqueID = '$unique'";
            $result1 = $conn->query($sql1);
            $row1 = $result1->fetch_assoc();
            ?>
              <div class="container">
                <div class="text-center">
                  <?php
                  echo '<img height ="50%" src="data:/image/jpeg;base64,'.base64_encode($row1['voter_photo']).'"/>';
                  ?>
                </div>
              </div>
    </div>
</div>



<script type="text/javascript">
      $('#uploadSnap').click(function(){
          var image_data = $("#image").val();
          // console.log(image_data);
          if(image_data==''){
            swal("Please select an image","error");
            return false;
          }
          else{
            var ext = $('#image').val().split('.').pop().toLowerCase();
            if(jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1){
                  swal("This is not an image","error");
                  $('#image').val('');
            }
          }
      });
</script>

<?php
include "footer.php";
}
else{
  header('location: login.php');
}

?>
