 <?php 
require ('../../../app/help.php');

$idPuesto = $_GET['idPuesto'];
$Tipo = $_GET['Tipo'];

$puesto = "";

$sql_empresa = "SELECT * FROM op_rh_puestos WHERE id = '".$idPuesto."' ";
$result_empresa = mysqli_query($con, $sql_empresa);
$numero_empresa = mysqli_num_rows($result_empresa);
while($row_empresa = mysqli_fetch_array($result_empresa, MYSQLI_ASSOC)){ 
$puesto = $row_empresa['puesto'];
}

if($Tipo == 0){
$Titulo = "Guardar";
}else if($Tipo == 1){
$Titulo = "Editar";
}
?>

<div class="modal-header">
<h5 class="modal-title"><?=$Titulo;?></h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<label class="text-secondary mb-1">* Puesto</label>
<textarea class="form-control titulos" id="NomPuesto"><?=$puesto;?></textarea>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="CrearPuesto(<?=$idPuesto;?>,<?=$Tipo;?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span><?=$Titulo;?></button>

</div>