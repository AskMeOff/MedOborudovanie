<?php

include '../../connection/connection.php';

$haractObject = json_decode($_POST['haractObject'], true);  // классы
$ishod = json_decode($_POST['ishod'], true);
$obmerObject = json_decode($_POST['obmerObject'], true);
$obsledObject = json_decode($_POST['obsledObject'], true);
$sostTechObject = json_decode($_POST['sostTechObject'], true);
$redactorIspObject = json_decode($_POST['redactorIspObject'], true);
$obsledOtdKonstrObject = json_decode($_POST['obsledOtdKonstrObject'], true);
$calculObject = json_decode($_POST['calculObject'], true);

$zdanie = isset($haractObject['zdanie']) ? $haractObject['zdanie'] : null;
$typeZdanie = isset($haractObject['typeZdanie']) ? $haractObject['typeZdanie'] : null;
$stage = $haractObject['stage'] != "" ? $haractObject['stage'] : 0;
$height = $haractObject['height'] != "" ? $haractObject['height'] : 0;
$obem = $haractObject['obem'] != "" ? $haractObject['obem'] : 0;
$height_pol = $haractObject['height_pol'] != "" ? $haractObject['height_pol'] : 0;
$temperature = isset($haractObject['temperature']) ? $haractObject['temperature'] : null;
$nasishenost = isset($haractObject['nasishenost']) ? $haractObject['nasishenost'] : null;
$aggresive_vozdeistvie = isset($haractObject['aggresive_vozdeistvie']) ? $haractObject['aggresive_vozdeistvie'] : null;


$checkb1 = isset($haractObject['checkb1']) ? $haractObject['checkb1'] : 0;
$checkb2 = isset($haractObject['checkb2']) ? $haractObject['checkb2'] : 0;
$checkb3 = isset($haractObject['checkb3']) ? $haractObject['checkb3'] : 0;
$checkb4 = isset($haractObject['checkb4']) ? $haractObject['checkb4'] : 0;
$checkb5 = isset($haractObject['checkb5']) ? $haractObject['checkb5'] : 0;
$checkb6 = isset($haractObject['checkb6']) ? $haractObject['checkb6'] : 0;
$checkb7 = isset($haractObject['checkb7']) ? $haractObject['checkb7'] : 0;
$checkb8 = isset($haractObject['checkb8']) ? $haractObject['checkb8'] : 0;
$checkb9 = isset($haractObject['checkb9']) ? $haractObject['checkb9'] : 0;
$checkb10 = isset($haractObject['checkb10']) ? $haractObject['checkb10'] : 0;
$checkb11 = isset($haractObject['checkb11']) ? $haractObject['checkb11'] : 0;
$checkb12 = isset($haractObject['checkb12']) ? $haractObject['checkb12'] : 0;
$hardZdanie = isset($haractObject['hardZdanie']) ? $haractObject['hardZdanie'] : 0;

$sborCheck = isset($ishod['sborCheck']) ? $ishod['sborCheck'] : null;
$toggleZd1 = isset($ishod['toggleZd1']) ? $ishod['toggleZd1'] : null;
$toggleZd2 = isset($ishod['toggleZd2']) ? $ishod['toggleZd2'] : null;
$toggleZd3 = isset($ishod['toggleZd3']) ? $ishod['toggleZd3'] : null;
$toggleZd4 = isset($ishod['toggleZd4']) ? $ishod['toggleZd4'] : null;
$toggleZd5 = isset($ishod['toggleZd5']) ? $ishod['toggleZd5'] : null;
$toggleZd6 = isset($ishod['toggleZd6']) ? $ishod['toggleZd6'] : null;
$toggleZd7 = isset($ishod['toggleZd7']) ? $ishod['toggleZd7'] : null;
$toggleZd8 = isset($ishod['toggleZd8']) ? $ishod['toggleZd8'] : null;
$toggleZd9 = isset($ishod['toggleZd9']) ? $ishod['toggleZd9'] : null;
$choosCunstruct = isset($ishod['choosCunstruct']) ? $ishod['choosCunstruct'] : null;
$conval1 = isset($ishod['conval1']) ? $ishod['conval1'] : null;
$conval2 = isset($ishod['conval2']) ? $ishod['conval2'] : null;
$conval3 = isset($ishod['conval3']) ? $ishod['conval3'] : null;
$conval4 = isset($ishod['conval4']) ? $ishod['conval4'] : null;
$conval5 = isset($ishod['conval5']) ? $ishod['conval5'] : null;
$conval6 = isset($ishod['conval6']) ? $ishod['conval6'] : null;
$conval7 = isset($ishod['conval7']) ? $ishod['conval7'] : null;
$conval8 = isset($ishod['conval8']) ? $ishod['conval8'] : null;
$conval9 = isset($ishod['conval9']) ? $ishod['conval9'] : null;
$selectedButrad = isset($ishod['selectedButrad']) ? $ishod['selectedButrad'] : null;

$obmerCheck = isset($obmerObject['obmerCheck']) ? $obmerObject['obmerCheck'] : null;
$toggleZd41 = isset($obmerObject['toggleZd41']) ? $obmerObject['toggleZd41'] : null;
$toggleZd42 = isset($obmerObject['toggleZd42']) ? $obmerObject['toggleZd42'] : null;
$toggleZd43 = isset($obmerObject['toggleZd43']) ? $obmerObject['toggleZd43'] : null;
$toggleZd44 = isset($obmerObject['toggleZd44']) ? $obmerObject['toggleZd44'] : null;
$toggleZd45 = isset($obmerObject['toggleZd45']) ? $obmerObject['toggleZd45'] : null;
$toggleZd46 = isset($obmerObject['toggleZd46']) ? $obmerObject['toggleZd46'] : null;
$toggleZd48 = isset($obmerObject['toggleZd48']) ? $obmerObject['toggleZd48'] : null;
$toggleZd49 = isset($obmerObject['toggleZd49']) ? $obmerObject['toggleZd49'] : null;
$toggleZd449 = isset($obmerObject['toggleZd449']) ? $obmerObject['toggleZd449'] : null;
$choosCunstruct4 = isset($obmerObject['choosCunstruct4']) ? $obmerObject['choosCunstruct4'] : null;
$conval41 = isset($obmerObject['conval41']) ? $obmerObject['conval41'] : null;
$conval42 = isset($obmerObject['conval42']) ? $obmerObject['conval42'] : null;
$conval43 = isset($obmerObject['conval43']) ? $obmerObject['conval43'] : null;
$conval44 = isset($obmerObject['conval44']) ? $obmerObject['conval44'] : null;
$conval45 = isset($obmerObject['conval45']) ? $obmerObject['conval45'] : null;
$conval46 = isset($obmerObject['conval46']) ? $obmerObject['conval46'] : null;
$conval48 = isset($obmerObject['conval48']) ? $obmerObject['conval48'] : null;
$conval49 = isset($obmerObject['conval49']) ? $obmerObject['conval49'] : null;
$conval449 = isset($obmerObject['conval449']) ? $obmerObject['conval449'] : null;
$obmerobs = isset($obmerObject['obmerobs']) ? $obmerObject['obmerobs'] : null;


$obsledCheck = isset($obsledObject['obsledCheck']) ? $obsledObject['obsledCheck'] : null;
$toggleZd51 = isset($obsledObject['toggleZd51']) ? $obsledObject['toggleZd51'] : null;
$toggleZd52 = isset($obsledObject['toggleZd52']) ? $obsledObject['toggleZd52'] : null;
$toggleZd53 = isset($obsledObject['toggleZd53']) ? $obsledObject['toggleZd53'] : null;
$toggleZd54 = isset($obsledObject['toggleZd54']) ? $obsledObject['toggleZd54'] : null;
$toggleZd55 = isset($obsledObject['toggleZd55']) ? $obsledObject['toggleZd55'] : null;
$toggleZd56 = isset($obsledObject['toggleZd56']) ? $obsledObject['toggleZd56'] : null;
$toggleZd57 = isset($obsledObject['toggleZd57']) ? $obsledObject['toggleZd57'] : null;
$toggleZd58 = isset($obsledObject['toggleZd58']) ? $obsledObject['toggleZd58'] : null;
$toggleZd59 = isset($obsledObject['toggleZd59']) ? $obsledObject['toggleZd59'] : null;
$choosCunstruct5 = isset($obsledObject['choosCunstruct5']) ? $obsledObject['choosCunstruct5'] : null;
$conval51 = isset($obsledObject['conval51']) ? $obsledObject['conval51'] : null;
$conval52 = isset($obsledObject['conval52']) ? $obsledObject['conval52'] : null;
$conval53 = isset($obsledObject['conval53']) ? $obsledObject['conval53'] : null;
$conval54 = isset($obsledObject['conval54']) ? $obsledObject['conval54'] : null;
$conval55 = isset($obsledObject['conval55']) ? $obsledObject['conval55'] : null;
$conval56 = isset($obsledObject['conval56']) ? $obsledObject['conval56'] : null;
$conval57 = isset($obsledObject['conval57']) ? $obsledObject['conval57'] : null;
$conval58 = isset($obsledObject['conval58']) ? $obsledObject['conval58'] : null;
$conval59 = isset($obsledObject['conval59']) ? $obsledObject['conval59'] : null;
$obsledobs = isset($obsledObject['obsledobs']) ? $obsledObject['obsledobs'] : null;

$sostTechOtchetCheck = isset($sostTechObject['sostTechOtchetCheck']) ? $sostTechObject['sostTechOtchetCheck'] : null;
$toggleZd61 = isset($sostTechObject['toggleZd61']) ? $sostTechObject['toggleZd61'] : null;
$toggleZd62 = isset($sostTechObject['toggleZd62']) ? $sostTechObject['toggleZd62'] : null;
$toggleZd63 = isset($sostTechObject['toggleZd63']) ? $sostTechObject['toggleZd63'] : null;
$toggleZd64 = isset($sostTechObject['toggleZd64']) ? $sostTechObject['toggleZd64'] : null;
$toggleZd65 = isset($sostTechObject['toggleZd65']) ? $sostTechObject['toggleZd65'] : null;
$toggleZd66 = isset($sostTechObject['toggleZd66']) ? $sostTechObject['toggleZd66'] : null;
$toggleZd67 = isset($sostTechObject['toggleZd67']) ? $sostTechObject['toggleZd67'] : null;
$toggleZd68 = isset($sostTechObject['toggleZd68']) ? $sostTechObject['toggleZd68'] : null;
$toggleZd69 = isset($sostTechObject['toggleZd69']) ? $sostTechObject['toggleZd69'] : null;
$choosCunstruct6 = isset($sostTechObject['choosCunstruct6']) ? $sostTechObject['choosCunstruct6'] : null;
$conval61 = isset($sostTechObject['conval61']) ? $sostTechObject['conval61'] : null;
$conval62 = isset($sostTechObject['conval62']) ? $sostTechObject['conval62'] : null;
$conval63 = isset($sostTechObject['conval63']) ? $sostTechObject['conval63'] : null;
$conval64 = isset($sostTechObject['conval64']) ? $sostTechObject['conval64'] : null;
$conval65 = isset($sostTechObject['conval65']) ? $sostTechObject['conval65'] : null;
$conval66 = isset($sostTechObject['conval66']) ? $sostTechObject['conval66'] : null;
$conval67 = isset($sostTechObject['conval67']) ? $sostTechObject['conval67'] : null;
$conval68 = isset($sostTechObject['conval68']) ? $sostTechObject['conval68'] : null;
$conval69 = isset($sostTechObject['conval69']) ? $sostTechObject['conval69'] : null;
$zaklSostStr = isset($sostTechObject['selectedSosttech']) ? $sostTechObject['selectedSosttech'] : null;

$redaktorIspConstrCheck = isset($redactorIspObject['redaktorIspConstrCheck']) ? $redactorIspObject['redaktorIspConstrCheck'] : null;
$toggleZd71 = isset($redactorIspObject['toggleZd71']) ? $redactorIspObject['toggleZd71'] : null;
$toggleZd72 = isset($redactorIspObject['toggleZd72']) ? $redactorIspObject['toggleZd72'] : null;
$toggleZd73 = isset($redactorIspObject['toggleZd73']) ? $redactorIspObject['toggleZd73'] : null;
$toggleZd74 = isset($redactorIspObject['toggleZd74']) ? $redactorIspObject['toggleZd74'] : null;
$conval71 = isset($redactorIspObject['conval71']) ? $redactorIspObject['conval71'] : null;
$conval72 = isset($redactorIspObject['conval72']) ? $redactorIspObject['conval72'] : null;
$conval73 = isset($redactorIspObject['conval73']) ? $redactorIspObject['conval73'] : null;
$conval74 = isset($redactorIspObject['conval74']) ? $redactorIspObject['conval74'] : null;

$obsledotdelCheck = isset($obsledOtdKonstrObject['obsledotdelCheck']) ? $obsledOtdKonstrObject['obsledotdelCheck'] : 0;
$toggleZd81 = isset($obsledOtdKonstrObject['toggleZd81']) ? $obsledOtdKonstrObject['toggleZd81'] : 0;
$toggleZd82 = isset($obsledOtdKonstrObject['toggleZd82']) ? $obsledOtdKonstrObject['toggleZd82'] : 0;
$toggleZd83 = isset($obsledOtdKonstrObject['toggleZd83']) ? $obsledOtdKonstrObject['toggleZd83'] : 0;
$toggleZd84 = isset($obsledOtdKonstrObject['toggleZd84']) ? $obsledOtdKonstrObject['toggleZd84'] : 0;
$toggleZd85 = isset($obsledOtdKonstrObject['toggleZd85']) ? $obsledOtdKonstrObject['toggleZd85'] : 0;
$toggleZd86 = isset($obsledOtdKonstrObject['toggleZd86']) ? $obsledOtdKonstrObject['toggleZd86'] : 0;
$toggleZd87 = isset($obsledOtdKonstrObject['toggleZd87']) ? $obsledOtdKonstrObject['toggleZd87'] : 0;
$toggleZd88 = isset($obsledOtdKonstrObject['toggleZd88']) ? $obsledOtdKonstrObject['toggleZd88'] : 0;
$toggleZd89 = isset($obsledOtdKonstrObject['toggleZd89']) ? $obsledOtdKonstrObject['toggleZd89'] : 0;
$toggleZd081 = isset($obsledOtdKonstrObject['toggleZd081']) ? $obsledOtdKonstrObject['toggleZd081'] : 0;
$toggleZd082 = isset($obsledOtdKonstrObject['toggleZd082']) ? $obsledOtdKonstrObject['toggleZd082'] : 0;
$toggleZd083 = isset($obsledOtdKonstrObject['toggleZd083']) ? $obsledOtdKonstrObject['toggleZd083'] : 0;
$toggleZd084 = isset($obsledOtdKonstrObject['toggleZd084']) ? $obsledOtdKonstrObject['toggleZd084'] : 0;
$toggleZd085 = isset($obsledOtdKonstrObject['toggleZd085']) ? $obsledOtdKonstrObject['toggleZd085'] : 0;
$toggleZd086 = isset($obsledOtdKonstrObject['toggleZd086']) ? $obsledOtdKonstrObject['toggleZd086'] : 0;
$toggleZd087 = isset($obsledOtdKonstrObject['toggleZd087']) ? $obsledOtdKonstrObject['toggleZd087'] : 0;
$toggleZd088 = isset($obsledOtdKonstrObject['toggleZd088']) ? $obsledOtdKonstrObject['toggleZd088'] : 0;
$toggleZd089 = isset($obsledOtdKonstrObject['toggleZd089']) ? $obsledOtdKonstrObject['toggleZd089'] : 0;
$toggleZd0081 = isset($obsledOtdKonstrObject['toggleZd0081']) ? $obsledOtdKonstrObject['toggleZd0081'] : 0;
$toggleZd0082 = isset($obsledOtdKonstrObject['toggleZd0082']) ? $obsledOtdKonstrObject['toggleZd0082'] : 0;
$toggleZd0083 = isset($obsledOtdKonstrObject['toggleZd0083']) ? $obsledOtdKonstrObject['toggleZd0083'] : 0;

$conval81 = isset($obsledOtdKonstrObject['conval81']) ? $obsledOtdKonstrObject['conval81'] : null;
$conval811 = isset($obsledOtdKonstrObject['conval811']) ? $obsledOtdKonstrObject['conval811'] : null;
$conval82 = isset($obsledOtdKonstrObject['conval82']) ? $obsledOtdKonstrObject['conval82'] : null;
$conval822 = isset($obsledOtdKonstrObject['conval822']) ? $obsledOtdKonstrObject['conval822'] : null;
$conval83 = isset($obsledOtdKonstrObject['conval83']) ? $obsledOtdKonstrObject['conval83'] : null;
$conval833 = isset($obsledOtdKonstrObject['conval833']) ? $obsledOtdKonstrObject['conval833'] : null;
$conval84 = isset($obsledOtdKonstrObject['conval84']) ? $obsledOtdKonstrObject['conval84'] : null;
$conval844 = isset($obsledOtdKonstrObject['conval844']) ? $obsledOtdKonstrObject['conval844'] : null;
$conval85 = isset($obsledOtdKonstrObject['conval85']) ? $obsledOtdKonstrObject['conval85'] : null;
$conval855 = isset($obsledOtdKonstrObject['conval855']) ? $obsledOtdKonstrObject['conval855'] : null;
$conval86 = isset($obsledOtdKonstrObject['conval86']) ? $obsledOtdKonstrObject['conval86'] : null;
$conval866 = isset($obsledOtdKonstrObject['conval866']) ? $obsledOtdKonstrObject['conval866'] : null;
$conval87 = isset($obsledOtdKonstrObject['conval87']) ? $obsledOtdKonstrObject['conval87'] : null;
$conval877 = isset($obsledOtdKonstrObject['conval877']) ? $obsledOtdKonstrObject['conval877'] : null;
$conval88 = isset($obsledOtdKonstrObject['conval88']) ? $obsledOtdKonstrObject['conval88'] : null;
$conval888 = isset($obsledOtdKonstrObject['conval888']) ? $obsledOtdKonstrObject['conval888'] : null;
$conval89 = isset($obsledOtdKonstrObject['conval89']) ? $obsledOtdKonstrObject['conval89'] : null;
$conval899 = isset($obsledOtdKonstrObject['conval899']) ? $obsledOtdKonstrObject['conval899'] : null;
$conval081 = isset($obsledOtdKonstrObject['conval081']) ? $obsledOtdKonstrObject['conval081'] : null;
$conval0811 = isset($obsledOtdKonstrObject['conval0811']) ? $obsledOtdKonstrObject['conval0811'] : null;
$conval082 = isset($obsledOtdKonstrObject['conval082']) ? $obsledOtdKonstrObject['conval082'] : null;
$conval0822 = isset($obsledOtdKonstrObject['conval0822']) ? $obsledOtdKonstrObject['conval0822'] : null;
$conval083 = isset($obsledOtdKonstrObject['conval083']) ? $obsledOtdKonstrObject['conval083'] : null;
$conval0833 = isset($obsledOtdKonstrObject['conval0833']) ? $obsledOtdKonstrObject['conval0833'] : null;
$conval084 = isset($obsledOtdKonstrObject['conval084']) ? $obsledOtdKonstrObject['conval084'] : null;
$conval0844 = isset($obsledOtdKonstrObject['conval0844']) ? $obsledOtdKonstrObject['conval0844'] : null;
$conval085 = isset($obsledOtdKonstrObject['conval085']) ? $obsledOtdKonstrObject['conval085'] : null;
$conval0855 = isset($obsledOtdKonstrObject['conval0855']) ? $obsledOtdKonstrObject['conval0855'] : null;
$conval086 = isset($obsledOtdKonstrObject['conval086']) ? $obsledOtdKonstrObject['conval086'] : null;
$conval0866 = isset($obsledOtdKonstrObject['conval0866']) ? $obsledOtdKonstrObject['conval0866'] : null;
$conval087 = isset($obsledOtdKonstrObject['conval087']) ? $obsledOtdKonstrObject['conval087'] : null;
$conval0877 = isset($obsledOtdKonstrObject['conval0877']) ? $obsledOtdKonstrObject['conval0877'] : null;
$conval088 = isset($obsledOtdKonstrObject['conval088']) ? $obsledOtdKonstrObject['conval088'] : null;
$conval0888 = isset($obsledOtdKonstrObject['conval0888']) ? $obsledOtdKonstrObject['conval0888'] : null;
$conval089 = isset($obsledOtdKonstrObject['conval089']) ? $obsledOtdKonstrObject['conval089'] : null;
$conval0899 = isset($obsledOtdKonstrObject['conval0899']) ? $obsledOtdKonstrObject['conval0899'] : null;
$conval0081 = isset($obsledOtdKonstrObject['conval0081']) ? $obsledOtdKonstrObject['conval0081'] : null;
$conval00811 = isset($obsledOtdKonstrObject['conval00811']) ? $obsledOtdKonstrObject['conval00811'] : null;
$conval0082 = isset($obsledOtdKonstrObject['conval0082']) ? $obsledOtdKonstrObject['conval0082'] : null;
$conval00822 = isset($obsledOtdKonstrObject['conval00822']) ? $obsledOtdKonstrObject['conval00822'] : null;
$conval0083 = isset($obsledOtdKonstrObject['conval0083']) ? $obsledOtdKonstrObject['conval0083'] : null;
$conval00833 = isset($obsledOtdKonstrObject['conval00833']) ? $obsledOtdKonstrObject['conval00833'] : null;

$monolit1 = isset($obsledOtdKonstrObject['monolit1']) ? $obsledOtdKonstrObject['monolit1'] : null;
$monolit2 = isset($obsledOtdKonstrObject['monolit2']) ? $obsledOtdKonstrObject['monolit2'] : null;
$monolit3 = isset($obsledOtdKonstrObject['monolit3']) ? $obsledOtdKonstrObject['monolit3'] : null;
$monolit4 = isset($obsledOtdKonstrObject['monolit4']) ? $obsledOtdKonstrObject['monolit4'] : null;
$monolit5 = isset($obsledOtdKonstrObject['monolit5']) ? $obsledOtdKonstrObject['monolit5'] : null;
$monolit6 = isset($obsledOtdKonstrObject['monolit6']) ? $obsledOtdKonstrObject['monolit6'] : null;
$monolit7 = isset($obsledOtdKonstrObject['monolit7']) ? $obsledOtdKonstrObject['monolit7'] : null;
$monolit8 = isset($obsledOtdKonstrObject['monolit8']) ? $obsledOtdKonstrObject['monolit8'] : null;
$monolit9 = isset($obsledOtdKonstrObject['monolit9']) ? $obsledOtdKonstrObject['monolit9'] : null;
$monolit10 = isset($obsledOtdKonstrObject['monolit10']) ? $obsledOtdKonstrObject['monolit10'] : null;
$monolit11 = isset($obsledOtdKonstrObject['monolit11']) ? $obsledOtdKonstrObject['monolit11'] : null;
$monolit12 = isset($obsledOtdKonstrObject['monolit12']) ? $obsledOtdKonstrObject['monolit12'] : null;
$monolit13 = isset($obsledOtdKonstrObject['monolit13']) ? $obsledOtdKonstrObject['monolit13'] : null;
$monolit14 = isset($obsledOtdKonstrObject['monolit14']) ? $obsledOtdKonstrObject['monolit14'] : null;
$monolit15 = isset($obsledOtdKonstrObject['monolit15']) ? $obsledOtdKonstrObject['monolit15'] : null;
$monolit16 = isset($obsledOtdKonstrObject['monolit16']) ? $obsledOtdKonstrObject['monolit16'] : null;
$monolit17 = isset($obsledOtdKonstrObject['monolit17']) ? $obsledOtdKonstrObject['monolit17'] : null;
$monolit18 = isset($obsledOtdKonstrObject['monolit18']) ? $obsledOtdKonstrObject['monolit18'] : null;
$monolit19 = isset($obsledOtdKonstrObject['monolit19']) ? $obsledOtdKonstrObject['monolit19'] : null;
$monolit20 = isset($obsledOtdKonstrObject['monolit20']) ? $obsledOtdKonstrObject['monolit20'] : null;
$monolit21 = isset($obsledOtdKonstrObject['monolit21']) ? $obsledOtdKonstrObject['monolit21'] : null;

$calcalcCheck = isset($calculObject['calcalcCheck']) ? $calculObject['calcalcCheck'] : null;
$selectCalc1 = isset($calculObject['selectCalc1']) ? $calculObject['selectCalc1'] : null;
$selectCalc2 = isset($calculObject['selectCalc2']) ? $calculObject['selectCalc2'] : null;
$selectCalc3 = isset($calculObject['selectCalc3']) ? $calculObject['selectCalc3'] : null;
$selectCalc4 = isset($calculObject['selectCalc4']) ? $calculObject['selectCalc4'] : null;
$selectCalc5 = isset($calculObject['selectCalc5']) ? $calculObject['selectCalc5'] : null;
$selectCalc6 = isset($calculObject['selectCalc6']) ? $calculObject['selectCalc6'] : null;
$selectCalc7 = isset($calculObject['selectCalc7']) ? $calculObject['selectCalc7'] : null;
$selectCalc8 = isset($calculObject['selectCalc8']) ? $calculObject['selectCalc8'] : null;

$inputCalc1 = isset($calculObject['inputCalc1']) ? $calculObject['inputCalc1'] : null;
$inputCalc2 = isset($calculObject['inputCalc2']) ? $calculObject['inputCalc2'] : null;
$inputCalc3 = isset($calculObject['inputCalc3']) ? $calculObject['inputCalc3'] : null;
$inputCalc4 = isset($calculObject['inputCalc4']) ? $calculObject['inputCalc4'] : null;
$inputCalc5 = isset($calculObject['inputCalc5']) ? $calculObject['inputCalc5'] : null;
$inputCalc6 = isset($calculObject['inputCalc6']) ? $calculObject['inputCalc6'] : null;
$inputCalc7 = isset($calculObject['inputCalc7']) ? $calculObject['inputCalc7'] : null;
$inputCalc8 = isset($calculObject['inputCalc8']) ? $calculObject['inputCalc8'] : null;

$select2Calc1 = isset($calculObject['select2Calc1']) ? $calculObject['select2Calc1'] : null;
$select2Calc2 = isset($calculObject['select2Calc2']) ? $calculObject['select2Calc2'] : null;
$select2Calc3 = isset($calculObject['select2Calc3']) ? $calculObject['select2Calc3'] : null;
$select2Calc4 = isset($calculObject['select2Calc4']) ? $calculObject['select2Calc4'] : null;
$select2Calc5 = isset($calculObject['select2Calc5']) ? $calculObject['select2Calc5'] : null;
$select2Calc6 = isset($calculObject['select2Calc6']) ? $calculObject['select2Calc6'] : null;
$select2Calc7 = isset($calculObject['select2Calc7']) ? $calculObject['select2Calc7'] : null;
$select2Calc8 = isset($calculObject['select2Calc8']) ? $calculObject['select2Calc8'] : null;

$input2Calc1 = isset($calculObject['input2Calc1']) ? $calculObject['input2Calc1'] : null;
$input2Calc2 = isset($calculObject['input2Calc2']) ? $calculObject['input2Calc2'] : null;
$input2Calc3 = isset($calculObject['input2Calc3']) ? $calculObject['input2Calc3'] : null;
$input2Calc4 = isset($calculObject['input2Calc4']) ? $calculObject['input2Calc4'] : null;
$input2Calc5 = isset($calculObject['input2Calc5']) ? $calculObject['input2Calc5'] : null;
$input2Calc6 = isset($calculObject['input2Calc6']) ? $calculObject['input2Calc6'] : null;
$input2Calc7 = isset($calculObject['input2Calc7']) ? $calculObject['input2Calc7'] : null;
$input2Calc8 = isset($calculObject['input2Calc8']) ? $calculObject['input2Calc8'] : null;

$input3Calc1 = isset($calculObject['input3Calc1']) ? $calculObject['input3Calc1'] : null;
$input3Calc2 = isset($calculObject['input3Calc2']) ? $calculObject['input3Calc2'] : null;
$input3Calc3 = isset($calculObject['input3Calc3']) ? $calculObject['input3Calc3'] : null;
$input3Calc4 = isset($calculObject['input3Calc4']) ? $calculObject['input3Calc4'] : null;
$input3Calc5 = isset($calculObject['input3Calc5']) ? $calculObject['input3Calc5'] : null;
$input3Calc6 = isset($calculObject['input3Calc6']) ? $calculObject['input3Calc6'] : null;
$input3Calc7 = isset($calculObject['input3Calc7']) ? $calculObject['input3Calc7'] : null;
$input3Calc8 = isset($calculObject['input3Calc8']) ? $calculObject['input3Calc8'] : null;


$id_zakazchik = isset($_POST['id_zakazchik']) ? $_POST['id_zakazchik'] : null;
$id_podryadchik = isset($_POST['id_podryadchik']) ? $_POST['id_podryadchik'] : null;
$selectedZakazchik = isset($_POST['selectedZakazchik']) ? $_POST['selectedZakazchik'] : null;
$selectedPodryadchik = isset($_POST['selectedPodryadchik']) ? $_POST['selectedPodryadchik'] : null;
$selectedIziskom = isset($_POST['selectedIziskom']) ? $_POST['selectedIziskom'] : null;
$selectedVskrytie = isset($_POST['selectedVskrytie']) ? $_POST['selectedVskrytie'] : null;
$selectedKonkursnoe= isset($_POST['selectedKonkursnoe']) ? $_POST['selectedKonkursnoe'] : null;
$summa = isset($_POST['summa']) ? $_POST['summa'] : null;
$textAreaNaimRabot = isset($_POST['textAreaNaimRabot']) ? $_POST['textAreaNaimRabot'] : null;
$textAreaCel = isset($_POST['textAreaCel']) ? $_POST['textAreaCel'] : null;
$textAreaMestoObj = isset($_POST['textAreaMestoObj']) ? $_POST['textAreaMestoObj'] : null;
if ($_POST['dateNachRab'] === "")
    $dateNachRab = "2000-01-01";
else {
    $dateNachRab = $_POST['dateNachRab'];

}
if ($_POST['dateOkonchRab'] === "")
    $dateOkonchRab = '2000-01-01';

else {
    $dateOkonchRab = $_POST['dateOkonchRab'];

}
$smetaName = $_POST['name'];

if (isset($_POST['id'])) {

    $id = $_POST['id'];
    $sql = "update smets set  `name` = '$smetaName',`id_zakazchik`='$id_zakazchik', `id_podryadchik`='$id_podryadchik', `date_nach_rab`='$dateNachRab', `date_okonch_rab`='$dateOkonchRab', textAreaNaimRabot = '$textAreaNaimRabot', textAreaCel = '$textAreaCel', textAreaMestoObj = '$textAreaMestoObj' , 
                  selectedZakazchik = '$selectedZakazchik', 
                  selectedPodryadchik = '$selectedPodryadchik', 
                  selectedIziskom = '$selectedIziskom', 
                  selectedVskrytie = '$selectedVskrytie', 
                  selectedKonkursnoe = '$selectedKonkursnoe', 
                  summa = '$summa'
            where id_smeta = '$id'";
    mysqli_query($connectionDB->con, $sql)  or mysqli_error($connectionDB->con);

    $sql = "UPDATE haract_object SET
                         radio_zdanie = '$hardZdanie',
    zdanie = '$zdanie',
    type_zdanie = '$typeZdanie',
    stage = '$stage',
    height = '$height',
    obem = '$obem',
    height_pol = '$height_pol',
    temperature = '$temperature',
    nasishenost = '$nasishenost',
    aggresive_vozdeistvie = '$aggresive_vozdeistvie',
    checkb1 = '$checkb1',
    checkb2 = '$checkb2',
    checkb3 = '$checkb3',
    checkb4 = '$checkb4',
    checkb5 = '$checkb5',
    checkb6 = '$checkb6',
    checkb7 = '$checkb7',
    checkb8 = '$checkb8',
    checkb9 = '$checkb9',
    checkb10 = '$checkb10',
    checkb11 = '$checkb11',
    checkb12 = '$checkb12'
WHERE id_smeta = '$id'";

    mysqli_query($connectionDB->con, $sql)  or mysqli_error($connectionDB->con);


    $sql = "UPDATE sbor_ishod_value SET
    sborCheck = '" . $ishod['sborCheck'] . "',
    toggleZd1 = '" . $ishod['toggleZd1'] . "',
    toggleZd2 = '" . $ishod['toggleZd2'] . "',
    toggleZd3 = '" . $ishod['toggleZd3'] . "',
    toggleZd4 = '" . $ishod['toggleZd4'] . "',
    toggleZd5 = '" . $ishod['toggleZd5'] . "',
    toggleZd6 = '" . $ishod['toggleZd6'] . "',
    toggleZd7 = '" . $ishod['toggleZd7'] . "',
    toggleZd8 = '" . $ishod['toggleZd8'] . "',
    toggleZd9 = '" . $ishod['toggleZd9'] . "',
    conval1 = '" . $ishod['conval1'] . "',
    conval2 = '" . $ishod['conval2'] . "',
    conval3 = '" . $ishod['conval3'] . "',
    conval4 = '" . $ishod['conval4'] . "',
    conval5 = '" . $ishod['conval5'] . "',
    conval6 = '" . $ishod['conval6'] . "',
    conval7 = '" . $ishod['conval7'] . "',
    conval8 = '" . $ishod['conval8'] . "',
    conval9 = '" . $ishod['conval9'] . "',
    choosCunstruct = '" . $ishod['choosCunstruct'] . "',
    pasport_na_zdanie = '$selectedButrad'
WHERE id_smeta = '$id'";
    mysqli_query($connectionDB->con, $sql)  or mysqli_error($connectionDB->con);


    $sql = "UPDATE obmernie_raboty SET
    obmerobs = '$obmerobs',
    obmerCheck = '$obmerCheck',
      toggleZd41 = '" . $toggleZd41 . "',
    toggleZd42 = '" . $toggleZd42 . "',
    toggleZd43 = '" . $toggleZd43 . "',
    toggleZd44 = '" . $toggleZd44 . "',
    toggleZd45 = '" . $toggleZd45 . "',
    toggleZd46 = '" . $toggleZd46 . "',
    toggleZd48 = '" . $toggleZd48 . "',
    toggleZd49 = '" . $toggleZd49 . "',
    toggleZd449 = '" . $toggleZd449 . "',
    conval41 = '" . $conval41 . "',
    conval42 = '" . $conval42 . "',
    conval43 = '" . $conval43 . "',
    conval44 = '" . $conval44 . "',
    conval45 = '" . $conval45 . "',
    conval46 = '" . $conval46 . "',
    conval48 = '" . $conval48 . "',
    conval49 = '" . $conval49 . "',
    conval449 = '" . $conval449 . "',
    choosCunstruct4 = '" . $choosCunstruct4 . "'
WHERE id_smeta = '$id'";

    mysqli_query($connectionDB->con, $sql)  or mysqli_error($connectionDB->con);

    $sql = "UPDATE obsled_raboty SET
    predvOsmotr = '" . $obsledobs . "',
    obsledCheck = '" . $obsledCheck . "',
      toggleZd51 = '" . $toggleZd51 . "',
    toggleZd52 = '" . $toggleZd52 . "',
    toggleZd53 = '" . $toggleZd53 . "',
    toggleZd54 = '" . $toggleZd54 . "',
    toggleZd55 = '" . $toggleZd55 . "',
    toggleZd56 = '" . $toggleZd56 . "',
    toggleZd57 = '" . $toggleZd57 . "',
    toggleZd58 = '" . $toggleZd58 . "',
    toggleZd59 = '" . $toggleZd59 . "',
    conval51 = '" . $conval51 . "',
    conval52 = '" . $conval52 . "',
    conval53 = '" . $conval53 . "',
    conval54 = '" . $conval54 . "',
    conval55 = '" . $conval55 . "',
    conval56 = '" . $conval56 . "',
    conval57 = '" . $conval57 . "',
    conval58 = '" . $conval58 . "',
    conval59 = '" . $conval59 . "',
    choosCunstruct5 = '" . $choosCunstruct5 . "'
WHERE id_smeta = '$id'";

    mysqli_query($connectionDB->con, $sql)  or mysqli_error($connectionDB->con);

    $sql = "UPDATE sost_tech_otchet SET
    zaklSostStr = '$zaklSostStr',
    sostTechOtchetCheck = '$sostTechOtchetCheck',
      toggleZd61 = '" . $toggleZd61 . "',
    toggleZd62 = '" . $toggleZd62 . "',
    toggleZd63 = '" . $toggleZd63 . "',
    toggleZd64 = '" . $toggleZd64 . "',
    toggleZd65 = '" . $toggleZd65 . "',
    toggleZd66 = '" . $toggleZd66 . "',
    toggleZd67 = '" . $toggleZd67 . "',
    toggleZd68 = '" . $toggleZd68 . "',
    toggleZd69 = '" . $toggleZd69 . "',
    conval61 = '" . $conval61 . "',
    conval62 = '" . $conval62 . "',
    conval63 = '" . $conval63 . "',
    conval64 = '" . $conval64 . "',
    conval65 = '" . $conval65 . "',
    conval66 = '" . $conval66 . "',
    conval67 = '" . $conval67 . "',
    conval68 = '" . $conval68 . "',
    conval69 = '" . $conval69 . "',
    choosCunstruct6 = '" . $choosCunstruct6 . "'
WHERE id_smeta = '$id'";

    mysqli_query($connectionDB->con, $sql)  or mysqli_error($connectionDB->con);


    $sql = "UPDATE redaktor SET
      redaktorIspConstrCheck = '" . $redaktorIspConstrCheck . "',
      toggleZd71 = '" . $toggleZd71 . "',
    toggleZd72 = '" . $toggleZd72 . "',
    toggleZd73 = '" . $toggleZd73 . "',
    toggleZd74 = '" . $toggleZd74 . "',
    conval71 = '" . $conval71 . "',
    conval72 = '" . $conval72 . "',
    conval73 = '" . $conval73 . "',
    conval74 = '" . $conval74 . "'
WHERE id_smeta = '$id'";

    mysqli_query($connectionDB->con, $sql)  or mysqli_error($connectionDB->con);

    $sql = "UPDATE obsled_otdel_constr SET
    obsledotdelCheck = '" . $obsledotdelCheck . "',
    toggleZd81 = '" . $toggleZd81 . "',
    toggleZd82 = '" . $toggleZd82 . "',
    toggleZd83 = '" . $toggleZd83 . "',
    toggleZd84 = '" . $toggleZd84 . "',
    toggleZd85 = '" . $toggleZd85 . "',
    toggleZd86 = '" . $toggleZd86 . "',
    toggleZd87 = '" . $toggleZd87 . "',
    toggleZd88 = '" . $toggleZd88 . "',
    toggleZd89 = '" . $toggleZd89 . "',
    toggleZd081 = '" . $toggleZd081 . "',
    toggleZd082 = '" . $toggleZd082 . "',
    toggleZd083 = '" . $toggleZd083 . "',
    toggleZd084 = '" . $toggleZd084 . "',
    toggleZd085 = '" . $toggleZd085 . "',
    toggleZd086 = '" . $toggleZd086 . "',
    toggleZd087 = '" . $toggleZd087 . "',
    toggleZd088 = '" . $toggleZd088 . "',
    toggleZd089 = '" . $toggleZd089 . "',
    toggleZd0081 = '" . $toggleZd0081 . "',
    toggleZd0082 = '" . $toggleZd0082 . "',
    toggleZd0083 = '" . $toggleZd0083 . "',
    conval81 = '" . $conval81 . "',
    conval811 = '" . $conval811 . "',
    conval82 = '" . $conval82 . "',
    conval822 = '" . $conval822 . "',
    conval83 = '" . $conval83 . "',
    conval833 = '" . $conval833 . "',
    conval84 = '" . $conval84 . "',
    conval844 = '" . $conval844 . "',
    conval85 = '" . $conval85 . "',
    conval855 = '" . $conval855 . "',
    conval86 = '" . $conval86 . "',
    conval866 = '" . $conval866 . "',
    conval87 = '" . $conval87 . "',
    conval877 = '" . $conval877 . "',
    conval88 = '" . $conval88 . "',
    conval888 = '" . $conval888 . "',
    conval89 = '" . $conval89 . "',
    conval899 = '" . $conval899 . "',
    conval081 = '" . $conval081 . "',
    conval0811 = '" . $conval0811 . "',
    conval082 = '" . $conval082 . "',
    conval0822 = '" . $conval0822 . "',
    conval083 = '" . $conval083 . "',
    conval0833 = '" . $conval0833 . "',
    conval084 = '" . $conval084 . "',
    conval0844 = '" . $conval0844 . "',
    conval085 = '" . $conval085 . "',
    conval0855 = '" . $conval0855 . "',
    conval086 = '" . $conval086 . "',
    conval0866 = '" . $conval0866 . "',
    conval087 = '" . $conval087 . "',
    conval0877 = '" . $conval0877 . "',
    conval088 = '" . $conval088 . "',
    conval0888 = '" . $conval0888 . "',
    conval089 = '" . $conval089 . "',
    conval0899 = '" . $conval0899 . "',
    conval0081 = '" . $conval0081 . "',
    conval00811 = '" . $conval00811 . "',
    conval0082 = '" . $conval0082 . "',
    conval00822 = '" . $conval00822 . "',
    conval0083 = '" . $conval0083 . "',
    conval00833 = '" . $conval00833 . "',
    monolit1 = '" . $monolit1 . "',
    monolit2 = '" . $monolit2 . "',
    monolit3 = '" . $monolit3 . "',
    monolit4 = '" . $monolit4 . "',
    monolit5 = '" . $monolit5 . "',
    monolit6 = '" . $monolit6 . "',
    monolit7 = '" . $monolit7 . "',
    monolit8 = '" . $monolit8 . "',
    monolit9 = '" . $monolit9 . "',
    monolit10 = '" . $monolit10 . "',
    monolit11 = '" . $monolit11 . "',
    monolit12 = '" . $monolit12 . "',
    monolit13 = '" . $monolit13 . "',
    monolit14 = '" . $monolit14 . "',
    monolit15 = '" . $monolit15 . "',
    monolit16 = '" . $monolit16 . "',
    monolit17 = '" . $monolit17 . "',
    monolit18 = '" . $monolit18 . "',
    monolit19 = '" . $monolit19 . "',
    monolit20 = '" . $monolit20 . "',
    monolit21 = '" . $monolit21 . "'
WHERE id_smeta = '$id'";

    mysqli_query($connectionDB->con, $sql)  or mysqli_error($connectionDB->con);


    $sql = "UPDATE calculation SET
    calcalcCheck = '" . $calcalcCheck . "',
    selectCalc1 = '" . $selectCalc1 . "',
    selectCalc2 = '" . $selectCalc2 . "',
    selectCalc3 = '" . $selectCalc3 . "',
    selectCalc4 = '" . $selectCalc4 . "',
    selectCalc5 = '" . $selectCalc5 . "',
    selectCalc6 = '" . $selectCalc6 . "',
    selectCalc7 = '" . $selectCalc7 . "',
    selectCalc8 = '" . $selectCalc8 . "',
    inputCalc1 = '" . $inputCalc1 . "',
    inputCalc2 = '" . $inputCalc2 . "',
    inputCalc3 = '" . $inputCalc3 . "',
    inputCalc4 = '" . $inputCalc4 . "',
    inputCalc5 = '" . $inputCalc5 . "',
    inputCalc6 = '" . $inputCalc6 . "',
    inputCalc7 = '" . $inputCalc7 . "',
    inputCalc8 = '" . $inputCalc8 . "',
    select2Calc1 = '" . $select2Calc1 . "',
    select2Calc2 = '" . $select2Calc2 . "',
    select2Calc3 = '" . $select2Calc3 . "',
    select2Calc4 = '" . $select2Calc4 . "',
    select2Calc5 = '" . $select2Calc5 . "',
    select2Calc6 = '" . $select2Calc6 . "',
    select2Calc7 = '" . $select2Calc7 . "',
    select2Calc8 = '" . $select2Calc8 . "',
    input2Calc1 = '" . $input2Calc1 . "',
    input2Calc2 = '" . $input2Calc2 . "',
    input2Calc3 = '" . $input2Calc3 . "',
    input2Calc4 = '" . $input2Calc4 . "',
    input2Calc5 = '" . $input2Calc5 . "',
    input2Calc6 = '" . $input2Calc6 . "',
    input2Calc7 = '" . $input2Calc7 . "',
    input2Calc8 = '" . $input2Calc8 . "',
    input3Calc1 = '" . $input3Calc1 . "',
    input3Calc2 = '" . $input3Calc2 . "',
    input3Calc3 = '" . $input3Calc3 . "',
    input3Calc4 = '" . $input3Calc4 . "',
    input3Calc5 = '" . $input3Calc5 . "',
    input3Calc6 = '" . $input3Calc6 . "',
    input3Calc7 = '" . $input3Calc7 . "',
    input3Calc8 = '" . $input3Calc8 . "'
WHERE id_smeta = '$id'";

    mysqli_query($connectionDB->con, $sql)  or mysqli_error($connectionDB->con);

    echo $id;

} else {
    $sql = "INSERT INTO smets (`name`, `id_zakazchik`, `id_podryadchik`, `date_nach_rab`, `date_okonch_rab`, textAreaNaimRabot, textAreaCel, textAreaMestoObj, selectedZakazchik, selectedPodryadchik, selectedIziskom, selectedVskrytie, selectedKonkursnoe,  summa) VALUES ('$smetaName', '$id_zakazchik', '$id_podryadchik', '$dateNachRab', '$dateOkonchRab' , '$textAreaNaimRabot', '$textAreaCel', '$textAreaMestoObj' ,'$selectedZakazchik', '$selectedPodryadchik', '$selectedIziskom', '$selectedVskrytie', '$selectedKonkursnoe','$summa')";
    if (mysqli_query($connectionDB->con, $sql)) {
        $insertedId = mysqli_insert_id($connectionDB->con);

        $sql = "INSERT INTO haract_object (
    radio_zdanie ,
    zdanie, 
    type_zdanie, 
    stage, 
    height, 
    obem, 
    height_pol, 
    temperature, 
    nasishenost, 
    aggresive_vozdeistvie, 
    checkb1, 
    checkb2, 
    checkb3, 
    checkb4, 
    checkb5, 
    checkb6, 
    checkb7, 
    checkb8, 
    checkb9, 
    checkb10, 
    checkb11, 
    checkb12,
    id_smeta
) VALUES (
    '$hardZdanie',
    '$zdanie',
    '$typeZdanie',
    '$stage',
    '$height',
    '$obem',
    '$height_pol',
    '$temperature',
    '$nasishenost',
    '$aggresive_vozdeistvie',
    '$checkb1',
    '$checkb2',
    '$checkb3',
    '$checkb4',
    '$checkb5',
    '$checkb6',
    '$checkb7',
    '$checkb8',
    '$checkb9',
    '$checkb10',
    '$checkb11',
    '$checkb12',
    '$insertedId'
)";
        mysqli_query($connectionDB->con, $sql)  or mysqli_error($connectionDB->con);


        $sql = "INSERT INTO sbor_ishod_value (
    sborCheck,
    toggleZd1,
    toggleZd2,
    toggleZd3,
    toggleZd4,
    toggleZd5,
    toggleZd6,
    toggleZd7,
    toggleZd8,
    toggleZd9,
    conval1,
    conval2,
    conval3,
    conval4,
    conval5,
    conval6,
    conval7,
    conval8,
    conval9,
    id_smeta,
    choosCunstruct,
    pasport_na_zdanie
) VALUES (
    '{$ishod['sborCheck']}',
    '{$ishod['toggleZd1']}',
    '{$ishod['toggleZd2']}',
    '{$ishod['toggleZd3']}',
    '{$ishod['toggleZd4']}',
    '{$ishod['toggleZd5']}',
    '{$ishod['toggleZd6']}',
    '{$ishod['toggleZd7']}',
    '{$ishod['toggleZd8']}',
    '{$ishod['toggleZd9']}',
    '{$ishod['conval1']}',
    '{$ishod['conval2']}',
    '{$ishod['conval3']}',
    '{$ishod['conval4']}',
    '{$ishod['conval5']}',
    '{$ishod['conval6']}',
    '{$ishod['conval7']}',
    '{$ishod['conval8']}',
    '{$ishod['conval9']}',
    '$insertedId',
    '{$ishod['choosCunstruct']}',
    '{$selectedButrad}'
)";

        mysqli_query($connectionDB->con, $sql)   or mysqli_error($connectionDB->con);

        $sql = "INSERT INTO obmernie_raboty (
    obmerobs,
    obmerCheck,
    toggleZd41,
    toggleZd42,
    toggleZd43,
    toggleZd44,
    toggleZd45,
    toggleZd46,
    toggleZd48,
    toggleZd49,
    toggleZd449,
    conval41,
    conval42,
    conval43,
    conval44,
    conval45,
    conval46,
    conval48,
    conval49,
    conval449,
    id_smeta,
    choosCunstruct4
) VALUES (
    '{$obmerobs}',
    '{$obmerCheck}',
    '{$toggleZd41}',
    '{$toggleZd42}',
    '{$toggleZd43}',
    '{$toggleZd44}',
    '{$toggleZd45}',
    '{$toggleZd46}',
    '{$toggleZd48}',
    '{$toggleZd49}',
    '{$toggleZd449}',
    '{$conval41}',
    '{$conval42}',
    '{$conval43}',
    '{$conval44}',
    '{$conval45}',
    '{$conval46}',
    '{$conval48}',
    '{$conval49}',
    '{$conval449}',
    '$insertedId',
    '{$choosCunstruct4}'
)";

        mysqli_query($connectionDB->con, $sql)  or mysqli_error($connectionDB->con);

        $sql = "INSERT INTO obsled_raboty (
    predvOsmotr,
    obsledCheck,
    toggleZd51,
    toggleZd52,
    toggleZd53,
    toggleZd54,
    toggleZd55,
    toggleZd56,
    toggleZd57,
    toggleZd58,
    toggleZd59,
    conval51,
    conval52,
    conval53,
    conval54,
    conval55,
    conval56,
    conval57,
    conval58,
    conval59,
    id_smeta,
    choosCunstruct5
) VALUES (
    '{$obsledobs}',
    '{$obsledCheck}',
    '{$toggleZd51}',
    '{$toggleZd52}',
    '{$toggleZd53}',
           '{$toggleZd54}',
           '{$toggleZd55}',
           '{$toggleZd56}',
           '{$toggleZd57}',
           '{$toggleZd58}',
           '{$toggleZd59}',
           '{$conval51}',
           '{$conval52}',
           '{$conval53}',
           '{$conval54}',
           '{$conval55}',
           '{$conval56}',
           '{$conval57}',
           '{$conval58}',
           '{$conval59}',
           '$insertedId',
           '{$choosCunstruct5}'
)";

        mysqli_query($connectionDB->con, $sql)  or mysqli_error($connectionDB->con);

        $sql = "INSERT INTO sost_tech_otchet (
    zaklSostStr,
    sostTechOtchetCheck,
    toggleZd61,
    toggleZd62,
    toggleZd63,
    toggleZd64,
    toggleZd65,
    toggleZd66,
    toggleZd67,
    toggleZd68,
    toggleZd69,
    conval61,
    conval62,
    conval63,
    conval64,
    conval65,
    conval66,
    conval67,
    conval68,
    conval69,
    id_smeta,
    choosCunstruct6
) VALUES (
    '{$zaklSostStr}',
    '{$sostTechOtchetCheck}',
    '{$toggleZd61}',
    '{$toggleZd62}',
    '{$toggleZd63}',
           '{$toggleZd64}',
           '{$toggleZd65}',
           '{$toggleZd66}',
           '{$toggleZd67}',
           '{$toggleZd68}',
           '{$toggleZd69}',
           '{$conval61}',
           '{$conval62}',
           '{$conval63}',
           '{$conval64}',
           '{$conval65}',
           '{$conval66}',
           '{$conval67}',
           '{$conval68}',
           '{$conval69}',
           '$insertedId',
           '{$choosCunstruct6}'
)";

        mysqli_query($connectionDB->con, $sql) or mysqli_error($connectionDB->con);

        $sql = "INSERT INTO redaktor (
    redaktorIspConstrCheck,
    toggleZd71,
    toggleZd72,
    toggleZd73,
    toggleZd74,
    conval71,
    conval72,
    conval73,
    conval74,
    id_smeta
) VALUES (
    '{$redaktorIspConstrCheck}',
    '{$toggleZd71}',
    '{$toggleZd72}',
    '{$toggleZd73}',
           '{$toggleZd74}',
           '{$conval71}',
           '{$conval72}',
           '{$conval73}',
           '{$conval74}',
           '$insertedId'
)";

        mysqli_query($connectionDB->con, $sql) or mysqli_error($connectionDB->con);


        $sql = "INSERT INTO obsled_otdel_constr (
    obsledotdelCheck,
    toggleZd81,
    toggleZd82,
    toggleZd83,
    toggleZd84,
    toggleZd85,
    toggleZd86,
    toggleZd87,
    toggleZd88,
    toggleZd89,
    toggleZd081,
    toggleZd082,
    toggleZd083,
    toggleZd084,
    toggleZd085,
    toggleZd086,
    toggleZd087,
    toggleZd088,
    toggleZd089,
    toggleZd0081,
    toggleZd0082,
    toggleZd0083,
    conval81,
    conval811,
    conval82,
    conval822,
    conval83,
    conval833,
    conval84,
    conval844,
    conval85,
    conval855,
    conval86,
    conval866,
    conval87,
    conval877,
    conval88,
    conval888,
    conval89,
    conval899,
    conval081,
    conval0811,
    conval082,
    conval0822,
    conval083,
    conval0833,
    conval084,
    conval0844,
    conval085,
    conval0855,
    conval086,
    conval0866,
    conval087,
    conval0877,
    conval088,
    conval0888,
    conval089,
    conval0899,
    conval0081,
    conval00811,
    conval0082,
    conval00822,
    conval0083,
    conval00833,
    monolit1,
    monolit2,
    monolit3,
    monolit4,
    monolit5,
    monolit6,
    monolit7,
    monolit8,
    monolit9,
    monolit10,
    monolit11,
    monolit12,
    monolit13,
    monolit14,
    monolit15,
    monolit16,
    monolit17,
    monolit18,
    monolit19,
    monolit20,
    monolit21,
    id_smeta
) VALUES (
    '{$obsledotdelCheck}',
    '{$toggleZd81}',
    '{$toggleZd82}',
    '{$toggleZd83}',
    '{$toggleZd84}',
    '{$toggleZd85}',
    '{$toggleZd86}',
    '{$toggleZd87}',
    '{$toggleZd88}',
    '{$toggleZd89}',
    '{$toggleZd081}',
    '{$toggleZd082}',
    '{$toggleZd083}',
    '{$toggleZd084}',
    '{$toggleZd085}',
    '{$toggleZd086}',
    '{$toggleZd087}',
    '{$toggleZd088}',
    '{$toggleZd089}',
    '{$toggleZd0081}',
    '{$toggleZd0082}',
    '{$toggleZd0083}',
    '{$conval81}',
    '{$conval811}',
    '{$conval82}',
    '{$conval822}',
    '{$conval83}',
    '{$conval833}',
    '{$conval84}',
    '{$conval844}',
    '{$conval85}',
    '{$conval855}',
    '{$conval86}',
    '{$conval866}',
    '{$conval87}',
    '{$conval877}',
    '{$conval88}',
    '{$conval888}',
    '{$conval89}',
    '{$conval899}',
    '{$conval081}',
    '{$conval0811}',
    '{$conval082}',
    '{$conval0822}',
    '{$conval083}',
    '{$conval0833}',
    '{$conval084}',
    '{$conval0844}',
    '{$conval085}',
    '{$conval0855}',
    '{$conval086}',
    '{$conval0866}',
    '{$conval087}',
    '{$conval0877}',
    '{$conval088}',
    '{$conval0888}',
    '{$conval089}',
    '{$conval0899}',
    '{$conval0081}',
    '{$conval00811}',
    '{$conval0082}',
    '{$conval00822}',
    '{$conval0083}',
    '{$conval00833}',
    '{$monolit1}',
    '{$monolit2}',
    '{$monolit3}',
    '{$monolit4}',
    '{$monolit5}',
    '{$monolit6}',
    '{$monolit7}',
    '{$monolit8}',
    '{$monolit9}',
    '{$monolit10}',
    '{$monolit11}',
    '{$monolit12}',
    '{$monolit13}',
    '{$monolit14}',
    '{$monolit15}',
    '{$monolit16}',
    '{$monolit17}',
    '{$monolit18}',
    '{$monolit19}',
    '{$monolit20}',
    '{$monolit21}',
    '$insertedId'
)";

        mysqli_query($connectionDB->con, $sql) or mysqli_error($connectionDB->con);

        $sql = "INSERT INTO calculation (
    calcalcCheck,
    selectCalc1,
    selectCalc2,
    selectCalc3,
    selectCalc4,
    selectCalc5,
    selectCalc6,
    selectCalc7,
    selectCalc8,
    inputCalc1,
    inputCalc2,
    inputCalc3,
    inputCalc4,
    inputCalc5,
    inputCalc6,
    inputCalc7,
    inputCalc8,
    select2Calc1,
    select2Calc2,
    select2Calc3,
    select2Calc4,
    select2Calc5,
    select2Calc6,
    select2Calc7,
    select2Calc8,
    input2Calc1,
    input2Calc2,
    input2Calc3,
    input2Calc4,
    input2Calc5,
    input2Calc6,
    input2Calc7,
    input2Calc8,
    input3Calc1,
    input3Calc2,
    input3Calc3,
    input3Calc4,
    input3Calc5,
    input3Calc6,
    input3Calc7,
    input3Calc8,
    id_smeta
) VALUES (
    '{$calcalcCheck}',
    '{$selectCalc1}',
    '{$selectCalc2}',
    '{$selectCalc3}',
    '{$selectCalc4}',
    '{$selectCalc5}',
    '{$selectCalc6}',
    '{$selectCalc7}',
    '{$selectCalc8}',
    '{$inputCalc1}',
    '{$inputCalc2}',
    '{$inputCalc3}',
    '{$inputCalc4}',
    '{$inputCalc5}',
    '{$inputCalc6}',
    '{$inputCalc7}',
    '{$inputCalc8}',
    '{$select2Calc1}',
    '{$select2Calc2}',
    '{$select2Calc3}',
    '{$select2Calc4}',
    '{$select2Calc5}',
    '{$select2Calc6}',
    '{$select2Calc7}',
    '{$select2Calc8}',
    '{$input2Calc1}',
    '{$input2Calc2}',
    '{$input2Calc3}',
    '{$input2Calc4}',
    '{$input2Calc5}',
    '{$input2Calc6}',
    '{$input2Calc7}',
    '{$input2Calc8}',
    '{$input3Calc1}',
    '{$input3Calc2}',
    '{$input3Calc3}',
    '{$input3Calc4}',
    '{$input3Calc5}',
    '{$input3Calc6}',
    '{$input3Calc7}',
    '{$input3Calc8}',
    '$insertedId'
)";

        mysqli_query($connectionDB->con, $sql) or mysqli_error($connectionDB->con);
    }
    echo $insertedId;

}
