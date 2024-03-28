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
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="row ">

<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-2"> 
<div class="border p-3">
<h6 class="mb-2 text-secondary ">Refacción:</h6>
<img src="archivos/<?=$imagen;?>" width="150px">
</div>
</div>

<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 mb-2"> 
 
<div class="row">
  
<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 mb-2"> 
<div class="border p-3">
    <h6 class="mb-1 text-secondary ">Nombre Refacción:</h6>
    <div class=""><?=$nombre;?></div>
</div>
</div>


<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12"> 
<div class="border p-3">
    <h6 class="mb-1 text-secondary ">Unidades:</h6>
    <div class=""><?=$unidad;?></div>
</div>
</div>

</div>

<hr>

<div class="row">


<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
 <div class="border p-3">   
    <h6 class="mb-1 text-secondary ">Costo por unidad:</h6>
    <div class="">$ <?=number_format($costo,2);?></div>
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"> 
<div class="border p-3">
    <h6 class="mb-1 text-secondary ">Total:</h6>
    <div class=""><b>$ <?=number_format($total,2);?></b></div>
</div>
  </div>

</div>

</div>

  </div>
</div>

