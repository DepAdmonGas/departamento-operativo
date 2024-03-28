<?php 
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}

$sql_empresa = "SELECT * FROM op_rh_localidades_perfil WHERE id_estacion = '".$idEstacion."' AND status = 1  ";
$result_empresa = mysqli_query($con, $sql_empresa);
$numero_empresa = mysqli_num_rows($result_empresa);


?>

<div class="border-0 p-3"> 

<div class="row">

<div class="col-10">
	<h5><?=$estacion;?></h5>
</div>

<div class="col-2">
<img class="pointer float-end" onclick="ModalPerfil(<?=$idEstacion;?>)" src="<?=RUTA_IMG_ICONOS;?>agregar.png" >
</div>

</div>

<hr>

<div class="row">
<div class="col-12 mb-2">
<h6 class="float-end">Usuario y contraseña (<strong>Sensor de huella</strong>)</h6>
</div>
</div>

<div class="table-responsive">
<table class="table table-sm table-bordered mb-0 table-striped table-hover">
<thead class="tables-bg">
<tr>
<th class="text-center align-middle" width="64px">#</th>
<th class="text-center align-middle">Usuario</th>
<th class="text-center align-middle">Contraseña</th>
<th class="text-center align-middle" width="32px"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png" /></th>
<th class="text-center align-middle" width="32px"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png" /></th>
</thead>
</tr>


<tbody>
<?php
if($numero_empresa > 0){
while($row_empresa = mysqli_fetch_array($result_empresa, MYSQLI_ASSOC)){

$id = $row_empresa['id'];

$usuario = $ClassEncriptar->decrypt($row_empresa['usuario']);
$password = $ClassEncriptar->decrypt($row_empresa['password']);	

echo '<tr>';
echo '<td class="text-center align-middle">'.$row_empresa['id'].'</td>';
echo '<td class="text-center align-middle"><strong>'.$ClassEncriptar->decrypt($row_empresa['usuario']).'</strong></td>';
echo '<td class="text-center align-middle"><strong>'.$ClassEncriptar->decrypt($row_empresa['password']).'</strong></td>';
echo '<td class="text-center align-middle"> <img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" class="pointer" onclick="editar('.$id.', '.$idEstacion.')"> </td>';
echo '<td class="text-center align-middle"> <img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" class="pointer" onclick="eliminarPerfil('.$id.', '.$idEstacion.')"/> </td>';
echo '</tr>';

}
}else{
echo "<tr><td colspan='5' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";	
}

?>
</tbody>
</table>
</div>
</div>




