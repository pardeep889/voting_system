<?php
include "header.php";
include "nav.php";
include "session.php";
if(!empty($_SESSION['id']) && $_SESSION['user_role'] == 3 ) {
    $unique = $_GET['id'];
           // $sql = "SELECT * FROM vs_voters where voter_uniqueID = '$unique'";
$sql = "SELECT u.id,u.voter_photo,u.voter_address,u.voter_email,u.voter_contactNO,u.center_code,u.center_address,u.voter_status,u.voter_uniqueID,c.county_name,d.district_name,p.precinct_name,po.polling_placeName,u.voter_name,u.voter_gender,u.voter_verifyStatus,u.voter_ballotNO,u.voter_age,c.id as county_id, d.id as district_id, p.id as precinct_id, po.id as polling_placeID FROM vs_voters u
                    INNER JOIN vs_county c on c.id = u.county_id
                    INNER JOIN vs_district d on d.id = u.district_id
                    INNER JOIN vs_precincts p on p.id = u.precinct_id
                    INNER JOIN vs_polling po on po.id = u.polling_placeID
                    where u.voter_uniqueID = '$unique'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $data =  $row['voter_photo'];
    // echo json_encode($row);
    // header("Content-type: image/gif");
    $str2 = substr($data, 23);
    // echo $str2;

    ?>

    <div class="container fixed-min-height">
    <h2 class="text-center large-heading-margin-top">Show Voter</h2>
      <div class="row">
        <div class="col-sm-8">
          <div class="">
                <strong>Name: </strong> <?php echo ucfirst($row['voter_name']); ?>
          </div>
          <div class="">
                <strong>Gender: </strong> <?php echo ucfirst($row['voter_gender']); ?>
          </div>
          <div class="">
                <strong>Age: </strong> <?php echo ucfirst($row['voter_age']); ?>
          </div>
          <div class="">
                <strong>Contact No: </strong> <?php echo ucfirst($row['voter_contactNO']); ?>
          </div>
          <div class="">
                <strong>E-mail: </strong> <?php echo ($row['voter_email']); ?>
          </div>
          <div class="">
                <strong>Address: </strong> <?php echo ucfirst($row['voter_address']); ?>
          </div>
          <div class="">
                <strong>Center Code: </strong><?php echo $row['center_code'];?>
          </div>
          <div class="">
                <strong>Center Address: </strong> <?php echo ucfirst($row['center_address']); ?>
          </div>
          <div class="">
                <strong>County: </strong> <?php echo ucfirst($row['county_name']); ?>
          </div>
          <div class="">
                <strong>District: </strong> <?php echo ucfirst($row['district_name']); ?>
          </div>
          <div class="">
                <strong>Precinct: </strong> <?php echo ucfirst($row['precinct_name']); ?>
          </div>
          <div class="">
                <strong>Polling Center: </strong> <?php echo ucfirst($row['polling_placeName']); ?>
          </div>

        </div>
        <div class="col-sm-4">
          <div class="voter_snap text-center">
            <?php
              echo '<img src="data:image/jpeg;base64,'.($str2).'"/>';
            ?>
            <br> <br>
            <a class="btn btn-warning" href="uploadSnap.php?unique=<?php echo $unique; ?>">Update Snap </a>
          </div>
        </div>

        <a href="updateVoter.php?id=<?php echo $unique; ?>" class="btn btn-success">Update Record</a>
        <!-- <input type ='button' class="btn btn-warning" onclick="update_voter()" value="Update Voter"> -->

      </div>

        <!-- <form>
            <div class="form-group">
                <label>Select County</label>
                <select class="form-control mr-sm-2 county_select" id="inlineFormCustomSelect" style="color:#337ab7;  font-weight: bold;">
                    <option disabled>Select County</option>
                    <option selected class="county_id" value="<?php echo $row['county_id']; ?>"><?php echo $row['county_name']; ?></option>
                    <?php $county_sql = "SELECT id,county_name FROM vs_county WHERE id != '$row[county_id]'";
                            $res_c = $conn->query($county_sql);
                            if ($res_c->num_rows > 0) {
                                while($rowc = $res_c->fetch_assoc()){
                                    ?>
                                  <option class="county_id" value="<?php echo $rowc['id']?>"><?php echo $rowc['county_name']; ?></option>
                                    <?php
                                }
                            }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Select District</label>
                <input type="hidden" value="<?php echo $row['voter_uniqueID']; ?>" id="unique">
                <select class="form-control mr-sm-2 district_select" id="inlineFormCustomSelect1" style="color:#337ab7;  font-weight: bold;">
                    <option disabled>Select District</option>
                    <option selected class="district_id" value="<?php echo $row['district_id']; ?>"><?php echo $row['district_name']; ?></option>
                </select>
            </div>
            <div class="form-group">
                <label>Select Precinct </label>
                <select class="form-control mr-sm-2 precinct_select" id="inlineFormCustomSelect2" style="color:#337ab7;  font-weight: bold;">
                    <option disabled>Select Precinct</option>
                    <option selected class="precinct_id" value="<?php echo $row['precinct_id']; ?>"><?php echo $row['precinct_name']; ?></option>
                </select>
            </div>
            <div class="form-group">
                <label>Select Polling Place</label>
                <select class="form-control mr-sm-2" id="inlineFormCustomSelect3" style="color:#337ab7;  font-weight: bold;">
                    <option disabled>Select Polling Place</option>
                    <option selected class="pol_id" value="<?php echo $row['polling_placeID']; ?>"><?php echo $row['polling_placeName']; ?></option>
                </select>
            </div>
            <div class="form-group">
                <label>Center Code</label>
                <input type="text" class="form-control" value="<?php echo $row['center_code'];   ?>" id="center_code">
            </div>
            <div class="form_group">
                <label>Center Address</label>
                <textarea id="center_address" class="form-control"><?php echo $row['center_address'] ?></textarea>
            </div>

            <div class="form-group">
                <label>Voter Name</label>
                <input type="text" class="form-control" value="" id="voter_name">
            </div>
            <div class="form-group">
                <label class="mr-sm-2" for="inlineFormCustomSelect">Select Gender</label>
                <select  class="form-control voter_gender" required>
                    <?php if($row['voter_gender'] == 'male') {
                      ?>
                    <option class="voter_gender" value="<?php echo $row['voter_gender']; ?>" selected><?php  echo $row['voter_gender'];?> </option>
                    <option class="voter_gender" value="female">Female</option> <?php
                  }else {
                    ?>
                      <option class="voter_gender" value="<?php echo $row['voter_gender']; ?>" ><?php  echo $row['voter_gender'];?> </option>
                      <option class="voter_gender" value="male">Male</option> <?php
                  }
                  ?>

                </select>
            </div>
            <div class="form-group">
                <label>Voter Age</label>
                <input type="number" min="12" class="form-control" value="<?php echo $row['voter_age'] ?>" id="voter_age">
            </div>
            <div class="form-group">
              <label>Voter Email</label>
                <input type="text" class="form-control" value="<?php echo $row['voter_email'] ?>" id="email">
            </div>
            <div class="form-group">
                <label>Contact Number</label>
                <input type="text" class="form-control" value="<?php echo $row['voter_contactNO'] ?>" id="number">
            </div>
            <div class="form_group">
              <label>Voter Address</label>
                <textarea id="voter_address" class="form-control"><?php echo $row['voter_address'] ?></textarea>
            </div>
            <div class="form_group">
            <br>

            </div>
        </form> -->
    </div>  
    <?php
}
    include "footer.php";
}
else{
    header("location: login.php");
}
    ?>
