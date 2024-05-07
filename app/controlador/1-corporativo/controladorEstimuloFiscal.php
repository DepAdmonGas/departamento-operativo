<?php
require "../../modelo/1-corporativo/EstimuloFiscal.php";
$EstimuloFiscal = new EstimuloFiscal();

switch($_POST['Accion']):

/* ---------- AGREGAR ----------*/
case 'agregar-estimulo-fiscal':
$idEstacion = $_POST['idEstacion'];
$MFInicio = $_POST['MFInicio'];
$MFTermino = $_POST['MFTermino'];
$PDF_file = $_FILES['PDF_file'] ?? ['']; 
$XML_file = $_FILES['XML_file'] ?? ['']; 
$docs = [$PDF_file, $XML_file];

echo $EstimuloFiscal->agregarEstimuloFiscal($idEstacion,$MFInicio,$MFTermino,$docs);
break;


/* ---------- EDITAR  ----------*/
case 'editar-estimulo-fiscal':
$IdReporte = $_POST['IdReporte'];
$idEstacion = $_POST['idEstacion'];
$EFInicio = $_POST['EFInicio'];
$EFTermino = $_POST['EFTermino'];
$EPDF_file = $_FILES['EPDF_file'] ?? [''];
$EXML_file = $_FILES['EXML_file'] ?? [''];
$CPDF_file = $_FILES['CPDF_file'] ?? [''];
$CXML_file = $_FILES['CXML_file'] ?? [''];
$docs = [$EPDF_file, $EXML_file, $CPDF_file, $CXML_file];
    
echo $EstimuloFiscal->editarEstimuloFiscal($IdReporte,$idEstacion,$EFInicio,$EFTermino,$docs);
break;

/* ---------- EDITAR  ----------*/
case 'eliminar-estimulo-fiscal':
$idReporte = $_POST['idReporte'];  
echo $EstimuloFiscal->eliminarEstimuloFiscal($idReporte);
break;


endswitch;