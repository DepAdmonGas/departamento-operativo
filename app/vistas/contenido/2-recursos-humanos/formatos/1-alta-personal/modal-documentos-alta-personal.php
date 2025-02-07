<?php 
require('../../../../../../app/help.php');
$idReporte = $_GET['idReporte'];
$idUsuario = $_GET['idUsuario'];
$idTipo = $_GET['idTipo'];
$formato = $_GET['formato'];

$sql_lista = "SELECT * FROM op_rh_formatos_alta WHERE id = '" . $idUsuario . "' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
$nombre = $row_lista['nombre'];
$idPuesto = $row_lista['puesto'];

$fecha_ingreso = FormatoFecha(fechaFormato: $row_lista['fecha_ingreso']);
$curriculum = $row_lista['curriculum'];
$ine = $row_lista['ine'];
$acta_nacimiento = $row_lista['acta_nacimiento'];
$nss = $row_lista['nss'];
$c_domicilio = $row_lista['c_domicilio'];
$c_estudios = $row_lista['c_estudios'];
$c_recomendacion = $row_lista['c_recomendacion'];
$curp = $row_lista['curp'];
$rfc = $row_lista['rfc'];
$c_antecedentes = $row_lista['c_antecedentes'];
$a_infonavit = $row_lista['a_infonavit'];
}

$detallecurriculum = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/curriculum/', $curriculum, 'Curriculum Vitae');
$detalleIne = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/ine/', $ine, 'Identificación Oficial');
$detalleacta = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/acta_nacimiento/', $acta_nacimiento, 'Acta de Nacimiento');
$detalleNss = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/nss/', $nss, 'Comprobante de Afiliación del IMSS');
$detallec_domicilio = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/comprobante_domicilio/', $c_domicilio, 'Comprobante de Domicilio');
$detallec_estudios = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/comprobante_estudios/', $c_estudios, 'Comprobante de Estudios');
$detallec_recomendacion = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/cartas_recomendacion/', $c_recomendacion, 'Cartas de Recomendación');
$detalleCurp = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/curp/', $curp, 'Clave Única de Registro de Población (CURP)');
$detalleRfc = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/rfc/', $rfc, 'Constancia de Situación Fiscal (CSF)');
$detallec_antecedentes = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/carta_antecedentes/', $c_antecedentes, 'Carta de Antecedentes No Penales');
$detallea_infonavit = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/acta_infonavit/', $a_infonavit, 'Aviso de Retención de Infonavit');

if($idPuesto == 4){
$ocultarTR = "";
}else{
$ocultarTR = "d-none";
}

?>


<div class="modal-header">
<h5 class="modal-title">Documentación personal</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
<div class="row">
  
<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="fw-bold text-secondary">Nombre del empleado:</div>
<?=$nombre;?>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="fw-bold text-secondary">Fecha de ingreso:</div>
<?=$fecha_ingreso;?>
</div>

<!--
<div class="col-12"> 
<div class="fw-bold text-secondary mb-1">Nombre del documento:</div>
<select class="form-select" id="selDocumento">
<option value=""></option>
<option value="1">Solicitud de empleo</option>
<option value="2">Identificción oficial vigente (INE O PASAPORTE)</option>
<option value="3">Acta de nacimiento</option>
<option value="4">Comprobante de afiliación IMSS</option>
<option value="5">Comprobante de domicilio (Recibo de teléfono, agua o predio con antigüedad máxima de tres meses)</option>
<option value="6">Ultimo comprobante de estudios</option>
<option value="7">Cartas de recomendación</option>
<option value="8">Clave Única de Registro de Población (CURP)</option>
<option value="9">Constancia de Situacion Fiscal (CSF) con Homoclave</option>
<option value="10" class="<?=$ocultarTR?>">Carta de Antecedentes No Penales</option>
<option value="11">Aviso de Retención de Infonavit</option>
</select>
</div>


<div class="col-12 mt-2">
<div class="fw-bold text-secondary mb-1">Documento (PDF):</div>
<input type="file" class="form-control rounded-0" id="documentoPDF">
</div>

<div class="col-12 mt-3 pb-0"> 
<button type="button" class="btn btn-labeled2 btn-success float-end" onclick="editarDocumentoPersonal(<?=$idUsuario?>,<?=$idReporte?>)"><span class="btn-label2"><i class="fa fa-check"></i></span>Editar documento</button>
</div>
-->

<div class="col-12 mt-2"> 
<div class="table-responsive">
<table id="tabla-principal" class="custom-table " width="100%">

<thead class="tables-bg">
<th class="text-start align-middle">Nombre del documento</th>
<th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>pdf.png"></th>
</thead>

<tbody class="bg-light">
<tr>
<td class="align-middle text-start">Solicitud de empleo</td>
<td class="align-middle text-center"><?=$detallecurriculum?></td>
</tr>

<tr>
<td class="align-middle text-start">Identificción oficial vigente (INE O PASAPORTE)</td>
<td class="align-middle text-center"><?=$detalleIne?></td>
</tr>

<tr>
<td class="align-middle text-start">Acta de nacimiento</td>
<td class="align-middle text-center"><?=$detalleacta?></td>
</tr>

<tr>
<td class="align-middle text-start">Comprobante de afiliación IMSS</td>
<td class="align-middle text-center"><?=$detalleNss?></td>
</tr>

<tr>
<td class="align-middle text-start">Comprobante de domicilio (Recibo de teléfono, agua o predio con antigüedad máxima de tres meses)</td>
<td class="align-middle text-center"><?=$detallec_domicilio?></td>
</tr>

<tr>
<td class="align-middle text-start">Ultimo comprobante de estudios</td>
<td class="align-middle text-center"><?=$detallec_estudios?></td>
</tr>

<tr>
<td class="align-middle text-start">Cartas de recomendación</td>
<td class="align-middle text-center"><?=$detallec_recomendacion?></td>
</tr>

<tr>
<td class="align-middle text-start">Clave Única de Registro de Población (CURP)</td>
<td class="align-middle text-center"><?=$detalleCurp?></td>
</tr>

<tr>
<td class="align-middle text-start">Constancia de Situacion Fiscal (CSF) con Homoclave</td>
<td class="align-middle text-center"><?=$detalleRfc?></td>
</tr>

<tr class="<?=$ocultarTR?>">
<td class="align-middle text-start">Carta de Antecedentes No Penales</td>
<td class="align-middle text-center"><?=$detallec_antecedentes?></td>
</tr>

<tr>
<td class="align-middle text-start">Aviso de Retención de Infonavit</td>
<td class="align-middle text-center"><?=$detallea_infonavit?></td>
</tr>

</tbody>

</table>
</div>
</div>

</div>
</div>
 

<?php if($idTipo == 1){?>
<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-danger float-end" onclick="RegresarFormulario(<?=$idReporte?>,<?=$formato?>)"><span class="btn-label2"><i class="fa-solid fa-arrow-left"></i></span>Regresar</button>
</div>
<?php } ?>