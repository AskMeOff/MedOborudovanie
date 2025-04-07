<?php
include "../../connection/connection.php";
if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
}

$id_fault = $_POST['id_fault'];
$documentOrg = null;
$currentDocumentQuery = "SELECT documentOrg FROM faults WHERE id_fault = '$id_fault'";
$currentDocumentResult = mysqli_query($connectionDB->con, $currentDocumentQuery);
$currentDocumentRow = mysqli_fetch_assoc($currentDocumentResult);
$currentDocumentName = $currentDocumentRow['documentOrg'];

if (isset($_FILES['document'])) {
    $file = $_FILES['document'];
    $uploadDir = '../../app/documents/' . $id_fault . '/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }


    function translit($fileName)
    {
        $tr = array(
            "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G",
            "Д"=>"D","Е"=>"E","Ж"=>"J","З"=>"Z","И"=>"I",
            "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
            "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
            "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
            "Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
            "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
            "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
            "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
            "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
            "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
            "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
            "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
            "Ё"=>"E","Є"=>"E","Ї"=>"YI","ё"=>"e","є"=>"e","ї"=>"yi",
            " "=> "_", "/"=> "_"
        );

        $fileName = strtr($fileName, $tr);
        $fileName = preg_replace('/[^A-Za-z0-9_\-.]/', '', $fileName);

        return $fileName;
    }

    $fileName = translit($file['name']);
    $uploadFile = $uploadDir . basename($fileName);


    if ($currentDocumentName) {
        $oldFilePath = $uploadDir . $currentDocumentName;
        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo 'Ошибка загрузки файла: ' . $file['error'];
        exit;
    }


    if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
        $documentOrg = $fileName;
    } else {
        echo 'Ошибка перемещения файла.';
        exit;
    }
}

$date_fault = !empty($_POST['date_fault']) ? "'" . $_POST['date_fault'] . "'" : "NULL";
$date_call_service = !empty($_POST['date_call_service']) ? "'" . $_POST['date_call_service'] . "'" : "NULL";
$reason_fault = isset($_POST['reason_fault']) ? "'" . mysqli_real_escape_string($connectionDB->con, $_POST['reason_fault']) . "'" : "NULL";
$date_procedure_purchase = !empty($_POST['date_procedure_purchase']) ? "'" . $_POST['date_procedure_purchase'] . "'" : "NULL";
$date_dogovora = !empty($_POST['date_dogovora']) ? "'" . $_POST['date_dogovora'] . "'" : "NULL";
$time_repair = !empty($_POST['time_repair']) ? "'" . $_POST['time_repair'] . "'" : "NULL";
$cost_repair = isset($_POST['cost_repair']) ? $_POST['cost_repair'] : "NULL";
$remont = isset($_POST['remont']) ? $_POST['remont'] : "NULL";
$date_remont = !empty($_POST['date_remont']) ? "'" . $_POST['date_remont'] . "'" : "NULL";
$edit_remontOrg = isset($_POST['edit_remontOrg']) ? "'" . mysqli_real_escape_string($connectionDB->con, $_POST['edit_remontOrg']) . "'" : "NULL";

$query = "UPDATE faults
        SET date_fault = $date_fault,
            date_call_service = $date_call_service,
            reason_fault = $reason_fault,
            date_procedure_purchase = $date_procedure_purchase,
            date_dogovora = $date_dogovora,
            cost_repair = $cost_repair,
            time_repair = $time_repair,
            remont = $remont,
            date_remont = $date_remont,
            remontOrg = $edit_remontOrg";

if (!empty($documentOrg)) {
    $query .= ", documentOrg = '$documentOrg'";
}
$query .= " WHERE id_fault = '$id_fault'";

if (mysqli_query($connectionDB->con, $query)) {
    echo "Запись обновлена.";
} else {
    echo "Ошибка обновления записи: " . mysqli_error($connectionDB->con);
}
?>