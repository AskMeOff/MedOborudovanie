
<?php

$equipmentTypes = [];
$oblastNames = [];
$sqlTypes = "SELECT DISTINCT name FROM type_oborudovanie";
$resultTypes = $connectionDB->executeQuery($sqlTypes);
while ($row = mysqli_fetch_assoc($resultTypes)) {
    $equipmentTypes[] = $row['name'];
}
$sqlOblast = "SELECT DISTINCT o.name FROM oblast o";
$resultOblast = $connectionDB->executeQuery($sqlOblast);
while ($row = mysqli_fetch_assoc($resultOblast)) {
    $oblastNames[] = $row['name'];
}
echo '
<link rel="stylesheet" href="css/minsk.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<section class="content" style="margin-top: 100px;">
    <div class="container-fluid" id="container_fluid" style="overflow: auto; height: 85vh;">
        <div class="row" id="main_row">
            <h1 class="ms-3">Статистика по видам оборудования по областям</h1>

            <section class="col-lg-11 connectedSortable ui-sortable" style="display: block;">
                <div class="row">              

               </div>
           <!--    <button class="btn btn-info m-3" onclick="getReportStatisticObor()">Построить отчет</button> -->
                <div> <button class="btn btn-info" onclick="startFilterReport()" style=" margin-left: 15px;">Фильтры</button>
                <a class="nav-link sidebartoggler nav-icon-hover" id="arrow-left" onclick="toggleRightSection()" style="
           position: absolute;
    right: 50px;
    cursor: pointer;
    top: 12%;
    color: rgb(152, 212, 212);
    display: none; z-index: 9999;" >
                    <i class="ti ti-arrow-left" style="font-size: 30px; "></i>
                </a>
           </div> 
            <div id="filterContainer" style="display: none;">
            <div class = "filtCol row" style="padding-left: 12px">
                        <div class="col-lg-4" >

                 <label for="filterEquipment">Вид оборудования:</label>
                 <select id="filterEquipment" onchange="filterTableReport()">
                 <option value="">Все</option>';
foreach ($equipmentTypes as $type) {
    echo '<option value="' . $type . '">' . $type . '</option>';
}

echo '  
            </select>
             </div>
            <div class="col-lg-4">

            <label for="filterOblast">Область:</label>
            <select id="filterOblast" onchange="filterTableReport()">
            <option value="">Все</option>           
            
            
            ';
foreach ($oblastNames as $oblast) {
    echo '<option value="' . $oblast . '">' . $oblast . '</option>';
}
        echo ' </select></div>
  <label for="filterStat">Статус:</label>
   <div class="col-lg-4">
            <select id="filterStat" onchange="filterTableReport()">
            <option value="0,1,2,3">Все</option>  
            <option value="0,1,3">Установленное</option>
            <option value="2">Неустановленное</option> 
            </select></div>   
             </div>
        </div>
        <div class="row hidden" id="table_row">
            <section class="col-lg-11 connectedSortable ui-sortable" style="display: block;">
                <div class="table-responsive">
                    <table class="table table-striped table-responsive-sm dataTable no-footer" id="table_report1"
                           style="display: block">
                        <thead>
                        <tr>
                            <th>Вид оборудования</th>
                            <th>Область</th>
                            <th>Кол-во(шт.)</th>

                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>         


            </section>

        </div>
    </div>
</section>

<script>

    $(document).ready(function () {
        $("#table_report1").DataTable();

    });


    function getReportStatisticObor() {
        var startYear = $("#start_year").val();
        var endYear = $("#end_year").val();
        $.ajax({
            url: "app/ajax/getReportStatisticObor.php",
            type: "POST",
            data: {

            },
            success: function (response) {
                $("#table_row").removeClass("hidden");
                var table = $(".table-responsive table").DataTable();
                table.clear().destroy();
                $(".table-responsive").html(response);
                if ($(".table-responsive table tbody tr").length > 0) {
                    
                    $(".table-responsive table").DataTable();
                } else {
                   
                   $(".table-responsive").html("<p style=\"text-align:center;\">Нет данных для отображения.</p>");
                }
            }
        })
    }
    
    
 function printTable() {
        var table = document.getElementById("table_report1").outerHTML;
        var newWindow = window.open("", "", "height=500,width=800");
        newWindow.document.write("<html><head><title>Печать таблицы</title>");
        newWindow.document.write("<link rel=\"stylesheet\" type=\"text/css\" href=\"bootstrap/assets/css/jquery.dataTables.min.css\">");
        newWindow.document.write("</head><body>");
        newWindow.document.write(table);
        newWindow.document.write("</body></html>");
        newWindow.document.close();
        newWindow.print();
    }
    
    
     function printTable1() {
        var table = document.getElementById("table_total").outerHTML;
        var newWindow = window.open("", "", "height=500,width=800");
        newWindow.document.write("<html><head><title>Печать таблицы</title>");
        newWindow.document.write("<link rel=\"stylesheet\" type=\"text/css\" href=\"bootstrap/assets/css/jquery.dataTables.min.css\">");
        newWindow.document.write("</head><body>");
        newWindow.document.write(table);
        newWindow.document.write("</body></html>");
        newWindow.document.close();
        newWindow.print();
    } 
document.addEventListener("DOMContentLoaded", function() {
    // Здесь вызов вашей функции
   getReportStatisticObor();
});    
    

</script>';

echo'
<script>
function startFilterReport() {
    let filterContainer = document.getElementById("filterContainer");
    filterContainer.style.display = filterContainer.style.display === "none" ? "block" : "none";
}


function filterTableReport() {
    let equipmentFilter = $("#filterEquipment").val();
    let oblastFilter = $("#filterOblast").val();
    let statFilter = $("#filterStat").val();
//    var startYear = $("#start_year").val();
//    var endYear = $("#end_year").val();
        $.ajax({
            type: "POST",
            url: "/app/ajax/filterGetDataStats.php",
            data: {
                equipment: equipmentFilter,
                oblast: oblastFilter,
                stat: statFilter
            },
            success: function (response) {

        $("#table_report1").DataTable().destroy();
    
               $("#table_report1").html(response);
//               console.log(response);   
               $("#table_report1").DataTable();
    
            },
            error: function (xhr, status, error) {
                console.error("Ошибка при выполнении запроса: " + error);
            }
        });
    
}
</script>


';
echo '
<script>
function exportTableToExcelStatObl(tableID, filename = \'\') {
    // Получаем таблицу
    var table = document.getElementById(tableID);
    var workbook = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
    
    // Устанавливаем имя файла
    filename = filename ? filename + \'.xlsx\' : \'table_export.xlsx\';
        
    const worksheet = workbook.Sheets[\'Sheet1\'];
    const range = XLSX.utils.decode_range(worksheet[\'!ref\']); // Получаем диапазон ячеек

    // Устанавливаем ширину для каждой колонки
    worksheet[\'!cols\'] = [];
    for (let col = range.s.c; col <= range.e.c; col++) {
        const maxWidth = Array.from({ length: range.e.r + 1 }, (_, row) => {
            const cell = worksheet[XLSX.utils.encode_cell({ c: col, r: row })];
            return cell ? cell.v.toString().length : 0; // Получаем длину значения ячейки
        }).reduce((max, width) => Math.max(max, width), 0); // Находим максимальную ширину

        worksheet[\'!cols\'].push({ wch: maxWidth + 2 }); // Добавляем 2 для небольшого отступа
    }
    // Генерируем Excel-файл и сохраняем его
    XLSX.writeFile(workbook, filename);

}

function exportTableToExcelStatRepublic(tableID, filename = \'\') {
    // Получаем таблицу
    var table = document.getElementById(tableID);
    var workbook = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
    
    // Устанавливаем имя файла
    filename = filename ? filename + \'.xlsx\' : \'table_export.xlsx\';
        
    const worksheet = workbook.Sheets[\'Sheet1\'];
    const range = XLSX.utils.decode_range(worksheet[\'!ref\']); // Получаем диапазон ячеек

    // Устанавливаем ширину для каждой колонки
    worksheet[\'!cols\'] = [];
    for (let col = range.s.c; col <= range.e.c; col++) {
        const maxWidth = Array.from({ length: range.e.r + 1 }, (_, row) => {
            const cell = worksheet[XLSX.utils.encode_cell({ c: col, r: row })];
            return cell ? cell.v.toString().length : 0; // Получаем длину значения ячейки
        }).reduce((max, width) => Math.max(max, width), 0); // Находим максимальную ширину

        worksheet[\'!cols\'].push({ wch: maxWidth + 2 }); // Добавляем 2 для небольшого отступа
    }
    // Генерируем Excel-файл и сохраняем его
    XLSX.writeFile(workbook, filename);

}
</script>
';
?>