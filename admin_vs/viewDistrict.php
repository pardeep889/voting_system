<?php
    include "session.php";
    include "../db/conn.php";
    if (!empty($_SESSION['id']) && $_SESSION['user_role'] == 1){
        $sql = "SELECT * FROM vs_district WHERE status < 2";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo json_encode($row);
            }
        } else {
            echo "0 results";
        }
        $conn->close();
    }

?>

