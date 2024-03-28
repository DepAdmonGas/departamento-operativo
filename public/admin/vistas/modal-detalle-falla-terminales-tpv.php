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
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">


<div class="border p-2 mb-2">
<div class="font-weight-bold"><b>Fecha falla:</b></div>
<?=$Fecha;?>
</div>

<div class="row">


<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="border p-2">
<div class="font-weight-bold"><b>Falla:</b></div>
<?=$falla;?>
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="border p-2">
<div class="font-weight-bold"><b>Atiende:</b></div>
<?=$atiende;?>
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="border p-2">
<div class="font-weight-bold"><b>No Reporte:</b></div>
<?=$noreporte;?>
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="border p-2">
<div class="font-weight-bold"><b>Día reporte:</b></div>
<?=FormatoFecha($diareporte);?>
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="border p-2">
<div class="font-weight-bold"><b>Día solución:</b></div>
<?=FormatoFecha($diasolucion);?>
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="border p-2">
<div class="font-weight-bold"><b>Costo:</b></div>
$ <?=number_format($costo,2);?>
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="border p-2">
<div class="font-weight-bold"><b>Factura:</b></div>
<?php 
if($factura == ""){
echo "S/I";
}else{
echo '<a href="../archivos/'.$factura.'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a>';
}
?>
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="border p-2">
<div class="font-weight-bold"><b>Serie que se queda:</b></div>
<?=$serie;?>
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="border p-2">
<div class="font-weight-bold"><b>Modelo:</b></div>
<?=$modelo;?>
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="border p-2">
<div class="font-weight-bold"><b>Conexión:</b></div>
<?=$conexion;?>
</div>
</div>
</div>


<div class="border p-2 mt-2">
<div class="font-weight-bold"><b>Observaciones:</b></div>
<?=$observaciones;?>
</div>



</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="ModalFalla(<?=$idEstacion;?>,<?=$idTPV;?>)">Regresar</button>
      </div>