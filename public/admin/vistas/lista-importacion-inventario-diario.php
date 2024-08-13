<?php
require('../../../app/help.php');

if(isset($_GET["Year"]) AND isset($_GET["Mes"])){
$sql_lista = "SELECT * FROM op_inventarios_diarios WHERE MONTH(fecha) = '".$_GET["Mes"]."' AND YEAR(fecha) = '".$_GET["Year"]."' ";

$titulo = '
<div class="row">
<div class="col-12"><div class="alert alert-primary text-start" role="alert">
Reportes de '.nombremes($_GET["Mes"]).' del '.$_GET["Year"].'</div>
</div>
</div>';

$titulo2 = '<button type="button" class="btn btn-labeled2 btn-success mt-3" onclick="Contenido()">
<span class="btn-label2"><i class="fa-solid fa-rotate-left"></i></span>Regresar a la pagina información principal</button>';

$titulo3 = 'de '.nombremes($_GET["Mes"]).' del '.$_GET["Year"].'';

$valYear = $_GET["Year"];
$valMes = $_GET["Mes"];

}else{
$sql_lista = "SELECT * FROM op_inventarios_diarios 
WHERE MONTH(fecha) = '".$fecha_mes."' AND YEAR(fecha) = '".$fecha_year."' ORDER BY fecha DESC LIMIT 31";

$titulo = '
<div class="row">
<div class="col-12"><div class="alert alert-primary" role="alert">
Reportes de '.nombremes($fecha_mes).' del '.$fecha_year.'</div>
</div>
</div>';

$titulo2 = "";

$titulo3 = 'de '.nombremes($fecha_mes).' del '.$fecha_year.'';

$valYear = $fecha_year;
$valMes = $fecha_mes;

}

function Detalle($idReporte,$detalle,$con){
$contenido ="";
$contenido .= '<div class="table-responsive">';
$contenido .= '<table class="custom-table fw-bold style="font-size: 0.9em;" width="100%">

<thead>

  <tr>
    <td class="font-weight-bold text-dark bg-light" colspan="5">'.$detalle.'</td>
  </tr>

  <tr>
    <td class="text-dark bg-light">Sucursal</td>
    <td class="font-weight-bold text-dark text-center bg-light" >Destino</td>
    <td class="font-weight-bold text-center" style="background: #76bd1d;color: white;">87 Oct</td>
    <td class="font-weight-bold text-center" style="background: #e21683;color: white;">91 Oct</td>
    <td class="text-center" style="background: #5e0f8e;color: white;">Diesel</td>
  </tr>
</thead>';

$contenido .= '<tbody class="bg-light">';
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
$contenido .= '<td class="align-middle bg-light">'.$row_lista['sucursal'].'</td>';
$contenido .= '<td class="align-middle bg-light text-center">'.$destino.'</td>';
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



$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
if ($numero_lista > 0) {
echo $titulo;

echo '<div class="row ">';
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$idReporte = $row_lista['id'];
if($row_lista['estatus'] == 0){
$color = 'bg-warning';	
}else{
$color = '';	
}

$Detalle1 = Detalle($idReporte,'INVENTARIOS REALES',$con);
$Detalle2 = Detalle($idReporte,'CAPACIDAD ALMACENAJE',$con);


echo '<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">';

echo '
<div class="table-responsive">
<table class="custom-table" style="font-size: 12.5px;" width="100%">
<thead class="tables-bg">
<tr> <th class="align-middle text-center" colspan="2">'.$ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha']).'</th> </tr>
</thead>
<tbody>
<tr class="no-hover">
<th class="align-middle text-center bg-white p-1" colspan="2">
'.$Detalle1.'
</th>
</tr>

<tr class="no-hover">
<th class="align-middle text-center p-2 bg-primary text-white" onclick="Editar('.$idReporte.')">  
<i class="fa-solid fa-pencil"></i> Editar         
</th>

<th class="align-middle text-center p-2 bg-danger text-white" onclick="Eliminar('.$idReporte.','.$valYear.','.$valMes.')">  
<i class="fa-regular fa-trash-can"></i> Eliminar         
</th>
</tr>
 
</tbody>
</table>
</div>';

echo '</div>';
}
echo '</div>';


}else{

  echo '<header class="bg-light py-5">
  <div class="container px-5">
  <div class="row gx-5 align-items-center justify-content-center">

  <div class="col-xl-5 col-xxl-6 d-xl-block text-center">
  <img class="my-2" style="width: 100%" src="'.RUTA_IMG_ICONOS.'no-busqueda.png" width="50%">
  </div>
 
  <div class="col-lg-8 col-xl-7 col-xxl-6">
  <div class="my-2 text-center"> 
  <h1 class="display-3 fw-bolder text-dark">No se encontró la información <br> '.$titulo3.'</h1> 
  
  '.$titulo2.'

  </div>
  </div>
  
  </div>
  </div>
  </header>';

}
