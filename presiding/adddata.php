<?php
include "header.php";
include "nav.php";
include "session.php";
include "../db/conn.php";
if(!empty($_SESSION['id']) && $_SESSION['user_role'] == 3 ){
    ?>
    <script type="text/javascript">
        // $(document).ready(function(){
        //   swal("Hello world!");
        // });
    </script>
    <div class="container">
        <h2 class="text-center large-heading-margin-top">Add New Voter</h2>
        <?php $id = $_SESSION['polling_place'];

    $sql = "SELECT pol.county_id,pol.district_id,pol.precinct_id,u.polling_placeID
      from vs_users u inner join vs_polling pol on u.polling_placeID = pol.id where u.polling_placeID = '$id'";

        $result = mysqli_query($conn,$sql);
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                // echo json_encode($row);
     ?>


        <div class="pre_background box-form">
            <form class="form" action="register.php" method="post">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="hidden" name="c_id" value="<?php echo $row['county_id'];?>">
                            <input type="hidden" name="d_id" value="<?php echo $row['district_id'];?>">
                            <input type="hidden" name="p_id" value="<?php echo $row['precinct_id'];?>">
                            <input type="hidden" name="pol_id" value="<?php echo $id;?>">

                        </div>
<?php
}
}

 ?>
                    </div>
                    <div class="col-sm-6">

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <!-- <label for="name">Voter Name <span class="text-danger">*</span></label> -->
                            <input type="text" name="voter_name" placeholder="Voter Name..." class="form-control" required>
                        </div>

                            <div class="form-group">
                                <!-- <label class="mr-sm-2" for="inlineFormCustomSelect">Select Gender<span class="text-danger">*</span></label> -->
                                <select name="voter_gender" class="form-control" id="inlineFormCustomSelect" required>
                                  <option value="" selected disabled>Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <!-- <label for="age">Voter Age <span class="text-danger">*</span></label> -->
                                <input type="number" min="12" name="voter_age" class="form-control" placeholder="Voter Age..." required>
                            </div>
                            <div class="form-group">
                                <!-- <label for="name">Voter Contact No <span class="text-danger">*</span></label> -->
                                <input type="text" name="voter_contact_no" class="form-control" placeholder="Contact no..." required>
                            </div>
                            <div class="form-group">
                                <!-- <label for="name">Voter Email</label> -->
                                <input type="email" name="voter_email" placeholder="Voter Email..." class="form-control" >
                            </div>
                            <div class="form-group">
                                <!-- <label for="name">Voter Address <span class="text-danger">*</span></label> -->
                                <textarea name="voter_address" placeholder="Voter Address" rows="3" cols="80" class="form-control" required></textarea>
                            </div>
                    </div>


                    <div class="col-sm-6 text-center right-button-align">
                      <div class="form-group">
                          <input type="submit" class="btn btn-success" value="Save Voter">
                          <a href="pre_dashboard.php" class="btn btn-danger">Cancel</a>
                      </div>

                    </div>

                </div>

                <!-- <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Take Photo</label>
                            <input type="text" name="voter_photo" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Scan Barcode</label>
                            <input type="text" name="voter_barcode" class="form-control">
                        </div>

                    </div>
                </div> -->

            </form>
        </div>
    </div>
    <?php
}
else{
    header("location: login.php");
}
?>
<?php
include "footer.php";
// }

?>
