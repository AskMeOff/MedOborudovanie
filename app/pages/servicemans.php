<?php

echo '<link rel="stylesheet" href="css/minsk.css">
<section class="content" style="margin-top: 100px; margin-left: 15px">
    <div class="container-fluid" id="container_fluid">

        <div class="row" id="main_row">';


            $query = "select * from servicemans;";
            $result = $connectionDB->executeQuery($query);
            if ($connectionDB->getNumRows($result) == 0) {
            echo '<section class="col-lg-9 connectedSortable ui-sortable"  style="display: block;">
                <div class="row">
                </div>
            </section>';
            }
while ($row = mysqli_fetch_assoc($result)) {

    $id_serviceman = $row['id_serviceman'];

    echo ' <section class="col-lg-9 connectedSortable ui-sortable" id="service' . $id_serviceman . '" style="display: block;">
                <div class="row">

                    <div class="table-responsive">
                        <table class="table table-striped table-responsive-sm dataTable no-footer" id="infoservice' . $id_serviceman . '"
                               style="display: none">
                            <thead>
                            <tr>
                                <th style="text-align: center;">Учреждение здравоохранения</th>
                                <th style="text-align: center;">Количество</th>
                        
                            </tr>
                            </thead>
                            <tbody>';
    $sql1 = "SELECT count(o.id_oborudovanie) countUz,uz.id_uz, uz.name   FROM oborudovanie o
                                        left join uz uz on o.id_uz = uz.id_uz
                                        left join servicemans s on s.id_serviceman = o.id_serviceman
                                        where s.id_serviceman = '$id_serviceman' group by uz.id_uz";
    $result1 = $connectionDB->executeQuery($sql1);
    while ($row1 = mysqli_fetch_assoc($result1)) {
        $nameUz = $row1['name'];
        $id_uz = $row1['id_uz'];
        $countUz = $row1['countUz'];
        echo '<tr id=iduz'.$id_uz.'  >';

        echo '<td>' . $nameUz . '</td>';
        echo '<td>' . $countUz . '</td>';

        echo '</tr>';
    }

    echo ' 
                            </tbody>
                        </table>
     
                    </div>
                </div>

            </section>';
}



echo '<section class="col-lg-3" id="right_section" style="overflow: auto;
    height: 85vh;">
    <div><input style="width:100%;" type="text" id="myInputOrg" onkeyup="searchServiceman(this)"
                placeholder="Поиск обслуживающей организации"
                title="Type in a name">
    </div>';



$sql = "select * from servicemans";
$result = $connectionDB->executeQuery($sql);
//                $activeClass = "activecard1";
while ($row = mysqli_fetch_assoc($result)) {

    echo '<div class="card card0 " onclick="showServiceman(' . $row['id_serviceman'] . ',this)">';
    echo '<h4>' . $row['name'] . '</h4>';
    echo '</div>';
//                    $activeClass = "";
}



echo '</div>
    </div>
</section>
<script src="js/serviceman.js"></script>
';
?>