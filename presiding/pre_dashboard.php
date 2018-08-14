<?php
include "header.php";
include "nav.php";
include "session.php";
if(!empty($_SESSION['id']) && $_SESSION['user_role'] == 3 ){
   ?>
    <h3 class="text-center large-heading-margin-top">Search Voter</h3>
    <div class="container fixed-min-height2 pre_background box-table">
            <form action = "" method="post">
                <div class="form-group text-center padding-10px">
                    <input type="text" id="search" name="search" placeholder="Enter id of the voter...">
<!--                    <input type="submit" name="submit" class="btn btn-warning">-->
                </div>
            </form>

        <?php
        if(isset($_POST['search'])){
        if("" == trim($_POST['search'])) {
        }
        else{
            $search = $_POST['search'];
//            $sql = "SELECT * FROM vs_voters where voter_uniqueID = '$search'";
            $sql = "SELECT u.id,u.voter_status,u.voter_uniqueID,c.county_name,d.district_name,p.precinct_name,po.polling_placeName,u.voter_name,u.voter_gender,u.voter_verifyStatus,u.voter_ballotNO,u.voter_age FROM vs_voters u
                    INNER JOIN vs_county c on c.id = u.county_id
                    INNER JOIN vs_district d on d.id = u.district_id
                    INNER JOIN vs_precincts p on p.id = u.precinct_id
                    INNER JOIN vs_polling po on po.id = u.polling_placeID
                    where u.voter_uniqueID = '$search'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                ?>
        <div class="table-responsive  box-table">
                <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>county</th>
                    <th>District</th>
                    <th>Precinct</th>
                    <th>Polling Place</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Verified ?</th>
                    <th>Ballot No.</th>
                    <th class="text-center">Action</th>
                </thead>
                <?php
                while($row = $result->fetch_assoc()) {
                    ?>
                    <tbody>
                    <tr>
                        <td><?php echo $row['voter_uniqueID']; ?></td>
                        <td><?php echo $row['county_name']; ?></td>
                        <td><?php echo $row['district_name']; ?></td>
                        <td><?php echo $row['precinct_name']; ?></td>
                        <td><?php echo $row['polling_placeName']; ?></td>
                        <td><?php echo $row['voter_name']; ?></td>
                        <td><?php echo $row['voter_age']; ?></td>
                        <td><?php echo $row['voter_gender']; ?></td>
                        <td><?php
                                    if($row['voter_verifyStatus'] == 0){
                                        ?>
                                            <span class="text-danger">Not Verified</span>
                                        <?php
                                    }
                                    else if($row['voter_verifyStatus'] == 1){
                                        ?>
                                        <span class="text-success">Verified</span>
                                        <?php
                                    }
                                    else if($row['voter_verifyStatus'] == 2){
                                        ?>
                                        <span class="text-warning">Updated</span>
                                        <?php
                                    }
                                    else{
                                        ?>
                                        <span class="text-info">Somthing is wrong</span>
                                        <?php
                                    }
                            ?></td>
                        <td><?php
                             if(!$row['voter_ballotNO']){
                                 ?>
                                 <span class="text-danger">Empty</span>
                                 <?php
                             }
                             else{
                                 ?>
                                 <span class="text-success"> <?php echo $row['voter_ballotNO']; ?></span>
                                 <?php
                             }
                            ?></td>
                        <td class="text-center">
                            <a href="#" class="btn btn-danger btn-sm">Flag</a>
                            <a href="updateVoter.php?id=<?php echo $row['voter_uniqueID']; ?>" class="btn btn-warning btn-sm">Update</a>
                            <a href="#" class="btn btn-info btn-sm">Verify</a>
                            <a href="#" class="btn btn-primary btn-sm">Issue Ballot</a>
                        </td>
                    </tr>
                    </tbody>
                    </table>
                    </div>
                    <?php
//                    echo json_encode($row);
                    $conn->close();
                }
            }
            else{
                ?>
                    <div class="text-danger text-center">No Record Found</div>
                <?php
            }
        }
        }
        ?>
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header1">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Update Voter</h4>
                    </div>
                    <div class="modal-body">
                       <form>
                           <div class="form-group">
                               <input type="text" name="county_name" id="voter_name" class="form-control">
                           </div>
                       </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
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
