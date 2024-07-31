<?php
require ('../../../app/help.php');
$idReporte = $_GET['idReporte'];
$idStatus = $_GET['idStatus'];

if ($idStatus == 0) {
  $ocultarTb = "";
} else {
  $ocultarTb = "d-none";
}

?>


<div class="table-responsive mt-2">
  <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="tables-bg">
      <th colspan="6" class="text-center align-middle ">DATOS DEL PROVEEDOR</th>
    </tr>
    <tr class="align-middle title-table-bg">
      <td class="fw-bold">Razón Social</td>
      <th>Dirección</th>
      <th>Contacto</th>
      <th>Email</th>
      <th width="16px" class="<?= $ocultarTb ?>"><img src="<?= RUTA_IMG_ICONOS ?>editar-tb.png" width="20px"></th>
      <td width="16px" class="<?= $ocultarTb ?> fw-bold"><img src="<?= RUTA_IMG_ICONOS ?>eliminar.png" width="20px"></td>
    </tr>
    <tbody>
      <?php

      $sql = "SELECT * FROM op_orden_compra_proveedor WHERE id_ordencompra = '" . $idReporte . "' ";
      $result = mysqli_query($con, $sql);
      $numero = mysqli_num_rows($result);
      if ($numero > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

          $id = $row['id'];

          echo '<tr class="align-middle">
            <th>' . $row['razon_social'] . '</th>
            <td>' . $row['direccion'] . '</td>
            <td>' . $row['contacto'] . '</td>
            <td>' . $row['email'] . '</td>
            <td class="' . $ocultarTb . '"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'editar-tb.png" width="20px" onclick="ModalEditarProveedor(' . $id . ',' . $idReporte . ')"></td>
            <td class="' . $ocultarTb . '"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" width="20px" onclick="EliminarProveedor(' . $id . ',' . $idReporte . ')"></td>
            </tr>';
        }
      } else {
        echo "<tr><th colspan='6' class='text-center text-secondary'><small>No se encontró información para mostrar </small></th></tr>";
      }
      ?>

    </tbody>
  </table>
</div>