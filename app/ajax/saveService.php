<?php
include "../../connection/connection.php";
if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
}

$serviceName = $_POST['name'];

$query = "INSERT INTO servicemans (name) VALUES ('$serviceName')";
$result = $connectionDB->executeQuery($query);
echo "Запись добавлена.";
?>



