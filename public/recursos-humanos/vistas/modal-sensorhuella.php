 <?php 
require ('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];

?>

<div class="modal-header">
<h5 class="modal-title">Agregar Usuario y Contraseña</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
 

<div class="modal-body">

<div class="form-group">

<label for="lblNombreGrupo" class="col-form-label fw-bold text-secondary">* USUARIO:</label>
<input type="text" id="txtUsuario" class="form-control rounded-0 " autocomplete="off">

<label for="lblNombreGrupo" class="col-form-label fw-bold text-secondary">* CONTRASEÑA:</label>
<input type="text" id="txtPassword" class="form-control rounded-0 mb-3" autocomplete="off"
onkeyup="validatePassword(this.value)">

<div class="text-secondary border p-3 mb-3">
<small>
<b>LA CONTRASEÑA DEBE DE CONTENER:</b>
<hr>Al menos 1 letra mayuscula
<br>Al menos 1 letra minuscula
<br>Al menos 1 digito
<br>Minimo 8 caracteres.
</small>
</div>

<label for="lblNombreGrupo" class="col-form-label fw-bold text-secondary">* VALIDA CONTRASEÑA:</label>
<input type="password" id="txtValidaPassword" class="form-control rounded-0" autocomplete="off">

</div>

</div>


<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="btnAgregarHuella(<?=$idEstacion;?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
</div>