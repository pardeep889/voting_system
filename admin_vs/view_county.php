<?php
require "session.php";
if(!empty($_SESSION['id']) && $_SESSION['user_role'] == 1 ){
include "header.php";
?>
<body>
<section id="container">
    <?php include "nav.php" ?>
    <?php include "sidebar.php" ?>
    <section id="main-content">
        <section class="wrapper">
            <div class="row" style="margin-bottom: 20px;">
                <h1 class="col-sm-10">View County</h1>
                <div class="text-center">
                </div>
            </div>
            <table id="example" class="display" style="width:100%">
                <thead class="text-center">
                <tr>
                    <th class="text-center">County id</th>
                    <th class="text-center"> County Name</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                require "../db/conn.php";
                $sql = "SELECT * FROM vs_county WHERE status < 2";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
//                echo json_encode($row);
                    $st = $row['status'];
                    $id  = $row['id'];
                    ?>
                <tr class="text-center">
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['county_name']; ?></td>
                    <td>
                        <?php
                            if($st == 0){
                                ?>
                                <a onclick="upate_status(<?php echo $id; ?>)" class="btn btn-primary btn-sm"> &nbsp; Activate &nbsp; </a>
                                <?php
                            }
                            elseif ($st == 1){
                                ?>
                                <a onclick="upate_status(<?php echo $id; ?>)" class="btn btn-danger btn-sm">Deactivate</a>
                                <?php
                            }
                            else{
                                echo "Not Specified Status";
                            }
                        ?>
                        <a onclick="county_update(<?php echo $id; ?>)" class="btn btn-success btn-sm">Update</a>
                    </td>
                </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </section>
    </section>
    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Update County</h4>
                </div>
                <div class="modal-body">

                    <form role="form">
                        <div class="form-group">
                            <label for="exampleInputEmail1">County Name</label>
                            <input type="hidden" name="idcounty" id="idcounty">
                            <input type="text" class="form-control" id="inputCountyName">
                        </div>
                        <button type="button" onclick="countyUpdateName()" class="btn btn-dark">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>

    </script>
    <!--main content end-->


</section>

<?php
include "footer.php";
}
else {
    header("location: login.php");
}
?>
