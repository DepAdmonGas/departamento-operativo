 
<?php
require('../../../app/help.php');
$idReporte = $_GET['idReporte'];
$idEstacion = $_GET['idEstacion'];

$sql_lista = "SELECT * FROM op_pedido_materiales_causa WHERE id_reporte = '".$idReporte."' ORDER BY fecha DESC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);


?>

<div class="modal-header">
  <h5 class="modal-title">Agregar causa</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="text-secondary mb-1">Descripcion de la causa:</div>
<textarea class="form-control rounded-0 mb-2" id="Causa"></textarea>

<div class="text-secondary mb-1 mt-2">La refaccion se queda en:</div>
<select class="form-select rounded-0 mb-2" id="Refaccion">
<option value="">Selecciona una opción...</option>
<option value="Estación">Estación</option>
<option value="Almacen">Almacen</option>
</select>

<div class="row">

<div class="col-12">
<div class="text-secondary mb-1">Factura PDF:</div>
<input type="file" class="form-control rounded-0 " id="ArchivoPDF">
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 d-none">
<div class="text-secondary mb-1">Factura XML:</div>
<input type="file" class="form-control rounded-0 " id="ArchivoXML">
</div>

</div>


<div class="text-secondary mb-1 mt-2">Precio:</div>
<input type="number" class="form-control rounded-0" id="Precio">

<hr>
 
<div class="text-end">
<button type="button" class="btn btn-labeled2 btn-success mb-1" onclick="AgregarCausa('<?=$idEstacion?>','<?=$idReporte?>')">
<span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
</div>


<div class="table-responsive">
<table id="tabla_bitacora" class="custom-table mt-2" style="font-size: 14px;" width="100%">

<thead class="tables-bg">
 <tr>
 <th class="align-middle tableStyle font-weight-bold text-center">No.</th>
 <th class="align-middle tableStyle font-weight-bold text-center">Fecha</th>
 <th class="align-middle tableStyle font-weight-bold text-center">Descripcion</th>
 <th class="align-middle tableStyle font-weight-bold text-center">Se queda en</th>
 <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
 <th class="align-middle tableStyle font-weight-bold text-center">Precio</th>

 <?php
 if($session_nompuesto != "Encargado"){
 echo '<th class="align-middle tableStyle font-weight-bold text-center" width="20"><img src="'.RUTA_IMG_ICONOS.'eliminar.png"></th>';
 }
 ?>

 </tr>
</thead> 
 
<?php
if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$id = $row_lista['id'];
$fecha = $row_lista['fecha'];
$descripcion = $row_lista['descripcion'];
$localidad_refaccion = $row_lista['localidad_refaccion'];
$factura_pdf = $row_lista['factura_pdf'];
$factura_xml = $row_lista['factura_xml'];
$precio = $row_lista['precio'];
 

if($factura_pdf == ""){
$facturaPDFtb = '<img src="'.RUTA_IMG_ICONOS.'prohibido.png" data-toggle="tooltip" data-placement="top" title="Sin Informacion">';
}else{
$facturaPDFtb = '<a class="pointer" href="'.RUTA_ARCHIVOS.'orden-mantenimiento-causa/'.$factura_pdf.'" download>
<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Factura PDF"></a>';  
}

if($factura_xml == ""){
  $facturaXMLtb = '<img src="'.RUTA_IMG_ICONOS.'prohibido.png" data-toggle="tooltip" data-placement="top" title="Sin Informacion">';
}else{
  $facturaXMLtb = '<a class="pointer" href="'.RUTA_ARCHIVOS.'orden-mantenimiento-causa/'.$factura_xml.'" download>
  <img class="pointer" src="'.RUTA_IMG_ICONOS.'xml.png" data-toggle="tooltip" data-placement="top" title="Factura XML"></a>';  
}

if($precio == 0){
$preciotb = number_format(0, 2);
}else{
$preciotb = number_format($precio,2);
}

echo '<tr class="bg-light">'; 
echo '<th class="align-middle text-center no-hover2">'.$num.'</th>'; 
echo '<td class="align-middle text-center no-hover2" ><b>'.FormatoFecha($row_lista['fecha']).', '.date("g:i a",strtotime($row_lista['hora'])).'</b></td>';
echo '<td class="align-middle text-center no-hover2">'.$descripcion.'</td>';
echo '<td class="align-middle text-center no-hover2">'.$localidad_refaccion.'</td>';
 
echo '<td class="align-middle text-center no-hover2">'.$facturaPDFtb.'</td>';

echo '<td class="align-middle text-center no-hover2" width="200px">$ '.$preciotb.'</td>';
if($session_nompuesto != "Encargado"){
echo '<td class="align-middle text-center no-hover2"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="eliminarCausa('.$idEstacion.','.$idReporte.','.$id.')"></td>';
}
echo '</tr>';

$num++;
} 
}else{
  echo "<tr class='bg-light'><th colspan='10' class='text-center text-secondary no-hover2 fw-normal'>No se encontró información para mostrar</th></tr>";  }
?>

</table>

</div>
</div>
</div>

 

   