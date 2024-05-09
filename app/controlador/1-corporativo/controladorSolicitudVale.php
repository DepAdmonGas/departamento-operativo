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
echo $SolicitudVale->agregararchivoSolicitudVale($idReporte,$nameDocumento,$docs);
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