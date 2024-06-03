let selectedOrg;

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
function showSection(idOrg, element) {
    selectedOrg = idOrg;
    let oldActive = document.getElementsByClassName("activecard1")[0];
    if(oldActive)
    oldActive.classList.remove("activecard1");
    element.classList.add('activecard1');
    let sections = document.getElementsByClassName('connectedSortable');
    [...sections].forEach(item => {
        item.style.display = 'none';
    })
    let section = document.getElementById("org" + idOrg);
    section.style.display = "block";
    showTable('infoOb' + idOrg);

    let container_fluid = document.getElementById("container_fluid");
    let btnAddOborudovanie = document.getElementById("btnAddOborudovanie");
    if(btnAddOborudovanie)
        btnAddOborudovanie.remove();
    btnAddOborudovanie = document.createElement("button");
    btnAddOborudovanie.innerHTML = "Добавить оборудование";
    btnAddOborudovanie.id = "btnAddOborudovanie";
    btnAddOborudovanie.className = "btn btn-primary";
    container_fluid.insertAdjacentElement("afterbegin", btnAddOborudovanie);

    btnAddOborudovanie.onclick = () => {
        $('#editBtnOb').hide();
        $('#addBtnOb').show();
        $('#editOborudovanieModal').modal('show');
        $('#editOborudovanieModal .modal-title').text("Добавление оборудования");
        let select_type_oborudovanie = document.getElementById("select_type_oborudovanie");
        select_type_oborudovanie.options[0].selected = true;
        document.getElementById('edit_cost').value = "";
        document.getElementById('edit_date_create').value = "";
        document.getElementById('edit_date_release').value = "";
        document.getElementById('edit_service_organization').value = "";
        document.getElementById('edit_date_last_TO').value = "";


        let select_status = document.getElementById("select_status");
        select_status.options[0].selected = true;

    }

}

function myFunctionOrg(input) {
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

function getFaultsTable(selectedEquipmentId) {
    event.stopPropagation();
    $.ajax({
        url: '/app/ajax/getFaultsTable.php',
        type: 'GET',
        data: { id_oborudovanie: selectedEquipmentId },
        dataType: 'json',
        success: function (data) {
            let tableContent = '<table class="table" style="font-size: 13px;">';
            if (!data.hasOwnProperty('empty')) {
            tableContent += '<thead><tr>';
            let headers = {
                'date_fault': 'Дата поломки',
                'date_call_service': 'Дата вызова сервисантов иных технических специалистов',
                'reason_fault': 'Причина поломки',
                'date_procedure_purchase': 'Дата проведения процедуры закупки на поставку з/ч или услуги по ремонту',
                'cost_repair': 'Стоимость ремонта',
                'time_repair': 'Срок ремонта/поставки запасных частей',
                'downtime': 'Время простоя',
                'id_fault': 'Действия'
            };
            Object.keys(headers).forEach(function(key) {
                tableContent += '<th>' + headers[key] + '</th>';
            });
            tableContent += '</tr></thead><tbody>';
            data.forEach(function(row) {
                tableContent += '<tr>';
                tableContent += '<td>' + row.date_fault + '</td>';
                tableContent += '<td>' + row.date_call_service + '</td>';
                tableContent += '<td>' + row.reason_fault + '</td>';
                tableContent += '<td>' + row.date_procedure_purchase + '</td>';
                tableContent += '<td>' + row.cost_repair + '</td>';
                tableContent += '<td>' + row.time_repair + '</td>';
                tableContent += '<td>' + row.downtime + '</td>';
                tableContent += '<td><a href="#" onclick="confirmDeleteFault(' + row.id_fault + '); return false;">&#10060;</a><a href="#" onclick="editFault(' + row.id_fault + ');">✏️</a></td>';
                tableContent += '</tr>';
            });
            } else {
                tableContent += '<thead><tr>';
                tableContent += '<th></th>';
                tableContent += '</tr></thead><tbody>';
                tableContent += '<tr><td colspan="8" style="text-align:center;">Нет данных</td></tr>';
            }
            tableContent += '</tbody></table>';
            $('#faultsModal .modal-body').html(tableContent);
            $('#faultsModal').modal('show');
        }
    });
}

function getEffectTable(selectedEquipmentId) {
    $.ajax({
        url: '/app/ajax/getEffectTable.php',
        type: 'GET',
        data: { id_oborudovanie: selectedEquipmentId },
        dataType: 'json',
        success: function (data) {
            let tableContent = '<table class="table" style="font-size: 13px;">';
            if (!data.hasOwnProperty('empty')) {
                tableContent += '<thead><tr>';
                let headers = {
                    'count_research': 'Количество проведенных исследований',
                    'count_patient': 'Количество диагностированных пациентов',
                    'id_use_efficiency': 'Действия',

                };
                Object.keys(headers).forEach(function (key) {
                    tableContent += '<th>' + headers[key] + '</th>';
                });
                tableContent += '</tr></thead><tbody>';

                data.forEach(function (row) {
                    tableContent += '<tr>';
                    tableContent += '<td>' + row.count_research + '</td>';
                    tableContent += '<td>' + row.count_patient + '</td>';
                    tableContent += '<td><a href="#" onclick="confirmDeleteEffect(' + row.id_use_efficiency + '); return false;">&#10060;</a><a href="#" onclick="editEffect(' + row.id_use_efficiency + ');">✏️</a></td>';
                    tableContent += '</tr>';
                });
            }
            else {
                    tableContent += '<thead><tr>';
                    tableContent += '<th></th>';
                    tableContent += '</tr></thead><tbody>';
                    tableContent += '<tr><td colspan="8" style="text-align:center;">Нет данных</td></tr>';
                }
            tableContent += '</tbody></table>';
            $('#effectModal .modal-body').html(tableContent);
            $('#effectModal').modal('show');
        }
    });
}



function confirmDeleteFault(id_fault) {
    if (confirm('Вы точно хотите удалить эту запись?')) {
        $.ajax({
            url: '/app/ajax/deleteFault.php',
            type: 'POST',
            data: { id_fault: id_fault },
            success: function(response) {
                if (response === "Запись успешно удалена.") {
                    $('#deleteModal').modal('show');
                    $('#deleteModal').on('hidden.bs.modal', function (e) {
                        $('#deleteModal').modal('hide');
                        getFaultsTable();
                    });
                } else {
                    getFaultsTable();
                }
            }
        });
    }
}


function confirmDeleteEffect(id_use_efficiency) {
    if (confirm('Вы точно хотите удалить эту запись?')) {
        $.ajax({
            url: '/app/ajax/deleteEffect.php',
            type: 'POST',
            data: { id_use_efficiency: id_use_efficiency },
            success: function(response) {
                if (response === "Запись успешно удалена.") {
                    $('#deleteModal').modal('show');
                    $('#deleteModal').on('hidden.bs.modal', function (e) {
                        $('#deleteModal').modal('hide');
                        getEffectTable();
                    });
                } else {
                    getEffectTable();
                }
            }
        });
    }
}

function confirmDeleteOborudovanie(idOborudovanie) {
    if (confirm('Вы точно хотите удалить эту запись?')) {
        $.ajax({
            url: '/app/ajax/deleteOborudovanie.php',
            type: 'POST',
            data: { id_oborudovanie: idOborudovanie },
            success: function(response) {
                if (response === "Запись успешно удалена.") {
                    $('#deleteModal').modal('show');
                    $('#deleteModal').on('hidden.bs.modal', function (e) {
                        $('#deleteModal').modal('hide');
                        location.reload();
                    });
                } else {
                    location.reload();
                }

            }
        });
    }
}



    $('#addFaultForm').on('submit', function(e) {
        e.preventDefault();

        let date_fault = $('#date_fault').val();
        let date_call_service = $('#date_call_service').val();
        let reason_fault = $('#reason_fault').val();
        let date_procedure_purchase = $('#date_procedure_purchase').val();
        let cost_repair = $('#cost_repair').val();
        let time_repair = $('#time_repair').val();
        let downtime = $('#downtime').val();


        let data = {
            date_fault: date_fault,
            date_call_service: date_call_service,
            reason_fault: reason_fault,
            date_procedure_purchase: date_procedure_purchase,
            cost_repair: cost_repair,
            time_repair: time_repair,
            downtime: downtime,
            id_oborudovanie: selectedEquipmentId
        };
        $.ajax({
            url: '/app/ajax/insertFault.php',
            type: 'POST',
            data: data,
            success: function (response) {

                if (response === "Запись добавлена.") {
                    $('#addFaultModal').modal('hide');
                    $('#addModal').modal('show');
                    $('#addModal').on('hidden.bs.modal', function (e) {
                        $('#addModal').modal('hide');
                        getFaultsTable();
                    });
                } else {
                    getFaultsTable();
                }
            }
        });
    });



$('#addEffectForm').on('submit', function(e) {
    e.preventDefault();

    let count_research = $('#count_research').val();
    let count_patient = $('#count_patient').val();
    let data = {
        count_research: count_research,
        count_patient: count_patient,
        id_oborudovanie: selectedEquipmentId
    };
    $.ajax({
        url: '/app/ajax/insertEffect.php',
        type: 'POST',
        data: data,
        success: function (response) {

            if (response === "Запись добавлена.") {
                $('#addEffectModal').modal('hide');
                $('#addModal').modal('show');
                $('#addModal').on('hidden.bs.modal', function (e) {
                    $('#addModal').modal('hide');
                    getEffectTable();
                });
            } else {
                getEffectTable();
            }
        }
    });
});




function editFault(id_fault) {
    $.ajax({
        url: '/app/ajax/getSingleFault.php',
        type: 'GET',
        data: { id_fault: id_fault },
        dataType: 'json',
        success: function (data) {
            $('#editFaultModal').modal('show');
            document.getElementById('edit_date_fault').value = data.date_fault;
            document.getElementById('edit_date_call_service').value = data.date_call_service;
            document.getElementById('edit_reason_fault').value = data.reason_fault;
            document.getElementById('edit_date_procedure_purchase').value = data.date_procedure_purchase;
            document.getElementById('edit_cost_repair').value = data.cost_repair;
            document.getElementById('edit_time_repair').value = data.time_repair;
            document.getElementById('edit_downtime').value = data.downtime;
            document.getElementById('edit_id_fault').value = data.id_fault;

        }
    });
}


function saveFaultData() {

    let dateFault = $('#edit_date_fault').val();
    let dateCallService = $('#edit_date_call_service').val();
    let reasonFault = $('#edit_reason_fault').val();
    let dateProcedurePurchase = $('#edit_date_procedure_purchase').val();
    let costRepair = $('#edit_cost_repair').val();
    let timeRepair = $('#edit_time_repair').val();
    let downtime = $('#edit_downtime').val();
    let idFault = $('#edit_id_fault').val();

    $.ajax({
        url: '/app/ajax/updateFault.php',
        type: 'POST',
        data: {
            id_fault: idFault,
            date_fault: dateFault,
            date_call_service: dateCallService,
            reason_fault: reasonFault,
            date_procedure_purchase: dateProcedurePurchase,
            cost_repair: costRepair,
            time_repair: timeRepair,
            downtime: downtime
        },
        success: function(response) {
            if (response === "Запись обновлена.") {
                $('#editFaultModal').modal('hide');
                $('#saveModal').modal('show');
                $('#saveModal').on('hidden.bs.modal', function (e) {
                    $('#saveModal').modal('hide');
                    getFaultsTable();
                });
            } else {
                getFaultsTable();
            }
        }
});
}

$('#editFaultForm').on('submit', function(event) {
    event.preventDefault();
    saveFaultData();
});




//--------------------------------

function editEffect(id_use_efficiency) {
    $.ajax({
        url: '/app/ajax/getSingleEffect.php',
        type: 'GET',
        data: { id_use_efficiency: id_use_efficiency },
        dataType: 'json',
        success: function (data) {
            $('#editEffectModal').modal('show');
            document.getElementById('edit_count_research').value = data.count_research;
            document.getElementById('edit_count_patient').value = data.count_patient;
            document.getElementById('edit_id_use_efficiency').value = data.id_use_efficiency;
        }
    });
}


function saveEffectData() {

    let countResearch = $('#edit_count_research').val();
    let countPatient = $('#edit_count_patient').val();
    let idUseEfficiency = $('#edit_id_use_efficiency').val();


    $.ajax({
        url: '/app/ajax/updateEffect.php',
        type: 'POST',
        data: {
            idUseEfficiency: idUseEfficiency,
            countPatient: countPatient,
            countResearch: countResearch,
        },
        success: function(response) {
            if (response === "Запись обновлена.") {
                $('#editEffectModal').modal('hide');
                $('#saveModal').modal('show');
                $('#saveModal').on('hidden.bs.modal', function (e) {
                    $('#saveModal').modal('hide');
                    getEffectTable();
                });
            } else {
                getEffectTable();
            }
        }
    });
}

let editedOborudovanie;
function editOborudovanie(idOborudovanie) {
    editedOborudovanie = idOborudovanie;
    $.ajax({
        url: '/app/ajax/getSingleOborudovanie.php',
        type: 'GET',
        data: { id_oborudovanie: idOborudovanie },
        dataType: 'json',
        success: function (data) {
            $('#editBtnOb').show();
            $('#addBtnOb').hide();
            $('#editOborudovanieModal').modal('show');
            $('#editOborudovanieModal .modal-title').text("Изменение оборудования");
            let select_type_oborudovanie = document.getElementById("select_type_oborudovanie");
            select_type_oborudovanie.options.forEach(option => {
                if (option.value === data.id_type_oborudovanie) {
                    option.selected = true;
                }
            });
            document.getElementById('edit_cost').value = data.cost;
            document.getElementById('edit_date_create').value = data.date_create;
            document.getElementById('edit_date_release').value = data.date_release;
            document.getElementById('edit_service_organization').value = data.service_organization;
            document.getElementById('edit_date_last_TO').value = data.date_last_TO;


            let select_status = document.getElementById("select_status");
            select_status.options.forEach(option => {
                if (option.value === data['status']) {
                    option.selected = true;
                }
            });
        }
    });
}

function saveEditedOborudovanie(){
    let select_type_oborudovanie = document.getElementById("select_type_oborudovanie");
    let select_status = document.getElementById("select_status");
    $.ajax({
        url: '/app/ajax/updateOborudovanie.php',
        type: 'POST',
        data: {id_oborudovanie: editedOborudovanie,
            id_type_oborudovanie: select_type_oborudovanie.options[select_type_oborudovanie.selectedIndex].value,
            cost: document.getElementById('edit_cost').value,
            date_create: document.getElementById('edit_date_create').value,
            date_release: document.getElementById('edit_date_release').value,
            service_organization: document.getElementById('edit_service_organization').value,
            date_last_TO: document.getElementById('edit_date_last_TO').value,
            status: select_status.options[select_status.selectedIndex].value
        },
        success: function (data) {
            if(data == "1") {
                alert("Запись изменена");
                location.reload();
            }else{
                alert("Ошибка в заполнении");
            }

        }
    });
}

$('#editFaultForm').on('submit', function(event) {
    event.preventDefault();
    saveFaultData();
});

$('#editEffectForm').on('submit', function(event) {
    event.preventDefault();
    saveEffectData();
});

function saveAddedOborudovanie(){
    let select_type_oborudovanie = document.getElementById("select_type_oborudovanie");
    let select_status = document.getElementById("select_status");
    $.ajax({
        url: '/app/ajax/insertOborudovanie.php',
        type: 'POST',
        data: {
            id_type_oborudovanie: select_type_oborudovanie.options[select_type_oborudovanie.selectedIndex].value,
            cost: document.getElementById('edit_cost').value,
            date_create: document.getElementById('edit_date_create').value,
            date_release: document.getElementById('edit_date_release').value,
            service_organization: document.getElementById('edit_service_organization').value,
            date_last_TO: document.getElementById('edit_date_last_TO').value,
            status: select_status.options[select_status.selectedIndex].value,
            id_org: selectedOrg
        },
        success: function (data) {
            if(data == "1") {
                alert("Запись изменена");
                location.reload();
            }else{
                alert("Ошибка в заполнении");
            }

        }
    });
}