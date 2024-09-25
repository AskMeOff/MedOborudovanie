<?php
include "../../connection/connection.php";
if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
}
$start_year = isset($_POST['start_year']) ? intval($_POST['start_year']) : null;
$end_year = isset($_POST['end_year']) ? intval($_POST['end_year']) : null;

$sql = "SELECT 
    type_oborudovanie.id_type_oborudovanie,
    type_oborudovanie.name AS typename,
    oblast.name AS oblast_name, 
    COUNT(ob.id_oborudovanie) AS quantity
FROM 
    oborudovanie ob
JOIN 
    uz ON ob.id_uz = uz.id_uz
LEFT JOIN 
    type_oborudovanie ON ob.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
LEFT JOIN 
    servicemans ON ob.id_serviceman = servicemans.id_serviceman
LEFT JOIN 
    oblast ON uz.id_oblast = oblast.id_oblast";

$where_conditions = [];
if ($start_year && $end_year) {
    $where_conditions[] = "YEAR(ob.date_create) BETWEEN $start_year AND $end_year";
}

if (count($where_conditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $where_conditions);
}

$sql .= " GROUP BY 
    type_oborudovanie.id_type_oborudovanie, 
    type_oborudovanie.name, 
    oblast.name
ORDER BY 
    oblast.name ASC";




$output = ' <table class="table table-striped table-responsive-sm dataTable no-footer" id="table_report1"
                           style="display: block">
                        <thead>
                        <tr>
                            <th>Вид оборудования</th>
                            <th>Область</th>
                            <th>Кол-во(шт.)</th>

                        </tr>
                        </thead>
                        <tbody>';
$result = $connectionDB->executeQuery($sql);
if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>";
        $output .= "<td>" . $row['typename'] . "</td>";
        $output .= "<td>" . $row['oblast_name'] . "</td>";
        $output .= "<td>" . $row['quantity'] . "</td>";
        $output .= "</tr>";
    }
}
else {
    $output .= "<tr><td colspan='3' style='text-align:center;'>Нет данных</td></tr>";
}

$output .= "</tbody></table>";
echo $output;
echo "<hr><br><br><br>";

$sql_total = "SELECT 
    type_oborudovanie.id_type_oborudovanie,
    type_oborudovanie.name AS typename,
    COUNT(ob.id_oborudovanie) AS total_quantity
FROM 
    oborudovanie ob
JOIN 
    uz ON ob.id_uz = uz.id_uz
LEFT JOIN 
    type_oborudovanie ON ob.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
WHERE 
    ob.status IN (0, 1)
GROUP BY 
    type_oborudovanie.id_type_oborudovanie, 
    type_oborudovanie.name
ORDER BY 
    type_oborudovanie.name ASC";

$result_total = $connectionDB->executeQuery($sql_total);
$output_total = '<h2>Общее количество оборудования по видам (Республика Беларусь):</h2>';
$output_total .= '<table class="table table-striped table-responsive-sm dataTable no-footer" id="table_total">
                    <thead>
                    <tr>
                        <th>Вид оборудования</th>
                        <th>Общее количество (шт.)</th>
                    </tr>
                    </thead>
                    <tbody>';

if ($result_total->num_rows > 0) {
    while ($row_total = $result_total->fetch_assoc()) {
        $output_total .= "<tr>";
        $output_total .= "<td>" . $row_total['typename'] . "</td>";
        $output_total .= "<td>" . $row_total['total_quantity'] . "</td>";
        $output_total .= "</tr>";
    }
} else {
    $output_total .= "<tr><td colspan='2' style='text-align:center;'>Нет данных</td></tr>";
}

$output_total .= "</tbody></table>";

echo $output_total;
?>
