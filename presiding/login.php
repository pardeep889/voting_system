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
            <span class="text-danger" id="error"></span>
            </div>
            <button type="button" class="btn btn-primary" id="login_button">Login</button>
        </form>
      </div>
      <p class="botto-text"> </p>
  </div>
</div>
  <script>
      $("#login_button").click(function(){
          var username = $("#inputUsername").val();
          var password = $("#inputPassword").val();
          var data = { "username":  username, "password": password };
          $.ajax({
              type: "GET",
              url: 'function.php?select=login',
              data: data,
              success: function(data){
                  if(data == 'fails'){
                      $("#error").text("Please enter valid username or password");
                  }
                  else if (data == 'success') {
                      location.assign("pre_dashboard.php");
                  }
                  else{
                      alert("something went wrong");
                  }
              }
          });
      });

  </script>
  <?php include "footer.php"; }?>
</body>
