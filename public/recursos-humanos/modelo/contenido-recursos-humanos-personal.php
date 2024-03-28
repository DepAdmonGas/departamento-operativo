<?php 
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}
  
$sql_personal = "SELECT
op_rh_personal.id,
op_rh_personal.id_estacion,
op_rh_personal.fecha_ingreso,
op_rh_personal.no_colaborador,
op_rh_personal.nombre_completo,
op_rh_personal.puesto AS idPuesto,
op_rh_personal.ine,
op_rh_personal.curp,
op_rh_personal.rfc,
op_rh_personal.nss,
op_rh_personal.contrato,
op_rh_personal.sd,
op_rh_puestos.puesto,
op_rh_personal.documentos,
op_rh_personal.estado
FROM op_rh_personal
INNER JOIN op_rh_puestos 
ON op_rh_personal.puesto = op_rh_puestos.id 
WHERE op_rh_personal.id_estacion = '".$idEstacion."' AND op_rh_personal.estado = 1 ORDER BY op_rh_personal.no_colaborador ASC ";
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);


if($Session_IDUsuarioBD == 354){
$ocultartb = "";
}else{
$ocultartb = "d-none";	
}


if($session_nompuesto == "Dirección de operaciones" || $session_nompuesto == "Dirección de operaciones servicio social" || $Session_IDUsuarioBD == 2){
$ocultarOpcion = "";
}else{
$ocultarOpcion = "d-none";	
}


?>
<script type="text/javascript">
$(document).ready(function($){
$('[data-toggle="tooltip"]').tooltip();
});
</script>

  
<div class="border-0 p-3">

<div class="row">

<div class="col-11">
<h5><?=$estacion;?></h5>
</div>

<div class="col-1">


<img class="float-end pointer ms-2 <?=$ocultarOpcion?>" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="Mas(<?=$idEstacion;?>)">

<a class="ms-2 float-end " href="public/recursos-humanos/vistas/personal-excel.php?idEstacion=<?=$idEstacion;?>" download>
<img src="<?=RUTA_IMG_ICONOS;?>excel.png">
</a>

</div>
 
</div>

<hr>
 
   
<div class="table-responsive">
<table class="table table-sm table-bordered table-hover p-0 mb-0" style="font-size: .85em;">
<thead class="tables-bg">
	<tr class="text-center align-middle">
	<!-- <th >#</th> -->
	<th >No. <br>colaborador</th>
	<th class="align-middle">Fecha ingreso</th>
	<th class="align-middle">Nombre completo</th>
	<th class="align-middle">Puesto</th>
	<th class="align-middle">Documentos <br>Personales</th>
     <th class="align-middle">Identificacion <br>Oficial</th>
	<th class="align-middle">CURP</th>
	<th class="align-middle">RFC</th>
	<th class="align-middle">NSS</th>
	<th class="align-middle">Contrato</th>
	<th class="align-middle">SD</th>
	<th class="text-center align-middle" width="24"><img src="<?=RUTA_IMG_ICONOS;?>archivo-tb.png"></th>
	<th class="text-center align-middle" width="24"><img src="<?=RUTA_IMG_ICONOS;?>reloj-tb.png"></th>
	<th class="text-center align-middle" width="24"><img src="<?=RUTA_IMG_ICONOS;?>huella-dactilar-tb.png"></th>
	<th class="text-center align-middle" width="24"><img src="<?=RUTA_IMG_ICONOS;?>nomina-tb.png"></th>
	<th class="text-center align-middle <?=$ocultarOpcion?>" width="24"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
	<th class="text-center align-middle <?=$ocultartb?>" width="24"><img src="<?=RUTA_IMG_ICONOS;?>pago-tb.png"></th>
	<th class="text-center align-middle <?=$ocultarOpcion?>" width="24"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
	</tr>
</thead> 
<tbody>
<?php 
$num = 1;
if ($numero_personal > 0) {
while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
$id = $row_personal['id'];
$no_colaborador = $row_personal['no_colaborador'];

$ine = $row_personal['ine'];
$curp = $row_personal['curp'];
$rfc = $row_personal['rfc'];
$nss = $row_personal['nss'];
$Documento = $row_personal['documentos'];
$contrato = $row_personal['contrato'];


$extensionCurp = pathinfo($curp, PATHINFO_EXTENSION);
$extensionRfc = pathinfo($rfc, PATHINFO_EXTENSION);
$extensionNss = pathinfo($nss, PATHINFO_EXTENSION);

  

if($ine != "" && $curp != "" && $rfc != "" && $nss != "" &&  $Documento != ""){
$bgTable = 'style="background-color: #b0f2c2"';

}else if($ine == "" && $curp == "" && $rfc == "" && $nss == "" &&  $Documento == ""){
$bgTable = 'style="background-color: #ffb6af"';

}else{
$bgTable = 'style="background-color: #fcfcda"';

} 


if($extensionCurp == "pdf" || $extensionCurp == "jpg" || $extensionCurp == "png" || $extensionCurp == "txt" || $extensionCurp == "xml" || $extensionCurp == "jpeg" || $extensionCurp == "JPG"){

$detalleCurp = '<a href="'.RUTA_ARCHIVOS.'/documentos-personal/curp/'.$curp.'" download>
<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="CURP"></a>';

}else{
$detalleCurp = $curp;
$bgTable = 'style="background-color: #fcfcda"';
}
  

if($extensionRfc == "pdf" || $extensionRfc == "jpg" || $extensionRfc == "png" || $extensionRfc == "txt" || $extensionRfc == "xml" || $extensionRfc == "jpeg" || $extensionRfc == "JPG"){
$detalleRfc = '<a href="'.RUTA_ARCHIVOS.'/documentos-personal/rfc/'.$rfc.'" download>
     <img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="RFC"></a>';

}else{
$detalleRfc = $rfc;
$bgTable = 'style="background-color: #fcfcda"';
}
 
 
if($extensionNss == "pdf" || $extensionNss == "jpg" || $extensionNss == "png" || $extensionNss == "txt" || $extensionNss == "xml" || $extensionNss == "jpeg" || $extensionNss == "JPG"){
$detalleNss = '<a href="'.RUTA_ARCHIVOS.'/documentos-personal/nss/'.$nss.'" download>
     <img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Numero de Seguro Social"></a>';

}else{
$detalleNss = $nss;
$bgTable = 'style="background-color: #fcfcda"';
}
  

if($ine != ""){
$detalleIne = '<a href="'.RUTA_ARCHIVOS.'documentos-personal/ine/'.$ine.'" download>
     <img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Identificacion Oficial"></a>';


}else{
$detalleIne = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Sin Información">';   
}
  

if($Documento != ""){
$detalleDoc = '<a href="'.RUTA_ARCHIVOS.''.$Documento.'" download>
     <img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Documentos Personales"></a>';


}else{
$detalleDoc = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Sin Información">';   
}

 
if($contrato != ""){
$detalleContrato = '<a href="'.RUTA_ARCHIVOS.'documentos-personal/contrato/'.$contrato.'" download>
     <img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Documentos Personales"></a>';


}else{
$detalleContrato = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Sin Información">';   
}
   

if($no_colaborador == 0){
  $num_col = "";
}else{
  $num_col = $no_colaborador;	
}
  
echo '<tr '.$bgTable.'>';

//echo '<td class="text-center align-middle">'.$row_personal['id'].'</td>';

echo '<td class="text-center align-middle">'.$num_col.'</td>
<td class="align-middle">'.FormatoFecha($row_personal['fecha_ingreso']).'</td>
<td class="align-middle">'.$row_personal['nombre_completo'].'</td>
<td class="align-middle text-center">'.$row_personal['puesto'].'</td>
<td class="align-middle text-center">'.$detalleDoc.'</td>
<td class="align-middle text-center">'.$detalleIne.'</td>
<td class="align-middle text-center">'.$detalleCurp.'</td>
<td class="align-middle text-center">'.$detalleRfc.'</td>
<td class="align-middle text-center">'.$detalleNss.'</td>
<td class="align-middle text-center">'.$detalleContrato.'</td>
<td class="align-middle text-center">'.number_format($row_personal['sd'],2).'</td>
 
<td class="align-middle text-center">
<img class="pointer" src="'.RUTA_IMG_ICONOS.'archivo-tb.png" data-toggle="tooltip" data-placement="top" title="Documentos" onclick="Documentos('.$id.')">
</td>

<td class="align-middle"><img class="pointer" src="'.RUTA_IMG_ICONOS.'reloj-tb.png" data-toggle="tooltip"  data-placement="top" title="Asistencia" onclick="Asistencia('.$id.')"></td>

<td class="align-middle"><img class="pointer" src="'.RUTA_IMG_ICONOS.'huella-dactilar-tb.png" data-toggle="tooltip"  data-placement="top" title="Acceso" onclick="Acceso('.$id.')"></td>
<td class="align-middle"><img class="pointer" src="'.RUTA_IMG_ICONOS.'nomina-tb.png" data-toggle="tooltip"  data-placement="top" title="Recibo de Nomina" onclick="NominaIndividual('.$id.')"></td>

<td class="align-middle '.$ocultarOpcion.'"><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" data-toggle="tooltip"  data-placement="top" title="Editar" onclick="EditarPersonal('.$idEstacion.','.$id.')"></td>

<td class="align-middle '.$ocultartb.'"><img class="pointer" src="'.RUTA_IMG_ICONOS.'pago-tb.png" data-toggle="tooltip"  data-placement="top" title="Salario Diario" onclick="ModalEditarSD('.$id.')"></td>

<td class="align-middle '.$ocultarOpcion.'"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarPersonal('.$idEstacion.','.$id.')" data-toggle="tooltip"  data-placement="top" title="Eliminar"></td>
</tr>';



}
}else{
echo "<tr><td colspan='13' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>

</tbody>
</table>
</div>

</div> 