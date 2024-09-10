<?php
require_once 'connection/connection.php';
$equipmentTypes = [];
$sqlTypes = "SELECT DISTINCT name FROM type_oborudovanie";
$resultTypes = $connectionDB->executeQuery($sqlTypes);
while ($row = mysqli_fetch_assoc($resultTypes)) {
    $equipmentTypes[] = $row['name'];
}
?>

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

                    <li><a href="#"><i class="fa fa-suitcase"></i>Оборудование</a>
                        <ul class="submenu">
                            <li><a href="index.php?oborud">Установленное</a>
                                <ul class="submenu1">
                                    <?php
                                    foreach ($equipmentTypes as $type) {
                                    echo '<li><a href="">'.$type.'</a></li>';
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
                    <li><a href="index.php?servicemans"><i class="fa fa-cog"></i>Сервисанты </a></li>
                    <li><a href="#"><i class="fa fa-file-image-o"></i>Отчеты </a>
                        <ul class="submenu">
                            <li><a href="index.php?report1">Отчет 1</a></li>
                            <li><a href="#">Отчет 2 </a></li>
                        </ul>
                    </li>
                </ul>

            </div>
        <!-- End Sidebar navigation -->
    <!-- End Sidebar scroll-->
</aside>

