 <?php 
require ('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($idEstacion);


$idHorario = $_GET['idHorario'];
$Tipo = $_GET['Tipo'];
$titulo = "";

$sql_empresa = "SELECT * FROM op_rh_localidades_horario WHERE id = '".$idHorario."' ";
$result_empresa = mysqli_query($con, $sql_empresa);
$numero_empresa = mysqli_num_rows($result_empresa);
while($row_empresa = mysqli_fetch_array($result_empresa, MYSQLI_ASSOC)){ 
$titulo = $row_empresa['titulo'];
$horaentrada = $row_empresa['hora_entrada'];
$horasalida = $row_empresa['hora_salida'];
}

if($Tipo == 0){
$Titulo = "Guardar";
}else if($Tipo == 1){
$Titulo = "Editar";
}
?>

<div class="modal-header">
<h5 class="modal-title"><?=$Titulo;?> horario - <?=$datosEstacion['localidad']?></h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<h6 class="mb-1 fw-bold text-secondary">* TITULO </h6>
<textarea class="form-control" id="Titulo"><?=$titulo;?></textarea>

<h6 class="mt-2 mb-1 fw-bold text-secondary">* HORA ENTRADA</h6>
<input type="time" id="HoraEntrada" class="form-control" value="<?=$horaentrada;?>">
<h6 class="mt-2 mb-1 fw-bold text-secondary">* HORA SALIDA</h6>
<input type="time" id="HoraSalida" class="form-control" value="<?=$horasalida;?>">

</div>

<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="Horario(<?=$idEstacion;?>,<?=$idHorario;?>,<?=$Tipo;?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span><?=$Titulo;?></button>

</div>