<?php
require('../../../app/help.php');

$IdReporte = $_GET['IdReporte'];
$id = $_GET['id'];

$cuenta = "";
$puesto = "";
$clave = "";

$sql_lista = "SELECT * FROM op_directorio WHERE id = '".$id."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$cuenta = $row_lista['cuenta'];
$puesto = $row_lista['puesto'];
$clave = $row_lista['clave'];
}



?>

<div class="modal-header">
<h5 class="modal-title">Agregar directorio</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
        
<div class="mb-1 text-secondary">Cuenta</div>
<input type="text" class="form-control rounded-0" id="Cuenta" value="<?=$cuenta;?>">

<div class="mb-1 mt-2 text-secondary">Puesto</div>
<input type="text" class="form-control rounded-0" id="Puesto" value="<?=$puesto;?>">

<div class="mb-1 mt-2 text-secondary">Clave</div>
<input type="text" class="form-control rounded-0" id="Clave" value="<?=$clave;?>">

</div>
      
<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="GuardarDirectorio(<?=$IdReporte;?>,<?=$id;?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
</div> 