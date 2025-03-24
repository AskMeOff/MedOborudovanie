<?php
include '../../connection/connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nameZakazchik'])) {
        $nameZakazchik = $_POST['nameZakazchik'];
        $dolzhnostIP = isset($_POST['dolzhnostIP']) ? $_POST['dolzhnostIP'] : '';
        $dolzhnostRP = isset($_POST['dolzhnostRP']) ? $_POST['dolzhnostRP'] : '';
        $fioIP = isset($_POST['fioIP']) ? $_POST['fioIP'] : '';
        $fioRP = isset($_POST['fioRP']) ? $_POST['fioRP'] : '';
        $osnovanie = isset($_POST['osnovanie']) ? $_POST['osnovanie'] : '';
        $rekvizit = isset($_POST['rekvizit']) ? $_POST['rekvizit'] : '';
        $contact = isset($_POST['contact']) ? $_POST['contact'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $pochtaIndex = isset($_POST['pochtaIndex']) ? $_POST['pochtaIndex'] : '';
        $primechanie = isset($_POST['primechanie']) ? $_POST['primechanie'] : '';
        $query = "INSERT INTO zakazchik (nameZakazchik, dolzhnostIP, dolzhnostRP, fioIP, fioRP, osnovanie, rekvizit, contact, email, pochtaIndex, primechanie) VALUES ('$nameZakazchik', '$dolzhnostIP', '$dolzhnostRP', '$fioIP', '$fioRP', '$osnovanie', '$rekvizit', '$contact', '$email', '$pochtaIndex', '$primechanie')";
        $result = $connectionDB->executeQuery($query);

        if ($result) {
            echo "success";
        } else {
            echo "error";
        }
    }
}