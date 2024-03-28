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
 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
<div class="form-group">


<div class="form-group">
<label for="lblNombreGrupo" class="col-form-label fw-lighter fs-6">* Usuario:</label>
<?php echo "<input type='text' id='txtUsuario' class='form-control rounded-0 fw-lighter fs-5' placeholder='Usuario' autocomplete='off' value='".$usuario."'>" ;?>
</div>

<div class="form-group">
<label for="lblNombreGrupo" class="col-form-label fw-lighter fs-6">* Contraseña:</label>
<?php echo "<input type='text' id='txtPassword' class='form-control rounded-0 fw-lighter fs-5' placeholder='Contraseña' autocomplete='off' value='".$password."'>" ;?>

<div class="fw-lighter text-secondary"><small>
<b>La contraseña debe de contener:</b>
<br>Al menos 1 letra mayuscula
<br>Al menos 1 letra minuscula
<br>Al menos 1 digito
<br>Minimo 8 caracteres.
</small>
</div>
</div>

<div class="form-group">
<label for="lblNombreGrupo" class="col-form-label fw-lighter fs-6">* Valida Contraseña:</label>
<input type="password" id="txtValidaPassword" class="form-control rounded-0 fw-lighter fs-5" placeholder="Contraseña" autocomplete="off">
</div>


</div>
</div>

</div>
</div>

<div class="" id="resultadoModal"></div>

<div class="modal-footer">
<button type="button" class="btn btn-primary rounded-0 fw-lighter fs-6" onclick="btnEditarPerfil(<?=$id;?>, <?=$idEstacion;?>)">Guardar</button>
</div>