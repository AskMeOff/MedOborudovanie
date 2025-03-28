<?php
require_once '../../../connection/connection.php';
echo '

<link rel="stylesheet" href="css/minsk.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<section class="content" style="margin-top: 80px; margin-left: 15px">
    <div class="container-fluid" id="container_fluid" style="overflow: auto; height: 85vh;">

        <div class="row" id="main_row">';

if (isset($_GET['id_obl'])) {
    $id_obl = $_GET['id_obl'];
}
if (isset($_GET['status'])) {
    $getStatus = $_GET['status'];
}



//-----------ДЛЯ ОРГАНИЗАЦИЙ -------------------------------------

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

    if ($id_role == 4) {
        $query = "select * from uz where id_oblast = '$id_obl' and id_uz = '$id_uz';";
    } else if ($id_role == 2 || $id_role == 1) {

        if ($id_obl == 111){
            $query = "select * from uz";
        }else {
            $query = "select * from uz where id_oblast = '$id_obl';";
        }
    } else if ($id_role == 3) {
        if ($id_obl == $idoblguzo) {
            $query = "select * from uz where id_oblast = '$id_obl'";
        } else {
            echo "Данные недоступны для вашей области.";
            exit;
        }
    } else {
        echo "Данные недоступны. Требуется Авторизация";
        exit;
    }
    if (isset($query)) {
        $result = $connectionDB->executeQuery($query);
    } else {
        echo "Ошибка: запрос не определен.";
    }


    if ($connectionDB->getNumRows($result) == 0) {


        echo '<div class="alert alert-warning">Данные недоступны для вашей организации.</div>';
        echo '<section class="col-lg-9 connectedSortable ui-sortable"  style="display: block;">

                <div class="row">
                </div>
                </section>';
    } else {
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

            echo '           <div> 
          <button id="btnExportExcel" data-id="" class="btn btn-info" style="margin-left: 2vw;" onclick = "exportTableToExcelAddedOb(\'infoObAll\', \'Таблица_оборудования\')">Экспорт в Excel</button>
<button class="btn btn-info" onclick="startFilter()" style="">Фильтры</button> 
           <a class="nav-link sidebartoggler nav-icon-hover" id="arrow-left" onclick="toggleRightSection()" style="
           position: absolute;
    right: 50px;
    cursor: pointer;
    top: 12%;
    color: rgb(152, 212, 212);
    display: none; z-index: 9999;" >
                    <i class="ti ti-arrow-left" style="font-size: 30px; "></i>
                </a>
           </div> 
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
    <input type="number" id="filterYear" onchange="filterTable1('.$id_uz.')"  min="1900" max="2100" placeholder="YYYY">
</div>
           <div class="col-lg-4">
    <label for="filterDatePostavki">Дата поставки:</label>
    <div>
        <input type="date" id="filterDatePostavkiFrom" class = "halfwidth" onchange="filterTable1('.$id_uz.')">
        <span> до </span>
        <input type="date" id="filterDatePostavkiTo" class = "halfwidth" onchange="filterTable1('.$id_uz.')">
    </div>
</div>
            </div>
            <div class = "filtCol row" style="margin-bottom: 10px; margin-left: 10px;">
                        
<div class="col-lg-4">
    <label for="filterDateRelease">Дата ввода в эксплуатацию:</label>
    <div>
        <input type="date" id="filterDateReleaseFrom" class = "halfwidth" onchange="filterTable1('.$id_uz.')">
        <span> до </span>
        <input type="date" id="filterDateReleaseTo" class = "halfwidth" onchange="filterTable1('.$id_uz.')">
    </div>
</div>
            <div class="col-lg-4">

            <label   for="filterService">Сервисная организация:</label>
            <select id="filterService" onchange="filterTable1('.$id_uz.')">
                <option value="">Все</option>';
        foreach ($serviceNames as $service) {
            echo '<option value="' . $service . '">' . $service . '</option>';
        }
        echo '</select>
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
           </div>';

        echo '
<section class="col-lg-9 connectedSortable ui-sortable" id="orgAll" style="display: block;">

                <div class="row">

                    <div class="table-responsive">
                        <table class="table table-striped table-responsive-sm dataTable no-footer" id="infoObAll">
                               <!--style="display: block"-->
                            <thead>
                            <tr>
                                <th>!!!</th>
                                <th>Организация</th>
                                <th>Модель, производитель</th>
                                <th>Регистрационный номер оборудования</th>
                                <th>Серийный(заводской) номер</th>
                                <th class="vid_oborudovaniya">Вид оборудования</th>
                                <th>Год производства</th>
                                <th>Дата поставки</th>
                                <th>Дата ввода в эксплуатацию</th>
                                <th>Сервисная организация</th>
                                <th>Дата последнего ТО</th>
                                <th>Статус </th>

                            </tr>
                            </thead>
                            <tbody>';
include '../../ajax/getOblastOborudovanie.php';
        echo '
                            </tbody>
                        </table>
                    </div>
                </div>

            </section>
            ';
    }


    while ($row = mysqli_fetch_assoc($result)) {

        $id_uz = $row['id_uz'];


        echo ' <section class="col-lg-9 connectedSortable ui-sortable" id="org' . $id_uz . '" style="display: none;">

               

            </section>';
    }


    echo '<section class="col-lg-3" id="right_section" style="transition: transform 1s;">
<a class="nav-link sidebartoggler nav-icon-hover" onclick="toggleRightSection()" style="margin-top: 10px; cursor: pointer; color: rgb(152, 212, 212); width: 37px;
    position: fixed;
    z-index: 9999;" >
                    <i class="ti ti-arrow-right" style="font-size: 30px; "></i>
                </a>
    <div style = "margin-top: 42px;"><input style="width:100%;" type="text" id="myInputOrg" onkeyup="myFunctionOrg(this)"
                placeholder="Поиск организации"
                title="Type in a name">
    </div>';


    if ($id_role == 4) {
        $sql = "select * from uz where id_oblast = $id_obl and id_uz = $id_uz";
    } else if ($id_role == 2 || $id_role == 1) {
        if ($id_obl == 111) {
            $sql = "select * from uz where id_uz is not null";
            }
        else{
            $sql = "select * from uz where id_oblast = $id_obl and id_uz is not null";
        }
    } else if ($id_role == 3) {
        if ($id_obl == $idoblguzo) {
            $sql = "select * from uz where id_oblast = $id_obl and id_uz is not null";
        } else {
            echo "Данные недоступны для вашей области.";
            exit;
        }
    } else {
        echo 'Данные недоступны. Требуется авторизация';
        exit;
    }
    $result = $connectionDB->executeQuery($sql);
//                $activeClass = "activecard1";
    while ($row = mysqli_fetch_assoc($result)) {

        echo '<div class="card card0 " onclick="showSection(' . $row['id_uz'] . ',this)">';
        echo '<h5>' . $row['name'] . '</h5>';
        echo '</div>';
//                    $activeClass = "";
    }


    echo '</div>
    </div>
</section>';

} //-----------ДЛЯ АДМИНОВ И ОСТАЛЬНЫХ -------------------------------------
else {
    echo 'Данные недоступны. Требуется авторизация.';

}

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
</div>';

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
                    <select class="form-select blink"  id="select_type_oborudovanie">';

$query = "SELECT * FROM type_oborudovanie where id_type_oborudovanie not in (19,29) order by name;";
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
                   
                    <label for="filterSerialNumber">Регистрационный номер оборудования (<a target="_blank" href="https://www.rceth.by/Refbank/reestr_medicinskoy_tehniki"> Реестры УП «Центр экспертиз и испытаний в здравоохранении»</a>): <a target="_blank" href="documents/Видеоинструкция добавления.mp4"><i style="font-size: 24px;" class="fa fa-question"></i><span style="color: red;">Видеоинструкция</span></a></label>
                
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
                        <button type="button" class="btn btn-info" id="addBtnOb" onclick="saveAddedOborudovanie()">
                            Добавить
                        </button>
                        <button type="button" class="btn btn-info" id="editBtnOb" onclick="saveEditedOborudovanie()">
                            Сохранить
                        </button>
                        <button type="button" class="btn btn-danger" id="closeBtnOb" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>';
echo '<div id="popup" class="popup">
    <div class="popup-content-serviceman">
        <span class="close" onclick="closePopup()">&times;</span>
        <h2>Выбор из списка!</h2>
        <p>Данное поле для поиска из текущего списка</p>
        <p>Если в списке нет вашей сервисной организации, то отправьте запрос на добавление по данному электронному адресу: <a href="mailto:sydykav@rnpcmt.by">sydykav@rnpcmt.by</a></p>
        <button class="button" onclick="closePopup()">Закрыть</button>
    </div>
</div>

';
echo '
<script>
    $(document).ready(function() {
         if ($("#infoObAll").length) {
            $("#infoObAll").DataTable().destroy();
        }
        $("#infoObAll").DataTable();
         
       
       
    });
        
</script>
';
?>
