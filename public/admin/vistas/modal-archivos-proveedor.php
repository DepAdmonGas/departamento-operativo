<?php
require('../../../app/help.php');

$idProveedor = $_GET['idProveedor'];
$sql_listArchivo = "SELECT nombre, fecha, archivo FROM op_almacen_proveedores_documentos WHERE id_proveedor = ".$idProveedor." ORDER BY nombre ASC"; 

$result_listArchivo = mysqli_query($con, $sql_listArchivo);
$numero_listArchivo = mysqli_num_rows($result_listArchivo);


function ToAlerta($idProveedor,$nameDoc,$con){

$sql_fechas = "SELECT fecha FROM op_almacen_proveedores_documentos WHERE id_proveedor = '".$idProveedor."' AND nombre = '".$nameDoc."' ";
$result_fechas = mysqli_query($con, $sql_fechas);
$numero_fechas = mysqli_num_rows($result_fechas); 

while($row_fechas = mysqli_fetch_array($result_fechas, MYSQLI_ASSOC)){
$fechas = $row_fechas['fecha'];
}

$fecha_del_dia = date("Y-m-d");
$fechaLimite = date("Y-m-d",strtotime($fechas."+ 3 month")); 

if($fecha_del_dia >= $fechaLimite ){
  return $BGColor = "style='background-color:#ffb6af'";
}else{
  return $BGColor = "";
}

 

}

?>

<div class="modal-header">
<h5 class="modal-title">Documentación</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">

<div class="alert alert-primary text-center" role="alert">
<b>Nota: </b>La documentación debe de ser actualizada cada 3 meses.
</div>
<hr>

<div class="row">

  <div class="col-12 mb-2">  
  <div class="mb-1 text-secondary">Documento:</div>
    <select class="form-select rounded-0" id="TipoArchivo">
      <option value="">Seleccione una opcion...</option>
      <option>Caratula Bancaria</option>
      <option>Constancia de Situacion Fiscal</option>
    </select>
  </div>


  <div class="col-12 mb-2">  
  <div class="mb-1 text-secondary">Fecha de ultima actualización:</div>
  <input type="date" class="form-control rounded-0" id="FechaDocumentacion"> 
  </div>

 
  <div class="col-12 mb-2">  
  <div class="mb-1 text-secondary">Archivo:</div>
  <input type="file" class="form-control" id="ArchivoUP">
  </div>

  <div class="col-12">  
    <button class="btn btn-primary btn-sm mt-2 float-end" type="button" onclick="ActualizarArchivo(<?=$idProveedor;?>)">Actualizar archivo</button>
</div>

  </div>

 <hr>


<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0 " style="font-size: .8em;">
<thead class="tables-bg">
<tr>
<th class="align-middle text-center">Documento</th>
<th class="align-middle text-center">Fecha de ultima actualización</th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
</tr>
</thead>
<tbody>
<?php
if ($numero_listArchivo > 0) {
while($row_listArchivo = mysqli_fetch_array($result_listArchivo, MYSQLI_ASSOC)){

$nombre = $row_listArchivo['nombre'];
$fechaArchivo = FormatoFecha($row_listArchivo['fecha']);
$archivo = $row_listArchivo['archivo'];

$ToAlerta = ToAlerta($idProveedor,$nombre,$con);


echo '<tr class="text-center" '.$ToAlerta.'>';
echo '<td class="align-middle font-weight-light">'.$nombre.'</td>';
echo '<td class="align-middle font-weight-light">'.$fechaArchivo.'</td>';
echo '<td class="align-middle font-weight-light"><a href="'.RUTA_ARCHIVOS.'/proveedores/'.$archivo.'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a></td>';
echo '</tr>';

}
}else{
echo "<tr><td colspan='3' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>


<?=$AlertaCSF?>


</div>
</div>