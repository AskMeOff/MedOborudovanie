let selectedOrg  = 0;
const contMenu = document.getElementById("contMenu");
const body = document.getElementsByTagName("body")[0];
let selectedEquipmentId;
let selectedServiceId = 0;
let oblId;

function showMenu(thisTr, idOborudovanie) {
    event.preventDefault();
    selectedEquipmentId = idOborudovanie;
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

function showSection(idOrg, element) {
    selectedOrg = idOrg;
    let oldActive = document.getElementsByClassName("activecard1")[0];
    if (oldActive)
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
    if (btnAddOborudovanie)
        btnAddOborudovanie.remove();
    btnAddOborudovanie = document.createElement("button");
    btnAddOborudovanie.innerHTML = "Добавить оборудование";
    btnAddOborudovanie.id = "btnAddOborudovanie";
    btnAddOborudovanie.className = "btn btn-info";
    container_fluid.insertAdjacentElement("afterbegin", btnAddOborudovanie);

    btnAddOborudovanie.onclick = () => {
        $('#editBtnOb').hide();
        $('#addBtnOb').show();
        $('#editOborudovanieModal').modal('show');
        $('#editOborudovanieModal .modal-title').text("Добавление оборудования");
        let select_type_oborudovanie = document.getElementById("select_type_oborudovanie");
        select_type_oborudovanie.options[0].selected = true;
        // document.getElementById('edit_cost').value = "";
        document.getElementById('edit_date_create').value = "";
        document.getElementById('edit_date_release').value = "";
        document.getElementById('edit_model_prozvoditel').value = "";
        // document.getElementById('select_serviceman').value = "";
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

function getFaultsTable(idOborudovanie) {
    selectedEquipmentId = idOborudovanie;
    event.stopPropagation();
    $.ajax({
        url: '/app/ajax/getFaultsTable.php',
        type: 'GET',
        data: {id_oborudovanie: idOborudovanie},
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
                    'date_dogovora': 'Дата заключения договора',
                    'cost_repair': 'Стоимость ремонта',
                    'time_repair': 'Срок ремонта/поставки запасных частей',
                    'downtime': 'Время простоя',
                    'remont': 'Отремонтировано',
                    'date_remont': 'Дата ремонта',
                    'id_fault': 'Действия'
                };
                Object.keys(headers).forEach(function (key) {
                    tableContent += '<th>' + headers[key] + '</th>';
                });
                tableContent += '</tr></thead><tbody>';
                data.forEach(function (row) {
                    let today = new Date();
                    tableContent += '<tr>';
                    tableContent += '<td>' + row.date_fault + '</td>';
                    tableContent += '<td>' + row.date_call_service + '</td>';
                    tableContent += '<td style="text-align: justify;">' + row.reason_fault + '</td>';
                    tableContent += '<td>' + row.date_procedure_purchase + '</td>';
                    if (row.date_dogovora == null)
                        tableContent += '<td></td>';
                    else
                        tableContent += '<td>' + row.date_dogovora + '</td>';
                    tableContent += '<td>' + row.cost_repair + '</td>';
                    tableContent += '<td>' + row.time_repair + '</td>';
                    let countDays = Math.floor((today.getTime() - new Date(row.date_fault).getTime()) / (1000 * 60 * 60 * 24));
                    let stringDays = countDays.toString() === "NaN" ? 'Не выставлена дата поломки' : (countDays + " дней");
                    tableContent += '<td>' + stringDays + '</td>';
                    tableContent += '<td>' + (row.remont > 0 ? 'Да' : 'Нет') +  '</td>';
                    tableContent += '<td>' + row.date_remont + '</td>';
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

function refreshMainTable() {
    let trel = document.getElementById("idob" + selectedEquipmentId)
    $.ajax({
        url: '/app/ajax/refreshTable.php',
        method: 'GET',
        data: {id_org: selectedOrg},
        dataType: 'json',
        success: function (response) {
            let tableContent = '<table class="table table-striped table-responsive-sm no-footer dataTable" id="infoOb' + selectedOrg + '" style="font-size: 13px;">';
            if (!response.hasOwnProperty('empty')) {
                tableContent += '<thead><tr>';
                let headers = {
                    'name': 'Вид оборудования',
                    'model': 'Модель, производитель',
                    // 'cost': 'Стоимость',
                    'date_create': 'Год производства',
                    'date_postavki': 'Дата поставки',
                    'date_release': 'Дата ввода в эксплуатацию',
                    'service_organization': 'Сервисная организация',
                    'date_last_TO': 'Дата последнего ТО',
                    'status': 'Статус',
                    'id_oborudovanie': 'Действие'
                };
                console.log(response);
                Object.keys(headers).forEach(function (key) {
                    tableContent += '<th>' + headers[key] + '</th>';
                });
                tableContent += '</tr></thead><tbody>';
                response.forEach(function (row) {
                    let today = new Date();
                    tableContent += '<tr>';
                    tableContent += '<td onclick="getEffectTable(' + row.id_oborudovanie + ')" id=idob' + row.id_oborudovanie + ' style="cursor: pointer; color: #167877;\n' +
                        '    font-weight: 550;">' + row.name + '</td>';
                    tableContent += '<td>' + row.model + '</td>';
                    tableContent += '<td style="text-align: justify;">' + row.date_create + '</td>';
                    tableContent += '<td style="text-align: justify;">' + row.date_postavki + '</td>';
                    tableContent += '<td>' + row.date_release + '</td>';
                    tableContent += '<td>' + row.service_organization + '</td>';
                    tableContent += '<td>' + row.date_last_TO + '</td>';
                    if (row.status === "1") {
                        tableContent += '<td  onclick="getFaultsTable(' + row.id_oborudovanie + ')" style="cursor: pointer; "><div style = "border-radius: 5px;background-color: green;color: white;padding: 5px;">исправно</div></td>';
                    } else {
                        tableContent += '<td  onclick="getFaultsTable(' + row.id_oborudovanie + ')" style="cursor: pointer"><div style = "border-radius: 5px;background-color: red;color: white;padding: 5px; font-size: 11px; width: 85px;">неисправно</div></td>';

                    }
                    tableContent += '<td><a href="#" onclick="confirmDeleteOborudovanie(' + row.id_oborudovanie + ')">&#10060;</a><a href="#" onclick="editOborudovanie(' + row.id_oborudovanie + ')">✏️</a></td>';
                    tableContent += '</tr>';
                });
            } else {
                tableContent += '<thead><tr>';
                tableContent += '<th></th>';
                tableContent += '</tr></thead><tbody>';
                tableContent += '<tr><td colspan="8" style="text-align:center;">Нет данных</td></tr>';
            }

            tableContent += '</tbody></table>';
            $('#org' + selectedOrg + ' .table-responsive').html(tableContent);
            $('#editOborudovanieModal').modal('hide');
            $('#infoOb' + selectedOrg).DataTable();
        },
        error: function (xhr, status, error) {
            console.log(error);
        }
    });

}


function getEffectTable(selectedEquipmentId) {
    $.ajax({
        url: '/app/ajax/getEffectTable.php',
        type: 'GET',
        data: {id_oborudovanie: selectedEquipmentId},
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
            } else {
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


function confirmDeleteEffect(id_use_efficiency) {
    if (confirm('Вы точно хотите удалить эту запись?')) {
        $.ajax({
            url: '/app/ajax/deleteEffect.php',
            type: 'POST',
            data: {id_use_efficiency: id_use_efficiency},
            success: function (response) {
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
    event.stopPropagation();
    if (confirm('Вы точно хотите удалить эту запись?')) {
        $.ajax({
            url: '/app/ajax/deleteOborudovanie.php',
            type: 'POST',
            data: {id_oborudovanie: idOborudovanie},
            success: function (response) {
                if (response === "Запись успешно удалена.") {
                    $('#deleteModal').modal('show');
                    $('#deleteModal').on('hidden.bs.modal', function (e) {
                        $('#deleteModal').modal('hide');
                        refreshMainTable();
                    });
                } else {
                    refreshMainTable();
                }

            }
        });
    }
}


function addFualt() {
    // e.preventDefault();

    let date_fault = $('#date_fault').val();
    let date_call_service = $('#date_call_service').val();
    let reason_fault = $('#reason_fault').val();
    let date_procedure_purchase = $('#date_procedure_purchase').val();
    let date_dogovora = $('#date_dogovora').val();
    let cost_repair = $('#cost_repair').val();
    let time_repair = $('#time_repair').val();
    // let downtime = $('#downtime').val();


    let data = {
        date_fault: date_fault,
        date_call_service: date_call_service,
        reason_fault: reason_fault,
        date_procedure_purchase: date_procedure_purchase,
        date_dogovora: date_dogovora,
        cost_repair: cost_repair,
        time_repair: time_repair,
        // downtime: downtime,
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
                    getFaultsTable(selectedEquipmentId);
                });
            } else {
                getFaultsTable(selectedEquipmentId);
            }
        }
    });
}


$('#addEffectForm').on('submit', function (e) {
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
                    getEffectTable(selectedEquipmentId);
                });
            } else {
                getEffectTable(selectedEquipmentId);
            }
        }
    });
});


function editFault(id_fault) {
    $.ajax({
        url: '/app/ajax/getSingleFault.php',
        type: 'GET',
        data: {id_fault: id_fault},
        dataType: 'json',
        success: function (data) {
            $('#editFaultModal').modal('show');
            const remontSelect = document.getElementById('edit_remont');
            document.getElementById('edit_date_fault').value = data.date_fault;
            document.getElementById('edit_date_call_service').value = data.date_call_service;
            document.getElementById('edit_reason_fault').value = data.reason_fault;
            document.getElementById('edit_date_procedure_purchase').value = data.date_procedure_purchase;
            document.getElementById('edit_date_dogovora').value = data.date_dogovora;
            document.getElementById('edit_cost_repair').value = data.cost_repair;
            document.getElementById('edit_time_repair').value = data.time_repair;
            console.log (data.remont + '[eq[e[[qe[q[we[qew[eqe')
            const remontValue = parseInt(data.remont, 10);
            if (remontValue  === 1) {
                remontSelect.value = '1';
            } else if (remontValue  === 0) {
                remontSelect.value = '0';
            } else {
                remontSelect.value = '';
            }
            document.getElementById('edit_date_remont').value = data.date_remont;
            document.getElementById('edit_id_fault').value = data.id_fault;

        }
    });
}


function saveFaultData() {

    let dateFault = $('#edit_date_fault').val() || null;
    let dateCallService = $('#edit_date_call_service').val() || null;
    let reasonFault = $('#edit_reason_fault').val() || null;
    let dateProcedurePurchase = $('#edit_date_procedure_purchase').val() || null;
    let dateDogovora = $('#edit_date_dogovora').val() || null;
    let costRepair = $('#edit_cost_repair').val() || null;
    let timeRepair = $('#edit_time_repair').val() || null;
    let remont = $('#edit_remont').val() || null;
    let date_remont = $('#edit_date_remont').val() || null;
    // let downtime = $('#edit_downtime').val();
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
            date_dogovora: dateDogovora,
            cost_repair: costRepair,
            time_repair: timeRepair,
            remont: remont,
            date_remont: date_remont,
            // downtime: downtime
        },
        success: function (response) {
            if (response === "Запись обновлена.") {
                $('#editFaultModal').modal('hide');
                $('#saveModal').modal('show');
                $('#saveModal').on('hidden.bs.modal', function (e) {
                    $('#saveModal').modal('hide');
                    getFaultsTable(selectedEquipmentId);
                });
            } else {
                getFaultsTable(selectedEquipmentId);
            }
        }
    });
}

function btnSaveFault() {
    event.preventDefault();
    saveFaultData();
}


//--------------------------------

function editEffect(id_use_efficiency) {
    $.ajax({
        url: '/app/ajax/getSingleEffect.php',
        type: 'GET',
        data: {id_use_efficiency: id_use_efficiency},
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
        success: function (response) {
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
    event.stopPropagation();
    editedOborudovanie = idOborudovanie;
    $.ajax({
        url: '/app/ajax/getSingleOborudovanie.php',
        type: 'GET',
        data: {id_oborudovanie: idOborudovanie},
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
            // document.getElementById('edit_cost').value = data.cost;
            document.getElementById('edit_date_create').value = data.date_create;
            document.getElementById('edit_date_postavki').value = data.date_postavki;
            document.getElementById('edit_date_release').value = data.date_release;
            document.getElementById('edit_model_prozvoditel').value = data.model_prozvoditel;
            let select_serviceman = document.getElementById("filterServicemans");
            let filteredDiv = select_serviceman.nextElementSibling.children;////
            filteredDiv.forEach(item => {
                if (item.getAttribute('data-id') == data.service_organization) {

                    select_serviceman.setAttribute('data-id', item.getAttribute('data-id'))
                    select_serviceman.value = item.innerText;
                }
            });
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

function saveEditedOborudovanie() {
    let select_type_oborudovanie = document.getElementById("select_type_oborudovanie");
    let select_servicemans = document.getElementById("filterServicemans");
    let select_status = document.getElementById("select_status");
    let sto = select_type_oborudovanie.options[select_type_oborudovanie.selectedIndex].value;
    // let cst = document.getElementById('edit_cost').value;
    let dcr = document.getElementById('edit_date_create').value;
    let dp = document.getElementById('edit_date_postavki').value;
    let dr = document.getElementById('edit_date_release').value;
    let mod = document.getElementById('edit_model_prozvoditel').value;
    let so = select_servicemans.getAttribute('data-id');
   // let so = document.getElementById('edit_serviceman').value;
    let dto = document.getElementById('edit_date_last_TO').value;
    let stat = select_status.options[select_status.selectedIndex].value

    if(selectedServiceId)
        so = selectedServiceId;
    $.ajax({
        url: '/app/ajax/updateOborudovanie.php',
        type: 'POST',
        data: {
            id_oborudovanie: editedOborudovanie,
            id_type_oborudovanie: select_type_oborudovanie.options[select_type_oborudovanie.selectedIndex].value,
            // cost: document.getElementById('edit_cost').value,
            date_create: dcr,
            date_postavki: dp,
            date_release: dr,
            model_prozvoditel: mod,
            service_organization: so,
            date_last_TO: document.getElementById('edit_date_last_TO').value,
            status: select_status.options[select_status.selectedIndex].value
        },
        success: function (data) {
            if (data == "1") {

                refreshMainTable();
                alert("Запись изменена");
            } else {
                alert("Ошибка в заполнении");
            }

        }
    });
}

$('#editFaultForm').on('submit', function (event) {
    event.preventDefault();
    saveFaultData();
});

$('#editEffectForm').on('submit', function (event) {
    event.preventDefault();
    saveEffectData();
});


function saveAddedOborudovanie() {
    let select_type_oborudovanie = document.getElementById("select_type_oborudovanie");
    let select_servicemans = document.getElementById("select_serviceman");
    let select_status = document.getElementById("select_status");

    $.ajax({
        url: '/app/ajax/insertOborudovanie.php',
        type: 'POST',
        data: {
            id_type_oborudovanie: select_type_oborudovanie.options[select_type_oborudovanie.selectedIndex].value,
            // cost: document.getElementById('edit_cost').value,
            date_create: document.getElementById('edit_date_create').value || null,
            date_postavki: document.getElementById('edit_date_postavki').value || null,
            date_release: document.getElementById('edit_date_release').value || null,
            model_prozvoditel: document.getElementById('edit_model_prozvoditel').value || null,
            service_organization: selectedServiceId || null,
            date_last_TO: document.getElementById('edit_date_last_TO').value || null,
            status: select_status.options[select_status.selectedIndex].value,
            id_org: selectedOrg
        },
        success: function (data) {
            if (data == "1") {
                alert("Запись добавлена");
                refreshMainTable();
            } else {
                alert("Ошибка в заполнении");
            }

        }
    });
}



function startFilter() {
    let filterContainer = document.getElementById("filterContainer");
    filterContainer.style.display = filterContainer.style.display === "none" ? "block" : "none";
}
function filterTable() {
    let equipmentFilter = $("#filterEquipment").val();
    let yearFilter = $("#filterYear").val();
    let datePostavkiFilter = $("#filterDatePostavki").val();
    let dateReleaseFilter = $("#filterDateRelease").val();
    let serviceFilter = $("#filterService").val();
    let statusFilter = $("#filterStatus").val();
    if (selectedOrg>0) {
        $.ajax({
            type: "POST",
            url: "/app/ajax/filterGetData.php",
            data: {
                equipment: equipmentFilter,
                id_uz: selectedOrg,
                year: yearFilter,
                datePostavki: datePostavkiFilter,
                dateRelease: dateReleaseFilter,
                service: serviceFilter,
                status: statusFilter
            },
            success: function (response) {
                $('#infoOb' + selectedOrg).DataTable().destroy();
                $("#infoOb" + selectedOrg).html(response);
                $('#infoOb' + selectedOrg).DataTable();

            },
            error: function (xhr, status, error) {
                console.error("Ошибка при выполнении запроса: " + error);
            }
        });
    }
    else{
console.log (oblId + "oblast");
        $.ajax({
            type: "POST",
            url: "/app/ajax/filterGetDataNoOrg.php",
            data: {
                equipment: equipmentFilter,
                id_obl: oblId,
                year: yearFilter,
                datePostavki: datePostavkiFilter,
                dateRelease: dateReleaseFilter,
                service: serviceFilter,
                status: statusFilter
            },
            success: function (response) {
                $('#infoObAll').DataTable().destroy();
                $('#infoObAll').html(response);
                $('#infoObAll').DataTable();

            },
            error: function (xhr, status, error) {
                console.error("Ошибка при выполнении запроса: " + error);
            }
        });
    }
}

let selectedPostavschikId = 0;

function filterS(event, id){
    let filetS = event.target;
    let filteredDiv = filetS.nextElementSibling;
    if(filteredDiv.classList.contains("hidden")) {
        filteredDiv.classList.remove("hidden");
    }else{
        filteredDiv.classList.add("hidden");
    }
    let arrServices = Array.from(filteredDiv.children).map(function(event) {
        return {data_id: event.getAttribute('data-id'), text: event.innerText};
    });
    filetS.addEventListener("input", function(event) {
        let sortedArr = arrServices.filter( (item) => {
                return item.text.toLowerCase().includes(event.target.value.toLowerCase()) ;
        });

        let items = filteredDiv.children;
        let visibleIds = sortedArr.map(item => item.data_id);


        for (let i = 0; i < items.length; i++) {
            const dataId = items[i].getAttribute('data-id');
            if (visibleIds.includes(dataId)) {
                items[i].style.display = '';
            } else {
                items[i].style.display = 'none';
            }
        }
        if(filetS.value == "") {
            if(id == 2) {
                selectedPostavschikId = 0;
                filetS.setAttribute('data-id', selectedPostavschikId);

            }else {
                selectedServiceId = 0;
                filetS.setAttribute('data-id', selectedServiceId);

            }
            if(!filteredDiv.classList.contains("hidden")) {
                filteredDiv.classList.add("hidden");
            }
        }else{
            if(filteredDiv.classList.contains("hidden")) {
                filteredDiv.classList.remove("hidden");
            }
        }



    });
}



function setServiceman(event){
    $("#filterServicemans").val(event.target.innerText);
    selectedServiceId = event.target.getAttribute('data-id');
}

function setPostavschik(event){
    $("#filterPostavschik").val(event.target.innerText);
    selectedPostavschikId = event.target.getAttribute('data-id');
}

function showModalAddOborudovanieUnspecified(){
    $('#editBtnOb').hide();
    $('#addBtnOb').show();
    $('#editOborudovanieModal').modal('show');
    $('#editOborudovanieModal .modal-title').text("Добавление оборудования");
}

function addOborudovanieUnspecified(){
    if(selectedServiceId === 0){
        alert("Выберите сервисную организацию из списка!");
        return;
    }
    if(selectedPostavschikId === 0){
        alert("Выберите поставщика из списка!");
        return;
    }
    $.ajax({
        url: '/app/ajax/insertOborudovanieUnspecified.php',
        type: 'POST',
        data: {
            id_type_oborudovanie: document.getElementById('select_type_oborudovanie').options[document.getElementById('select_type_oborudovanie').selectedIndex].value,
            cost: document.getElementById('edit_cost').value,
            model: document.getElementById('edit_model').value || null,
            contract: document.getElementById('edit_contract').value || null,
            id_serviceman: selectedServiceId || null,
            id_postavschik: selectedPostavschikId || null,
            date_get_sklad: document.getElementById('edit_date_get_oborud').value || null,
            date_srok_vvoda: document.getElementById('edit_date_srok_vvoda').value || null,
            reasons: document.getElementById('edit_reasons').value || null
        },
        success: function (data) {
            if (data == "1"){
                alert("Оборудование добавлено!");
                location.reload();
            }
            else{
                alert("Произошла непредвиденная ошибка, свяжитесь с разработчиком");
            }
        }
    })
}

function toggleRightSection() {
    let right_section = $("#right_section");

    let section = $(".connectedSortable");
    if (section.hasClass("col-lg-9")) {
        right_section.removeClass("viehal");
        right_section.addClass("zaehal");
        setTimeout(() => {
            section.removeClass("col-lg-9");
            section.addClass("col-lg-12");
            right_section.toggle();

        }, 800)

    } else {
        right_section.toggle();
        section.removeClass("col-lg-12");
        section.addClass("col-lg-9");
        right_section.removeClass("zaehal");
        right_section.addClass("viehal");

    }
    $("#arrow-left").toggle();

}