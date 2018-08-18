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
                <h2>Presiding officer Forgot (Request) </h2>
                <p>Please Enter Your One Time Password</p>
            </div>
            <form id="Login">
                <div class="form-group">
                    <input type="number" class="form-control" id="password" placeholder="Please Enter Your code here">
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
                <button type="button" class="btn btn-primary" id="forgot_button2">Change Password</button>
            </form>
        </div>
        <p class="botto-text"> </p>
    </div>
</div>
<script>
    $("#forgot_button2").click(function () {
        var code = $("#password").val();
        var data = { "code": code };
        $.ajax({
            type: "GET",
            url: 'function.php?select=forgot_request_pass',
            data: data,
            success: function (data) {
                if(data.message == 'success'){
                    location.assign("changepassword.php");
                }
                else if(data.message == 'fails'){
                    swal("Sorry", "You enter wrong code", "error");
                }
            }
        });
    });

</script>
<?php include "footer.php"; }?>
</body>
