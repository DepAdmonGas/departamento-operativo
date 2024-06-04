<?php
require "../../modelo/3-importacion/Merma.php";
$merma = new Merma();
switch($_POST['accion']):
    case 'nuevo-formato':
        // documentos
        $facturaRemision = $_FILES['FacturaRemision_file']??[''];
        $inventarioInicial = $_FILES['InventarioInicial_file']??[''];
        $nice = $_FILES['Nice_file']??[''];
        $inventarioFinal = $_FILES['InventarioFinal_file']??[''];
        $metroContador = $_FILES['MetroContador_file']??[''];
        $MC20Grados = $_FILES['MC20Grados_file']??[''];
        $docs = [$facturaRemision,$inventarioInicial,$nice,$inventarioFinal,$metroContador,$MC20Grados];
        //firmas 
        $img1 = $_POST['baseImage1'] ?? [''];
        $img2 = $_POST['baseImage2'] ?? [''];
        $imgs = [$img1,$img2];
        // formulario
        $estacion = $_POST['Estacion'];
        $responsable = $_POST['Responsable'];
        $fechaLlegada = $_POST['Fechallegada'];
        $horallegada = $_POST['Horallegada'];
        $produtos = $_POST['Productos'];
        $sellos = $_POST['Sellos'];
        $sdvdld = $_POST['Sdvdld'];
        $mermaformulario = $_POST['Merma'];
        $operador = $_POST['Operador'];
        $transportista = $_POST['Transportista'];
        $factura = $_POST['NoFactura'];
        $litros = $_POST['Litros'];
        $precioLitro = $_POST['PrecioLitro'];
        $unidad = $_POST['Unidad'];
        $cuentaLitros = $_POST['CuentaLitros'];
        $formulario =[$estacion,$responsable,$fechaLlegada,$horallegada,$produtos,$sellos,$sdvdld,$mermaformulario,$operador,
                $transportista,$factura,$litros,$precioLitro,$unidad,$cuentaLitros];
        echo $merma->nuevoFormato($formulario,$docs,$imgs);
        break;
    case 'editar-formato-merma':
        // documentos
        $facturaRemision = $_FILES['FacturaRemision_file'] ?? [];
        $inventarioInicial = $_FILES['InventarioInicial_file'] ?? [];
        $nice = $_FILES['Nice_file'] ?? [];
        $inventarioFinal = $_FILES['InventarioFinal_file'] ?? [];
        $metroContador = $_FILES['MetroContador_file'] ?? [];
        $MC20Grados = $_FILES['MC20Grados_file'] ?? [];
        $docs = [$facturaRemision, $inventarioInicial, $nice, $inventarioFinal, $metroContador, $MC20Grados];

        // formulario
        $fechaLlegada = $_POST['Fechallegada'];
        $horallegada = $_POST['Horallegada'];
        $produtos = $_POST['Productos'];
        $sellos = $_POST['Sellos'];
        $sdvdld = $_POST['Sdvdld'];
        $mermaformulario = $_POST['Merma'];
        $operador = $_POST['Operador'];
        $transportista = $_POST['Transportista'];
        $factura = $_POST['NoFactura'];
        $litros = $_POST['Litros'];
        $precioLitro = $_POST['PrecioLitro'];
        $unidad = $_POST['Unidad'];
        $cuentaLitros = $_POST['CuentaLitros'];
        $id = $_POST['idFormato'];
        $formulario =[$fechaLlegada,$horallegada,$produtos,$sellos,$sdvdld,$mermaformulario,$operador,
                $transportista,$factura,$litros,$precioLitro,$unidad,$cuentaLitros,$id];
        echo $merma->editaFormato($formulario,$docs);
        break;
    case 'elimina-formato-merma':
        $id = $_POST['idReporte'];
        echo $merma->eliminaFormatoMerma($id);
        break;
    endswitch;