<?php
require ('../../../../help.php');

$idReporte = $_GET['idReporte'];

$sql_lista = "SELECT * FROM op_pivoteo_detalle WHERE id_pivoteo = '" . $idReporte . "' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
    $id = $row_lista['id'];
    $id_pivoteo = $row_lista['id_pivoteo'];
    $estacionfc = $row_lista['estacion_fc'];
    $destinofc = $row_lista['destino_fc'];
    $productofc = $row_lista['producto_fc'];
    $tanquefc = $row_lista['tanque_fc'];
    $facturafc = $row_lista['factura_fc'];
    $litros = $row_lista['litros'];
    $tad = $row_lista['tad'];
    $unidad = $row_lista['unidad'];
    $chofer = $row_lista['chofer'];
    $estacionfn = $row_lista['estacion_fn'];
    $destinofn = $row_lista['destino_fn'];
    $tanquefn = $row_lista['tanque_fn'];
    $facturafn = $row_lista['factura_fn'];


    echo '<div class="p-3 border mb-3">';

    echo '<div class="text-end">
<button type="button" class="btn btn-danger btn-sm" onclick="Eliminar(' . $idReporte . ',' . $id . ')">Eliminar</button>
</div>
<hr>';

    echo '<div class="table-responsive">';
    echo '<table class="table table-sm table-bordered mb-0">';
    echo '<tbody>';
    echo '<tr class="bg-primary text-white text-center">
	   <td width="50%" colspan="2"><b>Documentación Facturada (CANCELAR)</b></td>
	   <td width="50%" colspan="2"><b>Documentación a refacturar</b></td>
	 </tr>';

    echo '<tr>
	  <td><b>Estación:</b></td>
	  <td>' . $estacionfc . '</td>
	  <td><b>Estación:</b></td>
	  <td>' . $estacionfn . '</td>
	  </tr>';

    echo '<tr>
	  <td><b>Destino:</b></td>
	  <td>' . $destinofc . '</td>
	  <td><b>Destino:</b></td>
	  <td>' . $destinofn . '</td>
	  </tr>';

    echo '<tr>
	  <td><b>Producto:</b></td>
	  <td>' . $productofc . '</td>
	  <td><b>Producto:</b></td>
	  <td>' . $productofc . '</td>
	  </tr>';

    echo '<tr>
	  <td><b>Tanque:</b></td>
	  <td>' . $tanquefc . '</td>
	  <td><b>Tanque:</b></td>
	  <td>' . $tanquefn . '</td>
	  </tr>';

    echo '<tr>
	  <td><b>Factura:</b></td>
	  <td>' . $facturafc . '</td>
	  <td><b>Factura:</b></td>
	  <td>' . $facturafn . '</td>
	  </tr>';

    echo '<tr>
	  <td><b>Litros:</b></td>
	  <td>' . number_format($litros, 2) . '</td>
	  <td><b>Litros:</b></td>
	  <td>' . number_format($litros, 2) . '</td>
	  </tr>';

    echo '<tr>
	  <td><b>TAD:</b></td>
	  <td>' . $tad . '</td>
	  <td><b>TAD:</b></td>
	  <td>' . $tad . '</td>
	  </tr>';

    echo '<tr>
	  <td><b>Unidad:</b></td>
	  <td>' . $unidad . '</td>
	  <td><b>Unidad:</b></td>
	  <td>' . $unidad . '</td>
	  </tr>';

    echo '<tr>
	  <td><b>Chofer:</b></td>
	  <td>' . $chofer . '</td>
	  <td><b>Chofer:</b></td>
	  <td>' . $chofer . '</td>
	  </tr>';

    echo '</tbody>';
    echo '</table>';
    echo '</div>';

    echo '</div>';

}

//------------------
mysqli_close($con);
//------------------