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


// ----------------update status----------------


    // county
    function upate_status(e){
        var data = { "id": e };
        $.ajax({
            type: "GET",
            url: 'function.php?select=countyStatus',
            data: data,
            success: function(data){
                if(data.message == "success"){
                    swal("Status Updated", "County Status is Updated", "success")
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

    // District
    function upate_status_d(e){
        var data = { "id": e };
        $.ajax({
            type: "GET",
            url: 'function.php?select=upate_status_d',
            data: data,
            success: function(data){
                if(data.message == "success"){
                    swal("Status Updated", "District Status is Updated", "success")
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

    //precinct
    function upate_status_p(e) {
        var data = { "id": e };
        $.ajax({
            type: "GET",
            url: 'function.php?select=upate_status_p',
            data: data,
            success: function(data){
                if(data.message == "success"){
                    swal("Status Updated", "Precinct Status is Updated", "success")
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

    //polling
    function upate_status_po(e) {
        var data = { "id": e };
        $.ajax({
            type: "GET",
            url: 'function.php?select=upate_status_po',
            data: data,
            success: function(data){
                if(data.message == "success"){
                    swal("Status Updated", "Pooling Status is Updated", "success")
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

// ---------------------end update status----------------

// --------------------update Call---------------------------

    //county
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
    //District
    function district_update(e) {
        var data = { "id": e };
        $.ajax({
            type: "GET",
            url: 'function.php?select=district_update',
            data: data,
            success: function (data) {
                $('#myModal').modal('show');
                console.log(data);
                $("#iddistrict").val(data.id);
                $("#inputMarea").val(data.magisterial_area);
                $("#inputDistrictName").val(data.district_name);
                $("#no_pre").val(data.precincts);
                $("#no_poll").val(data.polling_places);

            }
        });
    }
    //precinct
    function precinctUpdate(e) {
        var data = { "id": e };
        $.ajax({
            type: "GET",
            url: 'function.php?select=precinct_update',
            data: data,
            success: function (data) {
                $('#myModal').modal('show');
                $("#idpre").val(data.id);
                $("#prename").val(data.precinct_name);
                $("#address").val(data.precinct_address);


            }
        });
    }

    function polling_update(e) {
        var data = { "id": e };
        $.ajax({
            type: "GET",
            url: 'function.php?select=polling_update',
            data: data,
            success: function (data) {
                $('#myModal').modal('show');
                $("#idpoll").val(data.id);
                $("#inputName").val(data.polling_placeName);
                $("#address").val(data.polling_placeAddress);

            }
        });
    }

// ------------------End update call--------------



//------------------ update section ------------
    //county
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
    //district
    function districtUpdate() {
        var id =  $("#iddistrict").val();
        var MArea =  $("#inputMarea").val();
        var D_name =  $("#inputDistrictName").val();
        var pre =  $("#no_pre").val();
        var poll =  $("#no_poll").val();

        var data = {"id": id, "D_name": D_name, "M_area": MArea, "pre": pre, "poll": poll };

        $.ajax({
            type: "GET",
            url: 'function.php?select=districtUpdate',
            data: data,
            success: function (data) {
                if(data.message == "success"){
                    swal("District Updated", "District is Updated Successfully", "success")
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
    // precinct
    function update_Precinct() {
        var id =  $("#idpre").val();
        var pre_name =  $("#prename").val();
        var address =  $("#address").val();

        var data = {"id": id, "pre_name": pre_name, "address": address };

        $.ajax({
            type: "GET",
            url: 'function.php?select=precinctUpdate',
            data: data,
            success: function (data) {
                if(data.message == "success"){
                    swal("Precinct Updated", "Precinct is Updated Successfully", "success")
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

    function update_polling() {
        var id =  $("#idpoll").val();
        var p_name =  $("#inputName").val();
        var address =  $("#address").val();

        var data = {"id": id, "p_name": p_name, "address": address };

        $.ajax({
            type: "GET",
            url: 'function.php?select=pollingUpdate',
            data: data,
            success: function (data) {
                if(data.message == "success"){
                    swal("Polling Place Updated", "Polling Place is Updated Successfully", "success")
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

// ------------End Update Section--------------------

// ---------------- Add Section ------------
    //district
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

    //polling
    function addNewPolling() {
        var county = $(".county_id:selected").val();
        var district = $(".district_id:selected").val();
        var precint = $(".precinct_id:selected").val();
        var name = $("#polling_name").val();
        var address = $("#address").val();
        if(name == '') {
            swal("Enter Name of polling place", "Polling Place Name Field is empty please fill it");
        }
        else if (address == ''){
            swal("Enter Address", "Address of polling place field is empty please fill it");
        }
        else{
            var data = {"county": county, "district": district, "precinct": precint, "name": name, "address": address};
            $.ajax({
                type: "GET",
                url: "function.php?select=pollingAdd",
                data: data,
                success: function (data) {
                    if(data.message == "success"){
                        swal("Polling Place Added", "Polling Place is Added successfully !", "success")
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

    }

// ---------------End Add Section ----------------


// -----------Filters----------
    // get districts
    $('.county_select').on('change', function() {
        var id =  this.value ;
        // alert(id);
        data = { "id": id };
        $.ajax({
            type: "GET",
            url: "function.php?select=filterDistrict",
            data: data,
            success: function (data) {

                if(data.no == 'fails'){
                        var html = '<option>No Record</option>'
                }
                else{
                    var html  = '<option selected disabled>Select District</option>';
                    $.each(data, function(key,value){
                        html+= '<option class="district_id" value="'+value.id+'">'+value.district_name+'</option>';
                    });

                }
                        $('#inlineFormCustomSelect1').html(html);

                // $.each(data, function (key,val) {
                //     console.log(key+val);
                // })

                // $(".district_select").html('<option class="district_id" value="'+data.id+'">'+data.district_name+'</option>');

            }
        });
    });

    $('.district_filter').on('change', function() {
    var id =  this.value ;
    // alert(id);
    data = { "id": id };
    $.ajax({
        type: "GET",
        url: "function.php?select=filterPrecinct",
        data: data,
        success: function (data) {

            if(data.no == 'fails'){
                var html = '<option>No Record</option>'
            }
            else{
                var html  = '';
                var html  = '<option selected disabled>Select Precinct</option>';
                $.each(data, function(key,value){
                    html+= '<option class="precinct_id" value="'+value.id+'">'+value.precinct_name+'</option>';
                });

            }
            $('.precinct_select').html(html);

            // $.each(data, function (key,val) {
            //     console.log(key+val);
            // })

            // $(".district_select").html('<option class="district_id" value="'+data.id+'">'+data.district_name+'</option>');

        }
    });
});


// ----------Filters End--------


