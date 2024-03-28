<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];
$idStatus = $_GET['idStatus'];

if($idStatus == 1){
$nameStatus = "Agregar";
}else{
$nameStatus = "Editar";	
}


$sql_lista = "SELECT * FROM op_modelo_negocio WHERE id = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista); 
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){ 
$Titulo = $row_lista['titulo']; 
$Descripcion = $row_lista['descripcion'];
}

$sql_documento = "SELECT * FROM op_modelo_negocio_documento WHERE id_modelo_negocio = '".$idReporte."' ";
$result_documento = mysqli_query($con, $sql_documento);
$numero_documento = mysqli_num_rows($result_documento);
?>


<div class="modal-header">
<h5 class="modal-title"><?=$nameStatus?> Modelo de negocio <?=$idReporte?></h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

 

<div class="modal-body">

<div><b>Titulo:</b></div>
<input type="text" class="form-control" id="val_titulo" onkeyup="Actualizar(this,<?=$idReporte;?>,1)" value="<?=$Titulo;?>">

 
<div class="mt-2"><b>Descripción:</b></div>
<textarea class="form-control" id="val_desc" onkeyup="Actualizar(this,<?=$idReporte;?>,2)"><?=$Descripcion;?></textarea>

<hr>

<div><b>Documentos:</b></div>
<select class="form-select" id="Documento">
<option></option>
<option>Layout</option>
<option>Contrató</option>
<option>Presupuesto</option>
<option>Requisitos</option>
</select>

<input type="file" class="form-control mt-3 mb-3" id="Archivo">

<div class="text-end">
<button type="button" class="btn btn-primary btn-sm" onclick="AgregarD(<?=$idReporte;?>)">Agregar documento</button>
</div>


<hr>

<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0 mt-2" style="font-size: .8em;">
<thead class="tables-bg">
<tr>
<th class="align-middle text-center">Nombre archivo</th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
</tr>
</thead>
<tbody>
<?php
if ($numero_documento > 0) {
while($row_documento = mysqli_fetch_array($result_documento, MYSQLI_ASSOC)){

$id = $row_documento['id'];

echo '<tr>';
echo '<td class="align-middle font-weight-light">'.$row_documento['nombre'].'</td>';
echo '<td class="align-middle font-weight-light"><a href="archivos/modelo-negocio/'.$row_documento['archivo'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a></td>';
echo '<td class="align-middle font-weight-light"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarDocumento('.$idReporte.','.$id.')"></td>';
echo '</tr>';

}
}else{
echo "<tr><td colspan='3' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>


</div>
<div class="modal-footer">
<button type="button" class="btn btn-success" onclick="Finalizar(<?=$idStatus?>)">Guardar</button>
</div>



