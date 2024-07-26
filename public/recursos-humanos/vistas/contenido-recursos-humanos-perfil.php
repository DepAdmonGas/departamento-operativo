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

<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Configuración</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Perfil de aplicación (<?=$estacion?>)</li>
</ol>
</div>

<div class="row">
<div class="col-9">
<h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Perfil de aplicación (<?=$estacion?>)</h3>
</div>

<div class="col-3">
<button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="ModalPerfil(<?=$idEstacion;?>)">
<span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
</div>

</div>

<hr>
</div>

<div class="table-responsive">
<table id="tabla_bitacora" class="custom-table" style="font-size: 12.5px;" width="100%">
<thead class="title-table-bg">

<tr class="tables-bg">
<th class="text-center align-middle" colspan="5">Sensor de huella</th>
</tr>

<tr>
<td class="text-center align-middle fw-bold" width="64px">#</td>
<th class="text-center align-middle">Usuario</th>
<th class="text-center align-middle">Contraseña</th>
<th class="text-center align-middle" width="32px"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png" /></th>
<td class="text-center align-middle" width="32px"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png" /></td>
</thead>
</tr>


<tbody class="bg-white">
<?php
if($numero_empresa > 0){
while($row_empresa = mysqli_fetch_array($result_empresa, MYSQLI_ASSOC)){

$id = $row_empresa['id'];

$usuario = $ClassEncriptar->decrypt($row_empresa['usuario']);
$password = $ClassEncriptar->decrypt($row_empresa['password']);	

echo '<tr>';
echo '<th class="text-center align-middle">'.$row_empresa['id'].'</td>';
echo '<td class="text-center align-middle"><strong>'.$ClassEncriptar->decrypt($row_empresa['usuario']).'</strong></th>';
echo '<td class="text-center align-middle"><strong>'.$ClassEncriptar->decrypt($row_empresa['password']).'</strong></td>';
echo '<td class="text-center align-middle"> <img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" class="pointer" onclick="editar('.$id.', '.$idEstacion.')"> </td>';
echo '<td class="text-center align-middle"> <img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" class="pointer" onclick="eliminarPerfil('.$id.', '.$idEstacion.')"/> </td>';
echo '</tr>';

}
}else{
echo "<tr><td colspan='5' class='text-center text-secondary fw-normal no-hover2'><small>No se encontró información para mostrar </small></td></tr>";	
}

?>
</tbody>
</table>
</div>




