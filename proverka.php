<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Оборудование</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap @5.3.0/dist/css/bootstrap.min.css">
    <style>
        .table-container {
            margin: 20px;
        }
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container table-container">
    <h3>Список оборудования</h3>
    <div class="table-responsive">
        <table id="equipmentTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>!!!</th>
                <th>Организация</th>
                <th>Модель</th>
                <th>Серийный номер</th>
                <th>Заводской номер</th>
                <th>Тип оборудования</th>
                <th>Год производства</th>
                <th>Дата поставки</th>
                <th>Дата ввода</th>
                <th>Сервисная организация</th>
                <th>Последнее ТО</th>
                <th>Статус</th>
            </tr>
            </thead>
            <tbody id="tableBody"></tbody>
        </table>
    </div>

    <!-- Пагинация -->
    <div class="pagination-container" id="pagination"></div>
</div>

<script>
    let currentPage = 1;

    // Функция загрузки данных
    function loadPage(page) {
        currentPage = page;
        fetch(`/app/ajax/getRespublic.php?page=${page}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById('tableBody').innerHTML = `<tr><td colspan="12">${data.error}</td></tr>`;
                    document.getElementById('pagination').innerHTML = '';
                    return;
                }

                const tbody = document.getElementById('tableBody');
                tbody.innerHTML = data.data.map(row => `
                <tr id="idob${row.id}">
                    <td>${row.mark}</td>
                    <td>${row.poliklinika}</td>
                    <td>${row.model}</td>
                    <td>${row.serial_number}</td>
                    <td>${row.zavod_nomer}</td>
                    <td onclick="getEffectTable(${row.id})" style="cursor:pointer;color:#167877;font-weight:500;">${row.type_name}</td>
                    <td>${row.date_create}</td>
                    <td>${row.date_postavki}</td>
                    <td>${row.date_release}</td>
                    <td>${row.servname}</td>
                    <td>${row.date_last_TO}</td>
                    <td>${row.status_html}</td>
                </tr>
            `).join('');

                renderPagination(currentPage, data.total_pages);
            })
            .catch(err => {
                console.error(err);
                document.getElementById('tableBody').innerHTML = `<tr><td colspan="12">Ошибка загрузки данных</td></tr>`;
            });
    }

    // Функция генерации кнопок пагинации
    function renderPagination(current, total) {
        const paginationDiv = document.getElementById('pagination');
        paginationDiv.innerHTML = '';

        if (total <= 1) return; // не показывать, если всего одна страница

        for (let i = 1; i <= total; i++) {
            const btn = document.createElement('button');
            btn.className = 'btn btn-outline-primary mx-1';
            if (i === current) btn.classList.add('active');
            btn.textContent = i;
            btn.onclick = () => loadPage(i);
            paginationDiv.appendChild(btn);
        }
    }

    // Загрузка первой страницы при открытии
    window.onload = function() {
        loadPage(1);
    };
</script>

</body>
</html>