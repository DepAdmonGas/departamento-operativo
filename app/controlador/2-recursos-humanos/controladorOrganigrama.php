<?php
require "../../modelo/2-recursos-humanos/Organigrama.php";
$organigrama = new Organigrama();
switch($_POST['accion']):
    case 'guardar-organigrama':
        $idEstacion = $_POST['idEstacion'];
        $observaciones = $_POST['Observaciones'] ?? "";
        $file = $_FILES['seleccionArchivos_file'];
        echo $organigrama->agregarOrganigrama($idEstacion,$observaciones,$file);
        break;
    case 'eliminar-organigrama':
        $id = $_POST['idOrganigrama'];
        echo $organigrama->eliminarOrganigrama($id);
        break;
endswitch;