<?php
require "../../modelo/1-corporativo/Ingresos.php";
$ingresos = new Ingresos();
switch ($_POST['accion']) :
    case 'editar-ingreso-facturacion':
        $id = $_POST['id'];
        $valor = $_POST['valor'];
        $mes = $_POST['mes'];
        echo $ingresos->editarIngreso($id, $valor,$mes);
        break;
    case 'agregar-ingreso-facturacion-archivo':
        $file = $_FILES['Archivo_file'];
        $id = $_POST['idReporte'];
        echo $ingresos->agregarArchivoIngreso($id, $file);
        break;
    case 'eliminar-ingreso-facturacion-archivo':
        $id = $_POST['id'];
        echo $ingresos->eliminarArchivoIngresos($id);
        break;
endswitch;