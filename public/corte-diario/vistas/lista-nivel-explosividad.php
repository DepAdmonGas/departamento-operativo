<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$sql_lista = "SELECT * FROM op_nivel_explosividad WHERE id_estacion = '".$idEstacion."' ORDER BY folio DESC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>

<div class="table-responsive">
    <table class="table table-sm table-bordered table-hover mb-0">
      <thead class="tables-bg">
        <tr>
          <th class="align-middle">Folio</th>
          <th class="align-middle">Fecha</th>
        </tr>
      </thead>
      <tbody>
        <?php
		if ($numero_lista > 0) {
		while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

		echo '<tr class="pointer">';
		echo '<td class="align-middle" onclick="Detalle('.$row_lista['id'].')">00'.$row_lista['folio'].'</td>';
		echo '<td class="align-middle" onclick="Detalle('.$row_lista['id'].')">'.FormatoFecha($row_lista['fecha']).'</td>';
		echo '</tr>';

		}
		}else{
		echo "<tr><td colspan='4' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
		}
		?>
      </tbody>
    </table>
</div>