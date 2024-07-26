<?php
require('../../../app/help.php');

$idDocumento = $_GET['idDocumento'];

$sql = "SELECT nombre, formato FROM op_lista_formatos WHERE id = '".$idDocumento."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$formato = $row['formato'];
$nombre = $row['nombre'];
}

?> 
<div class="modal-header">

<h5 class="modal-title">Editar Formato</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
 
<div class="modal-body">

<h6 class="mb-1">* Clave del formato:</h6>
<textarea class="form-control" id="Clave"><?=$formato;?></textarea>

<h6 class="mt-2 mb-1">* Nombre del formato:</h6>
<textarea class="form-control" id="Formato"><?=$nombre;?></textarea>


</div>

<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="Editar(<?=$idDocumento;?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Editar</button>
</div>
