<?php require "session.php";
if(!empty($_SESSION['id']) && $_SESSION['user_role'] == 1){
        $id = $_GET['id'];
        echo $id;
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
                  Update Logo
                    <small>Control panel</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </section>
            <div class="">
                <!-- code here -->
                <div class="myNewSection">
                    <?php
                    require "../db/conn.php";
                    require "session.php";
                    $id = $_GET['id'];
                    $sql = "SELECT logo FROM vs_candidates where id = '$id'";
                    $result = mysqli_query($conn,$sql);
                    $response=[];
                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            ?>
                            <div class="text-center">
                                <img src="uploads/<?php echo $row['logo'];?>" width="200" height="200" class="img img-responsive">
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <form action="upload.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label> Select image to upload:</label>
                            <input type="hidden" name="id" value="<?php echo $id; ?>">

                            <input style="float: left;" type="file" name="fileToUpload" id="fileToUpload" required>
                            <br>
                            <input type="submit" value="Upload Image" class="btn btn-default" name="submit">

                        </div>
                    </form>
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
