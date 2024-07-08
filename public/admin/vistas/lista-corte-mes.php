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

<style type="text/css">
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


<div class="border-0 p-3">

  <div class="row">

    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-0">

      <h5><?= $estacion; ?></h5>

    </div>


    <div class="text-end col-xl-7 col-lg-7 col-md-12 col-12 mb-0">



      <div class="tooltip1">
        <img class="ms-1 mb-2 pointer" onclick="ControlVolumetrico(<?= $idEstacion; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)"
          src="<?= RUTA_IMG_ICONOS; ?>control-volumetrico.png">
        <div class="bottom">Control volumétrico</div>
      </div>

      <div class="tooltip1">
        <img class="ms-1 mb-2 pointer" onclick="ResumenMonedero(<?= $idEstacion; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)"
          src="<?= RUTA_IMG_ICONOS; ?>monedero.png">
        <div class="bottom">Resumen Monedero</div>
      </div>

      <div class="tooltip1">
        <img class="ms-1 mb-2 pointer" onclick="Clientes(<?= $idEstacion; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)"
          src="<?= RUTA_IMG_ICONOS; ?>clientes.png">
        <div class="bottom">Clientes</div>
      </div>

      <div class="tooltip1">
        <img class="ms-1 mb-2 pointer" onclick="ConcentradoVentas(<?= $idEstacion; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)"
          src="<?= RUTA_IMG_ICONOS; ?>concentrado-ventas.png">
        <div class="bottom">Concentrado de Ventas</div>
      </div>

      <!--
<div class="tooltip1">
<img class="ms-1 mb-2 pointer" onclick="FacTelcel(<?= $idEstacion; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)" src="<?= RUTA_IMG_ICONOS; ?>telefono.png">
  <div class="bottom">Facturas Telcel</div>
</div>

<div class="tooltip1">
<img class="ms-1 mb-2 pointer" width="32px" onclick="Servicios(<?= $IdReporte; ?>)" src="<?= RUTA_IMG_ICONOS; ?>servicios.png">
  <div class="bottom">Pago de servicio</div>
</div>


<div class="tooltip1">
<img class="ms-1 mb-2 pointer" onclick="ResumenImpuestos(<?= $idEstacion; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)" src="<?= RUTA_IMG_ICONOS; ?>impuestos.png">
  <div class="bottom">Resumen Impuestos</div>
</div>
-->

      <div class="tooltip1">
        <img class="ms-1 mb-2 pointer" onclick="Aceites(<?= $idEstacion; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)"
          src="<?= RUTA_IMG_ICONOS; ?>aceite.png">
        <div class="bottom">Aceites</div>
      </div>

      <?php
      if ($session_nompuesto == "Dirección de operaciones") {
        ?>

        <div class="tooltip1">
          <img class="ms-1 mb-2 pointer" onclick="AperturaCorteKPI(<?= $idEstacion; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)"
            src="<?= RUTA_IMG_ICONOS; ?>grafico.png">
          <div class="bottom">Apertura de Cortes Diarios (KPI's) </div>
        </div>

        <?php
      }
      ?>

    </div>
  </div>

  <hr>


  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover mb-0 pb-0" style="font-size: .92em">
      <thead>
        <tr class="tables-bg">
          <th class="text-center">FECHA</th>
          <th class="text-center" width="60px">VENTAS</th>
          <th class="text-center" width="60px">TPV</th>
          <th class="text-center" width="60px">IMPUESTOS</th>
          <th class="text-center" width="60px">MONEDERO</th>
          <th class="text-center" width="60px">CLIENTES</th>
          <th class="text-center" width="60px">EDITAR</th>
        </tr>
      </thead>
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


        if (strtotime($fecha_del_dia) >= strtotime($fecha)) {
          $text = "text-black font-weight-bold";
          $img = "";

          if ($row_listadia['ventas'] == 0) {
            $trColor = "table-warning";
          } else {
            $trColor = "";
          }

        } else {
          $trColor = "";
          $text = "text-secondary";
          $img = "grayscale";
        }

        $ToActivar = ToActivar($idDias, $con);

        if ($ToActivar > 0) {
          $Nuevo = '<div class="float-end" style="margin-bottom: -5px"><span class="badge bg-danger text-white rounded-circle"><small>' . $ToActivar . '</small></span></div>';
        } else {
          $Nuevo = '';
        }

        echo "<tr class='" . $trColor . "' id='id-" . $idDias . "'>";
        echo "<td class='align-middle " . $text . "'>" . FormatoFecha($fecha) . "</td>";
        echo "<td class='align-middle text-center' onclick='ventas(" . $GET_year . "," . $GET_mes . "," . $idDias . ")'><img class='pointer '" . $img . "'' src='" . RUTA_IMG_ICONOS . "ventas.png' ></td>";
        echo "<td class='align-middle text-center' onclick='cierrelote(" . $GET_year . "," . $GET_mes . "," . $idDias . ")'><img class='pointer '" . $img . "'' src='" . RUTA_IMG_ICONOS . "tpv.png' ></td>";

        echo "<td class='align-middle text-center' onclick='impuestos(" . $GET_year . "," . $GET_mes . "," . $idDias . ")'><img class='pointer '" . $img . "'' src='" . RUTA_IMG_ICONOS . "impuestos.png' ></td>";

        echo "<td class='align-middle text-center' onclick='monedero(" . $GET_year . "," . $GET_mes . "," . $idDias . ")'><img class='pointer '" . $img . "'' src='" . RUTA_IMG_ICONOS . "monedero.png' ></td>";

        echo "<td class='align-middle text-center' onclick='clientes(" . $GET_year . "," . $GET_mes . "," . $idDias . ")'><img class='pointer '" . $img . "'' src='" . RUTA_IMG_ICONOS . "clientes.png' ></td>";

        echo "<td class='align-middle text-center' onclick='editar(" . $idEstacion . "," . $GET_year . "," . $GET_mes . "," . $idDias . ")'>" . $Nuevo . "<img class='pointer '" . $img . "'' src='" . RUTA_IMG_ICONOS . "icon-lapiz.png' ></td>";
        echo "</tr>";
      }

      ?>
    </table>
  </div>




</div>