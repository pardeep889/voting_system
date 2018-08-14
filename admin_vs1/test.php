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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="dist/css/ser.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <script src="dist/js/pages/ser.js"></script>

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <header class="main-header">

        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Add New Precinct
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
                                <?php
                                $sql = "SELECT id,county_name from vs_county where status = 1";

                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    ?>
                                    <label class="mr-sm-2" for="inlineFormCustomSelect">Select County</label>
                                    <select class="form-control mr-sm-2 county_select" id="inlineFormCustomSelect" style="color:#337ab7;  font-weight: bold;">

                                        <option class="county_id" value="0" selected>Select County</option>

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
                            <div class="col-sm-12" id="myopt">


                            </div>
                            <input type="text" onclick="filter1()" tabindex="0" class="serk" onkeyup="filter()">
                            <div id="options" style="display: none;">
                                <ul class="uloption">

                                </ul>
                            </div>

<!--                            <select id="first-disabled" class="selectpicker" data-hide-disabled="true" data-live-search="true">-->
<!---->
<!--                                <option>Apple </option>-->
<!--                                <option>Orange</option>-->
<!---->
<!---->
<!--                                <option>Corn</option>-->
<!--                                <option>Carrot</option>-->
<!---->
<!--                            </select>-->


                                <br>


                                <label class="mr-sm-2" for="inlineFormCustomSelect">Select District</label>

                                <!--                    <select id="select-gear" class="demo-default" multiple placeholder="Select gear...">-->
                                <!--                        <option value="">Select gear...</option>-->
                                <!--                        <optgroup label="Climbing">-->
                                <!--                            <option value="pitons">Pitons</option>-->
                                <!--                            <option value="cams">Cams</option>-->
                                <!--                            <option value="nuts">Nuts</option>-->
                                <!--                            <option value="bolts">Bolts</option>-->
                                <!--                            <option value="stoppers">Stoppers</option>-->
                                <!--                            <option value="sling">Sling</option>-->
                                <!--                        </optgroup>-->
                                <!--                        <optgroup label="Skiing">-->
                                <!--                            <option value="skis">Skis</option>-->
                                <!--                            <option value="skins">Skins</option>-->
                                <!--                            <option value="poles">Poles</option>-->
                                <!--                        </optgroup>-->
                                <!--                    </select>-->



                                <select class="form-control mr-sm-2 district_select" id="inlineFormCustomSelect" style="color:#337ab7;  font-weight: bold;">

                                    <option class="district_id" value="0" selected>Select District</option>
                                </select>


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
                </div>
            </div>
            <!-- Main content -->
            <!-- /.content -->
        </div>

        <script type="text/javascript">
            $('.county_select').on('change', function() {
                var id =  this.value ;
                // alert(id);
                data = { "id": id };
                $.ajax({
                    type: "GET",
                    url: "function.php?select=filterDistrict",
                    data: data,
                    success: function (data) {


                        var html1 = '';

                           // // html1 +=  '<select class="selectpicker myopt" data-hide-disabled="true" data-live-search="true">';
                           //
                           // html1 +=  '<div class="dropdown bootstrap-select"><select id="first-disabled" class="selectpicker" data-hide-disabled="true" data-live-search="true" tabindex="-98"><optgroup>';
                           //

                        $("#options").hide();



                        $.each(data ,function (key,value) {
                            // html1 += '<option value="'+value.id+'">'+value.district_name+'</option>';
                            html1 += '<li class="li" onclick="filter2()"><option  value="'+value.id+'">'+value.district_name+'</option> </li>';
                        });


                        $('.uloption').html(html1);

                        // $.each(data, function (key,val) {
                        //     console.log(key+val);
                        // })

                        // $(".district_select").html('<option class="district_id" value="'+data.id+'">'+data.district_name+'</option>');

                    }
                });
            });

 function filter1() {
     $("#options").show();
 }
function filter2() {
    var value = $(".li > option").val();
    alert(value);
}
 
function filter() {
        var a = $(".serk").val();

        var b = $(".optsearch").val();

}


            function addNewPrecinct(){
                var c_id = $(".county_id:selected").val();
                var district_id = $(".district_id:selected").val();
                var precinct = $("#precinct").val();
                var address = $("#address").val();

                if(precinct == ''){
                    swal("Enter Precinct name first", "Precinct name field is empty please fill it");
                }
                else if(address ==''){
                    swal("Enter Precinct Address", "Precinct address field is empty please fill it");
                }
                else if(c_id == '0'){
                    swal("Select County First", "You have to select county name");
                }
                else if(district_id == '0'){
                    swal("Select District", "You have to select district name");
                }
                else{
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
            }


            //
            // function createOptions(number) {
            //     var options = [], _options;
            //
            //     for (var i = 0; i < number; i++) {
            //         var option = '<option value="' + i + '">Option ' + i + '</option>';
            //         options.push(option);
            //     }
            //
            //     _options = options.join('');
            //
            //     $('#number')[0].innerHTML = _options;
            //     $('#number-multiple')[0].innerHTML = _options;
            //
            //
            //     $('#number2')[0].innerHTML = _options;
            //     $('#number2-multiple')[0].innerHTML = _options;
            // }
            //
            // var mySelect = $('#first-disabled2');
            //
            // createOptions(4000);
            //
            // $('#special').on('click', function () {
            //     mySelect.find('option:selected').prop('disabled', true);
            //     mySelect.selectpicker('refresh');
            // });
            //
            // $('#special2').on('click', function () {
            //     mySelect.find('option:disabled').prop('disabled', false);
            //     mySelect.selectpicker('refresh');
            // });
            //
            // $('#basic2').selectpicker({
            //     liveSearch: true,
            //     maxOptions: 1
            // });
        </script>





        <!-- /.content-wrapper -->
        <footer class="main-footer">

        </footer>

        <!-- Add the sidebar's background. This div must be placed
             immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->

    </body>
    </html
    <?php
}
else{
    header("location:login.php");
}
?>
