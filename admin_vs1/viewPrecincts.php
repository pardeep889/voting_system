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
                    View Precincts
                    <small>Control panel</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </section>

            <!-- code here -->

            <div class="myNewSection">
                <table id="example" class="display" style="width:100%">
                    <thead class="text-center">
                    <tr>
                        <th class="text-center">Precinct id</th>
                        <th class="text-center">Precinct Name</th>
                        <th class="text-center"> Address</th>
                        <th class="text-center">County Name</th>

<!--                        <th class="text-center">Polling Places</th>-->

                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php require "../db/conn.php";
                    $sql = "SELECT * FROM vs_precincts WHERE status < 2";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
//                echo json_encode($row);
                        $st = $row['status'];
                        $id  = $row['id'];
                        $county = $row['county_id'];
                        $sql1 = "SELECT county_name FROM vs_county WHERE id = '$county'";
                        $result1 = $conn->query($sql1);
                        $row1 = $result1->fetch_assoc();
//                        echo json_encode($row1);
                        ?>
                        <tr class="text-center">
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['precinct_name']; ?></td>
                            <td><?php echo $row['precinct_address']; ?></td>
                            <td><?php echo $row1['county_name']; ?></td>
<!--                            <td>--><?php //echo $row['polling_places']; ?><!--</td>-->
                            <td>
                                <?php
                                if($st == 0){
                                    ?>
                                    <a onclick="upate_status_p(<?php echo $id; ?>)" class="btn btn-primary btn-sm"> &nbsp; Activate &nbsp; </a>
                                    <?php
                                }
                                elseif ($st == 1){
                                    ?>
                                    <a onclick="upate_status_p(<?php echo $id; ?>)" class="btn btn-danger btn-sm">Deactivate</a>
                                    <?php
                                }
                                else{
                                    echo "Not Specified Status";
                                }
                                ?>
                                <a onclick="precinctUpdate(<?php echo $id; ?>)" class="btn btn-success btn-sm">Update</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
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
                                    <label for="exampleInputEmail1">Precinct Name</label>
                                    <input type="hidden" name="idpre" id="idpre">
                                    <input type="text" class="form-control" id="prename">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Address</label>
                                    <input type="text" class="form-control" id="address">
                                </div>
                                <button type="button" onclick="update_Precinct()" class="btn btn-dark">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- code end here -->
        </div>
        <!-- Main content -->
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <?php include("pages/includes/footer-section.php"); ?>
    </footer>

    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>

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
