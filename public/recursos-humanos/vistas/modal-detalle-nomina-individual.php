<?php
require('../../../app/help.php');

$idNomina = $_GET['idNomina'];

$sql_lista = "SELECT * FROM op_recibo_nomina WHERE id = '".$idNomina."'";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

function archivoNomina($idNomina,$con){

$sql_lista = "SELECT * FROM op_recibo_nomina_documento WHERE id_nomina = '".$idNomina."'";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$documento = $row_lista['documento'];
}

return $documento;

}


while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$fecha = $row_lista['fecha'];

$explode = explode(" ", $fecha);
$fecha_desc = $explode[0];

$GET_idNomina = $row_lista['id'];
$nomina = $row_lista['nomina'];
$periodo = $row_lista['periodo'];
$status = $row_lista['status'];


}

if($status == 0){
$archivo_nomina = '<div class="col-12 mt-2">
<div class="alert alert-secondary text-center" role="alert">
  No se ha subido el recibo de nomina firmado.
</div>
</div>';

}else{

$archivo = archivoNomina($GET_idNomina,$con);

$archivo_nomina = '<iframe class="border-0 mt-2 mb-3" src="'.RUTA_ARCHIVOS.'/recibos-nomina/firmados/'.$archivo.'" width="100%" height="600px"></iframe>';
  
}


?> 


<div class="modal-header">
<h5 class="modal-title">Detalle Nomina - <?=$periodo?></h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">

<label class="text-secondary mb-0">Fecha de ingreso:</label>
<div><?=FormatoFecha($fecha_desc)?></div>

<label class="text-secondary mt-2 mb-0">Recibo de nomina (firmado):</label>
<?=$archivo_nomina?>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
</div>