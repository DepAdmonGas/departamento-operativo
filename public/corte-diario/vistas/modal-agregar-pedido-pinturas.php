<?php
require ('../../../app/help.php');

$idReporte = $_GET['idReporte'];

$sql_lista = "SELECT * FROM op_pinturas_lista WHERE estatus = 1 ORDER BY producto ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

function Producto($idProducto, $con)
{

  $sql_listaestacion = "SELECT unidad, producto FROM op_pinturas_lista WHERE id = '" . $idProducto . "' ";
  $result_listaestacion = mysqli_query($con, $sql_listaestacion);
  while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)) {
    $unidad = $row_listaestacion['unidad'];
    $producto = $row_listaestacion['producto'];
  }
  $result = array('unidad' => $unidad, 'producto' => $producto);

  return $result;
}
?>

<script type="text/javascript">
  $('.selectize').selectize({
    sortField: 'text'
  });
</script>


<div class="modal-header">
  <h5 class="modal-title">Crear pedido de pinturas</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
  <div class="row">
    <div class="col-8 mb-2">
      <div class="mb-1 text-secondary fw-bold">* PRODUCTO:</div>
      <div id="contenido-producto">
      <select class="selectize" placeholder="Producto" id="Producto">
        <option value="">Producto</option>
        <?php
        while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
          echo '<option value="' . $row_lista['id'] . '">' . $row_lista['producto'] . '<option>';
        }

        ?>
      </select>
      </div>
    </div>


    <div class="col-4 mb-2">
      <div class="mb-1 text-secondary fw-bold">* PIEZAS:</div>
      <input type="number" class="form-control rounded-0" id="Piezas">
    </div>

    <div class="col-12 mb-2">
      <div class="mb-1 text-secondary">OTRO:</div>
      <input type="text" class="form-control rounded-0" id="OtroProducto">
    </div>

    <div class="col-12 mb-2">
      <div class="mb-1 text-secondary">¿PARA QUE?</div>
      <textarea class="form-control rounded-0" id="ParaQue"></textarea>
    </div>
  </div>
</div>


<div class="modal-footer">
  <button type="button" class="btn btn-labeled2 btn-success" onclick="AgregarItem(<?= $idReporte ?>)">
    <span class="btn-label2"><i class="fa fa-check"></i></span>Agregar</button>
</div>


</div>