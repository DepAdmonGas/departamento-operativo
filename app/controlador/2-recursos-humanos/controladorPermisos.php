<?php
require "../../modelo/2-recursos-humanos/Permisos.php";
$permisos = new Permisos();
switch($_POST['accion']):
    case 'eliminar-permiso':
        $id = $_POST['idPermiso'];
        echo $permisos->eliminarPermisos($id);
        break;
    case 'agregar-permiso':
        $img = $_POST['base64'];
        $estacion = $_POST['Estacion'];
        $colaborador = $_POST['Colaborador'];
        $fechaInicio = $_POST['FechaInicio'];
        $fechaFin = $_POST['FechaTermino'];
        $diasTomados = $_POST['DiasTomados'];
        $cubre = $_POST['Cubre'];
        $motivo = $_POST['Motivo'];
        $observacion = $_POST['Observacion'];
        echo $permisos->agregarPermiso($img,$estacion,$colaborador,$fechaInicio,$fechaFin,$diasTomados,$cubre,$motivo,$observacion);
        break;
    case 'crear-token':
        $idReporte = $_POST['idReporte'];
        $idVal = $_POST['idVal'];
        echo $permisos->tokenPermiso($idReporte,$idVal);
        break;
    case 'firmar-permiso':
        $idReporte = $_POST['idReporte'];
        $tipoFirma = $_POST['tipoFirma'];
        $tokenValidacion = $_POST['TokenValidacion'];
        echo $permisos->firmarPermiso($idReporte,$tipoFirma,$tokenValidacion);
        break;
    case 'firma-quien-cubre':
        $img = $_POST['base64'];
        $idReporte = $_POST['idReporte'];
        $tipoFirma = $_POST['tipoFirma'];
        $idUsuario = $_POST['usuario'];
        echo $permisos->firmaQuienCubre($img,$idReporte,$tipoFirma,$idUsuario);
        break;
endswitch;