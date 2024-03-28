<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$sql_lista = "SELECT * FROM op_limpieza_lista WHERE estatus = 1 ORDER BY producto ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);


?>
<script type="text/javascript">
$('.selectize').selectize({
sortField: 'text'
});
</script>

<div class="modal-header">
<h5 class="modal-title">Agregar productos de limpieza a inventario</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
      <div class="modal-body">

      	<div class="mb-1 text-secondary">Producto:</div>
        <select class="selectize" placeholder="Producto" id="Producto">
          <option value="">Producto</option>
        <?php
        while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
          echo '<option value="'.$row_lista['id'].'">'.$row_lista['producto'].'</option>';
        }

        ?>
        </select>

        <div class="mb-1 mt-2 text-secondary">Piezas:</div>
        <input type="number" class="form-control rounded-0" id="Piezas">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="CreateInventario(<?=$idEstacion;?>)">Guardar</button>
      </div>
