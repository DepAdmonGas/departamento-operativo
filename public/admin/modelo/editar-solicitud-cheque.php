<?php
require('../../../app/help.php');

$aleatorio = uniqid();

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

$sql = "UPDATE op_solicitud_cheque SET 
fecha = '".$_POST['Fecha']."',
beneficiario = '".$_POST['Beneficiario']."',
monto = '".$_POST['Monto']."',
moneda = '".$_POST['Moneda']."',
no_factura = '".$_POST['NoFactura']."',
email = '".$_POST['Correo']."',
concepto = '".$valorConcepto."',
solicitante = '".$_POST['Solicitante']."',
telefono = '".$_POST['Telefono']."',
cfdi = '".$_POST['CFDI']."',
metodo_pago = '".$_POST['Metodopago']."',
forma_pago = '".$_POST['FormaPago']."',
banco = '".$_POST['Banco']."',
no_cuenta = '".$_POST['NoCuenta']."',
cuenta_clabe = '".$_POST['NoCuentaClave']."',
referencia = '".$_POST['Referencia']."',
observaciones = '".$_POST['Observaciones']."',
razonsocial = '".$_POST['RazonSocial']."'

WHERE id = '".$_POST['IdReporte']."' ";

if(mysqli_query($con, $sql)){

if (isset($_FILES['FacturaPresupuesto_file'])) {
if(move_uploaded_file($_FILES['FacturaPresupuesto_file']['tmp_name'], $UpDoc1)){
$sql3 = "DELETE FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$_POST['IdReporte']."' AND nombre = 'PRESUPUESTO' ";
if (mysqli_query($con, $sql3)) {

$sql_insert3 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$_POST['IdReporte']."',
    'PRESUPUESTO',
    '".$NomDoc1."'
    )";

mysqli_query($con, $sql_insert3);
}
}
}

if (isset($_FILES['FacturaPDF_file'])) {
if(move_uploaded_file($_FILES['FacturaPDF_file']['tmp_name'], $UpDoc2)){
$sql4 = "DELETE FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$_POST['IdReporte']."' AND nombre = 'FACTURA PDF' ";
if (mysqli_query($con, $sql4)) {

$sql_insert4 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$_POST['IdReporte']."',
    'FACTURA PDF',
    '".$NomDoc2."'
    )";

mysqli_query($con, $sql_insert4);
}
}
}

if (isset($_FILES['FacturaXML_file'])) {
if(move_uploaded_file($_FILES['FacturaXML_file']['tmp_name'], $UpDoc3)){
$sql5 = "DELETE FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$_POST['IdReporte']."' AND nombre = 'FACTURA XML' ";
if (mysqli_query($con, $sql5)) {

$sql_insert5 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$_POST['IdReporte']."',
    'FACTURA XML',
    '".$NomDoc3."'
    )";

mysqli_query($con, $sql_insert5);
}
}
}

if (isset($_FILES['CaratulaB_file'])) {
if(move_uploaded_file($_FILES['CaratulaB_file']['tmp_name'], $UpDoc4)){
$sql6 = "DELETE FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$_POST['IdReporte']."' AND nombre = 'CARATULA BANCARIA' ";
if (mysqli_query($con, $sql6)) {

$sql_insert6 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$_POST['IdReporte']."',
    'CARATULA BANCARIA',
    '".$NomDoc4."'
    )";

mysqli_query($con, $sql_insert6);
}
}
}

if (isset($_FILES['ConstanciaS_file'])) {
if(move_uploaded_file($_FILES['ConstanciaS_file']['tmp_name'], $UpDoc5)){
$sql7 = "DELETE FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$_POST['IdReporte']."' AND nombre = 'CONSTANCIA DE SITUACION' ";
if (mysqli_query($con, $sql7)) {

$sql_insert7 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$_POST['IdReporte']."',
    'CONSTANCIA DE SITUACION',
    '".$NomDoc5."'
    )";

mysqli_query($con, $sql_insert7);
}
}
}

if (isset($_FILES['PrefacturaPDF_file'])) {
if(move_uploaded_file($_FILES['PrefacturaPDF_file']['tmp_name'], $UpDoc6)){
$sql8 = "DELETE FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$_POST['IdReporte']."' AND nombre = 'PREFACTURA' ";
if (mysqli_query($con, $sql8)) {

$sql_insert8 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$_POST['IdReporte']."',
    'PREFACTURA',
    '".$NomDoc6."'
    )";

mysqli_query($con, $sql_insert8);
}
}
}

if (isset($_FILES['OrdenServicio_file'])) {
if(move_uploaded_file($_FILES['OrdenServicio_file']['tmp_name'], $UpDoc7)){
$sql9 = "DELETE FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$_POST['IdReporte']."' AND nombre = 'ORDEN DE SERVICIO' ";
if (mysqli_query($con, $sql9)) {

$sql_insert9 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$_POST['IdReporte']."',
    'ORDEN DE SERVICIO',
    '".$NomDoc7."'
    )";

mysqli_query($con, $sql_insert9);
}
}
}

if (isset($_FILES['OrdenCompra_file'])) {
if(move_uploaded_file($_FILES['OrdenCompra_file']['tmp_name'], $UpDoc8)){
$sql10 = "DELETE FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$_POST['IdReporte']."' AND nombre = 'ORDEN DE COMPRA' ";
if (mysqli_query($con, $sql10)) {

$sql_insert10 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$_POST['IdReporte']."',
    'ORDEN DE COMPRA',
    '".$NomDoc8."'
    )";

mysqli_query($con, $sql_insert10);
}
}
}

if (isset($_FILES['OrdenMantenimiento_file'])) {
if(move_uploaded_file($_FILES['OrdenMantenimiento_file']['tmp_name'], $UpDoc9)){
$sql11 = "DELETE FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$_POST['IdReporte']."' AND nombre = 'ORDEN DE MANTENIMIENTO' ";
if (mysqli_query($con, $sql11)) {

$sql_insert11 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$_POST['IdReporte']."',
    'ORDEN DE MANTENIMIENTO',
    '".$NomDoc9."'
    )";

mysqli_query($con, $sql_insert11);
}
}
}

if (isset($_FILES['PolizaGarantia_file'])) {
if(move_uploaded_file($_FILES['PolizaGarantia_file']['tmp_name'], $UpDoc10)){
$sql12 = "DELETE FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$_POST['IdReporte']."' AND nombre = 'PÓLIZA DE GARANTÍA' ";
if (mysqli_query($con, $sql12)) {

$sql_insert12 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$_POST['IdReporte']."',
    'PÓLIZA DE GARANTÍA',
    '".$NomDoc10."'
    )";

mysqli_query($con, $sql_insert12);
}
}
}

if (isset($_FILES['Prorrateo_file'])) {
if(move_uploaded_file($_FILES['Prorrateo_file']['tmp_name'], $UpDoc11)){
$sql13 = "DELETE FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$_POST['IdReporte']."' AND nombre = 'PRORRATEO' ";
if (mysqli_query($con, $sql13)) {

$sql_insert13 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$_POST['IdReporte']."',
    'PRORRATEO',
    '".$NomDoc11."'
    )";

mysqli_query($con, $sql_insert13);
}
}
}

if (isset($_FILES['ReembolsoCajaChica_file'])) {
if(move_uploaded_file($_FILES['ReembolsoCajaChica_file']['tmp_name'], $UpDoc12)){
$sql14 = "DELETE FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$_POST['IdReporte']."' AND nombre = 'REEMBOLSO CAJA CHICA' ";
if (mysqli_query($con, $sql14)) {

$sql_insert14 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$_POST['IdReporte']."',
    'REEMBOLSO CAJA CHICA',
    '".$NomDoc12."'
    )";

mysqli_query($con, $sql_insert14);
}
}
}

if (isset($_FILES['Cotizacion_file'])) {
if(move_uploaded_file($_FILES['Cotizacion_file']['tmp_name'], $UpDoc13)){
$sql15 = "DELETE FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$_POST['IdReporte']."' AND nombre = 'COTIZACIÓN' ";
if (mysqli_query($con, $sql15)) {

$sql_insert15 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$_POST['IdReporte']."',
    'COTIZACIÓN',
    '".$NomDoc13."'
    )";

mysqli_query($con, $sql_insert15);
}
}
}

if (isset($_FILES['NotaPDF_file'])) {
if(move_uploaded_file($_FILES['NotaPDF_file']['tmp_name'], $UpDoc14)){
$sql16 = "DELETE FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$_POST['IdReporte']."' AND nombre = 'NOTA DE CREDITO PDF' ";
if (mysqli_query($con, $sql16)) {

$sql_insert16 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$_POST['IdReporte']."',
    'NOTA DE CREDITO PDF',
    '".$NomDoc14."'
    )";

mysqli_query($con, $sql_insert16);
}
}
}

if (isset($_FILES['Contrato_file'])) {
if(move_uploaded_file($_FILES['NotaXML_file']['tmp_name'], $UpDoc15)){
$sql17 = "DELETE FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$_POST['IdReporte']."' AND nombre = 'NOTA DE CREDITO XML' ";
if (mysqli_query($con, $sql17)) {

$sql_insert17 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$_POST['IdReporte']."',
    'NOTA DE CREDITO XML',
    '".$NomDoc15."'
    )";

mysqli_query($con, $sql_insert17);
}
}
}

if (isset($_FILES['Contrato_file'])) {
if(move_uploaded_file($_FILES['Contrato_file']['tmp_name'], $UpDoc16)){
$sql18 = "DELETE FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$_POST['IdReporte']."' AND nombre = 'CONTRATO' ";
if (mysqli_query($con, $sql18)) {

$sql_insert18 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$_POST['IdReporte']."',
    'CONTRATO',
    '".$NomDoc16."'
    )";

mysqli_query($con, $sql_insert18);
}
}
} 


if (isset($_FILES['ComPDF_file'])) {
if(move_uploaded_file($_FILES['ComPDF_file']['tmp_name'], $UpDoc17)){
$sql19 = "DELETE FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$_POST['IdReporte']."' AND nombre = 'COMPLEMENTO DE PAGO PDF' ";

if (mysqli_query($con, $sql19)) {

$sql_insert19 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$_POST['IdReporte']."',
    'COMPLEMENTO DE PAGO PDF',
    '".$NomDoc17."'
    )";

mysqli_query($con, $sql_insert19);
}
}
} 



if (isset($_FILES['ComXML_file'])) {
if(move_uploaded_file($_FILES['ComXML_file']['tmp_name'], $UpDoc18)){
$sql20 = "DELETE FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$_POST['IdReporte']."' AND nombre = 'COMPLEMENTO DE PAGO XML' ";

if (mysqli_query($con, $sql20)) {

$sql_insert20 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$_POST['IdReporte']."',
    'COMPLEMENTO DE PAGO XML',
    '".$NomDoc18."'
    )";

mysqli_query($con, $sql_insert20);
}
}
} 


// Verificar si $img está vacío
if (!empty($img)) {
    $img = str_replace('data:image/png;base64,', '', $img);
    $fileData = base64_decode($img);
    $fileName = $aleatorio.'.png';

    if (file_put_contents('../../../imgs/firma/'.$fileName, $fileData)) {
        // Eliminar el registro si existe
        $sql21 = "DELETE FROM op_solicitud_cheque_firma WHERE id_solicitud = '".$_POST['IdReporte']."' AND tipo_firma = 'A'";
        if (mysqli_query($con, $sql21)) {
            // Insertar el nuevo registro
            $sql_insert21 = "INSERT INTO op_solicitud_cheque_firma (
                id_solicitud,
                id_usuario,
                tipo_firma,
                firma
            ) VALUES (
                '".$_POST['IdReporte']."',
                '".$Session_IDUsuarioBD."',
                'A',
                '".$fileName."'
            )";
            mysqli_query($con, $sql_insert21);
        }
    }
}


echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------