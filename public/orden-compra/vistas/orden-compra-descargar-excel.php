<?php
require 'app/help.php';
require 'app/phpoffice/vendor/autoload.php'; // Asegúrate de incluir PhpSpreadsheet correctamente

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Crear un nuevo archivo de Excel
$spreadsheet = new Spreadsheet();

// ---------- PAGINA 1 ----------//
$sheet4 = $spreadsheet->getActiveSheet();
$sheet4->setTitle("Orden de Compra");

$sql = "SELECT * FROM op_orden_compra WHERE id = '" . $GET_idReporte . "'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

$estatus = $row['estatus'] ?? '';
$iva_tb = $row['iva'] ?? '';
$no_control = $row['no_control'] ?? '';
$porcentaje_total = $row['porcentaje_total'] ?? '';
$cargo = $row['cargo'] ?? '';
$explode = explode(" ", $row['fecha'] ?? '');
$Fecha = $explode[0] ?? '';

// Escribir los datos de la orden de compra en la segunda hoja
$sheet4->setCellValue('A1', 'Dep. Almacén');
$sheet4->setCellValue('B1', '');
$sheet4->setCellValue('C1', 'ORDEN DE COMPRA');
$sheet4->setCellValue('D1', 'Cargo:');
$sheet4->setCellValue('E1', $cargo);

$sheet4->setCellValue('A2', 'Ref. Operativa');
$sheet4->setCellValue('D2', 'Fecha:');
$sheet4->setCellValue('E2', $Fecha);

$sheet4->setCellValue('A3', 'Refacturación');
$sheet4->setCellValue('B3', $porcentaje_total);
$sheet4->setCellValue('D3', 'No. De control:');
$sheet4->setCellValue('E3', '00' . $no_control);


// ---------- PAGINA 2 ----------//
$sheet3 = $spreadsheet->createSheet();
$sheet3->setTitle("Datos de la Estación");

$sql_lista = "SELECT op_rh_localidades.localidad 
FROM op_orden_compra_razon_social 
INNER JOIN op_rh_localidades ON op_rh_localidades.id = op_orden_compra_razon_social.id_estacion 
WHERE op_orden_compra_razon_social.id_ordencompra = '" . $GET_idReporte . "'";

$result_lista = mysqli_query($con, $sql_lista);
$row_lista = mysqli_fetch_assoc($result_lista);
$nombreES = $row_lista['localidad'] ?? '';

// Determinar la información según la localidad
if ($nombreES == "Quitarga") {
    $nombreRS = "COMERCIAL GASOLINERA QUITARGA";
    $rfc = "CGQ120525C15";
    $contacto = "Calle Plaza Tajin No. 433, Col. CTM Culhuacan Secc. V, C.P. 04480";
} elseif ($nombreES == "Comercializadora") {
    $nombreRS = "COMERCIALIZALIZADORA DE ARTICULOS GASOLINEROS";
    $rfc = "CAG05052557A";
    $contacto = "Carretera Rio Hondo Huixquilucan No. 401, San Bartolomé Coatepec, C.P. 52770";
} else {
    $sql_lista_es = "SELECT razonsocial, rfc, direccioncompleta FROM tb_estaciones WHERE nombre = '$nombreES'";
    $result_lista_es = mysqli_query($con, $sql_lista_es);
    $row_lista_es = mysqli_fetch_assoc($result_lista_es);
    $nombreRS = $row_lista_es['razonsocial'] ?? 'N/A';
    $rfc = $row_lista_es['rfc'] ?? 'N/A';
    $contacto = $row_lista_es['direccioncompleta'] ?? 'N/A';
}

// Escribir datos en la hoja
$sheet3->setCellValue('A1', 'Razón Social');
$sheet3->setCellValue('B1', $nombreRS);
$sheet3->setCellValue('A2', 'RFC');
$sheet3->setCellValue('B2', $rfc);
$sheet3->setCellValue('A3', 'Dirección');
$sheet3->setCellValue('B3', $contacto);


// ---------- PAGINA 3 ----------//
$sheet5 = $spreadsheet->createSheet();
$sheet5->setTitle("Datos del proveedor");

// Encabezados de la tabla
$arrayHeadDetalles2 = array(
    'Razón Social',
    'Dirección',
    'Contacto',
    'Email'
);

// Agregar encabezados a la hoja
$sheet5->fromArray($arrayHeadDetalles2, NULL, 'A1');

// Consultar datos y llenarlos en la hoja
$sqlP = "SELECT * FROM op_orden_compra_proveedor WHERE id_ordencompra = '".$GET_idReporte."' ";
$resultP = mysqli_query($con, $sqlP);
$rowIndex2 = 2;

while ($row2 = mysqli_fetch_array($resultP, MYSQLI_ASSOC)) {

    $arrayContenido2 = array(
        $row2['razon_social'],
        $row2['direccion'],
        $row2['contacto'],
        $row2['email']
    );

    $sheet5->fromArray($arrayContenido2, NULL, "A$rowIndex2");
    $rowIndex2++;
}

// ---------- PAGINA 4 ----------//
$sheet7 = $spreadsheet->createSheet();
$sheet7->setTitle("Cuadro Proveedores");

// Encabezados de la tabla
$arrayHeadDetalles7 = array(
    'Mejor Oferta',
    'Concepto',
    'Unidades',
    'Estatus',
    'Precio Unitario',
    'Subtotal',
    'IVA',
    'Total (Subtotal * IVA)',
    'Total'
);

// Agregar encabezados a la hoja
$sheet7->fromArray($arrayHeadDetalles7, NULL, 'A1');

// Consultar proveedores
$sqlP = "SELECT * FROM op_orden_compra_proveedor WHERE id_ordencompra = '".$GET_idReporte."' ";
$resultP = mysqli_query($con, $sqlP);
$numeroP = mysqli_num_rows($resultP);

$rowIndex = 2; // Comenzamos a escribir desde la fila 2

if ($numeroP > 0) {
    $num = 1;

    while ($rowP = mysqli_fetch_array($resultP, MYSQLI_ASSOC)) {
        $idProveedor = $rowP['id'];
        $razonsocialP = $rowP['razon_social'];
        $descuento = $rowP['descuento'];
        $envio_cp = $rowP['envio_cp'];
        $CheckProveedor = $rowP['check_p'];

        // Inicializamos los totales para cada proveedor
        $totalUnidades = 0;
        $totalPrecioU = 0;
        $totalSubTotal = 0;
        $totalIVA = 0;
        $totalGeneral = 0;

        // Agregar Proveedor
        $sheet7->setCellValue("A$rowIndex", "Proveedor: $razonsocialP");

        // Establecer el estilo de la celda
        $sheet7->getStyle("A$rowIndex")->getFont()->setBold(true); // Poner en negritas
        
        $sheet7->mergeCells("A$rowIndex:I$rowIndex");
        $sheet7->getRowDimension($rowIndex)->setRowHeight(25);
        
        $rowIndex++;

        // Consultar artículos del proveedor
        $sql_lista = "SELECT * FROM op_orden_compra_articulo WHERE id_ordencompra = '".$GET_idReporte."' AND id_proveedor = '".$idProveedor."' ORDER BY id ASC";
        $result_lista = mysqli_query($con, $sql_lista);
        $numero_lista = mysqli_num_rows($result_lista);

        if ($numero_lista > 0) {
            while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
                $unidades = $row_lista['unidades'];
                $precio_unitario = $row_lista['precio_unitario'];
                $subtotal_tb = $unidades * $precio_unitario;
                $subtotalPU_IVA = ($subtotal_tb - $descuento + $envio_cp) * 0.16; // IVA 16%
                $Total = $subtotal_tb + $subtotalPU_IVA;

                // Llenar datos de la tabla
                $sheet7->setCellValue("A$rowIndex", ''); // Mejor oferta (espacio vacío)
                $sheet7->setCellValue("B$rowIndex", $row_lista['concepto']);
                $sheet7->setCellValue("C$rowIndex", $unidades);
                $sheet7->setCellValue("D$rowIndex", $row_lista['estatus_r']);
                $sheet7->setCellValue("E$rowIndex", '$ ' . number_format($precio_unitario, 2));
                $sheet7->setCellValue("F$rowIndex", '$ ' . number_format($subtotal_tb, 2));
                $sheet7->setCellValue("G$rowIndex", '16%');
                $sheet7->setCellValue("H$rowIndex", '$ ' . number_format($subtotalPU_IVA, 2));
                $sheet7->setCellValue("I$rowIndex", '$ ' . number_format($Total, 2));

                // Actualizar totales
                $totalUnidades += $unidades;
                $totalPrecioU += $precio_unitario;
                $totalSubTotal += $subtotal_tb;
                $totalIVA += $subtotalPU_IVA;
                $totalGeneral += $Total;

                $rowIndex++;
            }

            // Sumar el total
            $subtotal3 = $totalSubTotal - $descuento + $envio_cp;
            $totalFinal = $totalIVA + $subtotal3;

            // Escribir los totales
            $sheet7->setCellValue("A$rowIndex", "SUMA");
            $sheet7->setCellValue("F$rowIndex", '$ ' . number_format($totalSubTotal, 2));
            $sheet7->setCellValue("A" . ($rowIndex + 1), "DESCUENTO");
            $sheet7->setCellValue("F" . ($rowIndex + 1), '$ ' . number_format($descuento, 2));
            $sheet7->setCellValue("A" . ($rowIndex + 2), "ENVIO");
            $sheet7->setCellValue("F" . ($rowIndex + 2), '$ ' . number_format($envio_cp, 2));
            $sheet7->setCellValue("A" . ($rowIndex + 3), "SUBTOTAL");
            $sheet7->setCellValue("F" . ($rowIndex + 3), '$ ' . number_format($subtotal3, 2));
            $sheet7->setCellValue("A" . ($rowIndex + 4), "IVA");
            $sheet7->setCellValue("F" . ($rowIndex + 4), '$ ' . number_format($totalIVA, 2));
            $sheet7->setCellValue("A" . ($rowIndex + 5), "TOTAL A PAGAR");
            $sheet7->setCellValue("F" . ($rowIndex + 5), '$ ' . number_format($totalFinal, 2));

            // Actualizamos el índice de la fila
            $rowIndex += 6;
        }
        $num++;
    }
}


// ---------- PAGINA 5 ----------//
$sheet1 = $spreadsheet->createSheet();
$sheet1->setTitle('Refacturación');

// Encabezados de la tabla
$arrayHeadDetalles8 = array(
    'Prorroteo (Estación)',
    'Descripción',
    'Cantidad',
    'Importe',
    'Porcentaje',
    'Estación',
    'Almacén',
    'Total'
);

// Agregar encabezados a la hoja
$sheet1->fromArray($arrayHeadDetalles8, NULL, 'A1');

// Consultar datos y llenarlos en la hoja
$sql = "SELECT * FROM op_orden_compra_refacturacion WHERE id_ordencompra = '" . $GET_idReporte . "'";
$result = mysqli_query($con, $sql);
$rowIndex = 2;

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $Estacion = Estacion($row['id_estacion'], $con);
    $total = $row['cantidad'] * $row['importe'];

    $arrayContenido = array(
        $Estacion['nombre'],
        $row['descripcion'],
        $row['cantidad'],
        number_format($row['importe'], 2),
        number_format($row['porcentaje'], 2),
        $row['cantidadES'],
        $row['cantidadAl'],
        number_format($total, 2)
    );

    $sheet1->fromArray($arrayContenido, NULL, "A$rowIndex");
    $rowIndex++;
}

// ---------- PAGINA 6 ----------//
$sheet2 = $spreadsheet->createSheet();
$sheet2->setTitle('Totales');

// Encabezados de la tabla de totales
$arrayHeadTotales = array('Concepto', 'Total');
$sheet2->fromArray($arrayHeadTotales, NULL, 'A1');

// Consultar y calcular totales
$sql_DatosProveedor = "SELECT descuento, envio_cp FROM op_orden_compra_proveedor 
                       WHERE id_ordencompra = '" . $GET_idReporte . "' AND check_p = 1";
$result_DatosProveedor = mysqli_query($con, $sql_DatosProveedor);

if ($row_DatosProveedor = mysqli_fetch_array($result_DatosProveedor, MYSQLI_ASSOC)) {
    $descuento = $row_DatosProveedor['descuento'];
    $envio_cp = $row_DatosProveedor['envio_cp'];
} else {
    $descuento = 0;
    $envio_cp = 0;
}

$sqlTotales = "SELECT cantidad, importe FROM op_orden_compra_refacturacion 
               WHERE id_ordencompra = '" . $GET_idReporte . "'";
$resultTotales = mysqli_query($con, $sqlTotales);

$subTotalGeneral = 0;

while ($row = mysqli_fetch_array($resultTotales, MYSQLI_ASSOC)) {
    $subTotalGeneral += $row['cantidad'] * $row['importe'];
}

$totalIVA = ($subTotalGeneral - $descuento + $envio_cp) * 0.16;
$totalFinal = $subTotalGeneral - $descuento + $envio_cp + $totalIVA;

// Preparar datos para la tabla de totales
$totales = array(
    array('Subtotal General', number_format($subTotalGeneral, 2)),
    array('Descuento', number_format($descuento, 2)),
    array('Costo de Envío', number_format($envio_cp, 2)),
    array('Subtotal con Descuento y Envío', number_format($subTotalGeneral - $descuento + $envio_cp, 2)),
    array('IVA (16%)', number_format($totalIVA, 2)),
    array('Total Final', number_format($totalFinal, 2))
);

$sheet2->fromArray($totales, NULL, 'A2');


// Guardar el archivo Excel y enviarlo al navegador
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Reporte_Orden_Compra_00'.$no_control.'.xlsx"');
$writer->save('php://output');
exit;

// Función para obtener la estación
function Estacion($idEstacion, $con){
  $sql_listaestacion = "SELECT nombre, direccioncompleta FROM tb_estaciones WHERE id = '".$idEstacion."' ";
  $result_listaestacion = mysqli_query($con, $sql_listaestacion);
  while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
  $nombre = $row_listaestacion['nombre'];
  $direccioncompleta = $row_listaestacion['direccioncompleta'];
  }
  
  return $arrayName = array('nombre' => $nombre, 'direccioncompleta' => $direccioncompleta);
  }
?>
