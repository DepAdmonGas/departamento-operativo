<?php
require "../../modelo/2-recursos-humanos/ProgramarHorario.php";
$horario = new Horarios();
switch ($_POST['accion']):
    /**
     * 
     * Programar Horario
     * 
     */
    case 'agregar-horario':
        $idEstacion = $_POST['idEstacion'];
        echo $horario->agregarHorario($idEstacion);
        break;
    case 'elimnar-horario':
        $idReporte = $_POST['idReporte'];
        echo $horario->eliminaHorario($idReporte);
        break;
    case 'editar-horario':
        $hora = $_POST['horario'];
        $dia = $_POST['dia'];
        $idPersonal = $_POST['idPersonal'];
        $idReporte = $_POST['idReporte'];
        $idEstacion = $_POST['idEstacion'];
        echo $horario->editarEstacion($hora, $dia, $idPersonal, $idReporte, $idEstacion);
        break;
    case 'guardar-horario':
        $fecha = $_POST['Fecha'];
        $idReporte = $_POST['idReporte'];
        echo $horario->guardarHorario($fecha, $idReporte);
        break;
    /**
     * 
     * 
     * Horario Personal
     * 
     * 
     * 
     */
    case 'editar-horario-personal':
     $hora = $_POST['horario'];
    $dia = $_POST['dia'];
    $idPersonal = $_POST['idPersonal'];
    echo $horario->editarHorarioPersonal($hora,$dia,$idPersonal);
    break;


    /** ---------- ROL DE COMODINES ---------- **/
    case 'agregar-rol-comodines':
    $idEstacion = $_POST['idEstacion'];
    echo $horario->agregarFormularioComodines($idEstacion);
    break;

    case 'editar-estacion-comodin':
    $idReporte = $_POST['idReporte'];
    $idUsuario = $_POST['idUsuario'];
    $idEstacion = $_POST['idEstacion'];
    $dia = $_POST['dia'];
    echo $horario->editarEstacionComodines($idReporte, $idUsuario, $idEstacion, $dia);
    break;

    case 'finalizar-rol-comodines':
    $idReporte = $_POST['idReporte'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaTermino = $_POST['fechaTermino'];
    echo $horario->finalizarRolComodines($idReporte, $fechaInicio, $fechaTermino);
    break;

    /** ---------- DIAS DOBLES ---------- **/
    case 'agregar-dia-doble-reporte':
    $year = $_POST['year'];
    $quincena = $_POST['quincena'];
    echo $horario->agregarDiaDobleOP($year, $quincena);
    break;
      
    case 'agregar-horario-doble-personal':
    $idReporte = $_POST['idReporte'];
    $NombreCompleto = $_POST['NombreCompleto'];
    $FechaDiaDoble = $_POST['FechaDiaDoble'];
    echo $horario->agregarDiaDoblePersonal($idReporte, $NombreCompleto, $FechaDiaDoble);
    break;

    case 'editar-quincena-dia-doble':
    $idReporte = $_POST['idReporte'];
    $quincena = $_POST['quincena'];
    echo $horario->editarQuincenaDiaDoble($idReporte, $quincena);
    break;

    case 'eliminar-horario-personal-do':
    $id = $_POST['id'];
    echo $horario->eliminarHorarioPersonal($id);
    break;

    case 'eliminar-formato-horario-do':
    $id = $_POST['id'];
    echo $horario->eliminarHorarioFormato($id);
    break;

    //---------- FIRMA DIAS DOBLES ----------//
    case 'finalizar-dia-doble-firma':
    $img = $_POST['base64'];
    $idReporte = $_POST['idReporte'];
    $idUsuario = $_POST['idUsuario'];
    $tipoFirma = $_POST['tipoFirma'];
    echo $horario->firmaDiaDoble($idReporte,$idUsuario,$tipoFirma,$img);
    break;

    case 'firmar-dia-doble-token':
    $idFormato = $_POST['idFormato'];
    $idVal = $_POST['idVal'];
    $idUsuario = $_POST['idUsuario'];
    $tokenWhats = $_POST['token'];
    $fecha = $_POST['fecha'];
    echo $horario->firmaFormatosToken($idFormato,$idVal,$idUsuario,$tokenWhats,$fecha);
    break;

    case 'crear-token-email':
    $idFormato = $_POST['idFormato'];
    $idUsuario = $_POST['idUsuario'];
    echo $horario->firmaFormatosTokenEmail($idFormato,$idUsuario);
    break;

    case 'firmar-formato-martin':
    $idFormato = $_POST['idFormato'];
    $idUsuario = $_POST['idUsuario'];
    $tipoFirma = $_POST['tipoFirma'];
    $token = $_POST['TokenValidacion'];
    echo $horario->firmarMartin($tipoFirma,$idFormato,$idUsuario,$token);
    break; 
    
    //---------- COMENTARIOS ----------//
    case 'agregar-comentario-dia-doble':
    $idReporte = $_POST['idReporte'];
    $idUsuario = $_POST['idUsuario'];
    $Comentario = $_POST['Comentario'];
    echo $horario->agregarComentarioDiaDoble($idReporte,$idUsuario,$Comentario);
    break;

    

endswitch;