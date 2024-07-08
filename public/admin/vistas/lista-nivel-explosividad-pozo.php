<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];

$sql_lista = "SELECT * FROM op_nivel_explosividad_pozo_motobomba WHERE id_reporte = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
?>

<div class="text-end">
<button type="button" class="btn btn-labeled2 btn-success mb-3" onclick="ModalPozo(<?=$idReporte;?>)">
<span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button></div>


<div class="table-responsive">
  <table class="custom-table" style="font-size: 12.5px;" width="100%">
  <thead class="title-table-bg">
  <tr>
  <th class="align-middle">Detalle</th>
  <th class="align-middle">PPM</th>
  <th class="align-middle">Ubicación de Pozos</th>
  <th class="align-middle" width="24"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
  </tr>
  </thead>

  <tbody class="bg-light">
  <?php
	if ($numero_lista > 0) {
	while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
	echo '<tr>';
	echo '<th class="align-middle no-hover2 fw-normal">'.$row_lista['pozo_motobomba'].'</th>';
	echo '<td class="align-middle no-hover2">'.$row_lista['ppm'].'</td>';
	echo '<td class="align-middle no-hover2">'.$row_lista['ubicacion'].'</td>';
	echo '<td class="align-middle no-hover2 text-center"><img src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$idReporte.','.$row_lista['id'].')"></td>';
	echo '</tr>';

	}
	}else{
	echo "<tr><th colspan='4' class='text-center text-secondary no-hover2'><small>No se encontró información para mostrar </small></th></tr>";
	}
	?>
  </tbody>
  </table>
</div>
 
