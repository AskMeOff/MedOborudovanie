<?php
include "../../connection/connection.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT title, content FROM news WHERE id_news = $id";
    $result = $connectionDB->executeQuery($query);

    if ($connectionDB->getNumRows($result) > 0) {
        $row = $connectionDB->getRowResult($result);
        echo json_encode($row);
    } else {
        echo json_encode(['title' => 'Ошибка', 'content' => 'Новость не найдена.']);
    }
}

$connectionDB->con->close();
?>