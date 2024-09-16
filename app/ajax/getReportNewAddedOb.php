<?php
include "../../connection/connection.php";
if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
}

$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$id_oblast = isset($_POST['id_oblast']) ? $_POST['id_oblast'] : null;
$id_type_oborudovanie = isset($_POST['id_type_oborudovanie']) ? $_POST['id_type_oborudovanie'] : null;


$sql = "SELECT 
    ob.* , 
    uz.*, 
    type_oborudovanie.*, 
    servicemans.*,
       uz.name as uzname,
       type_oborudovanie.name as typename

FROM 
    oborudovanie ob
JOIN 
    uz ON ob.id_uz = uz.id_uz
LEFT JOIN 
    type_oborudovanie ON ob.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
LEFT JOIN 
    servicemans ON ob.id_serviceman = servicemans.id_serviceman
WHERE 
    ob.date_create BETWEEN '$startDate' AND '$endDate'";

$conditions = [];

if ($id_oblast && $id_oblast != '0') {
    $conditions[] = "uz.id_oblast = '$id_oblast'";
}

if ($id_type_oborudovanie && $id_type_oborudovanie != '0') {
    $conditions[] = "ob.id_type_oborudovanie = '$id_type_oborudovanie'";
}
if (count($conditions) > 0) {
    $sql .= " AND " . implode(" AND ", $conditions);
}


$output = ' <table class="table table-striped table-responsive-sm dataTable no-footer" id="table_report1"
                           style="display: block">
                        <thead>
                        <tr>
                            <th>Организация</th>
                            <th>Вид оборудования</th>
                            <th>Дата создания записи</th>

                        </tr>
                        </thead>
                        <tbody>';
$result = $connectionDB->executeQuery($sql);
if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>";
        $output .= "<td>" . $row['uzname'] . "</td>";
        $output .= "<td>" . $row['typename'] . "</td>";
        $output .= "<td>" . $row['date_create'] . "</td>";
        $output .= "</tr>";
    }
}
else {
    $output .= "<tr><td colspan='3' style='text-align:center;'>Нет данных</td></tr>";
}

$output .= "</tbody></table>";
echo $output;
?>