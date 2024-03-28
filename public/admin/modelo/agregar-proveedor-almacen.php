<?php
require('../../../app/help.php');

$aleatorio = uniqid();

function idProveedor($con){
$sql = "SELECT id FROM op_almacen_proveedores ORDER BY id desc LIMIT 1";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if ($numero == 0) {
$numid = 1;
}else{
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$numid = $row['id'] + 1;
}
}
return $numid;
}


function NoFolio($con){
$sql = "SELECT folio FROM op_almacen_proveedores ORDER BY folio DESC LIMIT 1 ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if($numero == 0){
$Result = 1;	
}else{
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Result = $row['folio'] + 1;
}	
}
return $Result;
}
 

$idProveedor = idProveedor($con);
$NoFolio = NoFolio($con);

$NoDoc1  =   $_FILES['ConstanciaS_file']['name'];
$UpDoc1 = "../../../archivos/proveedores/".$aleatorio."-".$NoDoc1;
$NomDoc1 = $aleatorio."-".$NoDoc1;

$NoDoc2  =   $_FILES['CaratulaB_file']['name'];
$UpDoc2 = "../../../archivos/proveedores/".$aleatorio."-".$NoDoc2;
$NomDoc2 = $aleatorio."-".$NoDoc2;


$sql_insert = "INSERT INTO op_almacen_proveedores (
id,
folio,
fecha,
razon_social,
actividad_economica,
email,
rfc,
ciudad,
telefono_1,
telefono_2,
direccion,
beneficiario,
banco,
metodo_pago,
cfdi,
moneda,
forma_pago,
descripcion,
status
)
VALUES
(
'".$idProveedor."',
'".$NoFolio."',
'".$_POST['Fecha']."',
'".$_POST['RazonSocial']."',
'".$_POST['ActividadEco']."',
'".$_POST['Email']."',
'".$_POST['RFC']."',
'".$_POST['Ciudad']."',
'".$_POST['Telefono1']."',
'".$_POST['Telefono2']."',
'".$_POST['Direccion']."',
'".$_POST['Beneficiario']."',
'".$_POST['Banco']."',
'".$_POST['Metodopago']."',
'".$_POST['CFDI']."',
'".$_POST['Moneda']."',
'".$_POST['FormaPago']."',
'".$_POST['Descripcion']."',
'0'
)";


if(mysqli_query($con, $sql_insert)){

if(move_uploaded_file($_FILES['ConstanciaS_file']['tmp_name'], $UpDoc1)){

$sql_insert2 = "INSERT INTO op_almacen_proveedores_documentos (
id_proveedor,
nombre,
fecha,
archivo
    )
    VALUES 
    (
    '".$idProveedor."',
    'Constancia de Situacion Fiscal',
    '".$_POST['FechaConstancia']."',
    '".$NomDoc1."'
    )";

mysqli_query($con, $sql_insert2);

}


if(move_uploaded_file($_FILES['CaratulaB_file']['tmp_name'], $UpDoc2)){

$sql_insert3 = "INSERT INTO op_almacen_proveedores_documentos(
id_proveedor,
nombre,
fecha,
archivo
    )
    VALUES 
    (
    '".$idProveedor."',
    'Caratula Bancaria',
    '".$_POST['FechaCaratula']."',
    '".$NomDoc2."'
    )";

mysqli_query($con, $sql_insert3);

}


echo 1;
}else{
echo 0;
}


?>