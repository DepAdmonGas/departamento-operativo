<?php
error_reporting(error_level: 0);
require 'app/help.php';
require 'phpoffice/vendor/autoload.php'; 

$sql_pedido = "SELECT * FROM op_pedido_materiales WHERE id = '".$GET_idPedido."' ";
$result_pedido = mysqli_query($con, $sql_pedido);
$numero_pedido = mysqli_num_rows($result_pedido);
while($row_pedido = mysqli_fetch_array($result_pedido, MYSQLI_ASSOC)){
$folio = $row_pedido['folio'];
$id_estacion = $row_pedido['id_estacion'];
$fecha = $row_pedido['fecha'];
$afectacion = $row_pedido['afectacion'];
$estatus = $row_pedido['estatus'];
$tiposervicio = $row_pedido['tipo_servicio'];
$ordentrabajo = $row_pedido['orden_trabajo'];
$ordenriesgo = $row_pedido['orden_riesgo'];
$comentarios = $row_pedido['comentarios'];
}
 
$sql_listaestacion = "SELECT nombre, razonsocial, direccioncompleta FROM tb_estaciones WHERE id = '".$id_estacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$nombre = $row_listaestacion['nombre'];
$razonsocial = $row_listaestacion['razonsocial'];
$direccioncompleta = $row_listaestacion['direccioncompleta'];
}

if($id_estacion == 9){
$razonsocialDesc = "Autolavado";
$direccionDesc = "Av. Palo Solo #3515, Huixquilucan, Estado de México, C.P. 52787";
$DescripcionES = "¿EN QUE AFECTA AL AUTOLAVADO?";
    
}else{
$razonsocialDesc = $razonsocial;
$direccionDesc = $direccioncompleta;
$DescripcionES = "¿EN QUE AFECTA A LA ESTACIÓN?";

}

function DetalleArea($id,$con){
$Result = "";
$sql = "SELECT * FROM op_pedido_materiales_area_otros WHERE id_area = '".$id."' AND estatus = 1 ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Result .= '('.$row['sub_area'].')'; 
}
    
return $Result;
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Crear un nuevo archivo de Excel
$spreadsheet = new Spreadsheet();

// ---------- PAGINA 1 ----------//
$sheet1 = $spreadsheet->getActiveSheet();
$sheet1->setTitle("Orden de Mtto");

// ---------- DATOS DE LA ORDEN DE MANTENIMIENTO ----------
$sheet1->setCellValue('A1', 'Ref. Operativa');
$sheet1->setCellValue('B1', 'Orden de Mantenimiento');
$sheet1->setCellValue('C1', 'Sucursal:');
$sheet1->setCellValue('D1', $nombre);

// Combina las celdas B1 a B4
$sheet1->mergeCells('B1:B3');

$sheet1->setCellValue('A2', 'Proyecto de Mantenimiento');
$sheet1->setCellValue('C2', 'Fecha:');
$sheet1->setCellValue('D2', $fecha);

$sheet1->setCellValue('A3', 'Refacturación');
$sheet1->setCellValue('C3', 'No. De control:');
$sheet1->setCellValue('D3', '00' . $folio);


// ---------- DATOS DE LA ESTACIÓN DE SERVICIO ----------
$sheet1->setCellValue('A5', 'DATOS DE LA ESTACIÓN DE SERVICIO');
$sheet1->mergeCells('A5:D5');  // Combina las celdas A5:D5
$sheet1->getStyle('A5:D5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);  // Establece el tipo de relleno sólido
$sheet1->getStyle('A5:D5')->getFill()->getStartColor()->setRGB('215d98');  // Establece el color de fondo a azul (#0000FF)
$sheet1->getStyle('A5:D5')->getFont()->getColor()->setRGB('FFFFFF');  // Establece el color del texto a blanco

$sheet1->setCellValue('A6', 'Razón social:');
$sheet1->setCellValue('B6', $razonsocialDesc);
$sheet1->mergeCells('B6:D6');  

$sheet1->setCellValue('A7', 'Dirección:');
$sheet1->setCellValue('B7', $direccionDesc);
$sheet1->mergeCells('B7:D7');  

$sheet1->setCellValue('A9', $DescripcionES);
$sheet1->mergeCells('A9:D9'); 
$sheet1->getStyle('A9:D9')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);  // Establece el tipo de relleno sólido
$sheet1->getStyle('A9:D9')->getFill()->getStartColor()->setRGB('215d98');  // Establece el color de fondo a azul (#0000FF)
$sheet1->getStyle('A9:D9')->getFont()->getColor()->setRGB('FFFFFF');  // Establece el color del texto a blanco
$sheet1->setCellValue('A10', $afectacion);
$sheet1->mergeCells('A10:D10');  

// ---------- TIPO DE SERVICIO----------
$sheet1->setCellValue('A12', 'TIPO DE SERVICIO');
$sheet1->mergeCells('A12:D12');
$sheet1->getStyle('A12:D12')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);  // Establece el tipo de relleno sólido
$sheet1->getStyle('A12:D12')->getFill()->getStartColor()->setRGB('215d98');  // Establece el color de fondo a azul (#0000FF)
$sheet1->getStyle('A12:D12')->getFont()->getColor()->setRGB('FFFFFF');  // Establece el color del texto a blanco

$sheet1->setCellValue('A13', 'Preventivo');
$sheet1->setCellValue('B13', 'Correctivo');
$sheet1->setCellValue('C13', 'Emergente');
$sheet1->mergeCells('C13:D13');  

if($tiposervicio == 1){
$sheet1->setCellValue('A14', '✔');
}else{
$sheet1->setCellValue('A14', '');
}
    
if($tiposervicio == 2){
$sheet1->setCellValue('B14', '✔');
}else{
$sheet1->setCellValue('B14', '');
}
    
if($tiposervicio == 3){
$sheet1->setCellValue('C14', '✔');
}else{
$sheet1->setCellValue('C14', '');
}
        
$sheet1->mergeCells('C14:D14'); 
    
// ---------- LA ORDEN DE TRABAJO SE PUEDE ATENDER INTERNAMENTE ----------
$sheet1->setCellValue('A16', 'TIPO DE SERVICIO');
$sheet1->mergeCells('A16:D16');
$sheet1->getStyle('A16:D16')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);  // Establece el tipo de relleno sólido
$sheet1->getStyle('A16:D16')->getFill()->getStartColor()->setRGB('215d98');  // Establece el color de fondo a azul (#0000FF)
$sheet1->getStyle('A16:D16')->getFont()->getColor()->setRGB('FFFFFF');  // Establece el color del texto a blanco

$sheet1->setCellValue('A17', 'SI');
$sheet1->setCellValue('B17', 'NO');
$sheet1->setCellValue('C17', 'AMBAS');
$sheet1->mergeCells('C17:D17');  

if($ordentrabajo == 1){
$sheet1->setCellValue('A18', '✔');
}else{
$sheet1->setCellValue('A18', '');
}
      
if($ordentrabajo == 2){
$sheet1->setCellValue('B18', '✔');
}else{
$sheet1->setCellValue('B18', '');
}
      
if($ordentrabajo == 3){
$sheet1->setCellValue('C18', '✔');
}else{
$sheet1->setCellValue('C18', '');
}
          
$sheet1->mergeCells('C18:D18'); 
      
// ---------- LA ORDEN DE TRABAJO ES DE ALTO RIESGO ----------
$sheet1->setCellValue('A20', 'LA ORDEN DE TRABAJO ES DE ALTO RIESGO');
$sheet1->mergeCells('A20:D20');
$sheet1->getStyle('A20:D20')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);  // Establece el tipo de relleno sólido
$sheet1->getStyle('A20:D20')->getFill()->getStartColor()->setRGB('215d98');  // Establece el color de fondo a azul (#0000FF)
$sheet1->getStyle('A20:D20')->getFont()->getColor()->setRGB('FFFFFF');  // Establece el color del texto a blanco

$sheet1->setCellValue('A21', 'SI');
$sheet1->mergeCells('A21:B21');
$sheet1->setCellValue('C21', 'NO');
$sheet1->mergeCells('C21:D21');

if($ordenriesgo == 1){
$sheet1->setCellValue('A22', '✔');
}else{
$sheet1->setCellValue('A22', '');
}
$sheet1->mergeCells('A22:B22');
    
if($ordenriesgo == 2){
$sheet1->setCellValue('C22', '✔');
}else{
$sheet1->setCellValue('C22', '');
}
$sheet1->mergeCells('C22:D22');

$rowIndexArea = 24;

// ---------- ÁREA ----------
if($id_estacion != 9){
$sheet1->setCellValue("A$rowIndexArea", 'ÁREA');
$sheet1->mergeCells("A$rowIndexArea:D$rowIndexArea");
$sheet1->getStyle("A$rowIndexArea:D$rowIndexArea")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);  // Establece el tipo de relleno sólido
$sheet1->getStyle("A$rowIndexArea:D$rowIndexArea")->getFill()->getStartColor()->setRGB('215d98');  // Establece el color de fondo a azul (#0000FF)
$sheet1->getStyle("A$rowIndexArea:D$rowIndexArea")->getFont()->getColor()->setRGB('FFFFFF');  // Establece el color del texto a blanco

$rowIndexArea2 = $rowIndexArea + 1;
$sql_lista = "SELECT * FROM op_pedido_materiales_area WHERE id_pedido = '".$GET_idPedido."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if($numero_lista > 0){
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$area = $row_lista['area'];
$estatus2 = $row_lista['estatus'];

if($estatus2 == 1){
$checked = "✔";
$SADetalle = DetalleArea($id,$con);
}else{
$checked = "";  
$SADetalle = "";  

}

$sheet1->setCellValue("A$rowIndexArea2", $area . " " . $SADetalle);
$sheet1->mergeCells("A$rowIndexArea2:C$rowIndexArea2");

$sheet1->setCellValue("D$rowIndexArea2", $checked);

$rowIndexArea2++;
}
$rowIndexRefacciones = $rowIndexArea2 + 1;

}else{
$sheet1->setCellValue("A$rowIndexArea2", 'No se encontro información');
$sheet1->mergeCells("A$rowIndexArea2:D$rowIndexArea2");
$rowIndexRefacciones = $rowIndexArea2 + 2;

}

}

// ---------- REFACCIONES ----------
$sheet1->setCellValue("A$rowIndexRefacciones", 'REFACCIONES');
$sheet1->mergeCells("A$rowIndexRefacciones:D$rowIndexRefacciones");
$sheet1->getStyle("A$rowIndexRefacciones:D$rowIndexRefacciones")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);  // Establece el tipo de relleno sólido
$sheet1->getStyle("A$rowIndexRefacciones:D$rowIndexRefacciones")->getFill()->getStartColor()->setRGB('215d98');  // Establece el color de fondo a azul (#0000FF)
$sheet1->getStyle("A$rowIndexRefacciones:D$rowIndexRefacciones")->getFont()->getColor()->setRGB('FFFFFF');  // Establece el color del texto a blanco

$rowIndexRefacciones2 = $rowIndexRefacciones + 1;
$sheet1->setCellValue("A$rowIndexRefacciones2", 'Refacción');
$sheet1->setCellValue("B$rowIndexRefacciones2", 'Cantidad');
$sheet1->setCellValue("C$rowIndexRefacciones2", 'Estatus');
$sheet1->mergeCells("C$rowIndexRefacciones2:D$rowIndexRefacciones2");
$sheet1->getStyle("A$rowIndexRefacciones2:D$rowIndexRefacciones2")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);  // Establece el tipo de relleno sólido
$sheet1->getStyle("A$rowIndexRefacciones2:D$rowIndexRefacciones2")->getFill()->getStartColor()->setRGB('749abf');  // Establece el color de fondo a azul (#0000FF)
$sheet1->getStyle("A$rowIndexRefacciones2:D$rowIndexRefacciones2")->getFont()->getColor()->setRGB('FFFFFF');  // Establece el color del texto a blanco

$rowIndexRefacciones3 = $rowIndexRefacciones2 + 1;
$sql_detalle = "SELECT * FROM op_pedido_materiales_detalle WHERE id_pedido = '".$GET_idPedido."' ";
$result_detalle = mysqli_query($con, $sql_detalle);
$numero_detalle = mysqli_num_rows($result_detalle);
if ($numero_detalle > 0) {
while($row_detalle = mysqli_fetch_array($result_detalle, MYSQLI_ASSOC)){
$id  = $row_detalle['id'];
$concepto  = $row_detalle['concepto'];
$cantidad  = $row_detalle['cantidad'];
$nota  = $row_detalle['nota'];

$sheet1->setCellValue("A$rowIndexRefacciones3", $concepto);
$sheet1->setCellValue("B$rowIndexRefacciones3", $cantidad);
$sheet1->setCellValue("C$rowIndexRefacciones3", $nota);
$sheet1->mergeCells("C$rowIndexRefacciones3:D$rowIndexRefacciones3");

$rowIndexRefacciones3++;
}
$rowIndexEvidencia = $rowIndexRefacciones3 + 1;
}else{
$sheet1->setCellValue("A$rowIndexRefacciones3", 'No se encontro información');
$sheet1->mergeCells("A$rowIndexRefacciones3:D$rowIndexRefacciones3");  
$rowIndexEvidencia = $rowIndexRefacciones3 + 2;
}

// ---------- EVIDENCIA ----------
$sheet1->setCellValue("A$rowIndexEvidencia", 'EVIDENCIA');
$sheet1->mergeCells("A$rowIndexEvidencia:D$rowIndexEvidencia");
$sheet1->getStyle("A$rowIndexEvidencia:D$rowIndexEvidencia")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);  // Establece el tipo de relleno sólido
$sheet1->getStyle("A$rowIndexEvidencia:D$rowIndexEvidencia")->getFill()->getStartColor()->setRGB('215d98');  // Establece el color de fondo a azul (#0000FF)
$sheet1->getStyle("A$rowIndexEvidencia:D$rowIndexEvidencia")->getFont()->getColor()->setRGB('FFFFFF');  // Establece el color del texto a blanco

$rowIndexEvidencia2 = $rowIndexEvidencia + 1;
$sheet1->setCellValue("A$rowIndexEvidencia2", 'Área');
$sheet1->setCellValue("B$rowIndexEvidencia2", 'Motivo');
$sheet1->mergeCells("B$rowIndexEvidencia2:D$rowIndexEvidencia2");
$sheet1->getStyle("A$rowIndexEvidencia2:D$rowIndexEvidencia2")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);  // Establece el tipo de relleno sólido
$sheet1->getStyle("A$rowIndexEvidencia2:D$rowIndexEvidencia2")->getFill()->getStartColor()->setRGB('749abf');  // Establece el color de fondo a azul (#0000FF)
$sheet1->getStyle("A$rowIndexEvidencia2:D$rowIndexEvidencia2")->getFont()->getColor()->setRGB('FFFFFF');  // Establece el color del texto a blanco

$rowIndexEvidencia3 = $rowIndexEvidencia2 + 1;
$sql_evidencia = "SELECT * FROM op_pedido_materiales_evidencia_archivo WHERE id_pedido = '".$GET_idPedido."' ";
$result_evidencia = mysqli_query($con, $sql_evidencia);
$numero_evidencia = mysqli_num_rows($result_evidencia);
if($numero_evidencia > 0){
while($row_evidencia = mysqli_fetch_array($result_evidencia, MYSQLI_ASSOC)){
$idEvidencia = $row_evidencia['id'];
$area2 = $row_evidencia['area'];
$motivo = $row_evidencia['motivo'];

$sheet1->setCellValue("A$rowIndexEvidencia3", $area2);
$sheet1->setCellValue("B$rowIndexEvidencia3", $motivo);
$sheet1->mergeCells("B$rowIndexEvidencia3:D$rowIndexEvidencia3");

$rowIndexEvidencia3++;
}
$rowIndexComentarios = $rowIndexEvidencia3 + 1;
}else{
$sheet1->setCellValue("A$rowIndexEvidencia3", 'No se encontro información');
$sheet1->mergeCells("A$rowIndexEvidencia3:D$rowIndexEvidencia3");   
$rowIndexComentarios = $rowIndexEvidencia3 + 2; 
}

// ---------- COMENTARIOS ----------
$sheet1->setCellValue("A$rowIndexComentarios", 'COMENTARIOS');
$sheet1->mergeCells("A$rowIndexComentarios:D$rowIndexComentarios");
$sheet1->getStyle("A$rowIndexComentarios:D$rowIndexComentarios")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);  // Establece el tipo de relleno sólido
$sheet1->getStyle("A$rowIndexComentarios:D$rowIndexComentarios")->getFill()->getStartColor()->setRGB('215d98');  // Establece el color de fondo a azul (#0000FF)
$sheet1->getStyle("A$rowIndexComentarios:D$rowIndexComentarios")->getFont()->getColor()->setRGB('FFFFFF');  // Establece el color del texto a blanco

$rowIndexComentarios2 = $rowIndexComentarios + 1;
$sheet1->setCellValue("A$rowIndexComentarios2", $comentarios);
$sheet1->mergeCells("A$rowIndexComentarios2:D$rowIndexComentarios2");
 
// Ajustar el ancho de las columnas automáticamente
$sheet1->getColumnDimension('A')->setAutoSize(true);  // Ajusta el ancho de la columna A
$sheet1->getColumnDimension('B')->setAutoSize(true);  // Ajusta el ancho de la columna B
$sheet1->getColumnDimension('C')->setAutoSize(true);  // Ajusta el ancho de la columna C
$sheet1->getColumnDimension('D')->setAutoSize(true);  // Ajusta el ancho de la columna D
$sheet1->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);  // Centra el texto horizontalmente
$sheet1->getStyle('A')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);  // Centra el texto verticalmente
$sheet1->getStyle('B')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);  // Centra el texto horizontalmente
$sheet1->getStyle('B')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);  // Centra el texto verticalmente
$sheet1->getStyle('C')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);  // Centra el texto horizontalmente
$sheet1->getStyle('C')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);  // Centra el texto verticalmente
$sheet1->getStyle('D')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);  // Centra el texto horizontalmente
$sheet1->getStyle('D')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);  // Centra el texto verticalmente
$sheet1->getStyle('A1:D4')->getAlignment()->setWrapText(true);


// Guardar el archivo Excel y enviarlo al navegador
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Reporte_Orden_Mantenimiento_00'.$folio.'.xlsx"');
$writer->save('php://output');
exit;
