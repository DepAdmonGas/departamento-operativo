<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$sql_listaestacion = "SELECT localidad, recuperacion_vapores FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}

$sql_lista = "SELECT * FROM op_calibracion_dispensario WHERE id_estacion = '".$idEstacion."' ORDER BY year DESC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>


<div class="border-0 p-3">

<div class="row">

<div class="col-11">
  <h5><?=$estacion;?></h5>
</div>

<div class="col-1">
  <img src="<?=RUTA_IMG_ICONOS;?>agregar.png" class="float-end pointer" onclick="ModalNuevo(<?=$idEstacion;?>)">
</div>

</div>

<hr>

<div class="table-responsive">
    <table class="table table-sm table-bordered table-hover mb-0">
      <thead class="tables-bg">
        <tr>
          <th class="align-middle text-center">#</th>
          <th class="align-middle text-center">Fecha</th>
          <th class="align-middle text-center">Año</th>
          <th class="align-middle text-center">Periodo</th>
          <th class="align-middle text-center" width="24"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
          <th class="align-middle" width="24"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
        </tr>
      </thead>
      <tbody>
        <?php
		if ($numero_lista > 0) {
		while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

    $Fecha = explode(" ", $row_lista['fecha']);

		echo '<tr>';
		echo '<td class="align-middle text-center"><b>'.$row_lista['id'].'</b></td>';
		echo '<td class="align-middle text-center">'.FormatoFecha($Fecha[0]).'</td>';
    echo '<td class="align-middle text-center"><b>'.$row_lista['year'].'</b></td>';
    echo '<td class="align-middle text-center">'.$row_lista['periodo'].'</td>';
    echo '<td class="text-center align-middle"><a href="../archivos/'.$row_lista['archivo'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></td>';
		echo '<td class="text-center align-middle"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$idEstacion.','.$row_lista['id'].')"></td>';
		echo '</tr>';

		}
		}else{
		echo "<tr><td colspan='6' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
		}
		?>
      </tbody>
    </table>
  </div>

</div>