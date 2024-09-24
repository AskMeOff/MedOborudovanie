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
        $query = "select * from uz where id_oblast = '$id_obl';";
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
        $statuses = ['исправно', 'неисправно'];
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
        if (!isset($_GET['id_type'])) {
            echo '           <div>  <button class="btn btn-info" onclick="startFilter()" style=" margin-top: 10px; ">Фильтры</button> 
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
            <div id="filterContainer" style="display: none;">
            <div class = "filtCol row">
                        <div class="col-lg-4">

                 <label for="filterEquipment">Вид оборудования:</label>
                 <select id="filterEquipment" onchange="filterTable()">
                 <option value="">Все</option>';
            foreach ($equipmentTypes as $type) {
                echo '<option value="' . $type . '">' . $type . '</option>';
            }

            echo '  </select>
            </div>
                        <div class="col-lg-4">

            <label for="filterYear">Год производства:</label>
            <input type="date" id="filterYear" onchange="filterTable()">
            </div>
            <div class="col-lg-4">

            <label for="filterDatePostavki">Дата поставки:</label>
            <input type="date" id="filterDatePostavki" onchange="filterTable()">
</div>
            </div>
            <div class = "filtCol row">
                        
            <div class="col-lg-4">

            <label for="filterDateRelease">Дата ввода в эксплуатацию:</label>
            <input type="date" id="filterDateRelease" onchange="filterTable()">
            </div>
            <div class="col-lg-4">

            <label for="filterService">Сервисная организация:</label>
            <select id="filterService" onchange="filterTable()">
                <option value="">Все</option>';
            foreach ($serviceNames as $service) {
                echo '<option value="' . $service . '">' . $service . '</option>';
            }
            echo '  </select>
</div>
            <div class="col-lg-4">

            <label for="filterStatus">Статус:</label>
            <select id="filterStatus" onchange="filterTable()">
                <option value="">Все</option>';
            foreach ($statuses as $status) {
                echo '<option value="' . $status . '">' . $status . '</option>';
            }
            echo '  </select>
  </div>
            </div>
           
                   </div>  ';
        }
        echo '
<section class="col-lg-9 connectedSortable ui-sortable" id="orgAll" style="display: block;">
                
                <div class="row">

                    <div class="table-responsive">
                        <table class="table table-striped table-responsive-sm dataTable no-footer" id="infoObAll">
                               <!--style="display: block"-->
                            <thead>
                            <tr>
                                <th>Организация</th>
                                <th>Модель, производитель</th>
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
        if (!isset($_GET['id_type'])) {
            if ($id_role == 4) {
                $sql1 = "SELECT oborudovanie.*, type_oborudovanie.name, uz.name as poliklinika, s.name as servname FROM oborudovanie 
                                        INNER JOIN uz on oborudovanie.id_uz=uz.id_uz
                                        left outer join type_oborudovanie on oborudovanie.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
                                        left outer join servicemans s on s.id_serviceman = oborudovanie.id_serviceman
                                        WHERE uz.id_oblast=$id_obl and uz.id_uz = $id_uz and (oborudovanie.status = 0)";
            } else if ($id_role == 2 || $id_role == 1) {
                $sql1 = "SELECT oborudovanie.*, type_oborudovanie.name, uz.name as poliklinika, s.name as servname FROM oborudovanie 
                                        INNER JOIN uz on oborudovanie.id_uz=uz.id_uz
                                        left outer join type_oborudovanie on oborudovanie.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
                                        left outer join servicemans s on s.id_serviceman = oborudovanie.id_serviceman
                                        WHERE uz.id_oblast=$id_obl  and (oborudovanie.status = 0)";
            } else if ($id_role == 3) {
                if ($id_obl == $idoblguzo) {
                    $sql1 = "SELECT oborudovanie.*, type_oborudovanie.name, uz.name as poliklinika, s.name as servname FROM oborudovanie 
                                        INNER JOIN uz on oborudovanie.id_uz=uz.id_uz
                                        left outer join type_oborudovanie on oborudovanie.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
                                        left outer join servicemans s on s.id_serviceman = oborudovanie.id_serviceman
                                        WHERE uz.id_oblast=$id_obl  and (oborudovanie.status = 0)";
                } else {
                    echo "Данные недоступны для вашей области.";
                    exit;
                }
            } else {
                echo "Данные недоступны. Требуется Авторизация";
                exit;
            }
        } else {
            $id_type = $_GET['id_type'];
            $sql1 = "SELECT oborudovanie.*, tob.name, uz.name as poliklinika, s.name as servname FROM oborudovanie 
                                        INNER JOIN uz on oborudovanie.id_uz=uz.id_uz
                                        left outer join type_oborudovanie tob on oborudovanie.id_type_oborudovanie = tob.id_type_oborudovanie
                                        left outer join servicemans s on s.id_serviceman = oborudovanie.id_serviceman
                                        WHERE uz.id_oblast=$id_obl and tob.id_type_oborudovanie = $id_type and oborudovanie.status = 0";
        }
        $result1 = $connectionDB->executeQuery($sql1);
        while ($row1 = mysqli_fetch_assoc($result1)) {
            $poliklinika = $row1['poliklinika'];
            $nameOborudov = $row1['name'];
            $idOborudovanie = $row1['id_oborudovanie'];
            $model = $row1['model'];
            echo '<tr id=idob' . $idOborudovanie . '  >';
            echo '<td>' . $poliklinika . '</td>';
            echo '<td>' . $model . '</td>';
            echo '<td class="vid_oborudovaniya" onclick="getEffectTable(' . $idOborudovanie . ')" style="cursor: pointer; color: #167877;
    font-weight: 550;">' . $nameOborudov . '</td>';
            echo '<td>' . $row1['date_create'] . '</td>';
            echo '<td>' . $row1['date_postavki'] . '</td>';
            echo '<td>' . $row1['date_release'] . '</td>';
            echo '<td>' . $row1['servname'] . '</td>';
            echo '<td>' . $row1['date_last_TO'] . '</td>';
            $status = $row1['status'] === "1" ? "исправно" : "неисправно";
            if ($row1['status'] === "1") {
                echo '<td  onclick="getFaultsTable(' . $idOborudovanie . ')" style="cursor: pointer"><div style = "border-radius: 5px;background-color: green;color: white; padding: 5px;">' . $status . '</div></td>';
            } else {
                echo '<td  onclick="getFaultsTable(' . $idOborudovanie . ')" style="cursor: pointer"><div style = "border-radius: 5px;background-color: red;color: white; padding: 5px; font-size: 11px;width: 85px;">' . $status . '</div></td>';
            }
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
    }


    while ($row = mysqli_fetch_assoc($result)) {

        $id_uz = $row['id_uz'];


        echo ' <section class="col-lg-9 connectedSortable ui-sortable" id="org' . $id_uz . '" style="display: none;">
                
                <div class="row">

                    <div class="table-responsive">
                        <table class="table table-striped table-responsive-sm dataTable no-footer" id="infoOb' . $id_uz . '"
                               style="display: none">
                            <thead>
                            <tr>
                                <th>Вид оборудования</th>
                                <th>Модель, производитель</th>
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
                                        where id_uz = $id_uz and status in (0,1)";
        $result1 = $connectionDB->executeQuery($sql1);
        while ($row1 = mysqli_fetch_assoc($result1)) {
            $nameOborudov = $row1['name'];
            $idOborudovanie = $row1['id_oborudovanie'];
            $model = $row1['model'];
            echo '<tr id=idob' . $idOborudovanie . '  >';

            echo '<td onclick="getEffectTable(' . $idOborudovanie . ')" style="cursor: pointer; color: #167877;
    font-weight: 550;">' . $nameOborudov . '</td>';
            echo '<td>' . $model . '</td>';
            echo '<td>' . $row1['date_create'] . '</td>';
            echo '<td>' . $row1['date_postavki'] . '</td>';
            echo '<td>' . $row1['date_release'] . '</td>';
            echo '<td>' . $row1['servname'] . '</td>';
            echo '<td>' . $row1['date_last_TO'] . '</td>';
            $status = $row1['status'] === "1" ? "исправно" : "неисправно";
            if ($row1['status'] === "1") {
                echo '<td  onclick="getFaultsTable(' . $idOborudovanie . ')" style="cursor: pointer"><div style = "border-radius: 5px;background-color: green;color: white; padding: 5px;">' . $status . '</div></td>';
            } else {
                echo '<td  onclick="getFaultsTable(' . $idOborudovanie . ')" style="cursor: pointer"><div style = "border-radius: 5px;background-color: red;color: white; padding: 5px; font-size: 11px; width: 85px;">' . $status . '</div></td>';
            }
            echo '<td><a href="#" onclick="confirmDeleteOborudovanie(' . $idOborudovanie . ')"><i class="fa fa-trash" style="font-size: 20px;"></i></a><a href="#" onclick="editOborudovanie(' . $idOborudovanie . ')"><i class="fa fa-edit" style="font-size: 20px;"></i>️</a></td>';
            echo '</tr>';
        }

        echo ' 
                            </tbody>
                        </table>
     
                    </div>
                </div>

            </section>';
    }


    echo '<section class="col-lg-3" id="right_section" style="transition: transform 1s;">
<a class="nav-link sidebartoggler nav-icon-hover" onclick="toggleRightSection()" style="margin-top: 10px; cursor: pointer; color: rgb(152, 212, 212)" >
                    <i class="ti ti-arrow-right" style="font-size: 30px; "></i>
                </a>
    <div><input style="width:100%;" type="text" id="myInputOrg" onkeyup="myFunctionOrg(this)"
                placeholder="Поиск организации"
                title="Type in a name">
    </div>';


    if ($id_role == 4) {
        $sql = "select * from uz where id_oblast = $id_obl and id_uz = $id_uz";
    } else if ($id_role == 2 || $id_role == 1) {
        $sql = "select * from uz where id_oblast = $id_obl and id_uz is not null";
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

                    <label for="time_repair">Время ремонта:</label>
                    <input type="date" id="time_repair" name="time_repair">

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
</div>


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

                    <input type="hidden" id="edit_id_use_efficiency" name="id_use_efficiency">

                    <div id="edit_btnsGroup" style="margin-top: 10px;">
                        <button type="submit" class="btn btn-info">Сохранить</button>
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
                     <label for="model_prozvoditel">Модель, производитель:</label>
                    <input type="text" id="edit_model_prozvoditel" name="model_prozvoditel">
                   
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
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>';
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
