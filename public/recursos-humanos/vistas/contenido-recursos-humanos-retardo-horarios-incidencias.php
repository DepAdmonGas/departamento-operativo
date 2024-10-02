<?php 
require('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];
$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}

$sql = "SELECT * FROM op_rh_localidades_horario WHERE id_estacion = '".$idEstacion."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

//-------------------------------------------------------
RetardoIncidencias($idEstacion,$con);

function RetardoIncidencias($idEstacion,$con){
$sqlReIn = "SELECT * FROM op_rh_localidades_retardo_incidencia WHERE id_estacion = '".$idEstacion."' ";
$resultReIn = mysqli_query($con, $sqlReIn);
$numeroReIn = mysqli_num_rows($resultReIn);
if($numeroReIn == 0){

$sql = "INSERT INTO op_rh_localidades_retardo_incidencia (
    id_estacion,
    retardo,
    incidencia
    )
    VALUES 
    (
    '".$idEstacion."',
    '',
    ''
    )";

if(mysqli_query($con, $sql)) {
return true;
}else{
return false;
}
 
}else{}
}
//---------------------------------------------

$sqlRI = "SELECT * FROM op_rh_localidades_retardo_incidencia WHERE id_estacion = '".$idEstacion."' ";
$resultRI = mysqli_query($con, $sqlRI);
$numeroRI = mysqli_num_rows($resultRI);  
while($rowRI = mysqli_fetch_array($resultRI, MYSQLI_ASSOC)){
$retardo = $rowRI['retardo'];
$incidencia = $rowRI['incidencia'];
}


if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
$titleName = "Biometrico";
}else{
$titleName = "Configuración";
}


?>
 

<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> <?=$titleName?></a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Retardos, Horarios e Incidencias</li>
</ol>
</div>

<div class="row">
<div class="col-9">
<h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Retardos, Horarios e Incidencias</h3>
</div>

<div class="col-3">
<button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="ModalAgregar(<?=$idEstacion;?>)">
<span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
</div>

</div>

<hr>
</div>


<div class="row">
    
<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
<div class="table-responsive">
<table class="custom-table" style="font-size: 12.5px;" width="100%">
<thead class="tables-bg">
<tr> <th class="align-middle text-center">Retardo <br> <small class="text-white">Agregar retardo en minutos</small> </th> </tr>
</thead>
<tbody class="bg-white">
    
<tr>
<th class="align-middle text-center p-0">    
<div class="input-group">
<input type="number" id="Retardo" class="form-control rounded-0 border-0" placeholder="Retardo" aria-label="Retardo" min="0" value="<?=$retardo;?>">
<span class="input-group-text rounded-0 border-0 bg-white" id="basic-addon2">minutos</span>
</div>
</th>
</tr>

<tr>
<th class="align-middle text-center p-2 bg-success text-white" onclick="Actualizar(<?=$idEstacion;?>)">  
Actualizar Minutos      
</th>
</tr>

</tbody>
</table>
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
<div class="table-responsive">
<table class="custom-table" style="font-size: 12.5px;" width="100%">
<thead class="tables-bg">
<tr> <th class="align-middle text-center">Incidencias <br> <small class="text-white">Agregar días para la resolución de Incidencias</small> </th> </tr>
</thead>
<tbody class="bg-white">
    
<tr>
<th class="align-middle text-center p-0">    
<div class="input-group">
<input type="number" id="Incidencia" class="form-control rounded-0 border-0" placeholder="Incidencia" aria-label="Incidencia" min="0" value="<?=$incidencia;?>">
<span class="input-group-text rounded-0 border-0 bg-white" id="basic-addon2">días</span>
</div>
</th>
</tr>

<tr>
<th class="align-middle text-center p-2 bg-success text-white" onclick="Actualizar(<?=$idEstacion;?>)">  
Actualizar Días
</th>
</tr>

</tbody>
</table>
</div>
</div>


<div class="col-12">
<div class="table-responsive">
<table class="custom-table" style="font-size: 12.5px;" width="100%">

<thead class="tables-bg">
<tr>
<th class="text-center align-middle" colspan="6">Horarios <br> <small class="text-white">Lista de horarios  </small></th>
</tr>

<tr class="title-table-bg">
<td class="text-center align-middle fw-bold">#</td>
<th class="align-middle">Titulo horario</th>
<th class="align-middle">Hora entrada</th>
<th class="align-middle">Hora salida</th>
<th class="text-center align-middle" width="32px"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
<td class="text-center align-middle" width="32px"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></td>
</thead>
</tr>

        <tbody class="bg-light">
        <?php
        if($numero > 0){
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

        $id = $row['id'];

        echo '<tr>';
        echo '<th class="text-center align-middle fw-normal">'.$row['id'].'</th>';
        echo '<td class="align-middle">'.$row['titulo'].'</td>';
        echo '<td class="align-middle">'.$row['hora_entrada'].'</td>';
        echo '<td class="align-middle">'.$row['hora_salida'].'</td>';
        echo '<td class="text-center align-middle"> <img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" class="pointer" 
        onclick="editarHorario('.$idEstacion.','.$id.')"> </td>';
        echo '<td class="text-center align-middle"> <img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" class="pointer"
        onclick="eliminarHorario('.$idEstacion.','.$id.')"/> </td>';
        echo '</tr>';

        }
        }else{
        echo "<tr><td colspan='6' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";    
        }

?>
</tbody>
</table>
</div>
 
</div>
</div>  



