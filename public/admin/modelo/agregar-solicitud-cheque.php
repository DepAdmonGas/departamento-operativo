<?php
require('../../../app/help.php');

$aleatorio = uniqid();

function idReporte($con){
$sql = "SELECT id FROM op_solicitud_cheque ORDER BY id desc LIMIT 1";
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
 
$idReporte = idReporte($con);

$img = $_POST['base64'];
$img = str_replace('data:image/png;base64,', '', $img);
$fileData = base64_decode($img);
$fileName = $aleatorio.'.png';

if (isset($_FILES['FacturaPresupuesto_file'])) {
$NoDoc1  =   $_FILES['FacturaPresupuesto_file']['name'];
$UpDoc1 = "../../../archivos/".$aleatorio."-".$NoDoc1;
$NomDoc1 = $aleatorio."-".$NoDoc1;
}

if (isset($_FILES['FacturaPDF_file'])) {
$NoDoc2  =   $_FILES['FacturaPDF_file']['name'];
$UpDoc2 = "../../../archivos/".$aleatorio."-".$NoDoc2;
$NomDoc2 = $aleatorio."-".$NoDoc2;
}

if (isset($_FILES['FacturaXML_file'])) {
$NoDoc3  =   $_FILES['FacturaXML_file']['name'];
$UpDoc3 = "../../../archivos/".$aleatorio."-".$NoDoc3;
$NomDoc3 = $aleatorio."-".$NoDoc3;
}

if (isset($_FILES['CaratulaB_file'])) {
$NoDoc4  =   $_FILES['CaratulaB_file']['name'];
$UpDoc4 = "../../../archivos/".$aleatorio."-".$NoDoc4;
$NomDoc4 = $aleatorio."-".$NoDoc4;
}

if (isset($_FILES['ConstanciaS_file'])) {
$NoDoc5  =   $_FILES['ConstanciaS_file']['name'];
$UpDoc5 = "../../../archivos/".$aleatorio."-".$NoDoc5;
$NomDoc5 = $aleatorio."-".$NoDoc5;
}

if (isset($_FILES['PrefacturaPDF_file'])) {
$NoDoc6  =   $_FILES['PrefacturaPDF_file']['name'];
$UpDoc6 = "../../../archivos/".$aleatorio."-".$NoDoc6;
$NomDoc6 = $aleatorio."-".$NoDoc6;
}

if (isset($_FILES['OrdenServicio_file'])) {
$NoDoc7  =   $_FILES['OrdenServicio_file']['name'];
$UpDoc7 = "../../../archivos/".$aleatorio."-".$NoDoc7;
$NomDoc7 = $aleatorio."-".$NoDoc7;
}

if (isset($_FILES['OrdenCompra_file'])) {
$NoDoc8  =   $_FILES['OrdenCompra_file']['name'];
$UpDoc8 = "../../../archivos/".$aleatorio."-".$NoDoc8;
$NomDoc8 = $aleatorio."-".$NoDoc8;
}

if (isset($_FILES['OrdenMantenimiento_file'])) {
$NoDoc9  =   $_FILES['OrdenMantenimiento_file']['name'];
$UpDoc9 = "../../../archivos/".$aleatorio."-".$NoDoc9;
$NomDoc9 = $aleatorio."-".$NoDoc9;
}

if (isset($_FILES['PolizaGarantia_file'])) {
$NoDoc10  =   $_FILES['PolizaGarantia_file']['name'];
$UpDoc10 = "../../../archivos/".$aleatorio."-".$NoDoc10;
$NomDoc10 = $aleatorio."-".$NoDoc10;
}

if (isset($_FILES['Prorrateo_file'])) {
$NoDoc11  =   $_FILES['Prorrateo_file']['name'];
$UpDoc11 = "../../../archivos/".$aleatorio."-".$NoDoc11;
$NomDoc11 = $aleatorio."-".$NoDoc11;
}

if (isset($_FILES['ReembolsoCajaChica_file'])) {
$NoDoc12  =   $_FILES['ReembolsoCajaChica_file']['name'];
$UpDoc12 = "../../../archivos/".$aleatorio."-".$NoDoc12;
$NomDoc12 = $aleatorio."-".$NoDoc12;
}

if (isset($_FILES['Cotizacion_file'])) {
$NoDoc13  =   $_FILES['Cotizacion_file']['name'];
$UpDoc13 = "../../../archivos/".$aleatorio."-".$NoDoc13;
$NomDoc13 = $aleatorio."-".$NoDoc13;
}

if (isset($_FILES['NotaPDF_file'])) {
$NoDoc14  =   $_FILES['NotaPDF_file']['name'];
$UpDoc14 = "../../../archivos/".$aleatorio."-".$NoDoc14;
$NomDoc14 = $aleatorio."-".$NoDoc14;
}

if (isset($_FILES['NotaXML_file'])) {
$NoDoc15  =   $_FILES['NotaXML_file']['name'];
$UpDoc15 = "../../../archivos/".$aleatorio."-".$NoDoc15;
$NomDoc15 = $aleatorio."-".$NoDoc15;
}

if (isset($_FILES['Contrato_file'])) {
$NoDoc16  =   $_FILES['Contrato_file']['name'];
$UpDoc16 = "../../../archivos/".$aleatorio."-".$NoDoc16;
$NomDoc16 = $aleatorio."-".$NoDoc16;
}

if (isset($_FILES['ComPDF_file'])) {
$NoDoc17  =   $_FILES['ComPDF_file']['name'];
$UpDoc17 = "../../../archivos/".$aleatorio."-".$NoDoc17;
$NomDoc17 = $aleatorio."-".$NoDoc17;
}

if (isset($_FILES['ComXML_file'])) {
$NoDoc18  =   $_FILES['ComXML_file']['name'];
$UpDoc18 = "../../../archivos/".$aleatorio."-".$NoDoc18;
$NomDoc18 = $aleatorio."-".$NoDoc18;
}

$valorConcepto = mysqli_real_escape_string($con, $_POST['Concepto']);

$sql_insert = "INSERT INTO op_solicitud_cheque (
id,
id_year,
id_mes,
id_estacion,
fecha,
hora,
beneficiario,
monto,
moneda,
no_factura,
email,
concepto,
solicitante,
telefono,
cfdi,
metodo_pago,
forma_pago,
banco,
no_cuenta,
cuenta_clabe,
referencia,
observaciones,
depto,
razonsocial,
status
    )
    VALUES 
    (
    '".$idReporte."',
    '".$_POST['GETyear']."',
    '".$_POST['GETmes']."',
    '".$_POST['idEstacion']."',
    '".$_POST['Fecha']."',
    '".$hora_del_dia."',
    '".$_POST['Beneficiario']."',
    '".$_POST['Monto']."',
    '".$_POST['Moneda']."',
    '".$_POST['NoFactura']."',
    '".$_POST['Correo']."',
    '".$valorConcepto."',
    '".$_POST['Solicitante']."',
    '".$_POST['Telefono']."',
    '".$_POST['CFDI']."',
    '".$_POST['Metodopago']."',
    '".$_POST['FormaPago']."',
    '".$_POST['Banco']."',
    '".$_POST['NoCuenta']."',
    '".$_POST['NoCuentaClave']."',
    '".$_POST['Referencia']."',
    '".$_POST['Observaciones']."',
    '".$_POST['GETdepu']."',
    '".$_POST['RazonSocial']."',
    0
    )";

if(mysqli_query($con, $sql_insert)){


if(file_put_contents('../../../imgs/firma/'.$fileName, $fileData)){
$sql_insert2 = "INSERT INTO op_solicitud_cheque_firma (
id_solicitud,
id_usuario,
tipo_firma,
firma
    )
    VALUES 
    (
    '".$idReporte."',
    '".$Session_IDUsuarioBD."',
    'A',
    '".$fileName."'
    )";

mysqli_query($con, $sql_insert2);

}


if (isset($_FILES['FacturaPresupuesto_file'])) {
if(move_uploaded_file($_FILES['FacturaPresupuesto_file']['tmp_name'], $UpDoc1)){
$sql_insert3 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$idReporte."',
    'PRESUPUESTO',
    '".$NomDoc1."'
    )";

mysqli_query($con, $sql_insert3);
}
}

if (isset($_FILES['PrefacturaPDF_file'])) {
if(move_uploaded_file($_FILES['PrefacturaPDF_file']['tmp_name'], $UpDoc6)){
$sql_insert8 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$idReporte."',
    'PREFACTURA',
    '".$NomDoc6."'
    )";

mysqli_query($con, $sql_insert8);
}
}

if (isset($_FILES['FacturaPDF_file'])) {
if(move_uploaded_file($_FILES['FacturaPDF_file']['tmp_name'], $UpDoc2)){
$sql_insert4 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$idReporte."',
    'FACTURA PDF',
    '".$NomDoc2."'
    )";

mysqli_query($con, $sql_insert4);
}
}


if (isset($_FILES['FacturaXML_file'])) {
if(move_uploaded_file($_FILES['FacturaXML_file']['tmp_name'], $UpDoc3)){
$sql_insert5 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$idReporte."',
    'FACTURA XML',
    '".$NomDoc3."'
    )";

mysqli_query($con, $sql_insert5);
}
}

if (isset($_FILES['CaratulaB_file'])) {
if(move_uploaded_file($_FILES['CaratulaB_file']['tmp_name'], $UpDoc4)){
$sql_insert6 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$idReporte."',
    'CARATULA BANCARIA',
    '".$NomDoc4."'
    )";

mysqli_query($con, $sql_insert6);
}
}

if (isset($_FILES['ConstanciaS_file'])) {
if(move_uploaded_file($_FILES['ConstanciaS_file']['tmp_name'], $UpDoc5)){
$sql_insert7 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$idReporte."',
    'CONSTANCIA DE SITUACION',
    '".$NomDoc5."'
    )";

mysqli_query($con, $sql_insert7);
}
}

if (isset($_FILES['OrdenServicio_file'])) {
if(move_uploaded_file($_FILES['OrdenServicio_file']['tmp_name'], $UpDoc7)){

$sql_insert9 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$idReporte."',
    'ORDEN DE SERVICIO',
    '".$NomDoc7."'
    )";

mysqli_query($con, $sql_insert9);
}
}

if (isset($_FILES['OrdenCompra_file'])) {
if(move_uploaded_file($_FILES['OrdenCompra_file']['tmp_name'], $UpDoc8)){

$sql_insert9 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$idReporte."',
    'ORDEN DE COMPRA',
    '".$NomDoc8."'
    )";

mysqli_query($con, $sql_insert9);
}
}

if (isset($_FILES['OrdenMantenimiento_file'])) {
if(move_uploaded_file($_FILES['OrdenMantenimiento_file']['tmp_name'], $UpDoc9)){

$sql_insert10 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$idReporte."',
    'ORDEN DE MANTENIMIENTO',
    '".$NomDoc9."'
    )";

mysqli_query($con, $sql_insert10);
}
}

if (isset($_FILES['PolizaGarantia_file'])) {
if(move_uploaded_file($_FILES['PolizaGarantia_file']['tmp_name'], $UpDoc10)){

$sql_insert11 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$idReporte."',
    'PÓLIZA DE GARANTÍA',
    '".$NomDoc10."'
    )";

mysqli_query($con, $sql_insert11);
}
}

if (isset($_FILES['Prorrateo_file'])) {
if(move_uploaded_file($_FILES['Prorrateo_file']['tmp_name'], $UpDoc11)){

$sql_insert12 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$idReporte."',
    'PRORRATEO',
    '".$NomDoc11."'
    )";

mysqli_query($con, $sql_insert12);
}
}

if (isset($_FILES['ReembolsoCajaChica_file'])) {
if(move_uploaded_file($_FILES['ReembolsoCajaChica_file']['tmp_name'], $UpDoc12)){

$sql_insert13 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$idReporte."',
    'REEMBOLSO CAJA CHICA',
    '".$NomDoc12."'
    )";

mysqli_query($con, $sql_insert13);
}
}


if (isset($_FILES['Cotizacion_file'])) {
if(move_uploaded_file($_FILES['Cotizacion_file']['tmp_name'], $UpDoc13)){

$sql_insert14 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$idReporte."',
    'COTIZACIÓN',
    '".$NomDoc13."'
    )";

    $sqlComent = "INSERT INTO op_solicitud_cheque_comentario (
    id_solicitud,
    id_usuario,
    comentario
    )
    VALUES 
    (
    '".$idReporte."',
    '".$Session_IDUsuarioBD."',
    'Factura contra entrega.'
    )";

mysqli_query($con, $sql_insert14);
mysqli_query($con, $sqlComent);
}
}

if (isset($_FILES['NotaPDF_file'])) {
if(move_uploaded_file($_FILES['NotaPDF_file']['tmp_name'], $UpDoc14)){
$sql_insert15 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$idReporte."',
    'NOTA DE CREDITO PDF',
    '".$NomDoc14."'
    )";
mysqli_query($con, $sql_insert15);
}
}
  
if (isset($_FILES['NotaXML_file'])) {
if(move_uploaded_file($_FILES['NotaXML_file']['tmp_name'], $UpDoc15)){

$sql_insert16 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$idReporte."',
    'NOTA DE CREDITO XML',
    '".$NomDoc15."'
    )"; 

mysqli_query($con, $sql_insert16);
}
}

if (isset($_FILES['Contrato_file'])) {
if(move_uploaded_file($_FILES['Contrato_file']['tmp_name'], $UpDoc16)){

$sql_insert17 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$idReporte."',
    'CONTRATO',
    '".$NomDoc16."'
    )";

    mysqli_query($con, $sql_insert17);
}
}

if (isset($_FILES['ComPDF_file'])) {
if(move_uploaded_file($_FILES['ComPDF_file']['tmp_name'], $UpDoc17)){

$sql_insert18 = "INSERT INTO op_solicitud_cheque_documento (
  id_solicitud,
  nombre,
  documento
  )
    
    VALUES 
    (
'".$idReporte."',
'COMPLEMENTO DE PAGO PDF',
'".$NomDoc17."'
    )";


mysqli_query($con, $sql_insert18);
}
}


if (isset($_FILES['ComXML_file'])) {
if(move_uploaded_file($_FILES['ComXML_file']['tmp_name'], $UpDoc18)){

$sql_insert19 = "INSERT INTO op_solicitud_cheque_documento (
  id_solicitud,
  nombre,
  documento
  )
    VALUES 
    (
'".$idReporte."',
'COMPLEMENTO DE PAGO XML',
'".$NomDoc18."'
    )";


mysqli_query($con, $sql_insert19);
}
}


 

echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------