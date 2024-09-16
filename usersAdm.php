<?php
require_once 'connection/connection.php';
?>
<style>

    .container {
        padding: 0rem 0rem;
    }

    .leftSide {
        margin-left: 0;
        margin-right: 0;
    }

    h4 {
        margin: 2rem 0rem 1rem;
    }

    .table-image {

    td, th {
        vertical-align: middle;
    }

    }

</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>

    <div class="content-wrapper">
        <div class="row" id="proBanner">
            <div class="col-12">
                <!--    -->
            </div>
        </div>
        <div class="d-xl-flex justify-content-between align-items-start">
            <h2 class="text-dark font-weight-bold mb-2"> Пользователи </h2>
            <div class="d-sm-flex justify-content-xl-between align-items-center mb-2">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="d-sm-flex justify-content-between align-items-center transaparent-tab-border ">
                    <ul class="nav nav-tabs tab-transparent" role="tablist">
                        <li class="nav-item active ">
                            <a class="nav-link active" id="users-tab" data-toggle="tab" href="#users" role="tab"
                               aria-selected="false">Все пользователи</a>
                        </li>
                    </ul>
                    <div class="d-md-block d-none">

                    </div>
                </div>


                <div class="tab-content tab-transparent-content">
                    <div class="tab-pane fade show active" id="users" role="tabpanel" aria-labelledby="users-tab">

                        <div class="row">
                            <div class="col-12 grid-margin">
                                <div class="card">
                                    <div class="card-body">

                                        <?php
                                        $query = " SELECT * FROM users , uz
                                                WHERE uz.id_uz = users.id_uz and uz.id_uz = '" . $id_uz . "' and id_role = 4;";
                                        $result = mysqli_query($connectionDB->con, $query) or die (mysqli_error($connectionDB->con));
                                        for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row) ;
                                        ?>

                                        <table id="impTable" class="table table-striped table-bordered"
                                               style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>Логин</th>
                                                <th>Почта</th>
                                                <th>Пароль</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php

                                            foreach ($data as $app) {
                                                ?>

                                                <tr style="cursor: pointer; height: 100px;">
                                                    <td style="width: 40%;"><textarea style="width: 100%; height: 100%"
                                                                                      id="luser_<?= $app['id_user'] ?>"
                                                                                      rows="5"><?= $app['login'] ?></textarea>
                                                    </td>
                                                    <td style="width: 40%;"><textarea style="width: 100%; height: 100%"
                                                                                      id="em_<?= $app['id_user'] ?>"
                                                                                      rows="5"><?= $app['email'] ?></textarea>
                                                    </td>
                                                    <td style="width: 40%"><textarea style="width: 100%; height: 100%"
                                                                                     id="puser_<?= $app['id_user'] ?>"
                                                                                     rows="5"><?= $app['password'] ?></textarea>
                                                    </td>

                                                    <td style="width: 10%">
                                                        <button class="btn btn-success btn-fw"
                                                                onclick="savePodUser('<?= $app['id_user'] ?>', document.getElementById('luser_'+'<?= $app['id_user'] ?>').value, document.getElementById('puser_'+'<?= $app['id_user'] ?>').value, document.getElementById('em_'+'<?= $app['id_user'] ?>').value)">
                                                            Сохранить
                                                        </button>
                                                    </td>
                                                    <td style="width: 10%">
                                                        <button class="btn btn-danger btn-fw"
                                                                onclick="deletePodUser('<?= $app['id_user'] ?>')">
                                                            Удалить
                                                        </button>
                                                    </td>

                                                </tr>
                                                <?php
                                            }
                                            ?>

                                            </tbody>

                                        </table>

                                        <div style="margin-top: 0.5rem">
                                            <?php
                                            $id_uz = $login;
                                            $query = " SELECT * FROM users , uz
                                                WHERE uz.id_uz = users.id_uz and uz.name = '" . $id_uz . "' and id_role = 4;";
                                            $result = mysqli_query($connectionDB->con, $query) or die (mysqli_error($connectionDB->con));
                                            if(mysqli_num_rows($result) > 0){
                                                ?>
                                                <button id="btnAddUser" class="btn btn-success btn-fw"
                                                        onclick="addPodUser()">Добавить нового пользователя
                                                </button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function () {

            // var files;
            // $('#pril1').change(function(){
            //     files = this.files;
            // });


        });
    </script>


    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <!--<script>--><?php //include 'getApplication.php' ?><!--</script>-->
    <!--<script>console.log(filesName)</script>-->
    <!-- <script src="dist/js/formApplication.js"></script> -->


    <script>

        function getCookie(cname) {
            let name = cname + "=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }


        let allTabsMainPage = document.getElementsByClassName("tab-content tab-transparent-content");
        let tabs = document.getElementsByClassName("tab-content tab-transparent-content");
    </script>

    <script>



        function savePodUser(id_user, login, password, email) {
            console.log(id_user, login, password);
            if ((!login) || (login === null) || (login.trim() === '')) {
                alert('Поле логин не должно быть пустым!');
                return
            }

            if ((!email) || (email === null) || (email.trim() === '')) {
                alert('Поле почта не должно быть пустым!');
                return
            }

            if ((!password) || (password === null) || (password.trim() === '')) {
                alert('Поле пароль не должно быть пустым!');
                return
            }

            login = login.trim();
            password = password.trim();
            email = email.trim();


            $.ajax({
                url: "ajax/savePodUserGuzo.php",
                method: "GET",
                data: {id_user: id_user, login: login, password: password, email: email, id_role: 14}

            })
                .done(function (response) {
                    alert("Данные сохранены.");
                }).fail((jqXHR, textStatus, errorThrown)=>{
                if(jqXHR.status === 400) {
                    alert("Пользователь с таким логином существует");
                }
                else if(jqXHR.status === 300){
                    alert("Установите другой пароль пользователю");
                }
            })
        }

    </script>

    <script>
        function deletePodUser(id_user) {
            if (confirm("Пользователь будет удален. Удалить?")) {
                $.ajax({
                    url: "ajax/deletePodUserGuzo.php",
                    method: "GET",
                    data: {id_user: id_user}

                })
                    .done(function (response) {
                        alert("Пользователь удален.");
                        location.href = "/index.php?usersAdm";
                    })
            }
        }

        function addPodUser() {
            let impTable = document.getElementById("impTable");
            let tr = impTable.getElementsByTagName("tr");
            let newTr = document.createElement("tr");
            newTr.id = "newTr";
            newTr.style = "cursor: pointer; height: 100px;";
            let td1 = document.createElement("td");
            td1.style = "width: 20%;";
            let textAr1 = document.createElement("textarea");
            textAr1.setAttribute("rows", "5");
            textAr1.style = "width: 100%; height: 100%";
            textAr1.id = "newLogin";
            td1.appendChild(textAr1);
            let td2 = document.createElement("td");
            td2.style = "width: 30%";
            let textAr2 = document.createElement("textarea");
            textAr2.setAttribute("rows", "5");
            textAr2.style = "width: 100%; height: 100%";
            textAr2.id = "newEmail";
            td2.appendChild(textAr2);
            let td5 = document.createElement("td");
            let textAr4 = document.createElement("textarea");
            textAr4.setAttribute("rows", "5");
            textAr4.style = "width: 100%; height: 100%";
            textAr4.id = "newPassword";
            td5.appendChild(textAr4);
            let td3 = document.createElement("td");
            let btn3 = document.createElement("button");
            btn3.className = "btn btn-success btn-fw";
            btn3.innerHTML = 'Сохранить';
            let id_userMain = getCookie('id_user');
            btn3.onclick = () => {
                addNewPodUser(textAr1.value, textAr2.value, textAr4.value,id_userMain)
            };
            td3.appendChild(btn3);

            let td4 = document.createElement("td");
            let btn4 = document.createElement("button");
            btn4.className = "btn btn-danger btn-fw";
            btn4.innerHTML = 'Отмена';
            btn4.onclick = () => {
                newTr.remove();
                let btnAddFaq = document.getElementById('btnAddFaq');
                btnAddFaq.removeAttribute('disabled');
            }
            td4.appendChild(btn4);
            newTr.appendChild(td1);
            newTr.appendChild(td2);
            newTr.appendChild(td5);
            newTr.appendChild(td3);
            newTr.appendChild(td4);

            //   impTable.appendChild(newTr);
            tr[tr.length - 1].insertAdjacentElement("afterend", newTr);
            let btnAddFaq = document.getElementById('btnAddFaq');
            btnAddFaq.setAttribute('disabled', 'True');
        }

        let id_userMain = getCookie('id_user');

        function addNewPodUser(login,  email, password, id_userMain) {
            if ((!login) || (login === null) || (login.trim() === '')) {
                alert('Поле логин не должно быть пустым!');
                return
            }

            if ((!password) || (password === null) || (password.trim() === '')) {
                alert('Поле пароль не должно быть пустым!');
                return
            }

            $.ajax({
                url: "ajax/addPodUserGuzo.php",
                method: "GET",
                data: {id_userMain: id_userMain, login: login, password: password, email:email}

            })
                .done(function (response) {

                    alert("Пользователь добавлен.");
                    location.href = "/index.php?usersAdm";
                }).fail((jqXHR, textStatus, errorThrown)=>{
                console.log(textStatus);
                alert("Пользователь с таким логином существует");
            })

        }


        let sorted = false;

        function sortDate() {
            let table = document.getElementById("example1");
            let trs = table.getElementsByTagName("tr");
            let arr = Array.from(table.rows);
            arr = arr.slice(1);
            arr.sort((a, b) => {

                let str = new Date(a.cells[5].textContent);
                let str2 = new Date(b.cells[5].textContent);

                if (sorted) {

                    if (str < str2)
                        return 1;
                    else if (str > str2) {
                        return -1;
                    } else
                        return 0;

                } else {

                    if (str > str2)
                        return 1;
                    else if (str < str2) {
                        return -1;
                    } else {
                        return 0;
                    }

                }

            });
            if (sorted) {
                sorted = false;
                trs[0].children[5].innerHTML = "Дата ↑";
            } else {
                sorted = true;
                trs[0].children[5].innerHTML = "Дата ↓";
            }
            console.log(sorted);
            table.append(...arr);
        }
    </script>




<script>



</script>

