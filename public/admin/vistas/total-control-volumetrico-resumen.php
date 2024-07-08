<?php
require ('../../../app/help.php');
$IdReporte = $_GET['IdReporte'];
$GET_mes = $_GET['Mes'];


$sql_lista = "SELECT * FROM op_control_volumetrico_resumen WHERE id_mes = '" . $IdReporte . "' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
$GTdato3 = 0;
$GTdato4 = 0;
$GTdato5 = 0;
$GTdato6 = 0;
$GTdato7 = 0;
$GTdato8 = 0;
$GTdato9 = 0;
$GTdato10 = 0;

$GTdato11 = 0;
$GTdato12 = 0;
$GTdato13 = 0;
$GTdato14 = 0;
while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
  $id = $row_lista['id'];
  $producto = $row_lista['producto'];

  $dato1 = $row_lista['dato1'];

  if ($row_lista['dato2'] == 0) {
    $dato2 = "";
    $Diferencia1 = "";
  } else {
    $dato2 = $row_lista['dato2'];
    $Diferencia1 = $dato1 - $dato2;
  }

  $dato3 = $row_lista['dato3'];
  $dato4 = $row_lista['dato4'];
  $dato5 = $row_lista['dato5'];
  $dato6 = $row_lista['dato6'];
  $dato7 = $row_lista['dato7'];
  $dato8 = $row_lista['dato8'];
  $dato9 = $row_lista['dato9'];
  $dato10 = $row_lista['dato10'];

  $dato11 = $row_lista['dato11'];
  $dato12 = $row_lista['dato12'];
  $dato13 = $row_lista['dato13'];
  $dato14 = $row_lista['dato14'];

  $comentario = $row_lista['comentario'];

  $GTdato3 = $GTdato3 + $dato3;
  $GTdato4 = $GTdato4 + $dato4;
  $GTdato5 = $GTdato5 + $dato5;
  $GTdato6 = $GTdato6 + $dato6;
  $GTdato7 = $GTdato7 + $dato7;
  $GTdato8 = $GTdato8 + $dato8;
  $GTdato9 = $GTdato9 + $dato9;
  $GTdato10 = $GTdato10 + $dato10;

  $GTdato11 = $GTdato11 + $dato11;
  $GTdato12 = $GTdato12 + $dato12;
  $GTdato13 = $GTdato13 + $dato13;
  $GTdato14 = $GTdato14 + $dato14;


  $Diferencia2 = $GTdato3 - $GTdato4;
  $Diferencia3 = $GTdato5 - $GTdato6;
  $Diferencia4 = $GTdato7 - $GTdato8;
  $Diferencia5 = $GTdato9 - $GTdato10;

  $Diferencia6 = $GTdato11 - $GTdato12;
  $Diferencia7 = $GTdato13 - $GTdato14;

  if (is_numeric($Diferencia2) and ($Diferencia2 >= 0)) {
    $color2 = "text-black";
  } else {
    $color2 = "text-danger";
  }

  if (is_numeric($Diferencia3) and ($Diferencia3 >= 0)) {
    $color3 = "text-black";
  } else {
    $color3 = "text-danger";
  }

  if (is_numeric($Diferencia4) and ($Diferencia4 >= 0)) {
    $color4 = "text-black";
  } else {
    $color4 = "text-danger";
  }

  if (is_numeric($Diferencia5) and ($Diferencia5 >= 0)) {
    $color5 = "text-black";
  } else {
    $color5 = "text-danger";
  }

  if (is_numeric($Diferencia6) and ($Diferencia6 >= 0)) {
    $color6 = "text-black";
  } else {
    $color6 = "text-danger";
  }

  if (is_numeric($Diferencia7) and ($Diferencia7 >= 0)) {
    $color7 = "text-black";
  } else {
    $color7 = "text-danger";
  }




}





function totalaceites($IdReporte, $noaceite, $con)
{

  $sql_listaaceite = "SELECT * FROM op_corte_dia WHERE id_mes = '" . $IdReporte . "' ";
  $result_listaaceite = mysqli_query($con, $sql_listaaceite);
  $cantidad = 0;
  while ($row_listaaceite = mysqli_fetch_array($result_listaaceite, MYSQLI_ASSOC)):
    $id = $row_listaaceite['id'];
    $sql_listatotal = "SELECT * FROM op_aceites_lubricantes WHERE idreporte_dia = '" . $id . "' AND id_aceite = '" . $noaceite . "' LIMIT 1 ";
    $result_listatotal = mysqli_query($con, $sql_listatotal);
    while ($row_listatotal = mysqli_fetch_array($result_listatotal, MYSQLI_ASSOC)):
      $cantidad = $cantidad + $row_listatotal['cantidad'];
    endwhile;
  endwhile;

  return $cantidad;

}

function Aceites($IdReporte, $con)
{

  $sql_listaaceites = "SELECT * FROM op_aceites_lubricantes_reporte WHERE id_mes = '" . $IdReporte . "' ";
  $result_listaaceites = mysqli_query($con, $sql_listaaceites);
  $TotAceites = 0;
  $Grantotal = 0;
  while ($row_listaaceites = mysqli_fetch_array($result_listaaceites, MYSQLI_ASSOC)) {
    $noaceite = $row_listaaceites['id_aceite'];
    $preciou = $row_listaaceites['precio'];
    $totalaceites = totalaceites($IdReporte, $noaceite, $con);

    $Total = $preciou * $totalaceites;
    $TotAceites = $TotAceites + $totalaceites;
    $Grantotal = $Grantotal + $Total;
  }

  $array = array('TotAceites' => $TotAceites, 'Grantotal' => $Grantotal);

  return $array;
}

$Aceites = Aceites($IdReporte, $con);
$ResumenAceite = $Aceites['Grantotal'];

$GRANTOTAL = $GTdato10 + $ResumenAceite;

?>

<div class="table-responsive mt-3">
  <table class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="navbar-bg">
      <tr>
        <th colspan="5" class="align-middle text-center tables-bg">GRAN TOTAL</th>
      </tr>
      <tr>
        <td></td>
        <th>Rep. Volumetrico</th>
        <th>Reg. Contables</th>
        <td class="fw-bold">Diferencias</td>
      </tr>
    </thead>
    <tbody class="bg-white">
      <!----- COMPRAS ----->
      <tr>
        <th class="text-start">Compras L</th>
        <td class="text-end font-weight-bold">
          <?= number_format($GTdato3); ?>
        </td>
        <td class="text-end font-weight-bold">
          <?= number_format($GTdato4); ?>
        </td>
        <td class="text-end <?= $color2; ?>" id="D2<?= $id; ?>">
          <?= number_format($Diferencia2, 2); ?>
        </td>
      </tr>
      <tr>
        <th class="text-start">$</th>
        <td class="text-end font-weight-bold">$
          <?= number_format($GTdato5, 2); ?>
        </td>
        <td class="text-end font-weight-bold">$
          <?= number_format($GTdato6, 2); ?>
        </td>
        <td class="text-end <?= $color3; ?>" id="D2<?= $id; ?>">$
          <?= number_format($Diferencia3, 2); ?>
        </td>

      </tr>

      <!----- VENTAS ----->
      <tr>
        <th class="text-start">Ventas L</th>
        <td class="text-end font-weight-bold">
          <?= number_format($GTdato7); ?>
        </td>
        <td class="text-end font-weight-bold">
          <?= number_format($GTdato8); ?>
        </td>
        <td class="text-end <?= $color4; ?>" id="D2<?= $id; ?>">
          <?= number_format($Diferencia4, 2); ?>
        </td>

      </tr>
      <tr>
        <th class="text-start">$</th>
        <td class="text-end font-weight-bold">$
          <?= number_format($GTdato9, 2); ?>
        </td>
        <td class="text-end font-weight-bold">$
          <?= number_format($GTdato10, 2); ?>
        </td>
        <td class="text-end <?= $color5; ?>" id="D2<?= $id; ?>">$
          <?= number_format($Diferencia5, 2); ?>
        </td>

      </tr>

      <!----- DESPACHOS ----->
      <tr>
        <th class="text-start">Despachos L</th>
        <td class="text-end font-weight-bold">
          <?= number_format($GTdato11); ?>
        </td>
        <td class="text-end font-weight-bold">
          <?= number_format($GTdato12); ?>
        </td>
        <td class="text-end <?= $color6; ?>" id="D2<?= $id; ?>">
          <?= number_format($Diferencia6, 2); ?>
        </td>

      </tr>
      <tr>
        <th class="text-start">$</th>
        <td class="text-end font-weight-bold">$
          <?= number_format($GTdato13, 2); ?>
        </td>
        <td class="text-end font-weight-bold">$
          <?= number_format($GTdato14, 2); ?>
        </td>
        <td class="text-end <?= $color7; ?>" id="D2<?= $id; ?>">$
          <?= number_format($Diferencia7, 2); ?>
        </td>

      </tr>
    </tbody>
  </table>
</div>