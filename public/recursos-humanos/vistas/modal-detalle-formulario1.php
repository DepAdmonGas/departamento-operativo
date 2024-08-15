<?php
require('../../../app/help.php');

$idFormato = $_GET['idFormato'];

$sql = "SELECT * FROM op_rh_formatos WHERE id = '".$idFormato."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$explode = explode(' ', $row['fecha']);
$HoraFormato = date("g:i a",strtotime($explode[1]));
$Localidad = $row['id_localidad'];
}

$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$Localidad."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}
 
function Puesto($idPuesto,$con){
$sql = "SELECT puesto FROM op_rh_puestos WHERE id = '".$idPuesto."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$puesto = $row['puesto'];
}
return $puesto;
}

function Personal($idusuario,$con){
$sql = "SELECT nombre FROM tb_usuarios WHERE id = '".$idusuario."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
}
?> 


 <script type="text/javascript">
$(document).ready(function($){
$('[data-toggle="tooltip"]').tooltip();
});
</script>
<div class="modal-header">
<h5 class="modal-title">Detalle Alta Personal</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">


<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0 mt-2" style="font-size: .8em;">
<tbody>
<tr>
	<td class="text-center align-middle">Alta del personal</td>
	<td rowspan="3" class="text-center align-middle" width="250"><b>ALTA DE PERSONAL</b></td>
	<td class="align-middle text-center">Sucursal:</td>
	<td class="align-middle text-center">Grupo Admongas</td>
</tr>
<tr>
	<td class="align-middle text-center">Departamento de Recursos Humanos</td>
	<td class="align-middle text-center">Fecha:</td>
	<td class="align-middle text-center"><?=FormatoFecha($explode[0]).', '.$HoraFormato;?></td>
</tr>
<tr>
	<td class="align-middle text-center">Depto.Operativo</td>
	<td class="align-middle text-center">No. De control:</td>
	<td class="align-middle text-center"><b>001</b></td>
</tr>
</tbody>
</table>
</div>



<div class="mt-3">
<div class="border">
<div class="p-3">

<b>Lic. Alejandro Guzmán</b>
<br>
<b>Departamento de Recursos Humanos</b><br>
<hr>

Buenos días por medio del presente solicito de su amable apoyo para realizar las siguientes altas de personal:<br>

<div class="table-responsive">
      <table id="tabla_debito" class="custom-table mt-2" style="font-size: .8em;" width="100%">
        <thead class="tables-bg">
	<tr class="text-center">


        <th class="align-middle">Fecha de ingreso</th>
        <th class="align-middle">Nombre empleado</th>
        <th class="align-middle">Estación</th>

        <th class="align-middle">Puesto</th>
        <th class="align-middle">Identificacion Oficial</th>
        <th class="align-middle">CURP</th>
        <th class="align-middle">RFC</th>
        <th class="align-middle">NSS</th>
        <th class="align-middle text-end">Salario diario</th>


		<th class="align-middle">Detalle</th>
		<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>archivo-tb.png"></th>
	</tr>
</thead> 
<tbody class="bg-light">
<?php
$sql_lista = "SELECT * FROM op_rh_formatos_alta WHERE id_formulario = '".$idFormato."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

$Fecha = $row_lista['fecha_ingreso'];
$NombreC = $row_lista['nombres'].' '.$row_lista['apellido_p'].' '.$row_lista['apellido_m'];
$puesto = Puesto($row_lista['puesto'],$con);

$ine = $row_lista['ine'];
$curp = $row_lista['curp'];
$rfc = $row_lista['rfc'];
$nss = $row_lista['nss'];
$Documento = $row_lista['documento'];
 

$extensionCurp = pathinfo($curp, PATHINFO_EXTENSION);
$extensionRfc = pathinfo($rfc, PATHINFO_EXTENSION);
$extensionNss = pathinfo($nss, PATHINFO_EXTENSION);

if($extensionCurp == "pdf" || $extensionCurp == "jpg" || $extensionCurp == "png" || $extensionCurp == "txt" || $extensionCurp == "xml" || $extensionCurp == "jpeg"){
$detalleCurp = '<a href="'.RUTA_ARCHIVOS.'/documentos-personal/curp/'.$curp.'" download>
     <img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="CURP"></a>';

}else{
$detalleCurp = $curp;

}
  

if($extensionRfc == "pdf" || $extensionRfc == "jpg" || $extensionRfc == "png" || $extensionRfc == "txt" || $extensionRfc == "xml" || $extensionRfc == "jpeg"){
$detalleRfc = '<a href="'.RUTA_ARCHIVOS.'/documentos-personal/rfc/'.$rfc.'" download>
     <img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="RFC"></a>';

}else{
$detalleRfc = $rfc;

}
 

if($extensionNss == "pdf" || $extensionNss == "jpg" || $extensionNss == "png" || $extensionNss == "txt" || $extensionNss == "xml" || $extensionNss == "jpeg"){
$detalleNss = '<a href="'.RUTA_ARCHIVOS.'/documentos-personal/nss/'.$nss.'" download>
     <img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Numero de Seguro Social"></a>';

}else{
$detalleNss = $nss;

}
 

if($ine != ""){
$detalleIne = '<a href="'.RUTA_ARCHIVOS.'/documentos-personal/ine/'.$ine.'" download>
     <img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Identificacion Oficial"></a>';

}else{
$detalleIne = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Sin Información">';   
}


echo '<tr>';
echo '<th class="align-middle text-center">'.FormatoFecha($Fecha).'</th>';
echo '<td class="align-middle text-center">'.$NombreC.'</td>';
echo '<td class="align-middle text-center">'.$estacion.'</td>';
echo '<td class="align-middle text-center">'.$puesto.'</td>';
echo '<td class="align-middle text-center">'.$detalleIne.'</td>';
echo '<td class="align-middle text-center">'.$detalleCurp.'</td>';
echo '<td class="align-middle text-center">'.$detalleRfc.'</td>';
echo '<td class="align-middle text-center">'.$detalleNss.'</td>';
echo '<td class="align-middle text-end">'.number_format($row_lista['sd'],2).'</td>';
echo '<td class="align-middle text-center">'.$row_lista['detalle'].'</td>';
echo '<td class="align-middle text-center"><a href="archivos/'.$Documento.'" download><img src="'.RUTA_IMG_ICONOS.'archivo-tb.png" data-toggle="tooltip" data-placement="top" title="Archivos"></a></td>';
echo '</tr>';
}
}else{
echo "<tr><th colspan='15' class='text-center text-secondary'><small>No se encontró información para mostrar </small></th></tr>";
}
?>

</tbody>
</table>
</div>

<hr>

<div class="mt-3 text-center">
Sin más por el momento quedo de usted.
</div>



<div class="row justify-content-md-center">
<?php

$sql_firma = "SELECT * FROM op_rh_formatos_firma WHERE id_formato = '".$idFormato."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);


while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){
$explode = explode(' ', $row_firma['fecha']);


    if($row_firma['tipo_firma'] == "A"){
   
    $Detalle = '
    <div class="border p-3">
    <h6 class="mt-2 text-secondary text-center">Elaboró</h6><hr>
    <div class="border p-1 text-center"><img src="'.RUTA_IMG.'/firma/'.$row_firma['firma'].'" width="70%"></div>
    <div class="text-center mt-2">'.Personal($row_firma['id_usuario'],$con).'</div>
    </div>';


    }else if($row_firma['tipo_firma'] == "B"){

    $Detalle = '
    <div class="border p-3">
    <h6 class="mt-2 text-secondary text-center">Vo.Bo</h6><hr>
    <div class="border p-1 text-center">
    <div class="border-bottom text-center p-2"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div></div>
    <div class="text-center mt-2">'.Personal($row_firma['id_usuario'],$con).'</div>
    </div>';



    }else if($row_firma['tipo_firma'] == "C"){
   
    $Detalle = ' <div class="border p-3"><div class="mb-1 text-center">
    <b>Atentamente</b></br>'.Personal($row_firma['id_usuario'],$con).'</div>
    <br>
    <div class="border-bottom text-center p-3" style="font-size: 0.9em;"><small>El formato se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>
    <h6 class="mt-2 text-secondary text-center">NOMBRE Y FIRMA DE AUTORIZACIÓN</h6>
    </div> </div>';

    }

    echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-3">';
    echo $Detalle;
    echo '</div>';


}

?> 


</div>





</div>
</div>
</div>
</div>