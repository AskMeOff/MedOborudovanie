<?php
if(isset($_GET['oborud']))
    $id_type = $_GET['oborud'];
echo "ono = " . $id_type;
?>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
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

<section class="col-lg-12 connectedSortable ui-sortable" style="margin-top: 90px;">

    <?php

    if (isset($id_role )) {
        if ($id_role == 1 || $id_role == 2 || $id_role == 3) {
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
            $sqlTypes = "SELECT DISTINCT name FROM type_oborudovanie";
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
    margin-left: 1.5vw; width: 96%; overflow-x: scroll;">
                
                <div class="row">

                    <div style="-webkit-overflow-scrolling: touch;">
                        <table class="table table-striped table-responsive-sm dataTable no-footer" id="infoOb' . $id_uz . '"
                               style="display: block; width: 81vw; height:62vh;">
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
                                <th>Действия  </th>
                            </tr>
                            </thead>
                            <tbody>';

            if($id_type !== "")
            $sql1 = "SELECT oborudovanie.*, type_oborudovanie.name, s.name as servname FROM oborudovanie
                                        left outer join type_oborudovanie on oborudovanie.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
                                        left outer join servicemans s on s.id_serviceman = oborudovanie.id_serviceman
                                        where id_uz = $id_uz and status in (0,1,3) and oborudovanie.id_type_oborudovanie = '$id_type' order by oborudovanie.id_oborudovanie desc";
            else
                $sql1 = "SELECT oborudovanie.*, type_oborudovanie.name, s.name as servname FROM oborudovanie
                                        left outer join type_oborudovanie on oborudovanie.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
                                        left outer join servicemans s on s.id_serviceman = oborudovanie.id_serviceman
                                        where id_uz = $id_uz and status in (0,1,3) order by oborudovanie.id_oborudovanie desc";
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
           <a href="#" onclick="confirmDeleteOborudovanie1(' . $idOborudovanie . ')"><i class="fa fa-trash" style="font-size: 20px;"></i></a>
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

    $query = "select * from type_oborudovanie";
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



    ?>
    <div id="preloader" style="display:none;">
            <div class="loader"></div>
    </div>
</section>
<?php
echo '
<div class="modal" id="faultsModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Таблица неисправностей</h5>
                <button type="button" class="btn  btn-danger btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addFaultModal">
                    Добавить
                </button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="effectModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Таблица эффективности использования оборудования</h5>
                <button type="button" class="btn  btn-danger btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addEffectModal">
                    Добавить
                </button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Успех</h5>
                <button type="button" class="btn  btn-danger btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div>Запись успешно удалена</div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="saveModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Успех</h5>
                <button type="button" class="btn  btn-danger btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div>Запись успешно обновлена</div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Успех</h5>
                <button type="button" class="btn  btn-danger btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div>Запись успешно добавлена</div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="addFaultModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление неисправности</h5>
                <button type="button" class="btn btn-danger btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <div >
                    <label for="date_fault">Дата обнаружения неисправности:</label>
                    <input type="date" id="date_fault" name="date_fault">

                    <label for="date_call_service">Дата вызова сервиса:</label>
                    <input type="date" id="date_call_service" name="date_call_service">

                    <label for="reason_fault">Причина неисправности:</label>
                    <input type="text" id="reason_fault" name="reason_fault">

                    <label for="date_procedure_purchase">Дата процедуры закупки:</label>
                    <input type="date" id="date_procedure_purchase" name="date_procedure_purchase">
                    
                    <!---->
                    <label for="date_dogovora">Дата заключения договора:</label>
                    <input type="date" id="date_dogovora" name="date_dogovora">
                    <!---->

                    <label for="cost_repair">Стоимость ремонта:</label>
                    <input type="number" id="cost_repair" name="cost_repair">

                    <label for="time_repair">Срок ремонта/поставки запасных частей:</label>
                    <input type="date" id="time_repair" name="time_repair">
                    
                    <label for="add_remontOrg">Организация осуществляющая ремонт:</label>
                    <input type="text" id="add_remontOrg" name="add_remontOrg">

                    <label for="document"> Прикрепить документ: </label>
                    <input type="file" id="document_neispravnost" name="document" accept=".pdf,.doc,.docx,.jpg,.png">
               <!--     <label for="downtime">Продолжительность простоя:</label>
                    <input type="text" id="downtime" name="downtime">-->
                    <div id="btnsGroup" style="margin-top: 10px;">
                        <button type="button" class="btn btn-info" onclick="addFualt()">Добавить запись</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';

echo'
<div class="modal" id="addEffectModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление эффективности</h5>
                <button type="button" class="btn btn-danger btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <div id="addEffectForm">
                    <label for="count_research">Количество проведенных исследований:</label>
                    <input type="number" id="count_research" name="count_research">

                    <label for="count_patient">Количество обследованных пациентов:</label>
                    <input type="number" id="count_patient" name="count_patient">
                    
                    <label for="data_year_efficiency">Год:</label>
<select id="data_year_efficiency" name="data_year_efficiency" class="styled-select">
    <option value="" selected disabled>Выберите год</option>
    <option value="2025">2025</option>
    <option value="2024">2024</option>
    <option value="2023">2023</option>


</select>
                    
<label for="data_month_efficiency">Месяц:</label>
<select id="data_month_efficiency" name="data_month_efficiency" class="styled-select">
    <option value="" selected disabled>Выберите месяц</option>
    <option value="Январь">Январь</option>
    <option value="Февраль">Февраль</option>
    <option value="Март">Март</option>
    <option value="Апрель">Апрель</option>
    <option value="Май">Май</option>
    <option value="Июнь">Июнь</option>
    <option value="Июль">Июль</option>
    <option value="Август">Август</option>
    <option value="Сентябрь">Сентябрь</option>
    <option value="Октябрь">Октябрь</option>
    <option value="Ноябрь">Ноябрь</option>
    <option value="Декабрь">Декабрь</option>
</select>
        <input type="hidden" id="edit_id_use_efficiency" name="id_use_efficiency">
                    

                    <div id="btnsGroupEffect" style="margin-top: 10px;">
                        <button type="button" onclick = "addEffectR()" class="btn btn-info">Добавить запись</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="editFaultModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование неисправности</h5>
                <button type="button" class="btn btn-danger btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <div>
                    <label for="date_fault">Дата обнаружения неисправности:</label>
                    <input type="date" id="edit_date_fault" name="date_fault">

                    <label for="date_call_service">Дата вызова сервиса:</label>
                    <input type="date" id="edit_date_call_service" name="date_call_service">

                    <label for="reason_fault">Причина неисправности:</label>
                    <input type="text" id="edit_reason_fault" name="reason_fault">

                    <label for="date_procedure_purchase">Дата процедуры закупки:</label>
                    <input type="date" id="edit_date_procedure_purchase" name="date_procedure_purchase">
                    
                    <!---->
                    <label for="date_dogovora">Дата заключения договора:</label>
                    <input type="date" id="edit_date_dogovora" name="date_dogovora">
                    <!---->

                    <label for="cost_repair">Стоимость ремонта:</label>
                    <input type="number" id="edit_cost_repair" name="cost_repair">

                    <label for="time_repair">Время ремонта:</label>
                    <input type="date" id="edit_time_repair" name="time_repair">
                    
                    <label for="remont">Отремонтировано</label>
                    <select id="edit_remont" name="remont">
                   
                    
    <option value="">Выберите</option>
    <option value="1">Да</option>
    <option value="0">Нет</option>
</select>



                    <label for="date_remont">Дата ремонта:</label>
                    <input type="date" id="edit_date_remont" name="date_remont">
                    
                    <label for="edit_remontOrg">Организация осуществляющая ремонт:</label>
                    <input type="text" id="edit_remontOrg" name="edit_remontOrg">
                    
<label for="document">Прикрепить документ:</label>
<input type="file" id="document_neispravnost_edit" name="document" accept=".pdf,.doc,.docx,.jpg,.png">
<div id="document_link" style="display:none;"></div>
            <!--        <label for="downtime">Продолжительность простоя:</label>
                    <input type="text" id="edit_downtime" name="downtime">-->

                    <input type="hidden" id="edit_id_fault" name="id_fault">

                    <div id="edit_btnsGroup" style="margin-top: 10px;">
                        <button type="button" class="btn btn-info" onclick="btnSaveFault()">Сохранить</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';
echo '
<div class="modal" id="editEffectModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование</h5>
                <button type="button" class="btn btn-danger btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <form id="editEffectForm">
                    <label for="count_research">Количество проведенных исследований:</label>
                    <input type="number" id="edit_count_research" name="count_research">

                    <label for="count_patient">Количество обследованных пациентов:</label>
                    <input type="number" id="edit_count_patient" name="count_patient">
                    
                    <label for="data_year_efficiency">Год:</label>
                    <select id="edit_data_year_efficiency" name="data_year_efficiency" class="styled-select">
    <option value="" selected disabled>Выберите год</option>
    <option value="2024">2024</option>
    <option value="2023">2023</option>
    <option value="2022">2022</option>
    <option value="2021">2021</option>
    <option value="2020">2020</option>
</select>
                    
                    <label for="data_month_efficiency">Месяц:</label>
                    <select id="edit_data_month_efficiency" name="data_month_efficiency" class="styled-select">
                    <option value="" selected disabled>Выберите месяц</option>
    <option value="Январь">Январь</option>
    <option value="Февраль">Февраль</option>
    <option value="Март">Март</option>
    <option value="Апрель">Апрель</option>
    <option value="Май">Май</option>
    <option value="Июнь">Июнь</option>
    <option value="Июль">Июль</option>
    <option value="Август">Август</option>
    <option value="Сентябрь">Сентябрь</option>
    <option value="Октябрь">Октябрь</option>
    <option value="Ноябрь">Ноябрь</option>
    <option value="Декабрь">Декабрь</option>
</select>

                    <input type="hidden" id="edit_id_use_efficiency" name="id_use_efficiency">

                    <div id="edit_btnsGroup" style="margin-top: 10px;">
                        <button type="button" class="btn btn-info" onclick="saveEffectData()">Сохранить</button>                    
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>'; ?>