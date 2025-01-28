<link rel="stylesheet" href="css/minsk.css">
<style>
    .news-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }
    .news-block {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        padding: 15px;
        transition: transform 0.2s;
        height: 200px; /* Фиксированная высота блока */
        overflow: hidden; /* Скрыть переполнение */
        position: relative; /* Для позиционирования кнопки */
    }
    .news-block:hover {
        transform: translateY(-5px);
    }
    .news-block h2 {
        font-size: 1.5em;
        margin: 0 0 10px;
    }
    .news-block p {
        display: none;
    }
    .news-block.show p {
        display: block;
    }
    .date {
        font-size: 0.8em;
        color: #888;
        display: block;
        margin-top: 10px;
    }
    .more-button {
        position: absolute;
        bottom: 15px;
        left: 15px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 5px 10px;
        cursor: pointer;
    }

    .modal {
        display: none; /* Скрыто по умолчанию */
        position: fixed;
        z-index: 1000; /* Убедитесь, что модальное окно выше других элементов */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5); /* Полупрозрачный фон */
    }

    .modal-content {
        background-color: #fefefe;
        margin: auto; /* Центрирование */
        padding: 20px;
        border: 1px solid #888;
        width: 90%; /* Ширина 90% от экрана */
        max-width: 600px; /* Максимальная ширина 600px */
        border-radius: 8px; /* Закругленные углы */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Тень */
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 24px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

</style>
<section class="content" style="margin-top: 100px; margin-left: 15px">
    <h1 style="margin-left: 50px;">Новости</h1>

    <div class="container-fluid" id="container_fluid" style="overflow: auto; height: 85vh;">
        <div class="row" id="main_row">
<div class="news-container">
    <?php
    $query = "SELECT id_news, title, content FROM news order by id_news desc";
    $result = $connectionDB->executeQuery($query);

    if ($connectionDB->getNumRows($result) > 0) {
        while ($row = $connectionDB->getRowResult($result)) {
            echo '<div class="news-block">';
            echo '<h2>' . htmlspecialchars($row['title']) . '</h2>';
            echo '<p>' . nl2br(htmlspecialchars_decode($row['content'])) . '</p>';
            echo '<button class="more-button" onclick="openNewsModal(' . $row['id_news'] . ')">Подробнее</button>';
            echo '</div>';
        }
    } else {
        echo '<p>Нет новостей для отображения.</p>';
    }

    $connectionDB->con->close();
    ?>
</div>
            </div>
    </div>
</section>


<div id="newsModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeNewsModal()">&times;</span>
        <h2 id="modalTitle"></h2>
        <p id="modalContent"></p>
    </div>
</div>


<script>
    function openNewsModal(id) {
        const modal = document.getElementById("newsModal");
        const modalTitle = document.getElementById("modalTitle");
        const modalContent = document.getElementById("modalContent");
        $.ajax({
            url: '/app/ajax/getNews.php',
            type: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function(data) {
                modalTitle.textContent = data.title;
                modalContent.innerHTML = data.content;
                modal.style.display = "block";
            },
            error: function(xhr, status, error) {
                console.error('Ошибка:', error);
                modalTitle.textContent = 'Ошибка';
                modalContent.textContent = 'Не удалось загрузить новость.';
                modal.style.display = "block";
            }
        });
    }

    function closeNewsModal() {
        document.getElementById("newsModal").style.display = "none";
    }


    function toggleNews(button) {
        const newsBlock = button.parentElement;
        newsBlock.classList.toggle('show');
        button.textContent = newsBlock.classList.contains('show') ? 'Скрыть' : 'Подробнее';
    }
</script>