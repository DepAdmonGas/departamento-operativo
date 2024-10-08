<?php
require ('../../../../help.php');

// Obtener los parámetros de la solicitud
$idEstacion = $_GET['idEstacion'];
$dato = $_GET['dato'];

// Si el dato está vacío, buscamos solo por la estación
if($dato == "") {
$consulta = "id_estacion = " . $idEstacion;
} else {
$consulta = "nombre_completo LIKE '%" . $dato . "%'";
}

$sql_puesto = "SELECT id, nombre_completo FROM op_rh_personal WHERE $consulta AND estado = 1";
$result_puesto = mysqli_query($con, $sql_puesto);

// Generar las opciones para el datalist
while($row_puesto = mysqli_fetch_array($result_puesto, MYSQLI_ASSOC)) {
echo '<option value="'.$row_puesto['nombre_completo'].'" data-id="'.$row_puesto['id'].'"></option>';
}

?>
