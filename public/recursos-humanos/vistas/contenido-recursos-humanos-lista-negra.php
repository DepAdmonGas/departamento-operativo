<?php 
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];



function NombreES($idEstacion,$con){

$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}

return $estacion;
}

if($idEstacion != $Session_IDEstacion){
$consultaGnral = "WHERE op_rh_personal.id_estacion = '".$idEstacion."'";
$ocultarTB = "d-none";
$ocultarbtn = "";
}else{
$consultaGnral = "";
$ocultarTB = ""; 
$ocultarbtn = "d-none"; 
}




$sql_lista = "SELECT 
op_rh_personal.id_estacion,
op_rh_personal.nombre_completo,
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
INNER JOIN op_rh_puestos ON op_rh_personal.puesto = op_rh_puestos.id
$consultaGnral";

$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
?>


<div class="border-0 p-3">

<div class="row">

<div class="col-11">
<?php if($idEstacion != $Session_IDEstacion){ ?>

<div class="float-start"><h5><?=NombreES($idEstacion,$con)?></h5></div>
<?php }else{ ?>
   
    <div class="row">
    <div class="col-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">

     <h5>Recursos humanos (Lista negra) - <?=$session_nomestacion;?></h5>
    
    </div>
    </div>

    </div>
    </div> 

<?php } ?>

</div>
  

<!-- <div class="col-1">
<img class="pointer float-end" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="Mas(<?=$idEstacion;?>)">
</div> -->

</div>

<hr>

<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
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
<tbody>
<?php
$num = 1;
if ($numero_lista > 0) {

while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){


echo '<tr>';
echo '<td class="text-center align-middle"><b>'.$num.'</b></td>';
echo '<td class="text-center align-middle">'.FormatoFecha($row_lista['fecha']).'</td>';
echo '<td class="text-center align-middle">'.$row_lista['nombre_completo'].'</td>';
echo '<td class="text-center align-middle '.$ocultarTB.'"> '.NombreES($row_lista['id_estacion'],$con).'</td>';
echo '<td class="text-center align-middle">'.$row_lista['puesto'].'</td>';
echo '<td class="text-center align-middle">'.$row_lista['motivo'].'</td>';
echo '<td class="text-center align-middle">'.$row_lista['detalle'].'</td>';
echo '<td class="text-center align-middle '.$ocultarbtn.'"><a onclick="Eliminar('.$idEstacion.','.$row_lista['id'].')"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png"></a></td>';
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

</div>