<?php
require('../../../app/help.php');

$idFalla = $_GET['idFalla'];
$idEstacion = $_GET['idEstacion'];
$idTPV = $_GET['idTPV'];

$sql_lista = "SELECT * FROM op_terminales_tpv WHERE id = '".$idTPV."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$tpv = $row_lista['tpv'];
$noserie = $row_lista['no_serie'];
}

$sql = "SELECT * FROM op_terminales_tpv_reporte WHERE id = '".$idFalla."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

$explode = explode(" ", $row['fechacreacion']);
$Fecha = FormatoFecha($explode[0]);
$falla = $row['falla'];
$atiende = $row['atiende'];

$noreporte = $row['no_reporte'];
$diareporte = $row['dia_reporte'];
$diasolucion = $row['dia_solucion'];
$costo = $row['costo'];
$serie = $row['serie'];
$modelo = $row['modelo'];
$conexion = $row['conexion'];
$observaciones = $row['observaciones'];
$status = $row['status'];
$factura = $row['factura'];

}

?>
<div class="modal-header">
<h5 class="modal-title">Falla TPV: <?=$tpv;?>, No DE SERIE: <?=$noserie;?></h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<div class="row">
  
<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="fw-bold text-secondary">FECHA DE FALLA:</div>
<?=$Fecha;?>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="fw-bold text-secondary">FALLA:</div>
<?php 
if($falla == ""){
echo "S/I";
}else{
echo $falla;
}
?>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="fw-bold text-secondary">ATIENDE:</div>
<?php 
if($atiende == ""){
echo "S/I";
}else{
echo $atiende;
}
?>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="fw-bold text-secondary">NO REPORTE:</div>
<?php 
if($noreporte == ""){
echo "S/I";
}else{
echo $noreporte;
}
?>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="fw-bold text-secondary">DÍA REPORTE:</div>
<?php 
if($diareporte == "0000-00-00"){
echo "S/I";
}else{
echo $ClassHerramientasDptoOperativo->FormatoFecha($diareporte);
}
?>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="fw-bold text-secondary">DÍA SOLUCIÓN:</div>
<?php 
if($diasolucion == "0000-00-00"){
echo "S/I";
}else{
echo $ClassHerramientasDptoOperativo->FormatoFecha($diasolucion);
}
?>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="fw-bold text-secondary">COSTO:</div>
$ <?=number_format($costo,2);?>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="fw-bold text-secondary">FACTURA:</div>
<?php 
if($factura == ""){
echo "S/I";
}else{
echo '<a href="'.RUTA_ARCHIVOS.''.$factura.'" download>
<button type="button" class="btn btn-labeled2 btn-success">
<span class="btn-label2"><i class="fa-solid fa-file-arrow-down"></i></span>Descargar</button>
</a>';
}
?>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="fw-bold text-secondary">SERIE QUE SE QUEDA:</div>
<?php 
if($serie == ""){
echo "S/I";
}else{
echo $serie;
}
?>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="fw-bold text-secondary">MODELO:</div>
<?php 
if($modelo == ""){
echo "S/I";
}else{
echo $modelo;
}
?>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="fw-bold text-secondary">CONEXIÓN:</div>
<?php 
if($conexion == ""){
echo "S/I";
}else{
echo $conexion;
}
?>
</div>


<div class="col-12"> 
<div class="fw-bold text-secondary">OBSERVACIONES:</div>
<?php 
if($observaciones == ""){
echo "S/I";
}else{
echo $observaciones;
}
?>
</div>

</div>

</div>
      
<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-danger" onclick="ModalFalla(<?=$idEstacion;?>,<?=$idTPV;?>)">
<span class="btn-label2"><i class="fa-solid fa-arrow-left"></i></span>Regresar</button>       
</div>