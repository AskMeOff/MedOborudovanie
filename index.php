<?php require_once 'connection/connection.php';

require_once 'app/classes/UsersList.php';
include "app/constants/cookie.php";
include 'app/auth/auth.php';
include 'app/auth/out.php';




if (isset($TOKEN)) {
    if ($usersList->getUser($TOKEN)){
        $login = $usersList->getUser($TOKEN)->getLogin();
        $id_role = $usersList->getUser($TOKEN)->getRole();
        }
    else {
        $login = "";
    }
} else {
    $login = "";
}


?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Админ панель</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <?php include "app/elements/links.php"; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</head>



<body>
<!--  Body Wrapper -->
<?php include "app/elements/header.php"; ?>
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
     data-sidebar-position="fixed" data-header-position="fixed">

    <?php include "app/elements/navmenu.php"; ?>

    <div class="body-wrapper" id="bodywrap">

        <?php
        foreach ($_GET as $key => $value) {
            $value = $key;
            break;
        }
        if (isset($value)) {

            switch ($value) {

                case "oborud":
                    require_once "app/pages/oborudovanie.php";
                    break;

                case "oborud_unspecified":
                    require_once "app/pages/oborudovanie_unspecified.php";
                    break;
                case "effect_oborud":
                    require_once "app/pages/effectOborudovanie.php";
                    break;
                case "main":
                    require_once "app/pages/main.php";
                    break;
                case "servicemans":
                    require_once "app/pages/servicemans.php";
                    break;
                case "report1":
                    require_once "app/pages/report1.php";
                    break;
                case "contacts":
                    require_once "app/pages/contacts.php";
                    break;
                case "guides":
                    require_once "app/pages/guides.php";
                    break;
                case "news":
                    require_once "app/pages/news.php";
                    break;
                case "podusers":
                    require_once "app/pages/podusers.php";
                    break;
                case "reportNewAddedOb":
                    require_once "app/pages/reportNewAddedOb.php";
                    break;
                case "reportStatisticObor":
                    require_once "app/pages/reportStatisticObor.php";
                    break;

                case "zapchasti":
                    require_once "app/pages/zapchasti.php";
                    break;

                default:
                    require_once "app/pages/main.php";
            }
        }else{

            require_once "app/pages/main.php";
        }
        ?>
        <footer class="main-footer">
            <strong> © 2024 <a href="https://rnpcmt.by/">РНПЦ МТ</a></strong>

            <div class="float-right d-none d-sm-inline-block" style="right: 10px; position:absolute;">
                <b >Версия</b> 1.2.1
            </div>
        </footer>
    </div>
    <div id="preloader" style="display: none;">
        <div class="loader"></div>
    </div>
    <?php include "app/elements/scripts.php"; ?>

</body>

<script>
    // $('.sidebar-link').on('click', function (e) {
    //     e.preventDefault();
    //     let url;
    //     var page = $(this).attr('data-page');
    //     switch (page) {
    //         case 'main':
    //             url = "app/pages/main.php";
    //             break;
    //         case 'oborud':
    //             url = "app/pages/oborudovanie.php";
    //             break;
    //         default:
    //             url = "app/pages/main.php";
    //             break;
    //     }
    //     $.ajax({
    //         url: url,
    //     }).done(response => {
    //         $('.app-header').nextAll().remove().end().after(response);
    //     });
    // });


</script>



<script src="js/minsk.js"></script>
<script src="js/serviceman.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
</html>