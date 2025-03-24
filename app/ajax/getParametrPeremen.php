<?php
include '../../connection/connection.php';

$query = "SELECT * FROM parametr_peremen";
$result = mysqli_query($connectionDB->con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    echo json_encode(['success' => true, 'params' => $row]);
} else {
    echo json_encode(['success' => false, 'error' => 'Error getting parameters']);
}
?>