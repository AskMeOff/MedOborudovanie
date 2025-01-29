$(document).ready(function () {
    if ($("#infoObAll").length) {
        $("#infoObAll").DataTable().destroy();
    }
    $("#infoObAll").DataTable({
        "order": [[0, "asc"]],
        "pageLength": 20
    });


});


function modalAddUser() {
    $("#uz_name").val("");
    $("#uz_unp").val("");
    $("#uz_email").val("");
    $("#login_org").val("");
    $("#password_org").val("");
    $("#dogovor").val("");
    $("#saveUserBtn").show();
    $("#saveEditedUserBtn").hide();
    $("#addUserModal").modal("show");
}

function changeActive(el) {

    $.ajax({
        url: "app/ajax/changeActive.php",
        method: "POST",
        data: {id_user: el.getAttribute("data-id"), active: el.checked}
    }).then((response) => {

    })

}

let selected_user;

function editPodUser(el, id_user) {
    let par = el.parentElement;
    let par1 = par.parentElement;
    let name = par1.children[1].innerText;
    let unp = par1.children[2].innerText;
    let email = par1.children[4].innerText;
    let login = par1.children[5].innerText;
    let password = par1.children[6].innerText;
    let dogovor = par1.children[7].innerText;
    let id_oblast = par1.children[3].getAttribute("data-id");
    selected_user = id_user;
    $("#uz_name").val(name);
    $("#uz_unp").val(unp);
    $("#uz_email").val(email);
    $("#login_org").val(login);
    $("#password_org").val(password);
    $("#dogovor").val(dogovor);

    $("#saveUserBtn").hide();
    $("#saveEditedUserBtn").show();
    $("#addUserModal").modal("show");
    $("#sel_obls").val(id_oblast);
}

function addUser(id_obl) {
    if ($("#uz_name").val() == "" || $("#login_org").val() == "" || $("#password_org").val() == "" || $("#uz_unp").val() == "" || $("#uz_email").val() == "") {
        alert("Не все поля заполнены!");
    } else {
        let formData = new FormData();
        formData.append("uz_name", $("#uz_name").val());
        formData.append("uz_unp", $("#uz_unp").val());
        formData.append("email", $("#uz_email").val());
        formData.append("login_org", $("#login_org").val());
        formData.append("password_org", $("#password_org").val());
        formData.append("dogovor", $("#dogovor").val());
        formData.append("id_obl", id_obl);
        formData.append("sel_obl", $("#sel_obls").val());
        formData.append("zayavka", $("#zayavka")[0].files[0]); // Добавляем файл

        // Отправляем AJAX-запрос
        $.ajax({
            url: "app/ajax/addUser.php",
            method: "POST",
            data: formData,
            processData: false, // Не обрабатывать данные
            contentType: false // Не устанавливать заголовок Content-Type
        }).then((response) => {
            if (response == "0") {
                alert("Пользователь с таким логином или наименованием уже существует.");
            } else {
                alert("Организация добавлена.");
                location.reload();
            }

        })
    }
}

function updateUser(id_user) {
    if ($("#uz_name").val() == "" || $("#login_org").val() == "" || $("#password_org").val() == "" || $("#uz_unp").val() == "" || $("#uz_email").val() == "") {
        alert("Не все поля заполнены!");
    } else {
        let formData = new FormData();
        formData.append("id_user", selected_user);
        formData.append("uz_name", $("#uz_name").val());
        formData.append("uz_unp", $("#uz_unp").val());
        formData.append("email", $("#uz_email").val());
        formData.append("login_org", $("#login_org").val());
        formData.append("password_org", $("#password_org").val());
        formData.append("dogovor", $("#dogovor").val());
        formData.append("id_obl", $("#sel_obls").val());
        formData.append("sel_obl", $("#sel_obls").val());
        formData.append("zayavka", $("#zayavka")[0].files[0]); // Добавляем файл

        // Отправляем AJAX-запрос
        $.ajax({
            url: "app/ajax/updateUser.php",
            method: "POST",
            data: formData,
            processData: false, // Не обрабатывать данные
            contentType: false // Не устанавливать заголовок Content-Type
        }).then((response) => {
            if (response == "0") {
                alert("Пользователь с таким логином или наименованием уже существует.");
            } else {
                alert("Организация изменена.");
                location.reload();
            }

        })
    }
}


function deletePodUser(id_user) {
    if (confirm("Вы уверены, что хотите удалить пользователя?")) {
        $.ajax({
            url: "app/ajax/deletePodUser.php",
            method: "GET",
            data: {id_user: id_user}
        }).done(function (response) {
            alert("Пользователь удален.");
            location.reload();
        });
    }
}

function filterZayavka(el) {
    var table = $("#infoObAll").DataTable();

    // Сохраняем состояние фильтра
    var filterEmpty = el.checked;

    if (filterEmpty) {
        // Устанавливаем количество строк на странице на "все"
        table.page.len(-1).draw();

        // Скрываем строки, где "Заявка" пуста
        table.rows().every(function () {
            var rowData = this.data();
            var isEmpty = rowData[8].trim() === ""; // Проверяем, пустая ли ячейка

            if (isEmpty) {
                $(this.node()).hide(); // Скрываем строки, где "Заявка" пуста
            }
        });
    } else {
        // Возвращаем количество строк на странице к стандартному значению (например, 10)
        table.page.len(10).draw(); // Установите нужное количество строк на странице

        // Показываем все строки
        table.rows().every(function () {
            $(this.node()).show(); // Показываем все строки
        });
    }

    // Обновляем отображение таблицы
    table.draw();

}

function filterNew(el) {
    $("#infoObAll").DataTable().destroy();

    let selectOblast = document.getElementById("selectOblast");

    selectOblast.selectedIndex = 0;
    var table = $("#infoObAll").DataTable();
    table.page.len(10).draw();
    // Сохраняем состояние фильтра
    var filterEmpty = el.checked;

    if (filterEmpty) {
        // Устанавливаем количество строк на странице на "все"
        table.page.len(-1).draw();

        // Скрываем строки, где "Заявка" пуста
        table.rows().every(function () {
            var tr = this.node();
            var dataId = $(tr).data("id"); // Проверяем, пустая ли ячейка

            if (dataId < 550) {
                $(tr).hide(); // Скрываем строки, где "Заявка" пуста
            }
            if (dataId === 570) {
                $(tr).hide(); // Скрываем строки, где "Заявка" пуста
            }
        });
    } else {
        // Возвращаем количество строк на странице к стандартному значению (например, 10)
        table.page.len(10).draw(); // Установите нужное количество строк на странице

        // Показываем все строки
        table.rows().every(function () {
            $(this.node()).show(); // Показываем все строки
        });
    }

    // Обновляем отображение таблицы
    table.draw();

}

function filterOblast(el) {
    var table = $("#infoObAll").DataTable();
    let selectedObl = el.options[el.selectedIndex].innerText;

    if (el.selectedIndex > 0) {
        // Устанавливаем количество строк на странице на "все"
        table.page.len(-1).draw();

        // Скрываем строки, где "Область" не соответствует выбранному значению и "Заявка" пуста
        table.rows().every(function () {
            var tr = this.node();
            var dataId = $(tr).data("id");
            var rowData = this.data();
            var oblastMatches = rowData[3].trim() === selectedObl; // Проверяем, соответствует ли область
            var isEmpty = rowData[8].trim() === ""; // Проверяем, пуста ли "Заявка"

            if (oblastMatches) {
                if (!isEmpty)
                    if (dataId > 549 && dataId !== 570)
                        $(this.node()).show(); // Скрываем строки, где "Область" не соответствует и "Заявка" пуста
                    else
                        $(this.node()).hide();
                else
                    $(this.node()).hide();
            } else {
                $(this.node()).hide(); // Показываем строки, которые соответствуют условию
            }
        });
    } else {
        // Возвращаем количество строк на странице к стандартному значению (например, 10)
        table.page.len(10).draw();

        // Показываем все строки
        table.rows().every(function () {
            $(this.node()).show(); // Показываем все строки
        });
    }

    // Обновляем отображение таблицы
    table.draw();
}

function filterNew(el) {
    $("#infoObAll").DataTable().destroy();

    let selectOblast = document.getElementById("selectOblast");

    selectOblast.selectedIndex = 0;
    var table = $("#infoObAll").DataTable();
    table.page.len(10).draw();
    // Сохраняем состояние фильтра
    var filterEmpty = el.checked;

    if (filterEmpty) {
        // Устанавливаем количество строк на странице на "все"
        table.page.len(-1).draw();

        // Скрываем строки, где "Заявка" пуста
        table.rows().every(function () {
            var tr = this.node();
            var dataId = $(tr).data("id"); // Проверяем, пустая ли ячейка

            if (dataId < 550) {
                $(tr).hide(); // Скрываем строки, где "Заявка" пуста
            }
            if (dataId === 570) {
                $(tr).hide(); // Скрываем строки, где "Заявка" пуста
            }
        });
    } else {
        // Возвращаем количество строк на странице к стандартному значению (например, 10)
        table.page.len(10).draw(); // Установите нужное количество строк на странице

        // Показываем все строки
        table.rows().every(function () {
            $(this.node()).show(); // Показываем все строки
        });
    }

    // Обновляем отображение таблицы
    table.draw();

}

function filterDogovor(el) {
    var table = $("#infoObAll").DataTable();

    // Сохраняем состояние фильтра
    var filterEmpty = el.checked;

    if (filterEmpty) {
        // Устанавливаем количество строк на странице на "все"
        table.page.len(-1).draw();

        // Скрываем строки, где "Заявка" пуста
        table.rows().every(function () {
            var rowData = this.data();
            var isEmpty = rowData[7].trim() === ""; // Проверяем, пустая ли ячейка

            if (isEmpty) {
                $(this.node()).hide(); // Скрываем строки, где "Заявка" пуста
            }
        });
    } else {
        // Возвращаем количество строк на странице к стандартному значению (например, 10)
        table.page.len(10).draw(); // Установите нужное количество строк на странице

        // Показываем все строки
        table.rows().every(function () {
            $(this.node()).show(); // Показываем все строки
        });
    }

    // Обновляем отображение таблицы
    table.draw();

}