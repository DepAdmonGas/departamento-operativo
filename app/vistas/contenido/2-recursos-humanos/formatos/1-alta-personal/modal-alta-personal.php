<?php 
require('../../../../../../app/help.php');
$idReporte = $_GET['idReporte'];
$idEstacion = $_GET['idEstacion'];

?>

<script>
    // Seleccionar el elemento del select y el div a mostrar
    const puestoSelect = document.getElementById("Puesto");
    const cartasPenalesDiv = document.getElementById("Cartas_Penales");

    // Agregar evento de cambio al select
    puestoSelect.addEventListener("change", function() {
        // Obtener el valor seleccionado
        const selectedValue = puestoSelect.value;

        // Mostrar u ocultar el div según el valor seleccionado
        if (selectedValue === "4") {
            cartasPenalesDiv.style.display = "block"; // Mostrar el div
        } else {
            cartasPenalesDiv.style.display = "none"; // Ocultar el div
        }
    });
</script>


<div class="modal-header">
<h5 class="modal-title">Agregar personal</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
<div class="row">

<div class="col-12 mb-2">
<div class="fw-bold text-secondary mb-1">* NOMBRE COMPLETO:</div>
<input type="text" class="form-control rounded-0" id="NombresCompleto">
</div>
 
<div class="col-12 mb-2">
<div class="fw-bold text-secondary mb-1">* PUESTO:</div>
<select class="form-select rounded-0" id="Puesto">
<option value="">Selecciona una opción...</option>
<?php 
$sql_puesto = "SELECT id, puesto FROM op_rh_puestos ";
$result_puesto = mysqli_query($con, $sql_puesto);
while($row_puesto = mysqli_fetch_array($result_puesto, MYSQLI_ASSOC)){
echo '<option value='.$row_puesto['id'].'>'.$row_puesto['puesto'].'</option>';
}
?> 
</select>
</div>   
  
<div class="col-12 mb-3">
<div class="fw-bold text-secondary mb-1">* FECHA DE ALTA:</div>
<input type="date" class="form-control rounded-0" id="FechaIngreso">
</div>

<div class="col-12">
<div class="fw-bold text-secondary mb-1">* SALARIO DIARIO:</div>
<input type="number" class="form-control rounded-0" id="sd" >
</div>
	
<div class="col-12 mt-3">
<div class="alert alert-primary" role="alert">
Documentacion a anexar
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
<div class="fw-bold text-secondary mb-1">* SOLICITUD DE EMPLEO:</div>
<input type="file" class="form-control rounded-0" id="CV">
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
<div class="fw-bold text-secondary mb-1">* IDENTIFICACIÓN OFICIAL VIGENTE (INE O PASAPORTE):</div>
<input type="file" class="form-control rounded-0" id="INE">
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
<div class="fw-bold text-secondary mb-1">* ACTA DE NACIMIENTO:</div>
<input type="file" class="form-control rounded-0" id="A_Nacimiento">
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
<div class="fw-bold text-secondary mb-1">* COMPROBANTE DE AFILIACIÓN IMSS:</div>
<input type="file" class="form-control rounded-0" id="C_IMSS">
</div>

<div class="col-12 mb-3">
<div class="fw-bold text-secondary mb-1">* COMPROBANTE DE DOMICILIO (RECIBO DE TELÉFONO, AGUA O PREDIO CON ANTIGüEDAD MÁXIMA DE TRES MESES):</div>
<input type="file" class="form-control rounded-0" id="C_Domicilio">
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
<div class="fw-bold text-secondary mb-1">* ULTIMO COMPROBANTE DE ESTUDIOS:</div>
<input type="file" class="form-control rounded-0" id="C_Estudios">
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
<div class="fw-bold text-secondary mb-1">* CARTAS DE RECOMENDACIÓN:</div>
<input type="file" class="form-control rounded-0" id="C_Recomendacion">
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
<label class="fw-bold text-secondary mb-1">* CLAVE ÚNICA DE REGISTRO DE POBLACIÓN (CURP):</label>
<input type="file" class="form-control rounded-0" id="CURP">
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
<label class="fw-bold text-secondary mb-1">* CONSTANCIA DE SITUACIÓN FISCAL (CSF) CON HOMOCLAVE:</label>
<input type="file" class="form-control rounded-0" id="RFC">
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3" id="Cartas_Penales" style="display: none;">
<label class="fw-bold text-secondary mb-1">* CARTA DE ANTECEDENTES NO PENALES:</label>
<input type="file" class="form-control rounded-0" id="C_Antecedentes">
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
<label class="text-secondary">AVISO DE RETENCIÓN DE INFONAVIT (Opcional):</label>
<input type="file" class="form-control rounded-0" id="A_Infonavit">
</div>

</div>
</div>

<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="agregarPersonal(<?=$idReporte?>,<?=$idEstacion?>)"><span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
</div>


