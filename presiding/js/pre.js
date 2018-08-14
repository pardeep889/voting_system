
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
            $("#voter_name").val(data.voter_name);
        }
    });
}