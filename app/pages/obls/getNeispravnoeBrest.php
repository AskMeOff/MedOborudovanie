<?php
require_once '../../../connection/connection.php';
echo ' <section class="col-lg-9 connectedSortable ui-sortable" id="org" style="margin-top: 150px; margin-left: 70px; display: block;">
    <div class="row">

        <div class="table-responsive">
            <table class="table table-striped table-responsive-sm dataTable no-footer" id="infoOb"
                   style="display: block">
                <thead>
                <tr>
                    <th>Тип оборудования</th>
                    <th>Год производства</th>
                    <th>Дата поставки</th>
                    <th>Дата ввода в эксплуатацию</th>
                    <th>Сервисная организация</th>
                    <th>Дата последнего ТО</th>
                    <th>Статус </th>
                </tr>
                </thead>
                <tbody>';
                $sql9 = "SELECT oborudovanie.*, uz.id_oblast , type_oborudovanie.name FROM
                oborudovanie  left outer join type_oborudovanie on oborudovanie.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
                inner join uz uz on uz.id_uz = oborudovanie.id_uz where uz.id_oblast = 1 and oborudovanie.status = 0;";
                $result9 = $connectionDB->executeQuery($sql9);
                while ($row9 = mysqli_fetch_assoc($result9)) {
                $nameOborudov = $row9['name'];
                $idOborudovanie = $row9['id_oborudovanie'];
                echo '<tr id=idob'.$idOborudovanie.'  >';

                    echo '<td  style="cursor: pointer">' . $nameOborudov . '</td>';
                    //        echo '<td>' . $row1['cost'] . '</td>';
                    echo '<td>' . $row9['date_create'] . '</td>';
                    echo '<td>' . $row9['date_postavki'] . '</td>';
                    echo '<td>' . $row9['date_release'] . '</td>';
                    echo '<td>' . $row9['service_organization'] . '</td>';
                    echo '<td>' . $row9['date_last_TO'] . '</td>';
                    $status = $row9['status'] === "1" ? "исправно" : "неисправно";
                    if ($row9['status'] === "1") {
                    echo '<td   style="cursor: pointer"><div style = "border-radius: 5px;background-color: green;color: white;">' . $status . '</div></td>';
                    } else {
                    echo '<td  style="cursor: pointer"><div style = "border-radius: 5px;background-color: red;color: white;">' . $status . '</div></td>';
                    }
                    echo '</tr>';
                }

                echo '
                </tbody>
            </table>

        </div>
    </div>

</section>';


//-----------------------------------------------------------------------------

