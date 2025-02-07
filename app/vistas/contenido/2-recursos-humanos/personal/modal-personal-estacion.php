<?php
require('../../../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$idPersonal = $_GET['idPersonal'];
$Tipo = $_GET['Tipo'];

$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($idEstacion);
$estacion = $datosEstacion['localidad'];


if($Tipo == 0){ 
$Titulo = "Agregar personal";
$ocultarDivs = "d-none";
$columnaDiv1 = "col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2";
$columnaDiv2 = "col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-2";
$ocultarDivs2 = "";
$btnAccion = '<button type="button" class="btn btn-labeled2 btn-success" onclick="personalRecursosHumanos('.$idEstacion.','.$idPersonal.','.$Tipo.')"><span class="btn-label2"><i class="fa fa-check"></i></span>'.$Titulo.'</button>';


$datosPersonal = "";
$no_colaborador = "";
$nombrecompleto = "";
$idPuesto = "";
$puesto = "";
$sd = "";
$fechaingreso = "";

}else{
$Titulo = "Editar personal";
$ocultarDivs = "";

if($session_nompuesto == "Dirección de operaciones" || $session_nompuesto == "Dirección de operaciones servicio social" || $Session_IDUsuarioBD == 2){
$columnaDiv1 = "col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2";
$columnaDiv2 = "col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-2";
}else{
$columnaDiv1 = "col-xl-7 col-lg-7 col-md-12 col-sm-12 mb-2";
$columnaDiv2 = "col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-2";
}

$ocultarDivs2 = "d-none";

$btnAccion = '<button type="button" class="btn btn-labeled2 btn-success" onclick="personalRecursosHumanos('.$idEstacion.','.$idPersonal.','.$Tipo.')"><span class="btn-label2"><i class="fa fa-check"></i></span>'.$Titulo.'</button>';
$datosPersonal = $ClassHerramientasDptoOperativo->obtenerDatosPersonal($idPersonal);
$no_colaborador = $datosPersonal['no_colaborador'];
$nombrecompleto = $datosPersonal['nombre_personal'];
$idPuesto = $datosPersonal['idPuesto'];
$puesto = $datosPersonal['puesto'];
$sd = $datosPersonal['salario'];
$fechaingreso = $datosPersonal['fecha_ingreso'];

}

if($session_nompuesto == "Dirección de operaciones" || $session_nompuesto == "Dirección de operaciones servicio social" || $Session_IDUsuarioBD == 2){
$ocultarOpcion = "";
}else{
$ocultarOpcion = "d-none";	
}

?>

<div class="modal-header">
<h5 class="modal-title"><?=$Titulo?> (<?=$estacion?>)</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="row">
 
<div class="col-12 mb-3">
<div class="border p-3">
<h6>INFORMACIÓN PERSONAL</h6>
<hr>

<div class="row">

<div class="col-12 mb-2">
<label class="text-secondary fw-bold">* FECHA INGRESO:</label>
<input type="date" class="form-control rounded-0" id="FechaIngreso" value="<?=$fechaingreso;?>">
</div>

<div class="col-12 mb-2 <?=$ocultarOpcion?>">
<label class="text-secondary fw-bold">NO. DE COLABORADOR:</label>
<input type="number" class="form-control rounded-0" id="NoColaborador" value="<?=$no_colaborador;?>">
</div>

<div class="<?=$columnaDiv1?> mb-2">
<label class="text-secondary fw-bold">* NOMBRE COMPLETO:</label>
<input type="text" class="form-control rounded-0" id="NombresCompleto" value="<?=$nombrecompleto;?>">
</div>
 
<div class="<?=$columnaDiv2?> mb-2">
<label class="text-secondary fw-bold">* PUESTO</label>
<select class="form-select rounded-0" id="Puesto" onchange="PuestoDiv()">
<option value="<?=$idPuesto;?>"><?=$puesto;?></option>
<?php 
$sql_puesto = "SELECT id, puesto FROM op_rh_puestos ";
$result_puesto = mysqli_query($con, $sql_puesto);
while($row_puesto = mysqli_fetch_array($result_puesto, MYSQLI_ASSOC)){
echo '<option value='.$row_puesto['id'].'>'.$row_puesto['puesto'].'</option>';
}
?> 
</select>
</div>  
 
<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-2 <?=$ocultarOpcion?>">
<label class="text-secondary">SALARIO DIARIO:</label>
<input type="number" class="form-control rounded-0" id="sd" value="<?=$sd;?>">
</div>
	
</div>
	
</div>
</div> 


<!---------- DOCUMENTACION PERSONAL ---------->
<div class="col-12 mb-3">
<div class="border p-3">
<h6>DOCUMENTACIÓN</h6>
<hr>

<div class="row">

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
<label class="text-secondary">REQUISICIÓN DEL PERSONAL:</label>
<input type="file" class="form-control rounded-0" id="R_Personal">
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
<label class="text-secondary">SOLICITUD DE EMPLEO Y/O CURRICULUM VITAE (CV):</label>
<input type="file" class="form-control rounded-0" id="CV">
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
<label class="text-secondary">IDENTIFICAIÓN OFICIAL (VIGENTE, ELECTOR O PASAPORTE):</label>
<input type="file" class="form-control rounded-0" id="INE">
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
<label class="text-secondary">ACTA DE NACIMIENTO (CERTIFICADA):</label>
<input type="file" class="form-control rounded-0" id="A_Nacimiento">
</div>

<div class="col-12 mb-3">
<label class="text-secondary">COMPROBANTE DE DOMICILIO (RECIBO DE TELÉFONO, AGUA, O PREDIO CON ANTIGUEDAD MÁXIMA DE TRES MESES):</label>
<input type="file" class="form-control rounded-0" id="C_Domicilio">
</div>

<div class="col-12 mb-3">
<label class="text-secondary">COMPROBANTE DE AFILIACIÓN IMSS (EN CASO DE NO TENER, PRESENTAR AFILIACIÓN):</label>
<input type="file" class="form-control rounded-0" id="C_IMSS">
</div>

<div class="col-12 mb-3">
<label class="text-secondary">CARTAS DE RECOMENDACIÓN DE LOS ÚLTIMOS EMPLEOS (HOJA MEMBRETADA CON DIRECCIÓN Y TELÉFONO):</label>
<input type="file" class="form-control rounded-0" id="C_Recomendacion">
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
<label class="text-secondary">ULTIMO COMPROBANTE DE ESTUDIOS:</label>
<input type="file" class="form-control rounded-0" id="C_Estudios">
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
<label class="text-secondary">CLAVE ÚNICA DE REGISTRO DE POBLACIÓN (CURP):</label>
<input type="file" class="form-control rounded-0" id="CURP">
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
<label class="text-secondary">AVISO DE RETENCIÓN DE INFONAVIT:</label>
<input type="file" class="form-control rounded-0" id="A_Infonavit">
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
<label class="text-secondary">CONSTANCIA DE SITUACIÓN FISCAL (CSF) CON HOMOCLAVE:</label>
<input type="file" class="form-control rounded-0" id="RFC">
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3" id="Cartas_Penales">
<label class="text-secondary">CARTA DE ANTECEDENTES NO PENALES:</label>
<input type="file" class="form-control rounded-0" id="C_Antecedentes">
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
<label class="text-secondary">CONTRATO:</label>
<input type="file" class="form-control rounded-0" id="Contrato">
</div>

</div>
</div>
</div>

<div class="col-12 <?=$ocultarDivs2?>">
<div class="border ">
<div class="p-3">

<div class="text-danger"><b>EN CASO DE SER COLABORADORES NUEVOS Y RECIENTES.</b></div>
<hr>
<ol>
<li>Requisición de personal.</li>
<li>Solicitud de empleo (a puño y letra, unicamente despachadores) y/o Curriculum Vitae .</li>
<li>Identificación oficial (vigente, elector o pasaporte).</li>
<li>Acta de Nacimiento (Certificada).</li>
<li>Comprobante de Domicilio (recibo de teléfono, agua, o predio con antigüedad máxima de tres meses).</li>
<li>Comprobante de Afiliación IMSS (en caso de no tener, presentar afiliación).</li>
<li>Ultimo comprobante de estudios.</li>
<li>Cartas de Recomendación de los últimos empleos (Hoja membretada con dirección y teléfono).</li>
<li>Clave Única de Registro de Población (CURP).</li>
<li>Aviso de Retención de Infonavit.</li>
<li>Constancia de Situación Fiscal (CSF) con homoclave.</li>
<li>Carta de antecedentes no penales (solo despachadores).</li>
</ol>

</div>
</div>

</div>

</div>
</div> 

<div class="modal-footer">
<?=$btnAccion?>
</div>

 