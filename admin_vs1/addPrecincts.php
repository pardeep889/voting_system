<?php require "session.php";
require "../db/conn.php";
if(!empty($_SESSION['id']) && $_SESSION['user_role'] == 1){

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Voting System | Dashboard</title>
	<?php include("pages/includes/head-section.php");?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <header class="main-header">
    <?php include("pages/includes/header-section.php");?>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
	<?php include("pages/includes/aside-section.php");?>
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add New Precinct
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>
    <div class="container">
      <div class="myNewSection">
        <form class="form-horizontal bucket-form">
            <div class="form-group">
                <div class="col-sm-12">
                    <?php
                    $sql = "SELECT id,county_name from vs_county where status = 1";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        ?>
                        <label class="mr-sm-2" for="inlineFormCustomSelect">Select County</label>
                        <select class="form-control mr-sm-2 county_select" id="inlineFormCustomSelect" style="color:#337ab7;  font-weight: bold;">

                            <option class="county_id" value="0" selected>Select County</option>

                            <?php
                            // output data of each row

                            while($row = $result->fetch_assoc()) {
//                                echo json_encode($row);
                                ?>

                                <option class="county_id" value="<?php echo $row['id']; ?>"><?php echo $row['county_name']; ?></option>

                                <?php
                            }
                            ?>
                        </select>

                        <?php
                    } else {
                        echo "0 results";
                    }
                    ?>

                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">


                        <label class="mr-sm-2" for="inlineFormCustomSelect">Select District</label>


                    <select class="form-control mr-sm-2 district_select" id="inlineFormCustomSelect1" style="color:#337ab7;  font-weight: bold;">

                               <option class="district_id" value="0" selected>Select District</option>
                    </select>


                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12">
                    <input type="text" id="precinct" class="form-control" placeholder="Name of Precinct...">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="text" id="address" class="form-control"  placeholder="Address of Precincts...">
                </div>
            </div>
            <button type="button" id="addDistrict" onclick="addNewPrecinct()" class="btn btn-primary">Add New Precinct</button>
        </form>
      </div>
    </div>
    <!-- Main content -->
    <!-- /.content -->
  </div>

<script type="text/javascript">
    function addNewPrecinct(){
      var c_id = $(".county_id:selected").val();
      var district_id = $(".district_id:selected").val();
      var precinct = $("#precinct").val();
      var address = $("#address").val();

      if(precinct == ''){
          swal("Enter Precinct name first", "Precinct name field is empty please fill it");
      }
      else if(address ==''){
          swal("Enter Precinct Address", "Precinct address field is empty please fill it");
      }
      else if(c_id == '0'){
          swal("Select County First", "You have to select county name");
      }
      else if(district_id == '0'){
          swal("Select District", "You have to select district name");
      }
      else{
          var data = { "c_id": c_id,"district_id": district_id, "precinct": precinct, "address": address };
          $.ajax({
              type: "GET",
              url: "function.php?select=precinctAdd",
              data: data,
              success: function (data) {
                  if(data.message == "success"){
                      swal("Precinct Added", "Precinct is Added successfully !", "success")
                          .then((value) => {
                              if(value == ""){
                                  location.reload();
                              } else{
                                  location.reload();
                              }
                          });
                  }
                  else {
                      swal("Error","Something went wrong","error");
                  }
              }
          });
        }
    }
</script>





  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <?php include("pages/includes/footer-section.php"); ?>
  </footer>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<?php include("pages/includes/script-section.php");?>  
</body>
</html
<?php
}
else{
  header("location:login.php");
}
?>
