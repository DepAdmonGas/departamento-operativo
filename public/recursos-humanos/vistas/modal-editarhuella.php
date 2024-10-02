<?php 
require ('../../../app/help.php');
$id = $_GET['id'];
$idEstacion = $_GET['idEstacion']; 

$sql_empresa = "SELECT * FROM op_rh_localidades_perfil WHERE id = '".$id."' ";
$result_empresa = mysqli_query($con, $sql_empresa);
$numero_empresa = mysqli_num_rows($result_empresa);

while($row_empresa = mysqli_fetch_array($result_empresa, MYSQLI_ASSOC)){

$usuario =  $ClassEncriptar->decrypt($row_empresa['usuario']);
$password =  $ClassEncriptar->decrypt($row_empresa['password']);

}
?>

<div class="modal-header">
<h5 class="modal-title">Editar (Sensor de huella)</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">

<div class="form-group">

<label for="lblNombreGrupo" class="col-form-label text-secondary fw-bold">* USUARIO:</label>
<input type="text" id="txtUsuario" class="form-control rounded-0 " autocomplete="off" value="<?=$usuario?>">

<label for="lblNombreGrupo" class="col-form-label text-secondary fw-bold">* CONTRASEÑA:</label>
<input type="text" id="txtPassword" class="form-control rounded-0 mb-3" autocomplete="off"
onkeyup="validatePassword(this.value)" value="<?=$password?>">

<div class="text-secondary border p-3 mb-3">
<small>
<b>LA CONTRASEÑA DEBE DE CONTENER:</b>
<hr>Al menos 1 letra mayuscula
<br>Al menos 1 letra minuscula
<br>Al menos 1 digito
<br>Minimo 8 caracteres.
</small>
</div>

<label for="lblNombreGrupo" class="col-form-label fw-bolf text-secondary fw-bold">* VALIDA CONTRASEÑA:</label>
<input type="password" id="txtValidaPassword" class="form-control rounded-0" autocomplete="off">

</div>

</div>



<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="btnEditarPerfil(<?=$id;?>, <?=$idEstacion;?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
</div>