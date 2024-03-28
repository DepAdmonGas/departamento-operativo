<?php
require('../../../app/help.php');

if($_GET['Buscar'] == ''){
$sql_lista = "SELECT * FROM op_acuse_recepcion WHERE (estado = 0 OR estado = 1) ";
}else if($_GET['Buscar'] == 0){
$sql_lista = "SELECT * FROM op_acuse_recepcion ORDER BY estado ASC , fecha_creacion DESC  ";	
}else if($_GET['Buscar'] == 1){
$sql_lista = "SELECT * FROM op_acuse_recepcion WHERE estado = 1 ORDER BY fecha_creacion DESC ";	
}else if($_GET['Buscar'] == 2){
$sql_lista = "SELECT * FROM op_acuse_recepcion WHERE estado = 2 ORDER BY fecha_creacion DESC ";	
}

$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

function Documentos($id, $con){

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
$fondo = 'bg-danger-claro';
$color = 'text-dark';
$Onclick = 'onclick="Editar('.$id.')"';
}else if($row_lista['estado'] == 1){
$fondo = 'bg-light';
$color = 'text-dark';
$Onclick = 'onclick="Finalizar('.$id.')"';
}else if($row_lista['estado'] == 2){
$fondo = 'bg-success-claro';
$color = 'text-dark';
$Onclick = 'onclick="Detalle('.$id.')"';
}

echo '<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
<div class="border p-2 rounded-1 mt-2 '.$fondo.' '.$color.'" '.$Onclick.'>
<div class="text-end"><small>'.FormatoFecha($Fecha).', '.$Hora.'</small></div>
<div class="text-center mt-3"><h6>'.$Empresa.'</h6></div>
<div class="text-center mt-3"><b>Documentos </b>'.$Documentos.'</div>
</div>
</div>';

}
echo '</div>';
}else{
echo "<div class='text-center text-secondary'><small>No se encontró información para mostrar </small></div>";
}
?>


