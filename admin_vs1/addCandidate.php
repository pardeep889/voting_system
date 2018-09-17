<?php require "session.php";
require "../db/conn.php";
if(isset($_POST['submit'])){
    $name = $_POST['first_name'];
    $county_id = $_POST['county_id'];
    $last_name = $_POST['last_name'];
    $c_gender = $_POST['c_gender'];
    $position = $_POST['position'];
    $party = $_POST['party'];
    if(empty($name)){
        echo "Please Enter Firstname"; die;
    }elseif (empty($last_name)){
        echo "Please Enter Lastname"; die;
    }
    elseif (empty($c_gender)){
        echo "please select gender"; die;
    }elseif (empty($position)){
        echo "please enter postion of the candidate"; die;
    }elseif (empty($party)){
        echo "Please select party name";die;
    }
    else {
        $sql = "INSERT INTO vs_candidates(first_name, last_name,county_id, gender,candidate_position,party,created_at,updated_at)
             VALUES('$name', '$last_name','$county_id', '$c_gender', '$position', '$party',NOW(),NOW()) ";
        if ($conn->query($sql) === TRUE) {
            header("location: addCandidate.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }
//    $logo = $_POST['fileToUpload'];

//    echo $name.$county_id.$last_name.$c_gender.$position.$party; die;
}
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
                    Add New Candidate
                    <small>Control panel</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </section>
            <div class="container">
                <div class="myNewSection">
                    <form class="form-horizontal bucket-form" action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php
                                $sql = "SELECT id,county_name from vs_county where status = 1";

                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    ?>
                                    <label class="mr-sm-2" for="inlineFormCustomSelect">Select County</label>
                                    <select name="county_id" class="form-control mr-sm-2" id="inlineFormCustomSelect" style="color:#337ab7;  font-weight: bold;">
                                        <?php
                                        // output data of each row
                                        while($row = $result->fetch_assoc()) {
                                            ?>
                                            <option class="county_id" value="<?php echo $row['id']; ?>"><?php echo $row['county_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>

                                    <?php
                                } else {
                                    echo "0 results";
                                }
                                ?>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" name="first_name" class="form-control" placeholder="First name...">
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" name="last_name" class="form-control" placeholder="Last name...">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <select  name="c_gender"  class="form-control" required>
                                    <option value="male">Male</option>
                                    <option  value="female">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" name="position" class="form-control" placeholder="Position...">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" name="party" class="form-control" placeholder="Party...">
                            </div>
                        </div>

                        <input type="submit" name="submit" value="Add New Candidate" class="btn btn-primary">
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