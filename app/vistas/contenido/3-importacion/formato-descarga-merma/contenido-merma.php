<?php
require ('../../../../help.php');
$idEstacion = $_GET['idEstacion'];
$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($idEstacion);

if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
$ocultarOp = "";
$tituloMenu = "Importación";
$Estacion = '';

}else{

$Estacion = '('.$datosEstacion['localidad'].')';
$ocultarOp = "d-none";
 
if($Session_IDUsuarioBD == 346){
$tituloMenu = "Inicio";
    
}else{ 
$tituloMenu = "Importacion";
}
    
} 
?>
  
 
<div class="col-12 mb-3">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> <?=$tituloMenu?></a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Formato de descarga de merma <?=$Estacion?></li>
</ol>
</div>

<div class="row">
<div class="col-9">
<h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Formato de descarga de merma <?=$Estacion?></h3>
</div>

<div class="col-3 <?=$ocultarOp?>">
<button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="CrearDescarga(<?=$idEstacion?>)">
<span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
</div>

</div>
<hr>
</div>

<div class="table-responsive">

<table id="tabla_merma" class="custom-table" style="font-size: .9em;" width="100%">
<thead class="tables-bg">
<tr>
<th class="align-middle text-center" width="40px">Folio</th>
<th class="align-middle text-start">Fecha y hora</th>
<th class="align-middle text-center">Responsable</th>
<th class="align-middle text-center">Producto</th>
<th class="align-middle text-center" width="20"><i class="fa-solid fa-ellipsis-vertical text-white"></i></th>
</th>
</tr>
</thead>

<tbody class="bg-white">

<?php
$sql_lista = "SELECT * FROM op_descarga_tuxpa WHERE id_estacion = '".$idEstacion."' ORDER BY folio desc";

$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
  
if ($numero_lista > 0) :

while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) :
$id = $row_lista['id'];
$folio = $row_lista['folio'];
$fechallegada = FormatoFecha($row_lista['fecha_llegada']);
$horallegada = date("g:i a", strtotime($row_lista['hora_llegada'])); 

$datosPersonal = $ClassHerramientasDptoOperativo->obtenerDatosUsuario($row_lista['id_usuario']);

// Verificar si $datosPersonal no es null
 if ($datosPersonal !== null && isset($datosPersonal['nombre'])) {
$responsable = $datosPersonal['nombre'];
} else {
// Asignar un valor predeterminado si $datosPersonal es null o no tiene 'nombre'
$responsable = '';
}

$Detalle = '<a class="dropdown-item" onclick="Detalle('.$id.')"><i class="fa-regular fa-eye"></i> Detalle</a>';
$PDF = '<a class="dropdown-item" onclick=PDF(' . $id . ')><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
echo '<tr>
<th class="align-middle text-center">00' . $folio . '</th>
<td class="align-middle text-start">' . $fechallegada . ', ' . $horallegada . '</td>
<td class="align-middle text-center">' . $responsable . '</td>
<td class="align-middle text-center">'.$row_lista['producto'].'</td>
';
echo '<td class="align-middle text-center">
                  <div class="dropdown">

                  <a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-ellipsis-v"></i>
                  </a>

                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                  ' . $Detalle . '
                  ' . $PDF . '
                  </div>
                  </div>
                </td>
                </tr>';
endwhile;
endif;
?>

</tbody>
</table>
</div>