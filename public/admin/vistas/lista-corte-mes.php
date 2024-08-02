<?php
require ('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];
$GET_year = $_GET['year'];
$GET_mes = $_GET['mes'];


$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '" . $idEstacion . "' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)) {
  $estacion = $row_listaestacion['nombre'];
}


function ToActivar($IdReporte, $con)
{
  $sql_lista = "SELECT id FROM op_corte_dia_hist WHERE id_corte = '" . $IdReporte . "' ";
  $result_lista = mysqli_query($con, $sql_lista);
  return $numero_lista = mysqli_num_rows($result_lista);

}


function IdReporte($GET_idEstacion, $GET_year, $GET_mes, $con)
{
  $idmes = 0;
  $sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '" . $GET_idEstacion . "' AND year = '" . $GET_year . "' ";
  $result_year = mysqli_query($con, $sql_year);
  while ($row_year = mysqli_fetch_array($result_year, MYSQLI_ASSOC)) {
    $idyear = $row_year['id'];
  }

  $sql_mes = "SELECT id, id_year, mes FROM op_corte_mes WHERE id_year = '" . $idyear . "' AND mes = '" . $GET_mes . "' ";
  $result_mes = mysqli_query($con, $sql_mes);
  while ($row_mes = mysqli_fetch_array($result_mes, MYSQLI_ASSOC)) {
    $idmes = $row_mes['id'];
  }

  return $idmes;
}

$IdReporte = IdReporte($idEstacion, $GET_year, $GET_mes, $con);
?>


<script type="text/javascript">
  $(document).ready(function ($) {

    if (sessionStorage) {
      if (sessionStorage.getItem('scrollTop') !== undefined && sessionStorage.getItem('scrollTop')) {

        scrollTop = sessionStorage.getItem('scrollTop');

        if (sessionStorage.getItem('scrollTop') != 0) {


          $('html, body').animate({
            scrollTop: $("#id-" + scrollTop).offset().top
          }, 0);

        }

        $("#id-" + scrollTop).css("background-color", "#E2FFEA");

      }
    }


  });

</script>

<div class="row">
  <div class="col-12">
    <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
      <ol class="breadcrumb breadcrumb-caret">
        <li class="breadcrumb-item"><a onclick="history.go(-3)" class="text-uppercase text-primary pointer"><i
              class="fa-solid fa-house"></i> Corporativo</a></li>
        <li class="breadcrumb-item"><a onclick="history.go(-2)" class="text-uppercase text-primary pointer"> Corte Diario</a></li>
        <li class="breadcrumb-item"><a onclick="history.go(-1)" class="text-uppercase text-primary pointer">
            <?= $GET_year ?></a></li>
        <li aria-current="page" class="breadcrumb-item active text-uppercase">
          <?= $ClassHerramientasDptoOperativo->nombremes($GET_mes) ?>
        </li>
      </ol>
    </div>
    <div class="row">
      <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12">
        <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
          Corte Diario (<?= $estacion; ?>), <?= $ClassHerramientasDptoOperativo->nombremes($GET_mes); ?>
          <?= $GET_year; ?>
        </h3>
      </div>


      <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12">
        <div class="text-end">
          <div class="dropdown d-inline ms-2">
            <button type="button" class="btn dropdown-toggle btn-primary" id="dropdownMenuButton1"
              data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-solid fa-screwdriver-wrench"></i> </button>

            <ul class="dropdown-menu">
              <li onclick="ControlVolumetrico(<?= $idEstacion; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)">
                <a class="dropdown-item pointer"><i class="fa-solid fa-bottle-droplet"></i> Control
                  volumetrico</a>
              </li>

              <li onclick="ResumenMonedero(<?= $idEstacion; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)">
                <a class="dropdown-item pointer"><i class="fa-solid fa-money-bill-trend-up"></i> Resumen
                  monedero</a>
              </li>

              <li onclick="Clientes(<?= $idEstacion; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)">
                <a class="dropdown-item pointer"><i class="fa-solid fa-users"></i> Resumen clientes</a>
              </li>

              <li onclick="ConcentradoVentas(<?= $idEstacion; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)">
                <a class="dropdown-item pointer"><i class="fa-solid fa-cash-register"></i> Concentrado de
                  ventas</a>
              </li>

              <li onclick="Aceites(<?= $idEstacion; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)">
                <a class="dropdown-item pointer"><i class="fa-solid fa-oil-can"></i> Resumen aceites</a>
              </li>
              <?php
              if ($session_nompuesto == "Dirección de operaciones") {
                ?>
                <li onclick="AperturaCorteKPI(<?= $idEstacion; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)">
                  <a class="dropdown-item pointer"><i class="fa-solid  fa-truck-droplet"></i> Apertura de Cortes Diarios
                    (KPI's)</a>
                </li>
                <?php
              }
              ?>
            </ul>
          </div>

        </div>
      </div>
    </div>

  </div>
</div>

<hr>


<div class="table-responsive">
  <table class="custom-table " style="font-size: 1em;" width="100%">
    <thead class="tables-bg">
      <tr>
        <th class="text-center">FECHA</th>
        <th class="text-center" width="60px">VENTAS</th>
        <th class="text-center" width="60px">TPV</th>
        <th class="text-center" width="60px">IMPUESTOS</th>
        <th class="text-center" width="60px">MONEDERO</th>
        <th class="text-center" width="60px">CLIENTES</th>
        <th class="text-center" width="60px">EDITAR</th>
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
          op_corte_dia.fecha,
          op_corte_dia.ventas,
          op_corte_dia.tpv,
          op_corte_dia.monedero
          FROM op_corte_year
          INNER JOIN op_corte_mes ON op_corte_year.id = op_corte_mes.id_year
          INNER JOIN op_corte_dia ON op_corte_mes.id = op_corte_dia.id_mes 
          WHERE op_corte_year.id_estacion = '" . $idEstacion . "' AND 
          op_corte_year.year = '" . $GET_year . "' AND 
          op_corte_mes.mes = '" . $GET_mes . "'";
      $result_listadia = mysqli_query($con, $sql_listadia);
      $numero_listadia = mysqli_num_rows($result_listadia);

      while ($row_listadia = mysqli_fetch_array($result_listadia, MYSQLI_ASSOC)) {
        $idDias = $row_listadia['idDia'];
        $fecha = $row_listadia['fecha'];
        $text = "text-secondary";
        $img = "grayscale";

        if (strtotime($fecha_del_dia) >= strtotime($fecha)) {
          $text = "text-black font-weight-bold";
          $img = "";

          $trColor = "";
          if ($row_listadia['ventas'] == 0) {
            $trColor = "background-color: #fcfcda";
          }

        }

        $ToActivar = ToActivar($idDias, $con);
        $Nuevo = '';
        if ($ToActivar > 0) {
          $Nuevo = '<div class="position-absolute" style="margin-bottom: -15px; right: 2px;"><span class="badge bg-danger text-white rounded-circle"><span class="fw-bold" style="font-size: 10px;">'.$ToActivar.' </span></span></div>';
          //$Nuevo = '<div class="float-end" style="margin-bottom: -5px"><span class="badge bg-danger text-white rounded-circle"><small>' . $ToActivar . '</small></span></div>';
        }

        echo "<tr style='" . $trColor . "' id='id-" . $idDias . "'>";
        echo "<th class='text-start " . $text . "'>" . FormatoFecha($fecha) . "</th>";
        echo "<td class='align-middle text-center' onclick='ventas(" . $GET_year . "," . $GET_mes . "," . $idDias . ")'><img class='pointer '" . $img . "'' src='" . RUTA_IMG_ICONOS . "ventas.png' ></td>";
        echo "<td class='align-middle text-center' onclick='cierrelote(" . $GET_year . "," . $GET_mes . "," . $idDias . ")'><img class='pointer '" . $img . "'' src='" . RUTA_IMG_ICONOS . "tpv.png' ></td>";

        echo "<td class='align-middle text-center' onclick='impuestos(" . $GET_year . "," . $GET_mes . "," . $idDias . ")'><img class='pointer '" . $img . "'' src='" . RUTA_IMG_ICONOS . "impuestos.png' ></td>";

        echo "<td class='align-middle text-center' onclick='monedero(" . $GET_year . "," . $GET_mes . "," . $idDias . ")'><img class='pointer '" . $img . "'' src='" . RUTA_IMG_ICONOS . "monedero.png' ></td>";

        echo "<td class='align-middle text-center' onclick='clientes(" . $GET_year . "," . $GET_mes . "," . $idDias . ")'><img class='pointer '" . $img . "'' src='" . RUTA_IMG_ICONOS . "clientes.png' ></td>";
        echo '<td class="align-middle text-center position-relative" onclick="editar(' . $idEstacion . ', ' . $GET_year . ', ' . $GET_mes . ', ' . $idDias . ')">' . $Nuevo . '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'icon-lapiz.png" data-toggle="tooltip" data-placement="top" title="Abrir Corte"></td>';

        //echo "<td class='align-middle text-center' onclick='editar(" . $idEstacion . "," . $GET_year . "," . $GET_mes . "," . $idDias . ")'>" . $Nuevo . "<img class='pointer '" . $img . "'' src='" . RUTA_IMG_ICONOS . "icon-lapiz.png' ></td>";
        echo "</tr>";
      }

      ?>
    </tbody>
  </table>
</div>