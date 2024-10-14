<?php
require_once 'connection/connection.php';
echo '
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
<section class="ms-1 connectedSortable ui-sortable" id="orgAll" style="display: block; width:98%">
                <button class="btn btn-info" onclick="showModalAddOborudovanieUnspecified()">Добавить оборудование</button>
                <div class="row">

                    <div class="table-responsive">
                        <table class="table table-striped table-responsive-sm dataTable no-footer" id="infoObAll"
                               style="display: block">
                            <thead>
                            <tr>
                                <th>Организация</th>
                                <th>Модель, производитель</th>
                                <th>Наименование оборудования</th>
                                <th>Стоимость</th>
                                <th>№ контракта, дата подписания</th>
                                <th>Поставщик</th>
                                <th>Сервисант</th>
                                <th>Дата получения оборудования со склада продавца</th>
                                <th>Нормативный срок ввода (дата) </th>
                                <th>Причины, препятствующие вводу </th>
                                <th>Статус </th>
                                
                            </tr>
                            </thead>
                            <tbody>';


if ($id_role == 4) {
    $sql1 = "SELECT o.id_oborudovanie, o.model, type_oborudovanie.name as type_name, cost,num_and_date ,s2.name as name_postavschik,date_get_sklad,date_norm_srok_vvoda,reasons,
       uz.name as uzname, s1.name as servname FROM oborudovanie o
                                        left JOIN uz on o.id_uz=uz.id_uz
                                        left outer join type_oborudovanie on o.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
                                        left outer join servicemans s1 on s1.id_serviceman = o.id_serviceman
                                        left outer join servicemans s2 on s2.id_serviceman = o.id_postavschik
                                        WHERE  o.status = 2 and o.id_uz = '$id_uz'";
}  else if ($id_role == 2 || $id_role == 1) {
    $sql1 = "SELECT o.id_oborudovanie, o.model, type_oborudovanie.name as type_name, cost,num_and_date ,s2.name as name_postavschik,date_get_sklad,date_norm_srok_vvoda,reasons,
       uz.name as uzname, s1.name as servname FROM oborudovanie o
                                        left JOIN uz on o.id_uz=uz.id_uz
                                        left outer join type_oborudovanie on o.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
                                        left outer join servicemans s1 on s1.id_serviceman = o.id_serviceman
                                        left outer join servicemans s2 on s2.id_serviceman = o.id_postavschik
                                        WHERE  o.status = 2";
}
else if ($id_role == 3) {
    $sql1 = "SELECT o.id_oborudovanie, o.model, type_oborudovanie.name as type_name, cost,num_and_date ,s2.name as name_postavschik,date_get_sklad,date_norm_srok_vvoda,reasons,
       uz.name as uzname, s1.name as servname FROM oborudovanie o
                                        left JOIN uz on o.id_uz=uz.id_uz
                                        left outer join type_oborudovanie on o.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
                                        left outer join servicemans s1 on s1.id_serviceman = o.id_serviceman
                                        left outer join servicemans s2 on s2.id_serviceman = o.id_postavschik
                                        WHERE  o.status = 2 and uz.id_oblast = '$idoblguzo'";
}
else{
    echo "Данные недоступны для вашей области.";
    exit;
}


$result1 = $connectionDB->executeQuery($sql1);
while ($row1 = mysqli_fetch_assoc($result1)) {
    $poliklinika = $row1['uzname'];
    $nameOborudov = $row1['type_name'];
    $idOborudovanie = $row1['id_oborudovanie'];
    $model = $row1['model'];
    echo '<tr id=idob' . $idOborudovanie . '  >';
    echo '<td>' . $poliklinika . '</td>';
    echo '<td >' . $model . '</td>';
    echo '<td >' . $nameOborudov . '</td>';
    echo '<td>' . $row1['cost'] . '</td>';
    echo '<td>' . $row1['num_and_date'] . '</td>';
    echo '<td>' . $row1['name_postavschik'] . '</td>';
    echo '<td>' . $row1['servname'] . '</td>';
    echo '<td>' . $row1['date_get_sklad'] . '</td>';
    echo '<td>' . $row1['date_norm_srok_vvoda'] . '</td>';
    echo '<td>' . $row1['reasons'] . '</td>';

    echo '<td  onclick="getFaultsTable(' . $idOborudovanie . ')" style="cursor: pointer"><div style = "border-radius: 5px;background-color: yellow;color: black; padding: 5px;">не установлено</div></td>';

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

echo '<div class="modal" id="editOborudovanieModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование оборудования</h5>
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
                    <label for="date_create">Модель, производитель:</label>
                    <input type="text" id="edit_model" name="date_create">
                    <!---->
                    <label for="date_postavki">Стоимость:</label>
                    <input type="number" id="edit_cost" >
                    <!---->
                    <label for="date_release">№ контракта, дата подписания</label>
                    <input type="text" id="edit_contract" >                   
                     
                        
    <label >Поставщик:</label>
                    
                    <input type="text" id="filterPostavschik" autocomplete="off" onclick="filterS(event,2)"/>
                    <div class="hidden" style="margin-top: 10px; margin-left: 10px; height: 150px; width: 95%; inline-block; overflow: auto">
    ';
$query = "select * from servicemans";
$result = $connectionDB->executeQuery($query);
while ($row = $result->fetch_assoc()) {
    echo "<div style='cursor:pointer; ' data-id='" . $row['id_serviceman'] . "' onclick='setPostavschik(event)'>" . $row['name'] . "</div>";
}

echo ' </div>
 
  <label >Сервисная организация:</label>
                    
                    <input type="text" id="filterServicemans" autocomplete="off" onclick="filterS(event,1)"/>
                    <div class="hidden" style="margin-top: 10px; margin-left: 10px; height: 150px; width: 95%; inline-block; overflow: auto">
                    ';
$query = "select * from servicemans";
$result = $connectionDB->executeQuery($query);
while ($row = $result->fetch_assoc()) {
    echo "<div style='cursor:pointer; ' data-id='" . $row['id_serviceman'] . "' onclick='setServiceman(event)'>" . $row['name'] . "</div>";
}

echo ' </div>
                    <!---->
                    <label for="date_get_oborud">Дата получения оборудования со склада продавца:</label>
                    <input type="date" id="edit_date_get_oborud" name="date_get_oborud">
                    
                    <label for="date_srok_vvoda">Нормативный срок ввода (дата):</label>
                    <input type="date" id="edit_date_srok_vvoda" name="date_srok_vvoda">
                    <!---->
                            <label for="reasons">Причины препятствующие вводу:</label>
                    <input type="text" id="edit_reasons" name="reasons">
                    <!---->
                    <!--                    <input type="hidden" id="edit_id_fault" name="id_fault">-->

                    <div style="margin-top: 10px">
                        <button type="button" class="btn btn-info" id="addBtnOb" onclick="addOborudovanieUnspecified()">
                            Добавить
                        </button>
                        <button type="button" class="btn btn-info" id="editBtnOb" onclick="saveEditedOborudovanie()">
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
<script>
    if($("#infoObAll").length){
        $("#infoObAll").DataTable();
        }
    
         
</script>
';
?>
