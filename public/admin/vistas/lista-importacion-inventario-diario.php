<?php
require('../../../app/help.php');

if(isset($_GET["Year"]) AND isset($_GET["Mes"])){
$sql_lista = "SELECT * FROM op_inventarios_diarios WHERE MONTH(fecha) = '".$_GET["Mes"]."' AND YEAR(fecha) = '".$_GET["Year"]."' ";


$titulo = "

<div class='row'>

<div class='col-12'>
<span class='badge rounded-pill tables-bg float-end pointer' style='font-size:12px' onclick='Contenido()'> 
<label class='mt-1' >Reportes de ".nombremes($_GET["Mes"])." del ".$_GET["Year"]." </label>
<img class='float-end  ms-2' src='".RUTA_IMG_ICONOS."eliminar.png'></span>
</div>

</div>

";


}else{
$sql_lista = "SELECT * FROM op_inventarios_diarios ORDER BY fecha DESC LIMIT 31";
$titulo = "";
}

function Detalle($idReporte,$detalle,$con){

$contenido .= '<div class="font-weight-bold">'.$detalle.'</div>';
$contenido .= '<div class="table-responsive">';
$contenido .= '<table class="table table-bordered table-sm pb-0 mb-0" style="font-size: 0.9em;">
<thead >
  <tr>
    <td class="font-weight-bold">Sucursal</td>
    <td class="font-weight-bold text-center" >Destino</td>
    <td class="font-weight-bold text-center" style="background: #76bd1d;color: white;">87 Oct</td>
    <td class="font-weight-bold text-center" style="background: #e21683;color: white;">91 Oct</td>
    <td class="font-weight-bold text-center" style="background: #5e0f8e;color: white;">Diesel</td>
  </tr>
</thead>';
$contenido .= '<tbody>';
$sql_lista = "SELECT * FROM op_inventarios_diarios_detalle WHERE id_reporte = '".$idReporte."' AND detalle = '".$detalle."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$id = $row_lista['id'];

if($row_lista['destino'] == 0){
$destino = "";
}else{
$destino = $row_lista['destino'];  
}

if($row_lista['oct87'] == 0){
$oct87 = "";
}else{
$oct87 = $row_lista['oct87'];  
}

if($row_lista['oct91'] == 0){
$oct91 = "";
}else{
$oct91 = $row_lista['oct91'];  
}

if($row_lista['diesel'] == 0){
$diesel = "";
}else{
$diesel = $row_lista['diesel'];  
}

if($row_lista['oct87'] < 11 && $row_lista['oct87'] != 0){
$coloct87 = "background: #FFC300;";	
}else{
$coloct87 = "background: #76bd1d;";
}

if($row_lista['oct91'] < 11 && $row_lista['oct91'] != 0){
$coloct91 = "background: #FFC300;";	
}else{
$coloct91 = "background: #e21683;";
}

if($row_lista['diesel'] < 11 && $row_lista['diesel'] != 0){
$coldiesel = "background: #FFC300;";	
}else{
$coldiesel = "background: #5e0f8e;";
}


$contenido .= '<tr>';
$contenido .= '<td class="align-middle"><b>'.$row_lista['sucursal'].'</b></td>';
$contenido .= '<td class="align-middle text-center">'.$destino.'</td>';
$contenido .= '<td class="align-middle text-center" style="'.$coloct87.'color: white;">'.$oct87.'</td>';
$contenido .= '<td class="align-middle text-center" style="'.$coloct91.'color: white;">'.$oct91.'</td>';
$contenido .= '<td class="align-middle text-center" style="'.$coldiesel.'color: white;">'.$diesel.'</td>';
$contenido .= '</tr>';
}

}else{
$contenido .= '<tr>';
$contenido .= '<tr>
<td colspan="5" class="text-center text-secondary"><small>No se encontró información para mostrar</small></td>
</tr>';
$contenido .= '</tr>'; 
}

$contenido .= '</tbody></table>';
$contenido .= '</div>';

return $contenido;
}

echo $titulo;
echo '<div class="row mt-2">';

$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$idReporte = $row_lista['id'];
if($row_lista['estatus'] == 0){
$color = 'table-warning';	
}else{
$color = '';	
}

$Detalle1 = Detalle($idReporte,'INVENTARIOS REALES',$con);
$Detalle2 = Detalle($idReporte,'CAPACIDAD ALMACENAJE',$con);


echo '<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2 mt-1">';

echo '<div class="border p-3 '.$color.'">';

echo '<div class="row">';
echo '<div class="col-12">';

echo '<div class="float-end pointer">
<img class="ms-1 pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="Editar('.$idReporte.')">
<img class="ms-1 pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$idReporte.')">
</div>';

echo '</div>';
echo '</div>';

echo '<hr>';

echo '<div class="mb-1 text-secondary">'.FormatoFecha($row_lista['fecha']).'</div>';
echo '<div class="row">';
echo '<div class="col-12">';
echo $Detalle1;
echo '</div>';
/*
echo '<div class="col-6">';
echo $Detalle2;
echo '</div>';
*/
echo '</div>';
echo '</div>';

echo '</div>';

}
}
echo '</div>';