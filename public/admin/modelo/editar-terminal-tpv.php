<?php
require('../../../app/help.php');

$sql = "UPDATE op_terminales_tpv SET 
tpv = '".$_POST['Tpv']."',
no_serie = '".$_POST['Serie']."',
modelo = '".$_POST['Modelomarca']."',
no_lote = '".$_POST['NoLote']."',
tipo_conexion = '".$_POST['TipoC']."',
no_afiliacion = '".$_POST['Afiliado']."',
telefono = '".$_POST['Telefono']."',
estado = '".$_POST['Estado']."',
rollos = '".$_POST['Rollos']."',
cargadores = '".$_POST['Cargadores']."',
pedestales = '".$_POST['Pedestales']."',
estatus_tpv = '".$_POST['EstadoTPV']."',
no_impresiones = '".$_POST['NoImpresiones']."',
tipo_tpv = '".$_POST['TipoTPV']."'
WHERE id='".$_POST['idEditar']."' ";

if(mysqli_query($con, $sql)){
echo 1;
}else{
echo 0;
}
//------------------
mysqli_close($con);
//------------------
?>