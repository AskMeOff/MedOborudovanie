<?php

echo '<link rel="stylesheet" href="css/minsk.css">
<section class="content" style="margin-top: 100px; margin-left: 15px">
    <div class="container-fluid" id="container_fluid">

        <div class="row" id="main_row">';


            $query = "select * from servicemans;";
            $result = $connectionDB->executeQuery($query);
            if ($connectionDB->getNumRows($result) == 0) {
            echo '<section class="col-lg-9 connectedSortable ui-sortable"  style="display: block;">
                <div class="row">
                </div>
            </section>';
            }
while ($row = mysqli_fetch_assoc($result)) {

    $id_serviceman = $row['id_serviceman'];

    echo ' <section class="col-lg-9 connectedSortable ui-sortable" id="service' . $id_serviceman . '" style="display: block;">
                <div class="row">

                    <div class="table-responsive">
                        <table class="table table-striped table-responsive-sm dataTable no-footer" id="infoservice' . $id_serviceman . '"
                               style="display: none">
                            <thead>
                            <tr>
                                <th style="text-align: center;">Наименование организации</th>
                                <th style="text-align: center;">Вид оборудования</th>
                                <th style="text-align: center;">Дата заключения договора</th>
                                <th style="text-align: center;">Срок действия договора</th>
                                <th style="text-align: center;">Общая сумма по договору</th>
                                <th style="text-align: center;">Вид выполняемых работ по договору</th>
                                <th style="text-align: center;">Действия</th>
                        
                            </tr>
                            </thead>
                            <tbody>';
//    $sql1 = "SELECT count(o.id_oborudovanie) countUz,uz.id_uz, uz.name   FROM oborudovanie o
//                                        left join uz uz on o.id_uz = uz.id_uz
//                                        left join servicemans s on s.id_serviceman = o.id_serviceman
//                                        where s.id_serviceman = '$id_serviceman' group by uz.id_uz";
//    $result1 = $connectionDB->executeQuery($sql1);
//    while ($row1 = mysqli_fetch_assoc($result1)) {
//        $nameUz = $row1['name'];
//        $id_uz = $row1['id_uz'];
//        $countUz = $row1['countUz'];
//        echo '<tr id=iduz'.$id_uz.'  >';
//
//        echo '<td>' . $nameUz . '</td>';
//        echo '<td>' . $countUz . '</td>';
//
//        echo '</tr>';
//    }
$sql1 = "SELECT uz.id_uz, uz.name, typ.name as typename, f.date_dogovora, f.time_repair, f.cost_repair, f.type_work_dogovor FROM `servicemans` s
LEFT JOIN oborudovanie ob on s.id_serviceman = ob.id_serviceman
LEFT JOIN faults f on ob.id_oborudovanie = f.id_oborudovanie
LEFT JOIN uz uz on uz.id_uz = ob.id_uz
LEFT JOIN type_oborudovanie typ on typ.id_type_oborudovanie = ob.id_type_oborudovanie
where s.id_serviceman = '$id_serviceman'";
    $result1 = $connectionDB->executeQuery($sql1);
    while ($row1 = mysqli_fetch_assoc($result1)) {
        $nameUz = $row1['name'];
        $idUz = $row1['id_uz'];
        $typeName = $row1['typename'];
        $dateDogovora = $row1['date_dogovora'];
        $timeRepair = $row1['time_repair'];
        $costRepair = $row1['cost_repair'];
        $typeWorkDogovor = $row1['type_work_dogovor'];

        echo '<tr id=iduz'.$idUz.'  >';

        echo '<td>' . $nameUz . '</td>';
        echo '<td>' . $typeName . '</td>';
        echo '<td>' . $dateDogovora . '</td>';
        echo '<td>' . $timeRepair . '</td>';
        echo '<td>' . $costRepair . '</td>';
        echo '<td>' . $typeWorkDogovor . '</td>';
        echo '<td><a href="#" onclick="editService(' . $idUz . ')">✏️</a></td>';
        echo '</tr>';
    }
    echo ' 
                            </tbody>
                        </table>
     
                    </div>
                </div>

            </section>';
}



echo '<section class="col-lg-3" id="right_section" style="overflow: auto;
    height: 85vh;">
    <div><input style="width:100%;" type="text" id="myInputOrg" onkeyup="searchServiceman(this)"
                placeholder="Поиск обслуживающей организации"
                title="Type in a name">
    </div>';



$sql = "select * from servicemans";
$result = $connectionDB->executeQuery($sql);
//                $activeClass = "activecard1";
while ($row = mysqli_fetch_assoc($result)) {

    echo '<div class="card card0 " onclick="showServiceman(' . $row['id_serviceman'] . ',this)">';
    echo '<h4>' . $row['name'] . '</h4>';
    echo '</div>';
//                    $activeClass = "";
}



echo '</div>
    </div>
</section>
';

echo '<div class="modal" id="editServiceModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование сервисантов</h5>
                <button type="button" class="btn btn-danger btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
            <form id="editOborudovanieForm">
                    <label>Вид оборудования:</label>
                    <select class="form-select" id="select_type_oborudovanie">';

$query = "select * from type_oborudovanie";
$result = $connectionDB->executeQuery($query);
while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row['id_type_oborudovanie'] . "'>" . $row['name'] . "</option>";
}

echo ' </select>


                    <!---->
                    <label for="date_create">Год производства:</label>
                    <input type="text" id="edit_date_create" name="date_create">
                    <!---->
                    <label for="date_postavki">Дата поставки:</label>
                    <input type="date" id="edit_date_postavki" name="date_postavki">
                    <!---->
                    <label for="date_release">Дата ввода в эксплуатацию:</label>
                    <input type="date" id="edit_date_release" name="date_release">
                    <!---->
                   
                    <label for="service_organization">Сервисная организация:</label>
                    <input type="text" id="edit_service_organization" name="service_organization">

                    <!---->
                    <label for="date_last_TO">Дата последнего ТО:</label>
                    <input type="date" id="edit_date_last_TO" name="date_last_TO">
                    <!---->
                    <label>Статус:</label>
                    <select class="form-select" id="select_status">
                        <option value="0">Неисправно</option>
                        <option value="1">Исправно</option>
                    </select>
                    <!---->
                    <!--                    <input type="hidden" id="edit_id_fault" name="id_fault">-->

                    <div style="margin-top: 10px">
                        <button type="button" class="btn btn-primary" id="addBtnOb" onclick="saveAddedOborudovanie()">
                            Добавить
                        </button>
                        <button type="button" class="btn btn-primary" id="editBtnOb" onclick="saveEditedOborudovanie()">
                            Сохранить
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>';



echo '
<script src="js/serviceman.js"></script>
';
?>