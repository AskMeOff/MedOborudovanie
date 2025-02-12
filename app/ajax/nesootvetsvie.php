<?php
include "../../connection/connection.php";

function stem($word) {
    // Простейший стеммер, который удаляет некоторые распространенные окончания
    $endings = ['ая', 'яя', 'ий', 'ое', 'ие', 'ов', 'ев', 'ам', 'ом', 'ии', 'их', 'ые', 'ой', 'и', 'а', 'я', 'е', 'у', 'о', 'и', 'й', 'ь', 'ы'];
    foreach ($endings as $ending) {
        if (mb_substr($word, -mb_strlen($ending)) === $ending) {
            return mb_substr($word, 0, -mb_strlen($ending));
        }
    }
    return $word; // Если нет окончаний, возвращаем слово как есть
}
//
//$model = mb_strtolower("Аппараты искусственной вентиляции легких с принадлежностями и расходными материалами: аппарат SynoVent E5Shenzhen Mindray Bio-Medical Electronics Co., Ltd., КИТАЙ");
//$type_obor = "Аппараты ИВЛ";
//$type_obor = mb_strtolower($type_obor);
//
//// Разбиваем строки на слова
//$modelWordsArray = preg_split('/\s+/', $model, -1, PREG_SPLIT_NO_EMPTY);
//$typeWordsArray = preg_split('/\s+/', $type_obor, -1, PREG_SPLIT_NO_EMPTY);
//
//// Флаг для проверки наличия совпадений
//$found = false;
//
//foreach ($typeWordsArray as $typeWord) {
//    $stemmedTypeWord = stem($typeWord); // Получаем корень слова из $type_obor
//    foreach ($modelWordsArray as $modelWord) {
//        $stemmedModelWord = stem($modelWord); // Получаем корень слова из $model
//        // Проверяем, совпадают ли корни
//        if ($stemmedTypeWord === $stemmedModelWord) {
//            $found = true;
//            break 2; // Выходим из обоих циклов
//        }
//    }
//}
//
//if ($found) {
//    echo 'найдено совпадение';
//} else {
//    echo 'не найдено совпадение';
//}


echo '<table border="1">
<thead>
<th>

</th>
</thead>
<tbody>';

$sqlobl = 'select id_oblast, name from oblast';
$resultobl = mysqli_query($connectionDB->con, $sqlobl);
while($row = $resultobl->fetch_assoc()){
    echo '<tr><td style="font-size: 25px; font-weight: 800">'.$row['name'].'</td></tr>';
$id_oblast = $row['id_oblast'];
        $sql_type = 'SELECT o.id_oborudovanie, uz.name as name_uz, t.name as type_name, o.model, ob.name as ob_name
from oborudovanie o
     left join type_oborudovanie t on o.id_type_oborudovanie = t.id_type_oborudovanie
    left join uz uz on o.id_uz = uz.id_uz
    left join oblast ob on ob.id_oblast = uz.id_oblast
    where ob.id_oblast = '.$id_oblast.' and o.serial_number is not null and uz.id_uz = 534';
        $resultobl_type = mysqli_query($connectionDB->con, $sql_type);
        while ($row1 = $resultobl_type->fetch_assoc()) {
            $found = false;
            $model = $row1['model'];
            $type_obor = $row1['type_name'];
            if($type_obor !== NULL ) {
                if($type_obor === NULL || $type_obor === '')
                    $type_obor = 'Отсутствует тип';
                $model = mb_strtolower($model);
                $type_obor = mb_strtolower($type_obor);
                $modelWordsArray = preg_split('/\s+/', $model, -1, PREG_SPLIT_NO_EMPTY);
                $typeWordsArray = preg_split('/\s+/', $type_obor, -1, PREG_SPLIT_NO_EMPTY);

// Флаг для проверки наличия совпадений
                $found = false;

                foreach ($typeWordsArray as $typeWord) {
                    $stemmedTypeWord = stem($typeWord); // Получаем корень слова из $type_obor
                    foreach ($modelWordsArray as $modelWord) {
                        $stemmedModelWord = stem($modelWord); // Получаем корень слова из $model
                        // Проверяем, совпадают ли корни
                        if ($stemmedTypeWord === $stemmedModelWord) {
                            $found = true;
                            break 2; // Выходим из обоих циклов
                        }
                    }
                }
                if ($found) {

                } else {
                    echo '<tr><td>' . $row1['name_uz'] . '</td><td>' . $row1['type_name'] . '</td><td>' . $row1['model'] . '</td></tr>';
                }


            }else{
                echo '<tr><td>' . $row1['name_uz'] . '</td><td>' . $row1['type_name'] . '</td><td>' . $row1['model'] . '</td></tr>';

            }
        }

    $sql_type = 'SELECT o.id_oborudovanie, uz.name as name_uz, t.name as type_name, o.model, ob.name as ob_name
from oborudovanie o
     left join type_oborudovanie t on o.id_type_oborudovanie = t.id_type_oborudovanie
    left join uz uz on o.id_uz = uz.id_uz
    left join oblast ob on ob.id_oblast = uz.id_oblast
    where ob.id_oblast = '.$id_oblast.' and o.serial_number is null and uz.id_uz = 534';
    $resultobl_type = mysqli_query($connectionDB->con, $sql_type);

    while ($row1 = $resultobl_type->fetch_assoc()) {
        if($row1['type_name'] === NULL || $row1['type_name'] === '')
            $row1['type_name'] = 'Отсутствует тип';
        echo '<tr><td>' . $row1['name_uz'] . '</td><td>' . $row1['type_name'] . '</td><td>' . $row1['model'] . '</td></tr>';

    }
}



echo '</tbody>
</table>';
//?>