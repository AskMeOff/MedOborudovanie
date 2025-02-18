let selectedOrg = 0;
const contMenu = document.getElementById("contMenu");
const body = document.getElementsByTagName("body")[0];
let selectedEquipmentId;
let selectedServiceId = 0;
let selectedPostavschikId = 0;
let oblId;
let currselectedEquipmentId;
let globalserviceman;
let globalpostavschick;
let selectedEquipmentType = null;

let selectedItemFromReestr;


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



    new Promise((resolve, reject) => {
        $.ajax({
            url: 'app/ajax/getOrg.php',
            method: 'GET',
            data: { id_uz: idOrg }
        }).done(response => {
            section.innerHTML = response;
            resolve(); // Вызываем resolve() здесь, когда запрос завершен
        }).fail(error => {
            reject(error); // Обрабатываем ошибку, если запрос не удался
        });
    }).then(() => {
        let tableid = document.getElementById('infoOb' + idOrg);
        tableid.style.display = "block"; // Изменяем стиль отображения
    }).catch(error => {
        console.error('Ошибка при получении данных:', error); // Обрабатываем ошибку
    });



    $('#infoOb' + idOrg).DataTable();


    //showTable('infoOb' + idOrg);

    let container_fluid = document.getElementById("container_fluid");
    let btnAddOborudovanie = document.getElementById("btnAddOborudovanie");
    if (btnAddOborudovanie)
        btnAddOborudovanie.remove();
    btnAddOborudovanie = document.createElement("button");
    btnAddOborudovanie.innerHTML = "Добавить оборудование";
    btnAddOborudovanie.id = "btnAddOborudovanie";
    btnAddOborudovanie.className = "btn btn-info m-2";
    container_fluid.insertAdjacentElement("afterbegin", btnAddOborudovanie);

    btnAddOborudovanie.onclick = () => {

        $('#editBtnOb').hide();
        $('#addBtnOb').show();
        $('#yearError').hide();
        $('#editOborudovanieModal').modal('show');
        document.getElementById('addBtnOb').onclick = saveEditedOborudovanie1;
        $('#editOborudovanieModal .modal-title').text("Добавление оборудования");
        let select_type_oborudovanie = document.getElementById("select_type_oborudovanie");
        select_type_oborudovanie.options[0].selected = true;
        // document.getElementById('edit_cost').value = "";
        document.getElementById('edit_date_create').value = "";
        document.getElementById('edit_date_release').value = "";
        // document.getElementById('edit_model_prozvoditel').value = "";
        document.getElementById('filterSerialNumber').value = "";
        document.getElementById('zavod_nomer').value = "";
        document.getElementById('edit_date_postavki').value = "";
        document.getElementById('edit_date_postavki').value = "";
        document.getElementById('filterServicemans').value = "";
        // document.getElementById('select_serviceman').value = "";
        document.getElementById('edit_date_last_TO').value = "";


        let select_status = document.getElementById("select_status");
        select_status.options[0].selected = true;

    }
    let btnExportExcel = document.getElementById("btnExportExcel");
    if (btnExportExcel)
        btnExportExcel.remove();
    btnExportExcel = document.createElement("button");
    btnExportExcel.innerHTML = "Экспорт в Excel";
    btnExportExcel.id = "btnExportExcel";
    btnExportExcel.className = "btn btn-info";
    container_fluid.insertAdjacentElement("afterbegin", btnExportExcel);
    btnExportExcel.onclick = () => {
        exportTableToExcelAddedOb('infoOb' + idOrg, 'Отчет_организация_' + idOrg);

    }
    filterTable();
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
                    'remontOrg': 'Организация осуществляющая ремонт',
                    'documentOrg': 'Документ',
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
                    tableContent += '<td>' + (row.remont > 0 ? 'Да' : 'Нет') + '</td>';
                    tableContent += '<td>' + row.date_remont + '</td>';
                    tableContent += '<td>' + row.remontOrg + '</td>';
                    tableContent += '<td><a href="app/documents/' + row.id_fault + '/' + row.documentOrg + '" target="_blank">' + row.documentOrg + '</a></td>';
                    tableContent += '<td><a href="#" onclick="confirmDeleteFault(' + row.id_fault + '); return false;"><i class="fa fa-trash" style="font-size: 20px;"></i></a><a href="#" onclick="editFault(' + row.id_fault + ');"><i class="fa fa-edit" style="font-size: 20px;"></i>️</a></td>';
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
    let liItems = document.querySelectorAll('#menu_ustanovl .submenu1 li');
    let activeItemName = null;
    liItems.forEach(item => {
        if (item.classList.contains('active')) {
            activeItemName = item.textContent.trim();
        }
    });
    if (activeItemName) {
     let filterEquipment = document.getElementById("filterEquipment");

        filterEquipment.value = activeItemName;
        filterTable();

    } else {
        // let trel = document.getElementById("idob" + selectedEquipmentId)
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
                        'mark1': '!!!',
                        'name': 'Вид оборудования',
                        'model': 'Модель, производитель',
                        'serial_number': 'Регистрационный номер оборудования',
                        'zavod_nomer': 'Серийный(заводской) номер',
                        'date_create': 'Год производства',
                        'date_postavki': 'Дата поставки',
                        'date_release': 'Дата ввода в эксплуатацию',
                        'service_organization': 'Сервисная организация',
                        'date_last_TO': 'Дата последнего ТО',
                        'status': 'Статус',
                        'id_oborudovanie': 'Действие'
                    };
                    Object.keys(headers).forEach(function (key) {
                        tableContent += '<th>' + headers[key] + '</th>';
                    });
                    tableContent += '</tr></thead><tbody>';
                    response.forEach(function (row) {
                        let today = new Date();
                        tableContent += '<tr>';
                        tableContent += '<td>' + row.mark1 + '</td>';
                        tableContent += '<td onclick="getEffectTable(' + row.id_oborudovanie + ')" id=idob' + row.id_oborudovanie + ' style="cursor: pointer; color: #167877;\n' +
                            '    font-weight: 550;">' + row.name + '</td>';
                        tableContent += '<td>' + row.model + '</td>';
                        tableContent += '<td>' + row.serial_number + '</td>';
                        tableContent += '<td>' + row.zavod_nomer + '</td>';
                        tableContent += '<td style="text-align: justify;">' + row.date_create + '</td>';
                        tableContent += '<td style="text-align: justify;">' + formatDate(row.date_postavki) + '</td>';
                        tableContent += '<td>' + formatDate(row.date_release) + '</td>';
                        tableContent += '<td>' + row.service_organization + '</td>';
                        tableContent += '<td>' + formatDate(row.date_last_TO) + '</td>';
                        if (row.status === "1") {
                            tableContent += '<td  onclick="getFaultsTable(' + row.id_oborudovanie + ')" style="cursor: pointer; "><div style = "border-radius: 5px;background-color: green;color: white;padding: 5px;">исправно</div></td>';
                        } else if (row.status === "3") {
                            tableContent += '<td  onclick="getFaultsTable(' + row.id_oborudovanie + ')" style="cursor: pointer; "><div style = "border-radius: 5px;background-color: orange;color: white;padding: 5px;">Работа в ограниченном режиме</div></td>';
                        } else {
                            tableContent += '<td  onclick="getFaultsTable(' + row.id_oborudovanie + ')" style="cursor: pointer"><div style = "border-radius: 5px;background-color: red;color: white;padding: 5px; font-size: 11px; width: 85px;">неисправно</div></td>';

                        }
                        tableContent += '<td>' +
                            '<a href="#" onclick="confirmDeleteOborudovanie(' + row.id_oborudovanie + ')">' +
                            '<i class="fa fa-trash" style="font-size: 20px;"></i></a>' +
                            '<a href="#" onclick="editOborudovanie(' + row.id_oborudovanie + ')">' +
                            '<i class="fa fa-edit" style="font-size: 20px;"></i>️</a>' +

                            '</td>';
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
                $('#infoOb' + selectedOrg).DataTable({
                    "stateSave": true
                });
            },

            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }
    $('#editOborudovanieModal').modal('hide');


}

function formatYear(dateString) {
    if (!dateString) return 'Нет данных';
    const date = new Date(dateString);
    return date.getFullYear();
}

function formatDate(dateString) {
    if (!dateString) return 'Нет данных';
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    return `${day}.${month}.${year}`;
}

function getEffectTable(selectedEquipmentId) {
    currselectedEquipmentId = selectedEquipmentId;
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
                    'data_year_efficiency': 'Год',
                    'data_month_efficiency': 'Месяц'

                };
                Object.keys(headers).forEach(function (key) {
                    tableContent += '<th>' + headers[key] + '</th>';
                });
                tableContent += '</tr></thead><tbody>';

                data.forEach(function (row) {
                    tableContent += '<tr>';
                    tableContent += '<td>' + row.count_research + '</td>';
                    tableContent += '<td>' + row.count_patient + '</td>';
                    tableContent += '<td><a href="#" onclick="confirmDeleteEffect(' + row.id_use_efficiency + '); return false;"><i class="fa fa-trash" style="font-size: 20px;"></i></a><a href="#" onclick="editEffect(' + row.id_use_efficiency + ');"><i class="fa fa-edit" style="font-size: 20px;"></i>️</a></td>';
                    tableContent += '<td>' + row.data_year_efficiency + '</td>';
                    tableContent += '<td>' + row.data_month_efficiency + '</td>';
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
                        getEffectTable(currselectedEquipmentId);
                    });
                } else {
                    getEffectTable(currselectedEquipmentId);
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

function confirmDeleteOborudovanie1(idOborudovanie) {
    event.stopPropagation();
    let nowHref = location.href;
    if (confirm('Вы точно хотите удалить эту запись?')) {
        $.ajax({
            url: '/app/ajax/deleteOborudovanie.php',
            type: 'POST',
            data: {id_oborudovanie: idOborudovanie},
            success: function (response) {
                if (response === "Запись успешно удалена.") {
                    $('#deleteModal').modal('show');
                    location.reload();
                    $('#deleteModal').on('hidden.bs.modal', function (e) {
                        $('#deleteModal').modal('hide');

                    });
                } else {
                    location.reload();
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
    let add_remontOrg = $('#add_remontOrg').val();
    // let downtime = $('#downtime').val();

    let fileReport = document.getElementById("document_neispravnost");
    let xhr = new XMLHttpRequest();
    let form = new FormData();

    form.append("fileReport", fileReport.files[0]);
    form.append("date_fault", date_fault);
    form.append("date_call_service", date_call_service);
    form.append("reason_fault", reason_fault);
    form.append("date_procedure_purchase", date_procedure_purchase);
    form.append("date_dogovora", date_dogovora);
    form.append("cost_repair", cost_repair);
    form.append("time_repair", time_repair);
    form.append("add_remontOrg", add_remontOrg);
    form.append("id_oborudovanie", selectedEquipmentId);

    xhr.open("POST", "/app/ajax/insertFault.php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            if (xhr.responseText === "Запись добавлена.") {
                $('#addFaultModal').modal('hide');
                $('#addModal').modal('show');
                $('#addModal').on('hidden.bs.modal', function (e) {
                    $('#addModal').modal('hide');
                    getFaultsTable(selectedEquipmentId);
                });
            } else {
                getFaultsTable(selectedEquipmentId);
            }
        } else {
            console.error("Ошибка при отправке данных: " + xhr.statusText);
        }
    };
    xhr.send(form);
}


function addEffectR() {
    console.log(currselectedEquipmentId);

    let count_research = $('#count_research').val();
    let count_patient = $('#count_patient').val();
    let data_month_efficiency = $('#data_month_efficiency').val();
    let data_year_efficiency = $('#data_year_efficiency').val();
    console.log(data_month_efficiency, data_year_efficiency);
    let data = {
        count_research: count_research,
        count_patient: count_patient,
        id_oborudovanie: currselectedEquipmentId,
        data_month_efficiency: data_month_efficiency,
        data_year_efficiency: data_year_efficiency

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
                    getEffectTable(currselectedEquipmentId);
                });
            } else {
                getEffectTable(currselectedEquipmentId);
                //console.log (response);
            }
        }
    });
}


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
            const documentLink = document.getElementById('document_link');
            const documentName = data.documentOrg;
            const idOborudovanie = data.id_oborudovanie;
            if (documentName) {
                documentLink.innerHTML = `<a href="app/documents/${id_fault}/${documentName}" target="_blank">${documentName}</a>`;
                documentLink.style.display = 'block';
            } else {
                documentLink.innerHTML = '';
                documentLink.style.display = 'none';
            }
            const remontValue = parseInt(data.remont, 10);
            if (remontValue === 1) {
                remontSelect.value = '1';
            } else if (remontValue === 0) {
                remontSelect.value = '0';
            } else {
                remontSelect.value = '';
            }
            document.getElementById('edit_date_remont').value = data.date_remont;
            document.getElementById('edit_remontOrg').value = data.remontOrg || '';
            document.getElementById('edit_id_fault').value = data.id_fault;

        }
    });
}


function saveFaultData() {


    let formData = new FormData();
    formData.append('id_fault', $('#edit_id_fault').val());

    if ($('#edit_date_fault').val()) {
        formData.append('date_fault', $('#edit_date_fault').val());
    }
    if ($('#edit_date_call_service').val()) {
        formData.append('date_call_service', $('#edit_date_call_service').val());
    }
    if ($('#edit_reason_fault').val()) {
        formData.append('reason_fault', $('#edit_reason_fault').val());
    }
    if ($('#edit_date_procedure_purchase').val()) {
        formData.append('date_procedure_purchase', $('#edit_date_procedure_purchase').val());
    }
    if ($('#edit_date_dogovora').val()) {
        formData.append('date_dogovora', $('#edit_date_dogovora').val());
    }
    if ($('#edit_cost_repair').val()) {
        formData.append('cost_repair', $('#edit_cost_repair').val());
    }
    if ($('#edit_time_repair').val()) {
        formData.append('time_repair', $('#edit_time_repair').val());
    }
    if ($('#edit_remont').val()) {
        formData.append('remont', $('#edit_remont').val());
    }
    if ($('#edit_date_remont').val()) {
        formData.append('date_remont', $('#edit_date_remont').val());
    }
    if ($('#edit_remontOrg').val()) {
        formData.append('edit_remontOrg', $('#edit_remontOrg').val());
    }

    let fileInput = document.getElementById('document_neispravnost_edit');
        formData.append('document', fileInput.files[0]);
        console.log (fileInput.files[0]);
    for (let [key, value] of formData.entries()) {
        console.log(`${key}:`, value);
    }
    $.ajax({
        url: '/app/ajax/updateFault.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
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
            document.getElementById('data_year_efficiency').value = data.data_year_efficiency;
            document.getElementById('data_month_efficiency').value = data.data_month_efficiency;

        }
    });
}


function saveEffectData() {

    let countResearch = $('#edit_count_research').val();
    let countPatient = $('#edit_count_patient').val();
    let idUseEfficiency = $('#edit_id_use_efficiency').val();
    let data_year_efficiency = $('#edit_data_year_efficiency').val();
    let data_month_efficiency = $('#edit_data_month_efficiency').val();


    $.ajax({
        url: '/app/ajax/updateEffect.php',
        type: 'POST',
        data: {
            idUseEfficiency: idUseEfficiency,
            countPatient: countPatient,
            countResearch: countResearch,
            data_month_efficiency: data_month_efficiency,
            data_year_efficiency: data_year_efficiency
        },
        success: function (response) {
            if (response === "Запись обновлена.") {
                $('#editEffectModal').modal('hide');
                $('#saveModal').modal('show');
                $('#saveModal').on('hidden.bs.modal', function (e) {
                    $('#saveModal').modal('hide');
                    getEffectTable(currselectedEquipmentId);
                });
            } else {
                getEffectTable(currselectedEquipmentId);
            }
        }
    });
}

let editedOborudovanie;

function editOborudovanie(idOborudovanie) {
    event.stopPropagation();
    document.getElementById('filterSerialNumber').removeAttribute("data-id");
    editedOborudovanie = idOborudovanie;
    $("#preloader").show();
    $.ajax({
        url: '/app/ajax/getSingleOborudovanie.php',
        type: 'GET',
        data: {id_oborudovanie: idOborudovanie},
        dataType: 'json',
    }).then( function (data) {

            $('#editBtnOb').show();
            $('#addBtnOb').hide();
            $('#yearError').hide();

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
            if (data.id_from_reestr == 0) {
                $('#isNotReg').prop("checked", true);
                $('#filterSerialNumber').prop('disabled', true);
                $('#model_name').prop('disabled', false);
                document.getElementById('model_name').value = data.model_prozvoditel;
            } else {
                $('#isNotReg').prop("checked", false);
                $('#filterSerialNumber').prop('disabled', false);
                $('#model_name').prop('disabled', true);
                document.getElementById('model_name').value = data.model_prozvoditel;

            }
            document.getElementById('filterSerialNumber').value = data.serial_number;
            document.getElementById('filterSerialNumber').setAttribute('data-id', data.id_from_reestr);


            document.getElementById('zavod_nomer').value = data.zavod_nomer;
            if (data.service_organization == 0) {
                document.getElementById('filterServicemans').value = "";
            }

            let select_serviceman = document.getElementById("filterServicemans");
            let filteredDiv = select_serviceman.nextElementSibling.children;////
            filteredDiv.forEach(item => {
                if (item.getAttribute('data-id') == data.service_organization) {

                    select_serviceman.setAttribute('data-id', item.getAttribute('data-id'))
                    select_serviceman.value = item.innerText;
                }
            });
            console.log(select_serviceman.value);
            if (select_serviceman.value == 0) {
                let select_servicemans = document.getElementById("filterServicemans");
                globalserviceman = select_servicemans.getAttribute('data-id');
                globalserviceman = 0;
            }
            document.getElementById('edit_date_last_TO').value = data.date_last_TO;


            let select_status = document.getElementById("select_status");
            select_status.options.forEach(option => {
                if (option.value === data['status']) {
                    option.selected = true;
                }
            });


        const waitForJsonReestr = setInterval(() => {
            if (typeof JsonReestr !== 'undefined' && JsonReestr !== null) {
                clearInterval(waitForJsonReestr);
                selectedItemFromReestr = JsonReestr.find((item) => item['Рег_номер_товара'] == data.serial_number);

                $('#editOborudovanieModal').modal('show');
                document.getElementById('addBtnOb').onclick = saveEditedOborudovanie1;
                document.getElementById('editBtnOb').onclick = saveEditedOborudovanie1;
            }
        }, 100);
        $("#preloader").hide();
    });
}

function saveEditedOborudovanie() {
    let select_type_oborudovanie = document.getElementById("select_type_oborudovanie");
    let select_servicemans = document.getElementById("filterServicemans");
    let select_status = document.getElementById("select_status");
    let sto = select_type_oborudovanie.options[select_type_oborudovanie.selectedIndex].value;
    let dcr = document.getElementById('edit_date_create').value;
    let dp = document.getElementById('edit_date_postavki').value;
    let dr = document.getElementById('edit_date_release').value;
    let id_from_reestr = document.getElementById('filterSerialNumber').getAttribute('data-id');
    let serial_number = document.getElementById('filterSerialNumber').value;
    let zavod_nomer = document.getElementById('zavod_nomer').value;
    let so = select_servicemans.getAttribute('data-id');

    console.log(id_from_reestr);
    if (id_from_reestr == null) {
        alert('Не выбран регистрационный номер');
    } else {


        if (selectedServiceId) {
            so = selectedServiceId;
        } else {
            if (select_servicemans.value == "") {
                so = 0;
            }
        }


        let model_name = document.getElementById('model_name').value;

        if (serial_number.trim() === "" && !$('#isNotReg').prop("checked")) {
            $('#serialNumberError').show();
            console.log("Ошибка: Регистрационный номер оборудования для заполнения");
            $('#editOborudovanieModal').animate({
                scrollTop: $('#edit_serial_number').offset().top - $('#editOborudovanieModal').offset().top + $('#editOborudovanieModal').scrollTop() - 150
            }, 500);
            return false;
        } else if (model_name.trim() === "" && $('#isNotReg').prop("checked")) {
            $('#modelError').show();
            console.log("Ошибка: Регистрационный номер оборудования для заполнения");
            $('#editOborudovanieModal').animate({
                scrollTop: $('#edit_serial_number').offset().top - $('#editOborudovanieModal').offset().top + $('#editOborudovanieModal').scrollTop() - 150
            }, 500);
            return false;
        } else {
            $('#serialNumberError').hide();
            $('#modelError').hide();

        }


        const yearValue = $('#edit_date_create').val();

        // Проверяем, является ли год 4-значным числом
        if (!(yearValue === "") && !/^\d{4}$/.test(yearValue)) {
            $('#yearError').show();  // Показываем сообщение об ошибке
            console.log("Ошибка: значение пустое или не 4 цифры");
            $('#editOborudovanieModal').animate({
                scrollTop: $('#edit_date_create').offset().top - $('#editOborudovanieModal').offset().top + $('#editOborudovanieModal').scrollTop() - 150
            }, 500);
            return false;  // Останавливаем выполнение функции, предотвращаем сохранение
        }

        $('#yearError').hide();  // Скрываем сообщение об ошибке, если данные корректны

        $.ajax({
            url: '/app/ajax/updateOborudovanie.php',
            type: 'POST',
            data: {
                id_oborudovanie: editedOborudovanie,
                id_type_oborudovanie: sto,
                date_create: dcr,
                date_postavki: dp,
                date_release: dr,
                model_prozvoditel: $('#isNotReg').prop('checked') ? $('#model_name').val() : selectedItemFromReestr['Наименование'] + selectedItemFromReestr['Производитель'],
                serial_number: $('#isNotReg').prop('checked') ? "000" : selectedItemFromReestr['Рег_номер_товара'],
                zavod_nomer: zavod_nomer,
                id_from_reestr: $('#isNotReg').prop('checked') ? 0 : id_from_reestr,
                service_organization: so,
                date_last_TO: document.getElementById('edit_date_last_TO').value,
                status: select_status.options[select_status.selectedIndex].value
            },
            success: function (data) {
                if (data == "1") {
                    alert("Запись изменена");
                    refreshMainTable();
                } else {
                    alert("Ошибка в заполнении");
                }

                let newEquipmentName = select_type_oborudovanie.options[select_type_oborudovanie.selectedIndex].text;
                //console.log("Добавленное оборудование:", newEquipmentName);

                // Убедимся, что таблица обновилась
                setTimeout(function () {
                    let searchValue = newEquipmentName.trim().toLowerCase();
                    let matchingIndex = -1; // Начальное значение для индекса

                    // Используем метод rows().data() для получения всех данных
                    let allData = $('#infoOb' + selectedOrg).DataTable().rows().data();

                    // Перебираем строки данных в обратном порядке
                    for (let i = allData.length - 1; i >= 0; i--) {
                        let equipmentName = allData[i][0].trim().toLowerCase(); // Получаем название оборудования из первой ячейки

                        //console.log(`Сравниваем: '${equipmentName}' с '${searchValue}'`);

                        // Если текст ячейки совпадает с названием оборудования
                        if (equipmentName.includes(searchValue)) {
                            matchingIndex = i; // Сохраняем индекс найденной строки
                            break; // Прерываем цикл, так как мы нашли последнюю запись
                        }
                    }

                    if (matchingIndex !== -1) {
                        //console.log("Последняя запись с названием 'УЗИ Аппараты' найдена на индексе:", matchingIndex);

                        // Теперь находим страницу для перехода
                        let table = $('#infoOb' + selectedOrg).DataTable();
                        let pageSize = table.page.len();
                        let newPage = Math.floor(matchingIndex / pageSize);

                        // Переходим на нужную страницу
                        table.page(newPage).draw(false);

                        // Прокручиваем к новой строке
                        let newRow = $('#infoOb' + selectedOrg).find('tr').eq(matchingIndex + 1); // +1 для учета заголовка
                    }

                }, 200); // Небольшая задержка, чтобы убедиться, что таблица обновилась
            },
            error: function (xhr, status, error) {
                console.error("Ошибка при добавлении записи: " + error);
            }
        });
    }
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
    let select_status = document.getElementById("select_status");
    let id_from_reestr = document.getElementById('filterSerialNumber').getAttribute('data-id');
    let serial_number = document.getElementById('filterSerialNumber').value;
    let zavod_nomer = document.getElementById('zavod_nomer').value;
    let model_name = document.getElementById('model_name').value;

    if (serial_number.trim() === "" && !$('#isNotReg').prop("checked")) {
        $('#serialNumberError').show();
        console.log("Ошибка: Регистрационный номер оборудования для заполнения");
        $('#editOborudovanieModal').animate({
            scrollTop: $('#edit_serial_number').offset().top - $('#editOborudovanieModal').offset().top + $('#editOborudovanieModal').scrollTop() - 150
        }, 500);
        return false;
    } else if (model_name.trim() === "" && $('#isNotReg').prop("checked")) {
        $('#modelError').show();
        console.log("Ошибка: Регистрационный номер оборудования для заполнения");
        $('#editOborudovanieModal').animate({
            scrollTop: $('#edit_serial_number').offset().top - $('#editOborudovanieModal').offset().top + $('#editOborudovanieModal').scrollTop() - 150
        }, 500);
        return false;
    } else {
        $('#serialNumberError').hide();
        $('#modelError').hide();

    }


    const yearValue = $('#edit_date_create').val();


    if (!(yearValue === "") && !/^\d{4}$/.test(yearValue)) {
        $('#yearError').show();
        return false;
    }

    $('#yearError').hide();


    $.ajax({
        url: '/app/ajax/insertOborudovanie.php',
        type: 'POST',
        data: {
            id_type_oborudovanie: select_type_oborudovanie.options[select_type_oborudovanie.selectedIndex].value,
            date_create: document.getElementById('edit_date_create').value || null,
            date_postavki: document.getElementById('edit_date_postavki').value || null,
            date_release: document.getElementById('edit_date_release').value || null,
            model_prozvoditel: $('#isNotReg').prop('checked') ? $('#model_name').val() : selectedItemFromReestr['Наименование'] + selectedItemFromReestr['Производитель'],
            serial_number: $('#isNotReg').prop('checked') ? "000" : selectedItemFromReestr['Рег_номер_товара'],
            zavod_nomer: zavod_nomer,
            id_from_reestr: $('#isNotReg').prop('checked') ? 0 : id_from_reestr,
            service_organization: selectedServiceId || null,
            date_last_TO: document.getElementById('edit_date_last_TO').value || null,
            status: select_status.options[select_status.selectedIndex].value,
            id_org: selectedOrg
        },
        success: function (data) {
            if (data === "1") {
                alert("Запись добавлена");
                refreshMainTable();
            } else {
                alert("Ошибка в заполнении");
                return;
            }

            let newEquipmentName = select_type_oborudovanie.options[select_type_oborudovanie.selectedIndex].text;
            //console.log("Добавленное оборудование:", newEquipmentName);

            // Убедимся, что таблица обновилась
            setTimeout(function () {
                let searchValue = newEquipmentName.trim().toLowerCase();
                let matchingIndex = -1; // Начальное значение для индекса

                // Используем метод rows().data() для получения всех данных
                let allData = $('#infoOb' + selectedOrg).DataTable().rows().data();

                // Перебираем строки данных в обратном порядке
                for (let i = allData.length - 1; i >= 0; i--) {
                    let equipmentName = allData[i][0].trim().toLowerCase(); // Получаем название оборудования из первой ячейки

                    //console.log(`Сравниваем: '${equipmentName}' с '${searchValue}'`);

                    // Если текст ячейки совпадает с названием оборудования
                    if (equipmentName.includes(searchValue)) {
                        matchingIndex = i; // Сохраняем индекс найденной строки
                        break; // Прерываем цикл, так как мы нашли последнюю запись
                    }
                }

                if (matchingIndex !== -1) {
                    //console.log("Последняя запись с названием 'УЗИ Аппараты' найдена на индексе:", matchingIndex);

                    // Теперь находим страницу для перехода
                    let table = $('#infoOb' + selectedOrg).DataTable();
                    let pageSize = table.page.len();
                    let newPage = Math.floor(matchingIndex / pageSize);

                    // Переходим на нужную страницу
                    table.page(newPage).draw(false);

                    // Прокручиваем к новой строке
                    let newRow = $('#infoOb' + selectedOrg).find('tr').eq(matchingIndex + 1); // +1 для учета заголовка
                }

            }, 200); // Небольшая задержка, чтобы убедиться, что таблица обновилась
        },
        error: function (xhr, status, error) {
            console.error("Ошибка при добавлении записи: " + error);
        }
    });
}


function chckReg(el) {
    if (el.checked) {
        $('#filterSerialNumber').prop('disabled', true);
        $('#model_name').prop('disabled', false);
    } else {
        $('#filterSerialNumber').prop('disabled', false);
        $('#model_name').prop('disabled', true);
    }
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
    let data = {
        equipment: equipmentFilter,
        id_uz: selectedOrg,
        year: yearFilter,
        datePostavki: datePostavkiFilter,
        dateRelease: dateReleaseFilter,
        service: serviceFilter,
        status: statusFilter === "Все" ? "" : statusFilter,
        id_obl: oblId
    };

    if (selectedEquipmentType) {
        data.id_type_oborudovanie = selectedEquipmentType;

    }

    if (selectedOrg > 0) {
        $.ajax({
            type: "POST",
            url: "/app/ajax/filterGetData.php",
            data: data,
            success: function (response) {
                $('#infoOb' + selectedOrg).DataTable().destroy();
                $("#infoOb" + selectedOrg).html(response);
                $('#infoOb' + selectedOrg).DataTable();

            },
            error: function (xhr, status, error) {
                console.error("Ошибка при выполнении запроса: " + error);
            }
        });
    } else {
        console.log(oblId + "oblast");
        $.ajax({
            type: "POST",
            url: "/app/ajax/filterGetDataNoOrg.php",
            data: data,
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


function filterS(event, id) {
    let filetS = event.target;
    let filteredDiv = filetS.nextElementSibling;
    if (filteredDiv.classList.contains("hidden")) {
        filteredDiv.classList.remove("hidden");
    } else {
        filteredDiv.classList.add("hidden");
    }
    let arrServices = Array.from(filteredDiv.children).map(function (event) {
        return {data_id: event.getAttribute('data-id'), text: event.innerText};
    });
    filetS.addEventListener("input", function (event) {
        let sortedArr = arrServices.filter((item) => {
            return item.text.toLowerCase().includes(event.target.value.toLowerCase());
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
        if (filetS.value == "") {
            if (id == 2) {
                selectedPostavschikId = 0;
                filetS.setAttribute('data-id', selectedPostavschikId);

            } else {
                selectedServiceId = 0;
                filetS.setAttribute('data-id', selectedServiceId);

            }
            if (!filteredDiv.classList.contains("hidden")) {
                filteredDiv.classList.add("hidden");
            }
        } else {
            if (filteredDiv.classList.contains("hidden")) {
                filteredDiv.classList.remove("hidden");
            }
        }


    });
}


function setServiceman(event) {
    $("#filterServicemans").val(event.target.innerText);
    selectedServiceId = event.target.getAttribute('data-id');
    event.target.parentElement.classList.add('hidden');
}

function setPostavschik(event) {
    $("#filterPostavschik").val(event.target.innerText);
    selectedPostavschikId = event.target.getAttribute('data-id');
}

function showModalAddOborudovanieUnspecified() {
    document.getElementById('edit_cost').value = null;
    document.getElementById('edit_model').value = null;
    document.getElementById('edit_contract').value = null;
    document.getElementById('edit_date_get_oborud').value = null;
    document.getElementById('edit_date_srok_vvoda').value = null;
    document.getElementById('edit_reasons').value = null;
    selectedServiceId = null;
    selectedPostavschikId = null;
    document.getElementById('filterServicemans').value = null;


    $('#editBtnOb').hide();
    $('#addBtnOb').show();
    $('#editOborudovanieModal').modal('show');
    $('#editOborudovanieModal .modal-title').text("Добавление оборудования");
}

function addOborudovanieUnspecified() {
    let nowHref = location.href;
    if (selectedServiceId === 0) {
        alert("Выберите сервисную организацию из списка!");
        return;
    }
    if (selectedPostavschikId === 0) {
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
            var trimmedData = data.trim();
            if (trimmedData === "1") {
                alert("Оборудование добавлено!");
                location.reload();
            } else {
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

    if(right_section.hasClass("viehal"))
        right_section.removeClass("viehal");
}

function exportTableToExcelAddedOb(tableID, filename = '') {
    // Получаем таблицу
    var table = document.getElementById(tableID);

    // Копируем таблицу, исключая последний столбец
    var clonedTable = table.cloneNode(true);

    // Удаляем последний столбец из каждой строки таблицы
    var rows = clonedTable.rows;
    for (var i = 0; i < rows.length; i++) {
        if (rows[i].cells.length > 1) {
            rows[i].deleteCell(-1); // Удаляет последний столбец
        }
    }
    var workbook = XLSX.utils.table_to_book(clonedTable, {sheet: "Sheet1"});

    // Устанавливаем имя файла
    filename = filename ? filename + '.xlsx' : 'table_export.xlsx';

    const worksheet = workbook.Sheets['Sheet1'];
    const range = XLSX.utils.decode_range(worksheet['!ref']); // Получаем диапазон ячеек

    // Устанавливаем ширину для каждой колонки
    worksheet['!cols'] = [];
    for (let col = range.s.c; col <= range.e.c; col++) {
        const maxWidth = Array.from({length: range.e.r + 1}, (_, row) => {
            const cell = worksheet[XLSX.utils.encode_cell({c: col, r: row})];
            return cell ? cell.v.toString().length : 0; // Получаем длину значения ячейки
        }).reduce((max, width) => Math.max(max, width), 0); // Находим максимальную ширину

        worksheet['!cols'].push({wch: maxWidth + 2}); // Добавляем 2 для небольшого отступа
    }
    // Генерируем Excel-файл и сохраняем его
    XLSX.writeFile(workbook, filename);
}

function editNotInstallOborudovanie(idOborudovanie) {
    event.stopPropagation();
    editedOborudovanie = idOborudovanie;
    $.ajax({
        url: '/app/ajax/getSingleNotInstallOborudovanie.php',
        type: 'GET',
        data: {id_oborudovanie: idOborudovanie},
        dataType: 'json',
        success: function (data) {
            $('#editBtnOb').show();
            $('#addBtnOb').hide();
            $('#yearError').hide();
            $('#editOborudovanieModal').modal('show');
            $('#editOborudovanieModal .modal-title').text("Изменение неустановленного оборудования");
            let select_type_oborudovanie = document.getElementById("select_type_oborudovanie");
            select_type_oborudovanie.options.forEach(option => {
                if (option.value === data.id_type_oborudovanie) {
                    option.selected = true;
                }
            });
            document.getElementById('edit_model').value = data.model_prozvoditel;
            document.getElementById('edit_cost').value = data.cost;
            document.getElementById('edit_contract').value = data.num_and_date;
            if (data.service_organization == 0) {
                document.getElementById('filterServicemans').value = "";
            }

            let select_serviceman = document.getElementById("filterServicemans");
            let filteredDiv = select_serviceman.nextElementSibling.children;////
            filteredDiv.forEach(item => {
                if (item.getAttribute('data-id') == data.service_organization) {

                    select_serviceman.setAttribute('data-id', item.getAttribute('data-id'))
                    select_serviceman.value = item.innerText;
                }
            });
            console.log(select_serviceman.value);
            if (select_serviceman.value == 0) {
                let select_servicemans = document.getElementById("filterServicemans");
                globalserviceman = select_servicemans.getAttribute('data-id');
                globalserviceman = 0;
            }


            if (data.service_postavschik == 0) {
                document.getElementById('filterPostavschik').value = "";
            }

            let select_postavschik = document.getElementById("filterPostavschik");
            let filteredDivPostavschik = select_postavschik.nextElementSibling.children;////
            filteredDiv.forEach(item => {
                if (item.getAttribute('data-id') == data.service_postavschik) {

                    select_postavschik.setAttribute('data-id', item.getAttribute('data-id'))
                    select_postavschik.value = item.innerText;
                }
            });
            console.log(select_postavschik.value);
            if (select_postavschik.value == 0) {
                let select_postav = document.getElementById("filterServicemans");
                globalpostavschick = select_postav.getAttribute('data-id');
                globalpostavschick = 0;
            }

            document.getElementById('edit_date_get_oborud').value = data.date_get_sklad;
            document.getElementById('edit_date_srok_vvoda').value = data.date_norm_srok_vvoda;
            document.getElementById('edit_reasons').value = data.reasons;
        }
    });
}


function saveNotInstallEditedOborudovanie() {
    let select_type_oborudovanie = document.getElementById("select_type_oborudovanie");
    let edit_model = document.getElementById('edit_model').value;
    let edit_cost = document.getElementById('edit_cost').value;
    let edit_contract = document.getElementById('edit_contract').value;
    let select_servicemans = document.getElementById("filterServicemans");
    let select_postavschik = document.getElementById("filterPostavschik");
    let edit_date_get_oborud = document.getElementById('edit_date_get_oborud').value;
    let edit_date_srok_vvoda = document.getElementById('edit_date_srok_vvoda').value;
    let edit_reasons = document.getElementById('edit_reasons').value;

    let sto = select_type_oborudovanie.options[select_type_oborudovanie.selectedIndex].value;
    let so = select_servicemans.getAttribute('data-id');
    let sp = select_postavschik.getAttribute('data-id');
    if (selectedServiceId) {

        so = selectedServiceId;
    } else {
        if (select_servicemans.value == "") {
            so = 0;
        }
    }

    if (selectedPostavschikId) {

        sp = selectedPostavschikId;
    } else {
        if (select_postavschik.value == "") {
            sp = 0;
        }
    }
    $.ajax({
        url: '/app/ajax/updateNotInstallOborudovanie.php',
        type: 'POST',
        data: {
            id_oborudovanie: editedOborudovanie,
            id_type_oborudovanie: select_type_oborudovanie.options[select_type_oborudovanie.selectedIndex].value,
            edit_model: edit_model,
            edit_cost: edit_cost,
            edit_contract: edit_contract,
            service_organization: so,
            service_postavschik: sp,
            edit_date_get_oborud: edit_date_get_oborud,
            edit_date_srok_vvoda: edit_date_srok_vvoda,
            edit_reasons: edit_reasons
        },
        success: function (data) {
            if (data == "1") {
                alert("Запись изменена");
                location.reload();
            } else {
                alert("Ошибка в заполнении");
            }

        }
    });
}


function duplicateOborudovanie(id) {
    if (confirm("Вы уверены, что хотите дублировать это оборудование?")) {
        $.ajax({
            url: '/app/ajax/duplicateOborudovanie.php',
            type: 'POST',
            data: {id: id},
            success: function (response) {
                if (response.success) {
                    alert("Оборудование успешно дублировано!");
                    refreshMainTable();
                } else {
                    alert("Ошибка при дублировании оборудования: " + response.message);
                }
            },
            error: function () {
                alert("Произошла ошибка при отправке запроса.");
            }
        });
    }
}


function debounce(func, delay) {
    let timeout;
    return function (...args) {
        const context = this;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), delay);
    };
}

function filterSNumber(event) {
    let filetS = event.target;
    let filteredDiv = filetS.nextElementSibling;

    // Показать или скрыть список при фокусе

    let serialNumberErrorLess = document.getElementById("serialNumberErrorLess");


    const filterItems = debounce(function () {
        const inputValue = filetS.value.toLowerCase().trim();
        filteredDiv.innerHTML = ""; // очищаем содержимое
        let model_name = document.getElementById("model_name");

        if(inputValue.length > 7) {
            serialNumberErrorLess.style = "color: red; display: none;";

            // Индикатор загрузки
            const loadingIndicator = document.createElement('div');
            loadingIndicator.innerText = "Идет фильтрация...";
            loadingIndicator.className = "loading-indicator";
            filteredDiv.appendChild(loadingIndicator);

            if (inputValue === "") {
                filteredDiv.classList.add("hidden");
                model_name.value = "";
                return;
            }


            let sortedArr1 = JsonReestr.filter((item) => {
                return item['Рег_номер_товара'].toLowerCase().includes(inputValue);
            });

            // Удаляем индикатор загрузки
            filteredDiv.removeChild(loadingIndicator);

            if (sortedArr1.length === 0) {
                filteredDiv.classList.add("hidden");
                return;
            } else {
                filteredDiv.classList.remove("hidden");
            }

            sortedArr1.forEach(item => {
                let divEl = document.createElement('div');
                divEl.style.cursor = "pointer";
                divEl.className = "hover-reg-num";
                divEl.setAttribute("data-id", item['N_п_п']);
                divEl.setAttribute("data-reg-num", item['Рег_номер_товара']);
                divEl.innerHTML = `${item['Рег_номер_товара']}<br>${item['Наименование']}`;
                divEl.onclick = (event) => {
                    filetS.value = event.target.getAttribute('data-reg-num');
                    filteredDiv.classList.add("hidden");
                    filetS.setAttribute('data-id', event.target.getAttribute('data-id'));
                    selectedItemFromReestr = item;
                    model_name.value = item['Наименование'];
                }
                filteredDiv.appendChild(divEl);
            });
        }else{
            serialNumberErrorLess.style = "color: red; display: block;";
            filteredDiv.classList.add("hidden");
        }
    }, 300); // Задержка 300 мс

    filetS.addEventListener("input", filterItems);
}

let btnExportExc = document.getElementById('btnExportExcel');
if(btnExportExc){
    btnExportExc.onclick = (event) => {
        exportTableToExcelAddedOb('infoOb' + event.target.getAttribute('data-id'), 'Отчет_организация_' + event.target.getAttribute('data-id'));

    }
}

let btnAddOborudovanie = document.getElementById('btnAddOborudovanie');
if(btnAddOborudovanie){
    btnAddOborudovanie.onclick = (event) => {
        $('#editBtnOb').hide();
        $('#addBtnOb').show();
        $('#yearError').hide();
        $('#editOborudovanieModal').modal('show');
        document.getElementById('addBtnOb').onclick = saveEditedOborudovanie1;
        $('#editOborudovanieModal .modal-title').text("Добавление оборудования");
        let select_type_oborudovanie = document.getElementById("select_type_oborudovanie");
        select_type_oborudovanie.options[0].selected = true;
        // document.getElementById('edit_cost').value = "";
        document.getElementById('edit_date_create').value = "";
        document.getElementById('edit_date_release').value = "";
        // document.getElementById('edit_model_prozvoditel').value = "";
        document.getElementById('filterSerialNumber').value = "";
        document.getElementById('zavod_nomer').value = "";
        document.getElementById('edit_date_postavki').value = "";
        document.getElementById('edit_date_postavki').value = "";
        document.getElementById('filterServicemans').value = "";
        // document.getElementById('select_serviceman').value = "";
        document.getElementById('edit_date_last_TO').value = "";


        let select_status = document.getElementById("select_status");
        select_status.options[0].selected = true;
    }
}



function saveAddedOborudovanie1(iduz) {
    let select_type_oborudovanie = document.getElementById("select_type_oborudovanie");
    let select_status = document.getElementById("select_status");
    let id_from_reestr = document.getElementById('filterSerialNumber').getAttribute('data-id');
    let serial_number = document.getElementById('filterSerialNumber').value;
    let zavod_nomer = document.getElementById('zavod_nomer').value;
    let model_name = document.getElementById('model_name').value;

    if (serial_number.trim() === "" && !$('#isNotReg').prop("checked")) {
        $('#serialNumberError').show();
        console.log("Ошибка: Регистрационный номер оборудования для заполнения");
        $('#editOborudovanieModal').animate({
            scrollTop: $('#edit_serial_number').offset().top - $('#editOborudovanieModal').offset().top + $('#editOborudovanieModal').scrollTop() - 150
        }, 500);
        return false;
    } else if (model_name.trim() === "" && $('#isNotReg').prop("checked")) {
        $('#modelError').show();
        console.log("Ошибка: Регистрационный номер оборудования для заполнения");
        $('#editOborudovanieModal').animate({
            scrollTop: $('#edit_serial_number').offset().top - $('#editOborudovanieModal').offset().top + $('#editOborudovanieModal').scrollTop() - 150
        }, 500);
        return false;
    } else if (model_name.trim() === ""){
        $('#modelError').show();
        $('#editOborudovanieModal').animate({
            scrollTop: $('#edit_serial_number').offset().top - $('#editOborudovanieModal').offset().top + $('#editOborudovanieModal').scrollTop() - 150
        }, 500);
    }else {
        $('#serialNumberError').hide();
        $('#modelError').hide();

    }


    const yearValue = $('#edit_date_create').val();


    if (!(yearValue === "") && !/^\d{4}$/.test(yearValue)) {
        $('#yearError').show();
        return false;
    }

    $('#yearError').hide();


    $.ajax({
        url: '/app/ajax/insertOborudovanie.php',
        type: 'POST',
        data: {
            id_type_oborudovanie: select_type_oborudovanie.options[select_type_oborudovanie.selectedIndex].value,
            date_create: document.getElementById('edit_date_create').value || null,
            date_postavki: document.getElementById('edit_date_postavki').value || null,
            date_release: document.getElementById('edit_date_release').value || null,
            model_prozvoditel: $('#isNotReg').prop('checked') ? $('#model_name').val() : selectedItemFromReestr['Наименование'] + selectedItemFromReestr['Производитель'],
            serial_number: $('#isNotReg').prop('checked') ? "000" : selectedItemFromReestr['Рег_номер_товара'],
            zavod_nomer: zavod_nomer,
            id_from_reestr: $('#isNotReg').prop('checked') ? 0 : id_from_reestr,
            service_organization: selectedServiceId || null,
            date_last_TO: document.getElementById('edit_date_last_TO').value || null,
            status: select_status.options[select_status.selectedIndex].value,
            id_org: iduz
        },
        success: function (data) {
            if (data === "1") {
                alert("Запись добавлена");
                location.reload();
            } else {
                alert("Ошибка в заполнении");
                return;
            }

            let newEquipmentName = select_type_oborudovanie.options[select_type_oborudovanie.selectedIndex].text;
            //console.log("Добавленное оборудование:", newEquipmentName);

            // Убедимся, что таблица обновилась
            setTimeout(function () {
                let searchValue = newEquipmentName.trim().toLowerCase();
                let matchingIndex = -1; // Начальное значение для индекса

                // Используем метод rows().data() для получения всех данных
                let allData = $('#infoOb' + selectedOrg).DataTable().rows().data();

                // Перебираем строки данных в обратном порядке
                for (let i = allData.length - 1; i >= 0; i--) {
                    let equipmentName = allData[i][0].trim().toLowerCase(); // Получаем название оборудования из первой ячейки

                    //console.log(`Сравниваем: '${equipmentName}' с '${searchValue}'`);

                    // Если текст ячейки совпадает с названием оборудования
                    if (equipmentName.includes(searchValue)) {
                        matchingIndex = i; // Сохраняем индекс найденной строки
                        break; // Прерываем цикл, так как мы нашли последнюю запись
                    }
                }

                if (matchingIndex !== -1) {
                    //console.log("Последняя запись с названием 'УЗИ Аппараты' найдена на индексе:", matchingIndex);

                    // Теперь находим страницу для перехода
                    let table = $('#infoOb' + selectedOrg).DataTable();
                    let pageSize = table.page.len();
                    let newPage = Math.floor(matchingIndex / pageSize);

                    // Переходим на нужную страницу
                    table.page(newPage).draw(false);

                    // Прокручиваем к новой строке
                    let newRow = $('#infoOb' + selectedOrg).find('tr').eq(matchingIndex + 1); // +1 для учета заголовка
                }

            }, 200); // Небольшая задержка, чтобы убедиться, что таблица обновилась
        },
        error: function (xhr, status, error) {
            console.error("Ошибка при добавлении записи: " + error);
        }
    });
}

function filterTable1(iduz) {
    let equipmentFilter = $("#filterEquipment").val();
    let yearFilter = $("#filterYear").val();
    let datePostavkiFilter = $("#filterDatePostavki").val();
    let dateReleaseFilter = $("#filterDateRelease").val();
    let serviceFilter = $("#filterService").val();
    let statusFilter = $("#filterStatus").val();
    let data = {
        equipment: equipmentFilter,
        id_uz: iduz,
        year: yearFilter,
        datePostavki: datePostavkiFilter,
        dateRelease: dateReleaseFilter,
        service: serviceFilter,
        status: statusFilter === "Все" ? "" : statusFilter,
        id_obl: oblId
    };

    if (selectedEquipmentType) {
        data.id_type_oborudovanie = selectedEquipmentType;

    }

    if (iduz > 0) {
        $.ajax({
            type: "POST",
            url: "/app/ajax/filterGetData.php",
            data: data,
            success: function (response) {
                $('#infoOb' + iduz).DataTable().destroy();
                $("#infoOb" + iduz).html(response);
                $('#infoOb' + iduz).DataTable();

            },
            error: function (xhr, status, error) {
                console.error("Ошибка при выполнении запроса: " + error);
            }
        });
    } else {
        console.log(oblId + "oblast");
        $.ajax({
            type: "POST",
            url: "/app/ajax/filterGetDataNoOrg.php",
            data: data,
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


function saveEditedOborudovanie1(){


    let modelNAZVANIE = document.getElementById('model_name').value.trim().toLowerCase();
    let poisk = JsonReestr.find((item) =>
        item['Наименование'] && item['Наименование'].toLowerCase().includes(modelNAZVANIE)
    );

    console.log(poisk);
    console.log(modelNAZVANIE);

    let modelErrorSpan = document.getElementById('modelError');
    if (poisk) {
        let modelErrorSpan = document.getElementById('modelError');
        modelErrorSpan.style.display = 'block';
        modelErrorSpan.textContent = 'Найдено в реестре. Исправьте ввод перед сохранением.';
        modelErrorSpan.style.color = 'red';
        return;
    } else {
        let modelErrorSpan = document.getElementById('modelError');
        modelErrorSpan.style.display = 'none';
    }
    let nowHref = location.href;
    let select_type_oborudovanie = document.getElementById("select_type_oborudovanie");
    let select_servicemans = document.getElementById("filterServicemans");
    let select_status = document.getElementById("select_status");
    let sto = select_type_oborudovanie.options[select_type_oborudovanie.selectedIndex].value;
    let dcr = document.getElementById('edit_date_create').value;
    let dp = document.getElementById('edit_date_postavki').value;
    let dr = document.getElementById('edit_date_release').value;
    let id_from_reestr = document.getElementById('filterSerialNumber').getAttribute('data-id');
    let serial_number = document.getElementById('filterSerialNumber').value;
    let zavod_nomer = document.getElementById('zavod_nomer').value;
    let so = select_servicemans.getAttribute('data-id');

    console.log(id_from_reestr);
    if (id_from_reestr == null) {
        alert('Не выбран регистрационный номер');
    } else {
        if (selectedServiceId) {
            so = selectedServiceId;
        } else {
            if (select_servicemans.value == "") {
                so = 0;
            }
        }


        let model_name = document.getElementById('model_name').value;

        if (serial_number.trim() === "" && !$('#isNotReg').prop("checked")) {
            $('#serialNumberError').show();
            console.log("Ошибка: Регистрационный номер оборудования для заполнения");
            $('#editOborudovanieModal').animate({
                scrollTop: $('#edit_serial_number').offset().top - $('#editOborudovanieModal').offset().top + $('#editOborudovanieModal').scrollTop() - 150
            }, 500);
            return false;
        } else if (model_name.trim() === "" && $('#isNotReg').prop("checked")) {
            $('#modelError').show();
            console.log("Ошибка: Регистрационный номер оборудования для заполнения");
            $('#editOborudovanieModal').animate({
                scrollTop: $('#edit_serial_number').offset().top - $('#editOborudovanieModal').offset().top + $('#editOborudovanieModal').scrollTop() - 150
            }, 500);
            return false;
        } else {
            $('#serialNumberError').hide();
            $('#modelError').hide();

        }


        const yearValue = $('#edit_date_create').val();

        // Проверяем, является ли год 4-значным числом
        if (!(yearValue === "") && !/^\d{4}$/.test(yearValue)) {
            $('#yearError').show();  // Показываем сообщение об ошибке
            console.log("Ошибка: значение пустое или не 4 цифры");
            $('#editOborudovanieModal').animate({
                scrollTop: $('#edit_date_create').offset().top - $('#editOborudovanieModal').offset().top + $('#editOborudovanieModal').scrollTop() - 150
            }, 500);
            return false;  // Останавливаем выполнение функции, предотвращаем сохранение
        }

        $('#yearError').hide();  // Скрываем сообщение об ошибке, если данные корректны

        $.ajax({
            url: '/app/ajax/updateOborudovanie.php',
            type: 'POST',
            data: {
                id_oborudovanie: editedOborudovanie,
                id_type_oborudovanie: sto,
                date_create: dcr,
                date_postavki: dp,
                date_release: dr,
                model_prozvoditel: $('#isNotReg').prop('checked') ? $('#model_name').val() : selectedItemFromReestr['Наименование'] + selectedItemFromReestr['Производитель'],
                serial_number: $('#isNotReg').prop('checked') ? "000" : selectedItemFromReestr['Рег_номер_товара'],
                zavod_nomer: zavod_nomer,
                id_from_reestr: $('#isNotReg').prop('checked') ? 0 : id_from_reestr,
                service_organization: so,
                date_last_TO: document.getElementById('edit_date_last_TO').value,
                status: select_status.options[select_status.selectedIndex].value
            },
            success: function (data) {
                if (data == "1") {
                    alert("Запись изменена");
                    location.reload();
                } else {
                    alert("Ошибка в заполнении");
                }

                let newEquipmentName = select_type_oborudovanie.options[select_type_oborudovanie.selectedIndex].text;
                //console.log("Добавленное оборудование:", newEquipmentName);

                // Убедимся, что таблица обновилась
                setTimeout(function () {
                    let searchValue = newEquipmentName.trim().toLowerCase();
                    let matchingIndex = -1; // Начальное значение для индекса

                    // Используем метод rows().data() для получения всех данных
                    let allData = $('#infoOb' + selectedOrg).DataTable().rows().data();

                    // Перебираем строки данных в обратном порядке
                    for (let i = allData.length - 1; i >= 0; i--) {
                        let equipmentName = allData[i][0].trim().toLowerCase(); // Получаем название оборудования из первой ячейки

                        //console.log(`Сравниваем: '${equipmentName}' с '${searchValue}'`);

                        // Если текст ячейки совпадает с названием оборудования
                        if (equipmentName.includes(searchValue)) {
                            matchingIndex = i; // Сохраняем индекс найденной строки
                            break; // Прерываем цикл, так как мы нашли последнюю запись
                        }
                    }

                    if (matchingIndex !== -1) {
                        //console.log("Последняя запись с названием 'УЗИ Аппараты' найдена на индексе:", matchingIndex);

                        // Теперь находим страницу для перехода
                        let table = $('#infoOb' + selectedOrg).DataTable();
                        let pageSize = table.page.len();
                        let newPage = Math.floor(matchingIndex / pageSize);

                        // Переходим на нужную страницу
                        table.page(newPage).draw(false);

                        // Прокручиваем к новой строке
                        let newRow = $('#infoOb' + selectedOrg).find('tr').eq(matchingIndex + 1); // +1 для учета заголовка
                    }

                }, 200); // Небольшая задержка, чтобы убедиться, что таблица обновилась
            },
            error: function (xhr, status, error) {
                console.error("Ошибка при добавлении записи: " + error);
            }
        });
    }
}