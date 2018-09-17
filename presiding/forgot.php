<?php require "../db/conn.php"; ?>
<?php include "header.php"; ?>
<?php include "session.php"; ?>
<?php
if(!empty($_SESSION['id']) && $_SESSION['user_role'] == 3 ){
    header('location: pre_dashboard.php');
}
else{
?>
<!-- navbar -->
<body id="LoginForm">
<?php include "nav.php";?>
<div class="container large-heading-margin-top fixed-min-height1">
    <div class="login-form">
        <div class="main-div">
            <div class="panel">
                <h2>Presiding officer Forgot</h2>
                <p>Please enter your Email</p>
            </div>
            <form id="Login">
                <div class="form-group">
                    <input type="email" class="form-control" id="email" placeholder="Please enter your email">
                </div>
                <div class="forgot">
                    <a href="login.php">Go Back</a>
                    <br>
                    <span class="text-danger" id="error"></span>
                    <span class="text-success" id="success"></span>
                    <div class="text-center" id="processing" style="display: none;">
                        <p>Please Wait...</p>
                        <span class="dot"></span>
                        <span class="dot"></span>
                        <span class="dot"></span>
                        <span class="dot"></span>
                    </div>

                </div>
                <button type="button" class="btn btn-primary" id="forgot_button">Submit Request</button>
            </form>
        </div>
        <p class="botto-text"> </p>
    </div>
</div>
<script>
    $("#forgot_button").click(function(){
        var email = $("#email").val();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        if (!filter.test(email)) {
            $("#error").text("Please enter valid email address");
        }
        else{
            var data = { "email":  email};
            $.ajax({
                type: "GET",
                url: 'function.php?select=forgot',
                data: data,
                success: function(data){
                    // console.log(data);
                    if(data == 'fails'){
                        $("#error").text("Incorrect email address please enter valid email");
                    }
                    else if (data.message == 'success') {
                        $("#error").text('');
                        $("#success").text('');
                        $("#processing").show();
                        var email = data.email;
                        data1 = { "email": email };
                        $.ajax({
                            type : "GET",
                            url: 'function.php?select=forgot_request',
                            data: data1,
                            success: function (data) {
                                if(data.errForMessage == 'duplicate'){
                                    $("#processing").hide();
                                    $("#error").text("You can use old Otp which is already sent to your email: "+email);
                                }
                                else if(data.message == 'fails') {
                                    $("#error").text("Something went Wrong");
                                }
                                else{
                                    $("#processing").hide();
                                    $("#success").text("Email has been Sent Please check Your Email");
                                    setTimeout(myFunction, 2000);

                                    function myFunction() {
                                        location.assign("request_forgot.php");
                                    }
                                }
                            }
                        });
                    }
                    else{
                        $("#error").text("something went wrong");
                    }
                }
            });
        }
        //

    });

</script>
<?php include "footer.php"; }?>
</body>
