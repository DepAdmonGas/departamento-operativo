<?php
require 'app/vistas/contenido/header.php';
$IdReporte = $corteDiarioGeneral->idReporte($Session_IDEstacion, $GET_year, $GET_mes);
$Pdia = $corteDiarioGeneral->primerDia($GET_year, $GET_mes);
$Udia = $corteDiarioGeneral->ultimoDia($GET_year, $GET_mes);
?>
<style media="screen">
  .tooltip1 {
    display: inline-block;
    position: relative;
    text-align: left;
  }

  .tooltip1 {
    display: inline-block;
    position: relative;
    text-align: left;
  }

  .tooltip1 .bottom {
    top: 35px;
    left: 35%;
    transform: translate(-50%, 0);
    padding: 5px;
    color: white;
    background-color: black;
    font-weight: normal;
    font-size: 13px;
    border-radius: 8px;
    position: absolute;
    z-index: 999999999;
    box-shadow: 0 1px 8px rgba(0, 0, 0, 0.5);
    display: none;
    text-align: center;
  }

  .tooltip1:hover .bottom {
    display: block;
  }

  .grayscale {
    filter: grayscale(100%);
  }
</style>
<script type="text/javascript" src="<?php echo RUTA_CORTEDIARIO_JS ?>corte-diario-mes-function.js"></script>
<body>
  <div class="LoaderPage"></div>
  <!---------- DIV - CONTENIDO ---------->
  <div id="content">
    <!---------- NAV BAR - PRINCIPAL (TOP) ---------->
    <?php include_once "public/navbar/navbar-perfil.php"; ?>
    <!---------- CONTENIDO PAGINA WEB---------->
    <div class="contendAG">
      <div class="row">
        <div class="col-12 mb-3">
          <div class="cardAG">
            <div class="border-0 p-3">
              <div class="row">
                <div class="float-left col-xl-6 col-lg-6 col-md-6 col-12 mb-2">
                  <h5 class="card-title">
                    <img class="pointer" src="<?= RUTA_IMG_ICONOS; ?>regresar.png" onclick="history.back()"> Corte Diario,
                    <?= nombremes($GET_mes); ?> <?= $GET_year; ?>
                  </h5>
                </div>
                <div class="text-end col-xl-6 col-lg-6 col-md-6 col-12 mb-2">
                  <div class="tooltip1">
                    <img class="ms-1 pointer"
                      onclick="ControlVolumetrico(<?= $Session_IDEstacion; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)"
                      src="<?= RUTA_IMG_ICONOS; ?>control-volumetrico.png">
                    <div class="bottom">Control volumétrico</div>
                  </div>
                  <div class="tooltip1">
                    <img class="ms-1 pointer"
                      onclick="ConcentradoVentas(<?= $Session_IDEstacion; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)"
                      src="<?= RUTA_IMG_ICONOS; ?>concentrado-ventas.png">
                    <div class="bottom">Concentrado de Ventas</div>
                  </div>
                  <div class="tooltip1">
                    <img class="ms-1 pointer" onclick="ResumenImpuestos(<?= $GET_year; ?>,<?= $GET_mes; ?>)"
                      src="<?= RUTA_IMG_ICONOS; ?>impuestos.png">
                    <div class="bottom">Resumen Impuestos</div>
                  </div>
                  <div class="tooltip1">
                    <img class="ms-1 pointer" onclick="ResumenMonedero(<?= $GET_year; ?>,<?= $GET_mes; ?>)"
                      src="<?= RUTA_IMG_ICONOS; ?>monedero.png">
                    <div class="bottom">Resumen Monedero</div>
                  </div>
                  <div class="tooltip1">
                    <img class="ms-1 pointer" onclick="Aceites(<?= $GET_year; ?>,<?= $GET_mes; ?>)"
                      src="<?= RUTA_IMG_ICONOS; ?>aceite.png">
                    <div class="bottom">Resumen Aceites</div>
                  </div>
                  <div class="tooltip1">
                    <img class="ms-1 pointer" onclick="Clientes(<?= $GET_year; ?>,<?= $GET_mes; ?>)"
                      src="<?= RUTA_IMG_ICONOS; ?>clientes.png">
                    <div class="bottom">Resumen Clientes</div>
                  </div>
                  <div class="tooltip1">
                    <img class="ms-1 pointer" onclick="Embarques(<?= $GET_year; ?>,<?= $GET_mes; ?>)"
                      src="<?= RUTA_IMG_ICONOS; ?>embarque.png">
                    <div class="bottom">Resumen Embarques</div>
                  </div>
                </div>
              </div>
              <hr>
              <?php
              for ($Pdia = 1; $Pdia <= $Udia; $Pdia++) :
                $corteDiarioGeneral->validaFechaReporte($IdReporte, $GET_year, $GET_mes, $Pdia);
              endfor;
              ?>
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover mb-0">
                  <thead class="tables-bg">
                    <tr>
                      <th class="text-center">FECHA</th>
                      <th class="text-center" width="60px">VENTAS</th>
                      <th class="text-center" width="60px">TPV</th>
                      <th class="text-center" width="60px">IMPUESTOS</th>
                      <th class="text-center" width="60px">MONEDERO</th>
                      <th class="text-center" width="50px">CLIENTES</th>
                    </tr>
                  </thead>
                  <?php
                  $sql_listadia = "
                  SELECT 
                  op_corte_year.id_estacion,
                  op_corte_year.year,
                  op_corte_mes.mes,
                  op_corte_dia.id AS idDia,
                  op_corte_dia.fecha
                  FROM op_corte_year
                  INNER JOIN op_corte_mes ON op_corte_year.id = op_corte_mes.id_year
                  INNER JOIN op_corte_dia ON op_corte_mes.id = op_corte_dia.id_mes 
                  WHERE op_corte_year.id_estacion = '" . $Session_IDEstacion . "' AND 
                  op_corte_year.year = '" . $GET_year . "' AND 
                  op_corte_mes.mes = '" . $GET_mes . "' ORDER BY op_corte_dia.fecha ASC";
                  $result_listadia = mysqli_query($con, $sql_listadia);
                  $numero_listadia = mysqli_num_rows($result_listadia);

                  while ($row_listadia = mysqli_fetch_array($result_listadia, MYSQLI_ASSOC)) {
                    $idDias = $row_listadia['idDia'];
                    $fecha = $row_listadia['fecha'];

                    if (strtotime($fecha_del_dia) >= strtotime($fecha)) {
                      $text = "text-black font-weight-bold";
                      $img = "";
                    } else {
                      $text = "text-secondary";
                      $img = "grayscale";
                    }

                    echo "<tr>";
                    echo "<td class='align-middle " . $text . "'>" . FormatoFecha($fecha) . "</td>";

                    echo "<td class='align-middle text-center' onclick='ventas(" . $GET_year . "," . $GET_mes . "," . $idDias . ")'><img class='" . $img . " pointer' src='" . RUTA_IMG_ICONOS . "ventas.png' ></td>";
                    echo "<td class='align-middle text-center' onclick='cierrelote(" . $GET_year . "," . $GET_mes . "," . $idDias . ")'><img class='" . $img . " pointer' src='" . RUTA_IMG_ICONOS . "tpv.png' ></td>";

                    echo "<td class='align-middle text-center' onclick='impuestos(" . $GET_year . "," . $GET_mes . "," . $idDias . ")'><img class='" . $img . " pointer' src='" . RUTA_IMG_ICONOS . "impuestos.png' ></td>";

                    echo "<td class='align-middle text-center' onclick='monedero(" . $GET_year . "," . $GET_mes . "," . $idDias . ")'><img class='" . $img . " pointer' src='" . RUTA_IMG_ICONOS . "monedero.png' ></td>";

                    echo "<td class='align-middle text-center' onclick='clientes(" . $GET_year . "," . $GET_mes . "," . $idDias . ")'><img class='" . $img . " pointer' src='" . RUTA_IMG_ICONOS . "clientes.png' ></td>";
                    echo "</tr>";
                  }
                  ?>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>