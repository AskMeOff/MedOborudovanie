<?php require_once 'connection/connection.php';

require_once 'app/classes/UsersList.php';
include "app/constants/cookie.php";
include 'app/auth/auth.php';
include 'app/auth/out.php';


if (isset($TOKEN)) {
    if ($usersList->getUser($TOKEN))
        $login = $usersList->getUser($TOKEN)->getLogin();
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

    <div class="body-wrapper">

        <?php
        foreach ($_GET as $key => $value) {
            $value = $key;
            break;
        }
        if (isset($value)) {

            switch ($value) {
                case "minsk":
                    require_once "app/pages/obls/minsk.php";
                    break;
                case "minskobl":
                    require_once "app/pages/obls/minskobl.php";
                    break;
                case "brestobl":
                    require_once "app/pages/obls/brestobl.php";
                    break;
                case "vitebskobl":
                    require_once "app/pages/obls/vitebskobl.php";
                    break;
                case "gomelobl":
                    require_once "app/pages/obls/gomelobl.php";
                    break;
                case "grodnoobl":
                    require_once "app/pages/obls/grodnoobl.php";
                    break;
                case "mogilevobl":
                    require_once "app/pages/obls/mogilevobl.php";
                    break;
                case "minsk-efficiency":
                    require_once "app/pages/oblsEfficiency/minsk.php";
                    break;
                case "minskobl-efficiency":
                    require_once "app/pages/oblsEfficiency/minskobl.php";
                    break;
                case "brestobl-efficiency":
                    require_once "app/pages/oblsEfficiency/brestobl.php";
                    break;
                case "vitebskobl-efficiency":
                    require_once "app/pages/oblsEfficiency/vitebskobl.php";
                    break;
                case "gomelobl-efficiency":
                    require_once "app/pages/oblsEfficiency/gomelobl.php";
                    break;
                case "grodnoobl-efficiency":
                    require_once "app/pages/oblsEfficiency/grodnoobl.php";
                    break;
                case "mogilevobl-efficiency":
                    require_once "app/pages/oblsEfficiency/mogilevobl.php";
                    break;
                case "oborud":
                    require_once "app/pages/oborudovanie.php";
                    break;
                case "effect-oborud":
                    require_once "app/pages/effectOborudovanie.php";
                    break;
                case "main":
                    require_once "app/pages/main.php";
                    break;
                default:
                    require_once "app/pages/main.php";
            }
        }else{
            require_once "app/pages/main.php";
        }
        ?>
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

</html>