<?php

?>
<style>
    .card1 {
        cursor: pointer;
        height: 100px;
        background-size: cover;
        background-attachment: fixed;
        display: flex;
        flex-direction: column;
        /* align-items: center; */
        padding-left: 20px;
        justify-content: center;
        /* text-align: center; */
        color: black;
        transition: all 0.5s ease-in;
        width: 700px;
    }

    .card {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: aliceblue;
        background-clip: border-box;
        border: 0 solid rgba(0, 0, 0, 0.125);
        border-radius: 0.25rem;
    }
    @media (min-width: 1000px) {
        .card {
            left: 27%;
        }
    }
    .card {
        box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2);
        margin-bottom: 1rem;

    }

    .card:hover{
        background-color: #bbd0e3;
    }

    .card1 h2 {
        text-align: center;
        margin-top: 20px;
    }


    #preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .loader {
        border: 8px solid #f3f3f3; /* Light grey */
        border-top: 8px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

</style>

<section class="col-lg-12 connectedSortable ui-sortable" style="margin-top: 90px">

    <?php

    if (isset($id_role )) {
        if ($id_role == 1 || $id_role == 2) {
            echo "<div class='row'>";
            echo "<div class='card card1' onclick='getUzs(111)'>";
            echo "<h2>Республика Беларусь</h2>";
            echo "</div>";
            echo "</div>";
        }
    }
    $query = "SELECT * FROM oblast;";
    $result = $connectionDB->executeQuery($query);
    while ($row = mysqli_fetch_assoc($result)) {
        $id_oblast = $row['id_oblast'];
        echo "<div class='row'>";
        echo "<div class='card card1' onclick='getUzs($id_oblast)'>";
        echo "<h2>". $row['name']. "</h2>";
        echo "</div>";
        echo "</div>";
    }





    ?>
    <div id="preloader" style="display:none;">
        <div class="loader"></div>
    </div>
</section>

<script>


</script>
