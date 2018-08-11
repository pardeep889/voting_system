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

$(document).ready(function() {
    $('#example').DataTable();
} );

function upate_status(e){
    var data = { "id": e };
    $.ajax({
        type: "GET",
        url: 'function.php?select=countyStatus',
        data: data,
        success: function(data){
            if(data.message == "success"){
                swal("Status Update", "County Status is Updated", "success")
                    .then((value) => {
                         if(value == ""){
                             location.reload();
                         } else{
                             location.reload();
                         }
                    });

            }else{
                swal("Error", "Something Went wrong", "error");
            }
        }
    });
}
function county_update(e) {
    var data = { "id": e };
    $.ajax({
        type: "GET",
        url: 'function.php?select=countyUpdate',
        data: data,
        success: function (data) {
            $('#myModal').modal('show');
            // console.log(data);
            $("#idcounty").val(data.id);
            $("#inputCountyName").val(data.county_name);
        }
    });
}

function countyUpdateName() {
    var name =  $("#inputCountyName").val();
    var id =  $("#idcounty").val();

    var data = { "name": name, "id": id };
    $.ajax({
        type: "GET",
        url: 'function.php?select=countyUpdateName',
        data: data,
        success: function (data) {
            if(data.message == "success"){
                swal("County Update", "County Name is Updated", "success")
                    .then((value) => {
                        if(value == ""){
                            location.reload();
                        } else{
                            location.reload();
                        }
                    });

            }else{
                swal("Error", "Something Went wrong", "error");
            }

        }
    });
}


function addNewDistrict() {
    // var id = $("#county_id").val();
    var id = $(".county_id:selected"). val();
    var meg_area =  $("#m_area").val();
    var d_name=  $("#District").val();
    var no_pre = $("#no_pre").val();
    var no_poll =  $("#no_poll").val();
    if(meg_area == '') {
        swal("Enter Magisterial Area first", "Magisterial Area Field is empty please fill it");
    }
    else if(d_name == ""){
        swal("Enter District Name First", "District Area field is empty please fill it");
    }
    else if (no_poll == "" ){
        swal("Please Enter no of polling center", "You need to enter number of polling centers in the district");
    }
    else if (no_pre == ''){
        swal("Please Enter no of Precincts", "You need to enter number of precincts");
    }
    else {
        var data = { "id": id, "meg_area": meg_area, "dname": d_name, "pre": no_pre, "poll": no_poll };
        $.ajax({
            type: "GET",
            url: "function.php?select=districtAdd",
            data: data,
            success: function (data) {
                if(data.message == "success"){
                    swal("District Added", "District is Added successfully !", "success")
                        .then((value) => {
                            if(value == ""){
                                location.reload();
                            } else{
                                location.reload();
                            }
                        });

                }else{
                    swal("Error", "Something Went wrong", "error");
                }
            }
        });

    }



    // alert(id);
}