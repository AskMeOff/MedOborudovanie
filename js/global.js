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

function getUzs(id_obl) {
    console.log('xyu')

    $.ajax({
        url: "app/pages/obls/minsk.php",
        method: "GET",
        data: {id_obl: id_obl}
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
        $("#infoObAll").DataTable();


    })

}

function getUzs(id_obl, id_type) {
    $.ajax({
        url: "app/pages/obls/minsk.php",
        method: "GET",
        data: {id_obl: id_obl, id_type: id_type}
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

$(".region").on("click", function () {
    var regionNumber = $(this).data("region");
    getUzs(regionNumber);
    $("#sidebarnav").children().removeClass("selected active");
    $("#sidebarnav").children().children().removeClass("active");
    $("#sidebarnav").children().eq(1).addClass("selected active");
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
