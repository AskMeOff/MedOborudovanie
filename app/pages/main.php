<?php

$sql = "select obl , total_ispravno, total_neispravno , total_rabota_v_ogranich,  (total_ispravno+total_neispravno+total_rabota_v_ogranich) as sumtotal from (SELECT oblast.id_oblast obl,   
       SUM(CASE WHEN status = '1' THEN 1 ELSE 0 END) as total_ispravno,  
       SUM(CASE WHEN status = '3' THEN 1 ELSE 0 END) as total_rabota_v_ogranich,  
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
        .region1, .region2,.region3,.region4,.region5,.region6,.region7,.region8{
            width: 300px;
            display: inline-block;
            margin: 10px;
            margin-top: 20px;
        }


        #mainChart {
            width: 500px;
            margin: 0 auto;
            margin-left: 35%;
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

        @media (max-width: 1100px) {
            .region1, .region2,.region3,.region4,.region5,.region6,.region7{
                position: static;

            }
            #mainChart {
                margin-left: -9%;
                margin-top: 0%;
            }

        }



        .popup {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 1000;
            animation: fadeIn 0.5s;
        }
        .popup-content {
            background: linear-gradient(135deg, #ffffff, #e0e0e0);
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            width: 500px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.5);
            transform: translateY(-30px);
            animation: slideIn 0.5s forwards;
        }
        .popup-content-serviceman{
            background: linear-gradient(135deg, #ffffff, #e0e0e0);
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            width: 250px; /* уменьшение ширины в 2 раза */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5); /* уменьшение тени */
            position: fixed;
            top: 60%; /* сдвигаем чуть ниже центра */
            left: 50%;
            transform: translate(-50%, -30%);
            animation: slideIn 0.5s forwards;
        }
        .close {
            color: #888;
            float: right;
            font-size: 32px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover,
        .close:focus {
            color: #ff4c4c;
            text-decoration: none;
        }
        h2 {
            font-family: 'Arial', sans-serif;
            color: #333;
            margin-bottom: 15px;
            border-bottom: 2px solid #ff4c4c;
            padding-bottom: 10px;
        }
        p {
            font-family: 'Arial', sans-serif;
            color: #555;
            font-size: 16px;
            line-height: 1.5;
            margin-top: 15px;
        }
        .button {
            background-color: #ff4c4c;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #e63946;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        @keyframes slideIn {
            from {
                transform: translateY(-30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>

<?php


$regions = ["Брестская", "Витебская", "Гомельская", "Гродненская", "Минская", "Могилевская","Минск", "РНПЦ"];
$equipmentData = array_fill_keys($regions, ['Исправно' => 0, 'Неисправно' => 0, 'Работа в ограниченном режиме'=> 0]);
$i = 0;
while ($row = $result->fetch_assoc()) {
    if (isset($regions[$i])) {
        $equipmentData[$regions[$i]] = [
            'Исправно' => $row['total_ispravno'],
            'Работа в ограниченном режиме' => $row['total_rabota_v_ogranich'],
            'Неисправно' => $row['total_neispravno']
        ];
    }
    $i++;
}
$sumIspravno = 0;
$sumNeispravno = 0;
$sumRabotavOgranich = 0;
foreach ($equipmentData as $regionData) {
    $sumIspravno += $regionData['Исправно'];
    $sumNeispravno += $regionData['Неисправно'];
    $sumRabotavOgranich += $regionData['Работа в ограниченном режиме'];
}

echo "<div id='mainChart' ><canvas id='chartBelarus' style='margin-top: 18%;'></canvas><div style='display:flex;justify-content: center;' class='total'>Всего: " . ($sumIspravno + $sumNeispravno + $sumRabotavOgranich) . "</div></div>";

echo "<div class='container'>";
$i=1;
foreach ($regions as $region) {
    $total = $equipmentData[$region]['Исправно'] + $equipmentData[$region]['Неисправно']+ $equipmentData[$region]['Работа в ограниченном режиме'];
    echo "<div class='region region$i' data-region='$i' style='cursor: pointer'>";
    if($i < 7){
        echo "<h3>$region область</h3>";
    }else{
        echo "<h3>$region</h3>";
    }

    echo "<canvas id='chart$region'></canvas>";
    echo "<div class='total'>Всего: $total</div>";
    echo "</div>";
    $i++;
}
echo "</div>
";
echo '<div id="popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <h2>Важная новость!</h2>
        <p>Пожалуйста, убедитесь, что поле "Регистрационный номер оборудования" заполнено. Это поле обязательно для сохранения записи. Напротив незаполненных полей серийного номера стоит знак "!". Проверьте ваши записи!</p>
        <button class="button" onclick="closePopup()">Закрыть</button>
    </div>
</div>';




?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<script>

    function showPopup() {
        document.getElementById("popup").style.display = "flex";
    }

    function closePopup() {
        document.getElementById("popup").style.display = "none";
    }
    window.onload = function() {
        showPopup();
    };


    let mainChartData = [<?php echo $sumIspravno?>,<?php echo $sumNeispravno?>,<?php echo $sumRabotavOgranich?>];

    new Chart('chartBelarus', {
        type: 'doughnut',
        data: {
            labels: ['Исправно', 'Неисправно', 'Работа в ограниченном режиме'],
            datasets: [{
                backgroundColor: ['#10a1007d', '#fb000091', '#ff8c00'],
                data: mainChartData
            }]
        },
        options: {
            title: {
                display: true,
                fontSize: 22,
                text: 'Статистика оборудования: Беларусь'
            }
        }
    });

    <?php foreach ($equipmentData as $regionName => $data): ?>
    new Chart('chart<?= $regionName ?>', {
        type: 'doughnut',
        data: {
            labels: ['Исправно', 'Неисправно', 'Работа в ограниченном режиме'],
            datasets: [{
                backgroundColor: ['#10a1007d', '#fb000091', '#ff8c00'],
                data: [<?= $data['Исправно'] ?>, <?= $data['Неисправно'] ?>, <?= $data['Работа в ограниченном режиме'] ?>]
            }]
        },
        options: {
            onClick: function(evt) {
                var activePoints = this.getElementsAtEventForMode(evt, 'nearest', { intersect: true }, false);
                if (activePoints.length) {
                    var clickedIndex = activePoints[0]._index;
                    var label = activePoints[0]._chart.data.labels[clickedIndex];
                    var value;
                    if (clickedIndex === 0) {
                        value = 1; // Исправно
                    } else if (clickedIndex === 1) {
                        value = 0; // Неисправно
                    } else if (clickedIndex === 2) {
                        value = 3; // Работа в ограниченном режиме
                    }
                    var regionNumber = $(this.canvas.parentNode).data("region");
                    getUzsDiagram(regionNumber, value);
                }
            }

        },
        aspectRatio: 0.5
    });
    <?php endforeach; ?>
</script>

</body>
</html>
