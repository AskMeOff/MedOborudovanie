<?php
require_once 'connection/connection.php';
echo '

<link rel="stylesheet" href="css/minsk.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<section class="content" style="margin-top: 80px; margin-left: 15px">
    <div class="container-fluid" id="container_fluid" style="overflow: auto; height: 85vh;">
        <div class="row" id="main_row">';



if (isset($_COOKIE['token']) && $_COOKIE['token'] !== '') {
    $token = $_COOKIE['token'];
    $getiduz = "SELECT * FROM users WHERE token = '$token';";
    $resultiduz = $connectionDB->executeQuery($getiduz);
    $userData = $resultiduz->fetch_assoc();
    if ($userData) {
        $id_uz = $userData['id_uz'];
        $id_role = $userData['id_role'];
        $idoblguzo = $userData['id_obl'];
    }
    $query_count = "SELECT count(*) as count_z from users
                WHERE zayavka is not null";
    $result_count = $connectionDB->executeQuery($query_count);
    $row_count = mysqli_fetch_assoc($result_count);
    if ($id_role == 1) {
        $query = "SELECT id_user, email, uz.name, uz.unp, uz.id_oblast, login, password, zayavka, dogovor, `active` FROM users
                LEFT JOIN uz ON uz.id_uz = users.id_uz
                WHERE users.id_role = 4";
    } else {
        echo 'Данные недоступны. Требуется авторизация.';
        return;
    }

    $result = $connectionDB->executeQuery($query);
    if ($connectionDB->getNumRows($result) == 0) {


        echo '<div class="alert alert-warning">Организаций в вашей области нет.</div>';
        echo '      <div>  <button class="btn btn-info" onclick="modalAddUser()">Добавить организацию</button></div>';
        echo '<section class="col-lg-12 connectedSortable ui-sortable"  style="display: block;">

                <div class="row">
                </div>
                </section>';
    } else {

        echo '
<section class="col-lg-12 connectedSortable ui-sortable" id="orgAll" style="display: block;">
                <div style="display: flex;">  <button class="btn btn-info" onclick="modalAddUser()">Добавить организацию</button> <lable style="margin-left: 50px; font-size: 20px">С заявкой: </lable><div style=""><input class="form-check-input" style="margin-left: 5px; vertical-align: -webkit-baseline-middle;" type="checkbox" onchange="filterZayavka(this)">
                 <b style="    vertical-align: -webkit-baseline-middle; margin-left: 15px; font-size: 20px;">'.$row_count['count_z'].'</b></div>
                 <lable style="margin-left: 50px; font-size: 20px">Новые: </lable><div style=""><input class="form-check-input" style="margin-left: 5px; vertical-align: -webkit-baseline-middle;" id="chkbNew" type="checkbox" onchange="filterNew(this)"></div>
                 <lable style="margin-left: 50px; font-size: 20px">С договором: </lable><div style=""><input class="form-check-input" style="margin-left: 5px; vertical-align: -webkit-baseline-middle;" id="chkbDogovor" type="checkbox" onchange="filterDogovor(this)"></div>
                 <lable style="margin-left: 50px; font-size: 20px">Область: </lable><div style=""><select class="form-select" style="margin-left: 5px; vertical-align: -webkit-baseline-middle;" id="selectOblast" onchange="filterOblast(this)">
                 <option value="0">Выберите область</option>
                 <option value="1">Брестская</option>
                 <option value="2">Витебская</option>
                 <option value="3">Гомельская</option>
                 <option value="4">Гродненская</option>
                 <option value="5">Минская</option>
                 <option value="6">Могилевская</option>
                 <option value="7">Минск</option>
                 <option value="8">РНПЦ</option>
</select></div>
                 
                 </div>
                <div class="row">

                    <div class="table-responsive">
                        <table class="table table-striped table-responsive-sm dataTable no-footer" id="infoObAll">
                               <!--style="display: block"-->
                            <thead>
                            <tr>
                                <th>№</th>
                                <th>Наименование организации</th>
                                <th>УНП организации</th>
                                <th>Область</th>
                                <th>Email</th>
                                <th>Логин</th>
                                <th>Зашифрованный пароль</th>
                                <th>Договор</th>
                                <th>Заявка</th>
                                <th>Действия</th>
                                <th>Активность</th>
                            </tr>
                            </thead>
                            <tbody>';

        $oblast_names = [
            1 => 'Брестская',
            2 => 'Витебская',
            3 => 'Гомельская',
            4 => 'Гродненская',
            5 => 'Минская',
            6 => 'Могилевская',
            7 => 'Минск',
            8 => 'РНПЦ'
        ];

        while ($row = mysqli_fetch_assoc($result)) {
            $name = $row['name'];
            $unp = $row['unp'];
            $id_oblast = $row['id_oblast'];
            $email = $row['email'];
            $id_user = $row['id_user'];
            $loginOrg = $row['login'];
            $password = $row['password'];
            $zayavka = $row['zayavka'];
            $dogovor = $row['dogovor'];
            $active = $row['active'];
            echo '<tr data-id=' . $id_user . '  >';
            echo '<td>' . $id_user . '</td>';
            echo '<td>' . $name . '</td>';
            echo '<td>' . $unp . '</td>';
            echo '<td data-id="'. $id_oblast .'">' . (isset($oblast_names[$id_oblast]) ? $oblast_names[$id_oblast] : 'Неизвестная область') . '</td>'; // Заменяем ID на название области
            echo '<td>' . $email . '</td>';
            echo '<td>' . $loginOrg . '</td>';
            echo '<td style="cursor: pointer" id="td-change-pass"  data-pass="' . $password . '">' . $password . '</td>';
            echo '<td>' . $dogovor . '</td>';
            if($zayavka !== null)
                echo '<td><a target="_blank" href="'.$zayavka.'">' . $name . '</a></td>';
            else
                echo '<td></td>';
            echo '<td><button class="btn btn-danger" onclick="deletePodUser(' . $id_user . ')">&#10060;</button> 
                      <button class="btn btn-warning" onclick="editPodUser(this,' . $id_user . ')">Редактировать</button>
                  </td>';
            if($active == "1")
                echo '<td><input data-id=' . $id_user . ' checked="true" type="checkbox" onchange=changeActive(this)></td>';
            else
                echo '<td><input data-id=' . $id_user . ' type="checkbox" onchange=changeActive(this)></td>';

            echo '</tr>';
        }

        echo ' 
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>';
    }


    echo '</div>
    </div>
</section>

<div class="modal" id="addUserModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление/Редактирование организации</h5>
                <button type="button" class="btn btn-danger btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <div >
                    <label for="uz_name">Наименование организации</label>
                    <input type="text" id="uz_name" name="uz_name">

                    <label for="uz_unp">УНП организации</label>
                    <input type="text" id="uz_unp" name="uz_unp">
                    <label for="uz_email">Email организации</label>
                    <input type="text" id="uz_email" name="uz_email">

                    <label for="login_org">Логин</label>
                    <input type="text" id="login_org" name="login_org">

                    <label for="password_org">Пароль</label>
                    <input type="text" id="password_org" name="password_org">
                    
                    <label for="dogovor">Договор</label>
                    <input type="text" id="dogovor" name="dogovor">
                    
                    <label for="zayavka">Заявка</label>
                    <input type="file" id="zayavka" name="zayavka">
                    ';
    if ($id_role == 1) {
        echo '<label for="sel_obls">Область</label>
              <select id="sel_obls" class="form-select">';
        $query_obls = 'SELECT * FROM oblast';
        $rez = $connectionDB->executeQuery($query_obls);
        // Получаем текущую область для редактируемого пользователя
        $currentOblastId = null; // Идентификатор области текущего пользователя
        if (isset($_GET['id_user'])) {
            $currentUserId = $_GET['id_user'];
            $currentOblastQuery = "SELECT id_oblast FROM users WHERE id_user = '$currentUserId'";
            $currentOblastResult = $connectionDB->executeQuery($currentOblastQuery);
            $currentOblastRow = mysqli_fetch_assoc($currentOblastResult);
            $currentOblastId = $currentOblastRow['id_oblast'];
        }
        while ($obls = mysqli_fetch_assoc($rez)) {
            $selected = ($obls['id_oblast'] == $currentOblastId) ? 'selected' : '';
            echo '<option value="' . $obls['id_oblast'] . '" ' . $selected . '>' . $obls['name'] . '</option>';
        }
        echo '</select>';
    }
    echo '<div id="btnsGroup" style="margin-top: 10px;">
                        <button type="button" class="btn btn-info" id="saveUserBtn" onclick="addUser(' . $idoblguzo . ')">Добавить пользователя</button>
                        <button type="button" class="btn btn-info" id="saveEditedUserBtn" onclick="updateUser()">Изменить пользователя</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
';
} else {
    echo 'Данные недоступны. Требуется авторизация.';

}


echo '
<script src="/js/podusers.js">
   
</script>'
?>
