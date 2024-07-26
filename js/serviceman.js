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
    let btnAddServiceman = document.getElementById("btnAddServiceman");
    if(btnAddServiceman)
        btnAddServiceman.remove();
    btnAddServiceman = document.createElement("button");
    btnAddServiceman.innerHTML = "Добавить сервисанта";
    btnAddServiceman.id = "btnAddServiceman";
    btnAddServiceman.className = "btn btn-primary";
    container_fluid.insertAdjacentElement("afterbegin", btnAddServiceman);

    btnAddServiceman.onclick = () => {
        $('#editBtnOb').hide();
        $('#addBtnOb').show();
        $('#editOborudovanieModal').modal('show');
        $('#editOborudovanieModal .modal-title').text("Добавление сервисанта");


    }

}