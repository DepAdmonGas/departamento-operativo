<?php
require ('../../../app/help.php');

$year = $_GET['year'];
$mes = $_GET['mes'];
$idDias = $_GET['idDias'];
$idEstacion = $_GET['idEstacion'];

$sql_lista = "SELECT * FROM op_corte_dia_hist WHERE id_corte = '" . $idDias . "' ORDER BY id ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

function Responsable($id, $con)
{

  $sql_resp = "SELECT * FROM tb_usuarios WHERE id = '" . $id . "'  ";
  $result_resp = mysqli_query($con, $sql_resp);
  $numero_resp = mysqli_num_rows($result_resp);
  while ($row_resp = mysqli_fetch_array($result_resp, MYSQLI_ASSOC)) {
    $Usuario = $row_resp['nombre'];

  }
  return $Usuario;

}
?>

<div class="modal-header">
  <h5 class="modal-title">Activar corte</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
  <div class="table-responsive">
    <table class="custom-table " style="font-size: 1em;" width="100%">
      <thead class="tables-bg">
        <th class="text-center align-middle">#</th>
        <th class="text-center align-middle">Fecha</th>
        <th class="text-center align-middle">Usuario</th>
        <th class="text-center align-middle">Motivo</th>
      </thead>
      <tbody>
        <?php
        if ($numero_lista > 0) {
          $num = 1;
          while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
            $id = $row_lista['id'];
            $NomUsuario = Responsable($row_lista['id_usuario'], $con);

            $fechaExplode = explode(" ", $row_lista['fecha']);
            $FechaFormato = FormatoFecha($fechaExplode[0]);
            $HoraFormato = date("g:i a", strtotime($fechaExplode[1]));

            echo '<tr>';
            echo '<th class="align-middle text-center">' . $num . '</th>';
            echo '<td class="align-middle text-center">' . $FechaFormato . ', ' . $HoraFormato . '</td>';
            echo '<td class="align-middle text-center">' . $NomUsuario . '</td>';
            echo '<td class="align-middle text-center">' . $row_lista['detalle'] . '</td>';
            echo '</tr>';

            $num++;
          }
        } else {
          echo "<tr><th colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></th></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

</div>
<div class="modal-footer">
<?php if ($session_nompuesto != "Contabilidad") { ?>
  
      <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="NuevoReg(<?= $idEstacion; ?>,<?= $year; ?>,<?= $mes; ?>,<?= $idDias; ?>)">
      <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>

  <?php } ?>

</div>