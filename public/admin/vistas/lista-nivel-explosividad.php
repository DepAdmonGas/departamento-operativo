<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$sql_listaestacion = "SELECT localidad, recuperacion_vapores FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}

$sql_lista = "SELECT * FROM op_nivel_explosividad WHERE id_estacion = '".$idEstacion."' ORDER BY folio DESC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>

<div class="border-0 p-3 ">

<div class="row">

<div class="col-10">
<h5>Nivel de explosividad <?=$estacion;?></h5>
</div>

 
<div class="col-2">
<img src="<?=RUTA_IMG_ICONOS;?>agregar.png" class="float-end pointer" onclick="Agregar(<?=$idEstacion;?>)">
</div>

</div>

<hr>

<div class="table-responsive">
    <table class="table table-sm table-bordered table-hover mb-0">
      <thead class="tables-bg">
        <tr>
          <th class="align-middle text-center">Folio</th>
          <th class="align-middle text-center">Fecha</th>
          <th class="align-middle text-center" width="24"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
        </tr>
      </thead>
      <tbody>
        <?php
		if ($numero_lista > 0) {
		while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

		echo '<tr class="pointer">';
		echo '<td class="align-middle text-center" onclick="Detalle('.$row_lista['id'].')">00'.$row_lista['folio'].'</td>';
		echo '<td class="align-middle text-center" onclick="Detalle('.$row_lista['id'].')">'.FormatoFecha($row_lista['fecha']).'</td>';
		echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$idEstacion.','.$row_lista['id'].')"></td>';
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