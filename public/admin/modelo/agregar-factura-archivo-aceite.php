<?php
require ('../../../app/help.php');

$aleatorio = uniqid();
$Factura = $_FILES['Factura_file']['name'];


if ($Factura != "") {
    $upload_Factura = "../../../archivos/aceites-facturas/" . $aleatorio . "-" . $Factura;
    $DocumentoFactura = $aleatorio . "-" . $Factura;
    move_uploaded_file($_FILES['Factura_file']['tmp_name'], $upload_Factura);
} else {
    $upload_Factura = "";
    $DocumentoFactura = "";
}

$year = $_POST['year'];
$mes = $_POST['mes'];
$mes_formateado = sprintf("%02d", $mes);

$fecha_20 = date("$year-$mes_formateado-20");
$fecha_25 = date("$year-$mes_formateado-25");
$fecha_28 = date("$year-$mes_formateado-28");

$fecha_actual = date("Y-m-d");

if ($fecha_actual <= $fecha_20) {
    $puntaje = 3;

} else if ($fecha_actual > $fecha_20 && $fecha_actual <= $fecha_25) {
    $puntaje = 2;

} else if ($fecha_actual > $fecha_25 && $fecha_actual <= $fecha_28) {
    $puntaje = 1;

} else {
    $puntaje = 0;

}

$sql_insert = "INSERT INTO op_aceites_factura (
    id_mes,
    fecha,
    nombre_anexo,
    archivo,
    fecha_evaluacion,
    puntaje
    )
    VALUES 
    (
    '" . $_POST['IdReporte'] . "',
    '" . $_POST['fechaAceite'] . "',
    '" . $_POST['conceptoAceite'] . "',
    '" . $DocumentoFactura . "',
    '" . $fecha_actual . "',
    '" . $puntaje . "'   
    )";



if (mysqli_query($con, $sql_insert)) {
    echo 1;

} else {
    echo 0;

}


//------------------
mysqli_close($con);
//------------------
?>