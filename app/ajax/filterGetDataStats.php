<?php
include "../../connection/connection.php";


$equipment = isset($_POST['equipment']) ? $_POST['equipment'] : '';
$oblast = isset($_POST['oblast']) ? $_POST['oblast'] : '';
$stat = isset($_POST['stat']) ? $_POST['stat'] : '';




$sql = "SELECT 
    type_oborudovanie.name AS typename, 
    o.name AS oblast_name, 
    COUNT(oborudovanie.id_oborudovanie) AS quantity 
FROM oborudovanie
JOIN uz ON oborudovanie.id_uz = uz.id_uz
LEFT JOIN type_oborudovanie ON oborudovanie.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
LEFT JOIN servicemans ON oborudovanie.id_serviceman = servicemans.id_serviceman
LEFT JOIN oblast o ON uz.id_oblast = o.id_oblast";


$where_conditions = [];


if (!empty($equipment)) {
    $where_conditions[] = "type_oborudovanie.name LIKE '%" . $connectionDB->escapeString($equipment) . "%'";
}

if (!empty($oblast)) {
    $where_conditions[] = "o.name LIKE '%" . $connectionDB->escapeString($oblast) . "%'";
}

if (!empty($stat)) {
    $statArray = explode(',', $connectionDB->escapeString($stat));
    $statList = implode(',', $statArray);
    $where_conditions[] = "oborudovanie.status IN ($statList)";
}


if (count($where_conditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $where_conditions);
}


$sql .= " GROUP BY type_oborudovanie.name, o.name";




$result = $connectionDB->executeQuery($sql);


$output = '<div class="table-responsive">
                        <table class="table table-striped table-responsive-sm dataTable no-footer" id="table_report1"
                               style="display: none">
                            <thead>                    
                                <tr>
                                <th>Вид оборудования</th>
                                <th>Область</th>
                                <th>Кол-во(шт.)</th>
                            </tr>
                            </thead>
                            <tbody>';

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>";
        $output .= "<td>" . htmlspecialchars($row['typename']) . "</td>";
        $output .= "<td>" . htmlspecialchars($row['oblast_name']) . "</td>";
        $output .= "<td>" . intval($row['quantity']) . "</td>";
        $output .= "</tr>";
    }
}

$output .= '  </tbody></table></div>';

echo $output;
?>
