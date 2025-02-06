<?php


if (!isset($_GET['id_type'])) {
    if (!isset($_GET['status'])) {
        if ($id_role == 4) {

            $sql1 = "SELECT oborudovanie.*, type_oborudovanie.name, uz.name as poliklinika, s.name as servname FROM oborudovanie
                                        INNER JOIN uz on oborudovanie.id_uz=uz.id_uz
                                        left outer join type_oborudovanie on oborudovanie.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
                                        left outer join servicemans s on s.id_serviceman = oborudovanie.id_serviceman
                                        WHERE uz.id_oblast=$id_obl and uz.id_uz = $id_uz and (oborudovanie.status in (0,1,3))";
        } else if ($id_role == 2 || $id_role == 1) {
            if ($id_obl == 111){
                $sql1 = "SELECT oborudovanie.*, type_oborudovanie.name, uz.name as poliklinika, s.name as servname FROM oborudovanie
                                        INNER JOIN uz on oborudovanie.id_uz=uz.id_uz
                                        left outer join type_oborudovanie on oborudovanie.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
                                        left outer join servicemans s on s.id_serviceman = oborudovanie.id_serviceman
                                        WHERE  (oborudovanie.status in (0,1,3))";

            }else {
                $sql_count_pages = "select count(*) as count_pages from oborudovanie o left join uz on o.id_uz = uz.id_uz 
                                            where uz.id_oblast = $id_obl";
                $result_count_pages = $connectionDB->executeQuery($sql_count_pages);
                $row_count_pages = mysqli_fetch_assoc($result_count_pages);
                $count_pages = ceil($row_count_pages['count_pages'] / 10);
                $sql1 = "SELECT oborudovanie.*, type_oborudovanie.name, uz.name as poliklinika, s.name as servname FROM oborudovanie
                                        INNER JOIN uz on oborudovanie.id_uz=uz.id_uz
                                        left outer join type_oborudovanie on oborudovanie.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
                                        left outer join servicemans s on s.id_serviceman = oborudovanie.id_serviceman
                                        WHERE uz.id_oblast=$id_obl  and (oborudovanie.status in (0,1,3)) ";
            }
        }
        else if ($id_role == 3) {
            if ($id_obl == $idoblguzo) {
                $sql1 = "SELECT oborudovanie.*, type_oborudovanie.name, uz.name as poliklinika, s.name as servname FROM oborudovanie
                                        INNER JOIN uz on oborudovanie.id_uz=uz.id_uz
                                        left outer join type_oborudovanie on oborudovanie.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
                                        left outer join servicemans s on s.id_serviceman = oborudovanie.id_serviceman
                                        WHERE uz.id_oblast=$id_obl  and (oborudovanie.status in (0,1,3))";
            } else {
                echo "Данные недоступны для вашей области.";
                exit;
            }
        } else {
            echo "Данные недоступны. Требуется Авторизация";
            exit;
        }
    }
    else if ((isset($_GET['status']))){
        if ($id_obl == 111){
            $sql1 = "SELECT oborudovanie.*, tob.name, uz.name as poliklinika, s.name as servname FROM oborudovanie
                                        INNER JOIN uz on oborudovanie.id_uz=uz.id_uz
                                        left outer join type_oborudovanie tob on oborudovanie.id_type_oborudovanie = tob.id_type_oborudovanie
                                        left outer join servicemans s on s.id_serviceman = oborudovanie.id_serviceman
                                        WHERE oborudovanie.status = $getStatus";
        }else{
            $sql1 = "SELECT oborudovanie.*, tob.name, uz.name as poliklinika, s.name as servname FROM oborudovanie
                                        INNER JOIN uz on oborudovanie.id_uz=uz.id_uz
                                        left outer join type_oborudovanie tob on oborudovanie.id_type_oborudovanie = tob.id_type_oborudovanie
                                        left outer join servicemans s on s.id_serviceman = oborudovanie.id_serviceman
                                        WHERE uz.id_oblast=$id_obl and oborudovanie.status = $getStatus";
        }
    }

} else if (isset($_GET['id_type'])){
    $id_type = $_GET['id_type'];
    if ($id_obl == 111){
        $sql1 = "SELECT oborudovanie.*, tob.name, uz.name as poliklinika, s.name as servname FROM oborudovanie
                                        INNER JOIN uz on oborudovanie.id_uz=uz.id_uz
                                        left outer join type_oborudovanie tob on oborudovanie.id_type_oborudovanie = tob.id_type_oborudovanie
                                        left outer join servicemans s on s.id_serviceman = oborudovanie.id_serviceman
                                        WHERE tob.id_type_oborudovanie = $id_type and oborudovanie.status in (0,1,3)";
    }else{
        $sql1 = "SELECT oborudovanie.*, tob.name, uz.name as poliklinika, s.name as servname FROM oborudovanie
                                        INNER JOIN uz on oborudovanie.id_uz=uz.id_uz
                                        left outer join type_oborudovanie tob on oborudovanie.id_type_oborudovanie = tob.id_type_oborudovanie
                                        left outer join servicemans s on s.id_serviceman = oborudovanie.id_serviceman
                                        WHERE uz.id_oblast=$id_obl and tob.id_type_oborudovanie = $id_type and oborudovanie.status in (0,1,3)";
    }
}
$result1 = $connectionDB->executeQuery($sql1);
while ($row1 = mysqli_fetch_assoc($result1)) {
    $poliklinika = $row1['poliklinika'];
    $nameOborudov = $row1['name'];
    $idOborudovanie = $row1['id_oborudovanie'];
    $model = $row1['model'];
    $serial_number = $row1['serial_number'];
    $zavod_nomer = $row1['zavod_nomer'];
    $mark1 = empty($serial_number) || empty($nameOborudov) ?  '<span style="color: red; font-size: 20px;">!</span>' : '';
    echo '<tr id=idob' . $idOborudovanie . '  >';
    echo '<td>' . $mark1. '</td>';
    echo '<td>' . $poliklinika . '</td>';
    echo '<td>' . $model . '</td>';
    echo '<td>' . $serial_number . '</td>';
    echo '<td>' . $zavod_nomer . '</td>';
    echo '<td class="vid_oborudovaniya" onclick="getEffectTable(' . $idOborudovanie . ')" style="cursor: pointer; color: #167877;
    font-weight: 550;">' . $nameOborudov . '</td>';
    $date_create = $row1['date_create'];
    echo  '<td>' . $date_create . '</td>';
    $date_postavki = $row1['date_postavki'];
    echo '<td>' . ($date_postavki ? date('d.m.Y', strtotime($date_postavki)) : 'Нет данных') . '</td>';
    $date_release = $row1['date_release'];
    echo '<td>' . ($date_release ? date('d.m.Y', strtotime($date_release)) : 'Нет данных') . '</td>';
    echo '<td>' . $row1['servname'] . '</td>';
    $date_last_TO = $row1['date_last_TO'];
    echo '<td>' . ($date_last_TO ? date('d.m.Y', strtotime($date_last_TO)) : 'Нет данных') . '</td>';
    if($row1['status'] === "1")
    {
        $status = "исправно";
    }
    else{
        $status =  (($row1['status'] === "3") ? "Работа в ограниченном режиме" : "неисправно");
    }


    if ($row1['status'] === "1") {
        echo '<td   style="cursor: pointer"><div style = "border-radius: 5px;background-color: green;color: white; padding: 5px;">' . $status . '</div></td>';
    }
    else if ($row1['status'] === "3") {
        echo '<td   style="cursor: pointer"><div style = "border-radius: 5px;background-color: orange;color: white; padding: 5px;">' . $status . '</div></td>';
    }
    else {
        echo '<td   style="cursor: pointer"><div style = "border-radius: 5px;background-color: red;color: white; padding: 5px; font-size: 11px;width: 85px;">' . $status . '</div></td>';
    }
    //echo '<td><a href="#" onclick="confirmDeleteOborudovanie(' . $idOborudovanie . ')">&#10060;</a><a href="#" onclick="editOborudovanie(' . $idOborudovanie . ')">✏️</a></td>';
    echo '</tr>';
}