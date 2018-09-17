<?php require "../db/conn.php"; ?>
<?php include "header.php"; ?>
<?php include "session.php"; ?>
<?php
if(!empty($_SESSION['id']) && $_SESSION['user_role'] == 1 ){
    ?>
    <body id="LoginForm">
    <?php include "nav.php";?>
    <div class="container large-heading-margin-top fixed-min-height1">
        <div class="login-form">
            <div class="main-div">
                <div class="panel">
                    <h2>Admin Change Password</h2>
                    <p>Change Password</p>
                </div>
                <form id="Login">
                    <div class="form-group">
                        <input type="password" class="form-control" id="pass" placeholder="Old password">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="passA" placeholder="Type New Password">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="passB" placeholder="Confirm Password">
                    </div>
                    <div class="forgot">
                        <!--                    <a href="forgot.php">Forgot password?</a>-->
                        <br>
                        <span class="text-danger" id="error"></span>
                    </div>
                    <button type="button" class="btn btn-primary" id="changePassword">Change password</button>
                    <span class="text-danger" id="error"></span>
                </form>
            </div>
        </div>
    </div>
    <script>
        $("#changePassword").click(function () {
            var oldP = $("#pass").val();
            var passA = $("#passA").val();
            var passB = $("#passB").val();
            if(passA == passB){
                var data = { "passA": passA, "passB": passB, "passold": oldP };
                $.ajax({
                    type: "GET",
                    url: 'function.php?select=change_password',
                    data: data,
                    success: function (data) {
                        console.log(data);
                        if(data.message == "success"){
                            swal("Password Changed", "Your password has been changed", "success");
                            setTimeout(myFunction, 2000);
                            function myFunction() {
                                location.assign("login.php");
                            }
                        }
                        else if(data.message == "fails"){
                            swal("Sorry", "Error please try again", "error");
                        }
                        else if(data.message == "wrong"){
                            swal("Sorry", "You enter wrong password", "error");
                        }
                        else {
                            swal("Sorry", "something went wrong", "error");
                        }
                    }
                });
            }
            else{
                swal("Sorry", "password do not matched", "error");
            }
        });
    </script>
    </body>
    <?php
    include "footer.php";

}
else if(isset($_SESSION['secret'])){

if($_SESSION['secret'] == '594fe9cd56ba213c385ba5b92f752662d6485aa366d350be792ee82ef7c596eb'){
?>
<!-- navbar -->
<body id="LoginForm">
<?php include "nav.php";?>
<div class="container large-heading-margin-top fixed-min-height1">
    <div class="login-form">
        <div class="main-div">
            <div class="panel">
                <h2>Presiding officer Change Password</h2>
                <p>Please enter your new Password</p>
            </div>
            <form id="Login">
                <div class="form-group">
                    <input type="password" class="form-control" id="pass1" placeholder="Type New Password">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="pass2" placeholder="Confirm Password">
                </div>
                <div class="forgot">
                    <!--                    <a href="forgot.php">Forgot password?</a>-->
                    <br>
                    <span class="text-danger" id="error"></span>
                </div>
                <button type="button" class="btn btn-primary" id="change_password">Change password</button>
                <span class="text-danger" id="error"></span>
            </form>
        </div>
    </div>
</div>
<script>
    $("#change_password").click(function () {
        var pass1 = $('#pass1').val();
        var pass2 = $('#pass2').val();
        var data = { "pass1": pass1, "pass2": pass1 };
        if(pass1 === pass2) {
            $.ajax({
                type: "GET",
                url: 'function.php?select=changePassword',
                data: data,
                success: function(data){
                    if(data.message == "success"){
                        swal("Request", "Your Password is changed successfully you can login with new password", "success");
                        setTimeout(myFunction, 3000);

                        function myFunction() {
                            location.assign("login.php");
                        }
                    }
                    else if(data.message == "fails"){
                        swal("Sorry", "You can try after sometime", "error");
                    }
                    else{
                        swal("Sorry", "Somthing went wrong", "error");
                    }
                }
            });
        }else{
            swal("Sorry", "password do not matched", "error");
        }
    });


</script>
<?php include "footer.php";
}
else{
    echo "you are not authorise to perform this acton";
}
}
else{
    echo "you are not authorise to perform this acton";
}
?>
</body>
