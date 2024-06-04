<?php
require_once '../../../connection/connection.php';
echo '<link rel="stylesheet" href="css/minsk.css">
<section class="content" style="margin-top: 100px; margin-left: 15px">
    <div class="container-fluid" id="container_fluid">

        <div class="row" id="main_row">';

if (isset($_GET['id_obl'])) {
    $id_obl = $_GET['id_obl'];
}

$query = "select * from uz where id_oblast = '$id_obl';";
$result = $connectionDB->executeQuery($query);
if ($connectionDB->getNumRows($result) == 0) {
    echo '<section class="col-lg-9 connectedSortable ui-sortable"  style="display: block;">
                <div class="row">
                </div>
                </section>';
}
while ($row = mysqli_fetch_assoc($result)) {

    $id_uz = $row['id_uz'];

    echo ' <section class="col-lg-9 connectedSortable ui-sortable" id="org' . $id_uz . '" style="display: block;">
                <div class="row">

                    <div class="table-responsive">
                        <table class="table table-striped table-responsive-sm dataTable no-footer" id="infoOb' . $id_uz . '"
                               style="display: none">
                            <thead>
                            <tr>
                                <th>Тип оборудования</th>
                                <th>Стоимость</th>
                                <th>Дата производства</th>
                                <th>Дата ввода в эксплуатацию</th>
                                <th>Сервисная организация</th>
                                <th>Дата последнего ТО</th>
                                <th>Статус </th>
                                <th>Действия </th>
                            </tr>
                            </thead>
                            <tbody>';
    $sql1 = "SELECT oborudovanie.*, type_oborudovanie.name FROM oborudovanie
                                        left outer join type_oborudovanie on oborudovanie.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
                                        where id_uz = $id_uz";
    $result1 = $connectionDB->executeQuery($sql1);
    while ($row1 = mysqli_fetch_assoc($result1)) {
        $nameOborudov = $row1['name'];
        $idOborudovanie = $row1['id_oborudovanie'];
        echo '<tr onclick="getEffectTable(' . $idOborudovanie . ')" style="cursor: pointer" >';

        echo '<td>' . $nameOborudov . '</td>';
        echo '<td>' . $row1['cost'] . '</td>';
        echo '<td>' . $row1['date_create'] . '</td>';
        echo '<td>' . $row1['date_release'] . '</td>';
        echo '<td>' . $row1['service_organization'] . '</td>';
        echo '<td>' . $row1['date_last_TO'] . '</td>';
        $status = $row1['status'] === "1" ? "исправно" : "неисправно";
        if ($row1['status'] === "1") {
            echo '<td onclick="getFaultsTable(' . $idOborudovanie . ')" style="cursor: pointer"><div style = "border-radius: 5px;background-color: green;color: white;">' . $status . '</div></td>';
        } else {
            echo '<td onclick="getFaultsTable(' . $idOborudovanie . ')" style="cursor: pointer"><div style = "border-radius: 5px;background-color: red;color: white;">' . $status . '</div></td>';
        }
        echo '<td><a href="#" onclick="confirmDeleteOborudovanie(' . $idOborudovanie . ')">&#10060;</a><a href="#" onclick="editOborudovanie(' . $idOborudovanie . ')">✏️</a></td>';
        echo '</tr>';
    }

    echo ' 
                            </tbody>
                        </table>
     
                    </div>
                </div>

            </section>';
}



echo '<section class="col-lg-3" id="right_section">
    <div><input style="width:100%;" type="text" id="myInputOrg" onkeyup="myFunctionOrg(this)"
                placeholder="Поиск организации"
                title="Type in a name">
    </div>';



    $sql = "select * from uz where id_oblast = $id_obl";
    $result = $connectionDB->executeQuery($sql);
    //                $activeClass = "activecard1";
    while ($row = mysqli_fetch_assoc($result)) {

        echo '<div class="card card0 " onclick="showSection(' . $row['id_uz'] . ',this)">';
        echo '<h4>' . $row['name'] . '</h4>';
        echo '</div>';
//                    $activeClass = "";
    }



  echo '</div>
    </div>
</section>


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
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFaultModal">
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
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEffectModal">
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

                <form id="addFaultForm">
                    <label for="date_fault">Дата обнаружения неисправности:</label>
                    <input type="date" id="date_fault" name="date_fault">

                    <label for="date_call_service">Дата вызова сервиса:</label>
                    <input type="date" id="date_call_service" name="date_call_service">

                    <label for="reason_fault">Причина неисправности:</label>
                    <input type="text" id="reason_fault" name="reason_fault">

                    <label for="date_procedure_purchase">Дата процедуры закупки:</label>
                    <input type="date" id="date_procedure_purchase" name="date_procedure_purchase">

                    <label for="cost_repair">Стоимость ремонта:</label>
                    <input type="number" id="cost_repair" name="cost_repair">

                    <label for="time_repair">Время ремонта:</label>
                    <input type="date" id="time_repair" name="time_repair">

                    <label for="downtime">Простой (в часах):</label>
                    <input type="number" id="downtime" name="downtime">
                    <div id="btnsGroup" style="margin-top: 10px;">
                        <button type="submit" class="btn btn-primary">Добавить запись</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </form>
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

                <form id="addEffectForm">
                    <label for="count_research">Количество проведенных исследований:</label>
                    <input type="number" id="count_research" name="count_research">

                    <label for="count_patient">Количество диагностированных пациентов:</label>
                    <input type="number" id="count_patient" name="count_patient">

                    <div id="btnsGroupEffect" style="margin-top: 10px;">
                        <button type="submit" class="btn btn-primary">Добавить запись</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </form>
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

                <form id="editFaultForm">
                    <label for="date_fault">Дата обнаружения неисправности:</label>
                    <input type="date" id="edit_date_fault" name="date_fault">

                    <label for="date_call_service">Дата вызова сервиса:</label>
                    <input type="date" id="edit_date_call_service" name="date_call_service">

                    <label for="reason_fault">Причина неисправности:</label>
                    <input type="text" id="edit_reason_fault" name="reason_fault">

                    <label for="date_procedure_purchase">Дата процедуры закупки:</label>
                    <input type="date" id="edit_date_procedure_purchase" name="date_procedure_purchase">

                    <label for="cost_repair">Стоимость ремонта:</label>
                    <input type="number" id="edit_cost_repair" name="cost_repair">

                    <label for="time_repair">Время ремонта:</label>
                    <input type="date" id="edit_time_repair" name="time_repair">

                    <label for="downtime">Простой (в часах):</label>
                    <input type="number" id="edit_downtime" name="downtime">

                    <input type="hidden" id="edit_id_fault" name="id_fault">

                    <div id="edit_btnsGroup" style="margin-top: 10px;">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


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

                    <label for="count_patient">Количество диагностированных пациентов:</label>
                    <input type="number" id="edit_count_patient" name="count_patient">

                    <input type="hidden" id="edit_id_use_efficiency" name="id_use_efficiency">

                    <div id="edit_btnsGroup" style="margin-top: 10px;">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
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
                    <label>Тип оборудования:</label>
                    <select class="form-select" id="select_type_oborudovanie">';

                        $query = "select * from type_oborudovanie";
                        $result = $connectionDB->executeQuery($query);
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id_type_oborudovanie'] . "'>" . $row['name'] . "</option>";
                        }

                   echo ' </select>

                    <label for="cost">Стоимость:</label>
                    <input type="number" id="edit_cost" name="cost">
                    <!---->
                    <label for="date_create">Дата производства:</label>
                    <input type="date" id="edit_date_create" name="date_create">
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
echo'

<script>

    const contMenu = document.getElementById("contMenu");
    const body = document.getElementsByTagName("body")[0];
    let selectedEquipmentId;

    function showMenu(thisTr, idOborudovanie) {
        event.preventDefault();
        selectedEquipmentId = idOborudovanie;
    }


</script>
';

