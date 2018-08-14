<?php
include "header.php";
include "nav.php";
include "session.php";
if(!empty($_SESSION['id']) && $_SESSION['user_role'] == 3 ) {
    $unique = $_GET['id'];
$sql = "SELECT u.id,u.voter_status,u.voter_uniqueID,c.county_name,d.district_name,p.precinct_name,po.polling_placeName,u.voter_name,u.voter_gender,u.voter_verifyStatus,u.voter_ballotNO,u.voter_age,c.id as county_id, d.id as district_id, p.id as precinct_id, po.id as polling_placeID FROM vs_voters u
                    INNER JOIN vs_county c on c.id = u.county_id
                    INNER JOIN vs_district d on d.id = u.district_id
                    INNER JOIN vs_precincts p on p.id = u.precinct_id
                    INNER JOIN vs_polling po on po.id = u.polling_placeID
                    where u.voter_uniqueID = '$unique'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);


    ?>

    <div class="container">
        <form>
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
                <select class="form-control mr-sm-2 county_select" id="inlineFormCustomSelect" style="color:#337ab7;  font-weight: bold;">
                    <option disabled>Select County</option>
                    <option selected class="county_id" value="<?php echo $row['district_id']; ?>"><?php echo $row['district_name']; ?></option>
                </select>
            </div>
            <div class="form-group">
                <label>Select Precinct </label>
                <select class="form-control mr-sm-2 county_select" id="inlineFormCustomSelect" style="color:#337ab7;  font-weight: bold;">
                    <option disabled>Select County</option>
                    <option selected class="county_id" value="<?php echo $row['precinct_id']; ?>"><?php echo $row['precinct_name']; ?></option>
                </select>
            </div>
            <div class="form-group">
                <label>Select Polling Place</label>
                <select class="form-control mr-sm-2 county_select" id="inlineFormCustomSelect" style="color:#337ab7;  font-weight: bold;">
                    <option disabled>Select County</option>
                    <option selected class="county_id" value="<?php echo $row['polling_placeID']; ?>"><?php echo $row['polling_placeName']; ?></option>
                </select>
            </div>
            <div class="form-group">
                <label>Voter Name</label>
                <input type="text" class="form-control" value="<?php echo $row['voter_name'] ?>" name="voter_name">
            </div>
            <div class="form-group">
                <label>Voter Age</label>
                <input type="number" min="12" class="form-control" value="<?php echo $row['voter_age'] ?>" name="voter_name">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" value="<?php echo $row['voter_name'] ?>" name="voter_name">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" value="<?php echo $row['voter_name'] ?>" name="voter_name">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" value="<?php echo $row['voter_name'] ?>" name="voter_name">
            </div>


        </form>
    </div>


    <?php
}
    include "footer.php";
}
else{
    header("location: login.php");
}
    ?>
