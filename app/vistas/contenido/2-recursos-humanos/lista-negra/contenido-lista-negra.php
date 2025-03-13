<?php 
require('../../../../../app/help.php');
if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
$ocultarbtn = "d-none"; 

}else{
$ocultarbtn = "";

}

if(isset($_GET["fecha_inicio"]) AND isset($_GET["fecha_fin"])){
$fechaInicio = $_GET["fecha_inicio"];
$fechaFin = $_GET["fecha_fin"];
$consulta = "WHERE op_rh_personal_lista_negra.fecha BETWEEN '".$fechaInicio."' AND '".$fechaFin."'";
$textoDetalle = "del: ".$ClassHerramientasDptoOperativo->FormatoFecha($fechaInicio)." al: ".$ClassHerramientasDptoOperativo->FormatoFecha($fechaFin)."";
$btnRegreso = '  <button type="button" class="btn btn-labeled2 btn-success mt-3 float-end" onclick="SelEstacion()">
  <span class="btn-label2"><i class="fa-solid fa-rotate-left"></i></span>Regresar a la pagina información principal</button>';

}else{
$fechaInicio = "";
$fechaFin = "";
$consulta = "";
$textoDetalle = "General";
$btnRegreso = "";

}

$sql_lista = "SELECT 
op_rh_personal.id_estacion,
op_rh_personal.nombre_completo,
op_rh_personal.id_estacion,
op_rh_personal.puesto,
op_rh_personal.fecha_ingreso,
op_rh_personal.estado,
op_rh_personal_lista_negra.id,
op_rh_personal_lista_negra.fecha,
op_rh_personal_lista_negra.motivo,
op_rh_personal_lista_negra.detalle,
op_rh_puestos.puesto
FROM op_rh_personal_lista_negra
INNER JOIN op_rh_personal ON op_rh_personal_lista_negra.id_personal = op_rh_personal.id
INNER JOIN op_rh_puestos ON op_rh_personal.puesto = op_rh_puestos.id $consulta
ORDER BY op_rh_personal.id_estacion ASC ";

$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

function ToComentarios($idListaNegra,$con){
$sql_lista = "SELECT id FROM op_rh_lista_negra_comentarios WHERE id_lista_negra = '".$idListaNegra."' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
}

?>


<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Recursos Humanos</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Lista negra</li>
</ol>
</div>
   
<div class="row"> 
<div class="col-9">
<h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Lista negra</h3> 
</div>

<div class="col-3">
<button type="button" class="btn btn-labeled2 btn-primary float-end <?=$ocultarbtn?>" onclick="modalBuscar()">
  <span class="btn-label2"><i class="fa fa-search"></i></span>Buscar</button>
</div>

</div>

<hr>
</div>


<?php
if ($numero_lista > 0) {
?>

<div class="row <?=$ocultarbtn?>"> 

<div class="col-9 mb-3">
<h5 class="text-primary"><?=$textoDetalle?></h5>
</div>

<div class="col-3 mb-3">
<a href="app/vistas/contenido/2-recursos-humanos/lista-negra/reporte-lista-negra-pdf.php?fecha_inicio=<?=$fechaInicio?>&fecha_fin=<?=$fechaFin?>" download>
<button type="button" class="btn btn-labeled2 btn-danger float-end">
<span class="btn-label2"><i class="fa-regular fa-file-pdf"></i></span>Decargar PDF</button>        
</a>
</div>
</div>

<div class="table-responsive">
<table id="tabla-principal" class="custom-table" style="font-size: .9em;" width="100%">

<thead class="tables-bg">
<tr> 
  <th class="text-center align-middle ">#</th>
  <th class="align-middle text-start">Nombre completo</th>
  <th class="align-middle text-center">Puesto</th>
  <th class="align-middle text-center">Fecha de baja</th>
  <th class="align-middle text-center" width="150px">Estacion donde se dio de baja</th>
  <th class="align-middle text-center">Motivo de Baja</th>
  <th class="align-middle text-center" width="400px">Descripción</th>
  <th class="align-middle text-center" width="24px"><img src="<?=RUTA_IMG_ICONOS;?>comentario-tb.png"></th>
  <?php if($session_nompuesto != "Encargado" && $session_nompuesto != "Asistente Administrativo"){ ?>
  <th class="align-middle text-center" width="24px"><i class="fas fa-ellipsis-v"></i></th>
<?php } ?>

</tr>
</thead> 

<tbody class="bg-white">
<?php
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$idListaNegra = $row_lista['id'];
$GET_idEstacion = $row_lista['id_estacion'];
$nombre_completo = $row_lista['nombre_completo'];
$fecha = $row_lista['fecha'];
$puesto = $row_lista['puesto'];
$motivo = $row_lista['motivo'];
$detalle = $row_lista['detalle'];

$datosEstaciones = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($GET_idEstacion);
$nombreEstacion = $datosEstaciones['localidad'];

$ToComentarios = ToComentarios($idListaNegra,$con);

if($ToComentarios > 0){
$Nuevo = '<div class="position-absolute" style="margin-bottom: -15px; right: 2px;"><span class="badge bg-danger text-white rounded-circle"><span class="fw-bold" style="font-size: 10px;">'.$ToComentarios.' </span></span></div>';
}else{

$Nuevo = ''; 
}

echo '<tr>';
echo '<th class="text-center align-middle">'.$num.'</th>';
echo '<td class="text-start align-middle">'.$nombre_completo.'</td>';
echo '<td class="text-center align-middle">'.$puesto.'</td>';
echo '<td class="text-center align-middle">'.$ClassHerramientasDptoOperativo->FormatoFecha($fecha).'</td>';
echo '<td class="text-center align-middle"> '.$nombreEstacion.'</td>';
echo '<td class="text-center align-middle">'.$motivo.'</td>';
echo '<td class="text-center align-middle">'.$detalle.'</td>';

echo '<td class="align-middle text-center position-relative" onclick="ComentariosLN('.$idListaNegra.')">'.$Nuevo.'<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png"></td>';

if($session_nompuesto != "Encargado" && $session_nompuesto != "Asistente Administrativo"){

echo '<td class="align-middle text-center">
<div class="btn-group">
<a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
<i class="fas fa-ellipsis-v"></i>
</a>

<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
<a class="dropdown-item" onclick="PruebasLN('.$idListaNegra.')"><i class="fa-regular fa-file-lines"></i> Pruebas</a>
<a class="dropdown-item" onclick="Eliminar('.$GET_idEstacion.','.$idListaNegra.')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>
</div>
</div>
</td>';
}
echo '</tr>';

$num++;
}
?>
</tbody>

</table>
</div>

<div class="row <?=$ocultarbtn?>"> 
<div class="col-12"><?=$btnRegreso?></div>
</div>

<?php
}else{

  echo '<header class="bg-light py-5">
  <div class="container px-5">
  <div class="row gx-5 align-items-center justify-content-center">

  <div class="col-xl-5 col-xxl-6 d-xl-block text-center">
  <img class="my-2" style="width: 100%" src="'.RUTA_IMG_ICONOS.'no-busqueda.png" width="50%">
  </div>
 
  <div class="col-lg-8 col-xl-7 col-xxl-6">
  <div class="my-2 text-center"> 
  <h1 class="display-3 fw-bolder text-dark">No se encontró la información</h1> 
  <h5> del: '.$ClassHerramientasDptoOperativo->FormatoFecha($_GET["fecha_inicio"]).' 
  <br>al: '.$ClassHerramientasDptoOperativo->FormatoFecha($_GET["fecha_fin"]).'</h5>
  
  <button type="button" class="btn btn-labeled2 btn-success mt-3" onclick="SelEstacion()">
  <span class="btn-label2"><i class="fa-solid fa-rotate-left"></i></span>Regresar a la pagina información principal</button>

  </div>
  </div>
  
  </div>
  </div>
  </header>';

}

?>