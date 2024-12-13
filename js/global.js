var currentUrl = window.location.search;


if (currentUrl == "?main" || currentUrl == "") {
    let mainMenu = document.querySelector('[href="index.php?main"]');
    mainMenu.classList.add('active');
} else if (currentUrl == "?oborud" || currentUrl == "?grodnoobl" || currentUrl == "?minsk" || currentUrl == "?mogilevobl" ||
    currentUrl == "?minskobl" || currentUrl == "?brestobl" || currentUrl == "?gomelobl" || currentUrl == "?vitebskobl") {
    let oborMenu = document.querySelector('[href="index.php?oborud"]');
    oborMenu.classList.add('active');
} else if (currentUrl == "/index.php?servicemans") {
    let serviceMenu = document.querySelector('[href="index.php?servicemans"]');
    serviceMenu.classList.add('active');
}

// function getUzs(id_obl) {
//
//     $.ajax({
//         url: "app/pages/obls/minsk.php",
//         method: "GET",
//         data: {id_obl: id_obl}
//     }).then(response => {
//         let bodywrap = document.getElementById("bodywrap");
//         bodywrap.innerHTML = response;
//         if ($("#infoObAll").length) {
//             try {
//                 $("#infoObAll").DataTable().destroy();
//             } catch (e) {
//                 console.log(e);
//             }
//         }
//         $("#infoObAll").DataTable();
//
//
//     })
//
// }

function getUzs(id_obl, id_type) {
    oblId=id_obl;
    document.getElementById("preloader").style.display = 'flex';
    $.ajax({
        url: "app/pages/obls/minsk.php",
        method: "GET",
        data: {id_obl: id_obl, id_type: id_type}
    }).then(response => {
        let bodywrap = document.getElementById("bodywrap");
        bodywrap.innerHTML = response;
        document.getElementById("preloader").style.display = 'none';
        if ($("#infoObAll").length) {
            try {
                $("#infoObAll").DataTable().destroy();
            } catch (e) {
                console.log(e);
            }
        }
        try {
            if (id_type)
                $('.vid_oborudovaniya').each(function () {
                    $(this).addClass('hidden')
                })
            else {
                $('.vid_oborudovaniya').each(function () {
                    $(this).removeClass('hidden')
                })

            }
            $("#infoObAll").DataTable();
        } catch (e) {
            console.log(e);
        }

    })

}



function getUzsDiagram(id_obl, status) {
    oblId=id_obl;
    $.ajax({
        url: "app/pages/obls/minsk.php",
        method: "GET",
        data: {id_obl: id_obl, status: status}
    }).then(response => {
        let bodywrap = document.getElementById("bodywrap");
        bodywrap.innerHTML = response;
        if ($("#infoObAll").length) {
            try {
                $("#infoObAll").DataTable().destroy();
            } catch (e) {
                console.log(e);
            }
        }
        try {
            if (status)
                $('.vid_oborudovaniya').each(function () {
                    $(this).addClass('hidden')
                })
            else {
                $('.vid_oborudovaniya').each(function () {
                    $(this).removeClass('hidden')
                })

            }
            $("#infoObAll").DataTable();
        } catch (e) {
            console.log(e);
        }

    })

}


$(".region").on("click", "h3", function() {
    let regionNumber = $(this).parent().data("region");
    getUzs(regionNumber);
});


if(currentUrl == '?oborud'){
    $('#menu_oborud').addClass('submenu-indicator-minus');
    $('#menu_oborud').addClass('active');
    $('#menu_oborud').children().eq(0).addClass('submenu-indicator-minus');
    $('#menu_oborud').children().eq(1).css('display','block');
    $('#menu_ustanovl').addClass('active');
    $('#menu_ustanovl').children().css('background-color','#98d4d4');
}

function filterFunction() {
    const input = document.getElementById("search");
    const filter = input.value.toLowerCase();
    const select = document.getElementById("select_serviceman");
    const options = select.getElementsByTagName("option");

    for (let i = 0; i < options.length; i++) {
        const option = options[i];
        if (option.value === "0") {
            continue;
        }
        const txtValue = option.textContent || option.innerText;
        option.style.display = txtValue.toLowerCase().indexOf(filter) > -1 ? "" : "none";
    }
}
$(document).ready(function() {
    $('#saveService').click(function() {
        let serviceName = $('#serviceName').val();
        $.ajax({
            url: '/app/ajax/saveService.php',
            type: 'POST',
            data: { name: serviceName },
            success: function(response) {
                console.log (response)
                    alert('Сервисант успешно добавлен!');
                    $('#addServiceModal').modal('hide');
                }
        });
    });

});


function showModalAddZapchast(){
    document.getElementById('filter_uz_from').value = null;
    document.getElementById('filter_serial_number').value  = null;
    document.getElementById('edit_name_zapchast').value  = null;
    document.getElementById('edit_photo').value  = null;
    document.getElementById('edit_akt').value  = null;
    document.getElementById('edit_kat_nomer').value  = null;
    document.getElementById('edit_mark_zapchast').value  = null;
    document.getElementById('edit_cost').value  = null;
    document.getElementById('filter_uz_from').value  = null;


    $('#editBtnZap').hide();
    $('#addBtnZap').show();
    $('#editZapchastModal').modal('show');
    $('#editZapchastModal .modal-title').text("Добавление записи");
}