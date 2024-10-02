<?php
require '../../../help.php';
$idEstacion = $_GET['idEstacion'];
$year = $_GET['year'];

$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($idEstacion);
$ocultarCard = "";

if($idEstacion == 0){
$Estacion = '';
$estaciones = [1, 2, 3, 4, 5, 6, 7, 14];
$consulta = "";

}else{
$Estacion = '('.$datosEstacion['localidad'].'), ';
$estaciones = [$idEstacion];
$consulta = "AND op_recibo_nomina_v2.id_estacion = $idEstacion";

if($idEstacion == 6){
$ocultarCard = "d-none";
}

}

?> 

<style>
.card3 {
cursor: auto;
}


.product-info .btn {
  background-color: #215d98; /* Color de fondo */
  color: white; /* Color del texto */
  text-transform: uppercase;
  font-size: 0.875rem;
  border: none;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.product-info .btn:hover {
  background-color: #4bb7e6; /* Color de fondo al pasar el ratón */
}

</style>

<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Portal</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Reporte Anual <?=$Estacion?> <?=$year?></li>
</ol>
</div>

<div class="row">
<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
<h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Reporte Anual <?=$Estacion?> <?=$year?></h3>
</div>
<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
<button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="ModalBuscar()">
<span class="btn-label2"><i class="fa-solid fa-search"></i></i></span>Buscar
</button>
</div>
</div>
<hr>
</div>  


<div class="row ">

<!----- 1. Corte Diario (Resumen Aceites) ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2">    
<section class="card3 plan2 shadow-lg">
<div class="inner2">

<div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>aceites-anual.png" draggable="false"/></div>

<div class="product-info">
<p class="mb-0 pb-0">Reporte Anual  <?=$year?></p>
<h2 class="mb-2">Resumen de Aceites</h2>

<div class="row justify-content-center">

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-2">

<?php
if($idEstacion == 0){
?>
<button type="button" class="btn btn-labeled2 btn-success" onclick="pdfResumenAceites(<?=$idEstacion?>,<?=$year?>)">
<span class="btn-label2"><i class="fa-regular fa-file-pdf"></i></span>Descargar PDF</button>
<?php
}else{
?>
<button type="button" class="btn btn-labeled2 btn-success" onclick="pdfResumenAceitesES(<?=$idEstacion?>,<?=$year?>)">
<span class="btn-label2"><i class="fa-regular fa-file-pdf"></i></span>Descargar PDF</button>
<?php
}
?>

</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-2">
<a href="../app/vistas/administrador/0-reportes-anuales/excel/excel-reporte-aceites.php?idEstacion=<?=$idEstacion?>&year=<?=$year?>" download>
<button type="button" class="btn btn-labeled2 btn-success ">
<span class="btn-label2"><i class="fa-regular fa-file-excel"></i></span>Descargar Excel</button>
</a>
</div>

</div>

</div>

</div>
</section>
</div>


<!----- 2. Corte Diario (Concentrado de Ventas) ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2">    
<section class="card3 plan2 shadow-lg">
<div class="inner2">

<div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>ventas-anuales.png" draggable="false"/></div>

<div class="product-info">
<p class="mb-0 pb-0">Reporte Anual <?=$year?></p>
<h2 class="mb-2">Concentrado de Ventas</h2>

<div class="row justify-content-center">

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-2">

<?php
if($idEstacion == 0){
?>
<button type="button" class="btn btn-labeled2 btn-success" onclick="pdfConcentradoVentas(<?=$idEstacion?>,<?=$year?>)">
<span class="btn-label2"><i class="fa-regular fa-file-pdf"></i></span>Descargar PDF</button>

<?php
}else{
?>

<button type="button" class="btn btn-labeled2 btn-success" onclick="pdfConcentradoVentasES(<?=$idEstacion?>,<?=$year?>)">
<span class="btn-label2"><i class="fa-regular fa-file-pdf"></i></span>Descargar PDF</button>
<?php
}
?>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-2">

<?php
if($idEstacion == 0){
?>

<a href="../app/vistas/administrador/0-reportes-anuales/excel/excel-concentrado-ventas.php?idEstacion=<?=$idEstacion?>&year=<?=$year?>" download>
<button type="button" class="btn btn-labeled2 btn-success ">
<span class="btn-label2"><i class="fa-regular fa-file-excel"></i></span>Descargar Excel</button>
</a>

<?php
}else{
?>
<a href="../app/vistas/administrador/0-reportes-anuales/excel/excel-concentrado-ventas-estaciones.php?idEstacion=<?=$idEstacion?>&year=<?=$year?>" download>
<button type="button" class="btn btn-labeled2 btn-success ">
<span class="btn-label2"><i class="fa-regular fa-file-excel"></i></span>Descargar Excel</button>
</a>
<?php
}
?>
</div>

</div>

</div>

</div>
</section>
</div>
 

<!----- 3. Solicitud de Cheque ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2">    
<section class="card3 plan2 shadow-lg">
<div class="inner2">
  
<div class="product-image">
<img src="<?=RUTA_IMG_ICONOS;?>detalle-cheque.png" draggable="false"/>
</div>

<div class="product-info">
<p class="mb-0 pb-0">Reporte Anual <?=$year?></p>
<h2 class="mb-2">Solicitud Cheque</h2>

<div class="row justify-content-center">

<!--
<div class="col-12">
<button type="button" class="btn btn-labeled2 btn-success" onclick="detalleSolicitudCheque(<?=$idEstacion?>,<?=$year?>)">
<span class="btn-label2"><i class="fa-regular fa-eye"></i></span>Detalle del reporte</button>
</div>
-->  

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-2">
<?php
if($idEstacion == 0){
?>
<button type="button" class="btn btn-labeled2 btn-success" onclick="pdfSolicitudCheque(<?=$idEstacion?>,<?=$year?>)">
<span class="btn-label2"><i class="fa-regular fa-file-pdf"></i></span>Descargar PDF</button>
<?php
}else{
?>
<button type="button" class="btn btn-labeled2 btn-success" onclick="pdfSolicitudChequeES(<?=$idEstacion?>,<?=$year?>)">
<span class="btn-label2"><i class="fa-regular fa-file-pdf"></i></span>Descargar PDF</button>
<?php
}
?>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-2">
<a href="../app/vistas/administrador/0-reportes-anuales/excel/excel-solicitud-cheque.php?idEstacion=<?=$idEstacion?>&year=<?=$year?>" download>
<button type="button" class="btn btn-labeled2 btn-success ">
<span class="btn-label2"><i class="fa-regular fa-file-excel"></i></span>Descargar Excel</button>
</a>
</div>

</div>

</div>

</div>
</section>
</div>
 

<!----- 4. Recibo de nomina ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2 <?=$ocultarCard?>">    
<section class="card3 plan2 shadow-lg">
<div class="inner2">
  
<div class="product-image">
<img src="<?=RUTA_IMG_ICONOS;?>nomina.png" draggable="false"/>
</div>

<div class="product-info">
<p class="mb-0 pb-0">Reporte Anual <?=$year?></p>
<h2 class="mb-2">Recibos de Nomina</h2>

<div class="row justify-content-center">


<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-2">
<?php
if($idEstacion == 0){
?>
<button type="button" class="btn btn-labeled2 btn-success" onclick="pdfRecibosNomina(<?=$idEstacion?>,<?=$year?>)">
<span class="btn-label2"><i class="fa-regular fa-file-pdf"></i></span>Descargar PDF</button>
<?php
}else{
?>
<button type="button" class="btn btn-labeled2 btn-success" onclick="pdfRecibosNominaES(<?=$idEstacion?>,<?=$year?>)">
<span class="btn-label2"><i class="fa-regular fa-file-pdf"></i></span>Descargar PDF</button>
<?php
}
?>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-2">
<a href="../app/vistas/administrador/0-reportes-anuales/excel/excel-recibo-nomina.php?idEstacion=<?=$idEstacion?>&year=<?=$year?>" download>
<button type="button" class="btn btn-labeled2 btn-success ">
<span class="btn-label2"><i class="fa-regular fa-file-excel"></i></span>Descargar Excel</button>
</a>
</div>

</div>

</div>

</div>
</section>
</div>
 
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2">    
<section class="card3 plan2 shadow-lg">
<div class="inner2">
  
<div class="product-image">
<img src="<?=RUTA_IMG_ICONOS;?>vales-tb.png" draggable="false"/>
</div>

<div class="product-info">
<p class="mb-0 pb-0">Reporte Anual <?=$year?></p>
<h2 class="mb-2">Solicitud de Vales</h2>

<div class="row justify-content-center">


<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-2">
<?php
if($idEstacion == 0){
?>
<button type="button" class="btn btn-labeled2 btn-success" onclick="pdfSolicitudVales(<?=$idEstacion?>,<?=$year?>)">
<span class="btn-label2"><i class="fa-regular fa-file-pdf"></i></span>Descargar PDF</button>
<?php
}else{
?>
<button type="button" class="btn btn-labeled2 btn-success" onclick="pdfSolicitudValesES(<?=$idEstacion?>,<?=$year?>)">
<span class="btn-label2"><i class="fa-regular fa-file-pdf"></i></span>Descargar PDF</button>
<?php
}
?>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-2">
<a href="../app/vistas/administrador/0-reportes-anuales/excel/excel-solicitud-vales.php?idEstacion=<?=$idEstacion?>&year=<?=$year?>" download>
<button type="button" class="btn btn-labeled2 btn-success ">
<span class="btn-label2"><i class="fa-regular fa-file-excel"></i></span>Descargar Excel</button>
</a>
</div>

</div>

</div>

</div>
</section>
</div>


</div>

