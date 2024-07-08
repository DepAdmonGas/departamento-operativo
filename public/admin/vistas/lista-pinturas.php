<?php
require ('../../../app/help.php');

$sql_lista = "SELECT * FROM op_pinturas_lista WHERE estatus = 1 ORDER BY producto ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
?>

<div class="p-3">
  <div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
      <div class="row">
        <div class="col-9">
          <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
            Catálogo de pinturas y complementos
          </h3>
        </div>
        <div class="col-3">
          <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="ModalNevoProducto()">
            <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
        </div>
      </div>
    </div>

  </div>

  <hr>

  <div class="table-responsive">
    <table id='tabla-catalogo' class="custom-table" style="font-size: .8em;" width="100%">
      <thead class="title-table-bg">
        <th class="text-center align-middle">#</th>
        <th class="text-center align-middle">Producto</th>
        <th class="text-center align-middle">Unidad</th>
        <th class="text-center align-middle" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>editar-tb.png"></th>
        <th class="text-center align-middle" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>eliminar.png"></th>
      </thead>
      <tbody class="bg-white">
        <?php
        if ($numero_lista > 0) {
          $num = 1;
          while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
            $id = $row_lista['id'];

            echo '<tr>';
            echo '<th class="align-middle text-center">' . $num . '</th>';
            echo '<td class="align-middle text-center">' . $row_lista['producto'] . '</td>';
            echo '<td class="align-middle text-center">' . $row_lista['unidad'] . '</td>';
            echo '<td class="align-middle text-center"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'editar-tb.png" onclick="EditarProducto(' . $id . ')"></td>';
            echo '<td class="align-middle text-center"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="EliminarProducto(' . $id . ')"></td>';
            echo '</tr>';

            $num++;
          }
        } else {
          echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>