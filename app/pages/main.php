<?php

$sql = "select obl , total_ispravno, total_neispravno ,  (total_ispravno+total_neispravno) as sumtotal from (SELECT oblast.id_oblast obl,   
       SUM(CASE WHEN status = '1' THEN 1 ELSE 0 END) as total_ispravno,  
       SUM(CASE WHEN status = '0' THEN 1 ELSE 0 END) as total_neispravno
FROM oblast 
LEFT JOIN uz ON oblast.id_oblast = uz.id_oblast 
LEFT JOIN oborudovanie obr ON uz.id_uz = obr.id_uz 
GROUP BY oblast.id_oblast)  as mmm";
$result = $connectionDB->executeQuery($sql);
?>


<!DOCTYPE html>
<html>
<head>
    <style>
        .region {
            width: 300px;
            display: inline-block;
            margin: 10px;
        }
        #mainChart {
            width: 500px;
            margin: 0 auto;
            margin-top: 120px;
        }
        .container {
            text-align: center;
        }
        .total {
            font-size: 18px;
            color: #333;
            font-weight: bold;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<?php


$regions = ["Брестская", "Витебская", "Гомельская", "Гродненская", "Минская", "Могилевская","Минск"];
$equipmentData = array_fill_keys($regions, ['Исправно' => 0, 'Неисправно' => 0]);
$i = 0;
while ($row = $result->fetch_assoc()) {
    if (isset($regions[$i])) {
        $equipmentData[$regions[$i]] = [
            'Исправно' => $row['total_ispravno'],
            'Неисправно' => $row['total_neispravno']
        ];
    }
    $i++;
}
$sumIspravno = 0;
$sumNeispravno = 0;
foreach ($equipmentData as $regionData) {
    $sumIspravno += $regionData['Исправно'];
    $sumNeispravno += $regionData['Неисправно'];
}

echo "<div id='mainChart'><canvas id='chartBelarus'></canvas></div>";
echo "<div style='display:flex;justify-content: center;' class='total'>Всего: " . ($sumIspravno + $sumNeispravno) . "</div>";
echo "<div class='container'>";
foreach ($regions as $region) {
    $total = $equipmentData[$region]['Исправно'] + $equipmentData[$region]['Неисправно'];
    echo "<div class='region'>";
    echo "<h3>$region</h3>";
    echo "<canvas id='chart$region'></canvas>";
    echo "<div class='total'>Всего: $total</div>";
    echo "</div>";
}
echo "</div>";


?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<script>
    let mainChartData = [<?php echo $sumIspravno?>,<?php echo $sumNeispravno?>];

    new Chart('chartBelarus', {
        type: 'pie',
        data: {
            labels: ['Исправно', 'Неисправно'],
            datasets: [{
                backgroundColor: ['green', 'red'],
                data: mainChartData
            }]
        },
        options: {
            title: {
                display: true,
                fontSize: 24,
                text: 'Статистика оборудования: Беларусь'
            }
        }
    });

    <?php foreach ($equipmentData as $regionName => $data): ?>
    new Chart('chart<?= $regionName ?>', {
        type: 'pie',
        data: {
            labels: ['Исправно', 'Неисправно'],
            datasets: [{
                backgroundColor: ['green', 'red'],
                data: [<?= $data['Исправно'] ?>, <?= $data['Неисправно'] ?>]
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Статистика оборудования: <?= $regionName ?>'
            }
        }
    });
    <?php endforeach; ?>
</script>

</body>
</html>
