<?php
require('../../../app/help.php');

$idProducto = $_GET['idProducto'];

if($idProducto == 0){
$producto = ""; 
$costo = "";

}else{

$sql_producto = "SELECT * FROM op_papeleria_lista WHERE id = '".$idProducto."' ";
$result_producto = mysqli_query($con, $sql_producto);
$numero_producto = mysqli_num_rows($result_producto);
while($row_producto = mysqli_fetch_array($result_producto, MYSQLI_ASSOC)){

$producto = $row_producto['producto'];
}
}
?>

<div class="modal-header">
<h5 class="modal-title">Agregar pintura y complemento</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

      <div class="modal-body">

      	<div class="mb-1 text-secondary">Producto:</div>
        <textarea class="form-control rounded-0" id="Producto"><?=$producto;?></textarea>

      </div>
      
      <div class="modal-footer">
        
  <button type="button" class="btn btn-labeled2 btn-success" onclick="CreateUpdateProducto(<?=$idProducto?>)">
    <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
    </div>
