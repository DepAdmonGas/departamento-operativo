<?php
require('../../../app/help.php');

$idReporte = $_POST['idReporte'];
$aleatorio = uniqid();

$Nombre1 = $Nombre2 = $Nombre3 = $Nombre4 = ""; // Inicializar las variables

if (isset($_FILES['CartaCredito_file']) && $_FILES['CartaCredito_file']['error'] == UPLOAD_ERR_OK) {
    $Doc1 = $_FILES['CartaCredito_file']['name'];
    $Folder1 = "../../../archivos/" . $aleatorio . "-" . $Doc1;
    if (move_uploaded_file($_FILES['CartaCredito_file']['tmp_name'], $Folder1)) {
        $Nombre1 = $aleatorio . "-" . $Doc1;
    }
}

if (isset($_FILES['ActaConstitutiva_file']) && $_FILES['ActaConstitutiva_file']['error'] == UPLOAD_ERR_OK) {
    $Doc2 = $_FILES['ActaConstitutiva_file']['name'];
    $Folder2 = "../../../archivos/" . $aleatorio . "-" . $Doc2;
    if (move_uploaded_file($_FILES['ActaConstitutiva_file']['tmp_name'], $Folder2)) {
        $Nombre2 = $aleatorio . "-" . $Doc2;
    }
}

if (isset($_FILES['ComprobanteDom_file']) && $_FILES['ComprobanteDom_file']['error'] == UPLOAD_ERR_OK) {
    $Doc3 = $_FILES['ComprobanteDom_file']['name'];
    $Folder3 = "../../../archivos/" . $aleatorio . "-" . $Doc3;
    if (move_uploaded_file($_FILES['ComprobanteDom_file']['tmp_name'], $Folder3)) {
        $Nombre3 = $aleatorio . "-" . $Doc3;
    }
}

if (isset($_FILES['Identificacion_file']) && $_FILES['Identificacion_file']['error'] == UPLOAD_ERR_OK) {
    $Doc4 = $_FILES['Identificacion_file']['name'];
    $Folder4 = "../../../archivos/" . $aleatorio . "-" . $Doc4;
    if (move_uploaded_file($_FILES['Identificacion_file']['tmp_name'], $Folder4)) {
        $Nombre4 = $aleatorio . "-" . $Doc4;
    }
}

function IdEstacion($idReporte, $con) {
    $idEstacion = 0;
    $sql_credito = "SELECT
        op_consumos_pagos.id,
        op_consumos_pagos.id_reportedia,
        op_consumos_pagos.id_cliente,
        op_consumos_pagos.total,
        op_consumos_pagos.tipo AS ConsumoTipo,
        op_consumos_pagos.pago,
        op_consumos_pagos.comprobante,
        op_cliente.id_estacion,
        op_cliente.cuenta,
        op_cliente.cliente,
        op_cliente.tipo
    FROM op_consumos_pagos 
    INNER JOIN op_cliente
    ON op_consumos_pagos.id_cliente = op_cliente.id
    WHERE op_consumos_pagos.id_reportedia = '".$idReporte."' LIMIT 1 ";
    $result_credito = mysqli_query($con, $sql_credito);
    $numero_credito = mysqli_num_rows($result_credito); 
    while($row_credito = mysqli_fetch_array($result_credito, MYSQLI_ASSOC)){
        $idEstacion = $row_credito['id_estacion'];  
    }

    return $idEstacion;
}

$idEstacion = IdEstacion($idReporte, $con);

$sql_insert = "INSERT INTO op_cliente (
    id_estacion,
    cuenta,
    cliente,
    tipo,
    rfc,
    doc_cc,
    doc_ac,
    doc_cd,
    doc_io,
    estado
    )
    VALUES 
    (
    '".$idEstacion."',
    '".$_POST['Cuenta']."',
    '".$_POST['Cliente']."',
    '".$_POST['Tipo']."',
    '".$_POST['RFC']."',
    '".$Nombre1."',
    '".$Nombre2."',
    '".$Nombre3."',
    '".$Nombre4."',
    1
    )";

if (mysqli_query($con, $sql_insert)) {
    echo 1;
} else {
    echo 0;
}

//------------------
mysqli_close($con);
//------------------
