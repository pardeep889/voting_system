<?php
include "../db/conn.php";
include "session.php";
include "header.php";


include "nav.php";

if(!empty($_SESSION['id']) && $_SESSION['user_role'] == 3 ) {
    ?>

    <div class="container">
        <h3 class="large-heading-margin-top text-center">Showing All Voters</h3>
    <div class="table-responsive fixed-min-height pre_background box-table">
        <table class="table" id="example" class="display">
            <thead class="thead-dark">
            <tr>
                <th>Voter ID</th>
                <th>Voter name</th>
                <th>Age</th>
                <th>Gender</th>
                <!-- <th>County</th> -->
                <th>Center code</th>
                <th>Voter Email</th>
                <th>Valid ?</th>

            </tr>
            </thead>

            <tbody>
              <?php
              $data = mysqli_query($conn,"CALL getVoters()") or die(mysqli_error($conn));
                  while($voters = mysqli_fetch_assoc($data))
                  {
  //                    echo json_encode($voters);
                  ?>
            <tr>
                <td><?php echo $voters['voter_uniqueID']; ?></td>
                <td><?php echo $voters['voter_name']; ?></td>
                <td><?php echo $voters['voter_age']; ?></td>
                <td><?php echo $voters['voter_gender']; ?></td>
                <!-- <td><?php // echo $voters['county_name']; ?></td> -->
                <td>
                <?php
                echo  $voters['center_code'];
                ?>
                </td>
                <td><?php echo $voters['voter_email']; ?></td>
                <td><?php if($voters['voter_status'] == 1){
                            echo "<span class='text-success'>Valid";
                    }else if($voters['voter_status'] == 0) {
                        echo "<span class='text-warning'>Inactive";
                    }

                        else if($voters['voter_status'] == 2){
                        echo "<span class='text-danger'>Flagged";
                    }
                        ?></td>

            </tr>
            <?php
                }
            ?>
            </tbody>

        </table>


    </div>
    </div>




    <script>
    $(document).ready(function() {
      $('#example').DataTable( {
          });
      });
    </script>
<?php
}
else{
    header('location: login.php');
}


include "footer.php";
