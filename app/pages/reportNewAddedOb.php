
<?php

echo '
<link rel="stylesheet" href="css/minsk.css">
<section class="content" style="margin-top: 100px; margin-left: 15px">
    <div class="container-fluid" id="container_fluid" style="overflow: auto; height: 85vh;">
        <div class="row" id="main_row">
            <h1 class="ms-3">Выберите период для отображения добавленного оборудования за период времени</h1>

            <section class="col-lg-11 connectedSortable ui-sortable" style="display: block;">
                <div class="row">
                    <div class="col-2 m-3">
                        <label for="startDate">Начальная дата:</label>
                        <input type="date" id="startDate" >
                    </div>
                    <div class="col-2 m-3">
                        <label for="endDate">Конечная дата:</label>
                        <input type="date" id="endDate">
                    </div>
                    <div class="col-3 m-3">
                    <label for="organization">Организация:</label>
                        <select class="form-select" id="select_organization">
                            <option value="0">-- Ничего не выбрано --</option>
                    ';


                    $query = "select * from uz";
                    $result = $connectionDB->executeQuery($query);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id_uz'] . "'>" . $row['name'] . "</option>";
                    }

echo ' </select></div>
 ``                 <div class="col-3 m-3">
                    <label>Область:</label>
                    <select class="form-select" id="select_oblast">
                     <option value="0">-- Ничего не выбрано --</option>
                    ';


$query = "select * from oblast";
$result = $connectionDB->executeQuery($query);
while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row['id_oblast'] . "'>" . $row['name'] . "</option>";
}

echo ' </select></div>
                    
                    <div class="col-3 m-3">
                    <label>Вид оборудования:</label>
                    <select class="form-select" id="select_type_oborudovanie">
                    <option value="0">-- Ничего не выбрано --</option>
                    ';

                    $query = "select * from type_oborudovanie";
                    $result = $connectionDB->executeQuery($query);
                    while ($row = $result->fetch_assoc()) {
                     echo "<option value='" . $row['id_type_oborudovanie'] . "'>" . $row['name'] . "</option>";
                    }

echo ' </select>
                    </div>
                </div>
                <button class="btn btn-info m-3" onclick="getReportNewAddedOb()">Построить отчет</button>
            </section>
        </div>
        <div class="row hidden" id="table_row">
            <section class="col-lg-11 connectedSortable ui-sortable" style="display: block;">
                <div class="table-responsive">
                    <table class="table table-striped table-responsive-sm dataTable no-footer" id="table_report1"
                           style="display: block">
                        <thead>
                        <tr>
                            <th>Организация</th>
                            <th>Вид оборудования</th>
                            <th>Год производства</th>
                            <th>Дата создания записи</th>

                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <button class="btn btn-info m-3" onclick="printTable()">Печать таблицы</button>
                
                <button class="btn btn-success m-3" onclick="exportTableToExcelAddedOb(\'table_report1\', \'Таблица_отчета\')">Экспорт в Excel</button>




            </section>

        </div>
    </div>
</section>

<script>

    $(document).ready(function () {
        $("#table_report1").DataTable();

    });


    function getReportNewAddedOb() {

        $.ajax({
            url: "app/ajax/getReportNewAddedOb.php",
            type: "POST",
            data: {
             startDate: $("#startDate").val(),
            endDate: $("#endDate").val(),
            id_oblast: $("#select_oblast").val(), 
            id_uz: $("#select_organization").val(),
            id_type_oborudovanie: $("#select_type_oborudovanie").val() 
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
function exportTableToExcelAddedOb(tableID, filename = \'\') {
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

//    // Генерируем Excel-файл
//    const wbout = XLSX.write(workbook, { bookType: \'xlsx\', type: \'binary\' });   
//    
//    function s2ab(s) {
//        var buf = new ArrayBuffer(s.length);
//        var view = new Uint8Array(buf);
//        for (var i = 0; i < s.length; i++) {
//            view[i] = s.charCodeAt(i) & 0xFF;
//        }
//        return buf;
//    }
//    
//    // Создаем Blob
//    var blob = new Blob([s2ab(wbout)], { type: "application/octet-stream" });
//        
//        // Создаем ссылку для скачивания
//    var link = document.createElement(\'a\');
//    link.href = URL.createObjectURL(blob);
//    link.download = filename;
//
//    // Добавляем ссылку в документ и кликаем по ней
//    document.body.appendChild(link);
//    link.click();
//
//    // Удаляем ссылку
//    document.body.removeChild(link);

}
  
</script>';
?>