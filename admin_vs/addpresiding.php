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
            <h1 class="text-center" style="margin-bottom: 100px;">Add New Presiding Officer</h1>
            <form class="form-horizontal bucket-form">
                <div class="form-group">
                    <div class="col-sm-6">
                        <input type="text" id="county" class="form-control">
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
