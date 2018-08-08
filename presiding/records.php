<?php
include "../db/conn.php";
include "session.php";
include "header.php";
include "nav.php";

if(!empty($_SESSION['id']) && $_SESSION['user_role'] == 3 ) {
    ?>
    <div class="container">
        <h3 class="large-heading-margin-top text-center">Showing All Voters</h3>
    <div class="table-responsive fixed-min-height pre_background box-table">
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Voter name</th>
                <th>Age</th>
                <th>Gender</th>
                <th></th>
                <th>Country</th>
                <th>Gender</th>
                <th>Example</th>
                <th>Example</th>
                <th>Example</th>
                <th>Example</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>Anna</td>
                <td>Pitt</td>
                <td>35</td>
                <td>New York</td>
                <td>USA</td>
                <td>Female</td>
                <td>Yes</td>
                <td>Yes</td>
                <td>Yes</td>
                <td>Yes</td>
            </tr>
            </tbody>
        </table>

    </div>
    </div>


<?php
}
else{
    header('location: login.php');
}


include "footer.php";
