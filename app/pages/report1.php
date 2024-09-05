<link rel="stylesheet" href="css/minsk.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<section class="content" style="margin-top: 100px; margin-left: 15px">
    <div class="container-fluid" id="container_fluid" style="overflow: auto; height: 85vh;">

        <div class="row" id="main_row">
            <section class="col-lg-11 connectedSortable ui-sortable" style="display: block;">
                <div class="row">
                    <div class="col-3 m-3">
                        <label for="startDate">Начальная дата:</label>
                        <input type="date" id="startDate" >
                    </div>
                    <div class="col-3 m-3">
                        <label for="endDate">Конечная дата:</label>
                        <input type="date" id="endDate">
                    </div>
                </div>
                <button class="btn btn-primary m-3" onclick="getReport()">Построить отчет</button>
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
                            <th>Сервисная организация</th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr>

                        </tr>
                        </tbody>
                    </table>
                </div>
                <button class="btn btn-primary m-3" onclick="printTable()">Печать таблицы</button>

            </section>

        </div>
    </div>
</section>

<script>

    $(document).ready(function () {
        $("#table_report1").DataTable();
    });


    function getReport() {
        if($('#startDate').val() == "" || $('#endDate').val() == "") {
            alert('Заполните поля даты!');
            return;
        }
        $.ajax({
            url: 'app/ajax/getReport1.php',
            type: 'POST',
            data: {
                startDate: $('#startDate').val(),
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