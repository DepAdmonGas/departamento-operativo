 <?php 
require ('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$idHorario = $_GET['idHorario'];
$Tipo = $_GET['Tipo'];

$sql_empresa = "SELECT * FROM op_rh_localidades_horario WHERE id = '".$idHorario."' ";
$result_empresa = mysqli_query($con, $sql_empresa);
$numero_empresa = mysqli_num_rows($result_empresa);
while($row_empresa = mysqli_fetch_array($result_empresa, MYSQLI_ASSOC)){ 
$titulo = $row_empresa['titulo'];
$horaentrada = $row_empresa['hora_entrada'];
$horasalida = $row_empresa['hora_salida'];
}

if($Tipo == 0){
$Titulo = "Agregar horario";
}else if($Tipo == 1){
$Titulo = "Editar horario";
}
?>

<div class="modal-header">
<h5 class="modal-title"><?=$Titulo;?></h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<label class="text-secondary mb-1">* Titulo</label>
<textarea class="form-control" id="Titulo"><?=$titulo;?></textarea>

<label class="text-secondary mt-2 mb-1">* Hora entrada</label>
<input type="time" id="HoraEntrada" class="form-control" value="<?=$horaentrada;?>">
<label class="text-secondary mt-2 mb-1">* Hora salida</label>
<input type="time" id="HoraSalida" class="form-control" value="<?=$horasalida;?>">

</div>

<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="Horario(<?=$idEstacion;?>,<?=$idHorario;?>,<?=$Tipo;?>)"><?=$Titulo;?></button>
</div>