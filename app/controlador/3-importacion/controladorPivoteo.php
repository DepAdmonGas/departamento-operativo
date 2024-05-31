<?php
require "../../modelo/3-importacion/Pivoteo.php";
$pivote = new Pivoteo();
switch($_POST['accion']):
    case 'nuevo-pivoteo':
        $idEstacion = $_POST['idEstacion'];
        echo $pivote->agregarPivote($idEstacion);
        break;
    case 'eliminar-pivoteo':
        $id = $_POST['id'];
        echo $pivote->eliminaPivote($id);  
        break;
    case 'pivoteo-detalle':
        $idEstacion = $_POST['idEstacion'];
        $idReporte = $_POST['idReporte'];
        $producto = $_POST['Producto'];
        $tanque = $_POST['Tanque'];
        $litros = $_POST['Litros'];
        $tad = $_POST['TAD'];
        $unidad = $_POST['Unidad'];
        $chofer = $_POST['Chofer'];
        echo $pivote->detallePivoteo($idEstacion,$idReporte,$producto,$tanque,$litros,$tad,$unidad,$chofer);
        break;
    case 'eliminar-factura':
        $id = $_POST['id'];
        echo $pivote->eliminaFactura($id);
        break;
    case 'finalizar-detalle':
        $id = $_POST['idReporte'];
        echo $pivote->finalizardetalleReporte($id);
        break;
endswitch;