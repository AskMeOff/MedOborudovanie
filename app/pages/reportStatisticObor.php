
<?php

echo '
<link rel="stylesheet" href="css/minsk.css">
<section class="content" style="margin-top: 100px; margin-left: 15px">
    <div class="container-fluid" id="container_fluid" style="overflow: auto; height: 85vh;">
        <div class="row" id="main_row">
            <h1 class="ms-3">Статистика по видам оборудования по областям</h1>

            <section class="col-lg-11 connectedSortable ui-sortable" style="display: block;">
                <div class="row">              

               </div>
                <button class="btn btn-info m-3" onclick="getReportStatisticObor()">Построить отчет</button>
            </section>
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
                <button class="btn btn-info m-3" onclick="printTable()">Печать статистики по областям</button>
                <button class="btn btn-info m-3" onclick="printTable1()">Печать статистики по Республике Беларусь</button>

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

  
</script>';
?>