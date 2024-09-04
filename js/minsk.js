let selectedOrg  = 0;
const contMenu = document.getElementById("contMenu");
const body = document.getElementsByTagName("body")[0];
let selectedEquipmentId;

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
    btnAddOborudovanie.className = "btn btn-primary";
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
            let tableContent = '<table class="table" id="infoOb' + selectedOrg + '" style="font-size: 13px;">';
            if (!response.hasOwnProperty('empty')) {
                tableContent += '<thead><tr>';
                let headers = {
                    'name': 'Вид оборудования',
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
                    tableContent += '<td onclick="getEffectTable(' + row.id_oborudovanie + ')" id=idob' + row.id_oborudovanie + ' style="cursor: pointer">' + row.name + '</td>';
                    // tableContent += '<td>' + row.cost + '</td>';
                    tableContent += '<td style="text-align: justify;">' + row.date_create + '</td>';
                    tableContent += '<td style="text-align: justify;">' + row.date_postavki + '</td>';
                    tableContent += '<td>' + row.date_release + '</td>';
                    tableContent += '<td>' + row.service_organization + '</td>';
                    tableContent += '<td>' + row.date_last_TO + '</td>';
                    if (row.status === "1") {
                        tableContent += '<td  onclick="getFaultsTable(' + row.id_oborudovanie + ')" style="cursor: pointer"><div style = "border-radius: 5px;background-color: green;color: white;">исправно</div></td>';
                    } else {
                        tableContent += '<td  onclick="getFaultsTable(' + row.id_oborudovanie + ')" style="cursor: pointer"><div style = "border-radius: 5px;background-color: red;color: white;">неисправно</div></td>';

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
            document.getElementById('edit_date_fault').value = data.date_fault;
            document.getElementById('edit_date_call_service').value = data.date_call_service;
            document.getElementById('edit_reason_fault').value = data.reason_fault;
            document.getElementById('edit_date_procedure_purchase').value = data.date_procedure_purchase;
            document.getElementById('edit_date_dogovora').value = data.date_dogovora;
            document.getElementById('edit_cost_repair').value = data.cost_repair;
            document.getElementById('edit_time_repair').value = data.time_repair;
            document.getElementById('edit_id_fault').value = data.id_fault;

        }
    });
}


function saveFaultData() {

    let dateFault = $('#edit_date_fault').val();
    let dateCallService = $('#edit_date_call_service').val();
    let reasonFault = $('#edit_reason_fault').val();
    let dateProcedurePurchase = $('#edit_date_procedure_purchase').val();
    let dateDogovora = $('#edit_date_dogovora').val();
    let costRepair = $('#edit_cost_repair').val();
    let timeRepair = $('#edit_time_repair').val();
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
            let select_serviceman = document.getElementById("select_serviceman");
            select_serviceman.options.forEach(option => {
                if (option.value === data.service_organization) {
                    option.selected = true;
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
    let select_servicemans = document.getElementById("select_serviceman");
    let select_status = document.getElementById("select_status");
    let sto = select_type_oborudovanie.options[select_type_oborudovanie.selectedIndex].value;
    // let cst = document.getElementById('edit_cost').value;
    let dcr = document.getElementById('edit_date_create').value;
    let dp = document.getElementById('edit_date_postavki').value;
    let dr = document.getElementById('edit_date_release').value;
    let so = select_servicemans.options[select_servicemans.selectedIndex].value;
   // let so = document.getElementById('edit_serviceman').value;
    let dto = document.getElementById('edit_date_last_TO').value;
    let stat = select_status.options[select_status.selectedIndex].value
    console.log(so+"trhrfhhg");
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
            date_create: document.getElementById('edit_date_create').value,
            date_postavki: document.getElementById('edit_date_postavki').value,
            date_release: document.getElementById('edit_date_release').value,
            service_organization: select_servicemans.options[select_servicemans.selectedIndex].value,
            date_last_TO: document.getElementById('edit_date_last_TO').value,
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
    let equipmentFilter = document.getElementById("filterEquipment").value.toLowerCase();
    let yearFilter = document.getElementById("filterYear").value;
    let datePostavkiFilter = document.getElementById("filterDatePostavki").value;
    let dateReleaseFilter = document.getElementById("filterDateRelease").value;
    let serviceFilter = document.getElementById("filterService").value.toLowerCase();
    let statusFilter = document.getElementById("filterStatus").value.toLowerCase();
    let table;
    console.log(selectedOrg);
    let j;
    if (selectedOrg !== 0){
        table = document.getElementById("infoOb" + selectedOrg);
        j = 0;
        }
    else {
        table = document.getElementById("infoObAll");
        j = 1;
    }

    let rows = table.getElementsByTagName("tr");
    for (let i = 1; i < rows.length; i++) {
        let cells = rows[i].getElementsByTagName("td");
        let equipmentMatch = equipmentFilter === "" || cells[j].innerText.toLowerCase().indexOf(equipmentFilter) > -1;
        let yearMatch = yearFilter === "" || cells[j+1].innerText === yearFilter;
        let datePostavkiMatch = datePostavkiFilter === "" || cells[j+2].innerText === datePostavkiFilter;
        let dateReleaseMatch = dateReleaseFilter === "" || cells[j+3].innerText === dateReleaseFilter;
        let serviceMatch = serviceFilter === "" || cells[j+4].innerText.toLowerCase().indexOf(serviceFilter) > -1;
        let statusMatch = statusFilter === "" || cells[j+5].innerText.toLowerCase().indexOf(statusFilter) > -1;
        if (equipmentMatch && yearMatch && datePostavkiMatch && dateReleaseMatch && serviceMatch && statusMatch) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}