<?php  
require('../../../app/help.php');

$idEstacion = $_POST['idEstacion'];

$aleatorio = uniqid();

function idReporte($con){
$sql = "SELECT id FROM op_solicitud_vale ORDER BY id desc LIMIT 1";
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

function Folio($con){
$sql = "SELECT folio FROM op_solicitud_vale ORDER BY id desc LIMIT 1";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if ($numero == 0) {
$folio = 1;
}else{
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$folio = $row['folio'] + 1;
}
}
return $folio;
}

$idReporte = idReporte($con);
$Folio = Folio($con);

$NoDoc1  =   $_FILES['Vale_file']['name'];
$UpDoc1 = "../../../archivos/vales/".$aleatorio."-".$NoDoc1;
$NomDoc1 = $aleatorio."-".$NoDoc1;

$NoDoc2  =   $_FILES['Recibo_file']['name'];
$UpDoc2 = "../../../archivos/vales/".$aleatorio."-".$NoDoc2;
$NomDoc2 = $aleatorio."-".$NoDoc2;

$NoDoc3  =   $_FILES['Factura_file']['name'];
$UpDoc3 = "../../../archivos/vales/".$aleatorio."-".$NoDoc3;
$NomDoc3 = $aleatorio."-".$NoDoc3;

$NoDoc4  =   $_FILES['PDF_file']['name'];
$UpDoc4 = "../../../archivos/vales/".$aleatorio."-".$NoDoc4;
$NomDoc4 = $aleatorio."-".$NoDoc4;

$NoDoc5  =   $_FILES['XML_file']['name'];
$UpDoc5 = "../../../archivos/vales/".$aleatorio."-".$NoDoc5;
$NomDoc5 = $aleatorio."-".$NoDoc5;

if ($_POST['idEstacion'] == 8) {
$Estacion = $_POST['Estacion'];
$Cuentas = $_POST['Cuentas'];
}else{
$Estacion = $_POST['idEstacion'];
$Cuentas = '';    
}

if($_POST['Departamento'] == ''){
$Departamento = $_POST['GETdepu'];
}else{
$Departamento = $_POST['Departamento']; 
}

$sql_insert = "INSERT INTO op_solicitud_vale (
id,
id_year,
id_mes,
id_estacion,
cuenta,
id_usuario,
folio,
fecha,
hora,
monto,
moneda,
concepto,
solicitante,

autorizado_por,
metodo_autorizacion,

observaciones,
depto,
status
    )
    VALUES 
    (
    '".$idReporte."',
    '".$_POST['GETyear']."',
    '".$_POST['GETmes']."',
    '".$Estacion."',
    '".$Cuentas."',
    '".$Session_IDUsuarioBD."',
    '".$Folio."',
    '".$_POST['Fecha']."',
    '".$hora_del_dia."',
    '".$_POST['Monto']."',
    '".$_POST['Moneda']."',
    '".$_POST['Concepto']."',
    '".$_POST['Solicitante']."',

    '".$_POST['Autorizadopor']."',
    '".$_POST['MetodoAutorizacion']."',

    '".$_POST['Observaciones']."',
    '".$_POST['GETdepu']."',
    1
    )";

if(mysqli_query($con, $sql_insert)){

if(move_uploaded_file($_FILES['Vale_file']['tmp_name'], $UpDoc1)){

$sqlInsert1 = "INSERT INTO op_solicitud_vale_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$idReporte."',
    'VALE',
    '".$NomDoc1."'
    )";

mysqli_query($con, $sqlInsert1);

}
//--------------------------------------------------------------------
if(move_uploaded_file($_FILES['Recibo_file']['tmp_name'], $UpDoc2)){

$sqlInsert2 = "INSERT INTO op_solicitud_vale_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$idReporte."',
    'RECIBO',
    '".$NomDoc2."'
    )";

mysqli_query($con, $sqlInsert2);

}
//--------------------------------------------------------------------

//--------------------------------------------------------------------
if(move_uploaded_file($_FILES['Factura_file']['tmp_name'], $UpDoc3)){

$sqlInsert3 = "INSERT INTO op_solicitud_vale_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$idReporte."',
    'FACTURA',
    '".$NomDoc3."'
    )";

mysqli_query($con, $sqlInsert3);

}
//--------------------------------------------------------------------
//--------------------------------------------------------------------
if(move_uploaded_file($_FILES['PDF_file']['tmp_name'], $UpDoc4)){

$sqlInsert4 = "INSERT INTO op_solicitud_vale_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$idReporte."',
    'PDF',
    '".$NomDoc4."'
    )";

mysqli_query($con, $sqlInsert4);

}
//--------------------------------------------------------------------
//--------------------------------------------------------------------
if(move_uploaded_file($_FILES['XML_file']['tmp_name'], $UpDoc5)){

$sqlInsert5 = "INSERT INTO op_solicitud_vale_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$idReporte."',
    'XML',
    '".$NomDoc5."'
    )";

mysqli_query($con, $sqlInsert5);

}
//--------------------------------------------------------------------
echo 1;

}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------