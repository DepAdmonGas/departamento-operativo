<?php
require ('../../../../help.php');
$idEstacion = $_GET['idEstacion'];

$sql_empresa = "SELECT * FROM op_rh_personal_horario_programar WHERE id_estacion = '" . $idEstacion . "' AND estado >= 1 ";
$result_empresa = mysqli_query($con, $sql_empresa);
$numero_empresa = mysqli_num_rows($result_empresa);
?>

<div class="table-responsive">
<table id="tabla_horario" class="custom-table mt-2" style="font-size: .8em;" width="100%">

<thead class="navbar-bg">
<tr>
<th class="text-center align-middle" width="48px">#</th>
<th class="text-center">Fecha programada</th>
<th class="text-center align-middle" width="32px"><img src="<?= RUTA_IMG_ICONOS; ?>ver-tb.png" /></th>
<th class="text-center align-middle" width="32px"><img src="<?= RUTA_IMG_ICONOS; ?>eliminar.png" /></th>
</tr>
</thead>

<tbody>
<?php

if ($numero_empresa > 0) {
while ($row_empresa = mysqli_fetch_array($result_empresa, MYSQLI_ASSOC)) {
$id = $row_empresa['id'];

if ($row_empresa['estado'] == 1) {
$trcolor = 'style="background-color: #fcfcda"';
$eliminar = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="Eliminar('.$id.','.$idEstacion.')"/>';

}else if ($row_empresa['estado'] == 2){
$trcolor = 'style="background-color: #b0f2c2"';
$eliminar = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'eliminar.png"/>';
}

echo '<tr ' . $trcolor . '">';
echo '<th class="text-center align-middle fw-normal">' . $row_empresa['id'] . '</th>';
echo '<td class="text-start">' . $ClassHerramientasDptoOperativo->FormatoFecha($row_empresa['fecha']) . '</td>';
echo '<td class="text-center align-middle"><img src="' . RUTA_IMG_ICONOS . 'ver-tb.png" onclick="Detalle('.$id.')"/></td>';
echo '<td class="text-center align-middle">' . $eliminar . '</td>';
echo '</tr>';

}

}
?>

</tbody>
</table>
</div>