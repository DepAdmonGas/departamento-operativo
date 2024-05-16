<?php
require "../../modelo/1-corporativo/SolicitudVale.php";
$SolicitudVale = new SolicitudVale();


switch($_POST['Accion']):

/* ---------- AGREGAR ----------*/
case 'agregar-archivo-solicitud-vale':
$idReporte = $_POST['idReporte'];
$nameDocumento = $_POST['Documento'];
$doc1 = $_FILES['Archivo_file'] ?? [''];
$docs = [$doc1];
$indiceDoc = 0;
echo $SolicitudVale->agregarArchivoSolicitudVale($idReporte,$nameDocumento,$docs,$indiceDoc);
break;

case 'agregar-solicitud-vale':
$idEstacion = $_POST['idEstacion'];
$GETdepu = $_POST['GETdepu'];
$GETyear = $_POST['GETyear'];
$GETmes = $_POST['GETmes'];
$idUsuario = $_POST['idUsuario'];

$Fecha = $_POST['Fecha'];
$Monto = $_POST['Monto'];
$Moneda = $_POST['Moneda'];
$Concepto = $_POST['Concepto'];
$Solicitante = $_POST['Solicitante'];
$Observaciones = $_POST['Observaciones'];
$Autorizadopor = $_POST['Autorizadopor'];
$MetodoAutorizacion = $_POST['MetodoAutorizacion'];
$Departamento = $_POST['Departamento'];
$Estacion = $_POST['Estacion']; 
$Cuentas = $_POST['Cuentas'];

$doc1 = $_FILES['Vale_file'] ?? [''];
$doc2 = $_FILES['Recibo_file'] ?? [''];
$doc3 = $_FILES['Factura_file'] ?? [''];
$doc4 = $_FILES['PDF_file'] ?? [''];
$doc5 = $_FILES['XML_file'] ?? [''];

$infoSolicitud = [$idEstacion,$GETdepu,$GETyear,$GETmes,$idUsuario,$Fecha,$Monto,$Moneda,$Concepto,$Solicitante,$Observaciones,$Autorizadopor,$MetodoAutorizacion,$Departamento,$Estacion,$Cuentas];
$docs = [$doc1,$doc2,$doc3,$doc4,$doc5];
echo $SolicitudVale->agregarSolicitudVale($infoSolicitud,$docs);
break;

/* ---------- AGREGAR ----------*/
case 'agregar-comentario-solicitud-vale':
$idReporte = $_POST['idReporte'];
$idUsuario = $_POST['idUsuario'];
$Comentario = $_POST['Comentario'];
echo $SolicitudVale->agregarComentarioSolicitudVale($idReporte,$idUsuario,$Comentario);
break;

/* ---------- ELIMINAR ----------*/
case 'eliminar-solicitud-vale':
$idReporte = $_POST['idReporte'];
echo $SolicitudVale->eliminarSolicitudVale($idReporte);
break;


case 'eliminar-documento-solicitud-vale':
$idDocumento = $_POST['idDocumento'];
echo $SolicitudVale->eliminarDocumentoSolicitudVale($idDocumento);
break;


endswitch; 