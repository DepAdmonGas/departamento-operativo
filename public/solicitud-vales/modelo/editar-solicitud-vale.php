<?php  
require('../../../app/help.php');

$aleatorio = uniqid();
$idEstacion = $_POST['idEstacion'];
$NoDoc1  =   $_FILES['Archivo_file']['name'];
$UpDoc1 = "../../../archivos/vales/".$aleatorio."-".$NoDoc1;
$NomDoc1 = $aleatorio."-".$NoDoc1;

if ($_POST['idEstacion'] == 8) {
$Estacion = $_POST['Estacion'];
$Cuentas = $_POST['Cuentas'];
}else{
$Estacion = $_POST['idEstacion'];
$Cuentas = '';    
}

$sql_insert = "UPDATE op_solicitud_vale SET
fecha = '".$_POST['Fecha']."',
monto = '".$_POST['Monto']."',
moneda = '".$_POST['Moneda']."',
concepto = '".$_POST['Concepto']."',
solicitante = '".$_POST['Solicitante']."',

autorizado_por = '".$_POST['Autorizadopor']."',
metodo_autorizacion = '".$_POST['MetodoAutorizacion']."',

observaciones = '".$_POST['Observaciones']."',
id_estacion = '".$Estacion."',
cuenta = '".$Cuentas."'
WHERE id = '".$_POST['idReporte']."' ";


if(mysqli_query($con, $sql_insert)){

if(move_uploaded_file($_FILES['Archivo_file']['tmp_name'], $UpDoc1)){
$sql1 = "DELETE FROM op_solicitud_vale_documento WHERE id_solicitud = '".$_POST['IdReporte']."' AND nombre = 'ARCHIVO' ";
if (mysqli_query($con, $sql1)) {

$sql_insert1 = "INSERT INTO op_solicitud_vale_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$idReporte."',
    'ARCHIVO',
    '".$NomDoc1."'
    )";

mysqli_query($con, $sql_insert1);

}
}

echo 1;

}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------