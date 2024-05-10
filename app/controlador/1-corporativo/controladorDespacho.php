<?php
require "../../modelo/1-corporativo/Despacho.php";
$despacho = new Despacho();
switch ($_POST['accion']) :
    case 'editar-despacho-factura':
        $despa = $_POST['Despacho'];
        $input = $_POST['input'];
        $dia = $_POST['idDias'];
        echo $despacho->editarDespacho($input, $dia, $despa);
        break;
endswitch;