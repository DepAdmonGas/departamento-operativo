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

$sql_lista2 = "SELECT id, doc_nomina_aguinaldo, status FROM op_recibo_nomina_aguinaldo WHERE id_estacion = '".$idEstacion."' AND year = '".$year."' AND mes = '".$mes."' AND no_semana_quincena = '".$SemQui."' AND descripcion = '".$descripcion."'";
$result_lista2 = mysqli_query($con, $sql_lista2);
$numero_lista2 = mysqli_num_rows($result_lista2);

if ($numero_lista2 == 0) {
$frameNomina = '<div class="alert alert-danger text-center mb-0" role="alert">
No has subido los recibos de aguinaldo del personal de '.$Titulo.'
</div>';

$BtnSubir = '<div class="col-12">
<button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="SubirAguinaldos(0,'.$idEstacion.','.$year.','.$mes.','.$SemQui.',\''.$descripcion.'\')">
<span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
</div>';

$BtnFinalizar = '';

}else{

while($row_lista2 = mysqli_fetch_array($result_lista2, MYSQLI_ASSOC)){
$GET_idAguinaldo = $row_lista2['id'];
$doc_nomina_aguinaldo = $row_lista2['doc_nomina_aguinaldo'];
$status_aguinaldo = $row_lista2['status'];

}
    
$frameNomina = '<iframe class="border-0" src="'.RUTA_ARCHIVOS.'/recibos-nomina-v2/recibos-mexdesa/'.$doc_nomina_aguinaldo.'" width="100%" height="400px"></iframe>';

$BtnSubir = '<div class="col-12">
<button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="SubirAguinaldos('.$GET_idAguinaldo.','.$idEstacion.','.$year.','.$mes.','.$SemQui.',\''.$descripcion.'\')">
<span class="btn-label2"><i class="fa fa-check"></i></span>Editar</button>
</div>';


if($status_aguinaldo == 0){
$BtnFinalizar = '<button type="button" class="btn btn-labeled2 btn-success" onclick="FinalizarAguinaldo('.$GET_idAguinaldo.','.$idEstacion.','.$year.','.$mes.','.$SemQui.',\''.$descripcion.'\')">
<span class="btn-label2"><i class="fa fa-check"></i></span>Finalizar</button>';

}else{
$BtnFinalizar = '';

}

}

?>


<div class="modal-header">
<h5 class="modal-title">Aguinaldos - <?=$Titulo?></h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
<button type="button" class="btn btn-labeled2 btn-danger" data-bs-dismiss="modal">
<span class="btn-label2"><i class="fa-solid fa-xmark"></i></span>Cerrar</button>

<?=$BtnFinalizar?>
</div>
