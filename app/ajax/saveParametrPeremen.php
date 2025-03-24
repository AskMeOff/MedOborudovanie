<?php
include '../../connection/connection.php';
$director = $_POST['director'];
$iODirector = $_POST['iODirector'];
$currentIndex = $_POST['currentIndex'];
$nextIndex = $_POST['nextIndex'];
$usnValue = $_POST['usnValue'];
$ndsValue = $_POST['ndsValue'];
$workCost = $_POST['workCost'];
$b14Index = $_POST['b14Index'];
$currentYear = date("Y");
$currentMonth = date("n");

$query = "UPDATE parametr_peremen SET name_director = '$director', name_IOdirector = '$iODirector', 
          value_usn = '$usnValue', value_nds = '$ndsValue'";
$result = mysqli_query($connectionDB->con, $query);

$query = "UPDATE b14_index SET   res = '$currentIndex', next_year_res = '$nextIndex', 
        cost_work = '$workCost' where `year` = '$currentYear'";
$result = mysqli_query($connectionDB->con, $query);

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Error updating parameters']);
}
?>