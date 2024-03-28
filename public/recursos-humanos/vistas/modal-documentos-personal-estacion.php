<?php
require('../../../app/help.php');

$idPersonal = $_GET['idPersonal'];

$sql_personal = "SELECT
op_rh_personal.id,
op_rh_personal.id_estacion,
op_rh_personal.nombre_completo,
op_rh_personal.puesto AS idPuesto,
op_rh_personal.curp,
op_rh_personal.sd,
op_rh_puestos.puesto,
op_rh_personal.documentos,
op_rh_personal.estado
FROM op_rh_personal
INNER JOIN op_rh_puestos 
ON op_rh_personal.puesto = op_rh_puestos.id
WHERE op_rh_personal.id = '".$idPersonal."' ";

$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);
while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
$NombreCompleto = $row_personal['nombre_completo'];
$Documento = $row_personal['documentos'];

if($row_personal['documentos'] == ""){
$Documentos = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Archivos">';
}else{
$Documentos = '<a href="archivos/'.$Documento.'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Archivos"></a>';	
}

}
 
$sql_lista = "SELECT * FROM op_rh_personal_documentos WHERE id_personal = '".$idPersonal."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
?>
<script type="text/javascript">
 $(document).ready(function($){
  $('[data-toggle="tooltip"]').tooltip(); 

  })	
</script>

<div class="modal-header">
<h5 class="modal-title">Documentos - <?=$NombreCompleto;?></h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">



<div class="row">

 <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">    
<label class="text-secondary mb-1">* Documento</label>
<select class="form-select" id="Documento">
<option></option>
<option>Documentos Personales</option>
<option>Constancia Fiscal</option>
</select>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">    
<label class="text-secondary mb-1">* Archivo</label><br>
<input class="form-control" type="file" id="Archivo">
</div>

<div class="col-12 mb-1">
<hr>
<div class="border">
<div class="p-3">

<div class="text-end">
<button type="button" class="btn btn-sm btn-primary" onclick="AgregarDocumento(<?=$idPersonal;?>)">Agregar documento</button>
</div>
 
<hr>

<table class="table table-sm table-bordered table-hover" style="font-size: .9em;">
<thead>
<tr>
<th class="text-center align-middle">Detalle</th>
<th class="text-center align-middle" width="24">
<img src="<?=RUTA_IMG_ICONOS;?>pdf.png">
</th>
<th class="text-center align-middle" width="24">
<img src="<?=RUTA_IMG_ICONOS;?>eliminar.png">
</th>
</tr>
</thead> 
<tbody>
<tr>
<td>Documentos Personales</td>
<td><?=$Documentos;?></td>
<td><a><img class="pointer" src="<?=RUTA_IMG_ICONOS;?>/eliminar.png" data-toggle="tooltip" data-placement="top" title="Eliminar" onclick="Eliminar(1,<?=$idPersonal;?>, <?=$idPersonal;?>)" id="Eliminar<?=$idPersonal;?>"></a></td>
</tr>
<?php
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
echo '<tr>
<td>'.$row_lista['detalle'].'</td>
<td><a href="archivos/'.$row_lista['documento'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'/pdf.png" data-toggle="tooltip" data-placement="top" title="Archivos"></a></td>
<td><a><img class="pointer" src="'.RUTA_IMG_ICONOS.'/eliminar.png" data-toggle="tooltip" data-placement="top" title="Eliminar" onclick="Eliminar(2,'.$id.', '.$idPersonal.')" id="Eliminar'.$id.'"></a></td>
</tr>';	
}
?>
</tbody>
</table>

</div>
</div>
</div>
</div>

<hr>


<div class="border mb-3">
<div class="p-3">

<div class="text-danger"><b>3.1 En caso de ser colaboradores nuevos y recientes</b></div>
<hr>

* Documentos:
<ol>
<li>Requisición de personal.</li>
<li>Solicitud de empleo (a puño y letra).</li>
<li>Identificación oficial (vigente, elector o pasaporte).</li>
<li>Acta de nacimiento (certificada).</li>
<li>Comprobante de domicilio (Recibo de tel., agua o predio, con antigüedad máxima de tres meses).</li>
<li>Ultimo comprobante de estudios.</li>
<li>Cartas de recomendaciones de últimos empleos (hoja membretada con dirección y teléfono).</li>
<li>Aviso de retención de Infonavit.</li>
<li>Carta de antecedentes no penales (solo para despachadores).</li>
</ol>

</div>
</div>

<div class="border">
<div class="p-3">
<div class="text-danger"><b>3.2 Colaboradores con antigüedad mínima de 1 año</b></div>
<hr>
<ol>
<li>INE.</li>
<li>Comprobante de domicilio.</li>
<li>Comprobante afiliación IMSS.</li>
<li>CURP.</li>
<li>RFC.</li>
</ol>

</div>
</div>
 
</div>

<!--
<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="AgregarPersonal()">Agregar personal</button>
</div>
-->
