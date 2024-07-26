 <?php 
require ('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];

?>

<div class="modal-header">
<h5 class="modal-title">Reporte asistencia</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="row">

<div class="col-12 mb-2 my-0">
<label for="lblNombreGrupo" class="col-form-label  fs-6">* Año:</label>
<select class="form-select rounded-0  fs-6" id="Year">
<option value="">Selecciona</option>
<?php
$YearReporte = date("Y");
for ($i = 2022; $i <= $YearReporte; $i++) {
echo '<option value="'.$i.'">'.$i.'</option>';
}
?>
</select>
</div>

<div class="col-12 mb-2">
<label for="lblNombreGrupo" class="col-form-label fs-6">* Mes:</label>
<select class="form-select rounded-0 fs-6" id="Mes">
<option value="">Selecciona</option>
<option value="1">Enero</option>
<option value="2">Febrero</option>
<option value="3">Marzo</option>
<option value="4">Abril</option>
<option value="5">Mayo</option>
<option value="6">Junio</option>
<option value="7">Julio</option>
<option value="8">Agosto</option>
<option value="9">Septiembre</option>
<option value="10">Octubre</option>
<option value="11">Noviembre</option>
<option value="12">Diciembre</option>
</select>
</div>


</div>

<div class="mt-1" id="MensajeReporte"></div>

</div>


<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="btnBuscar(<?=$idEstacion;?>)">
<span class="btn-label2"><i class="fa fa-search"></i></span>Buscar</button>
</div>

