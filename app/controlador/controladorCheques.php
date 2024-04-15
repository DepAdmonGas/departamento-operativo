<?php
require "../modelo/SolicitudCheques.php";
switch($_POST['Accion']){
    case'agregar-archivo-solicitud-cheque':
        return SolicitudCheques::agregarArchivoSolicitudCheque($_POST['idReporte'],$_POST['Documento'],$_POST['session_IDUsuarioBD']);
        break;
}
?>