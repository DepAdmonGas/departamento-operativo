<?php
require ('../../../app/help.php');

$idReporte = $_GET['idReporte'];

function Producto($idProducto, $con)
{

  $sql_listaestacion = "SELECT unidad, producto FROM op_limpieza_lista WHERE id = '" . $idProducto . "' ";
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
  <h5 class="modal-title">Material utilizado</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">

  <div class="row">

    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 mt-2 mb-2">
      <div class="mb-1 text-secondary FW-BOLD">* LIMPIEZA:</div>
      <select class="selectize pointer" placeholder="Producto" id="Producto">
        <option value="">Selecciona</option>
        <?php
        $sql_lista = "SELECT * FROM op_inventario_limpieza WHERE id_estacion = '" . $Session_IDEstacion . "' AND piezas > 0 AND status = 1 ORDER BY id ASC";
        $result_lista = mysqli_query($con, $sql_lista);
        $numero_lista = mysqli_num_rows($result_lista);
        while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {

          $Producto = Producto($row_lista['id_producto'], $con);
          echo '<option value="' . $row_lista['id_producto'] . '">' . $Producto['producto'] . '</option>';
        }
        ?>
      </select>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mt-2 mb-2">
      <div class="mb-1 text-secondary fw-bold">* PIEZAS UTILIZADAS:</div>
      <input type="number" class="form-control rounded-0" id="Unidad" min="1">
    </div>

    <div class="col-12 mt-2">
      <div class="mb-1 text-secondary">OBSERVACIONES:</div>
      <textarea class="form-control rounded-0" id="Observacion"></textarea>
    </div>

  </div>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="AgregarItemReporte(<?=$idReporte?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Agregar</button>
</div>