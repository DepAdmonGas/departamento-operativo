<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];

$sql_lista = "SELECT * FROM op_nivel_explosividad_pozo_motobomba WHERE id_reporte = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
?>

<div class="border p-3 mt-3">

<div class="text-end"><img class="pointer" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="ModalPozo(<?=$idReporte;?>)"></div>

<hr>

<div class="table-responsive">
    <table class="table table-sm table-bordered mb-0">
      <thead class="tables-bg">
        <tr>
          <th class="align-middle">Detalle</th>
          <th class="align-middle">PPM</th>
          <th class="align-middle">Ubicación de Pozos</th>
          <th class="align-middle" width="24"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
        </tr>
      </thead>
      <tbody>
        <?php
		if ($numero_lista > 0) {
		while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

		echo '<tr>';
		echo '<td class="align-middle">'.$row_lista['pozo_motobomba'].'</td>';
		echo '<td class="align-middle">'.$row_lista['ppm'].'</td>';
		echo '<td class="align-middle">'.$row_lista['ubicacion'].'</td>';
		echo '<td class="align-middle text-center"><img src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$idReporte.','.$row_lista['id'].')"></td>';
		echo '</tr>';

		}
		}else{
		echo "<tr><td colspan='4' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
		}
		?>
      </tbody>
    </table>
  </div>
   
  </div>