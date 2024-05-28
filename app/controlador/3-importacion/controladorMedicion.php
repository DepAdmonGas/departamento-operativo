<?php
require "../../modelo/3-importacion/Medicion.php";
$medicion = new Medicion();
switch($_POST['accion']):
    case 'guardar-medicion':
        $idEstacion=$_POST['idEstacion'];
        $fecha = $_POST['Fecha'];
        $factura = $_POST['Factura'];
        $neto = $_POST['Neto'];
        $bruto = $_POST['Bruto'];
        $cuentaLitros = $_POST['CuentaLitros'];
        $provedor = $_POST['Proveedor'];
        echo $medicion->guardarMedicion($idEstacion,$fecha,$factura,$neto,$bruto,$cuentaLitros,$provedor); 
        break;
    case 'eliminar-medicion':
        $id = $_POST['id'];
        echo $medicion->eliminarMedicion($id);
        break;
endswitch;