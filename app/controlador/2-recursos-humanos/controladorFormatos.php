<?php
require "../../modelo/2-recursos-humanos/Formatos.php";
$formatos = new Formatos();
switch($_POST['accion']):

    case 'agregar-formulario':
    $idEstacion = $_POST['idEstacion'];
    $formato = $_POST['Formato'];
    echo $formatos->formatos($idEstacion,$formato);
    break;

    //---------- 1. ALTA DEL PERSONAL ----------
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

    //---------- 2. BAJA DEL PERSONAL ----------
    case 'agregar-personal-baja':
    $idReporte = $_POST['idReporte'];
    $idEstacion = $_POST['idEstacion'];
    $NombreCompleto = $_POST['NombreCompleto'];
    $FechaBaja = $_POST['FechaBaja'];
    $Motivo = $_POST['Motivo'];
    $Detalle = $_POST['Detalle'];

    echo $formatos->guardarBajaPersonal($idReporte, $idEstacion, $NombreCompleto, $FechaBaja, $Motivo, $Detalle);
    break;
 
    case 'eliminar-personal-baja':
    $idUsuario = $_POST['idUsuario'];
    echo $formatos->eliminarBajaPersonal($idUsuario);
    break;
 
    //---------- 3. FALTA DEL PERSONAL ----------
    case 'agregar-personal-falta':
    $idReporte = $_POST['idReporte'];
    $idEstacion = $_POST['idEstacion'];
    $NombreCompleto = $_POST['NombreCompleto'];
    $FechaFalta = $_POST['FechaFalta'];
        
    echo $formatos->guardarFaltaPersonal($idReporte, $idEstacion, $NombreCompleto, $FechaFalta);
    break;

     
    case 'eliminar-personal-falta':
    $idUsuario = $_POST['idUsuario'];
    echo $formatos->eliminarFaltaPersonal($idUsuario);
    break;
         
    //---------- 4. REESTRUCTURACIÓN DE PERSONAL ----------
    case 'agregar-personal-reestructuracion':
    $idReporte = $_POST['idReporte'];
    $idEstacion = $_POST['idEstacion']; 
    $NombreCompleto = $_POST['NombreCompleto'];
    $NombreEstacion = $_POST['NombreEstacion'];
    $FechaAplicacion = $_POST['FechaAplicacion'];
    echo $formatos->guardarReestructuracionPersonal($idReporte, $idEstacion, $NombreCompleto, $NombreEstacion, $FechaAplicacion);
    break;

    case 'eliminar-personal-reestructuración':
    $idUsuario = $_POST['idUsuario'];
    echo $formatos->eliminarReestructuracionPersonal($idUsuario);
    break;
    
    //---------- 5. AJUSTE SALARIAL ----------
    case 'agregar-ajuste-salarial':
    $idReporte = $_POST['idReporte'];
    $idEstacion = $_POST['idEstacion']; 
    $NombreCompleto = $_POST['NombreCompleto'];
    $AjusteSalario = $_POST['AjusteSalario'];
    $FechaAplicacion = $_POST['FechaAplicacion'];
    echo $formatos->guardarAjusteSalarial($idReporte, $idEstacion, $NombreCompleto, $AjusteSalario, $FechaAplicacion);
    break;

    case 'eliminar-ajuste-salarial':
    $idUsuario = $_POST['idUsuario'];
    echo $formatos->eliminarAjusteSalarial($idUsuario);
    break;

    //---------- 6. VACACIONES DE PERSONAL ----------//
    case 'agregar-vacaciones-personal':
    $idReporte = $_POST['idReporte'];
    $Personal = $_POST['Personal'];
    $NumDias = $_POST['NumDias'];
    $FechaInicio = $_POST['FechaInicio'];
    $FechaTermino = $_POST['FechaTermino'];
    $FechaRegreso = $_POST['FechaRegreso'];
    $Observaciones = $_POST['Observaciones'];
    echo $formatos->guardarVacacionesPersonal($idReporte, $Personal, $NumDias, $FechaInicio, $FechaTermino, $FechaRegreso, $Observaciones);
    break;

    case 'eliminar-vacaciones-personal':
    $idUsuario = $_POST['idUsuario'];
    echo $formatos->eliminarVacacionesPersonal($idUsuario);
    break;

    //---------- 7. PRIMA VACACIONAL ----------//
    case 'agregar-prima-vacacional':
    $idReporte = $_POST['idReporte'];
    $idEstacion = $_POST['idEstacion'];
    $NombresCompleto = $_POST['NombresCompleto'];
    $Periodo = $_POST['Periodo'];
    echo $formatos->guardarPrimaVacacional($idReporte, $idEstacion, $NombresCompleto, $Periodo);
    break;

    case 'eliminar-prima-vacacional':
    $idUsuario = $_POST['idUsuario'];
    echo $formatos->eliminarPrimaVacacional($idUsuario);
    break;

    //---------- COMENTARIOS ----------//
    case 'agregar-comentario-formatos':
    $idFormato = $_POST['idFormato'];
    $idUsuario = $_POST['idUsuario'];
    $Comentario = $_POST['Comentario'];
    echo $formatos->agregarComentarioFormato($idFormato,$idUsuario,$Comentario);
    break;

    //---------- FIRMA FORMATOS ----------//
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
    $estacion = $_POST['estacion'];
    echo $formatos->firmaFormatosToken($idFormato,$idVal,$idUsuario,$tokenWhats,$idTipo,$estacion);
    break;

    case 'crear-token-email':
    $idFormato = $_POST['idFormato'];
    $idUsuario = $_POST['idUsuario'];
    echo $formatos->firmaFormatosTokenEmail($idFormato,$idUsuario);
    break;
 
    case 'firmar-formato-martin':
    $idFormato = $_POST['idFormato'];
    $idUsuario = $_POST['idUsuario'];
    $tipoFirma = $_POST['tipoFirma'];
    $token = $_POST['TokenValidacion'];
    echo $formatos->firmarMartin($tipoFirma,$idFormato,$idUsuario,$token);
    break;

    //---------- ELIMINAR FORMATOS ----------//
    case 'eliminar-formato':
    $idReporte = $_POST['idReporte'];
    echo $formatos->eliminarFormato($idReporte);
    break;



endswitch;     