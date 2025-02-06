<?php
include "../../connection/connection.php";

$id_uz = $_GET['id_uz'];

echo '<div class="row">

                    <div class="table-responsive">
                        <table class="table table-striped table-responsive-sm dataTable no-footer" id="infoOb' . $id_uz . '"
                               style="display: none">
                            <thead>
                            <tr>
                                <th>!!!</th>
                                <th>Вид оборудования</th>
                                <th>Модель, производитель</th>
                                <th>Регистрационный номер оборудования</th>
                                <th>Серийный(заводской) номер</th>
                                <th>Год производства</th>
                                <th>Дата поставки</th>
                                <th>Дата ввода в эксплуатацию</th>
                                <th>Сервисная организация</th>
                                <th>Дата последнего ТО</th>
                                <th>Статус </th>
                                <th>Действия </th>
                            </tr>
                            </thead>
                            <tbody>';
        $sql1 = "SELECT oborudovanie.*, type_oborudovanie.name, s.name as servname FROM oborudovanie
                                        left outer join type_oborudovanie on oborudovanie.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
                                        left outer join servicemans s on s.id_serviceman = oborudovanie.id_serviceman
                                        where id_uz = $id_uz and status in (0,1,3)";
        $result1 = $connectionDB->executeQuery($sql1);
        while ($row1 = mysqli_fetch_assoc($result1)) {
            $nameOborudov = $row1['name'];
            $idOborudovanie = $row1['id_oborudovanie'];
            $model = $row1['model'];
            $serial_number = $row1['serial_number'];
            $zavod_nomer = $row1['zavod_nomer'];
            $mark1 = empty($serial_number) || empty($nameOborudov) ? '<span style="color: red; font-size: 20px;">!</span>' : '';
            echo '<tr id=idob' . $idOborudovanie . '  >';
            echo '<td>' . $mark1 . '</td>';
            echo '<td onclick="getEffectTable(' . $idOborudovanie . ')" style="cursor: pointer; color: #167877;
    font-weight: 550;">' . $nameOborudov . '</td>';
            echo '<td>' . $model . '</td>';
            echo '<td>' . $serial_number . '</td>';
            echo '<td>' . $zavod_nomer . '</td>';
            $date_create = $row1['date_create'];
            echo '<td>' . $date_create . '</td>';
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
                echo '<td  onclick="getFaultsTable(' . $idOborudovanie . ')" style="cursor: pointer"><div style = "border-radius: 5px;background-color: green;color: white; padding: 5px;">' . $status . '</div></td>';
            }
            else if ($row1['status'] === "3") {
                echo '<td  onclick="getFaultsTable(' . $idOborudovanie . ')" style="cursor: pointer"><div style = "border-radius: 5px;background-color: orange;color: white; padding: 5px; font-size: 11px; width: 85px;">' . $status . '</div></td>';
            }
            else {
                echo '<td  onclick="getFaultsTable(' . $idOborudovanie . ')" style="cursor: pointer"><div style = "border-radius: 5px;background-color: red;color: white; padding: 5px; font-size: 11px; width: 85px;">' . $status . '</div></td>';
            }
            echo '<td>
           <a href="#" onclick="confirmDeleteOborudovanie(' . $idOborudovanie . ')"><i class="fa fa-trash" style="font-size: 20px;"></i></a>
           <a href="#" onclick="editOborudovanie(' . $idOborudovanie . ')"><i class="fa fa-edit" style="font-size: 20px;"></i>️</a>

         </td>';
            echo '</tr>';
        }

        echo '
                            </tbody>
                        </table>

                    </div>
                </div>';