let editedOborudovanieService;
let selectedServiceman;
function searchServiceman(input) {
    let filter, cards, card, i, txtValue;
    filter = input.value.toUpperCase();
    cards = document.getElementsByClassName("card0");

    for (i = 0; i < cards.length; i++) {
        card = cards[i];
        txtValue = card.textContent || card.innerText;

        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            card.style.display = "";
        } else {
            card.style.display = "none";
        }
    }
}

function showTable(idTable) {
    let tables = document.getElementsByTagName('table');
    [...tables].forEach(item => {
        item.style.display = 'none';
    })
    let table = document.getElementById(idTable);
    table.style.display = "block";
    $('table').DataTable().destroy();
    $('#' + idTable).DataTable();
    $('th').css('width', '20%');
}

function showServiceman(idServiceman, element) {
    selectedServiceman = idServiceman;
    let oldActive = document.getElementsByClassName("activecard1")[0];
    if(oldActive)
        oldActive.classList.remove("activecard1");
    element.classList.add('activecard1');
    let sections = document.getElementsByClassName('connectedSortable');
    [...sections].forEach(item => {
        item.style.display = 'none';
    })
    let section = document.getElementById("service" + idServiceman);
    section.style.display = "block";
    showTable('infoService' + idServiceman);



}
function editService(idOborudovanie) {
    editedOborudovanieService = idOborudovanie;
    $.ajax({
        url: '/app/ajax/getSingleOborudovanieService.php',
        type: 'GET',
        data: {id_oborudovanie: idOborudovanie},
        dataType: 'json',
        success: function (data) {
            $('#editBtnOb').show();
            $('#editServiceModal').modal('show');
            $('#editServiceModal .modal-title').text("Изменение записи");
            // document.getElementById('edit_cost').value = data.cost;
            document.getElementById('edit_name_org').value =data.uz;
            document.getElementById('edit_type_obor').value = data.typename;
            document.getElementById('edit_date_dogovor_service').value = data.date_dogovor_service;
            document.getElementById('edit_srok_dogovor_service').value = data.srok_dogovor_service;
            document.getElementById('edit_summa_dogovor_service').value = data.summa_dogovor_service;
            document.getElementById('edit_type_work_dogovor_service').value = data.type_work_dogovor_service;

        }
    });
}
function confirmDeleteService(id_fault) {
    if (confirm('Вы точно хотите удалить эту запись?')) {
        $.ajax({
            url: '/app/ajax/deleteFault.php',
            type: 'POST',
            data: {id_fault: id_fault},
            success: function (response) {
                if (response === "Запись успешно удалена.") {
                    $('#deleteModal').modal('show');
                    $('#deleteModal').on('hidden.bs.modal', function (e) {
                        $('#deleteModal').modal('hide');
                        getFaultsTable(selectedEquipmentId);
                    });
                } else {
                    getFaultsTable(selectedEquipmentId);
                }
            }
        });
    }
}

function saveEditedService() {
    let edit_date_dogovor_service = document.getElementById("edit_date_dogovor_service");
    let edit_srok_dogovor_service = document.getElementById("edit_srok_dogovor_service");
    let edit_summa_dogovor_service = document.getElementById("edit_summa_dogovor_service");
    let edit_type_work_dogovor_service = document.getElementById("edit_type_work_dogovor_service");

    $.ajax({
        url: '/app/ajax/updateOborudovanieService.php',
        type: 'POST',
        data: {
            id_oborudovanie: editedOborudovanieService,

            date_dogovor_service: edit_date_dogovor_service.value,
            srok_dogovor_service: edit_srok_dogovor_service.value,
            summa_dogovor_service: edit_summa_dogovor_service.value,
            type_work_dogovor_service: edit_type_work_dogovor_service.value
        },
        success: function (data) {
            if (data == "1") {

                refreshTableOborudovanieService();
                alert("Запись изменена");
            } else {
                alert("Ошибка в заполнении");
            }

        }
    });
}
function refreshTableOborudovanieService() {
    $.ajax({
        url: '/app/ajax/refreshTableOborudovanieService.php',
        method: 'GET',
        data: {id_serviceman: selectedServiceman},
        dataType: 'json',
        success: function (response) {
            let tableContent = '<table class="table" id="infoService' + selectedServiceman + '" style="font-size: 13px;">';
            if (!response.hasOwnProperty('empty')) {
                tableContent += '<thead><tr>';
                let headers = {
                    'name': 'Наименование организации',
                    'typename': 'Вид оборудования',
                    'date_dogovor_service': 'Дата заключения договора',
                    'srok_dogovor_service': 'Срок действия договора',
                    'summa_dogovor_service': 'Общая сумма по договору',
                    'type_work_dogovor_service': 'Вид выполняемых работ по договору',
                    'id_oborudovanie': 'Действие'
                };
                Object.keys(headers).forEach(function (key) {
                    tableContent += '<th>' + headers[key] + '</th>';
                });
                tableContent += '</tr></thead><tbody>';
                response.forEach(function (row) {
                    let today = new Date();
                    tableContent += '<tr>';
                    tableContent += '<td>' + row.name + '</td>';
                    tableContent += '<td style="text-align: justify;">' + row.typename + '</td>';
                    tableContent += '<td style="text-align: justify;">' + row.date_dogovor_service + '</td>';
                    tableContent += '<td>' + row.srok_dogovor_service + '</td>';
                    tableContent += '<td>' + row.summa_dogovor_service + '</td>';
                    tableContent += '<td>' + row.type_work_dogovor_service + '</td>';
                    tableContent += '<td><a href="#" onclick="editService(' + row.id_oborudovanie + ')">✏️</a></td>';
                    tableContent += '</tr>';
                });
            } else {
                tableContent += '<thead><tr>';
                tableContent += '<th></th>';
                tableContent += '</tr></thead><tbody>';
                tableContent += '<tr><td colspan="8" style="text-align:center;">Нет данных</td></tr>';
            }

            tableContent += '</tbody></table>';
            $('#service' + selectedServiceman + ' .table-responsive').html(tableContent);
            $('#editServiceModal').modal('hide');
            $('#infoService' + selectedServiceman).DataTable();
        },
        error: function (xhr, status, error) {
            console.log(error);
        }
    });

}