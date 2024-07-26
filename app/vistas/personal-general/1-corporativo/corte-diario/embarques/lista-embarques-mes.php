<?php
require ('../../../../../help.php');

$idEstacion = $Session_IDEstacion;
$IdReporte = $_GET['IdReporte'];
 
function validaExtencion($extension)
{
  $icon = '';
  if ($extension == "xml") {
    $icon = RUTA_IMG_ICONOS . 'xml.png';
  } else if ($extension == "pdf") {
    $icon = RUTA_IMG_ICONOS . 'pdf.png';
  } else if ($extension == "xlsx") {
    $icon = RUTA_IMG_ICONOS . 'excel.png';
  }

  return $icon;
}
function es_negativo($num)
{
  return (is_numeric($num) and $num < 1) ? true : false;

}

function ToComentarios($IdReporte, $con)
{
  $sql_lista = "SELECT id FROM op_embarques_comentario WHERE id_embarques = '" . $IdReporte . "' ";
  $result_lista = mysqli_query($con, $sql_lista);
  return $numero_lista = mysqli_num_rows($result_lista);

}


?>

<div class="table-responsive">

<table id="tabla_embarques_<?=$IdReporte?>" class="custom-table" style="font-size: .75em;" width="100%">
        
<thead class="tables-bg">
<tr>
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
<th class="align-middle text-center" width="24"><img src="<?= RUTA_IMG_ICONOS; ?>editar-tb.png"></th>
<th class="align-middle text-center" width="24"><img src="<?= RUTA_IMG_ICONOS; ?>eliminar.png"></th>
</tr>
</thead>

<tbody class="bg-white">

<?php
$sql_lista = "SELECT * FROM op_embarques WHERE id_mes = '" . $IdReporte . "' ORDER BY fecha desc";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {

if ($session_nompuesto != "Dirección de operaciones servicio social") {
$eliminar = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="Eliminar(' . $IdReporte . ',' . $row_lista['id'] . ',' . $idEstacion . ')" data-toggle="tooltip" data-placement="top" title="Eliminar">';
$editar = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'editar-tb.png" onclick="Editar(' . $IdReporte . ',' . $row_lista['id'] . ',' . $idEstacion . ')" data-toggle="tooltip" data-placement="top" title="Editar">';
} else {
$eliminar = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png" data-toggle="tooltip" data-placement="top" title="Eliminar">';
$editar = '<img src="' . RUTA_IMG_ICONOS . 'editar-tb.png" data-toggle="tooltip" data-placement="top" title="Editar">';
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

echo '<tr ' . $bgTable . '>';
echo '<th class="align-middle text-center">' . $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha']) . '</th>';
echo '<td class="align-middle text-center">' . $row_lista['embarque'] . '</td>';
echo '<td class="align-middle text-center">' . $row_lista['producto'] . '</td>';
echo '<td class="align-middle text-center"><a href="'.RUTA_ARCHIVOS.'' . $row_lista['documento'] . '" download  data-toggle="tooltip" data-placement="top" title="Documento"><img class=""pointer src="' . $icon . '"></a></td>';
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
echo '<td class="align-middle text-center position-relative" onclick="ModalComentario(' . $IdReporte . ',' . $row_lista['id'] . ',' . $idEstacion . ')">'.$Nuevo.'<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';
echo '<td class="align-middle text-right" width="24">' . $editar . '</td>';
echo '<td class="align-middle text-right" width="24">' . $eliminar . '</td>';
echo '</tr>';

}
}
?>
</tbody>
</table>
</div>