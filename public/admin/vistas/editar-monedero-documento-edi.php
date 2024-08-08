<?php
require ('../../../app/help.php');

$IdReporte = $_GET['IdReporte'];
$year = $_GET['year'];
$mes = $_GET['mes'];
$id = $_GET['id'];

$sql_lista = "SELECT * FROM op_monedero_documento WHERE id = '" . $id . "' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
$monedero = '';
while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
  $fecha = $row_lista['fecha'];
  $monedero = $row_lista['monedero'];
  $diferencia = $row_lista['diferencia'];
}

$sql_lista1 = "SELECT * FROM op_monedero_edi WHERE id_documento = '" . $id . "' ORDER BY id desc";
$result_lista1 = mysqli_query($con, $sql_lista1);
$numero_lista1 = mysqli_num_rows($result_lista1);
?>


<div class="modal-body">

<div class="row">

  <div class="col-12 mb-3">
    <span class="badge rounded-pill tables-bg float-end" style="font-size:12px"><b><?= $monedero; ?></b> (Documentos
      EDI)</span>
  </div>

  <div class="col-12 mb-2">
    <div class="mb-1 text-secondary">Complemento</div>
    <select class="form-select" id="Complemento">
      <option></option>
      <option>Complemento 1</option>
      <option>Complemento 2</option>
    </select>
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
    <div class="mb-1 text-secondary">Agregar PDF</div>
    <input class="form-control" type="file" id="PDF">
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
    <div class="mb-1 text-secondary">Agregar XML</div>
    <input class="form-control" type="file" id="XML">
  </div>

</div>

<br>

  <div class="table-responsive">
  <table class="custom-table" style="font-size: 12.5px;" width="100%">

    <thead class="tables-bg">
      <th class="align-middle text-center">Complemento</th>
      <th class="align-middle text-center" width="24"><img src="<?= RUTA_IMG_ICONOS; ?>pdf.png"></th>
      <th class="align-middle text-center" width="24"><img src="<?= RUTA_IMG_ICONOS; ?>xml.png"></th>

      <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>eliminar.png"></th>
    </thead>

    <tbody class="bg-light">
      <?php
      if ($numero_lista1 > 0) {
        while ($row_lista1 = mysqli_fetch_array($result_lista1, MYSQLI_ASSOC)) {

          if ($session_nompuesto != "Contabilidad" && $session_nompuesto != "Dirección de operaciones servicio social") {
            $eliminar = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="EliminarEdi(' . $IdReporte . ',' . $id . ',' . $row_lista1['id'] . ', '.$year.', '.$mes.')">';
          } else {
            $eliminar = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png" >';
          }

          echo '<tr>';
          echo '<th class="align-middle text-center fw-normal">' . $row_lista1['complemento'] . '</th>';

          echo '<td><a class="pointer" href="'.RUTA_ARCHIVOS.'' . $row_lista1['pdf'] . '" download><img src="' . RUTA_IMG_ICONOS . 'pdf.png"></a></td>';
          echo '<td><a class="pointer" href="'.RUTA_ARCHIVOS.'' . $row_lista1['xml'] . '" download><img src="' . RUTA_IMG_ICONOS . 'xml.png"></a></td>';

          echo '<td width="20">' . $eliminar . '</td>';
          echo '</tr>';

        }
      } else {
        echo "<tr><td colspan='7' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
      }
      ?>
    </tbody>
  </table>

</div>


</div>


<div class="modal-footer"> 

<button type="button" class="btn btn-labeled2 btn-danger float-end" onclick="Cancelar(<?= $IdReporte; ?>)">
<span class="btn-label2"><i class="fa fa-x"></i></span>Cancelar</button>

<button type="button" class="btn btn-labeled2 btn-success float-end"
    onclick="GuardarC(<?=$IdReporte?>,<?=$year?>,<?=$mes?>,<?= $id; ?>)">
    <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>



</div>