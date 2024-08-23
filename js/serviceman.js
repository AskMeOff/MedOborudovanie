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