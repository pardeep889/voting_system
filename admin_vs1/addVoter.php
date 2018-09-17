<?php require "session.php";
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
                    Add New Voter
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
                                <input type="text" id="county" class="form-control" placeholder="Voter name....">
                            </div>
                        </div>
                        <button type="button" onclick="addVoter()" class="btn btn-primary">Add New County</button>
                    </form>
                </div>
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
