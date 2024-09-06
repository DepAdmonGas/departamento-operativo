<?php
require "../../modelo/2-recursos-humanos/Formatos.php";
$formatos = new Formatos();
switch($_POST['accion']):
   
    case 'agregar-formulario':
    $idEstacion = $_POST['idEstacion'];
    $formato = $_POST['Formato'];
    echo $formatos->formatos($idEstacion,$formato);
    break;

    case 'agregar-personal-alta':
    $idReporte = $_POST['idReporte'];
    $idEstacion = $_POST['idEstacion'];
    $NombreCompleto = $_POST['NombreCompleto'];
    $Puesto = $_POST['Puesto'];
    $FechaIngreso = $_POST['FechaIngreso'];
    $sd = $_POST['sd'];
    echo $formatos->guardarAltaPersonal($idReporte, $idEstacion, $NombreCompleto, $Puesto, $FechaIngreso, $sd);
    break;

    case 'eliminar-personal-alta':
    $idUsuario = $_POST['idUsuario'];
    echo $formatos->eliminarAltaPersonal($idUsuario);
    break;

    case 'finalizar-formato-firma':
    $img = $_POST['base64'];
    $idReporte = $_POST['idReporte'];
    $idUsuario = $_POST['idUsuario'];
    $tipoFirma = $_POST['tipoFirma'];
    echo $formatos->firmaFormatos($idReporte,$idUsuario,$tipoFirma,$img);
    break;


    case 'firmar-formato-token':
    $idFormato = $_POST['idFormato'];
    $idVal = $_POST['idVal'];
    $idUsuario = $_POST['idUsuario'];
    $tokenWhats = $_POST['token'];
    $idTipo = $_POST['idTipo'];
    echo $formatos->firmaFormatosToken($idFormato,$idVal,$idUsuario,$tokenWhats,$idTipo);
    break;


endswitch;     