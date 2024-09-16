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

    <?php include "app/elements/links.php"; ?>
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
                case "podusers":
                    require_once "app/pages/podusers.php";
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
                <b >Версия</b> 1.1.1
            </div>
        </footer>
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

</html>