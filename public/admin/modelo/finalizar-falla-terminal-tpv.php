<?php
require('../../../app/help.php');

$aleatorio = uniqid();
$NomDoc = "";

if (isset($_FILES['FacturaPDF_file'])) {
$NoDoc  =   $_FILES['FacturaPDF_file']['name'];
$UpDoc = "../../../archivos/".$aleatorio."-".$NoDoc;
$NomDoc = $aleatorio."-".$NoDoc;
}


$sql_edit = "UPDATE op_terminales_tpv_reporte SET 
falla = '".$_POST['Falla']."',
atiende = '".$_POST['Atiende']."',
no_reporte = '".$_POST['NoReporte']."',
dia_reporte = '".$_POST['DiaReporte']."',
dia_solucion = '".$_POST['DiaSolucion']."',
costo = '".$_POST['Costo']."',
factura = '".$NomDoc."',
serie = '".$_POST['NuevaSerie']."',
modelo = '".$_POST['ModeloTPV']."',
conexion = '".$_POST['Conexion']."',
observaciones = '".$_POST['Observaciones']."',
status = 1
WHERE id = '".$_POST['idFalla']."' ";

if(mysqli_query($con, $sql_edit)){

if (isset($_FILES['FacturaPDF_file'])){
if(move_uploaded_file($_FILES['FacturaPDF_file']['tmp_name'], $UpDoc)){
    
}
}

if($_POST['NuevaSerie'] != "" AND $_POST['ModeloTPV'] != "" AND $_POST['Conexion'] != "" ){

$sql_lista = "SELECT * FROM op_terminales_tpv WHERE id = '".$_POST['idTPV']."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$tpv = $row_lista['tpv'];
$telefono = $row_lista['telefono'];	
$estado = $row_lista['estado'];	
$rollos = $row_lista['rollos'];
$cargadores = $row_lista['cargadores'];
$pedestales = $row_lista['pedestales'];	
$noafiliacion = $row_lista['no_afiliacion'];	
}

$sql_insert = "INSERT INTO op_terminales_tpv (
id_estacion,
tpv,
no_serie,
modelo,
no_lote,
tipo_conexion,
no_afiliacion,
telefono,
estado,
rollos,
cargadores,
pedestales,
status
    )
    VALUES 
    (
    '".$_POST['idEstacion']."',
    '".$tpv."',
    '".$_POST['NuevaSerie']."',
    '".$_POST['ModeloTPV']."',
    '',
    '".$_POST['Conexion']."',
    '".$noafiliacion."',
    '".$telefono."',
    '".$estado."',
    '".$rollos."',
    '".$cargadores."',
    '".$pedestales."',
    1
    )";

if(mysqli_query($con, $sql_insert)){

$sql_edit1 = "UPDATE op_terminales_tpv SET 
status = 0
WHERE id = '".$_POST['idTPV']."' ";
mysqli_query($con, $sql_edit1);

echo 1;
}else{
echo 0;
}

}else{

echo 1;
}

}else{
echo 0;	
}


//------------------
mysqli_close($con);
//------------------
?>