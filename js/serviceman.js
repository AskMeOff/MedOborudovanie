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
    selectedOrg = idServiceman;
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
    showTable('infoservice' + idServiceman);

    let container_fluid = document.getElementById("container_fluid");
    container_fluid.insertAdjacentElement("afterbegin", btnAddServiceman);


}
function editService(idOborudovanie) {
    event.stopPropagation();
    editedOborudovanie = idOborudovanie;
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
            document.getElementById('edit_name_org').value = data.uz;
            document.getElementById('edit_type_obor').value = data.date_create;
            document.getElementById('edit_date_dogovor_service').value = data.date_postavki;
            document.getElementById('edit_srok_dogovor_service').value = data.date_release;
            document.getElementById('edit_summa_dogovor_service').value = data.service_organization;
            document.getElementById('edit_type_work_dogovor_service').value = data.date_last_TO;


            let select_status = document.getElementById("select_status");
            select_status.options.forEach(option => {
                if (option.value === data['status']) {
                    option.selected = true;
                }
            });
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