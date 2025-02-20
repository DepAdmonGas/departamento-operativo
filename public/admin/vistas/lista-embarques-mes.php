<?php 
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$GET_year = $_GET['year'];
$GET_mes = $_GET['mes']; 
 
$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosEstacion($idEstacion);

if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo" ){
$Estacion = '';
	
}else{
$Estacion = ' ('.$datosEstacion['nombre'].')';
	
}

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}

function IdReporte($idEstacion,$GET_year,$GET_mes,$con){
$sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '".$idEstacion."' AND year = '".$GET_year."' ";
$result_year = mysqli_query($con, $sql_year);
while($row_year = mysqli_fetch_array($result_year, MYSQLI_ASSOC)){
$idyear = $row_year['id'];
}
$sql_mes = "SELECT id, id_year, mes FROM op_corte_mes WHERE id_year = '".$idyear."' AND mes = '".$GET_mes."' ";
$result_mes = mysqli_query($con, $sql_mes);
while($row_mes = mysqli_fetch_array($result_mes, MYSQLI_ASSOC)){
$idmes = $row_mes['id'];
}
return $idmes;
}
   
function validaExtencion($extension){
  $icon = "";

if ($extension == "xml") {
$icon = RUTA_IMG_ICONOS.'xml.png';
}else if ($extension == "pdf") {
$icon = RUTA_IMG_ICONOS.'pdf.png';
}else if ($extension == "xlsx") {
$icon = RUTA_IMG_ICONOS.'excel.png';
}

return $icon;
}
 
$IdReporte = IdReporte($idEstacion,$GET_year,$GET_mes,$con);

function es_negativo($num) {
return (is_numeric($num) and $num<1) ? true : false;
}

function ToComentarios($IdReporte,$con){
$sql_lista = "SELECT id FROM op_embarques_comentario WHERE id_embarques = '".$IdReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
}
?>


<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<?php if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo" ){?>

<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i>
Corte Diario, <?=$ClassHerramientasDptoOperativo->nombreMes($GET_mes)?> <?=$GET_year?></a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">
Resumen Embarques (<?=$ClassHerramientasDptoOperativo->nombremes($GET_mes)?> <?=$GET_year?>)
</li>

<?php }else{ ?>
<li class="breadcrumb-item"><a onclick="history.go(-3)"  class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Importación</a></li>
<li class="breadcrumb-item"><a onclick="history.go(-2)"  class="text-uppercase text-primary pointer"> Resumen  Embarques <?=$Estacion?></a></li>
<li class="breadcrumb-item"><a onclick="history.go(-1)"  class="text-uppercase text-primary pointer"> <?=$GET_year?></a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase"><?=$ClassHerramientasDptoOperativo->nombremes($GET_mes)?> </li>
<?php } ?>
</ol>
</div>
 
<div class="row"> 
<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 mb-1"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Resumen Embarques<?=$Estacion?>, <?=$ClassHerramientasDptoOperativo->nombremes($GET_mes)?> <?=$GET_year?></h3> </div>

<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mt-1"> 
<?php if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo" ){?>
<button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="Mas(<?=$IdReporte;?>,<?=$idEstacion;?>,<?=$GET_year;?>,<?=$GET_mes;?>)"> 
<span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
<?php }else{ 
if ($session_nompuesto == "Contabilidad" || $session_nompuesto == "Comercializadora" || $session_nompuesto == "Dirección de operaciones servicio social") { ?>
<button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="AnalisisC(<?=$idEstacion;?>,<?=$GET_year;?>,<?=$GET_mes;?>)"> 
<span class="btn-label2"><i class="fa-solid fa-cart-shopping"></i></span>Analisis de Compras</button>
<?php } else {?>
<div class="text-end">
<div class="dropdown d-inline ms-2">
<button type="button" class="btn dropdown-toggle btn-primary" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-screwdriver-wrench"></i></button>
<ul class="dropdown-menu">
<li onclick="Mas(<?=$IdReporte;?>,<?=$idEstacion;?>,<?=$GET_year;?>,<?=$GET_mes;?>)"> <a class="dropdown-item pointer"><i class="fa-solid fa-plus"></i> Agregar </a> </li>
<li onclick="AnalisisC(<?=$idEstacion;?>,<?=$GET_year;?>,<?=$GET_mes;?>)"><a class="dropdown-item pointer"><i class="fa-solid fa-cart-shopping"></i> Analisis de Compras</a></li>
</ul>
</div>
</div>
<?php }?>

<?php } ?>
</div>

</div>

<hr>
</div>

  
<div class="table-responsive">
<table id="tabla_embarques_<?=$idEstacion?>" class="custom-table" style="font-size: .70em;" width="100%">
        
<thead class="tables-bg">
<tr>
<th class="align-middle text-center">No.</th>
<th class="align-middle text-center">Fecha</th>
<th class="align-middle text-center">Embarque</th>
<th class="align-middle text-center">Producto</th>
<th class="align-middle text-center">Documento</th>
<th class="align-middle text-center">No. Documento CV</th>
<th class="align-middle text-center">Litros Factura</th>
<th class="align-middle text-center">Precio por litro</th>
<th class="align-middle text-center">Merma</th>
<th class="align-middle text-center">TAD</th>
<th class="align-middle text-center">Nombre del transporte</th>
<th class="align-middle text-center">Chofer</th>
<th class="align-middle text-center">Unidad</th>
<th class="align-middle text-center" width="24"><small><div class="text-white">Factura</div></small><img src="<?= RUTA_IMG_ICONOS; ?>pdf.png"></th>
<th class="align-middle text-center" width="24"><small><div class="text-white">Factura</div></small><img src="<?= RUTA_IMG_ICONOS; ?>xml.png"></th>
<th class="align-middle text-center" width="24"><small><div class="text-white">CoPa</div></small><img src="<?= RUTA_IMG_ICONOS; ?>descargar.png"></th>
<th class="align-middle text-center" width="24"><small><div class="text-white">NC</div></small><img src="<?= RUTA_IMG_ICONOS; ?>pdf.png"></th>
<th class="align-middle text-center" width="24"><small><div class="text-white">NC</div></small><img src="<?= RUTA_IMG_ICONOS; ?>xml.png"></th>
<th class="align-middle text-center" width="24"><small><div class="text-white">CP</div></small><img src="<?= RUTA_IMG_ICONOS; ?>pdf.png"></th>
<th class="align-middle text-center" width="24"><small><div class="text-white">CP</div></small><img src="<?= RUTA_IMG_ICONOS; ?>xml.png"></th>
<th class="align-middle text-center" width="24"><img src="<?= RUTA_IMG_ICONOS; ?>comentario-tb.png"></th>
<th class="align-middle text-center" width="24"><i class="fas fa-ellipsis-v"></i></th>

</tr>
</thead>

<tbody class="bg-white">

<?php
$sql_lista = "SELECT * FROM op_embarques WHERE id_mes = '" . $IdReporte . "'";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
$num = 1;
while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {

if ($session_nompuesto != "Dirección de operaciones servicio social") {
$eliminar = '<a class="dropdown-item" onclick="Eliminar('.$IdReporte.','.$row_lista['id'].','.$idEstacion.','.$GET_year.','.$GET_mes.')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
$editar = '<a class="dropdown-item" onclick="Editar('.$IdReporte.','.$row_lista['id'].','.$idEstacion.','.$GET_year.','.$GET_mes.')"><i class="fa-solid fa-pencil"></i> Editar</a>';

} else {
$eliminar = '<a class="dropdown-item grayscale"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
$editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';

}

$extension = pathinfo($row_lista['documento'], PATHINFO_EXTENSION);
$icon = validaExtencion($extension);

if ($row_lista['pdf'] != "") {
$PDF = '<a href="'.RUTA_ARCHIVOS.'' . $row_lista['pdf'] . '" download data-toggle="tooltip" data-placement="top" title="Factura PDF"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'pdf.png' . '"></a>';
} else {
$PDF = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png" data-toggle="tooltip" data-placement="top" title="Factura PDF">';
}

if ($row_lista['xml'] != "") {
$XML = '<a href="'.RUTA_ARCHIVOS.'' . $row_lista['xml'] . '" download><img class="pointer" src="' . RUTA_IMG_ICONOS . 'xml.png' . '" data-toggle="tooltip" data-placement="top" title="Factura XML"></a>';
} else {
$XML = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png" data-toggle="tooltip" data-placement="top" title="Factura XML">';
}

if ($row_lista['comprobante_p'] != "") {
$CoPa = '<a href="'.RUTA_ARCHIVOS.'' . $row_lista['comprobante_p'] . '" download><img class="pointer" src="' . RUTA_IMG_ICONOS . 'descargar.png' . '" data-toggle="tooltip" data-placement="top" title="Comprobante de pago"></a>';
} else {
$CoPa = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png" data-toggle="tooltip" data-placement="top" title="Comprobante de pago">';
}

if ($row_lista['merma'] == 0) {
$colorspan = "text-dark";
} else {
if (es_negativo($row_lista['merma'])) {
$colorspan = "text-danger";
} else {
 $colorspan = "text-dark";
}
}

$ToComentarios = ToComentarios($row_lista['id'], $con);

if ($ToComentarios > 0) {
$Nuevo = '<div class="position-absolute" style="margin-bottom: -15px; right: 2px;"><span class="badge bg-danger text-white rounded-circle"><span class="fw-bold" style="font-size: 10px;">'.$ToComentarios.' </span></span></div>';
//$Nuevo = '<div class="float-center" style="margin-bottom: -8px"><span class="badge bg-danger text-white rounded-circle"><small>' . $ToComentarios . '</small></span></div>';
} else {
$Nuevo = '';
}

if ($row_lista['nc_pdf'] != "") {
$NCPDF = '<a href="'.RUTA_ARCHIVOS.'' . $row_lista['nc_pdf'] . '" download data-toggle="tooltip" data-placement="top" title="Nota de crédito PDF"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'pdf.png' . '"></a>';
} else {
$NCPDF = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png" data-toggle="tooltip" data-placement="top" title="Nota de crédito PDF">';
}

if ($row_lista['nc_xml'] != "") {
$NCXML = '<a href="'.RUTA_ARCHIVOS.'' . $row_lista['nc_xml'] . '" download><img class="pointer" src="' . RUTA_IMG_ICONOS . 'xml.png' . '" data-toggle="tooltip" data-placement="top" title="Nota de crédito XML"></a>';
} else {
$NCXML = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png" data-toggle="tooltip" data-placement="top" title="Nota de crédito XML">';
}

if ($row_lista['comPDF'] != "") {
$ComPDF = '<a class="pointer" href="'.RUTA_ARCHIVOS.'' . $row_lista['comPDF'] . '" download><img src="' . RUTA_IMG_ICONOS . 'pdf.png' . '" data-toggle="tooltip" data-placement="top" title="Complemento PDF"></a>';
} else {
$ComPDF = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png" data-toggle="tooltip" data-placement="top" title="Complemento PDF">';
}

if ($row_lista['comXML'] != "") {
$ComXML = '<a class="pointer" href="'.RUTA_ARCHIVOS.'' . $row_lista['comXML'] . '" download><img src="' . RUTA_IMG_ICONOS . 'xml.png' . '" data-toggle="tooltip" data-placement="top" title="Complemento XML"></a>';
} else {
$ComXML = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png" data-toggle="tooltip" data-placement="top" title="Complemento XML">';
}

$bgTable = '';

if ($row_lista['embarque'] == "Pemex" || $row_lista['embarque'] == "Delivery") {
$colorSemaforo = '<img src="' . RUTA_IMG_ICONOS . 'verde_E.png">';
$bgTable = 'style="background-color: #b0f2c2"';
$PDF = '<img src="' . RUTA_IMG_ICONOS . 'prohibido.png">';
$XML = '<img src="' . RUTA_IMG_ICONOS . 'prohibido.png">';
$CoPa = '<img src="' . RUTA_IMG_ICONOS . 'prohibido.png">';
$NCPDF = '<img src="' . RUTA_IMG_ICONOS . 'prohibido.png">';
$NCXML = '<img src="' . RUTA_IMG_ICONOS . 'prohibido.png">';
$ComPDF = '<img src="' . RUTA_IMG_ICONOS . 'prohibido.png">';
$ComXML = '<img src="' . RUTA_IMG_ICONOS . 'prohibido.png">';

} else if ($row_lista['embarque'] == "Pick Up") {
//---------- TRANSPORTES 1. CONFIGURACION (PETRO ASFALTOS & SANTA FE) ----------
if ($row_lista['nom_transporte'] == "PETRO ASFALTOS DEL SURESTE" || $row_lista['nom_transporte'] == "TRANSPORTES SANTA FE DEL SURESTE SA DE CV") {

if ($row_lista['pdf'] != "" && $row_lista['xml'] != "" && $row_lista['comprobante_p'] != "" && $row_lista['nc_pdf'] != "" && $row_lista['comPDF'] != "" && $row_lista['comXML'] != "") {
$colorSemaforo = '<img src="' . RUTA_IMG_ICONOS . 'verde_E.png">';
$bgTable = 'style="background-color: #b0f2c2"';

} else if ($row_lista['pdf'] == "" && $row_lista['xml'] == "" && $row_lista['comprobante_p'] == "" && $row_lista['nc_pdf'] == "" && $row_lista['comPDF'] == "" && $row_lista['comXML'] == "") {
$colorSemaforo = '<img src="' . RUTA_IMG_ICONOS . 'red_E.png">';
$bgTable = 'style="background-color: #ffb6af"';

} else {
$colorSemaforo = '<img src="' . RUTA_IMG_ICONOS . 'amarillo_E.png">';
$bgTable = 'style="background-color: #fcfcda"';

}

//---------- TRANSPORTE 2. CONFIGURACION (SIPCI) ----------
} else if ($row_lista['nom_transporte'] == "SIPCI") {
$NCPDF = '<img src="' . RUTA_IMG_ICONOS . 'prohibido.png">';
$NCXML = '<img src="' . RUTA_IMG_ICONOS . 'prohibido.png">';
$ComPDF = '<img src="' . RUTA_IMG_ICONOS . 'prohibido.png">';
$ComXML = '<img src="' . RUTA_IMG_ICONOS . 'prohibido.png">';

if ($row_lista['pdf'] != "" && $row_lista['xml'] != "" && $row_lista['comprobante_p'] != "") {
$colorSemaforo = '<img src="' . RUTA_IMG_ICONOS . 'verde_E.png">';
$bgTable = 'style="background-color: #b0f2c2"';

} else if ($row_lista['pdf'] == "" && $row_lista['xml'] == "" && $row_lista['comprobante_p'] == "") {
$colorSemaforo = '<img src="' . RUTA_IMG_ICONOS . 'red_E.png">';
$bgTable = 'style="background-color: #ffb6af"';

} else {
$colorSemaforo = '<img src="' . RUTA_IMG_ICONOS . 'amarillo_E.png">';
$bgTable = 'style="background-color: #fcfcda"';

}

//---------- TRANSPORTE 3. CONFIGURACION (GENERAL) ----------
} else {

if ($row_lista['pdf'] != "" && $row_lista['xml'] != "" && $row_lista['comprobante_p'] != "" && $row_lista['nc_pdf'] != "" && $row_lista['nc_xml'] != "" && $row_lista['comPDF'] != "" && $row_lista['comXML'] != "") {
$colorSemaforo = '<img src="' . RUTA_IMG_ICONOS . 'verde_E.png">';
$bgTable = 'style="background-color: #b0f2c2"';

} else if ($row_lista['pdf'] == "" && $row_lista['xml'] == "" && $row_lista['comprobante_p'] == "" && $row_lista['nc_pdf'] == "" && $row_lista['nc_xml'] == "" && $row_lista['comPDF'] == "" && $row_lista['comXML'] == "") {
$colorSemaforo = '<img src="' . RUTA_IMG_ICONOS . 'red_E.png">';
$bgTable = 'style="background-color: #ffb6af"';

} else {
$colorSemaforo = '<img src="' . RUTA_IMG_ICONOS . 'amarillo_E.png">';
$bgTable = 'style="background-color: #fcfcda"';

}

}

} 

// Convertir la fecha en un formato ordenable
$fecha = $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha']);
$meses = [
    "Enero" => "01", "Febrero" => "02", "Marzo" => "03", "Abril" => "04",
    "Mayo" => "05", "Junio" => "06", "Julio" => "07", "Agosto" => "08",
    "Septiembre" => "09", "Octubre" => "10", "Noviembre" => "11", "Diciembre" => "12"
];

// Extraer día y mes de la fecha
preg_match('/(\d{1,2}) de (\w+) del (\d{4})/', $fecha, $matches);
$dia = str_pad($matches[1], 2, '0', STR_PAD_LEFT); // Asegurar formato 01, 02, etc.
$mes = $meses[$matches[2]]; // Convertir mes a número
$year = $matches[3]; // Extraer año

// Formato ordenable YYYYMMDD
$fechaOrdenable = $year . $mes . $dia;

echo '<tr ' . $bgTable . '>';
echo '<th class="align-middle text-center fw-normal" data-order="' . $fechaOrdenable . '">'.$num.'</th>';
echo '<th class="align-middle text-center fw-normal" data-order="' . $fechaOrdenable . '">' . $fecha . '</th>';
echo '<td class="align-middle text-center">' . $row_lista['embarque'] . '</td>';
echo '<td class="align-middle text-center">' . $row_lista['producto'] . '</td>';
echo '<td class="align-middle text-center"><a href="'.RUTA_ARCHIVOS.'' . $row_lista['documento'] . '" download  data-toggle="tooltip" data-placement="top" title="Documento"><img src="'.RUTA_IMG_ICONOS.'pdf.png"></a></td>';
echo '<td class="align-middle text-center">' . $row_lista['documentocv'] . '</td>';
echo '<td class="align-middle text-right">' . number_format($row_lista['importef'], 2) . '</td>';
echo '<td class="align-middle text-right">' . $row_lista['precio_litro'] . '</td>';
echo '<td class="align-middle text-right ' . $colorspan . '">' . number_format($row_lista['merma'], 2) . '</td>';
echo '<td class="align-middle text-center">' . $row_lista['tad'] . '</td>';
echo '<td class="align-middle text-center">' . $row_lista['nom_transporte'] . '</td>';
echo '<td class="align-middle text-center">' . $row_lista['chofer'] . '</td>';
echo '<td class="align-middle text-center">' . $row_lista['unidad'] . '</td>';
echo '<td class="align-middle text-center" width="24">' . $PDF . '</td>';
echo '<td class="align-middle text-center" width="24">' . $XML . '</td>';
echo '<td class="align-middle text-center" width="24">' . $CoPa . '</td>';
echo '<td class="align-middle text-center" width="24">' . $NCPDF . '</td>';
echo '<td class="align-middle text-center" width="24">' . $NCXML . '</td>';
echo '<td class="align-middle text-center" width="24">' . $ComPDF . '</td>';
echo '<td class="align-middle text-center" width="24">' . $ComXML . '</td>';
echo '<td class="align-middle text-center position-relative" onclick="ModalComentario('.$IdReporte.','.$row_lista['id'].','.$idEstacion.','.$GET_year.','.$GET_mes.')">'.$Nuevo.'<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';

echo '<td class="align-middle text-right" width="24">
<div class="dropdown">

<a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
<i class="fas fa-ellipsis-v"></i>
</a>

<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
'.$editar.'
'.$eliminar.'
</div>
</div>

</td>';

echo '</tr>';

$num++;
}
}
?>
</tbody>
</table>
</div>
