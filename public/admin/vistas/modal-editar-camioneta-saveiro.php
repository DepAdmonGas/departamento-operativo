<?php
require('../../../app/help.php');
$id = $_GET['id'];
$tipo = $_GET['tipo'];

$sql_lista = "SELECT fecha, descripcion FROM op_camioneta_saveiro_documentacion WHERE id = '".$id."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$fecha = $row_lista['fecha'];
$descripcion = $row_lista['descripcion'];
    
}


?>


<div class="modal-header">
  <h5 class="modal-title">Editar <?=$tipo?></h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
 

<div class="modal-body">

<div class="text-secondary mb-1">FECHA:</div>
<input type="date" class="form-control rounded-0 mb-2" id="Fecha" value="<?=$fecha?>">

<div class="text-secondary mb-1">DESCRIPCIÓN:</div>
<input type="text" class="form-control rounded-0 mb-2" id="Descripcion" value="<?=$descripcion?>">

<div class="text-secondary mb-1">ARCHIVO:</div>
<input type="file" class="form-control rounded-0 mb-2" id="Archivo">

</div> 


<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-danger float-end m-2" data-bs-dismiss="modal">
    <span class="btn-label2"><i class="fa fa-x"></i></span>Cancelar</button>
  <button type="button" class="btn btn-labeled2 btn-success float-end m-2"
    onclick="EditarDocumento('<?=$tipo?>',<?=$id?>)">
    <span class="btn-label2"><i class="fa fa-check"></i></span>Editar</button>
</div>
