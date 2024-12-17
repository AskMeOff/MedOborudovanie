<?php
require_once 'connection/connection.php';
echo '
<style>
th{
border: 1px solid gray;
}
</style>
<script type="text/javascript" src="bootstrap/assets/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" href="css/minsk.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<section class="content" style="margin-top: 100px; margin-left: 15px">
    <div class="container-fluid" id="container_fluid" style="overflow: auto; height: 85vh;">

        <div class="row" id="main_row">';

if (isset($_COOKIE['token']) && $_COOKIE['token'] !== '') {
$login = $_COOKIE['login'];
$token = $_COOKIE['token'];
$getiduz = "SELECT * FROM users WHERE token = '$token';";
$resultiduz = $connectionDB->executeQuery($getiduz);
$userData = $resultiduz->fetch_assoc();
if ($userData) {
    $id_uz = $userData['id_uz'];
    $id_role = $userData['id_role'];
    $idoblguzo = $userData['id_obl'];
}

echo '
<section class="ms-1 connectedSortable ui-sortable" id="zapAll" style="display: block; width:98%">
                <button class="btn btn-info" onclick="showModalAddZapchast()">Добавить запчасть</button>
                <div class="row mt-4" >

                    <div class="table-responsive">
                        <table class="table table-striped table-responsive-sm dataTable no-footer" id="infoObAll"
                               style="display: block; ">
                            <thead>
                            <tr>
                                <th rowspan="2">Действия</th>
                                <th rowspan="2">Объект основного средства (учреждение здравоохранения)</th>
                                <th colspan="3">Аппарат подлежащий списанию</th>
                                <th rowspan="2">Наименование запасных частей и комплектующих, списанных с основного средства</th>
                                <th rowspan="2">Фото запасных частей</th>
                                <th rowspan="2">Дефектный акт</th>
                                <th rowspan="2">Каталожный номер </th>
                                <th rowspan="2">Маркировка запасных частей</th>
                                <th rowspan="2">Фактическая стоиомсть </th>
                                <th rowspan="2">Учреждение здравоохранения, которому переданы запасные части </th>
                                
                            </tr>
                            <tr>
                                <th>наименование</th>
                                <th>год выпуска</th>
                                <th>регистрационный номер оборудования</th>
</tr>
                            </thead>
                            <tbody>';



    $sql = "SELECT z.*, o.model, o.date_create, o.serial_number, uz_from.name as uz_from, uz_to.name as uz_to  FROM zapchasti z
                                        left JOIN uz uz_from on z.id_uz_from=uz_from.id_uz
                                        left JOIN uz uz_to on z.id_uz_to=uz_to.id_uz
                                        left outer join oborudovanie o on o.id_oborudovanie = z.id_oborudovanie
                                       ";



$result = $connectionDB->executeQuery($sql);
while ($row = mysqli_fetch_assoc($result)) {
    $id_zapchast = $row['id_zapchast'];
    $id_oborudovanie = $row['id_oborudovanie'];
    $model = $row['model'];
    $date_create = $row['date_create'];
    $serial_number = $row['serial_number'];
    $name_zapchast = $row['name_zapchast'];
    $photo = $row['photo'];
    $def_akt = $row['def_akt'];
    $katal_nom = $row['katal_nom'];

    $mark_zapchast = $row['mark_zapchast'];
    $fact_cost = $row['fact_cost'];
    $uz_from = $row['uz_from'];
    $uz_to = $row['uz_to'];

    echo '<tr id=idzap' . $id_zapchast . '  >';
    echo '<td><a href="#" onclick="confirmDeleteZapchast(' . $id_zapchast . ')"><i class="fa fa-trash" style="font-size: 20px;"></i></a><a href="#" onclick="editZapchast(' . $id_zapchast . ')"><i class="fa fa-edit" style="font-size: 20px;"></i>️</a></td>';
    echo '<td>' . $uz_from . '</td>';
    echo '<td >' . $model . '</td>';
    echo '<td >' . $date_create . '</td>';
    echo '<td>' . $serial_number . '</td>';
    echo '<td>' . $name_zapchast . '</td>';
    echo '<td>' . $photo . '</td>';
    echo '<td>' . $def_akt . '</td>';
    echo '<td>' . $katal_nom . '</td>';
    echo '<td>' . $mark_zapchast . '</td>';
    echo '<td>' . $fact_cost . '</td>';

    echo '<td>' . $uz_to . '</td>';

    //echo '<td><a href="#" onclick="confirmDeleteOborudovanie(' . $idOborudovanie . ')">&#10060;</a><a href="#" onclick="editOborudovanie(' . $idOborudovanie . ')">✏️</a></td>';
    echo '</tr>';
}

echo ' 
                            </tbody>
                        </table>
                    </div>
                </div>

            </section>
            ';


echo '</div>
    </div>
</section>';

}
else {
    echo 'Данные недоступны. Требуется авторизация.';

}

echo '<div class="modal" id="editZapchastModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование записи</h5>
                <button type="button" class="btn btn-danger btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
            <form id="editZapchastForm">
                    <label>Объект основного средства:</label>
                    <input type="text" id="filter_uz_from" autocomplete="off" onclick="filterUzFrom(event,2)"/>
                   
                 <div class="hidden" style="margin-top: 10px; margin-left: 10px; height: 150px; width: 95%; inline-block; overflow: auto">
    ';
$query = "select * from uz";
$result = $connectionDB->executeQuery($query);
while ($row = $result->fetch_assoc()) {
    echo "<div style='cursor:pointer; ' data-id='" . $row['id_uz'] . "' onclick='setUzFrom(event)'>" . $row['name'] . "</div>";
}

echo ' </div>


                    <!---->
                     <label >Регистрационный номер оборудования:</label>
                    
                    <input type="text" id="filter_serial_number" autocomplete="off" onclick="filterSN(event,2)"/>
                    <div class="hidden" style="margin-top: 10px; margin-left: 10px; height: 150px; width: 95%; inline-block; overflow: auto">
    ';
$query = "select * from oborudovanie";
$result = $connectionDB->executeQuery($query);
while ($row = $result->fetch_assoc()) {
    echo "<div style='cursor:pointer; ' data-id='" . $row['id_oborudovanie'] . "' onclick='setOborudovanie(event)'>" . $row['model'] . "</div>";
}

echo ' </div>
                    <!---->
                    <label for="date_postavki">Наименование запчастей:</label>
                    <input type="number" id="edit_name_zapchast" >
                    <!---->
                    <label for="photo">Фото</label>
                    <input type="file" id="edit_photo" >                   
                     
                        
    <label >Дефектный акт:</label>
                    
            <input type="file" id="edit_akt" >   
 
 
                    <!---->
                    <label for="edit_kat_nomer">Каталожный номер:</label>
                    <input type="text" id="edit_kat_nomer" name="edit_kat_nomer">
                    
                    <label for="date_srok_vvoda">Маркировка запасных частей:</label>
                    <input type="text" id="edit_mark_zapchast" name="edit_mark_zapchast">
                    <!---->
                            <label for="reasons">Фактическая стоимость:</label>
                    <input type="text" id="edit_cost" name="reasons">
                    
                   <label for="reasons">Учреждение здравоохранения, которому переданы запасные части:</label>
                   <input type="text" id="filter_uz_from" autocomplete="off" onclick="filterUzTo(event,2)"/>
                   
                 <div class="hidden" style="margin-top: 10px; margin-left: 10px; height: 150px; width: 95%; inline-block; overflow: auto">
    ';
$query = "select * from uz";
$result = $connectionDB->executeQuery($query);
while ($row = $result->fetch_assoc()) {
    echo "<div style='cursor:pointer; ' data-id='" . $row['id_uz'] . "' onclick='setUzTo(event)'>" . $row['name'] . "</div>";
}

echo ' </div>

                    <div style="margin-top: 10px">
                        <button type="button" class="btn btn-info" id="addBtnZap" onclick="addZapchast()">
                            Добавить
                        </button>
                        <button type="button" class="btn btn-info" id="editBtnZap" onclick="saveZapchast()">
                            Сохранить
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

';


echo '
<script>
  
    
         
</script>
';
?>
