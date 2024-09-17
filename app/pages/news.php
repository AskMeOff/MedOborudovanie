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
    }
    .news-block:hover {
        transform: translateY(-5px);
    }
    .news-block h2 {
        font-size: 1.5em;
        margin: 0 0 10px;
    }
    .news-block p {
        font-size: 1em;
        color: #555;
    }
    .date {
        font-size: 0.8em;
        color: #888;
        display: block;
        margin-top: 10px;
    }
</style>
<div class="news-container">
    <?php
    $query = "SELECT title, content, date FROM news ORDER BY date DESC";
    $result = $connectionDB->executeQuery($query);

    if ($connectionDB->getNumRows($result) > 0) {
        while ($row = $connectionDB->getRowResult($result)) {
            echo '<div class="news-block">';
            echo '<h2>' . htmlspecialchars($row['title']) . '</h2>';
            echo '<p>' . htmlspecialchars($row['content']) . '</p>';
            echo '<span class="date">' . htmlspecialchars($row['date']) . '</span>';
            echo '</div>';
        }
    } else {
        echo '<p>Нет новостей для отображения.</p>';
    }

    $connectionDB->con->close();
    ?>
</div>