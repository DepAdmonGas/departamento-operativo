<?php 
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$Year = $_GET['Year'];
$Mes = $_GET['Mes'];
$Val = $_GET['Val'];
$listadoSemanas = SemanasDelMes($Mes, $Year);


$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}


//---------- OBTIENE EL NUMERO DE SEMANAS QUE TIENE EL MES ----------
function SemanasDelMes($GET_idMes, $GET_year) {
// Obtener el primer día del mes
$primerDia = strtotime("$GET_year-$GET_idMes-01");
  
// Ajustar el primer día al primer día de la semana
$primerDia = strtotime("this Wednesday", $primerDia);
  
// Inicializar el array para almacenar las semanas
$semanas = array();
  
// Iterar desde el primer día hasta el último día del mes
for ($currentDate = $primerDia; date('m', $currentDate) == $GET_idMes; $currentDate = strtotime('+1 week', $currentDate)) {
// Calcular el número de semana
$semana = date('W', $currentDate);
  
// Agregar la semana al array solo si no está ya presente
if (!in_array($semana, $semanas)) {
$semanas[] = $semana;
}
}
  
return $semanas;
}

//---------- OBTENER FECHA DEL PRIMER Y ULTIMO DIA DE LA SEMANA ----------
function fechasNominaSemana($year, $semana){
// Obtener la fecha del primer día de la semana
$inicioDay = new DateTime();
$inicioDay->setISODate($year, $semana, 1);
$inicioDay->modify('last thursday');
      
// Calcular la fecha de fin de la semana (6 días después del inicio)
$finDay = clone $inicioDay;
$finDay->modify('+6 days');
      
// Formatear las fechas para mostrarlas
$inicioDayFormateada = $inicioDay->format('Y-m-d');
$finDayFormateada = $finDay->format('Y-m-d');
      
$array = array(
'inicioSemanaDay' => $inicioDayFormateada, 
'finSemanaDay' => $finDayFormateada
);
      
return $array; 
      
}  


if($session_nompuesto == "Encargado"){
$ocultarDiv = "d-none";
                    
}else{
$ocultarDiv = "";
                    
}

?>


<div class="row">

<?php if($Val == 0){ ?>

<div class="col-12 <?=$ocultarDiv?>">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Recursos Humanos</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Incidencias de Nomina (<?=$estacion;?>), <?=$ClassHerramientasDptoOperativo->nombremes($Mes);?> <?=$Year;?></li>
</ol>
</div>

<div class="row">
<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12"><h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Incidencias de Nomina (<?=$estacion;?>), <?=$ClassHerramientasDptoOperativo->nombremes($Mes);?> <?=$Year;?></h3></div>
<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
    
<div class="text-end">
<div class="dropdown d-inline">
<button type="button" class="btn dropdown-toggle btn-primary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
<i class="fa-solid fa-screwdriver-wrench"></i></span>
</button>

<ul class="dropdown-menu">
<li onclick="ModalReporte(<?=$idEstacion;?>)"><a class="dropdown-item pointer">  <i class="fa-solid fa-search text-dark"></i> Buscar Reporte</a></li>
<li><a href="public/recursos-humanos/vistas/asistencias-excel-v3.php?idEstacion=<?=$idEstacion?>&year=<?=$Year?>&mes=<?=$Mes?>" download class="dropdown-item pointer">
<i class="fa-regular fa-file-excel"></i> Descargar Reporte</a></li>

 </ul>
  </div>
</div>

</div>
</div>
<hr>      
</div>


<?php }else{ ?>
 
<div class="col-12 <?=$ocultarDiv?>">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Recursos Humanos</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Reporte de Incidencias (<?=$estacion;?>), <?=$ClassHerramientasDptoOperativo->nombremes($Mes);?> <?=$Year;?></li>
</ol>
</div>

<div class="row">
<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12"><h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Reporte de Incidencias (<?=$estacion;?>), <?=$ClassHerramientasDptoOperativo->nombremes($Mes);?> <?=$Year;?></h3></div>
<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
    
<div class="text-end">
<div class="dropdown d-inline">
<button type="button" class="btn dropdown-toggle btn-primary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
<i class="fa-solid fa-screwdriver-wrench"></i></span>
</button>

<ul class="dropdown-menu">
<li onclick="ModalReporte(<?=$idEstacion;?>)"><a class="dropdown-item pointer">  <i class="fa-solid fa-search text-dark"></i> Buscar Reporte</a></li>
<li><a href="public/recursos-humanos/vistas/asistencias-excel-v3.php?idEstacion=<?=$idEstacion?>&year=<?=$Year?>&mes=<?=$Mes?>" download class="dropdown-item pointer">
<i class="fa-regular fa-file-excel"></i> Descargar Reporte</a></li>
<li onclick="SelEstacionReturn(<?=$idEstacion;?>)"><a class="dropdown-item pointer">  <i class="fa-solid fa-xmark text-dark"></i> Cancelar</a></li>
</ul>
</div>
</div>

</div>
</div>
<hr>      
</div>
<?php } ?>

<div>

<div class="row">
<?php 

foreach ($listadoSemanas as $semana) {
$GET_idSemana = (int)$semana;
// echo tablasNomina($idEstacion, $Year, $Mes, $GET_idSemana, $con);


$fechaNomiaSemana = fechasNominaSemana($Year, $GET_idSemana);
$inicioFechas = $fechaNomiaSemana['inicioSemanaDay'];
$finFechas = $fechaNomiaSemana['finSemanaDay'];


echo '<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2" onclick="DetalleIncidencia('.$idEstacion.', '.$Year.', '.$Mes.', '.$GET_idSemana.')">    
<section class="card3 plan2 shadow-lg">
<div class="inner2">
  
<div class="product-image"><img src="'.RUTA_IMG_ICONOS.'incidente-nomina.png" draggable="false"/></div>
  
<div class="product-info">
<h2>Semana '.$GET_idSemana.'</h2>
<p class="mb-0 pb-0">'.formatoFecha($inicioFechas).' al <br> '.formatoFecha($finFechas).'</p>

</div>

</div>
</section>
</div>';

}
    
?>

</div>



