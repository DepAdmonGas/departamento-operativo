<?php
require('../../../app/help.php');
$idRefaccion = $_GET['idRefaccion'];

$sql_lista = "SELECT * FROM op_refacciones WHERE id = '".$idRefaccion."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$nombre = $row_lista['nombre'];
$imagen = $row_lista['imagen'];
$unidad = $row_lista['unidad'];
$costo = $row_lista['costo'];

$total = $unidad * $costo;
}

?>

<div class="modal-header">
<h5 class="modal-title">Detalle de la Refacción</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="row">

<div class="col-12"> 
<div class="table-responsive">
<table class="custom-table" style="font-size: 12.5px;" width="100%">
<thead class="tables-bg">
<tr> <th class="align-middle text-center" colspan="4">Refacción</th> </tr>
</thead>
<tbody>
<tr class="no-hover">
<th class="align-middle text-center bg-light fw-normal"><b>Nombre Refacción:</b> <br><?=$nombre;?></th>
<th class="align-middle text-center bg-light fw-normal"><b>Unidades:</b> <br><?=$unidad;?></th>
<th class="align-middle text-center bg-light fw-normal"><b>Costo por unidad:</b> <br>$ <?=number_format($costo,2);?></th>
<th class="align-middle text-center bg-light fw-normal"><b>Total:</b> <br>$ <?=number_format($total,2);?></th>
</tr>

<tr class="no-hover">
<th colspan="4" class="align-middle text-center bg-light"><img src="archivos/<?=$imagen;?>" width="100%" height="200px"></th>
</tr>
</tbody>
</table>
</div>
</div>

</div>
</div>

