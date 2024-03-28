 <?php
require('../../../app/help.php');

$idSenalamiento = $_GET['idSenalamiento'];

if($_GET['Senalamiento'] == 1){
$titulo = 'NOM-003-SEGOB-2011';

}else if($_GET['Senalamiento'] == 2){
$titulo = 'NOM-005-ASEA-2016';

}else if($_GET['Senalamiento'] == 3){
$titulo = 'IMAGEN G500';
}


$sql_documento = "SELECT * FROM op_senalamientos_archivos WHERE id_imagen = '".$idSenalamiento."' ORDER BY fecha DESC";
$result_documento = mysqli_query($con, $sql_documento);
$numero_documento = mysqli_num_rows($result_documento);

?>  
 
<div class="modal-header">
<h5 class="modal-title">Documentos <?=$titulo?></h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="mb-1 text-secondary">Fecha:</div>
<div class="input-group">
  <input type="date" class="form-control" id="Fecha">
</div>


<div class="mb-1 mt-2 text-secondary">Descripcion:</div>
<div class="input-group">
  <input type="text" class="form-control" id="Descripcion">
</div>

<div class="mb-1 mt-2 text-secondary">Archivo:</div>
<div class="input-group">
  <input type="file" class="form-control" id="Archivo">
</div>
 
<hr> 

<div class="row">
<div class="col-12">
    <button class="btn btn-outline-secondary btn-sm mb-3 float-end" type="button" onclick="AgregarArchivo(<?=$idSenalamiento;?>)">Agregar archivo</button></div>
</div>


 
<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0 " style="font-size: .8em;">
<thead class="tables-bg">
<tr>
<th class="align-middle text-center">Fecha</th>
<th class="align-middle text-center">Descripción</th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
</tr>
</thead>
<tbody>
<?php
if ($numero_documento > 0) {
while($row_documento = mysqli_fetch_array($result_documento, MYSQLI_ASSOC)){

$GET_idArchivo = $row_documento['id'];

$archivotb = $row_documento['archivo'];

echo '<tr class="align-middle text-center">';
echo '<td class="align-middle font-weight-light">'.FormatoFecha($row_documento['fecha']).'</td>';
echo '<td class="align-middle font-weight-light">'.$row_documento['descripcion'].'</td>';
echo '<td class="align-middle font-weight-light"><a href="'.RUTA_ARCHIVOS.'senalamientos/'.$row_documento['archivo'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a></td>';
echo '<td class="align-middle font-weight-light"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarArchivo('.$GET_idArchivo.','.$idSenalamiento.')"></td>';
echo '</tr>';

}
}else{
echo "<tr><td colspan='5' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>

</div>
