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

    if ($id_role == 1) {
        $query = "SELECT id_user, email, uz.name, uz.unp, uz.id_oblast, login, password, zayavka, `active` FROM users
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
                                <th>УНП организации</th>
                                <th>Область</th>
                                <th>Email</th>
                                <th>Логин</th>
                                <th>Зашифрованный пароль</th>
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
            7 => 'МИНСК',
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
            $active = $row['active'];
            echo '<tr data-id=' . $id_user . '  >';
            echo '<td>' . $name . '</td>';
            echo '<td>' . $unp . '</td>';
            echo '<td>' . (isset($oblast_names[$id_oblast]) ? $oblast_names[$id_oblast] : 'Неизвестная область') . '</td>'; // Заменяем ID на название области
            echo '<td>' . $email . '</td>';
            echo '<td>' . $loginOrg . '</td>';
            echo '<td style="cursor: pointer" id="td-change-pass"  data-pass="' . $password . '">' . $password . '</td>';
            if($zayavka !== null)
                echo '<td><a target="_blank" href="'.$zayavka.'">' . $name . '</a></td>';
            else
                echo '<td></td>';
            echo '<td><button class="btn btn-danger" onclick="deletePodUser(' . $id_user . ')">&#10060;</button> 
                      <button class="btn btn-warning" onclick="editPodUser(' . $id_user . ', \'' . $name . '\', \'' . $unp . '\', \'' . $id_oblast . '\', \'' . $email . '\', \'' . $loginOrg . '\', \'' . $password . '\')">Редактировать</button>
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
<script>
    $(document).ready(function() {
         if ($("#infoObAll").length) {
            $("#infoObAll").DataTable().destroy();
        }
        $("#infoObAll").DataTable({
        "order": [[0, "asc"]],
        "pageLength": 10 
        });
         
           
    });

    
    function modalAddUser(){
        $("#uz_name").val("");
        $("#uz_unp").val("");
        $("#uz_email").val("");
        $("#login_org").val("");
        $("#password_org").val("");
        $("#saveUserBtn").show();
        $("#saveEditedUserBtn").hide();
        $("#addUserModal").modal("show");
    }
    
    function changeActive(el){
       
         $.ajax({ 
                url: "app/ajax/changeActive.php",
                method: "POST",
                data: {id_user: el.getAttribute("data-id"), active: el.checked}
            }).then((response) => {
                               
            })
   
    }
    
let selected_user;
    function editPodUser(id_user, name, unp, id_oblast, email, login, password) {
        selected_user = id_user;
        $("#uz_name").val(name);
        $("#uz_unp").val(unp);
        $("#uz_email").val(email);
        $("#login_org").val(login);
        $("#password_org").val(password);
     
        $("#saveUserBtn").hide();
        $("#saveEditedUserBtn").show();
        $("#addUserModal").modal("show");
        $("#sel_obls").val(id_oblast); 
    }
    
    function addUser(id_obl){
        if($("#uz_name").val() == "" || $("#login_org").val() == "" || $("#password_org").val() == "" || $("#uz_unp").val() == "" || $("#uz_email").val() == ""){
            alert("Не все поля заполнены!");
        }else{
            let formData = new FormData();
            formData.append("uz_name", $("#uz_name").val());
            formData.append("uz_unp", $("#uz_unp").val());
            formData.append("email", $("#uz_email").val());
            formData.append("login_org", $("#login_org").val());
            formData.append("password_org", $("#password_org").val());
            formData.append("id_obl", id_obl);
            formData.append("sel_obl", $("#sel_obls").val());
            formData.append("zayavka", $("#zayavka")[0].files[0]); // Добавляем файл
            
            // Отправляем AJAX-запрос
            $.ajax({ 
                url: "app/ajax/addUser.php",
                method: "POST",
                data: formData,
                processData: false, // Не обрабатывать данные
                contentType: false // Не устанавливать заголовок Content-Type
            }).then((response) => {
                if(response == "0"){
                    alert("Пользователь с таким логином или наименованием уже существует.");
                } else {
                    alert("Организация добавлена.");
                    location.reload();
                }
                
            })
        }
    }

    function updateUser(id_user) {
        if($("#uz_name").val() == "" || $("#login_org").val() == "" || $("#password_org").val() == "" || $("#uz_unp").val() == "" || $("#uz_email").val() == ""){
            alert("Не все поля заполнены!");
        } else {
            let formData = new FormData();
            formData.append("id_user", selected_user);
            formData.append("uz_name", $("#uz_name").val());
            formData.append("uz_unp", $("#uz_unp").val());
            formData.append("email", $("#uz_email").val());
            formData.append("login_org", $("#login_org").val());
            formData.append("password_org", $("#password_org").val());
            formData.append("id_obl", $("#sel_obls").val());
            formData.append("sel_obl", $("#sel_obls").val());
            formData.append("zayavka", $("#zayavka")[0].files[0]); // Добавляем файл
            
            // Отправляем AJAX-запрос
            $.ajax({ 
                url: "app/ajax/updateUser.php",
                method: "POST",
                data: formData,
                processData: false, // Не обрабатывать данные
                contentType: false // Не устанавливать заголовок Content-Type
            }).then((response) => {
                if(response == "0"){
                    alert("Пользователь с таким логином или наименованием уже существует.");
                } else {
                    alert("Организация изменена.");
                    location.reload();
                }
                
            })
        }
    }
    
    
     function deletePodUser(id_user) {
        if (confirm("Вы уверены, что хотите удалить пользователя?")) {
            $.ajax({
                url: "app/ajax/deletePodUser.php",
                method: "GET",
                data: { id_user: id_user }
            }).done(function (response) {
                alert("Пользователь удален.");
                location.reload();
            });
        }
    }
    
    function filterZayavka(el){

        var table = $("#infoObAll").DataTable();
       if(el.checked){
           $("#infoObAll tbody tr").filter(function() {
                return $(this).find("td").eq(5).text().trim() === ""; // Если пусто
           }).hide(); // Скрываем строки, где "Заявка" пуста
       }
       else{
           $("#infoObAll tbody tr").filter(function() {
                return $(this).find("td").eq(5).text().trim() === ""; // Если пусто
           }).show();
       }
      
       table.page.len(-1).draw();
    }
</script>
';
?>
