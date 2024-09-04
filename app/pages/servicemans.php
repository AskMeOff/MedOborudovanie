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
                        <table class="table table-striped table-responsive-sm dataTable no-footer" id="infoService' . $id_serviceman . '"
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
$sql1 = "SELECT ob.id_oborudovanie, uz.id_uz, uz.name, typ.name as typename, ob.date_dogovor_service, ob.srok_dogovor_service, ob.summa_dogovor_service, ob.type_work_dogovor_service FROM `servicemans` s
inner JOIN oborudovanie ob on s.id_serviceman = ob.id_serviceman
LEFT JOIN uz uz on uz.id_uz = ob.id_uz
LEFT JOIN type_oborudovanie typ on typ.id_type_oborudovanie = ob.id_type_oborudovanie
where s.id_serviceman = '$id_serviceman'";
    $result1 = $connectionDB->executeQuery($sql1);
    while ($row1 = mysqli_fetch_assoc($result1)) {

        $nameUz = $row1['name'];
        $id_oborudovanie = $row1['id_oborudovanie'];
        $idUz = $row1['id_uz'];
        $typeName = $row1['typename'];
        $dateDogovora = $row1['date_dogovor_service'];
        $srokDogovor = $row1['srok_dogovor_service'];
        $costRepair = $row1['summa_dogovor_service'];
        $typeWorkDogovor = $row1['type_work_dogovor_service'];

        echo '<tr id=iduz'.$idUz.'  >';

        echo '<td>' . $nameUz . '</td>';
        echo '<td>' . $typeName . '</td>';
        echo '<td>' . $dateDogovora . '</td>';
        echo '<td>' . $srokDogovor . '</td>';
        echo '<td>' . $costRepair . '</td>';
        echo '<td>' . $typeWorkDogovor . '</td>';
        echo '<td><a href="#" onclick="editService(' . $id_oborudovanie . ')">✏️</a></td>';
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
                <h5 class="modal-title">Редактирование записи</h5>
                <button type="button" class="btn btn-danger btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
            <form id="editServiceForm">
                    <label>Наименование организации:</label>
                    <input type="text" id="edit_name_org" disabled>
                    <!---->
                    <label>Вид оборудования:</label>
                    <input type="text" id="edit_type_obor" disabled>
                    <!---->
                    <label for="edit_date_dogovor_service">Дата заключения договора:</label>
                    <input type="date" id="edit_date_dogovor_service">
                    <!---->
                    <label for="edit_srok_dogovor_service">Срок действия договора:</label>
                    <input type="date" id="edit_srok_dogovor_service">
                    <!---->
                    <label for="edit_summa_dogovor_service">Общая сумма по договору:</label>
                    <input type="text" id="edit_summa_dogovor_service">
                    <!---->
                   
                    <label for="edit_type_work_dogovor_service">Вид выполняемых работ по договору:</label>
                    <input type="text" id="edit_type_work_dogovor_service">


                    <div style="margin-top: 10px">
                        <button type="button" class="btn btn-primary" id="editBtnOb" onclick="saveEditedService()">
                            Сохранить
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>'
;
echo '<div class="overlay" id="overlay">
    <div class="overlay-content">
       Выберите сервисанта
    </div>
    <img src="app/assets/images/fast-forward.gif" alt="GIF" class="overlay-gif">
</div>';



echo '

';
?>