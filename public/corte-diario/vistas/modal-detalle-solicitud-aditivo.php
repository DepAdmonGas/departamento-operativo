<?php
require ('../../../app/help.php');

$idReporte = $_GET['idReporte'];

$sql_lista = "SELECT * FROM op_solicitud_aditivo WHERE id = '" . $idReporte . "' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
  $ordencompra = $row_lista['orden_compra'];
  $para = $row_lista['para'];
  $fecha = $row_lista['fecha'];
  $idpersonal = $row_lista['id_personal'];
  $fechaentrega = $row_lista['fecha_entrega'];
  $comentarios = $row_lista['comentarios'];
  $status = $row_lista['status'];
}
if ($comentarios == ''):
  $comentarios = 'Sin comentarios';
endif;
function Personal($idusuario, $con)
{
  $sql = "SELECT nombre FROM tb_usuarios WHERE id = '" . $idusuario . "' ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $nombre = $row['nombre'];
  }
  return $nombre;
}
?>


<div class="modal-header">
  <h5 class="modal-title">Detalle de Solicitud de aditivo</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

  <div class="row">

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-1 mt-1">
      <span class="badge rounded-pill tables-bg float-start">Fecha:
        <?= FormatoFecha($fecha); ?></span>
    </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-1 mt-1">
      <span class="badge rounded-pill tables-bg float-end">No. Orden de Compra:
        <?= $ordencompra; ?></span>
    </div>

  </div>
  <br>
  <div class="row">
    <div class="col-12">
    <div class="text-secondary fw-bold">PARA:</div>
      <?= $para ?>
    </div>
    <br>
    <div class="col-12">
    <div class="text-secondary fw-bold">COMENTARIOS O INSTRUCCIONES ESPECIALES:</div>
      <?= $comentarios ?>
    </div>
  </div>
  <hr>
  <div class="table-responsive">
    <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
      <thead class="tables-bg">
        <tr>
          <th class="text-center align-middle tableStyle font-weight-bold">FECHA DE ENTREGA REQUERIDA</th>
          <th class="text-center align-middle tableStyle font-weight-bold">SOLICITADO POR</th>
        </tr>
      </thead>
      <tbody class="bg-light">
        <tr>
          <th class="text-center">
            <?= FormatoFecha($fechaentrega) ?>
          </th>
          <td class="text-center align-middle">
            <b><?= Personal($idpersonal, $con) ?></b>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <br>
  <div class="table-responsive">
    <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
      <thead class="tables-bg">
        <tr>
          <th class="text-center align-middle tableStyle font-weight-bold">CANTIDAD DE TAMBORES</th>
          <th class="text-center align-middle tableStyle font-weight-bold">NOMBRE DEL PRODUCTO</th>
          <th class="text-center align-middle tableStyle font-weight-bold">NOMBRE DEL ADITIVO</th>
          <th class="text-center align-middle tableStyle font-weight-bold">KILOGRAMOS POR TAMBOR</th>
          <th class="text-center align-middle tableStyle font-weight-bold">TOTAL KILOS</th>
        </tr>
      </thead>

      <tbody class="bg-light">
        <?php
        $sql_aditivo = "SELECT * FROM op_solicitud_aditivo_tambo WHERE id_reporte = '" . $idReporte . "' ";
        $result_aditivo = mysqli_query($con, $sql_aditivo);
        $numero_aditivo = mysqli_num_rows($result_aditivo);
        if ($numero_aditivo > 0) {
          while ($row_aditivo = mysqli_fetch_array($result_aditivo, MYSQLI_ASSOC)) {
            $id = $row_aditivo['id'];

            $totalkilogramos = $row_aditivo['cantidad'] * $row_aditivo['kilogramo'];
            echo '<tr>
                  <th class="text-center align-middle">' . $row_aditivo['cantidad'] . '</th>
                  <td class="text-center align-middle">' . $row_aditivo['producto'] . '</td>
                  <td class="text-center align-middle">' . $row_aditivo['aditivo'] . '</td>
                  <td class="text-center align-middle">' . $row_aditivo['kilogramo'] . '</td>
                  <td class="text-center align-middle" id="TK' . $id . '">' . $totalkilogramos . '</td>
                </tr>';
          }
        } else {
          echo "<tr><th colspan='7' class='text-center text-secondary'><small>No se encontró información para mostrar </small></th></tr>";
        }

        ?>
      </tbody>
    </table>
  </div>
  <br>

  <div class="row">
    <div class="col-12">
      <?php
      if ($status == 1): ?>

        <div class="row">
          <?php
          $sql_firma = "SELECT * FROM op_solicitud_aditivo_firma WHERE id_reporte = '" . $idReporte . "' ";
          $result_firma = mysqli_query($con, $sql_firma);
          $numero_firma = mysqli_num_rows($result_firma);
          while ($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)):
            $explode = explode(' ', $row_firma['fecha']);
            $TipoFirma = "NOMBRE Y FIRMA DE VoBo";
            $Detalle = '<th class="border-bottom text-center p-3"><small>La solicitud de aditivo se firmó por un medio electrónico.</br> Fecha: ' . FormatoFecha($explode[0]) . ', ' . date("g:i a", strtotime($explode[1])) . '</small></th>';
            ?>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
              <div class="table-responsive">
                <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
                  <thead class="tables-bg">
                    <tr>
                      <th class="text-center align-middle">
                        <?= $TipoFirma ?>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th class="text-center align-middle">
                        <?= Personal($row_firma['id_usuario'], $con) ?>
                      </th>
                    </tr>
                    <tr>
                      <?= $Detalle ?>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

          <?php endwhile; ?>
        </div>

      <?php else: ?>
        <div class="row">

          <div class="col-12 text-center mb-0">
            <div class="alert alert-warning" role="alert">
              ¡Falta la firma de autorización!
            </div>
          </div>
        </div>

        <?php endif; ?>

    </div>
  </div>

</div>