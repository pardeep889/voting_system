<?php
include "header.php";
include "nav.php";
include "session.php";
include "../db/conn.php";
if(!empty($_SESSION['id']) && $_SESSION['user_role'] == 3 ){
$unique = $_GET['unique'];

?>
<div class="container fixed-min-height">
    <h2 class="text-center large-heading-margin-top">Upload Voter Image</h2>

<input type="hidden" id="unique" value="<?php echo $unique ?>">
<div class="text-center">
<div id="results">Your captured image will appear here...</div>

</div>

  <!-- <h1>Voter Image</h1> -->
  	<div id="my_camera" style="margin-top:60px;"></div>
  	<!-- First, include the Webcam.js JavaScript Library -->
  	<!-- <script type="text/javascript" src="../webcam.min.js"></script> -->
  	<!-- Configure a few settings and attach camera -->
  	<script language="JavaScript">
  		Webcam.set({
  			width: 320,
  			height: 240,
  			image_format: 'jpeg',
  			jpeg_quality: 90
  		});
  		Webcam.attach( '#my_camera' );
  	</script>

  	<!-- A button for taking snaps -->
  	<form>
      <br>
  		<input type=button value="Take Snapshot" class="btn btn-success" onClick="take_snapshot()">
      <a href="uploadFingerprint.php?unique=<?php echo $unique; ?>" class="btn btn-danger">Skip</a>
  	</form>

  	<!-- Code to handle taking the snapshot and displaying it locally -->
  	<script language="JavaScript">
  		function take_snapshot() {
  			// take snapshot and get image data
  			Webcam.snap( function(data_uri) {
  				// display results in page
  				document.getElementById('results').innerHTML =
  					'<h2 class="text-center">Voter Image</h2>' +
  					'<img id="voter_snap" src="'+data_uri+'"/>'+
            '<br><br><button class="btn btn-primary" onclick="saveSnap()">Save Snap</button>';
  			} );
  		}
      function saveSnap(){
        var image_data = $("#voter_snap").attr("src");
        var unique = $("#unique").val();
        var data = {"unique": unique, "image_data": image_data, "select": "saveSnap"};
        $.ajax({
          type:"POST",
          url: "postFunction.php",
          data: data,
          success: function(data){
            if(data.message == "success"){
                window.location = 'uploadFingerprint.php?unique='+data.unique;
            }else{
                swal("Something went wrong !", "Please try Again with","error");
            }
          }
        });
      }

  	</script>
</div>

<?php
include "footer.php";
}
else{
  header('location: login.php');
}

?>
