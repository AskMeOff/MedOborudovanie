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
            }catch (e) {
                console.log(e);
            }
        }
        try {
            $("#infoObAll").DataTable();
        }catch (e) {
            console.log(e);
        }


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
            }catch (e) {
                console.log(e);
            }
        }
        try {
            $("#infoObAll").DataTable();
        }catch (e) {
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



