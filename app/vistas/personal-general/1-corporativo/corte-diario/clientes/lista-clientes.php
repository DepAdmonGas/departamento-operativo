<?php
require ('../../../../../help.php');

$idEstacion = $_GET['idEstacion'];

// Obtener el número de clientes de crédito
$numero_credito = $corteDiarioGeneral->getNumeroClientesPorTipo($idEstacion, 'Crédito');

// Obtener el número de clientes de débito
$numero_debito = $corteDiarioGeneral->getNumeroClientesPorTipo($idEstacion, 'Débito');

?>
<div class="row">
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
    <div class="table-responsive">
      <table id="tabla_credito" class="custom-table mt-2" style="font-size: .8em;" width="100%">
        <thead class="title-table-bg">
          <tr class="tables-bg">
            <th class="text-center align-middle fw-bold" colspan="4">Crédito</th>
          </tr>
          <tr class="fw-bold">
            <td class="first-th">Cuenta</td>
            <th>Cliente</th>
            <th>RFC</th>
            <td width="20px"><img src="<?= RUTA_IMG_ICONOS; ?>editar-tb.png" width="20px"></td>
          </tr>
        </thead>
        <tbody class="bg-white">
          <?php
          if ($numero_credito > 0):
            $sql_credito = "SELECT * FROM op_cliente WHERE id_estacion = '" . $idEstacion . "' AND tipo = 'Crédito' AND estado = 1 ";
            $result_credito = mysqli_query($con, $sql_credito);
            while ($row_credito = mysqli_fetch_array($result_credito, MYSQLI_ASSOC)) {
              echo '<tr>
                                <th class="align-middle font-weight-light fw-bold"  style="font-size: .9em;">' . $row_credito['cuenta'] . '</th>
                                <td class="align-middle font-weight-light"  style="font-size: .9em;">' . $row_credito['cliente'] . '</td>
                                <td class="align-middle font-weight-light"  style="font-size: .9em;">' . $row_credito['rfc'] . '</td>
                                <td width="20px" class="align-middle">
                                <img class="pointer" src="' . RUTA_IMG_ICONOS . 'editar-tb.png" onclick="Editar(' . $row_credito['id'] . ')" width="20px">
                                </td>
                                </tr>';
            }
          endif;
          ?>
        </tbody>
      </table>
    </div>

  </div>




  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
    <hr class="responsive-hr">

    <div class="table-responsive">
      <table id="tabla_debito" class="custom-table mt-2" style="font-size: .8em;" width="100%">
        <thead class="title-table-bg">
          <tr class="tables-bg">
            <th class="text-center align-middle fw-bold" colspan="3">Débito</th>
          </tr>
          <tr class="fw-bold">
            <td>Cuenta</td>
            <th>Cliente</th>
            <td width="20px"><img src="<?= RUTA_IMG_ICONOS; ?>editar-tb.png" width="20px"></td>
          </tr>
        </thead>
        <tbody class="bg-white">
          <?php
          if ($numero_debito > 0):
            $sql_debito = "SELECT * FROM op_cliente WHERE id_estacion = '" . $idEstacion . "' AND tipo = 'Débito' AND estado = 1 ";
            $result_debito = mysqli_query($con, $sql_debito);
            while ($row_debito = mysqli_fetch_array($result_debito, MYSQLI_ASSOC)) {
              echo '<tr>
                                <th class="align-middle font-weight-light fw-bold" style="font-size: .9em;">' . $row_debito['cuenta'] . '</th>
                                <td class="align-middle font-weight-light" style="font-size: .9em;">' . $row_debito['cliente'] . '</td>
                                <td width="20px" class="align-middle">
                                <img class="pointer" src="' . RUTA_IMG_ICONOS . 'editar-tb.png" onclick="Editar(' . $row_debito['id'] . ')" width="20px">
                                </td>
                                </tr>';
            }
          endif;
          ?>
        </tbody>
      </table>
    </div>

  </div>
</div>
<!---------- FUNCIONES - NAVBAR ---------->
<script
  src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

<script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>