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
$counts = [
    'Брестская область' => '',
    'Витебская область' => '',
    'Гомельская область' => '',
    'Гродненская область' => '',
    'Минская область' => '',
    'Могилевская область' => '',
    'Минск' => '',
    'РНПЦ' => ''
];
$countNevernoe = 0;
$sqlobl = 'select id_oblast, name from oblast';
$resultobl = mysqli_query($connectionDB->con, $sqlobl);
$i=0;
while($row = $resultobl->fetch_assoc()){
    $i=0;
    $count_obl = 0;
    $oblast = $row['name'];
    echo '<tr><td style="font-size: 25px; font-weight: 800">'.$row['name'].'</td></tr>';
$id_oblast = $row['id_oblast'];
        $sql_type = 'SELECT o.id_oborudovanie, uz.name as name_uz, t.name as type_name, o.model, ob.name as ob_name
from oborudovanie o
     left join type_oborudovanie1 t on o.id_type_oborudovanie = t.id_type_oborudovanie
    left join uz uz on o.id_uz = uz.id_uz
    left join oblast ob on ob.id_oblast = uz.id_oblast
    where ob.id_oblast = '.$id_oblast.' and o.serial_number is not null and o.status in (0,1,3) order by uz.name asc';
        $resultobl_type = mysqli_query($connectionDB->con, $sql_type);
        while ($row1 = $resultobl_type->fetch_assoc()) {
            $found = false;
            $model = $row1['model'];
            $type_obor = $row1['type_name'];
            if($type_obor !== NULL ) {
                if($type_obor === NULL || $type_obor === '' || $type_obor === 'NULL')
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
                    $countNevernoe++;
                    $count_obl++;
                }


            }else{
                if ($row1['type_name'] === NULL || $row1['type_name'] === '' || $row1['type_name'] === 'NULL')
                    $row1['type_name'] = 'Отсутствует тип';
                echo '<tr><td>' . $row1['name_uz'] . '</td><td>' . $row1['type_name'] . '</td><td>' . $row1['model'] . '</td></tr>';
                $countNevernoe++;
                $count_obl++;
            }
        }

    $sql_type = 'SELECT o.id_oborudovanie, uz.name as name_uz, t.name as type_name, o.model, ob.name as ob_name
from oborudovanie o
     left join type_oborudovanie1 t on o.id_type_oborudovanie = t.id_type_oborudovanie
    left join uz uz on o.id_uz = uz.id_uz
    left join oblast ob on ob.id_oblast = uz.id_oblast
    where ob.id_oblast = '.$id_oblast.' and o.serial_number is null and o.status in (0,1,3) order by uz.name asc';
    $resultobl_type = mysqli_query($connectionDB->con, $sql_type);

    while ($row1 = $resultobl_type->fetch_assoc()) {
        if($row1['type_name'] === NULL || $row1['type_name'] === '' || $row1['type_name'] === 'NULL')
            $row1['type_name'] = 'Отсутствует тип';
        echo '<tr><td>' . $row1['name_uz'] . '</td><td>' . $row1['type_name'] . '</td><td>' . $row1['model'] . '</td></tr>';
        $countNevernoe++;
        $count_obl++;
    }
    $counts[$oblast] = $count_obl;
    echo '<tr><td>'.$count_obl.'</td></tr>';
    $i++;
}



echo '</tbody>
</table>';

echo $countNevernoe;

echo '<table border="1" cellpadding="10" cellspacing="0">';
echo '<tr><th>Область</th><th>Значение</th></tr>';

foreach ($counts as $region => $value) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($region) . '</td>';
    echo '<td>' . htmlspecialchars($value) . '</td>';
    echo '</tr>';
}

echo '</table>';


$sql_type = '
    SELECT count(*) as all_count, ob.name 
    FROM oborudovanie o 
    inner JOIN uz u ON u.id_uz = o.id_uz
    inner JOIN oblast ob ON ob.id_oblast = u.id_oblast
    where o.status in (0,1,3)
    GROUP BY ob.name 
';
$resultobl_type = mysqli_query($connectionDB->con, $sql_type);
$data = [];
$total_my_value = 0;
$total_all_count = 0;

if ($resultobl_type && mysqli_num_rows($resultobl_type) > 0) {
    while ($row = mysqli_fetch_assoc($resultobl_type)) {
        $regionName = $row['name'];
        $allCount = (int)$row['all_count'];

        // Получаем значение из $counts, если оно есть
        $myValue = isset($counts[$regionName]) ? (int)$counts[$regionName] : 0;

        // Считаем процент
        $percent = ($allCount > 0) ? round(($myValue / $allCount) * 100, 2) : 0;

        // Накапливаем суммы для итоговой строки
        $total_my_value += $myValue;
        $total_all_count += $allCount;

        // Сохраняем данные для вывода
        $data[] = [
            'region' => $regionName,
            'my_value' => $myValue,
            'all_count' => $allCount,
            'percent' => $percent
        ];
    }
}

// Вычисляем общий процент (если всего записей больше 0)
$general_percent = ($total_all_count > 0)
    ? round(($total_my_value / $total_all_count) * 100, 2)
    : 0;

// Теперь выводим таблицу
echo '<table border="1" cellpadding="10" cellspacing="0">';
echo '<tr><th>Область</th><th>Количество записей</th><th>Значение</th><th>Процент (%)</th></tr>';

if (!empty($data)) {
    foreach ($data as $item) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($item['region']) . '</td>';
        echo '<td>' . htmlspecialchars($item['all_count']) . '</td>';
        echo '<td>' . htmlspecialchars($item['my_value']) . '</td>';
        echo '<td>' . htmlspecialchars($item['percent']) . '</td>';
        echo '</tr>';
    }

    // Итоговая строка
    echo '<tr style="font-weight:bold; background-color:#f2f2f2;">';
    echo '<td>Всего</td>';
    echo '<td>' . number_format($total_all_count, 0, '', ' ') . '</td>';
    echo '<td>' . number_format($total_my_value, 0, '', ' ') . '</td>';
    echo '<td>' . htmlspecialchars($general_percent) . '%</td>';
    echo '</tr>';

} else {
    echo '<tr><td colspan="4">Нет данных для отображения.</td></tr>';
}

echo '</table>';

?>