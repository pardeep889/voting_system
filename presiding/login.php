<?php include "header.php"; ?>
  <!-- navbar -->
<body id="LoginForm">
  <?php include "nav.php";?>
<div class="container">
<div class="login-form">
<div class="main-div">
    <div class="panel">
   <h2>Presiding officer Login</h2>
   <p>Please enter your username and password</p>
   </div>
    <form id="Login">
        <div class="form-group">
            <input type="text" class="form-control" id="inputUsername" placeholder="Username">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" id="inputPassword" placeholder="Password">
        </div>
        <div class="forgot">
        <a href="forgot.php">Forgot password?</a>
        <br>
        <span class="text-danger">Please enter valid username or password</span>
        </div>
        <button type="button" class="btn btn-primary" id="login_button">Login</button>
    </form>
    </div>
<p class="botto-text"> </p>
</div></div></div>
<script type="text/javascript">
   $("#login_button").click(function(){
     var username = $("#inputUsername").val();
     var password = $("#inputPassword").val();
     var data = { "username":  username, "password": password };
            $.ajax({
			                type: "GET",
			                url: 'function.php?select=login',
			                data: data,
			                success: function(data){
                        console.log(data);
                      }
                    });
   });


</script>
  <?php include "footer.php"; ?>
</body>
