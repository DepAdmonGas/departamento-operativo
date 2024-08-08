<?php
require ('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$Year = $_GET['Year'];
$Mes = $_GET['Mes'];

$sql_estaciones = "SELECT producto_uno, producto_dos, producto_tres FROM tb_estaciones WHERE id = '" . $idEstacion . "' ";
$result_estaciones = mysqli_query($con, $sql_estaciones);
$numero_estaciones = mysqli_num_rows($result_estaciones);
while ($row_estaciones = mysqli_fetch_array($result_estaciones, MYSQLI_ASSOC)) {
  $ProductoUno = $row_estaciones['producto_uno'];
  $ProductoDos = $row_estaciones['producto_dos'];
  $ProductoTres = $row_estaciones['producto_tres'];
}

function TotalVentas($idDias, $Producto, $con)
{

  $sql = "SELECT * FROM op_ventas_dia WHERE idreporte_dia = '" . $idDias . "' AND producto = '" . $Producto . "' ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  $TotalLitros = 0;
  $TotalPrecio = 0;
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $litros = $row['litros'];
    $preciolitro = $row['precio_litro'];
    $LitrosPrecio = $litros * $preciolitro;

    $TotalLitros = $TotalLitros + $litros;
    $TotalPrecio = $TotalPrecio + $LitrosPrecio;
  }

  $array = array(
    'TotalLitros' => $TotalLitros,
    'TotalPrecio' => $TotalPrecio
  );

  return $array;
}

?>


<div class="table-responsive">
    <table class="custom-table" style="font-size: .75em;" width="100%">
        <thead class="navbar-bg">
      <tr>
        <th class="text-center align-middle" rowspan="2">FECHA</th>
        <?php
        if ($ProductoUno != "") {
          echo '<th class="text-center align-middle" style="background-color: #76bd1d" colspan="2">' . $ProductoUno . '</th>';
        }
        if ($ProductoDos != "") {
          echo '<th class="text-center align-middle" style="background-color: #e21683" colspan="2">' . $ProductoDos . '</th>';
        }
        if ($ProductoTres != "") {
          echo '<th class="text-center align-middle" style="background-color: #000000" colspan="2">' . $ProductoTres . '</th>';
        }
        ?>
      </tr>
      <tr> 
        <?php

        if ($ProductoUno != "") {
          echo '<td class="text-start fw-bold" style="background-color: #76bd1d">Litros</td>
                  <td class="text-end fw-bold" style="background-color: #76bd1d">Pesos</td>';
        }

        if ($ProductoDos != "") {
          echo '<td class="text-start fw-bold" style="background-color: #e21683">Litros</td>
            	  <td class="text-end fw-bold" style="background-color: #e21683">Pesos</td>';
        }

        if ($ProductoTres != "") {
          echo '<td class="text-startfw-bold" style="background-color: #000000">Litros</td>
            	  <td class="text-end fw-bold" style="background-color: #000000">Pesos</td>';
        }

        ?> 

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
          WHERE op_corte_year.id_estacion = '" . $idEstacion . "' AND 
          op_corte_year.year = '" . $Year . "' AND 
          op_corte_mes.mes = '" . $Mes . "'";
    $result_listadia = mysqli_query($con, $sql_listadia);
    $numero_listadia = mysqli_num_rows($result_listadia);
    $P1TL = 0;
    $P1TP = 0;

    $P2TL = 0;
    $P2TP = 0;

    $P3TL = 0;
    $P3TP = 0;
    while ($row_listadia = mysqli_fetch_array($result_listadia, MYSQLI_ASSOC)) {
      $idDias = $row_listadia['idDia'];
      $fecha = $row_listadia['fecha'];

      $Producto1 = TotalVentas($idDias, $ProductoUno, $con);
      $Producto2 = TotalVentas($idDias, $ProductoDos, $con);
      $Producto3 = TotalVentas($idDias, $ProductoTres, $con);


      echo "<tr >";
      echo "<th class='text-start'>" . FormatoFecha($fecha) . "</th>";

      if ($ProductoUno != "") {
        echo "<td class='align-middle text-start'>" . number_format($Producto1['TotalLitros'], 2) . "</td>";
        echo "<td class='align-middle text-end'>$" . number_format($Producto1['TotalPrecio'], 2) . "</td>";
      }

      if ($ProductoDos != "") {
        echo "<td class='align-middle text-start'>" . number_format($Producto2['TotalLitros'], 2) . "</td>";
        echo "<td class='align-middle text-end'>$" . number_format($Producto2['TotalPrecio'], 2) . "</td>";
      }

      if ($ProductoTres != "") {
        echo "<td class='align-middle text-start'>" . number_format($Producto3['TotalLitros'], 2) . "</td>";
        echo "<td class='align-middle text-end'>$" . number_format($Producto3['TotalPrecio'], 2) . "</td>";
      }
      echo "</tr>";

      $P1TL = $P1TL + $Producto1['TotalLitros'];
      $P1TP = $P1TP + $Producto1['TotalPrecio'];

      $P2TL = $P2TL + $Producto2['TotalLitros'];
      $P2TP = $P2TP + $Producto2['TotalPrecio'];

      $P3TL = $P3TL + $Producto3['TotalLitros'];
      $P3TP = $P3TP + $Producto3['TotalPrecio'];
    }

    echo '<tr class="title-table-bg">
          <th class="title-table-bg">Total</th>';

    if ($ProductoUno != "") {
      echo '<td class="text-start title-table-bg"><b>' . number_format($P1TL, 2) . '</b></td>
          <td class="text-end title-table-bg"><b>$' . number_format($P1TP, 2) . '</b></td>';
    }

    if ($ProductoDos != "") {
      echo '<td class="text-start title-table-bg"><b>' . number_format($P2TL, 2) . '</b></td>
          <td class="text-end title-table-bg"><b>$' . number_format($P2TP, 2) . '</b></td>';
    }

    if ($ProductoTres != "") {
      echo '<td class="text-start title-table-bg"><b>' . number_format($P3TL, 2) . '</b></td>
          <td class="text-end title-table-bg"><b>$' . number_format($P3TP, 2) . '</b></td>';
    }

    echo '</tr>';

    ?>
    </tbody>
  </table>
</div>