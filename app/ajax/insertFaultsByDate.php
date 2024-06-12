<?php
error_reporting(E_ALL);
ini_set('display_errors','on');
$host='localhost';
$user='formed';
$password='jUnfTyD6D7Jb2akh5';
$database='formed_medOborudovanie';
$con = mysqli_connect($host, $user, $password, $database) or die("Ошибка подключения " . mysqli_error($con));
mysqli_query($con, "SET NAMES 'utf8'");

$query = "INSERT INTO table_faults_by_date (id_oborudovanie, date)
SELECT id_oborudovanie, CURDATE()
FROM oborudovanie
WHERE status = 0;";
$result = mysqli_query($con,$query);