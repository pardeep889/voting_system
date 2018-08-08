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

function logout(){
      var data  = { "data": "logout"};
         $.ajax({
                   type: "POST",
                   url: 'function.php?select=logout',
                   data: data,
                   success: function(data){
                      if(data == "success"){
                        location.assign("login.php");
                      }
                     }
                 });
}

function show_voter(unique_id) {
    var data = { "data": unique_id };
    $.ajax({
        type: "GET",
        url: 'function.php?select=show_voter',
        data: data,
        success: function (data) {
            $('#myModal').modal('show');
            console.log(data);
        }
    });
}