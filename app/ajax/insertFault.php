<?php
include "../../connection/connection.php";

if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
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

$date_fault = $_POST['date_fault'] ?? null;
$date_call_service = $_POST['date_call_service'] ?? null;
$reason_fault = $_POST['reason_fault'] ?? null;
$date_procedure_purchase = $_POST['date_procedure_purchase'] ?? null;
$cost_repair = $_POST['cost_repair'] ?? null;
$time_repair = $_POST['time_repair'] ?? null;
$add_remontOrg = $_POST['add_remontOrg'] ?? null;
$id_oborudovanie = $_POST['id_oborudovanie'] ?? null;

$cost_repair = !empty($cost_repair) ? "'" . $cost_repair . "'" : 0;
$date_fault = !empty($date_fault) ? "'" . $date_fault . "'" : "NULL";
$date_call_service = !empty($date_call_service) ? "'" . $date_call_service . "'" : "NULL";
$date_procedure_purchase = !empty($date_procedure_purchase) ? "'" . $date_procedure_purchase . "'" : "NULL";
$time_repair = !empty($time_repair) ? "'" . $time_repair . "'" : "NULL";

$documentsDir = '../documents/' . $id_oborudovanie . '/';
if (!file_exists($documentsDir)) {
    mkdir($documentsDir, 0777, true);
}

$file_name = null;
if (isset($_FILES['fileReport']) && $_FILES['fileReport']['error'] === UPLOAD_ERR_OK) {
    $file_name = translit(basename($_FILES['fileReport']['name']));
    $file_tmp = $_FILES['fileReport']['tmp_name'];
    move_uploaded_file($file_tmp, $documentsDir . $file_name);
}

$sql = "INSERT INTO faults (date_fault, date_call_service, reason_fault, date_procedure_purchase, cost_repair, time_repair, remontOrg, id_oborudovanie, documentOrg)
        VALUES ($date_fault, $date_call_service, '$reason_fault', $date_procedure_purchase, $cost_repair, $time_repair, '$add_remontOrg', '$id_oborudovanie', '$file_name')";

$result = $connectionDB->executeQuery($sql);
if ($result) {
    echo "Запись добавлена.";
} else {
    echo "Ошибка: " . mysqli_error($connectionDB);
}

?>