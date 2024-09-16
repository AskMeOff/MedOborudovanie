<?php
require_once 'connection/connection.php';
echo '

<link rel="stylesheet" href="css/minsk.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<section class="content" style="margin-top: 80px; margin-left: 15px">
    <div class="container-fluid" id="container_fluid" style="overflow: auto; height: 85vh;">
        <div class="row" id="main_row">';


//-----------ДЛЯ ОРГАНИЗАЦИЙ -------------------------------------

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

    if ($id_role == 1) {
        $query = "select id_user, uz.name, login, password from users
                left join uz on uz.id_uz = users.id_uz
                where users.id_role = 4";
    } else {
        $query = "select id_user, uz.name, login, password from users
                left join uz on uz.id_uz = users.id_uz
                where uz.id_oblast = '$idoblguzo' and users.id_role = 4";
    }

    $result = $connectionDB->executeQuery($query);
    if ($connectionDB->getNumRows($result) == 0) {


        echo '<div class="alert alert-warning">Организаций в вашей области нет.</div>';
        echo '      <div>  <button class="btn btn-info" onclick="modalAddUser()">Добавить организацию</button></div>';
        echo '<section class="col-lg-9 connectedSortable ui-sortable"  style="display: block;">

                <div class="row">
                </div>
                </section>';
    } else {

        echo '
<section class="col-lg-9 connectedSortable ui-sortable" id="orgAll" style="display: block;">
                <div>  <button class="btn btn-info" onclick="modalAddUser()">Добавить организацию</button></div>
                <div class="row">

                    <div class="table-responsive">
                        <table class="table table-striped table-responsive-sm dataTable no-footer" id="infoObAll">
                               <!--style="display: block"-->
                            <thead>
                            <tr>
                                <th>Наименование организации</th>
                                <th>Логин</th>
                                <th>Зашифрованный пароль</th>
                                
                            </tr>
                            </thead>
                            <tbody>';


        while ($row = mysqli_fetch_assoc($result)) {
            $name = $row['name'];
            $id_user = $row['id_user'];
            $loginOrg = $row['login'];
            $password = $row['password'];
            echo '<tr data-id=' . $id_user . '  >';
            echo '<td>' . $name . '</td>';
            echo '<td>' . $loginOrg . '</td>';
            echo '<td style="cursor: pointer" contenteditable="true" onblur="changePass(event)" data-pass="' . $password . '">' . $password . '</td>';
            echo '<td><button class="btn btn-danger" onclick="deletePodUser(' . $id_user . ')">&#10060;</button></td>';
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


    echo '</div>
    </div>
</section>

<div class="modal" id="addUserModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление организации</h5>
                <button type="button" class="btn btn-danger btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <div >
                    <label for="uz_name">Наименование организации</label>
                    <input type="text" id="uz_name" name="uz_name">

                    <label for="login_org">Логин</label>
                    <input type="text" id="login_org" name="login_org">

                    <label for="password_org">Пароль</label>
                    <input type="text" id="password_org" name="password_org">
                    ';
    if ($id_role == 1) {
        echo '<label for="sel_obls">Область</label>
                    <select id="sel_obls" class="form-select">';
        $query_obls = 'select * from oblast';
        $rez = $connectionDB->executeQuery($query_obls);
        for ($data = []; $row = mysqli_fetch_assoc($rez); $data[] = $row) ;
        foreach ($data as $obls) {
            echo '<option value="' . $obls['id_oblast'] . '">' . $obls['name'] . '</option>';
        }
        echo '  </select>';
    };


    echo '<div id="btnsGroup" style="margin-top: 10px;">
                        <button type="button" class="btn btn-info" onclick="addUser(' . $idoblguzo . ')">Добавить пользователя</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
';

} //-----------ДЛЯ АДМИНОВ И ОСТАЛЬНЫХ -------------------------------------
else {
    echo 'Данные недоступны. Требуется авторизация.';

}


echo '
<script>
    $(document).ready(function() {
         if ($("#infoObAll").length) {
            $("#infoObAll").DataTable().destroy();
        }
        $("#infoObAll").DataTable({
        "order": [[0, "asc"]],
        "pageLength": 15 
        });
    });
    
    function modalAddUser(){
        $("#addUserModal").modal("show");
    }
    
    function addUser(id_obl){
        if($("#uz_name").val() == "" || $("#login_org").val() == "" || $("#password_org").val() == ""){
            alert("Не все поля заполнены!");
        }else{
            $.ajax({
                url: "app/ajax/addUser.php",
                method: "POST",
                data: {uz_name: $("#uz_name").val(), login_org: $("#login_org").val(), password_org: $("#password_org").val(), id_obl: id_obl, sel_obl: $("#sel_obls").val()}
            }).then((response) => {
                if(response == "0"){
                   alert("Пользователь с таким логином или наименованием уже существует.");
                }else{
                    alert("Организация добавлена.");
                    location.reload();
                }
                
            })
        }
    }
    
    function changePass(event){
        
        let thisEl = event.target;
        let id = thisEl.parentElement.getAttribute("data-id");
        let nameOrg = thisEl.parentElement.children[0].innerHTML;
        let oldPass = thisEl.getAttribute("data-pass");
        let newPass = thisEl.innerHTML;
        if(oldPass == newPass){
            return;
        }
        else{
            $.ajax({
                url: "app/ajax/changePass.php",
                method: "POST",
                data: {id: id, newPass: newPass}
            }).then((response) => {
                if(response == "0"){
                   alert("Ошибка изменения пароля.");
                }
                alert("Пароль организации " + nameOrg + " изменен.");
                location.reload();
            })
        }
    }
    
    
     function deletePodUser(id_user) {
        if (confirm("Вы уверены, что хотите удалить пользователя?")) {
            $.ajax({
                url: "app/ajax/deletePodUser.php",
                method: "POST",
                data: { id_user: id_user }
            }).then((response) => {
                if (response == "1") {
                    alert("Пользователь удален.");
                    location.reload(); 
                } else {
                    alert("Ошибка при удалении.");
                }
            });
        }
    }
    
    
</script>
';
?>
