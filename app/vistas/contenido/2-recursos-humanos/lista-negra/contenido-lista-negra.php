<?php 
require('../../../../../app/help.php');
$idEstacion = $_GET['idEstacion'];

if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
$consultaGnral = "";
$ocultarTB = ""; 
$ocultarbtn = "d-none"; 
}else{
$consultaGnral = "WHERE op_rh_personal.id_estacion = '".$idEstacion."' ORDER BY op_rh_personal_lista_negra.fecha ASC";
$ocultarTB = "d-none";
$ocultarbtn = "";
}

if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
$tituloBar = "Lista negra";

}else{
$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($idEstacion);
$nombreLocalidad = $datosEstacion['localidad'];
$tituloBar = "Lista negra ($nombreLocalidad)";
}

$sql_lista = "SELECT 
op_rh_personal.id_estacion,
op_rh_personal.nombre_completo,
op_rh_personal.id_estacion,
op_rh_personal.puesto,
op_rh_personal.fecha_ingreso,
op_rh_personal.ine,
op_rh_personal.curp,
op_rh_personal.rfc,
op_rh_personal.nss,
op_rh_personal.contrato,
op_rh_personal.documentos,
op_rh_personal.estado,
op_rh_personal_lista_negra.id,
op_rh_personal_lista_negra.fecha,
op_rh_personal_lista_negra.motivo,
op_rh_personal_lista_negra.detalle,
op_rh_puestos.puesto
FROM op_rh_personal_lista_negra
INNER JOIN op_rh_personal ON op_rh_personal_lista_negra.id_personal = op_rh_personal.id
INNER JOIN op_rh_puestos ON op_rh_personal.puesto = op_rh_puestos.id $consultaGnral";

$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
?>


<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Recursos Humanos</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase"><?=$tituloBar?></li>
</ol>
</div>
   
<div class="row"> 
<div class="col-12"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"><?=$tituloBar?></h3> </div>
</div>

<hr>
</div>

<div class="table-responsive">
<table id="tabla_bitacora" class="custom-table style="font-size: .9em;" width="100%">

<thead class="tables-bg">
<tr> 
  <th class="text-center align-middle tableStyle font-weight-bold">#</th>
  <th class="align-middle tableStyle font-weight-bold">Fecha</th>
  <th class="align-middle tableStyle font-weight-bold">Nombre</th>
  <th class="align-middle tableStyle font-weight-bold <?=$ocultarTB?>">Estacion</th>
  <th class="align-middle tableStyle font-weight-bold">Puesto</th>
  <th class="align-middle tableStyle font-weight-bold">Motivo</th>
  <th class="align-middle tableStyle font-weight-bold">Detalle</th>
  <th class="align-middle text-center <?=$ocultarbtn?>" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
</tr>
</thead> 

<tbody class="bg-white">
<?php
$num = 1;
if ($numero_lista > 0) {

while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$idListaNegra = $row_lista['id'];
$GET_idEstacion = $row_lista['id_estacion'];
$nombre_completo = $row_lista['nombre_completo'];
$fecha = $row_lista['fecha'];
$puesto = $row_lista['puesto'];
$motivo = $row_lista['motivo'];
$detalle = $row_lista['detalle'];

$datosEstaciones = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($GET_idEstacion);
$nombreEstacion = $datosEstaciones['localidad'];

echo '<tr>';
echo '<th class="text-center align-middle">'.$num.'</th>';
echo '<td class="text-center align-middle">'.$ClassHerramientasDptoOperativo->FormatoFecha($fecha).'</td>';
echo '<td class="text-center align-middle">'.$nombre_completo.'</td>';
echo '<td class="text-center align-middle '.$ocultarTB.'"> '.$nombreEstacion.'</td>';
echo '<td class="text-center align-middle">'.$puesto.'</td>';
echo '<td class="text-center align-middle">'.$motivo.'</td>';
echo '<td class="text-center align-middle">'.$detalle.'</td>';
echo '<td class="text-center align-middle '.$ocultarbtn.'"><a onclick="Eliminar('.$GET_idEstacion.','.$idListaNegra.')"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png"></a></td>';
echo '</tr>';

$num++;
}

}else{
echo "<tr><td colspan='7'><div class='text-secondary text-center p-2 fs-6 fw-light'>No se encontró información para mostrar </div></td></tr>";	
}
?>
</tbody>

</table>
</div>

