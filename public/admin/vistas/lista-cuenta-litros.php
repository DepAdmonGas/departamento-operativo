<?php
require('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];
$GET_year = $_GET['year'];
$GET_mes = $_GET['mes']; 

$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosEstacion($idEstacion);

if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo" ){
$ocultarTB = "";
$Estacion = ' (Cuenta litros)';

}else{
$ocultarTB = "d-none";
$Estacion = ' (Cuenta litros - '.$datosEstacion['nombre'].')';

}

$sql_lista = "SELECT * FROM op_cuenta_litros WHERE id_estacion = '".$idEstacion."' AND year = '".$GET_year."'  AND mes = '".$GET_mes."' ORDER BY fecha DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>

 
<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.go(-3)"  class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Importación</a></li>
<li class="breadcrumb-item"><a onclick="history.go(-2)"  class="text-uppercase text-primary pointer"> Tabla de Descarga</a></li>
<li class="breadcrumb-item"><a onclick="history.go(-1)"  class="text-uppercase text-primary pointer"> <?=$GET_year?></a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase"><?=$ClassHerramientasDptoOperativo->nombremes($GET_mes)?> </li>
</ol>
</div>
 
<div class="row"> 
<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Tabla de Descarga<?=$Estacion?>, <?=$ClassHerramientasDptoOperativo->nombremes($GET_mes)?> <?=$GET_year?></h3> </div>
<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mt-2 <?=$ocultarTB?>"> 
<button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="NuevoCuentaLitros(<?=$idEstacion;?>,<?=$GET_year;?>,<?=$GET_mes;?>)"><span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
</div>

</div>

<hr>
</div>


<div class="table-responsive">
<table class="custom-table" style="font-size: .9em;" width="100%">

 
<thead class="title-table-bg">
<th class="text-center align-middle font-weight-bold" width="60">#</th>
<th class="align-middle font-weight-bold">Fecha</th>
<th class="text-center align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
<th class="text-center align-middle text-center " width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
<th class="text-center align-middle text-center <?=$ocultarTB?>" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
</thead> 

<tbody class="bg-white">
<?php
if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id_cuenta_litros = $row_lista['id_cuenta_litros'];
$estado = $row_lista['estatus'];

if($estado == 0 AND $session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo" ){
$TrColor = 'style="background-color: #fcfcda"';
$detalletb = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'ver-tb.png">';
$editartb = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="EditarCL('.$id_cuenta_litros.')">';

}else if($estado == 1 AND $session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo" ){
$TrColor =  'style="background-color: #b0f2c2"';
$detalletb = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png"  onclick="DetalleCL('.$id_cuenta_litros.')">';
$editartb = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png">';


}else if($estado == 0){
$TrColor = 'style="background-color: #fcfcda"';
$detalletb = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png"  onclick="DetalleCL('.$id_cuenta_litros.')">';
$editartb = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png">';

}else if($estado == 1){
$TrColor =  'style="background-color: #b0f2c2"';
$detalletb = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png"  onclick="DetalleCL('.$id_cuenta_litros.')">';
$editartb = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="HabilitarCL('.$id_cuenta_litros.')">';
}


echo '<tr '.$TrColor.'>';
echo '<th class="align-middle text-center">'.$num .'</th>';
echo '<td class="align-middle">'.FormatoFecha($row_lista['fecha']).'</td>';
echo '<td class="align-middle text-center">'.$detalletb.'</td>';
echo '<td class="align-middle text-center">'.$editartb.'</td>';
echo '<td class="align-middle text-center '.$ocultarTB.'"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarCL('.$id_cuenta_litros.','.$idEstacion.','.$GET_year.','.$GET_mes.')"></td>';
echo '</tr>';

$num++;
}

}else{
echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>  
</div>

 

