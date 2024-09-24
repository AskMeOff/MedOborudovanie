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
       type_oborudovanie.name as typename,
              ob.date_create as dcr,
       ob.date_insert_ob as dto

FROM 
    oborudovanie ob
JOIN 
    uz ON ob.id_uz = uz.id_uz
LEFT JOIN 
    type_oborudovanie ON ob.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
LEFT JOIN 
    servicemans ON ob.id_serviceman = servicemans.id_serviceman
WHERE 1=1";

if (!empty($startDate) && !empty($endDate)) {
    $startDateTime = new DateTime($startDate);
    $endDateTime = new DateTime($endDate);
    $endDateTime->modify('+1 day');
    $endDate = $endDateTime->format('Y-m-d');
    $sql .= " AND ob.date_insert_ob >= '$startDate' AND ob.date_insert_ob <= '$endDate'";
}


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
                            <th>Год производства</th>
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
        $output .= "<td>" . $row['dcr'] . "</td>";
        $output .= "<td>" . $row['dto'] . "</td>";
        $output .= "</tr>";
    }
}
else {
    $output .= "<tr><td colspan='3' style='text-align:center;'>Нет данных</td></tr>";
}

$output .= "</tbody></table>";
echo $output;
?>