<?php
require('../../../app/help.php');

if($_GET['Buscar'] == ''){
$sql_lista = "SELECT * FROM op_acuse_recepcion WHERE (estado = 0 OR estado = 1) ";
}else if($_GET['Buscar'] == 0){
$sql_lista = "SELECT * FROM op_acuse_recepcion ORDER BY estado ASC , fecha_creacion DESC ";	
}else if($_GET['Buscar'] == 1){
$sql_lista = "SELECT * FROM op_acuse_recepcion WHERE estado = 1 ORDER BY fecha_creacion DESC ";	
}else if($_GET['Buscar'] == 2){
$sql_lista = "SELECT * FROM op_acuse_recepcion WHERE estado = 2 ORDER BY fecha_creacion DESC ";	
}
 
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

function Documentos($id, $con){
$Result = "";
$sql_lista = "SELECT * FROM op_acuse_recepcion_documentos WHERE id_acuse = '".$id."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);	
$num = 1;
$Result .= '(';
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){ 
$Documento = $row_lista['documento'];

if($num == $numero_lista){
$Detalle = '';
}else{
$Detalle = ', ';
}

$Result .= $num.'. '.$Documento.$Detalle;

$num++;
}
$Result .= ')';

return $Result;
}

if ($numero_lista > 0) {
echo '<div class="row">';
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$id = $row_lista['id'];
$explode = explode(" ", $row_lista['fecha_creacion']);
$Fecha = $explode[0];
$Hora = date("g:i a",strtotime($explode[1]));
$Empresa = $row_lista['empresa'];

$Documentos = Documentos($id, $con);

if($row_lista['estado'] == 0){
$fondo = 'bg-danger'; 
$detalleBadge = "Pendiente";
$Onclick = 'onclick="Editar('.$id.')"';
}else if($row_lista['estado'] == 1){
$fondo = 'bg-warning';
$detalleBadge = "En proceso";
$Onclick = 'onclick="Finalizar('.$id.')"';
}else if($row_lista['estado'] == 2){
$fondo = 'bg-success';
$detalleBadge = "Finalizado";
$Onclick = 'onclick="Detalle('.$id.')"';
}


echo '<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2" '.$Onclick.'>    
<section class="card3 plan2 shadow-lg">
<div class="inner2" style="position: relative;">
<div class="badge rounded-pill '.$fondo.'" style="position: absolute; top: 10px; right: 10px;">'.$detalleBadge.'</div>
<div class="product-image"><img src="'.RUTA_IMG_ICONOS.'recepcion-tb.png" draggable="false"/></div>
  
<div class="product-info">
<p class="mb-0 pb-0">'.$ClassHerramientasDptoOperativo->FormatoFecha($Fecha).', '.$Hora.'</p>
<h6>'.$Empresa.'</h6> 
<p class="mb-0 pb-0"><b>Documentos </b>'.$Documentos.'</p>
</div>
</div>
</section>
</div>';

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
<div class="my-2 text-center"> <h1 class="display-3 fw-bolder text-dark">No se encontró la información</h1> </div>
</div>

</div>
</div>
</header>';

}
?>
