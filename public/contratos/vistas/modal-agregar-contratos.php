<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$Cate = $_GET['Cate'];

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}

?>

 <div class="modal-header">
  <h5 class="modal-title">Agregar contratos <?=$estacion?></h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
 </div>

<div class="modal-body">

<h6 class="mb-1">* Fecha:</h6>
<input class="form-control" type="date" id="FechaC">

<h6 class="mb-1 mt-3">* Documento:</h6>
<textarea class="form-control" id="DescripcionC"></textarea>


<h6 class="mt-3 mb-1">* PDF:</h6>
<input class="form-control" type="file" id="ContratoDoc">

<h6 class="mb-1 mt-3">Objeto:</h6>
<textarea class="form-control" id="Objeto"></textarea>

<h6 class="mb-1 mt-3">Proveedor:</h6>
<textarea class="form-control" id="Proveedor"></textarea>

<h6 class="mb-1 mt-3">Vencimiento:</h6>
<input type="date" class="form-control" id="Vencimiento">

<h6 class="mb-1 mt-3">Personas que firman:</h6>
<textarea class="form-control" id="Firman"></textarea>

<h6 class="mb-1 mt-3">Comentario:</h6>
<textarea class="form-control" id="Comentario"></textarea>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="AgregarContrato(<?=$idEstacion?>,'<?=$Cate;?>')">
<span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
</div>