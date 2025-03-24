<?php
include '../../connection/connection.php';
$currentYear = date("Y");
$currentMonth = date("n");
$sqlstring = "";
$koefMonth = 1;

for ($i = 1; $i <= $currentMonth; $i++ )
{
    $sqlstring .= "c_". $i. ",";
}
$sqlstring = rtrim($sqlstring, ",");

$query = "SELECT c_$currentMonth as cmont, $sqlstring, res, next_year_res,cost_work  FROM b14_index where year =  $currentYear";
$result = mysqli_query($connectionDB->con, $query);
$array = explode(',', $sqlstring);
$i = 0;
if ($result && mysqli_num_rows($result) > 0) {

    $row = mysqli_fetch_assoc($result);
    if ($row['cmont'] == 1)
    {
        $koefMonth = 1;
    }else {
        for ($i = 1; $i < count($array); $i++) {
            $koefMonth *= floatval(str_replace(',', '.', $row[$array[$i]]));
            $koefMonth = round($koefMonth, 4);
        }
    }



    echo json_encode(['success' => true, 'params' => $row, 'koefMonth' => $koefMonth ] );
} else {
    echo json_encode(['success' => false, 'error' => 'Error getting parameters']);
}
?>