<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];
$idEstacion = $_GET['idEstacion'];

if($session_nompuesto == "Encargado"){
$ocultarTB = "d-none";

}else{
$ocultarTB = ""; 
}

?>

<div class="modal-header">
  <h5 class="modal-title">Agregar evidencia</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<label class="text-secondary">Imagen:</label>
<div><input type="file" class="form-control" id="Imagen"></div>

<hr>

<?php  
 
$sql_lista = "SELECT * FROM op_pedido_materiales_instalacion WHERE id_pedido = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$archivos = $row_lista['archivo'];

$extension = pathinfo($archivos, PATHINFO_EXTENSION);

if($extension == "png" || $extension == "jpg"){
    $tipoArchivo = '<img style="width: 100%; class="mt-1" src="'.RUTA_ARCHIVOS.$archivos.'"/>';
}else{
  $tipoArchivo = '<iframe style="width: 100%; height: 500px" class="mt-1" src="'.RUTA_ARCHIVOS.$archivos.'"/>';
}


echo '<div class="border mt-2 p-2">

<div class="row">
<div class="12">

<div class="float-end">

<button type="button" class="btn btn-labeled2 btn-danger '.$ocultarTB.'" onclick="EliminarEvidencia('.$row_lista['id'].','.$idEstacion.','.$idReporte.')">
<span class="btn-label2"><i class="fa-regular fa-trash-can"></i></span>Eliminar evidencia</button>

</div>
</div>
</div>

<hr class="'.$ocultarTB.'">

'.$tipoArchivo.'
 
</div>';

}

?>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="AgregarEvidencia(<?=$idEstacion;?>,<?=$idReporte;?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Agregar</button>
</div>

  