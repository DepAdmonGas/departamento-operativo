<?php
require "../../modelo/2-recursos-humanos/DocumentosPersonal.php";
$DocumentosPersonal = new DocumentosPersonal();

switch($_POST['Accion']):

/* ---------- AGREGAR ----------*/
case 'agregar-comentario-personal':
$idPersonal = $_POST['idPersonal'];
$idUsuario = $_POST['idUsuario'];
$Comentario = $_POST['Comentario'];
echo $DocumentosPersonal->agregarComentarioPersonal($idPersonal,$idUsuario,$Comentario);
break;

case 'agregar-comentario-baja-personal':
$idBaja = $_POST['idBaja'];
$idUsuario = $_POST['idUsuario'];
$Comentario = $_POST['Comentario'];
echo $DocumentosPersonal->agregarComentarioBajaPersonal($idBaja,$idUsuario,$Comentario);
break;

   
case 'agregar-informacion-personal':
$idEstacion = $_POST['idEstacion'];
$idPersonal = $_POST['idPersonal'];
$FechaIngreso = $_POST['FechaIngreso'];
$NoColaborador = $_POST['NoColaborador'];
$NombreCompleto = $_POST['NombreCompleto'];
$Puesto = $_POST['Puesto'];
$sd = $_POST['sd'];
$infoPersonal = [$idEstacion, $idPersonal, $FechaIngreso, $NoColaborador, $NombreCompleto, $Puesto, $sd];
    
$doc0 = $_FILES['DocumentoPersonal_file'] ?? [''];
$doc1 = $_FILES['DocumentoCV_file'] ?? [''];
$doc2 = $_FILES['DocumentoINE_file'] ?? [''];
$doc3 = $_FILES['DocumentoNacimiento_file'] ?? [''];
$doc4 = $_FILES['DocumentoDomicilio_file'] ?? [''];
$doc5 = $_FILES['DocumentoNSS_file'] ?? [''];
$doc6 = $_FILES['DocumentoEstudios_file'] ?? [''];
$doc7 = $_FILES['DocumentoRecomendacion_file'] ?? [''];
$doc8 = $_FILES['DocumentoCURP_file'] ?? [''];
$doc9 = $_FILES['DocumentoInfonavit_file'] ?? [''];
$doc10 = $_FILES['DocumentoRFC_file'] ?? [''];
$doc11 = $_FILES['DocumentoAntecedentes_file'] ?? [''];
$doc12 = $_FILES['DocumentoContrato_file'] ?? [''];
$docs = [$doc0, $doc1, $doc2, $doc3, $doc4, $doc5, $doc6, $doc7, $doc8, $doc9, $doc10, $doc11, $doc12];
    
echo $DocumentosPersonal->agregarInformacionPersonal($infoPersonal,$docs);
break;

case 'agregar-pin-personal':
$idPersonal = $_POST['idPersonal'];
$PinAcceso = $_POST['PinAcceso'];
echo $DocumentosPersonal->agregarPinPersonal($idPersonal,$PinAcceso);
break;

case 'agregar-baja-personal':
$idPersonal = $_POST['idPersonal'];
$FechaBaja = $_POST['FechaBaja'];
$Motivo = $_POST['Motivo'];
$Detalle = $_POST['Detalle'];
$infoBaja  = [$idPersonal,$FechaBaja,$Motivo,$Detalle];

$doc1 = $_FILES['ActaHechos_file'] ?? [''];
$doc2 = $_FILES['CartaRenuncia_file'] ?? [''];
$doc3 = $_FILES['Finiquito_file'] ?? [''];
$docs = [$doc1,$doc2,$doc3];
    
echo $DocumentosPersonal->agregarBajaPersonal($infoBaja,$docs);
break;
 
case 'agregar-archivo-baja-personal':
$idBaja = $_POST['idBaja'];
$DescripcionArchivo = $_POST['DescripcionArchivo'];
$doc0 = $_FILES['Archivo_file'] ?? [''];
$docs = [$doc0];
$indice = 0;

echo $DocumentosPersonal->agregarArchivoBajaPersonal($idBaja,$DescripcionArchivo,$docs,$indice);
break;


/* ---------- EDITAR ----------*/
case 'editar-informacion-personal':
$idEstacion = $_POST['idEstacion'];
$idPersonal = $_POST['idPersonal'];
$FechaIngreso = $_POST['FechaIngreso'];
$NoColaborador = $_POST['NoColaborador'];
$NombreCompleto = $_POST['NombreCompleto'];
$Puesto = $_POST['Puesto'];
$sd = $_POST['sd'];
$infoPersonal = [$idEstacion, $idPersonal, $FechaIngreso, $NoColaborador, $NombreCompleto, $Puesto, $sd];

$doc0 = $_FILES['DocumentoPersonal_file'] ?? [''];
$doc1 = $_FILES['DocumentoCV_file'] ?? [''];
$doc2 = $_FILES['DocumentoINE_file'] ?? [''];
$doc3 = $_FILES['DocumentoNacimiento_file'] ?? [''];
$doc4 = $_FILES['DocumentoDomicilio_file'] ?? [''];
$doc5 = $_FILES['DocumentoNSS_file'] ?? [''];
$doc6 = $_FILES['DocumentoEstudios_file'] ?? [''];
$doc7 = $_FILES['DocumentoRecomendacion_file'] ?? [''];
$doc8 = $_FILES['DocumentoCURP_file'] ?? [''];
$doc9 = $_FILES['DocumentoInfonavit_file'] ?? [''];
$doc10 = $_FILES['DocumentoRFC_file'] ?? [''];
$doc11 = $_FILES['DocumentoAntecedentes_file'] ?? [''];
$doc12 = $_FILES['DocumentoContrato_file'] ?? [''];
$docs = [$doc0, $doc1, $doc2, $doc3, $doc4, $doc5, $doc6, $doc7, $doc8, $doc9, $doc10, $doc11, $doc12];

echo $DocumentosPersonal->editarInformacionPersonal($infoPersonal,$docs);
break;
    
case 'editar-proceso-baja-personal':
$idBaja = $_POST['idBaja'];
$Proceso = $_POST['Proceso'];
$Status = $_POST['Status'];

echo $DocumentosPersonal->editarProcesoBaja($idBaja,$Proceso,$Status);
break;

/* ---------- ELIMINAR ----------*/
case 'eliminar-archivo-baja-personal':
$idArchivo = $_POST['idArchivo'];
echo $DocumentosPersonal->eliminarArchivoBajaPersonal($idArchivo);
break;

case 'eliminar-lista-negra':
$idListaNegra = $_POST['idListaNegra'];
echo $DocumentosPersonal->eliminarListaNegraPersonal($idListaNegra);
break;
    
    

endswitch;   