<?php
require '../../../../help.php';

$idReporte = $_GET['idReporte'];

$sqlP1 = "SELECT * FROM op_ingresos_facturacion_contabilidad WHERE id_year = '" . $idReporte . "' AND posicion = 1";
$resultP1 = mysqli_query($con, $sqlP1);
$numeroP1 = mysqli_num_rows($resultP1);

$sqlP2 = "SELECT * FROM op_ingresos_facturacion_contabilidad WHERE id_year = '" . $idReporte . "' AND posicion = 2";
$resultP2 = mysqli_query($con, $sqlP2);
$numeroP2 = mysqli_num_rows($resultP2);
$TCE1 = 0;
    $TCF1 = 0;
    $TCM1 = 0;
    $TCA1 = 0;
    $TCMY1 = 0;
    $TCJN1 = 0;
    $TCJL1 = 0;
    $TCAS1 = 0;
    $TCS1 = 0;
    $TCO1 = 0;
    $TCN1 = 0;
    $TCD1 = 0;

    $TCTEJ1 = 0;

while ($rowP1 = mysqli_fetch_array($resultP1, MYSQLI_ASSOC)) {
    $id = $rowP1['id'];

    if ($rowP1['enero'] == 0) {
        $enero1 = "";
    } else {
        $enero1 = $rowP1['enero'];
    }

    if ($rowP1['febrero'] == 0) {
        $febrero1 = "";
    } else {
        $febrero1 = $rowP1['febrero'];
    }

    if ($rowP1['marzo'] == 0) {
        $marzo1 = "";
    } else {
        $marzo1 = $rowP1['marzo'];
    }

    if ($rowP1['abril'] == 0) {
        $abril1 = "";
    } else {
        $abril1 = $rowP1['abril'];
    }

    if ($rowP1['mayo'] == 0) {
        $mayo1 = "";
    } else {
        $mayo1 = $rowP1['mayo'];
    }

    if ($rowP1['junio'] == 0) {
        $junio1 = "";
    } else {
        $junio1 = $rowP1['junio'];
    }

    if ($rowP1['julio'] == 0) {
        $julio1 = "";
    } else {
        $julio1 = $rowP1['julio'];
    }

    if ($rowP1['agosto'] == 0) {
        $agosto1 = "";
    } else {
        $agosto1 = $rowP1['agosto'];
    }

    if ($rowP1['septiembre'] == 0) {
        $septiembre1 = "";
    } else {
        $septiembre1 = $rowP1['septiembre'];
    }

    if ($rowP1['octubre'] == 0) {
        $octubre1 = "";
    } else {
        $octubre1 = $rowP1['octubre'];
    }

    if ($rowP1['noviembre'] == 0) {
        $noviembre1 = "";
    } else {
        $noviembre1 = $rowP1['noviembre'];
    }

    if ($rowP1['diciembre'] == 0) {
        $diciembre1 = "";
    } else {
        $diciembre1 = $rowP1['diciembre'];
    }


    $totalEj1 = $rowP1['enero'] + $rowP1['febrero'] + $rowP1['marzo'] + $rowP1['abril'] + $rowP1['mayo'] + $rowP1['junio'] + $rowP1['julio'] + $rowP1['agosto'] + $rowP1['septiembre'] + $rowP1['octubre'] + $rowP1['noviembre'] + $rowP1['diciembre'];

    $TCE1 = $TCE1 + $rowP1['enero'];
    $TCF1 = $TCF1 + $rowP1['febrero'];
    $TCM1 = $TCM1 + $rowP1['marzo'];
    $TCA1 = $TCA1 + $rowP1['abril'];
    $TCMY1 = $TCMY1 + $rowP1['mayo'];
    $TCJN1 = $TCJN1 + $rowP1['junio'];
    $TCJL1 = $TCJL1 + $rowP1['julio'];
    $TCAS1 = $TCAS1 + $rowP1['agosto'];
    $TCS1 = $TCS1 + $rowP1['septiembre'];
    $TCO1 = $TCO1 + $rowP1['octubre'];
    $TCN1 = $TCN1 + $rowP1['noviembre'];
    $TCD1 = $TCD1 + $rowP1['diciembre'];

    $TCTEJ1 = $TCTEJ1 + $totalEj1;

}
$TCE2 = 0;
    $TCF2 = 0;
    $TCM2 = 0;
    $TCA2 = 0;
    $TCMY2 = 0;
    $TCJN2 = 0;
    $TCJL2 = 0;
    $TCAS2 = 0;
    $TCS2 = 0;
    $TCO2 = 0;
    $TCN2 = 0;
    $TCD2 = 0;

    $TCTEJ2 =0;
while ($rowP2 = mysqli_fetch_array($resultP2, MYSQLI_ASSOC)) {
    $id = $rowP2['id'];

    if ($rowP2['enero'] == 0) {
        $enero2 = "";
    } else {
        $enero2 = $rowP2['enero'];
    }

    if ($rowP2['febrero'] == 0) {
        $febrero2 = "";
    } else {
        $febrero2 = $rowP2['febrero'];
    }

    if ($rowP2['marzo'] == 0) {
        $marzo2 = "";
    } else {
        $marzo2 = $rowP2['marzo'];
    }

    if ($rowP2['abril'] == 0) {
        $abril2 = "";
    } else {
        $abril2 = $rowP2['abril'];
    }

    if ($rowP2['mayo'] == 0) {
        $mayo2 = "";
    } else {
        $mayo2 = $rowP2['mayo'];
    }

    if ($rowP2['junio'] == 0) {
        $junio2 = "";
    } else {
        $junio2 = $rowP2['junio'];
    }

    if ($rowP2['julio'] == 0) {
        $julio2 = "";
    } else {
        $julio2 = $rowP2['julio'];
    }

    if ($rowP2['agosto'] == 0) {
        $agosto2 = "";
    } else {
        $agosto2 = $rowP2['agosto'];
    }

    if ($rowP2['septiembre'] == 0) {
        $septiembre2 = "";
    } else {
        $septiembre2 = $rowP2['septiembre'];
    }

    if ($rowP2['octubre'] == 0) {
        $octubre2 = "";
    } else {
        $octubre2 = $rowP2['octubre'];
    }

    if ($rowP2['noviembre'] == 0) {
        $noviembre2 = "";
    } else {
        $noviembre2 = $rowP2['noviembre'];
    }

    if ($rowP2['diciembre'] == 0) {
        $diciembre2 = "";
    } else {
        $diciembre2 = $rowP2['diciembre'];
    }


    $totalEj2 = $rowP2['enero'] + $rowP2['febrero'] + $rowP2['marzo'] + $rowP2['abril'] + $rowP2['mayo'] + $rowP2['junio'] + $rowP2['julio'] + $rowP2['agosto'] + $rowP2['septiembre'] + $rowP2['octubre'] + $rowP2['noviembre'] + $rowP2['diciembre'];

    $TCE2 = $TCE2 + $rowP2['enero'];
    $TCF2 = $TCF2 + $rowP2['febrero'];
    $TCM2 = $TCM2 + $rowP2['marzo'];
    $TCA2 = $TCA2 + $rowP2['abril'];
    $TCMY2 = $TCMY2 + $rowP2['mayo'];
    $TCJN2 = $TCJN2 + $rowP2['junio'];
    $TCJL2 = $TCJL2 + $rowP2['julio'];
    $TCAS2 = $TCAS2 + $rowP2['agosto'];
    $TCS2 = $TCS2 + $rowP2['septiembre'];
    $TCO2 = $TCO2 + $rowP2['octubre'];
    $TCN2 = $TCN2 + $rowP2['noviembre'];
    $TCD2 = $TCD2 + $rowP2['diciembre'];

    $TCTEJ2 = $TCTEJ2 + $totalEj2;

}

$TD1 = $TCE2 - $TCE1;
$TD2 = $TCF2 - $TCF1;
$TD3 = $TCM2 - $TCM1;
$TD4 = $TCA2 - $TCA1;
$TD5 = $TCMY2 - $TCMY1;
$TD6 = $TCJN2 - $TCJN1;
$TD7 = $TCJL2 - $TCJL1;
$TD8 = $TCAS2 - $TCAS1;
$TD9 = $TCS2 - $TCS1;
$TD10 = $TCO2 - $TCO1;
$TD11 = $TCN2 - $TCN1;
$TD12 = $TCD2 - $TCD1;
$TDTE = $TCTEJ2 - $TCTEJ1;

$Data = array();

$Data['TCE1'] = '$ ' . number_format($TCE1, 2);
$Data['TCF1'] = '$ ' . number_format($TCF1, 2);
$Data['TCM1'] = '$ ' . number_format($TCM1, 2);
$Data['TCA1'] = '$ ' . number_format($TCA1, 2);
$Data['TCMY1'] = '$ ' . number_format($TCMY1, 2);
$Data['TCJN1'] = '$ ' . number_format($TCJN1, 2);
$Data['TCJL1'] = '$ ' . number_format($TCJL1, 2);
$Data['TCAS1'] = '$ ' . number_format($TCAS1, 2);
$Data['TCS1'] = '$ ' . number_format($TCS1, 2);
$Data['TCO1'] = '$ ' . number_format($TCO1, 2);
$Data['TCN1'] = '$ ' . number_format($TCN1, 2);
$Data['TCD1'] = '$ ' . number_format($TCD1, 2);
$Data['TCTEJ1'] = '$ ' . number_format($TCTEJ1, 2);

$Data['TCE2'] = '$ ' . number_format($TCE2, 2);
$Data['TCF2'] = '$ ' . number_format($TCF2, 2);
$Data['TCM2'] = '$ ' . number_format($TCM2, 2);
$Data['TCA2'] = '$ ' . number_format($TCA2, 2);
$Data['TCMY2'] = '$ ' . number_format($TCMY2, 2);
$Data['TCJN2'] = '$ ' . number_format($TCJN2, 2);
$Data['TCJL2'] = '$ ' . number_format($TCJL2, 2);
$Data['TCAS2'] = '$ ' . number_format($TCAS2, 2);
$Data['TCS2'] = '$ ' . number_format($TCS2, 2);
$Data['TCO2'] = '$ ' . number_format($TCO2, 2);
$Data['TCN2'] = '$ ' . number_format($TCN2, 2);
$Data['TCD2'] = '$ ' . number_format($TCD2, 2);
$Data['TCTEJ2'] = '$ ' . number_format($TCTEJ2, 2);

$Data['TD1'] = '$ ' . number_format($TD1, 2);
$Data['TD2'] = '$ ' . number_format($TD2, 2);
$Data['TD3'] = '$ ' . number_format($TD3, 2);
$Data['TD4'] = '$ ' . number_format($TD4, 2);
$Data['TD5'] = '$ ' . number_format($TD5, 2);
$Data['TD6'] = '$ ' . number_format($TD6, 2);
$Data['TD7'] = '$ ' . number_format($TD7, 2);
$Data['TD8'] = '$ ' . number_format($TD8, 2);
$Data['TD9'] = '$ ' . number_format($TD9, 2);
$Data['TD10'] = '$ ' . number_format($TD10, 2);
$Data['TD11'] = '$ ' . number_format($TD11, 2);
$Data['TD12'] = '$ ' . number_format($TD12, 2);
$Data['TDTE'] = '$ ' . number_format($TDTE, 2);


echo json_encode($Data);

?>