<?php
require ('../../../../help.php');
$idEstacion = $_GET['idEstacion'];

?>

<div class="table-responsive">
<table class="custom-table" style="font-size: .8em;" width="100%">
<thead class="tables-bg">
<tr>
<th colspan="5">Plantilla</th>
</tr>

<tr class="title-table-bg">
<td class="fw-bold" width="24px">No.</td>
<th>Descripción</th>
<th>Nombre Completo</th>
<th width="24px"><img src="<?=RUTA_IMG_ICONOS?>archivo-tb.png"></th>
<th width="24px"><img src="<?=RUTA_IMG_ICONOS?>eliminar.png"></th>
</tr>
</thead>

<tbody class="bg-white">
<?php
$sql_plantilla = "SELECT * FROM tb_organigrama_plantilla WHERE id_estacion = '" . $idEstacion . "' AND status = 0 ORDER BY id ASC";
$result_plantilla  = mysqli_query($con, $sql_plantilla);
$numero_plantilla  = mysqli_num_rows($result_plantilla);
if ($numero_plantilla  > 0) {
$num = 1;

while ($row_lista_plantilla = mysqli_fetch_array($result_plantilla, MYSQLI_ASSOC)) {
$id = $row_lista_plantilla['id'];
$id_usuario = $row_lista_plantilla['id_usuario'];
$descripcion = $row_lista_plantilla['descripcion'];

$datosPersonal = $ClassHerramientasDptoOperativo->obtenerDatosPersonal($id_usuario);

if($id_usuario == 0){
$nombre_completo = "";
$btnEditar = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'archivo-tb.png">';

}else{
$nombre_completo = $datosPersonal['nombre_personal'];
$btnEditar = '<img onclick="ModalCP('.$id.')" src="' . RUTA_IMG_ICONOS . 'archivo-tb.png">';

}

echo '<tr> 
<th class="align-middle text-center"><b>'.$num.'</b></th>
<td class="align-middle text-center p-0">
<input onchange="datosPlantilla(this, '.$id.', '.$idEstacion.', 1)" class="form-control rounded-0 border-0" id="descripcionPuesto_'.$id.'" placeholder="Ingresa la descripcion de puesto..." value="'.$descripcion.'">
</td>

<td class="align-middle text-center p-0">
<input oninput="buscarNombres(this, '.$idEstacion.')" onchange="datosPlantilla(this, '.$id.', '.$idEstacion.', 2)" list="listaNombres_'.$idEstacion.'" class="form-control rounded-0 border-0" id="NombresCompleto_'.$id.'" placeholder="Selecciona y/o escribe el personal..." value="'.$nombre_completo.'">
<datalist id="listaNombres_'.$idEstacion.'"> </datalist>
</td>

<td class="align-middle text-center pointer" width="20">'.$btnEditar .'</td>
<td class="align-middle text-center pointer" width="20"><img onclick="EliminarPP('.$id.')" src="' . RUTA_IMG_ICONOS . 'eliminar.png"></td>
</tr>';
$num++;
}

}else{
echo "<tr><th colspan='5' class='text-center text-secondary'><small>No se encontró información para mostrar </small></th></tr>";
}


?>

</tbody>
</table>
</div>