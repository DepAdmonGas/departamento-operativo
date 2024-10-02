<?php
require('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];
 
$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}

$sql_poliza_inc = "SELECT * FROM op_poliza_incidencia WHERE id_estacion = '".$idEstacion ."' ORDER BY id_poliza_incidencia DESC ";  
$result_poliza_inc = mysqli_query($con, $sql_poliza_inc);
$numero_poliza_inc = mysqli_num_rows($result_poliza_inc);
?>
 
<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.go(-1)"  class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Corporativo</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase"> Seguros (<?=$estacion;?>) </li>
</ol>
</div>
 
<div class="row"> 
<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 mb-1"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Seguros (<?=$estacion;?>)</h3> </div>

<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mt-1"> 
<div class="text-end">
 <div class="dropdown d-inline ms-2 <?=$ocultarbtnEn?>">
 <button type="button" class="btn dropdown-toggle btn-primary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
 <i class="fa-solid fa-screwdriver-wrench"></i></span>
 </button>

<ul class="dropdown-menu">
<li onclick="ModalAgregarIncidente(<?=$idEstacion;?>)"><a class="dropdown-item pointer"><i class="fa-solid fa-plus text-dark"></i> Agregar</a></li>
<li onclick="ModalPoliza(<?=$idEstacion;?>)"><a class="dropdown-item pointer"><i class="fa-regular fa-file-lines"></i> Poliza de Seguro</a></li>
</ul>
</div>
</div>
 
</div>
</div>
<hr>
</div>
 

<div class="table-responsive">
<table id="tabla_seguros_<?=$idEstacion?>" class="custom-table" style="font-size: 12.5px;" width="100%">

<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle" width="40">#</th>
  <th class="text-center align-middle">Fecha</th>
  <th class="text-center align-middle">Hora</th>

  <th class="text-center align-middle">Asunto</th>
  <th class="text-start align-middle">Observaciones</th>
  <th class="text-start align-middle">Solucion</th>
  <th class="align-middle text-center" width="20"><i class="fas fa-ellipsis-v"></i> </th>
  </tr>
</thead> 
 
<tbody class="bg-white">
<?php 
$i = 1;
if ($numero_poliza_inc > 0) {
while($row_poliza_inc = mysqli_fetch_array($result_poliza_inc, MYSQLI_ASSOC)){
$id_poliza_inc = $row_poliza_inc['id_poliza_incidencia'];

if($row_poliza_inc['archivo'] != ""){ 
$PDF = '<a class="dropdown-item" href="'.RUTA_ARCHIVOS.'incidencias-poliza-es/'.$row_poliza_inc['archivo'].'" download><i class="fa-solid fa-file-arrow-down"></i> Descargar archivo</a>';
}else{
$PDF = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-arrow-down"></i> Descargar archivo</a>';

}  

echo '<tr >
<th class="text-center align-middle">'.$i.'</th>
<td class="text-center align-middle">'.$ClassHerramientasDptoOperativo->FormatoFecha($row_poliza_inc['fecha']).'</td>
<td class="align-middle">'.date("g:i a",strtotime($row_poliza_inc['hora'])).'</td>
<td class="text-center align-middle">'.$row_poliza_inc['asunto'].'</td>
<td class="text-start align-middle">'.$row_poliza_inc['observaciones'].'</td>
<td class="text-start align-middle">'.$row_poliza_inc['solucion'].'</td>


<td class="text-center align-middle">
    <div class="dropdown-container">
        <a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-ellipsis-v"></i>
        </a>

        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton1">
  <a class="dropdown-item" onclick="DetallePolizaInc('.$id_poliza_inc.')"><i class="fa-regular fa-eye"></i> Detalle</a>
'.$PDF.'
<a class="dropdown-item" onclick="ModalEditarIncP('.$id_poliza_inc.')"><i class="fa-solid fa-pencil"></i> Editar</a>
<a class="dropdown-item" onclick="EliminarInc('.$id_poliza_inc.','.$idEstacion.')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>
        </ul>
    </div>
</td>

</tr>';
$i++;
} 
}
?>
</tbody>
</table> 
</div>


