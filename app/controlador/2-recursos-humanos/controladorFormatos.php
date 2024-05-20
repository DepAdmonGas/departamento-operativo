<?php
require "../../modelo/2-recursos-humanos/Formatos.php";
$formatos = new Formatos();
switch($_POST['accion']):
    case 'formulario':
        $idEstacion = $_POST['idEstacion'];
        $formato = $_POST['Formato'];
        echo $formatos->formatos($idEstacion,$formato);
        break;
    case 'guardar-personal':
        $doc1  = $_FILES['Documento_file'] ?? [''];
        $doc2  = $_FILES['DocumentoCURP_file'] ?? [''];
        $doc3  = $_FILES['DocumentoRFC_file'] ?? [''];
        $doc4  = $_FILES['DocumentoNSS_file'] ?? [''];
        $doc5  = $_FILES['DocumentoINE_file'] ?? [''];
        $docs = [$doc1,$doc2,$doc3, $doc4,$doc5];
        $idReporte = $_POST['idReporte'];
        $fechaIngreso = $_POST['FechaIngreso'];
        $nombres = $_POST['Nombres'];
        $apellidoP = $_POST['ApellidoP'];
        $apellidoM = $_POST['ApellidoM'];
        $puesto = $_POST['Puesto'];
        $salario = $_POST['SalarioD'];
        $detalle = $_POST['Detalle'];
        echo $formatos->guardarPersonal($docs,$idReporte,$fechaIngreso,$nombres, $apellidoP,$apellidoM,$puesto, $salario, $detalle);
        break;
    case '':
        break;
endswitch;