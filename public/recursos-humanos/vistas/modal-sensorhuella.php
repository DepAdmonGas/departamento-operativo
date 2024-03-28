 <?php 
require ('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];

?>

<div class="modal-header">
<h5 class="modal-title">Agregar Usuario y Contraseña</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
 

<div class="modal-body">

<div class="form-group">


<div class="form-group">
<label for="lblNombreGrupo" class="col-form-label fw-lighter fs-6">* Usuario:</label>
<input type="text" id="txtUsuario" class="form-control rounded-0 fw-lighter fs-5" placeholder="Usuario" autocomplete="off">
</div>

<div class="form-group">
<label for="lblNombreGrupo" class="col-form-label fw-lighter fs-6">* Contraseña:</label>
<input type="text" id="txtPassword" class="form-control rounded-0 fw-lighter fs-5" placeholder="Contraseña" autocomplete="off"
onkeyup="validatePassword(this.value)">
</div>

<div class="fw-lighter text-secondary"><small>
<b>La contraseña debe de contener:</b>
<br>Al menos 1 letra mayuscula
<br>Al menos 1 letra minuscula
<br>Al menos 1 digito
<br>Minimo 8 caracteres.
</small>
</div>

<div class="form-group">
<label for="lblNombreGrupo" class="col-form-label fw-lighter fs-6">* Valida Contraseña:</label>
<input type="password" id="txtValidaPassword" class="form-control rounded-0 fw-lighter fs-5" placeholder="Contraseña" autocomplete="off">
</div>

</div>
</div>

<div class="" id="resultadoModal"></div>

<div class="modal-footer">
<button type="button" class="btn btn-primary rounded-0 fw-lighter fs-6" onclick="btnAgregarHuella(<?=$idEstacion;?>)">Guardar</button>
</div>