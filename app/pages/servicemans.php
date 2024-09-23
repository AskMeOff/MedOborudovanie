<?php

echo '<link rel="stylesheet" href="css/minsk.css">
<section class="content" style="margin-top: 100px; margin-left: 15px">
    <div class="container-fluid" id="container_fluid">
    '; if($login=='admin'){
echo ' <a href="#" class="btn btn-info" data-toggle="modal" data-target="#addServiceModal">Добавить сервисанта</a>
';}
     echo'   <div class="row" id="main_row">';


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
                                ';
    if($id_role == "1")
    echo '
                                <th style="text-align: center;">Действия</th>';
    echo '
                                                    </tr>
                            </thead>
                            <tbody>';

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
        if($id_role == "1")
            echo '<td><a href="#" onclick="editService(' . $id_oborudovanie . ')"><i class="fa fa-edit" style="font-size: 20px;"></i>️</a></td>';
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
    echo '<h5>' . $row['name'] . '</h5>';
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
                        <button type="button" class="btn btn-info" id="editBtnOb" onclick="saveEditedService()">
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
</div>

<div class="modal fade" id="addServiceModal" tabindex="-1" role="dialog" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addServiceModalLabel">Добавить сервисную организацию</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="serviceForm">
                    <div class="form-group">
                        <label for="serviceName">Наименование сервисной организации</label>
                        <input type="text" class="form-control" id="serviceName" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" id="saveService">Сохранить</button>
            </div>
        </div>
    </div>
</div>
';

echo '
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
';
?>