<link rel="stylesheet" href="css/minsk.css">
<section class="content" style="margin-top: 100px; margin-left: 15px">
    <div class="container-fluid" id="container_fluid" style="overflow: auto; height: 85vh;">
        <div class="row" id="main_row">
            <h1 class="ms-3">Простаивающее оборудование</h1>

            <section class="col-lg-11 connectedSortable ui-sortable" style="display: block;">
                <div class="row">
<!--                    <div class="col-3 m-3">-->
<!--                        <label for="startDate">Начальная дата:</label>-->
<!--                        <input type="date" id="startDate" >-->
<!--                    </div>-->
<!--                    <div class="col-3 m-3">-->
<!--                        <label for="endDate">Конечная дата:</label>-->
<!--                        <input type="date" id="endDate">-->
<!--                    </div>-->
                    <div class="col-3 m-3">
                        <label for="organization">Организация:</label>
                        <select class="form-select" id="select_organization">
                            <option value="0">-- Ничего не выбрано --</option>

<?php
                            $query = "select * from uz";
                            $result = $connectionDB->executeQuery($query);
                            while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id_uz'] . "'>" . $row['name'] . "</option>";
                            }
?>
                            </select>
                    </div>
                </div>
                <button class="btn btn-info m-3" onclick="getReport()">Построить отчет</button>
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
                            <th>Наименование оборудования</th>
                            <th>Дата поломки</th>
                            <th>Время простоя</th>
                            <th>Сервисная организация</th>

                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <button class="btn btn-info m-3" onclick="printTable()">Печать таблицы</button>

            </section>

        </div>
    </div>
</section>

<script>

    $(document).ready(function () {
        $("#table_report1").DataTable();

    });


    function getReport() {
        $.ajax({
            url: 'app/ajax/getReport1.php',
            type: 'POST',
            data: {
                startDate: $('#startDate').val(),
                id_uz: $("#select_organization").val(),
                endDate: $('#endDate').val()
            },
            success: function (response) {
                $('#table_row').removeClass('hidden');
                $('.table-responsive table').DataTable().destroy();
                $('.table-responsive').html(response);
                $('.table-responsive table').DataTable();
            }
        })
    }





    function printTable() {
        var table = document.getElementById("table_report1").outerHTML;

        var newWindow = window.open('', '', 'height=500,width=800');

        newWindow.document.write('<html><head><title>Печать таблицы</title>');
        newWindow.document.write('<link rel="stylesheet" type="text/css" href="bootstrap/assets/css/jquery.dataTables.min.css">');
        newWindow.document.write('</head><body>');
        newWindow.document.write(table);
        newWindow.document.write('</body></html>');

        newWindow.document.close();
        newWindow.print();
    }
</script>