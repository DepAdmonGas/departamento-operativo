<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$year = $_GET['year'];
$mes = $_GET['mes'];
$SemQui = $_GET['SemQui'];
$descripcion = $_GET['descripcion'];

$sql = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Titulo = $row['localidad'];
}

function botonFinalizar($idEstacion,$year,$mes,$SemQui,$descripcion,$con){

$sql_lista3 = "SELECT id FROM op_recibo_nomina_v2_puntaje WHERE id_estacion = '".$idEstacion."' AND year = '".$year."' AND mes = '".$mes."' AND no_semana_quincena = '".$SemQui."' AND descripcion = '".$descripcion."' AND actividad = 'Recibos Mexdesa'";
$result_lista3 = mysqli_query($con, $sql_lista3);
return $numero_lista3 = mysqli_num_rows($result_lista3);
    
}

$numeroFinalizar = botonFinalizar($idEstacion,$year,$mes,$SemQui,$descripcion,$con);

$sql_lista2 = "SELECT id, doc_nomina_acuse FROM op_recibo_nomina_v2_acuses WHERE id_estacion = '".$idEstacion."' AND year = '".$year."' AND mes = '".$mes."' AND no_semana_quincena = '".$SemQui."' AND descripcion = '".$descripcion."'";
$result_lista2 = mysqli_query($con, $sql_lista2);
$numero_lista2 = mysqli_num_rows($result_lista2);

if ($numero_lista2 == 0) {
$frameNomina = '<div class="alert alert-danger text-center mb-0" role="alert">
No has subido los recibos de nomina de la '.$descripcion.' '.$SemQui.' del personal de '.$Titulo.'
</div>';
$BtnSubir = '<div class="col-12"><button type="button" class="btn btn-primary float-end" onclick="SubirAcusesNomina(0,'.$idEstacion.','.$year.','.$mes.','.$SemQui.',\''.$descripcion.'\')">Guardar</button></div>';
$BtnFinalizar = '';
 
}else{

while($row_lista2 = mysqli_fetch_array($result_lista2, MYSQLI_ASSOC)){
$GET_idAcuse = $row_lista2['id'];
$doc_nomina_acuse = $row_lista2['doc_nomina_acuse'];
}

$frameNomina = '<iframe class="border-0" src="'.RUTA_ARCHIVOS.'/recibos-nomina-v2/recibos-mexdesa/'.$doc_nomina_acuse.'" width="100%" height="400px"></iframe>';
$BtnSubir = '<div class="col-12"><button type="button" class="btn btn-primary float-end" onclick="SubirAcusesNomina('.$GET_idAcuse.','.$idEstacion.','.$year.','.$mes.','.$SemQui.',\''.$descripcion.'\')">Editar</button></div>';

if($numeroFinalizar != 0){
$BtnFinalizar = '';
}else{
$BtnFinalizar = '<button type="button" class="btn btn-success" onclick="FinalizarNomina(1,'.$idEstacion.','.$year.','.$mes.','.$SemQui.',\''.$descripcion.'\')">Finalizar</button>';
}

}


?>

<div class="modal-header">
<h5 class="modal-title">Recibos de Nomina - <?=$Titulo?> (<?=$descripcion?> <?=$SemQui?>)</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">

    <div class="row"> 
    <div class="col-12 mb-2 mb-2">
    <div class="mb-1 text-secondary">Archivo:</div> 
    <input class="form-control" type="file" id="DocumentoAcuse">
    </div>

    <div class="col-12 mt-2 pb-0 mb-0"> 
    <div class="p-3 border">
    <div class="row">
    <?=$BtnSubir?>
    </div>
    <hr>
    <?=$frameNomina?>
    </div>
    </div>
    </div>
    
</div>

 
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
    <?=$BtnFinalizar?>
</div>

