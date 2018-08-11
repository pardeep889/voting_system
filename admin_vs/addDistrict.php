<?php
require "session.php";
require "../db/conn.php";
if(!empty($_SESSION['id']) && $_SESSION['user_role'] == 1 ){
include "header.php";
?>
<body>
<section id="container" >
    <?php include "nav.php"?>
    <?php include "sidebar.php"?>
    <section id="main-content">
        <section class="wrapper">
            <div class="row" style="margin-bottom: 20px;">
                <h1 class="col-sm-10" >Add New District</h1>
                <div class="text-center">
                    <a href="viewDistrict.php" style="margin-top:20px;" class="btn btn-warning">View District</a>            </div>
            </div>
            <form class="form-horizontal bucket-form">
                <div class="form-group">
                    <div class="col-sm-12">
                 <?php
                        $sql = "SELECT id,county_name from vs_county where status = 1";

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            ?>
                            <label class="mr-sm-2" for="inlineFormCustomSelect">Select County</label>
                            <select class="form-control mr-sm-2" id="inlineFormCustomSelect" style="color:#337ab7;  font-weight: bold;">


                            <?php
                            // output data of each row
                            while($row = $result->fetch_assoc()) {
//                                echo json_encode($row);
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
                        <input type="text" id="m_area" class="form-control" placeholder="Magisterial Area...">
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" id="District" class="form-control" placeholder="Name of District...">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="number" id="no_pre" class="form-control" min="0" placeholder="Number of Precincts...">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="number" id="no_poll" class="form-control" min="0" placeholder="Number of Polling Places...">
                    </div>
                </div>

                <button type="button" id="addDistrict" onclick="addNewDistrict()" class="btn btn-primary">Add New District</button>
            </form>
        </section>
    </section>
    <script>

            var county = $("#county").val();

            if(county == ''){
                alert("Please Enter County name..");
            }else{
                var data = { "county": county };
                $.ajax({
                    type: "GET",
                    url: 'function.php?select=countyAdd',
                    data: data,
                    success: function(data){
                        if(data.message == "success"){
                            // location.reload();
                            county = "";
                            swal("County Added", "Your County has been Added", "success");
                        }else{

                        }
                    }
                });
            }
        });
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
