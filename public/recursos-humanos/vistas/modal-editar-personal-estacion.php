<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$idPersonal = $_GET['idPersonal'];

$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}

$sql_personal = "SELECT
op_rh_personal.id,
op_rh_personal.id_estacion,
op_rh_personal.nombre_completo,
op_rh_personal.puesto AS idPuesto,
op_rh_personal.curp,
op_rh_personal.sd,
op_rh_puestos.puesto,
op_rh_personal.estado
FROM op_rh_personal
INNER JOIN op_rh_puestos 
ON op_rh_personal.puesto = op_rh_puestos.id
WHERE op_rh_personal.id = '".$idPersonal."' ";
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);
while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){

}

?>
<div class="modal-header">
<h5 class="modal-title">Agregar personal <?=$estacion;?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<div class="row">



</div>
</div>

<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="EditarPersonal(<?=$idEstacion;?>)">Editar</button>
</div>

