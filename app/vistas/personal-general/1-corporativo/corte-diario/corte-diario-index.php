<?php
require 'app/vistas/contenido/header.php';
$breadcrumbYearMes = $ClassHomeCorporativo->tituloMenuCorporativoYearMes($Pagina, $Session_IDUsuarioBD, $session_idpuesto, $GET_year, $GET_mes);
$IdReporte = $corteDiarioGeneral->idReporte($Session_IDEstacion, $GET_year, $GET_mes);
$Pdia = $corteDiarioGeneral->primerDia($GET_year, $GET_mes);
$Udia = $corteDiarioGeneral->ultimoDia($GET_year, $GET_mes);

$Tovalefectivale = 0;
$Tovalaccord = 0;
$ocultartb2 = "";
$ocultartbAcord = "";
$ocultartbEfectivale = "";

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
op_corte_mes.mes = '" . $GET_mes . "'";

$result_listadia = mysqli_query($con, $sql_listadia);
$numero_listadia = mysqli_num_rows($result_listadia);

while ($row_listadia = mysqli_fetch_array($result_listadia, MYSQLI_ASSOC)) {
$idDias = $row_listadia['idDia'];
$fecha = $row_listadia['fecha'];

$valaccord = TarjetasCB($idDias, "VALE ACCORD", $con);
$valefectivale = TarjetasCB($idDias, "VALE EFECTIVALE", $con);

$Tovalaccord = $Tovalaccord + $valaccord;
$Tovalefectivale = $Tovalefectivale + $valefectivale;
}


if($Tovalaccord == 0 && $Tovalefectivale == 0){
  $ocultartb2 = "d-none";
  
  }else{
  
  if($Tovalaccord == 0){
  $ocultartbAcord = "d-none";
  }
  
  if($Tovalefectivale == 0){
  $ocultartbEfectivale = "d-none";
  }
  
  }

function TarjetasCB($idReporte, $concepto, $con){
$sql_cb = "SELECT * FROM op_tarjetas_c_b WHERE idreporte_dia = '" . $idReporte . "' AND concepto = '" . $concepto . "' LIMIT 1 ";
$result_cb = mysqli_query($con, $sql_cb);
$baucher = 0;
while ($row_cb = mysqli_fetch_array($result_cb, MYSQLI_ASSOC)) {
$baucher = $row_cb['baucher'];
}
return $baucher;
}



?>
<script type="text/javascript" src="<?php echo RUTA_CORTEDIARIO_JS ?>corte-diario-mes-function.js"></script>

<script>
  $(document).ready(function ($) {
    $(".LoaderPage").fadeOut("slow");

  });

  function menuCorporativoYearMes(referencia) {
    window.location.href = "../../" + referencia;
  }

  function returnCorporativoItem(referencia) {
    window.location.href = "../../" + referencia;
  }
</script>

<body>
  <div class="LoaderPage"></div>

  <!---------- DIV - CONTENIDO ---------->
  <div id="content">
    <!---------- NAV BAR - PRINCIPAL (TOP) ---------->
    <?php include_once "public/navbar/navbar-perfil.php"; ?>
    <!---------- CONTENIDO PAGINA WEB---------->
    <div class="contendAG">
      <div class="row">
        <div class="col-12">
          <div class="row">
            <div class="col-12">

              <?= $breadcrumbYearMes ?>

              <div class="row">
                <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12">
                  <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                    Corte Diario, <?= $ClassHerramientasDptoOperativo->nombremes($GET_mes); ?> <?= $GET_year; ?>
                  </h3>
                </div>

                <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12">
                  <div class="text-end">
                    <div class="dropdown d-inline ms-2">
                      <button type="button" class="btn dropdown-toggle btn-primary" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-screwdriver-wrench"></i> </button>

                      <ul class="dropdown-menu">
                        <li
                          onclick="ControlVolumetrico(<?= $Session_IDEstacion; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)">
                          <a class="dropdown-item pointer"><i class="fa-solid fa-bottle-droplet"></i> Control
                            volumetrico</a>
                        </li>

                        <li onclick="ConcentradoVentas(<?= $Session_IDEstacion; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)">
                          <a class="dropdown-item pointer"><i class="fa-solid fa-cash-register"></i> Concentrado de
                            ventas</a>
                        </li>

                        <li onclick="ResumenImpuestos(<?= $GET_year; ?>,<?= $GET_mes; ?>)">
                          <a class="dropdown-item pointer"><i class="fa-solid fa-hand-holding-dollar"></i> Resumen
                            impuestos</a>
                        </li>

                        <li onclick="ResumenMonedero(<?= $GET_year; ?>,<?= $GET_mes; ?>)">
                          <a class="dropdown-item pointer"><i class="fa-solid fa-money-bill-trend-up"></i> Resumen
                            monedero</a>
                        </li>

                        <li onclick="Aceites(<?= $GET_year; ?>,<?= $GET_mes; ?>)">
                          <a class="dropdown-item pointer"><i class="fa-solid fa-oil-can"></i> Resumen aceites</a>
                        </li>

                        <li onclick="Clientes(<?= $GET_year; ?>,<?= $GET_mes; ?>)">
                          <a class="dropdown-item pointer"><i class="fa-solid fa-users"></i> Resumen clientes</a>
                        </li>

                        <li onclick="Embarques(<?= $GET_year; ?>,<?= $GET_mes; ?>)">
                          <a class="dropdown-item pointer"><i class="fa-solid  fa-truck-droplet"></i> Resumen
                            embarques</a>
                        </li>

                      </ul>
                    </div>

                  </div>
                </div>
              </div>
              <hr>
            </div>


<div class="col-12">
<?php
          for ($Pdia = 1; $Pdia <= $Udia; $Pdia++):
            $corteDiarioGeneral->validaFechaReporte($IdReporte, $GET_year, $GET_mes, $Pdia);
          endfor;
          ?>
          <div class="table-responsive">
            <table class="custom-table " style="font-size: 1em;" width="100%">
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
              <tbody class="bg-white">


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
                  echo "<th class='text-start fw-normal " . $text . "'>" . $ClassHerramientasDptoOperativo->FormatoFecha($fecha) . "</th>";

                  echo "<td class='align-middle text-center' onclick='ventas(" . $GET_year . "," . $GET_mes . "," . $idDias . ")'><img class='" . $img . " pointer' src='" . RUTA_IMG_ICONOS . "ventas.png' ></td>";
                  echo "<td class='align-middle text-center' onclick='cierrelote(" . $GET_year . "," . $GET_mes . "," . $idDias . ")'><img class='" . $img . " pointer' src='" . RUTA_IMG_ICONOS . "tpv.png' ></td>";

                  echo "<td class='align-middle text-center' onclick='impuestos(" . $GET_year . "," . $GET_mes . "," . $idDias . ")'><img class='" . $img . " pointer' src='" . RUTA_IMG_ICONOS . "impuestos.png' ></td>";

                  echo "<td class='align-middle text-center' onclick='monedero(" . $GET_year . "," . $GET_mes . "," . $idDias . ")'><img class='" . $img . " pointer' src='" . RUTA_IMG_ICONOS . "monedero.png' ></td>";

                  echo "<td class='align-middle text-center' onclick='clientes(" . $GET_year . "," . $GET_mes . "," . $idDias . ")'><img class='" . $img . " pointer' src='" . RUTA_IMG_ICONOS . "clientes.png' ></td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
</div>



<div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 <?=$ocultartb2?>">
  <div class="table-responsive">
  <table id="tabla_2" class="custom-table" style="font-size: .8em;" width="100%">
  <thead class="title-table-bg">
  <tr class="tables-bg">
  <th class="text-center align-middle fw-bold" colspan="2">IMPORTE MENSUAL</th>
  </tr>
  <tr>
  <td class="fw-bold">CONCEPTO/BANCO</td>
  <td class="fw-bold">IMPORTE TOTAL</td>
  </tr>
  </thead>
  <tbody class="bg-white">
  <tr>
  <th class="align-middle text-center <?=$ocultartbAcord?>" style="font-size: .9em;" >VALE ACCORD</th>
  <td class="align-middle text-center <?=$ocultartbAcord?>" style="font-size: .9em;" >$<?= number_format($Tovalaccord, 2); ?></td>
  </tr>

  <tr>
  <th class="align-middle text-center <?=$ocultartbEfectivale?>" style="font-size: .9em;">VALE EFECTIVALE</th>
  <td class="align-middle text-center <?=$ocultartbEfectivale?>" style="font-size: .9em;">$<?= number_format($Tovalefectivale, 2); ?></td>
  </tr>

  </tbody>
  </table>
  </div>

  </div>


          </div>






          
        </div>
      </div>
    </div>

    <!---------- FUNCIONES - NAVBAR ---------->
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</body>

</html>