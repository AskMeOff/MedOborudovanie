<?php

include '../../connection/connection.php';

$dogovor = isset($_POST['dogovor']) ? $_POST['dogovor'] : null;
$id = isset($_POST['id']) ? $_POST['id'] : null;


if ($dogovor) {
    $id_zakazchik = isset($dogovor['id_zakazchik']) ? $dogovor['id_zakazchik'] : null;
    $doljn = isset($dogovor['doljn']) ? $dogovor['doljn'] : null;
    $fio = isset($dogovor['fio']) ? $dogovor['fio'] : null;
    $osn_podpis = isset($dogovor['osn_podpis']) ? $dogovor['osn_podpis'] : null;
    $rekvizit = isset($dogovor['rekvizit']) ? $dogovor['rekvizit'] : null;
    $istochnik = isset($dogovor['istochnik']) ? $dogovor['istochnik'] : null;
    $date_start_work = isset($dogovor['date_start_work']) ? $dogovor['date_start_work'] : null;
    $date_end_work = isset($dogovor['date_end_work']) ? $dogovor['date_end_work'] : null;
    $count_bum = isset($dogovor['count_bum']) ? $dogovor['count_bum'] : null;
    $count_el = isset($dogovor['count_el']) ? $dogovor['count_el'] : null;
    $osn_obsled = isset($dogovor['osn_obsled']) ? $dogovor['osn_obsled'] : null;
    $name_work = isset($dogovor['name_work']) ? $dogovor['name_work'] : null;
    $target_work = isset($dogovor['target_work']) ? $dogovor['target_work'] : null;
    $nomer_dogovora = isset($dogovor['nomer_dogovora']) ? $dogovor['nomer_dogovora'] : null;
    $who_podpis_dog = isset($dogovor['who_podpis_dog']) ? $dogovor['who_podpis_dog'] : null;
    $srok_vid = isset($dogovor['srok_vid']) ? $dogovor['srok_vid'] : null;
    $count_days = isset($dogovor['count_days']) ? $dogovor['count_days'] : null;
    $date_akt = isset($dogovor['date_akt']) ? $dogovor['date_akt'] : null;
    $who_podpis_akt = isset($dogovor['who_podpis_akt']) ? $dogovor['who_podpis_akt'] : null;
    $date_zakl_dogovora = isset($dogovor['date_zakl_dogovora']) ? $dogovor['date_zakl_dogovora'] : null;
    $count_toms = isset($dogovor['count_toms']) ? $dogovor['count_toms'] : null;
    $who_podpis_titul = isset($dogovor['who_podpis_titul']) ? $dogovor['who_podpis_titul'] : null;
    $sum_avans = isset($dogovor['sum_avans']) ? $dogovor['sum_avans'] : null;
    $cost_work = isset($dogovor['cost_work']) ? $dogovor['cost_work'] : null;
    $count_str = isset($dogovor['count_str']) ? $dogovor['count_str'] : null;
    $nalich_avans = isset($dogovor['nalich_avans']) ? $dogovor['nalich_avans'] : null;
    $kompl_chert = isset($dogovor['kompl_chert']) ? $dogovor['kompl_chert'] : null;
    $tek_smeta = isset($dogovor['tek_smeta']) ? $dogovor['tek_smeta'] : null;
    $calculacia = isset($dogovor['calculacia']) ? $dogovor['calculacia'] : null;
    $prilagaetsa = isset($dogovor['prilagaetsa']) ? $dogovor['prilagaetsa'] : null;

    if ($id) {
        $sql = "UPDATE dogovor SET 
        doljn = '$doljn', 
        fio = '$fio', 
        osn_podpis = '$osn_podpis', 
        rekvizit = '$rekvizit', 
        istochnik = '$istochnik', 
        date_start_work = '$date_start_work', 
        date_end_work = '$date_end_work', 
        count_bum = '$count_bum', 
        count_el = '$count_el', 
        osn_obsled = '$osn_obsled', 
        name_work = '$name_work', 
        target_work = '$target_work', 
        nomer_dogovora = '$nomer_dogovora', 
        who_podpis_dog = '$who_podpis_dog', 
        srok_vid = '$srok_vid', 
        count_days = '$count_days', 
        date_akt = '$date_akt', 
        who_podpis_akt = '$who_podpis_akt', 
        date_zakl_dogovora = '$date_zakl_dogovora', 
        count_toms = '$count_toms', 
        who_podpis_titul = '$who_podpis_titul', 
        sum_avans = '$sum_avans', 
        cost_work = '$cost_work', 
        count_str = '$count_str' ,
        id_zakazchik = '$id_zakazchik',
        nalich_avans = '$nalich_avans',
        kompl_chert = '$kompl_chert',
        tek_smeta = '$tek_smeta',
        calculacia = '$calculacia',
        prilagaetsa = '$prilagaetsa'
        
    WHERE id_dogovor = '$id'";
    } else {
        // Если id_zakazchik не существует, вставляем новую запись
        $sql = "INSERT INTO dogovor (
        doljn, 
        fio, 
        osn_podpis, 
        rekvizit, 
        istochnik, 
        date_start_work, 
        date_end_work, 
        count_bum, 
        count_el, 
        osn_obsled, 
        name_work, 
        target_work, 
        nomer_dogovora, 
        who_podpis_dog, 
        srok_vid, 
        count_days, 
        date_akt, 
        who_podpis_akt, 
        date_zakl_dogovora, 
        count_toms, 
        who_podpis_titul, 
        sum_avans, 
        cost_work, 
        count_str,
        nalich_avans,
                        kompl_chert,
        tek_smeta,
        calculacia ,
        prilagaetsa 
    ) VALUES (
        '$doljn', 
        '$fio', 
        '$osn_podpis', 
        '$rekvizit', 
        '$istochnik', 
        '$date_start_work', 
        '$date_end_work', 
        '$count_bum', 
        '$count_el', 
        '$osn_obsled', 
        '$name_work', 
        '$target_work', 
        '$nomer_dogovora', 
        '$who_podpis_dog', 
        '$srok_vid', 
        '$count_days', 
        '$date_akt', 
        '$who_podpis_akt', 
        '$date_zakl_dogovora', 
        '$count_toms', 
        '$who_podpis_titul', 
        '$sum_avans', 
        '$cost_work', 
        '$count_str',
              '$nalich_avans',
                '$kompl_chert',
      '$tek_smeta',
       '$calculacia',
       '$prilagaetsa'
    )";
    }
    try {
        mysqli_query($connectionDB->con, $sql) ;
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {

}