<?php
require 'vendor/autoload.php'; // Подключение автозагрузчика Composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Создание объекта класса Spreadsheet
$spreadsheet = new Spreadsheet();
// Указание на активный лист
$sheet = $spreadsheet->getActiveSheet();
// Указание названия листа книги
$sheet->setTitle("Новый лист");
// Указываем значения для отдельных ячеек
$sheet->setCellValue("D1", "1-я строка");
$sheet->setCellValue("A2", "2-я строка");
$sheet->setCellValue("A3", "3-я строка");
$sheet->setCellValue("B1", "2-й столбец");

// HTTP-заголовки
header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
header("Last-Modified: " . gmdate("D,d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=myFile.xlsx");

// Вывод файла
$writer = new Xlsx($spreadsheet);
$writer->save("php://output");