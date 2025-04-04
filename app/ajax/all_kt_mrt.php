<?php
include "../../connection/connection.php";

echo '<table border="1">
<thead>
<th>
</th>
</thead>
<tbody>';
$countNevernoe = 0;

$sqlobl = 'SELECT id_oblast, name FROM oblast';
$resultobl = mysqli_query($connectionDB->con, $sqlobl);

while ($row = $resultobl->fetch_assoc()) {
    $count_obl = 0;
    echo '<tr><td style="font-size: 25px; font-weight: 800">' . $row['name'] . '</td></tr>';
    $id_oblast = $row['id_oblast'];

    $sql_type = 'SELECT o.id_oborudovanie, uz.name AS name_uz, t.name AS type_name, o.model, ob.name AS ob_name
                 FROM oborudovanie o
                 LEFT JOIN type_oborudovanie1 t ON o.id_type_oborudovanie = t.id_type_oborudovanie
                 LEFT JOIN uz uz ON o.id_uz = uz.id_uz
                 LEFT JOIN oblast ob ON ob.id_oblast = uz.id_oblast
                 WHERE ob.id_oblast = ' . $id_oblast . ' 
                 AND o.serial_number IS NOT NULL 
                 AND t.id_type_oborudovanie IN (12) 
                 AND o.status IN (0, 1, 3)';

    $resultobl_type = mysqli_query($connectionDB->con, $sql_type);

    while ($row1 = $resultobl_type->fetch_assoc()) {
        $type_name = $row1['type_name'] ?: 'Отсутствует тип';
        echo '<tr><td>' . $row1['name_uz'] . '</td><td>' . $type_name . '</td><td>' . $row1['model'] . '</td></tr>';
        $countNevernoe++;
        $count_obl++;
    }


    $sql_type = 'SELECT o.id_oborudovanie, uz.name AS name_uz, t.name AS type_name, o.model, ob.name AS ob_name
                 FROM oborudovanie o
                 LEFT JOIN type_oborudovanie1 t ON o.id_type_oborudovanie = t.id_type_oborudovanie
                 LEFT JOIN uz uz ON o.id_uz = uz.id_uz
                 LEFT JOIN oblast ob ON ob.id_oblast = uz.id_oblast
                 WHERE ob.id_oblast = ' . $id_oblast . ' 
                 AND o.serial_number IS NULL 
                 AND t.id_type_oborudovanie IN (12) 
                 AND o.status IN (0, 1, 3)';

    $resultobl_type = mysqli_query($connectionDB->con, $sql_type);

    while ($row1 = $resultobl_type->fetch_assoc()) {
        $type_name = $row1['type_name'] ?: 'Отсутствует тип';
        echo '<tr><td>' . $row1['name_uz'] . '</td><td>' . $type_name . '</td><td>' . $row1['model'] . '</td></tr>';
        $countNevernoe++;
        $count_obl++;
    }

    echo '<tr><td>' . $count_obl . '</td></tr>';
}

echo '</tbody>
</table>';
echo $countNevernoe;
?>