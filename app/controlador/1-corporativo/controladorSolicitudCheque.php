<?php
require "../../modelo/1-corporativo/SolicitudCheque.php";
$SolicitudCheque = new SolicitudCheque();

switch($_POST['Accion']):
  
/* ---------- AGREGAR ----------*/
case 'agregar-comentario-solicitud-cheque':
$idReporte = $_POST['idReporte'];
$idUsuario = $_POST['idUsuario'];
$Comentario = $_POST['Comentario'];
echo $SolicitudCheque->agregarComentarioSolicitudCheque($idReporte,$idUsuario,$Comentario);
break;

case 'agregar-archivos-solicitud-cheque':
$idReporte = $_POST['idReporte'];
$idUsuario = $_POST['idUsuario'];
$descripcion = $_POST['Documento'];
$doc1 = $_FILES['Archivo_file'] ?? [''];
$docs = [$doc1];
$indice = 0;
echo $SolicitudCheque->agregarArchivosSolicitudCheque($idReporte,$idUsuario,$descripcion,$docs,$indice);
break;

case 'crear-token-solicitud-cheque':
$idReporte = $_POST['idReporte'];
$idUsuario = $_POST['idUsuario'];
echo $SolicitudCheque->crearTokenSolicitudCheque($idReporte,$idUsuario);
break;

case 'firmar-solicitud-cheque':
$idReporte = $_POST['idReporte'];
$tipoFirma = $_POST['tipoFirma'];
$TokenValidacion = $_POST['TokenValidacion'];
$idUsuario = $_POST['idUsuario'];
$nameEstacion = $_POST['nameEstacion'];
echo $SolicitudCheque->firmarSolicitudCheque($idReporte,$tipoFirma,$TokenValidacion,$idUsuario,$nameEstacion);
break;

case 'agregar-solicitud-cheque':
$GET_year = $_POST['GETyear'] ?? '';
$GET_mes = $_POST['GETmes'] ?? '';
$fecha = $_POST['Fecha'] ?? '';
$razon_s = $_POST['RazonSocial'] ?? '';
$beneficiario = $_POST['Beneficiario'] ?? '';
$monto = $_POST['Monto'] ?? '';
$moneda = $_POST['Moneda'] ?? '';
$noFactura = $_POST['NoFactura'] ?? '';
$correo = $_POST['Correo'] ?? '';
$concepto = $_POST['Concepto'] ?? '';
$solicitante = $_POST['Solicitante'] ?? '';
$telefono = $_POST['Telefono'] ?? '';
$CFDI = $_POST['CFDI'] ?? '';
$metodo = $_POST['Metodopago'] ?? '';
$forma = $_POST['FormaPago'] ?? '';
$banco = $_POST['Banco'] ?? '';
$cuenta = $_POST['NoCuenta'] ?? '';
$cuentaClave = $_POST['NoCuentaClave'] ?? '';
$referencia = $_POST['Referencia'] ?? '';
$observaciones = $_POST['Observaciones'] ?? '';
$departamento = $_POST['Depto'] ?? '';
$firma = $_POST['base64'];
$infoSolicitudCheque = [$GET_year,$GET_mes,$fecha,$razon_s,$beneficiario,$monto,$moneda,$noFactura,$correo,$concepto,$solicitante,$telefono,$CFDI,$metodo,$forma,$banco,$cuenta,$cuentaClave,$referencia,$observaciones,$departamento,$firma];

$doc1 = $_FILES['FacturaPresupuesto_file'] ?? [''];
$doc2 = $_FILES['FacturaPDF_file'] ?? [''];
$doc3 = $_FILES['FacturaXML_file'] ?? [''];
$doc4 = $_FILES['CaratulaB_file'] ?? [''];
$doc5 = $_FILES['ConstanciaS_file'] ?? [''];
$doc6 = $_FILES['PrefacturaPDF_file'] ?? [''];
$doc7 = $_FILES['OrdenServicio_file'] ?? [''];
$doc8 = $_FILES['OrdenCompra_file'] ?? [''];
$doc9 = $_FILES['OrdenMantenimiento_file'] ?? [''];
$doc10 = $_FILES['PolizaGarantia_file'] ?? [''];
$doc11 = $_FILES['Prorrateo_file'] ?? [''];
$doc12 = $_FILES['ReembolsoCajaChica_file'] ?? [''];
$doc13 = $_FILES['Cotizacion_file'] ?? [''];
$doc14 = $_FILES['NotaPDF_file'] ?? [''];
$doc15 = $_FILES['NotaXML_file'] ?? [''];
$doc16 = $_FILES['Contrato_file'] ?? [''];
$doc17 = $_FILES['ComPDF_file'] ?? [''];
$doc18 = $_FILES['ComXML_file'] ?? [''];
$docs = [$doc1,$doc2,$doc3,$doc4,$doc5,$doc6,$doc7,$doc8,$doc9,$doc10,$doc11,$doc12,$doc13,$doc14,$doc15,$doc16,$doc17,$doc18];

$idEstacion = $_POST['idEstacion'];
$idPuesto = $_POST['idPuesto'];
$idUsuario = $_POST['idUsuario'];
$nameEstacion = $_POST['nameEstacion'];

echo $SolicitudCheque->agregarSolicitudCheque($infoSolicitudCheque,$docs,$idEstacion,$idPuesto,$idUsuario,$nameEstacion);
break;

/* ---------- EDITAR ----------*/
case 'editar-factura-telcel-solicitud-cheque':
$idFactura = $_POST['idFactura'];
$doc1 = $_FILES['Pago_file'] ?? [''];
echo $SolicitudCheque->editarFacturaTelcelSolicitudCheque($idFactura,$doc1);
break;
 
case 'editar-solicitud-cheque':
$IdReporte = $_POST['IdReporte'];
$fecha = $_POST['Fecha'] ?? '';
$razon_s = $_POST['RazonSocial'] ?? '';
$beneficiario = $_POST['Beneficiario'] ?? '';
$monto = $_POST['Monto'] ?? '';
$moneda = $_POST['Moneda'] ?? '';
$noFactura = $_POST['NoFactura'] ?? '';
$correo = $_POST['Correo'] ?? '';
$concepto = $_POST['Concepto'] ?? '';
$solicitante = $_POST['Solicitante'] ?? '';
$telefono = $_POST['Telefono'] ?? '';
$CFDI = $_POST['CFDI'] ?? '';
$metodo = $_POST['Metodopago'] ?? '';
$forma = $_POST['FormaPago'] ?? '';
$banco = $_POST['Banco'] ?? '';
$cuenta = $_POST['NoCuenta'] ?? '';
$cuentaClave = $_POST['NoCuentaClave'] ?? '';
$referencia = $_POST['Referencia'] ?? '';
$observaciones = $_POST['Observaciones'] ?? '';
$firma = $_POST['base64'];
$infoSolicitudCheque = [$IdReporte,$fecha,$razon_s,$beneficiario,$monto,$moneda,$noFactura,$correo,$concepto,$solicitante,$telefono,$CFDI,$metodo,$forma,$banco,$cuenta,$cuentaClave,$referencia,$observaciones,$firma];

$doc1 = $_FILES['FacturaPresupuesto_file'] ?? [''];
$doc2 = $_FILES['FacturaPDF_file'] ?? [''];
$doc3 = $_FILES['FacturaXML_file'] ?? [''];
$doc4 = $_FILES['CaratulaB_file'] ?? [''];
$doc5 = $_FILES['ConstanciaS_file'] ?? [''];
$doc6 = $_FILES['PrefacturaPDF_file'] ?? [''];
$doc7 = $_FILES['OrdenServicio_file'] ?? [''];
$doc8 = $_FILES['OrdenCompra_file'] ?? [''];
$doc9 = $_FILES['OrdenMantenimiento_file'] ?? [''];
$doc10 = $_FILES['PolizaGarantia_file'] ?? [''];
$doc11 = $_FILES['Prorrateo_file'] ?? [''];
$doc12 = $_FILES['ReembolsoCajaChica_file'] ?? [''];
$doc13 = $_FILES['Cotizacion_file'] ?? [''];
$doc14 = $_FILES['NotaPDF_file'] ?? [''];
$doc15 = $_FILES['NotaXML_file'] ?? [''];
$doc16 = $_FILES['Contrato_file'] ?? [''];
$doc17 = $_FILES['ComPDF_file'] ?? [''];
$doc18 = $_FILES['ComXML_file'] ?? [''];
$docs = [$doc1,$doc2,$doc3,$doc4,$doc5,$doc6,$doc7,$doc8,$doc9,$doc10,$doc11,$doc12,$doc13,$doc14,$doc15,$doc16,$doc17,$doc18];

$idEstacion = $_POST['idEstacion'];
$idPuesto = $_POST['idPuesto'];
$idUsuario = $_POST['idUsuario'];
$nameEstacion = $_POST['nameEstacion'];

echo $SolicitudCheque->editarSolicitudCheque($infoSolicitudCheque,$docs,$idEstacion,$idPuesto,$idUsuario,$nameEstacion);
break;

 
/* ---------- ELIMINAR ----------*/
case 'eliminar-solicitud-cheque':
$idReporte = $_POST['idReporte'];
echo $SolicitudCheque->eliminarSolicitudCheque($idReporte);
break;


case 'eliminar-documentos-solicitud-cheque':
$idDocumento = $_POST['idDocumento'];
echo $SolicitudCheque->eliminarArchivosSolicitudCheque($idDocumento);
break;
    
endswitch;