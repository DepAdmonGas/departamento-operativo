<?php 
require ('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];
$tipo = $_GET['tipo'];

?>

<div class="modal-header">
<h5 class="modal-title">Busqueda</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="row">

<div class="col-12 mb-2 my-0">
<label for="lblNombreGrupo" class="col-form-label  fs-6">* Año:</label>
<select class="form-select rounded-0  fs-6" id="years">
<option value="">Selecciona el año...</option>
<?php
$YearReporte = date("Y");
for ($i = 2020; $i <= $YearReporte; $i++) {
echo '<option value="'.$i.'">'.$i.'</option>';
}
?>
</select>
</div>

</div>
 

<div class="mt-1" id="MensajeReporte"></div>

</div>


    <div class="modal-footer">
<button type="button" class="btn btn-primary rounded-0 fw-lighter fs-6" onclick="btnBuscar(<?=$idEstacion;?>,<?=$tipo;?>)">Buscar</button>
      </div>

