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
                    View Candidates
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
                        <th class="text-center">ID</th>
                        <th class="text-center">Logo</th>
                        <th class="text-center">County Name</th>
                        <th class="text-center">First Name</th>
                        <th class="text-center">Last Name</th>
                        <th class="text-center">Gender</th>
                        <th class="text-center">Position</th>
                        <th class="text-center">Party</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php require "../db/conn.php";
                    $sql = "SELECT * FROM vs_candidates ";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        $county = $row['county_id'];
                        $sql1 = "SELECT county_name FROM vs_county WHERE id = '$county'";
                        $result1 = $conn->query($sql1);
                        $row1 = $result1->fetch_assoc();
//                        echo json_encode($row1);
//                echo json_encode($row);
                        $id  = $row['id'];
                        ?>
                        <tr class="text-center">
                            <td><?php echo $row['id']; ?></td>
                            <td>
                                <?php
                                        if($row['logo']){
                                            ?>
                                            <div class="row">
                                                <div class="col-sm-8">
                                                     <span class="text-center">
                                                <img src="uploads/<?php echo $row['logo'];?>" width="100" height="100" class="img img-responsive">
                                                </span>
                                                </div>
                                                <div class="col-sm-3">
                                                    <a href="#" onclick="update_image(<?php echo $row['id'] ?>)" class="btn btn-primary btn-sm">Update</a>
                                                </div>
                                            </div>


                                            <?php
                                        }else{
                                            ?>
                                            <form action="upload.php" method="post" enctype="multipart/form-data">
                                                <div class="form-group">
                                                <label> Select image to upload:</label>
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <input style="float: left;" type="file" name="fileToUpload" id="fileToUpload" required>
                                                    <br>
                                                <input type="submit" value="Upload Image" class="btn btn-default" name="submit">

                                                </div>
                                            </form>

                                            <?php
                                        }

                                ?>


                            </td>
                            <td><?php echo $row1['county_name'];?></td>
                            <td><?php echo $row['first_name'];?></td>
                            <td><?php echo $row['last_name'];?></td>
                            <td><?php echo $row['gender'];?></td>
                            <td><?php echo $row['candidate_position'];?></td>
                            <td><?php echo $row['party'];?></td>
                            <td>

                                <a onclick="updateCandidate(<?php echo $id; ?>)" class="btn btn-success btn-sm">Update</a>
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
                            <h4 class="modal-title">Update Candidate</h4>
                        </div>
                        <div class="modal-body">

                            <form role="form">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">First name</label>
                                    <input type="hidden" name="idcan" id="idcan" required>
                                    <input type="text" class="form-control" id="first_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Last name</label>
                                    <input type="text" class="form-control" id="last_name" required>
                                </div>
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select class="form-control" id="can_gender">

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Party</label>
                                    <input type="text" class="form-control" id="party" required>
                                </div>

                                <div class="form-group">
                                    <label>Position</label>
                                    <input type="text" class="form-control" id="pos">
                                </div>

                                <button type="button" onclick="candidateUpdate()" class="btn btn-outline-dark">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal1" class="modal fade" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Update Logo</h4>
                        </div>
                        <div class="modal-body">

                            <form role="form">
                                <div class="form-group">
                                    <div class="text-center" id="imagelocation">

                                    </div>
                                </div>
                                    <form action="uploads1.php" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label> Select image to upload:</label>
                                            <input type="hidden" name="idcn" id="idcn" required>
                                            <input style="float: left;" type="file" size="500" name="fileToUpload" id="fileToUpload" required>
                                            <br>
                                            <input type="button" onclick="update_logo()" value="Update Image" class="btn btn-outline-success" name="submit">
                                        </div>
                                    </form>



<!--                                <button type="button" onclick="candidateUpdate()" class="btn btn-outline-dark">Update</button>-->
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
