<?php
require('../../../app/help.php');

$idProducto = $_GET['idProducto'];

if($idProducto == 0){
$producto = ""; 
$unidad = "Seleccione";
$value = "";
}else{

$sql_producto = "SELECT * FROM op_limpieza_lista WHERE id = '".$idProducto."' ";
$result_producto = mysqli_query($con, $sql_producto);
$numero_producto = mysqli_num_rows($result_producto);
while($row_producto = mysqli_fetch_array($result_producto, MYSQLI_ASSOC)){
$unidad = $row_producto['unidad'];
$producto = $row_producto['producto'];
$value = $row_producto['unidad'];
}
}
?>
<div class="modal-header">
<h5 class="modal-title">Agregar pintura y complemento</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
      <div class="modal-body">

      	<div class="mb-2 text-secondary">Producto:</div>
        <textarea class="form-control rounded-0" id="Producto"><?=$producto;?></textarea>

        <div class="mb-1 mt-2 text-secondary">Unidad:</div>
        <select class="form-select rounded-0" id="Unidad">
          <option value="<?=$value;?>"><?=$unidad;?></option>

          <option value="1 KG.">1 KG.</option>
          <option value="BULTO.">BULTO.</option>
          <option value="CAJA.">CAJA.</option>
          <option value="CUB.">CUB.</option>
          <option value="PZA.">PZA.</option>
          <option value="ROLLO.">ROLLO.</option>
        </select>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="CreateUpdateProducto(<?=$idProducto;?>)">Guardar</button>
      </div>
