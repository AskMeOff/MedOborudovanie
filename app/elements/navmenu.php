<?php
require_once 'connection/connection.php';
$equipmentTypes = [];
$sqlTypes = "SELECT id_type_oborudovanie, name FROM type_oborudovanie order by name";
$resultTypes = $connectionDB->executeQuery($sqlTypes);
while ($row = mysqli_fetch_assoc($resultTypes)) {
    $equipmentTypes[] = [
            'id_type_oborudovanie' => $row['id_type_oborudovanie'],
            'name' => $row['name']
    ];
}
?>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<aside class="left-sidebar" style="background-color: aliceblue; z-index: 999">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="index.php" class="text-nowrap logo-img">
                <span style="font-size: 24px; color: black; vertical-align: sub; margin-left: 10px; margin-right: 10px; font-weight: 700">РНПЦ МТ</span><img
                        width="45px" src="app/assets/images/logo-rnpcmt.png" width="180" alt=""/>
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->

            <div id="jquery-accordion-menu" class="jquery-accordion-menu white">

                <ul id="demo-list">

                    <li class="active"><a  href="index.php?main" ><i class="fa fa-home"></i>Главная</a></li>
                    <?php
                    if (isset($id_role )){
                        if($id_role == 1 || $id_role == 3){
                            echo "<li><a href='index.php?podusers'><i class='fa fa-user'></i>Мои пользователи</a></li>";
                        }
                    }
                    ?>
                    <li id="menu_oborud"><a href="#"><i class="fa fa-suitcase"></i>Оборудование</a>
                        <ul class="submenu">
                            <li id="menu_ustanovl"><a href="index.php?oborud" onclick="showTooltip(event)">Установленное</a>
                                <ul class="submenu1">
                                    <?php
                                    foreach ($equipmentTypes as $type) {
                                    echo '<li><a onclick="checkHash('.$type["id_type_oborudovanie"].',event)" href="#">'.$type["name"].'</a></li>';
                                    }
                                    ?>
                                </ul></li>

                                <li><a href="index.php?oborud_unspecified">Неустановленное </a></li>
<!--                            <li><a href="#">Design </a>-->
<!--                                <ul class="submenu">-->
<!--                                    <li><a href="#">Graphics </a></li>-->
<!--                                    <li><a href="#">Vectors </a></li>-->
<!--                                    <li><a href="#">Photoshop </a></li>-->
<!--                                    <li><a href="#">Fonts </a></li>-->
<!--                                </ul>-->
<!--                            </li>-->
                        </ul>
                    </li>


                    <li>
                        <a href="index.php?zapchasti">
                            <i class="fa fa-wrench"></i> Запчасти
                        </a>
                    </li>


                    <li><a href="#"><i class="fa fa-file-image-o"></i>Отчеты </a>
                        <ul class="submenu">
                            <!--        <li><a href="index.php?report1">Отчет 1</a></li>-->
                                 <li><a href="index.php?reportNewAddedOb">Отчет о добавленном<br>оборудовании</a></li>
                                 <li><a href="index.php?reportStatisticObor">Статистика оборудования</a></li>
                             </ul>
                         </li>
                         <li>
                             <a href="#">
                                 <i class="fa fa-asterisk"></i> Помощь
                                 <span class="new-icon" style="color: red; font-size: 0.8em; margin-left: 5px;">★</span>
                             </a>
                             <ul class="submenu">
                                 <li>
                                     <a href="index.php?contacts">Контакты</a>
                                 </li>
                                 <li>
                                     <a href="index.php?guides">
                                          Руководство пользователя <span class="new-icon" style="color: red; font-size: 0.8em; margin-left: 5px;">★</span>
                                     </a>
                                 </li>
                             </ul>
                         </li>
                         <li>
                             <a href="index.php?news">
                                 <i class="fa fa-asterisk"></i> Новости
                                 <span class="new-icon" style="color: red; font-size: 0.8em; margin-left: 5px;">!</span>
                             </a>
                         </li>
                         <li><a href="index.php?servicemans"><i class="fa fa-cog"></i>Сервисанты </a></li>



                     </ul>




                 </div>
             <!-- End Sidebar navigation -->
    <!-- End Sidebar scroll-->
</aside>

<script>



    toastr.options = {
        "closeButton": true, // Показывать кнопку закрытия
        "debug": false, // Включить отладку
        "newestOnTop": false, // Добавлять новые сообщения поверх старых
        "progressBar": true, // Показывать прогресс-бар
        "positionClass": "toast-bottom-right", // Позиция: top-right, top-left, bottom-right, bottom-left
        "preventDuplicates": true, // Не показывать дублирующие сообщения
        "onclick": null, // Действие при клике на сообщение
        "showDuration": "500", // Длительность показа
        "hideDuration": "1000", // Длительность скрытия
        "timeOut": "6000", // Время отображения
        "extendedTimeOut": "1000", // Дополнительное время отображения при наведении
        "showEasing": "swing", // Эффект появления
        "hideEasing": "linear", // Эффект скрытия
        "showMethod": "fadeIn", // Метод появления
        "hideMethod": "fadeOut" // Метод скрытия
    }

    function checkHash(id_type, event) {
        selectedEquipmentType = id_type;
        $.ajax({
            url: "app/ajax/getOblsByType.php",
            method: "GET",
            data: {id_type: id_type},
            success: function (data) {
                $("#bodywrap").html(data);
                let lis = document.querySelectorAll('a[onclick*="checkHash"]');
                lis.forEach(li => li.parentElement.style.backgroundColor = "");
                let li = event.target.parentElement;
                li.style.backgroundColor = "darkcyan";
                toastr.info("Теперь можно выбрать область для отображения");
            }
        })
        console.log(id_type);
    }


    function showTooltip(event) {
        toastr.info('При повторном нажатии на пункт "Установленные", фильтрация по видам оборудования учитываться не будет');

    }
</script>