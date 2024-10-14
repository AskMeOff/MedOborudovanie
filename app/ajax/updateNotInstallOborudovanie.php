<?php
include "../../connection/connection.php";
if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
}

$id_oborudovanie = $_POST['id_oborudovanie'];
$id_type_oborudovanie = $_POST['id_type_oborudovanie'];
$edit_model = isset($_POST['edit_model']) && $_POST['edit_model'] !== "" ? "'" . $connectionDB->escapeString($_POST['edit_model']) . "'" : "NULL";
$edit_cost = isset($_POST['edit_cost']) && $_POST['edit_cost'] !== "" ? "'" . $connectionDB->escapeString($_POST['edit_cost']) . "'" : "NULL";
$edit_contract = isset($_POST['edit_contract']) && $_POST['edit_contract'] !== "" ? "'" . $connectionDB->escapeString($_POST['edit_contract']) . "'" : "NULL";
$service_postavschik = isset($_POST['service_postavschik']) && $_POST['service_postavschik'] !== "" ? "'" . $connectionDB->escapeString($_POST['service_postavschik']) . "'" : "NULL";
$service_organization = isset($_POST['service_organization']) && $_POST['service_organization'] !== "" ? "'" . $connectionDB->escapeString($_POST['service_organization']) . "'" : "NULL";
$edit_date_get_oborud = isset($_POST['edit_date_get_oborud']) && $_POST['edit_date_get_oborud'] !== "" ? "'" . $connectionDB->escapeString($_POST['edit_date_get_oborud']) . "'" : "NULL";
$edit_date_srok_vvoda = isset($_POST['edit_date_srok_vvoda']) && $_POST['edit_date_srok_vvoda'] !== "" ? "'" . $connectionDB->escapeString($_POST['edit_date_srok_vvoda']) . "'" : "NULL";
$edit_reasons = isset($_POST['edit_reasons']) && $_POST['edit_reasons'] !== "" ? "'" . $connectionDB->escapeString($_POST['edit_reasons']) . "'" : "NULL";


$sql = "UPDATE oborudovanie SET 
            id_type_oborudovanie = '$id_type_oborudovanie', 
            model = $edit_model, 
            cost = $edit_cost,
            num_and_date = $edit_contract, 
            id_postavschik = $service_postavschik,
            id_serviceman = $service_organization, 
            date_get_sklad = $edit_date_get_oborud, 
            date_norm_srok_vvoda = $edit_date_srok_vvoda, 
            reasons = $edit_reasons 
        WHERE id_oborudovanie = '$id_oborudovanie'";

try {
    $result = $connectionDB->executeQuery($sql);
    echo "1";
} catch(Exception $e) {
    echo $e->getMessage();
}

