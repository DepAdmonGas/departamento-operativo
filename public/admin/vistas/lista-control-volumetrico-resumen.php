<?php
require ('../../../app/help.php');
$IdReporte = $_GET['IdReporte'];
$GET_mes = $_GET['Mes'];


$sql_lista = "SELECT * FROM op_control_volumetrico_resumen WHERE id_mes = '" . $IdReporte . "' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);


while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)):
  $id = $row_lista['id'];
  $producto = $row_lista['producto'];
  $dato1 = $row_lista['dato1'];

  if ($row_lista['dato2'] == 0) {
    $dato2 = 0;
    $Diferencia1 = 0;

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

  if ($producto == "G SUPER") {
    $bgproducto = "bg-super";
    $CProduct0 = 'style="background-color: #76bd1d"'; 

  } else if ($producto == "G PREMIUM") {
    $bgproducto = "bg-premium";
    $CProduct0 = 'style="background-color: #e21683"'; 


  } else if ($producto == "G DIESEL") {
    $bgproducto = "bg-diesel";
    $CProduct0 = 'style="background-color: #000000"'; 


  }

  $Diferencia2 = $dato3 - $dato4;
  $Diferencia3 = $dato5 - $dato6;
  $Diferencia4 = $dato7 - $dato8;
  $Diferencia5 = $dato9 - $dato10;

  $Diferencia6 = $dato11 - $dato12;
  $Diferencia7 = $dato13 - $dato14;


  if (is_numeric($Diferencia1) and ($Diferencia1 >= 0)) {
    $color1 = "text-black";
  } else {
    $color1 = "text-danger";
  }

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

  if ($dato4 != 0) {
    $valP1 = ($dato3 * 100) / $dato4;
  } else {
    $valP1 = 0;
  }


  $valTotalP = $valP1 - 100;

  $ParametroP = number_format($valTotalP, 2);

  if ($ParametroP == "inf" || $ParametroP == "INF" || $ParametroP == "nan" || $ParametroP == "NaN" || $ParametroP == "Infinity") {
    $Parametrotb = number_format(0, 2);
  } else {
    $Parametrotb = $ParametroP;
  }


  if (is_numeric($Parametrotb) and ($Parametrotb >= 1.5)) {
    $color8 = "text-danger";
  } else {
    $color8 = "text-black";
  }

  ?>
  <div class="table-responsive mb-3">
    <table class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="title-table-bg">
    <tr>
          <th colspan="4" class="align-middle text-center" <?=$CProduct0?>> <?=$producto;?></th>
        </tr>
        <tr>
          <td></td>
          <th>Rep. Volumetrico</th>
          <th>Reg. Contables</th>
          <td class="no-hover fw-bold">Diferencias</td>
        </tr>
      </thead>
      <tbody class="bg-white">
        <tr>
          <th class="no-hover text-start">Inventario final</th>
          <td class="no-hover text-end p-0">
            <input type="number" id="1<?= $id; ?>" step="any" style="width: 100%; height: 100%;"
              class="text-end border-0 font-weight-light p-2" value="<?= $dato1; ?>"
              onkeyup="Edit(1,1,<?= $id; ?>,<?= $dato2; ?>,<?= $IdReporte; ?>,<?= $GET_mes; ?>)">
          </td>

          <td class="no-hover text-end p-0">
            <input type="number" id="2<?= $id; ?>" step="any" style="width: 100%;"
              class="text-end border-0 font-weight-light p-2" value="<?= $dato2; ?>"
              onkeyup="Edit(2,1,<?= $id; ?>,<?= $dato1; ?>,<?= $IdReporte; ?>,<?= $GET_mes; ?>)">
          </td>

          <td class="no-hover text-end <?= $color1; ?>" id="D1<?= $id; ?>"><?= number_format($Diferencia1, 2); ?></td>
        </tr>

        <!---------- COMPRAS L ---------->
        <tr>
          <th class="no-hover text-start">Compras L</th>

          <td class="no-hover text-end p-0">
            <input type="number" id="3<?= $id; ?>" step="any" style="width: 100%;"
              class="text-end border-0 font-weight-light p-2" value="<?= $dato3; ?>"
              onkeyup="Edit(3,2,<?= $id; ?>,<?= $dato4; ?>,<?= $IdReporte; ?>,<?= $GET_mes; ?>)">
          </td>

          <td id="RC<?= $id; ?>" class="text-end no-hover"><?= number_format($dato4, 2); ?></td>
          <td class="no-hover text-end <?= $color2; ?>" id="D2<?= $id; ?>"><?= number_format($Diferencia2, 2); ?></td>
        </tr>

        <tr>
          <th class="no-hover text-start">$</th>

          <td class="no-hover text-end p-0">
            $ <input type="number" id="5<?= $id; ?>" step="any" style="width: 90%;"
              class="text-end border-0 font-weight-light p-2" value="<?= $dato5; ?>"
              onkeyup="Edit(5,3,<?= $id; ?>,<?= $dato6; ?>,<?= $IdReporte; ?>,<?= $GET_mes; ?>)"></td>

          <td class="no-hover text-end">$ <?= number_format($dato6, 2); ?></td>

          
          <td class="no-hover text-end <?= $color3; ?>" id="D3<?= $id; ?>">$ <?= number_format($Diferencia3, 2); ?></td>
        </tr>

        <!---------- VENTAS L ---------->
        <tr>
          <th class="no-hover text-start">Ventas L</th>

          <td class="no-hover text-end p-0">
            <input type="number" id="7<?= $id; ?>" step="any" style="width: 100%;"
              class="text-end border-0 font-weight-light p-2" value="<?= $dato7; ?>"
              onkeyup="Edit(7,4,<?= $id; ?>,<?= $dato8; ?>,<?= $IdReporte; ?>,<?= $GET_mes; ?>)">
          </td>

          <td class="no-hover text-end"><?= number_format($dato8, 2); ?></td>
          <td class="no-hover text-end <?= $color4; ?>" id="D4<?= $id; ?>"><?= number_format($Diferencia4, 2); ?></td>
        </tr>

        <tr>
          <th class="no-hover text-start">$</th>

          <td class="no-hover text-end p-0">
            $ <input type="number" id="9<?= $id; ?>" step="any" style="width: 90%;"
              class="text-end border-0 font-weight-light p-2" value="<?= $dato9; ?>"
              onkeyup="Edit(9,5,<?= $id; ?>,<?= $dato10; ?>,<?= $IdReporte; ?>,<?= $GET_mes; ?>)"></td>

          <td class="no-hover text-end">$ <?= number_format($dato10, 2); ?></td>
          <td class="no-hover text-end <?= $color5; ?>" id="D5<?= $id; ?>">$ <?= number_format($Diferencia5, 2); ?></td>
        </tr>

        <!---------- DESPACHOS L ---------->
        <tr>
          <th class="no-hover text-start">Despachos L</th>
          <td class="no-hover text-end p-0">
            <input type="number" id="11<?= $id; ?>" step="any" style="width: 100%;"
              class="text-end border-0 font-weight-light p-2" value="<?= $dato11; ?>"
              onkeyup="Edit(11,6,<?= $id; ?>,<?= $dato12; ?>,<?= $IdReporte; ?>,<?= $GET_mes; ?>)">
          </td>
          <td class="no-hover text-end"><?= number_format($dato12, 2); ?></td>
          <td class="no-hover text-end <?= $color6; ?>" id="D6<?= $id; ?>"><?= number_format($Diferencia6, 2); ?></td>
        </tr>

        <tr>
          <th class="no-hover text-start">$</th>
          <td class="no-hover text-end p-0">
            $ <input type="number" id="13<?= $id; ?>" step="any" style="width: 90%;"
              class="text-end border-0 font-weight-light p-2" value="<?= $dato13; ?>"
              onkeyup="Edit(13,7,<?= $id; ?>,<?= $dato14; ?>,<?= $IdReporte; ?>,<?= $GET_mes; ?>)"></td>
          <td class="no-hover text-end">$ <?= number_format($dato14, 2); ?></td>
          <td class="no-hover text-end <?= $color7; ?>" id="D7<?= $id; ?>">$ <?= number_format($Diferencia7, 2); ?></td>

        </tr>

        <!---------- PARAMETROS ---------->
        <tr>
          <th colspan="2" class="text-center no-hover">Parametro 1.5%</t>
          <td colspan="2" class="text-center no-hover <?= $color8; ?>" id="D8<?= $id; ?>"><?= $Parametrotb ?></td>
        </tr>

      </tbody>
    </table>
  </div>


  <div class="col-12 mb-3">
  <div class="table-responsive">
  <table class="custom-table mt-2" style="font-size: 12.5px;" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">Comentarios</th> </tr>
  </thead>
  <tbody class="bg-white">
  <tr class="no-hover">
  <th class="align-middle text-center p-0">
  <textarea class="form-control rounded-0 border-0" placeholder="Escribe tu comentario aquí..." id="Comentario<?= $id; ?>" onkeyup="Comentario(<?= $id; ?>)" style="height: 135px;"><?= $comentario; ?></textarea>
  </th>
  </tr>
  </tbody>
  </table>
  </div>
  </div>


  <?php

endwhile;

$ResumenAceite = ResumenAceite($IdReporte, $con);
function ResumenAceite($IdReporte, $con)
{
  $sql = "SELECT * FROM op_control_volumetrico_resumen_aceites WHERE id_mes = '" . $IdReporte . "' ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

    $volumetrico = $row['volumetrico'];
  }

  return $volumetrico;
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
  while ($row_listaaceites = mysqli_fetch_array($result_listaaceites, MYSQLI_ASSOC)):
    $noaceite = $row_listaaceites['id_aceite'];
    $preciou = $row_listaaceites['precio'];
    $totalaceites = totalaceites($IdReporte, $noaceite, $con);

    $Total = $preciou * $totalaceites;
    $TotAceites = $TotAceites + $totalaceites;
    $Grantotal = $Grantotal + $Total;
  endwhile;

  $array = array('TotAceites' => $TotAceites, 'Grantotal' => $Grantotal);

  return $array;
}

$Aceites = Aceites($IdReporte, $con);
$diferenciaA = $ResumenAceite - $Aceites['Grantotal'];
?>

<div class="table-responsive mt-3">
    <table class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="title-table-bg">
    <tr>
          <th colspan="5" class="align-middle text-center tables-bg">ACEITES</th>
        </tr>
        <tr>
          <td></td>
          <th>Piezas</th>
          <th>Rep. Volumetrico</th>
          <th>Reg. Contables</th>
          <td class="fw-bold">Diferencias</td>
        </tr>
      </thead>
      <tbody class="bg-white">
        <tr>
          <th class="no-hover">Ventas</th>
          <td class="no-hover"><?= $Aceites['TotAceites']; ?></td>
          <td class="no-hover text-end p-0">
            <input type="number" id="Aceites" step="any" style="width: 100%;"
              class="text-end border-0 font-weight-light p-2" value="<?= $ResumenAceite; ?>"
              onkeyup="EditAceites(this,<?= $IdReporte; ?>,<?= $GET_mes; ?>)">
          </td>
          <td class="no-hover text-end">$ <?= number_format($Aceites['Grantotal'], 2); ?></td>
          <td class="no-hover text-end">$ <?= number_format($diferenciaA, 2); ?></td>
        </tr>
      </tbody>
  </table>
</div>