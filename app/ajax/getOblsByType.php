<?php
require_once '../../connection/connection.php';
require_once '../../app/classes/UsersList.php';
include "../../app/constants/cookie.php";
$id_type = $_GET['id_type'];
if (isset($TOKEN)) {
    if ($usersList->getUser($TOKEN)){
        $login = $usersList->getUser($TOKEN)->getLogin();
        $id_role = $usersList->getUser($TOKEN)->getRole();
        $id_uz = $usersList->getUser($TOKEN)->getIdUz();
    }
    else {
        $login = "";
    }
} else {
    $login = "";
}
echo '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<style>
    .card1 {
    cursor: pointer;
    height: 100px;
        background-size: cover;
        background-attachment: fixed;
        display: flex;
        flex-direction: column;
        /* align-items: center; */
        padding-left: 20px;
        justify-content: center;
        /* text-align: center; */
        color: black;
        transition: all 0.5s ease-in;
        width: 700px;
    }

    .card {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: aliceblue;
        background-clip: border-box;
        border: 0 solid rgba(0, 0, 0, 0.125);
        border-radius: 0.25rem;
    }

    @media (min-width: 1000px) {
    .card {
        left: 27%;
    }
    }

    .card {
    box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2);
        margin-bottom: 1rem;

    }

    .card:hover {
    background-color: #bbd0e3;
    }

    .card1 h2 {
    text-align: center;
        margin-top: 20px;
    }


    #preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .loader {
    border: 8px solid #f3f3f3; /* Light grey */
        border-top: 8px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
    0% {
        transform: rotate(0deg);
        }
        100% {
        transform: rotate(360deg);
        }
    }
    td{
    text-align: center;
    }
    .filterContainer{
    margin-bottom: 20px;
        width: 95% !important;
        margin-left: 2vw;
        margin-top: 10px;
        /* padding: 10px; */
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
        display: flex
    ;
        flex-wrap: wrap;

    }

</style>

<section class="col-lg-12 connectedSortable ui-sortable" style="margin-top: 90px">';


    if (isset($id_role )) {
        if ($id_role == 1 || $id_role == 2) {
            echo "<div class='row'>";
            echo "<div class='card card1' onclick='getUzs(111)'>";
            echo "<h2>Республика Беларусь</h2>";
            echo "</div>";
            echo "</div>";
            $query = "SELECT * FROM oblast;";
            $result = $connectionDB->executeQuery($query);
            while ($row = mysqli_fetch_assoc($result)) {
                $id_oblast = $row['id_oblast'];
                echo "<div class='row'>";
                echo "<div class='card card1' onclick='getUzs($id_oblast)'>";
                echo "<h2>". $row['name']. "</h2>";
                echo "</div>";
                echo "</div>";
            }
        }
        if($id_role == 4){
            echo '<link rel="stylesheet" href="css/minsk.css">';
            $equipmentTypes = [];
            $serviceNames = [];
            $statuses = ['исправно', 'неисправно','Работа в ограниченном режиме'];
            $sqlTypes = "SELECT DISTINCT name FROM type_oborudovanie order by name";
            $resultTypes = $connectionDB->executeQuery($sqlTypes);
            while ($row = mysqli_fetch_assoc($resultTypes)) {
                $equipmentTypes[] = $row['name'];
            }
            $sqlServices = "SELECT DISTINCT s.name FROM servicemans s";
            $resultServices = $connectionDB->executeQuery($sqlServices);
            while ($row = mysqli_fetch_assoc($resultServices)) {
                $serviceNames[] = $row['name'];
            }
            echo ' 
 <button id="btnExportExcel" data-id="'.$id_uz.'" class="btn btn-info" style="margin-left: 2vw;">Экспорт в Excel</button>
 <button id="btnAddOborudovanie" class="btn btn-info m-2">Добавить оборудование</button>';
            echo '<div>  <button class="btn btn-info" onclick="startFilter()" style=" margin-top: 10px; margin-left: 2vw;">Фильтры</button> 
          <div id="filterContainer" class="filterContainer" style="display: none;">
            <div class = "filtCol row" style="margin-left: 10px;">
                        <div class="col-lg-4">

                 <label for="filterEquipment">Вид оборудования:</label>
                 <select id="filterEquipment" onchange="filterTable1('.$id_uz.')">
                 <option value="">Все</option>';
            foreach ($equipmentTypes as $type) {
                echo '<option value="' . $type . '">' . $type . '</option>';
            }

            echo '  </select>
            </div>
                        <div class="col-lg-4">

            <label for="filterYear">Год производства:</label>
            <input type="date" id="filterYear" onchange="filterTable1('.$id_uz.')">
            </div>
            <div class="col-lg-4">

            <label for="filterDatePostavki">Дата поставки:</label>
            <input type="date" id="filterDatePostavki" onchange="filterTable1('.$id_uz.')">
</div>
            </div>
            <div class = "filtCol row" style="margin-bottom: 10px; margin-left: 10px;">
                        
            <div class="col-lg-4">

            <label for="filterDateRelease">Дата ввода в эксплуатацию:</label>
            <input type="date" id="filterDateRelease" onchange="filterTable1('.$id_uz.')">
            </div>
            <div class="col-lg-4">

            <label for="filterService">Сервисная организация:</label>
            <select id="filterService" onchange="filterTable1('.$id_uz.')">
                <option value="">Все</option>';
            foreach ($serviceNames as $service) {
                echo '<option value="' . $service . '">' . $service . '</option>';
            }
            echo '  </select>
</div>
            <div class="col-lg-4">

            <label for="filterStatus">Статус:</label>
            <select id="filterStatus" onchange="filterTable1('.$id_uz.')">
                <option value="Все">Все</option>';
            foreach ($statuses as $status) {
                echo '<option value="' . $status . '">' . $status . '</option>';
            }
            echo '  </select>
  </div>
            </div>
           </div>
 <section class=" connectedSortable ui-sortable" id="org' . $id_uz . '" style="display: block; justify-items: baseline;
    margin-left: 1.5vw; width: 96%;">
                
                <div class="row">

                    <div class="table-responsive">
                        <table class="table table-striped table-responsive-sm dataTable no-footer" id="infoOb' . $id_uz . '"
                               style="display: block">
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
                                        where id_uz = $id_uz and status in (0,1,3) and oborudovanie.id_type_oborudovanie = '$id_type'";
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
                </div>

            </section>';

        }
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

    $query = "select * from type_oborudovanie order by name";
    $result = $connectionDB->executeQuery($query);
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['id_type_oborudovanie'] . "'>" . $row['name'] . "</option>";
    }

    echo ' </select>


                    <!---->
                    <label for="date_create">Год производства:</label>
                    <input type="text" id="edit_date_create" name="date_create" placeholder="YYYY">
                    <span id="yearError" style="color: red; display: none;">Некорректный ввод данных. Год состоит из 4 цифр!</span>
                    <!---->
                    <label for="date_postavki">Дата поставки:</label>
                    <input type="date" id="edit_date_postavki" name="date_postavki">
                    <!---->
                    <label for="date_release">Дата ввода в эксплуатацию:</label>
                    <input type="date" id="edit_date_release" name="date_release">
                    <!---->
                   
                    <label for="filterSerialNumber">Регистрационный номер оборудования (<a target="_blank" href="https://www.rceth.by/Refbank/reestr_medicinskoy_tehniki"> Реестры УП «Центр экспертиз и испытаний в здравоохранении»</a>): <a target="_blank" href="documents/help_reg_number.mp4"><i style="font-size: 24px;" class="fa fa-question"></i></a></label>
                
                     <input type="text" id="filterSerialNumber" autocomplete="off" onclick="filterSNumber(event)"/>    
           
                    <div class="hidden" style="margin-top: 10px; margin-left: 10px; height: 150px; width: 95%; inline-block; overflow: auto">
                    </div>
                                          <span id="serialNumberErrorLess" style="color: red; display: block;">Введите более 7 символов</span>
                    
                     <span id="serialNumberError" style="color: red; display: none;">Это поле обязательно для заполнения!</span>
                    <div style="display: flex; margin-top: 10px"><input id="isNotReg" onchange="chckReg(this)" type="checkbox"><div style="margin-left: 10px;">Нет регистрационного номера в реестре</div></div>
                    
                                         <label for="model_name">Модель, производитель:</label>
                   
                     <input disabled type="text" id="model_name" autocomplete="off"/>
                     
                    <span id="modelError" style="color: red; display: none;">Не выбран регистрационный номер из предложенного списка выше!</span>
                    
                     <label for="zavod_nomer">Серийный(заводской) номер:</label>
                     <input type="text" id="zavod_nomer" autocomplete="off"/>
                   
                    <label >Сервисная организация:</label>
                    
                   <input type="text" id="filterServicemans" autocomplete="off" onclick="filterS(event)"/>
                    
                    <div class="hidden" style="margin-top: 10px; margin-left: 10px; height: 150px; width: 95%; inline-block; overflow: auto">
                    ';
    $query = "select * from servicemans";
    $result = $connectionDB->executeQuery($query);
    while ($row = $result->fetch_assoc()) {
        echo "<div style='cursor:pointer; ' data-id='" . $row['id_serviceman'] . "' onclick='setServiceman(event)'>" . $row['name'] . "</div>";
    }
    echo '
                    </div>
                  
                    <!---->
                    <label for="date_last_TO">Дата последнего ТО:</label>
                    <input type="date" id="edit_date_last_TO" name="date_last_TO">
                    <!---->
                    <label>Статус:</label>
                    <select class="form-select" id="select_status">
                        <option value="0">Неисправно</option>
                        <option value="1">Исправно</option>
                        <option value="3">Работа в ограниченном режиме</option>
                    </select>
                    <!---->
                    <!--                    <input type="hidden" id="edit_id_fault" name="id_fault">-->

                    <div style="margin-top: 10px">
                        <button type="button" class="btn btn-info" id="addBtnOb" onclick="saveAddedOborudovanie1('.$id_uz.')">
                            Добавить
                        </button>
                        <button type="button" class="btn btn-info" id="editBtnOb" onclick="saveEditedOborudovanie1()">
                            Сохранить
                        </button>
                        <button type="button" class="btn btn-danger" id="closeBtnOb" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>';

echo "
<script>
btnAddOborudovanie = document.getElementById('btnAddOborudovanie');
if(btnAddOborudovanie){
    btnAddOborudovanie.onclick = (event) => {
        $('#editBtnOb').hide();
        $('#addBtnOb').show();
        $('#yearError').hide();
        $('#editOborudovanieModal').modal('show');
        $('#editOborudovanieModal .modal-title').text('Добавление оборудования');
        let select_type_oborudovanie = document.getElementById('select_type_oborudovanie');
        select_type_oborudovanie.options[0].selected = true;
        // document.getElementById('edit_cost').value = '';
        document.getElementById('edit_date_create').value = '';
        document.getElementById('edit_date_release').value = '';
        // document.getElementById('edit_model_prozvoditel').value = '';
        document.getElementById('filterSerialNumber').value = '';
        document.getElementById('zavod_nomer').value = '';
        document.getElementById('edit_date_postavki').value = '';
        document.getElementById('edit_date_postavki').value = '';
        document.getElementById('filterServicemans').value = '';
        // document.getElementById('select_serviceman').value = '';
        document.getElementById('edit_date_last_TO').value = '';


        let select_status = document.getElementById('select_status');
        select_status.options[0].selected = true;
    }
}
</script>  
";

    ?>