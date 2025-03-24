<?php
include '../../connection/connection.php';
$typeW = $_POST['typeW'] ?? '';
$myAr = json_decode($_POST['myAr']);
$partSql = '';
$flag = true;
if (count($myAr) > 1){
    $partSql = 'konstr = '. $myAr[0];
    for($i = 1; $i < count($myAr); $i++){
        $partSql.= " or konstr = ". $myAr[$i];
    }
}else if(count($myAr) == 1){
    $partSql = 'konstr = '. $myAr[0];
}else{
    $flag = false;
}
if($flag) {
    $query = "SELECT * FROM table2_4 where ($partSql) and vid = '$typeW' ";

    $result = mysqli_query($connectionDB->con, $query);
    $myarray = array();
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($myarray, $row['koef']/100);
        }
    }
    echo json_encode($myarray);
}else{
    echo 1;
}


?>