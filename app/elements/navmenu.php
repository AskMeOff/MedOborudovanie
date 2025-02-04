<?php
require_once 'connection/connection.php';


$equipmentTypes = [];
$sqlTypes = "SELECT id_type_oborudovanie, name, parent_id FROM type_oborudovanie ORDER BY parent_id, name";
$resultTypes = $connectionDB->executeQuery($sqlTypes);
while ($row = mysqli_fetch_assoc($resultTypes)) {
    $equipmentTypes[] = [
        'id_type_oborudovanie' => $row['id_type_oborudovanie'],
        'name' => $row['name'],
        'parent_id' => $row['parent_id']
    ];
}

function buildEquipmentTree($equipmentList, $id_role, $parentId = null) {
    $login = $_COOKIE['login'];
    $html = '';
    $filteredEquipment = array_filter($equipmentList, function($equipment) use ($parentId) {
        return $equipment['parent_id'] == $parentId;
    });
    if (count($filteredEquipment) > 0) {
        $html .= '<ul class="submenu" style="display: none;">'; // Скрываем подменю по умолчанию
        foreach ($filteredEquipment as $equipment) {
            $html .= '<li>';
            if($login == "test_account"){
                if($equipment["id_type_oborudovanie"] == 21)
                    $html .= '<a href="index.php?oborud=' . $equipment["id_type_oborudovanie"] . '">' . $equipment["name"] . '</a>';
            }else {
                // Проверяем, является ли элемент "Лабораторно-диагностические системы" по id
                if ($equipment["id_type_oborudovanie"] == 29) {
                    // Заменяем span на a с классом menu-item
                    $html .= '<a href="#" class="menu-item" onclick="toggleSubmenu(event); return false;">' . $equipment["name"] . '</a>';
                } else if ($equipment["id_type_oborudovanie"] == 19) {
                    // Заменяем span на a с классом menu-item
                    $html .= '<a href="#" class="menu-item" onclick="toggleSubmenu(event); return false;">' . $equipment["name"] . '</a>';
                } else {
                    // Для всех остальных элементов добавляем обработчик
                    if ($id_role == 4)
                        $html .= '<a href="index.php?oborud=' . $equipment["id_type_oborudovanie"] . '">' . $equipment["name"] . '</a>';
                    else {
                        $html .= '<a href="#" onclick="checkHash(' . $equipment["id_type_oborudovanie"] . ', event)">' . $equipment["name"] . '</a>';
                    }
                }
            }

            // Рекурсивный вызов для дочерних элементов
            $html .= buildEquipmentTree($equipmentList, $id_role, $equipment['id_type_oborudovanie']);
            $html .= '</li>';
        }
        $html .= '</ul>';
    }
    return $html;
}
?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<aside class="left-sidebar" style="background-color: aliceblue; z-index: 999">
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="index.php" class="text-nowrap logo-img">
                <span style="font-size: 24px; color: black; vertical-align: sub; margin-left: 10px; margin-right: 10px; font-weight: 700">РНПЦ МТ</span>
                <img width="45px" src="app/assets/images/logo-rnpcmt.png" width="180" alt=""/>
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <div id="jquery-accordion-menu" class="jquery-accordion-menu white">
            <ul id="demo-list">
                <li class="active"><a href="index.php?main"><i class="fa fa-home"></i>Главная</a></li>
                <?php
                if (isset($id_role)) {
                    if ($id_role == 1) {
                        echo "<li><a href='index.php?podusers'><i class='fa fa-user'></i>Мои пользователи</a></li>";
                    }
                }
                ?>
                <li id="menu_oborud"><a href="#"><i class="fa fa-suitcase"></i>Оборудование</a>
                    <ul class="submenu">
                        <li id="menu_ustanovl"><a href="index.php?oborud" onclick="showTooltip(event)">Установленное</a>
                            <?php echo buildEquipmentTree($equipmentTypes, $id_role); ?>
                        </li>
                        <li><a href="index.php?oborud_unspecified">Неустановленное</a></li>
                    </ul>
                </li>
                <li>
                    <a href="index.php?zapchasti">
                        <i class="fa fa-wrench"></i> Запчасти
                    </a>
                </li>
                <li><a href="#"><i class="fa fa-file-image-o"></i>Отчеты </a>
                    <ul class="submenu">
                        <li><a href="index.php?report1">Отчет о простаивающем<br>оборудовании</a></li>
                        <li><a href="index.php?reportNewAddedOb">Отчет о добавленном<br>оборудовании</a></li>
                        <li><a href="index.php?reportStatisticObor">Статистика оборудования</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-question"></i> Помощь
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
    </div>
</aside>

<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "500",
        "hideDuration": "1000",
        "timeOut": "6000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    function checkHash(id_type, event) {
        event.preventDefault(); // Предотвращаем перезагрузку страницы
        selectedEquipmentType = id_type;
        $.ajax({
            url: "app/ajax/getOblsByTypeAdmin.php",
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
    }

    function showTooltip(event) {
        toastr.info('При повторном нажатии на пункт "Установленные", фильтрация по видам оборудования учитываться не будет');
    }

    function toggleSubmenu(event) {
        event.preventDefault(); // Предотвращаем переход по ссылке
        const target = event.currentTarget; // Получаем элемент, на который кликнули
        const submenu = target.querySelector('.submenu'); // Ищем подменю внутри элемента

        if (submenu) {
            // Переключаем видимость подменю
            if (submenu.style.display === 'none' || submenu.style.display === '') {
                submenu.style.display = 'block'; // Открываем подменю
            } else {
                submenu.style.display = 'none'; // Закрываем подменю
            }
        }
    }
</script>