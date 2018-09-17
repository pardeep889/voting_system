<?php
include "header.php";
include "nav.php";
include "session.php";
if(!empty($_SESSION['id']) && $_SESSION['user_role'] == 3 ) {
    $unique = $_GET['id'];
           // $sql = "SELECT * FROM vs_voters where voter_uniqueID = '$unique'";
$sql = "SELECT u.id,u.voter_barcode,u.voter_photo,u.voter_address,u.voter_email,u.voter_contactNO,u.center_code,u.center_address,u.voter_status,u.voter_uniqueID,c.county_name,d.district_name,p.precinct_name,po.polling_placeName,u.voter_name,u.voter_gender,u.voter_verifyStatus,u.voter_ballotNO,u.voter_age,c.id as county_id, d.id as district_id, p.id as precinct_id, po.id as polling_placeID FROM vs_voters u
                    INNER JOIN vs_county c on c.id = u.county_id
                    INNER JOIN vs_district d on d.id = u.district_id
                    INNER JOIN vs_precincts p on p.id = u.precinct_id
                    INNER JOIN vs_polling po on po.id = u.polling_placeID
                    where u.voter_uniqueID = '$unique'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $data =  $row['voter_photo'];
    // echo json_encode($row);
    // header("Content-type: image/gif");
    $str2 = substr($data, 23);
    // echo $str2;

    ?>

    <div class="container">
    <h2 class="text-center large-heading-margin-top">Update Voter</h2>
      <!-- <div class="voter_snap text-center">
        <?php
          // echo '<img src="data:image/jpeg;base64,'.($str2).'"/>';
        ?>
        <br> <br>
        <a class="btn btn-warning" href="uploadSnap.php?unique=<?php // echo $unique; ?>">Update Snap </a>
      </div> -->
        <form>
            <div class="form-group">
                <label>Select County</label>
                <select class="form-control mr-sm-2 county_select" id="inlineFormCustomSelect" style="color:#337ab7;  font-weight: bold;">
                    <option disabled>Select County</option>
                    <option selected class="county_id" value="<?php echo $row['county_id']; ?>"><?php echo $row['county_name']; ?></option>
                    <?php $county_sql = "SELECT id,county_name FROM vs_county WHERE id != '$row[county_id]'";
                            $res_c = $conn->query($county_sql);
                            if ($res_c->num_rows > 0) {
                                while($rowc = $res_c->fetch_assoc()){
                                    ?>
                                  <option class="county_id" value="<?php echo $rowc['id']?>"><?php echo $rowc['county_name']; ?></option>
                                    <?php
                                }
                            }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Select District</label>
                <input type="hidden" value="<?php echo $row['voter_uniqueID']; ?>" id="unique">
                <select class="form-control mr-sm-2 district_select" id="inlineFormCustomSelect1" style="color:#337ab7;  font-weight: bold;">
                    <option disabled>Select District</option>
                    <option selected class="district_id" value="<?php echo $row['district_id']; ?>"><?php echo $row['district_name']; ?></option>
                </select>
            </div>
            <div class="form-group">
                <label>Select Precinct </label>
                <select class="form-control mr-sm-2 precinct_select" id="inlineFormCustomSelect2" style="color:#337ab7;  font-weight: bold;">
                    <option disabled>Select Precinct</option>
                    <option selected class="precinct_id" value="<?php echo $row['precinct_id']; ?>"><?php echo $row['precinct_name']; ?></option>
                </select>
            </div>
            <div class="form-group">
                <label>Select Polling Place</label>
                <select class="form-control mr-sm-2" id="inlineFormCustomSelect3" style="color:#337ab7;  font-weight: bold;">
                    <option disabled>Select Polling Place</option>
                    <option selected class="pol_id" value="<?php echo $row['polling_placeID']; ?>"><?php echo $row['polling_placeName']; ?></option>
                </select>
            </div>
            <div class="form-group">
                <label>Center Code</label>
                <input type="text" class="form-control" value="<?php echo $row['center_code'];   ?>" id="center_code">
            </div>
            <div class="form_group">
                <label>Center Address</label>
                <textarea id="center_address" class="form-control"><?php echo $row['center_address'] ?></textarea>
            </div>

            <div class="form-group">
                <label>Voter Name</label>
                <input type="text" class="form-control" value="<?php echo $row['voter_name'] ?>" id="voter_name">
            </div>
            <div class="form-group">
                <label class="mr-sm-2" for="inlineFormCustomSelect">Select Gender</label>
                <select  class="form-control voter_gender" required>
                    <?php if($row['voter_gender'] == 'male') {
                      ?>
                    <option class="voter_gender" value="<?php echo $row['voter_gender']; ?>" selected><?php  echo $row['voter_gender'];?> </option>
                    <option class="voter_gender" value="female">Female</option> <?php
                  }else {
                    ?>
                      <option class="voter_gender" value="<?php echo $row['voter_gender']; ?>" ><?php  echo $row['voter_gender'];?> </option>
                      <option class="voter_gender" value="male">Male</option> <?php
                  }
                  ?>

                </select>
            </div>
            <div class="form-group">
                <label>Voter Age</label>
                <input type="number" min="12" class="form-control" value="<?php echo $row['voter_age'] ?>" id="voter_age">
            </div>
            <div class="form-group">
              <label>Voter Email</label>
                <input type="text" class="form-control" value="<?php echo $row['voter_email'] ?>" id="email">
            </div>
            <div class="form-group">
                <label>Contact Number</label>
                <input type="text" class="form-control" value="<?php echo $row['voter_contactNO'] ?>" id="number">
            </div>
            <div class="form_group">
              <label>Voter Address</label>
                <textarea id="voter_address" class="form-control"><?php echo $row['voter_address'] ?></textarea>
            </div>
            <div class="form-group">
                <label>Barcode</label>
                <input type="text" class="form-control" value="<?php echo $row['voter_barcode'] ?>" id="barcode">
            </div>
            <div class="form_group">
            <br>
              <input type ='button' class="btn btn-warning" onclick="update_voter()" value="Update Voter">
              <a href="show_voter.php?id=<?php echo $unique; ?>" class="btn btn-danger">Go back</a>
            </div>
        </form>
    </div>
    <script type="text/javascript">
    function update_voter(){
      var unique = $("#unique").val();
    var  c_id = $(".county_id:selected").val();
    var  d_id = $(".district_id:selected").val();
    var  p_id = $(".precinct_id:selected").val();
    var  pol_id = $(".pol_id:selected").val();
    var center = $("#center_code").val();
    var center_address = $("#center_address").val();
    var name = $("#voter_name").val();
    var  gender = $(".voter_gender:selected").val();
    var voter_age = $("#voter_age").val();
    var email = $("#email").val();
    var number = $("#number").val();
    var voter_address = $("#voter_address").val();
    var voter_barcode = $("#barcode").val();
    // alert(c_id+d_id+p_id+pol_id+center+center_address+name+gender+voter_age+email+number+voter_address);
    var data = { "unique": unique,"c_id": c_id, "d_id": d_id, "p_id": p_id, "pol_id":pol_id, "center": center, "center_address": center_address, "name": name,
                  "gender": gender, "voter_age": voter_age, "email": email, "number": number, "voter_address": voter_address, "barcode": voter_barcode  };

      if(d_id == null){
          swal("Please select District");
      }else if (p_id == null) {
          swal("Please select Precinct");
      }else if (pol_id == null) {
          swal("Please Select Polling Place");
      }
      else if (name == '') {
          swal("Please Enter Voter Name ");
      }else if (gender == '') {
            swal("Please Select Gender ");
      }
      else if (voter_age == '') {
            swal("Please Enter Voter Age ");
      }else if (number == '') {
              swal("Please Enter Voter Mobile Number ");
      }else if (voter_address == '') {
              swal("Please Enter Voter Address");
      }else{
        // alert("success");
        $.ajax({
                type: "GET",
                url: "function.php?select=update_voter",
                data: data,
                success: function(data){
                  if(data.message == "success"){
                        swal("Voter is Updated", "Voter Information is Updated successfully !", "success")
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

    $('.county_select').on('change', function() {
      $('#inlineFormCustomSelect2').find('option').remove().end().append('<option value="0">Select Precinct</option>').val('0');
      $('#inlineFormCustomSelect3').find('option').remove().end().append('<option value="0">Select Polling Place</option>').val('0');

       var id =  this.value ;
       var data = {"id":id};
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
           }
       });
   });

   $('.district_select').on('change', function() {
      var id =  this.value ;
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
           $('#inlineFormCustomSelect2').html(html);
         }
       });
    });
    $('.precinct_select').on('change', function() {
       var id =  this.value ;
       data = { "id": id };
    $.ajax({
        type: "GET",
        url: "function.php?select=filterPolling",
        data: data,
        success: function (data) {
            if(data.no == 'fails'){
                var html = '<option>No Record</option>'
            }
            else{
                var html  = '';
                var html  = '<option selected disabled>Select Polling Place</option>';
                $.each(data, function(key,value){
                    html+= '<option class="pol_id" value="'+value.id+'">'+value.polling_placeName+'</option>';
                });
            }
            $('#inlineFormCustomSelect3').html(html);
          }
        });
     });
    </script>
    <?php
}
    include "footer.php";
}
else{
    header("location: login.php");
}
    ?>
