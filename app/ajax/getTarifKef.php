<?php
include '../../connection/connection.php';
$pp = $_POST['inputValue'] ?? '';

if (empty($pp)) {
   echo 1;
} else {
    if ($pp >=9 || $pp <= 18.9) {
        $query = "SELECT ki FROM tarifs where p =$pp ";
        $result = mysqli_query($connectionDB->con, $query);
        $row = mysqli_fetch_assoc($result);
        echo $row['ki'];
    }
    else {
        echo "";
    }
}

?>