<?php  
require('../../../app/help.php');


if ($Session_IDUsuarioBD == 292) {
$Estacion = $_POST['Estacion'];
$Cuentas = $_POST['Cuentas'];

}else{

if ($_POST['idEstacion'] == 8) {
$Estacion = $_POST['Estacion'];
$Cuentas = $_POST['Cuentas'];
        
}else{
$Estacion = $_POST['idEstacion'];
$Cuentas = '';    
}

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
echo 1;

}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------