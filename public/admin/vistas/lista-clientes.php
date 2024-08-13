<?php
require ('../../../app/help.php');

$idReporte = $_GET['idReporte'];

function IdEstacion($idReporte, $con)
{
  $sql_credito = "SELECT
op_consumos_pagos.id,
op_consumos_pagos.id_reportedia,
op_consumos_pagos.id_cliente,
op_consumos_pagos.total,
op_consumos_pagos.tipo AS ConsumoTipo,
op_consumos_pagos.pago,
op_consumos_pagos.comprobante,
op_cliente.id_estacion,
op_cliente.cuenta,
op_cliente.cliente,
op_cliente.tipo
FROM op_consumos_pagos 
INNER JOIN op_cliente
ON op_consumos_pagos.id_cliente = op_cliente.id
WHERE op_consumos_pagos.id_reportedia = '" . $idReporte . "' LIMIT 1 ";
  $result_credito = mysqli_query($con, $sql_credito);
  $numero_credito = mysqli_num_rows($result_credito);
  while ($row_credito = mysqli_fetch_array($result_credito, MYSQLI_ASSOC)) {
    $idEstacion = $row_credito['id_estacion'];
  }

  return $idEstacion;
}

$idEstacion = IdEstacion($idReporte, $con);

$sql_credito = "SELECT * FROM op_cliente WHERE id_estacion = '" . $idEstacion . "' AND tipo = 'Crédito' AND estado = 1 ";
$result_credito = mysqli_query($con, $sql_credito);
$numero_credito = mysqli_num_rows($result_credito);

$sql_debito = "SELECT * FROM op_cliente WHERE id_estacion = '" . $idEstacion . "' AND tipo = 'Débito' AND estado = 1 ";
$result_debito = mysqli_query($con, $sql_debito);
$numero_debito = mysqli_num_rows($result_debito);

?>

<div class="row">

  <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 mb-3">
    <div class="table-responsive">
      <table id="tabla_credito" class="custom-table mt-2" style="font-size: .8em;" width="100%">
        <thead class="title-table-bg">
          <tr class="tables-bg">
            <th class="text-center align-middle fw-bold" colspan="8">Crédito</th>
          </tr>
          <tr>
            <td class="align-middle text-center fw-bold">Cuenta</td>
            <th class="align-middle text-center">Cliente</th>
            <th class="align-middle text-center">RFC</th>
            <th class="text-center align-middle">Carta de crédito</th>
            <th class="text-center align-middle">Acta constitutiva</th>
            <th class="text-center align-middle">Comprobante de domicilio</th>
            <th class="text-center align-middle">Identificación</th>
            <td width="20px" class="text-center align-middle fw-bold"><img src="<?= RUTA_IMG_ICONOS; ?>editar-tb.png"></td>

          </tr>
        </thead>
        <tbody class="bg-white">
          <?php
          if ($numero_credito > 0) {
            while ($row_credito = mysqli_fetch_array($result_credito, MYSQLI_ASSOC)) {

              if ($row_credito['doc_cc'] != "") {
                $CC = '<a target="_blank" href="'.RUTA_ARCHIVOS.'' . $row_credito['doc_cc'] . '"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'pdf.png"></a>';
              } else {
                $CC = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png">';
              }

              if ($row_credito['doc_ac'] != "") {
                $AC = '<a target="_blank" href="'.RUTA_ARCHIVOS.'' . $row_credito['doc_ac'] . '"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'pdf.png"></a>';
              } else {
                $AC = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png">';
              }

              if ($row_credito['doc_cd'] != "") {
                $CD = '<a target="_blank" href="'.RUTA_ARCHIVOS.'' . $row_credito['doc_cd'] . '"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'pdf.png"></a>';
              } else {
                $CD = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png">';
              }

              if ($row_credito['doc_io'] != "") {
                $IO = '<a target="_blank" href="'.RUTA_ARCHIVOS.'' . $row_credito['doc_io'] . '"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'pdf.png"></a>';
              } else {
                $IO = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png">';
              }

              echo '<tr>
                        <th class="align-middle text-center font-weight-light"  style="font-size: .9em;">' . $row_credito['cuenta'] . '</th>
                        <td class="align-middle text-start font-weight-light "  style="font-size: .9em;">' . $row_credito['cliente'] . '</td>
                        <td class="align-middle text-center font-weight-light"  style="font-size: .9em;">' . $row_credito['rfc'] . '</td>

                        <td class="align-middle font-weight-light text-center"  style="font-size: .9em;">' . $CC . '</td>
                        <td class="align-middle font-weight-light text-center"  style="font-size: .9em;">' . $AC . '</td>
                        <td class="align-middle font-weight-light text-center"  style="font-size: .9em;">' . $CD . '</td>
                        <td class="align-middle font-weight-light text-center"  style="font-size: .9em;">' . $IO . '</td>
                        <td width="20px" class="align-middle text-center">
                        <img class="pointer" src="' . RUTA_IMG_ICONOS . 'editar-tb.png" onclick="Editar(' . $row_credito['id'] . ')" width="20px">
                        </td>
                      </tr>';

            }
          }
          ?>
        </tbody>
      </table>
    </div>

  </div>

  <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-3">
  <div class="table-responsive">
      <table id="tabla_debito" class="custom-table mt-2" style="font-size: .8em;" width="100%">
        <thead class="title-table-bg">
          <tr class="tables-bg">
            <th class="text-center align-middle fw-bold" colspan="2">Débito</th>
          </tr>
          <tr>
            <td class="fw-bold">Cuenta</td>
            <td class="fw-bold">Cliente</td>
          </tr>
        </thead>
        <tbody class="bg-white">
          <?php
          if ($numero_debito > 0) {
            while ($row_debito = mysqli_fetch_array($result_debito, MYSQLI_ASSOC)) {

              echo '<tr>
                        <th class="align-middle font-weight-light" style="font-size: .9em;">' . $row_debito['cuenta'] . '</th>
                        <td class="align-middle font-weight-light text-start" style="font-size: .9em;">' . $row_debito['cliente'] . '</td>
                      </tr>';
            }
          }
          ?>
        </tbody>
      </table>
    </div>

  </div>
</div>