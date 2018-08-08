<?php
include "header.php";
include "nav.php";
include "session.php";
if(!empty($_SESSION['id']) && $_SESSION['user_role'] == 3 ){
    ?>
    <script type="text/javascript">
        // $(document).ready(function(){
        //   swal("Hello world!");
        // });
    </script>
    <div class="container">
        <h2 class="text-center large-heading-margin-top">Add New Voter</h2>
        <div class="pre_background box-form">
            <form class="form" action="register.php" method="post">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Country Name <span class="text-danger">*</span></label>
                            <input type="text" name="county_name" class="form-control" required>
                        </div>

                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Center Code <span class="text-danger">*</span></label>
                            <input type="text" name="center_code" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Voter Name <span class="text-danger">*</span></label>
                            <input type="text" name="voter_name" class="form-control" required>
                        </div>

                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="mr-sm-2" for="inlineFormCustomSelect">Select Gender<span class="text-danger">*</span></label>
                            <select name="voter_gender" class="form-control" id="inlineFormCustomSelect" required>
                                <option value="male" selected>Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="age">Voter Age <span class="text-danger">*</span></label>
                            <input type="text" name="voter_age" class="form-control" required>
                        </div>

                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Voter Email <span class="text-danger">*</span></label>
                            <input type="email" name="voter_email" class="form-control" required>
                        </div>

                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Voter Address <span class="text-danger">*</span></label>
                            <textarea name="voter_address" rows="3" cols="80" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Voter Contact No <span class="text-danger">*</span></label>
                            <input type="text" name="voter_contact_no" class="form-control" required>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Take Photo</label>
                            <input type="text" name="voter_photo" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Scan Barcode</label>
                            <input type="text" name="voter_barcode" class="form-control">
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Insert Record</label> <br>
                            <input type="submit" class="btn btn-dark" value="Add new voter">
                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>
    <?php
}
else{
    header("location: login.php");
}
?>
<?php
include "footer.php";
// }

?>
