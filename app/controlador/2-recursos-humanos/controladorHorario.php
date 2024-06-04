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
endswitch;