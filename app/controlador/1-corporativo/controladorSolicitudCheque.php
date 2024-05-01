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
echo $SolicitudCheque->agregarArchivosSolicitudCheque($idReporte,$idUsuario,$descripcion,$doc1);
break;

/* ---------- EDITAR ----------*/
case 'editar-factura-telcel-solicitud-cheque':
$idFactura = $_POST['idFactura'];
$doc1 = $_FILES['Pago_file'] ?? [''];
echo $SolicitudCheque->editarFacturaTelcelSolicitudCheque($idFactura,$doc1);
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