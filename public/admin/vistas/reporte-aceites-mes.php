<?php
require ('../../../app/help.php');

$IDEstacion = $_GET['idEstacion'];
$GET_year = $_GET['year'];
$GET_mes = $_GET['mes'];

function IdReporte($Session_IDEstacion, $GET_year, $GET_mes, $con)
{
  $sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '" . $Session_IDEstacion . "' AND year = '" . $GET_year . "' ";
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

$IdReporte = IdReporte($IDEstacion, $GET_year, $GET_mes, $con);

function ultimodia($year, $mes)
{
  $month = $mes;
  $day = date("d", mktime(0, 0, 0, $month + 1, 0, $year));
  return date('d', mktime(0, 0, 0, $month, $day, $year));
}
;


function primerdia($year, $mes)
{
  $month = $mes;
  return date('d', mktime(0, 0, 0, $month, 1, $year));
}

$Pdia = primerdia($GET_year, $GET_mes);
$Udia = ultimodia($GET_year, $GET_mes);

function cantidadaceites($IdReporte, $fecha, $noaceite, $con)
{
  $cantidad = 0;
  $sql_listaaceite = "SELECT id FROM op_corte_dia WHERE id_mes = '" . $IdReporte . "' AND fecha = '" . $fecha . "' LIMIT 1 ";
  $result_listaaceite = mysqli_query($con, $sql_listaaceite);
  while ($row_listaaceite = mysqli_fetch_array($result_listaaceite, MYSQLI_ASSOC)) {
    $id = $row_listaaceite['id'];
  }


  $sql_listatotal = "SELECT cantidad FROM op_aceites_lubricantes WHERE idreporte_dia = '" . $id . "' AND id_aceite = '" . $noaceite . "' LIMIT 1 ";
  $result_listatotal = mysqli_query($con, $sql_listatotal);
  while ($row_listatotal = mysqli_fetch_array($result_listatotal, MYSQLI_ASSOC)) {
    $cantidad = $row_listatotal['cantidad'];
  }

  return $cantidad;

}

function totalaceites($IdReporte, $noaceite, $con)
{
  $cantidad = 0;
  $sql_listaaceite = "SELECT * FROM op_corte_dia WHERE id_mes = '" . $IdReporte . "' ";
  $result_listaaceite = mysqli_query($con, $sql_listaaceite);
  while ($row_listaaceite = mysqli_fetch_array($result_listaaceite, MYSQLI_ASSOC)) {
    $id = $row_listaaceite['id'];

    $sql_listatotal = "SELECT * FROM op_aceites_lubricantes WHERE idreporte_dia = '" . $id . "' AND id_aceite = '" . $noaceite . "' LIMIT 1 ";
    $result_listatotal = mysqli_query($con, $sql_listatotal);
    while ($row_listatotal = mysqli_fetch_array($result_listatotal, MYSQLI_ASSOC)) {
      $cantidad = $cantidad + $row_listatotal['cantidad'];


    }

  }

  return $cantidad;

}

function precioaceite($IdReporte, $fecha, $noaceite, $con)
{
  $total = 0;
  $sql_listaaceite = "SELECT id FROM op_corte_dia WHERE id_mes = '" . $IdReporte . "' AND fecha = '" . $fecha . "' LIMIT 1 ";
  $result_listaaceite = mysqli_query($con, $sql_listaaceite);
  while ($row_listaaceite = mysqli_fetch_array($result_listaaceite, MYSQLI_ASSOC)) {
    $id = $row_listaaceite['id'];
  }


  $sql_listatotal = "SELECT cantidad,precio_unitario FROM op_aceites_lubricantes WHERE idreporte_dia = '" . $id . "' AND id_aceite = '" . $noaceite . "' LIMIT 1 ";
  $result_listatotal = mysqli_query($con, $sql_listatotal);
  while ($row_listatotal = mysqli_fetch_array($result_listatotal, MYSQLI_ASSOC)) {
    $cantidad = $row_listatotal['cantidad'];
    $precio = $row_listatotal['precio_unitario'];

    $total = $cantidad * $precio;


  }

  return $total;

}

function totalprecio($IdReporte, $fecha, $noaceite, $con)
{
  $total = 0;
  $cantidad = 0;
  $sql_listaaceite = "SELECT id FROM op_corte_dia WHERE id_mes = '" . $IdReporte . "' ";
  $result_listaaceite = mysqli_query($con, $sql_listaaceite);
  while ($row_listaaceite = mysqli_fetch_array($result_listaaceite, MYSQLI_ASSOC)) {
    $id = $row_listaaceite['id'];

    $sql_listatotal = "SELECT cantidad,precio_unitario FROM op_aceites_lubricantes WHERE idreporte_dia = '" . $id . "' AND id_aceite = '" . $noaceite . "' LIMIT 1 ";
    $result_listatotal = mysqli_query($con, $sql_listatotal);
    while ($row_listatotal = mysqli_fetch_array($result_listatotal, MYSQLI_ASSOC)) {
      $cantidad = $cantidad + $row_listatotal['cantidad'];
      $precio = $row_listatotal['precio_unitario'];

      $total = $cantidad * $precio;


    }

  }

  return $total;

}

function totalcantidad($IdReporte, $fecha, $noaceite, $con)
{
  $cantidad = 0;
  $sql_listaaceite = "SELECT id FROM op_corte_dia WHERE id_mes = '" . $IdReporte . "' AND fecha = '" . $fecha . "' ";
  $result_listaaceite = mysqli_query($con, $sql_listaaceite);
  while ($row_listaaceite = mysqli_fetch_array($result_listaaceite, MYSQLI_ASSOC)) {
    $id = $row_listaaceite['id'];



    $sql_listatotal = "SELECT cantidad FROM op_aceites_lubricantes WHERE idreporte_dia = '" . $id . "' ";
    $result_listatotal = mysqli_query($con, $sql_listatotal);
    while ($row_listatotal = mysqli_fetch_array($result_listatotal, MYSQLI_ASSOC)) {
      $cantidad = $cantidad + $row_listatotal['cantidad'];
    }

    return $cantidad;
  }



}

function totalimporte($IdReporte, $fecha, $noaceite, $con)
{
  $totalimporte = 0;
  $sql_listaaceite = "SELECT id FROM op_corte_dia WHERE id_mes = '" . $IdReporte . "' AND fecha = '" . $fecha . "' ";
  $result_listaaceite = mysqli_query($con, $sql_listaaceite);
  while ($row_listaaceite = mysqli_fetch_array($result_listaaceite, MYSQLI_ASSOC)) {
    $id = $row_listaaceite['id'];



    $sql_listatotal = "SELECT cantidad, precio_unitario FROM op_aceites_lubricantes WHERE idreporte_dia = '" . $id . "' ";
    $result_listatotal = mysqli_query($con, $sql_listatotal);
    while ($row_listatotal = mysqli_fetch_array($result_listatotal, MYSQLI_ASSOC)) {
      $cantidad = $row_listatotal['cantidad'];
      $precio = $row_listatotal['precio_unitario'];

      $total = $cantidad * $precio;

      $totalimporte = $totalimporte + $total;

    }

    return $totalimporte;

  }


}
?>


<div class="table-responsive">
  <table class="custom-table" style="font-size: .75em;" width="100%">
    <thead class="tables-bg">
      <tr>
        <th colspan="2" class="align-middle text-center">Concepto</th>
        <th class="align-middle text-center">Pzas caja</th>
        <th class="align-middle text-center">Precio Unitario</th>
        <th class="align-middle text-center">Bodega</th>
        <th class="align-middle text-center">Exhibidores</th>
        <th class="align-middle text-center">Inventario Inicial</th>
        <th class="align-middle text-center">Compras / Pedido</th>
        <th class="align-middle text-center">Ventas del mes</th>
        <th class="align-middle text-center">Inventario Final</th>
        <th class="align-middle text-center">Inventario fisico Bodega</th>
        <th class="align-middle text-center">Inventario fisico Exhibidores</th>
        <th class="align-middle text-center">Inventario fisico Final</th>
        <th class="align-middle text-center">Diferencia</th>
        <th class="align-middle text-center">Diferencia $</th>
        <th class="align-middle text-center">Prod. Facturados</th>
        <th class="align-middle text-center">Factura venta mostrador</th>
        <th class="align-middle text-center">Fac. total</th>
        <th class="align-middle text-center">Dif. En Facturacion</th>
        <?php
        for ($Pdia = 1; $Pdia <= $Udia; $Pdia++) {
          echo "<th class='align-middle text-center'>" . $Pdia . "</th>";
        }
        ?>
        <th class="align-middle text-center ">Total</th>
        <?php
        for ($Pdia = 1; $Pdia <= $Udia; $Pdia++) {
          echo "<th class='align-middle text-center'>" . $Pdia . "</th>";
        }
        ?>
        <th class="align-middle text-center">Total</th>
      </tr>
    </thead>
    <tbody class="bg-white">
      <?php
      function valRow($valor)
      {

        if ($valor == 0) {
          $resultado = 0;
        } else {
          $resultado = number_format($valor, 2, '.', '');
        }

        return $resultado;

      }

      function Piezas($noaceite, $con)
      {
        $piezas=0;
        $sql_listaaceite = "SELECT piezas FROM op_aceites WHERE id_aceite = '" . $noaceite . "' LIMIT 1 ";
        $result_listaaceite = mysqli_query($con, $sql_listaaceite);
        while ($row_listaaceite = mysqli_fetch_array($result_listaaceite, MYSQLI_ASSOC)) {
          $piezas = $row_listaaceite['piezas'];
        }

        return $piezas;
      }
      $totalBodegas = 0;
      $totalExibidores = 0;
      $totalInventarioI = 0;
      $totalPedido = 0;
      $totalVentasM = 0;
      $totalInventarioF = 0;
      $totalInventarioBodega = 0;
      $totalInventarioExibidores = 0;
      $totalInventarioFinal = 0;
      $totalDiferencia = 0;
      $totalDigPrecio = 0;
      $sql_listaaceites = "SELECT * FROM op_aceites_lubricantes_reporte WHERE id_mes = '" . $IdReporte . "' ORDER BY id_aceite ASC ";
      $result_listaaceites = mysqli_query($con, $sql_listaaceites);
      while ($row_listaaceites = mysqli_fetch_array($result_listaaceites, MYSQLI_ASSOC)) {

        $idaceite = $row_listaaceites['id'];
        $noaceite = $row_listaaceites['id_aceite'];
        $piezas = Piezas($noaceite, $con);
        $preciou = $row_listaaceites['precio'];
        $bodega = valRow($row_listaaceites['bodega']);
        $exibidores = valRow($row_listaaceites['exibidores']);
        $pedido = valRow($row_listaaceites['pedido']);

        $inventario_bodega = valRow($row_listaaceites['inventario_bodega']);
        $inventario_exibidores = valRow($row_listaaceites['inventario_exibidores']);

        $producto_facturado = valRow($row_listaaceites['producto_facturado']);
        $factura_venta_mostrador = valRow($row_listaaceites['factura_venta_mostrador']);

        $totalaceites = totalaceites($IdReporte, $noaceite, $con);

        $inventarioI = $bodega + $exibidores;
        $inventarioF = $inventarioI + $pedido - $totalaceites;

        $inventario_final = $inventario_bodega + $inventario_exibidores;

        $diferencia = $inventario_final - $inventarioF;

        $factotal = $factura_venta_mostrador + $producto_facturado;
        $diffactura = $factotal;

        $difPrecio = $row_listaaceites['precio'] * $diferencia;



        $totalBodegas = $totalBodegas + $bodega;
        $totalExibidores = $totalExibidores + $exibidores;
        $totalInventarioI = $totalInventarioI + $inventarioI;
        $totalPedido = $totalPedido + $pedido;
        $totalVentasM = $totalVentasM + $totalaceites;
        $totalInventarioF = $totalInventarioF + $inventarioF;
        $totalInventarioBodega = $totalInventarioBodega + $inventario_bodega;
        $totalInventarioExibidores = $totalInventarioExibidores + $inventario_exibidores;
        $totalInventarioFinal = $totalInventarioFinal + $inventario_final;
        $totalDiferencia = $totalDiferencia + $diferencia;
        $totalDigPrecio = $totalDigPrecio + $difPrecio;
        $sumt = 0;
        ?>
        <tr>
          <th class="align-middle p-1"><?= $row_listaaceites['id_aceite']; ?></th>
          <td class="align-middle p-1"><?= $row_listaaceites['concepto']; ?></td>
          <td class="align-middle p-1 text-center"><?= $piezas; ?></td>
          <td class="align-middle text-end p-1">$ <?= number_format($row_listaaceites['precio'], 2); ?></td>
          <td class="align-middle p-1 text-end">
            <?= $bodega; ?>
          </td>

          <td class="align-middle p-1 text-end">
            <?= $exibidores; ?>
          </td>

          <td class="align-middle bg-white text-end"><?= number_format($inventarioI, 2); ?></td>

          <td class="align-middle p-1 text-end">
            <?= $pedido; ?>
          </td>

          <td class="align-middle p-1 text-end">
            <?= $totalaceites; ?>
          </td>

          <td class="align-middle p-1 text-end">
            <?= number_format($inventarioF, 2); ?>
          </td>

          <td class="align-middle p-1 text-end">
            <?= $inventario_bodega; ?>
          </td>

          <td class="align-middle p-1 text-end">
            <?= $inventario_exibidores; ?>
          </td>

          <td class="align-middle p-1 text-end">
            <?= valRow($inventario_final); ?>
          </td>

          <td class="align-middle p-1 text-end"><?= number_format($diferencia, 2); ?></td>

          <td class="align-middle p-1 text-end">$ <?= number_format($difPrecio, 2); ?></td>

          <td class="align-middle p-1 text-end">
            <?= $producto_facturado; ?>
          </td>
          <td class="align-middle p-1 text-end">
            <?= $factura_venta_mostrador; ?>
          </td>

          <td class="align-middle p-1 text-end">
            <?= $factotal; ?>
          </td>

          <td class="align-middle p-1 text-end">
            <?= $diffactura; ?>
          </td>

          <?php

          for ($Pdia = 1; $Pdia <= $Udia; $Pdia++) {

            $fecha = $GET_year . "-" . $GET_mes . "-" . $Pdia;
            $cantidad = cantidadaceites($IdReporte, $fecha, $noaceite, $con);

            echo "<td class='align-middle text-center'>" . $cantidad . "</td>";

          }

          $sumt = $sumt + $totalaceites;
          ?>
          <td class="align-middle text-center bg-white"><?= $totalaceites; ?></td>
          <?php
          $importeneto = 0;
          for ($Pdia = 1; $Pdia <= $Udia; $Pdia++) {

            $fechap = $GET_year . "-" . $GET_mes . "-" . $Pdia;
            $precioaceite = precioaceite($IdReporte, $fechap, $noaceite, $con);

            echo "<td class='align-middle text-center'>" . number_format($precioaceite, 2) . "</td>";
          }
          $totalprecio = totalprecio($IdReporte, $fecha, $noaceite, $con);
          $importeneto = $importeneto + $totalprecio;
          ?>
          <td class="align-middle text-center bg-white"><?= number_format($totalprecio, 2); ?></td>
        </tr>
        <?php
      }
      ?>
      <tr>
        <th class="text-end" colspan="4">TOTAL</th>

        <td class="align-middle p-1 text-end"><?= number_format($totalBodegas, 2); ?></td>
        <td class="align-middle p-1 text-end"><?= number_format($totalExibidores, 2); ?></td>
        <td class="align-middle p-1 text-end"><?= number_format($totalInventarioI, 2); ?></td>
        <td class="align-middle p-1 text-end"><?= number_format($totalPedido, 2); ?></td>
        <td class="align-middle p-1 text-end"><?= number_format($totalVentasM, 2); ?></td>
        <td class="align-middle p-1 text-end"><?= number_format($totalInventarioF, 2); ?></td>
        <td class="align-middle p-1 text-end"><?= number_format($totalInventarioBodega, 2); ?></td>
        <td class="align-middle p-1 text-end"><?= number_format($totalInventarioExibidores, 2); ?></td>
        <td class="align-middle p-1 text-end"><?= number_format($totalInventarioFinal, 2); ?></td>
        <td class="align-middle p-1 text-end"><?= number_format($totalDiferencia, 2); ?></td>
        <td class="align-middle p-1 text-end">$<?= number_format($totalDigPrecio, 2); ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <?php
        $noaceite = 0;

        for ($Pdia = 1; $Pdia <= $Udia; $Pdia++) {
          $fecha = $GET_year . "-" . $GET_mes . "-" . $Pdia;
          $totalcantidad = totalcantidad($IdReporte, $fecha, $noaceite, $con);

          echo "<td class='align-middle text-center'>" . $totalcantidad . "</td>";
        }
        ?>
    <td class="align-middle text-center bg-light"><?php echo $sumt; ?></td>
    <?php
        for ($Pdia = 1; $Pdia <= $Udia; $Pdia++) {

          $fecha = $GET_year . "-" . $GET_mes . "-" . $Pdia;
          $totalimporte = totalimporte($IdReporte, $fecha, $noaceite, $con);

          echo "<td class='align-middle text-center'>" . number_format($totalimporte, 2) . "</td>";
        }
        ?>
        <td class="align-middle text-center bg-white"><?= number_format($importeneto, 2); ?></td>
      </tr>
    </tbody>
  </table>
</div>