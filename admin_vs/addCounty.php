<?php
require "session.php";
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
                <h1 class="col-sm-10" >Add New County</h1>
               <div class="text-center">

                   <a href="view_county.php" style="margin-top:20px;" class="btn btn-warning">View County</a>            </div>
            </div>
            <form class="form-horizontal bucket-form">
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" id="county" class="form-control" placeholder="Write name of the county">
                    </div>
                </div>

                    <button type="button" id="county_button" class="btn btn-primary">Add New County</button>

            </form>
        </section>
    </section>
    <script>
        $("#county_button").click(function () {
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
                            swal("County Added", "County is Added successfully !", "success")
                                .then((value) => {
                                    if(value == ""){
                                        location.reload();
                                    } else{
                                        location.reload();
                                    }
                                });
                        }else{
                            swal("Error", "Something went wrong","error");
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
?>
</body><?php
}
else {
    header("location: login.php");
}
?>
