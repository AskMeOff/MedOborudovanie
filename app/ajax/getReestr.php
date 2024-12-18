<?php
include "../../connection/connection.php";

    $query = "SELECT * FROM reestr ";
    $result = $connectionDB->executeQuery($query);
$data = array();
    while($row = $result->fetch_assoc()){
        array_push($data , ['Наименование' => $row['Наименование']
            , 'Производитель' => $row['Производитель']
            , 'Рег_номер_товара' => $row['Рег_номер_товара']
            , 'Рег_номер_РУ' => $row['Рег_номер_РУ']
            , 'Тип' => $row['Тип']
            , 'N_п_п' => $row['N_п_п']
        ]);
    }
    echo json_encode($data);


$connectionDB->con->close();
?>