<?php
require ('../../../app/help.php');

$sql_lista = "SELECT * FROM op_limpieza_lista WHERE estatus = 1 ORDER BY producto ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
?>
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
    <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
          class="fa-solid fa-house"></i> Comercializadora</a></li>
    <li aria-current="page" class="breadcrumb-item active text-uppercase"> Catálogo de artículos de limpieza</li>
  </ol>
</div>
<div class="row">
  <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12">
    <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
      Catálogo de artículos de limpieza
    </h3>
  </div>
  <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
    <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="ModalNevo()">
      <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
  </div>

</div>

<hr>

<div class="table-responsive">
  <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="tables-bg">
      <th class="text-center align-middle">#</th>
      <th class="align-middle">Producto</th>
      <th class="align-middle">Unidad</th>
      <th class="text-center align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>editar-tb.png"></th>
      <th class="text-center align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>eliminar.png"></th>
    </thead>
    <tbody class="bg-white">
      <?php
      if ($numero_lista > 0) {
        $num = 1;
        while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
          $id = $row_lista['id'];

          echo '<tr>';
          echo '<th class="align-middle text-center">' . $num . '</th>';
          echo '<td class="align-middle">' . $row_lista['producto'] . '</td>';
          echo '<td class="align-middle">' . $row_lista['unidad'] . '</td>';
          echo '<td class="align-middle text-center"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'editar-tb.png" onclick="EditarProducto(' . $id . ')"></td>';
          echo '<td class="align-middle text-center"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="EliminarProducto(' . $id . ')"></td>';
          echo '</tr>';

          $num++;
        }
      }
      ?>
    </tbody>
  </table>
</div>