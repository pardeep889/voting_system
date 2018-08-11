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
                <h1 class="col-sm-10" >Add New Precincts</h1>
                <div class="text-center">
                    <a href="viewPrecincts.php" style="margin-top:20px;" class="btn btn-warning">View Precincts</a>            </div>
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
                        <?php
                        $sql = "SELECT id,district_name from vs_district where status = 1";

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            ?>
                            <label class="mr-sm-2" for="inlineFormCustomSelect">Select District</label>
                            <select class="form-control mr-sm-2" id="inlineFormCustomSelect" style="color:#337ab7;  font-weight: bold;">


                                <?php
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
//                                echo json_encode($row);
                                    ?>
                                    <option class="district_id" value="<?php echo $row['id']; ?>"><?php echo $row['district_name']; ?></option>

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
                        <input type="text" id="precinct" class="form-control" placeholder="Name of Precinct...">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" id="address" class="form-control"  placeholder="Address of Precincts...">
                    </div>
                </div>
                <button type="button" id="addDistrict" onclick="addNewPrecinct()" class="btn btn-primary">Add New Precinct</button>
            </form>
        </section>
    </section>
    <script>
        
        function addNewPrecinct() {
            var c_id = $(".county_id:selected").val();
            var district_id = $(".district_id:selected").val();
            var precinct = $("#precinct").val();
            var address = $("#address").val();

            if(precinct == ''){
                swal("Enter Precinct name first", "Precinct name field is empty please fill it");
            }
            else if(address ==''){
                swal("Enter Precinct Address", "Precinct address field is empty please fill it");
            }else{
                var data = { "c_id": c_id,"district_id": district_id, "precinct": precinct, "address": address };
                $.ajax({
                    type: "GET",
                    url: "function.php?select=precinctAdd",
                    data: data,
                    success: function (data) {
                        if(data.message == "success"){
                            swal("Precinct Added", "Precinct is Added successfully !", "success")
                                .then((value) => {
                                    if(value == ""){
                                        location.reload();
                                    } else{
                                        location.reload();
                                    }
                                });
                        }
                        else {
                            swal("Error","Something went wrong","error");
                        }
                    }
                });
            }


            // if(county == ''){
            //     alert("Please Enter County name..");
            // }else{
            //     var data = { "county": county };
            //     $.ajax({
            //         type: "GET",
            //         url: 'function.php?select=precinctAdd',
            //         data: data,
            //         success: function(data){
            //             if(data.message == "success"){
            //                 // location.reload();
            //                 county = "";
            //                 swal("County Added", "Your County has been Added", "success");
            //             }else{
            //
            //             }
            //         }
            //     });
            // }

        }


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
