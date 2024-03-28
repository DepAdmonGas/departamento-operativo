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

?>



<div class="border-0 p-3">

    <h5><?=$estacion;?></h5>
    <hr>


    <div class="row">
    
    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-3">
   
    <div class="border p-3 mb-3">
    <h5>Retardo</h5>
    <div class="text-secondary mb-3">Agregar retardo en minutos</div>
    <div class="input-group">
    <input type="number" id="Retardo" class="form-control rounded-0" placeholder="Retardo" aria-label="Retardo" min="0" value="<?=$retardo;?>">
    <span class="input-group-text rounded-0" id="basic-addon2">minutos</span>
    
    </div>
    <div class="text-end mt-3"><button class="btn btn-outline-primary rounded-0 btn-sm" type="button" onclick="Actualizar(<?=$idEstacion;?>)">Actualizar</button></div>
    </div>


    <div class="border p-3">
    <h5>Incidencias</h5>
    <div class="fs-6 fw-light text-secondary mb-3">Agregar días para la resolución de Incidencias</div>
    <div class="input-group">
    <input type="number" id="Incidencia" class="form-control rounded-0" placeholder="Incidencia" aria-label="Incidencia" min="0" value="<?=$incidencia;?>">
    <span class="input-group-text rounded-0" id="basic-addon2">días</span>    
    </div>
    <div class="text-end mt-3"><button class="btn btn-outline-primary rounded-0 btn-sm" type="button" onclick="Actualizar(<?=$idEstacion;?>)">Actualizar</button></div>
    </div>

    </div>


    <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 mb-3">

    <div class="border p-3">


    <h5>Horarios</h5>  

    <div class="fw-light text-secondary mb-0">
    Lista de horarios  

    <div class="float-end"> 
    <img class="pointer" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="ModalAgregar(<?=$idEstacion;?>)"/>
    </div>

    </div>

    <hr>

    <div class="table-responsive">
        <table class="table table-sm table-bordered table-striped table-hover">
        <thead class="tables-bg">
        <tr>
        <th class=text-center align-middle>#</th>
        <th class="align-middle">Titulo horario</th>
        <th class="align-middle">Hora entrada</th>
        <th class="align-middle">Hora salida</th>
        <th class="text-center align-middle" width="32px"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png" /></th>
        <th class="text-center align-middle" width="32px"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png" /></th>
        </thead>
        </tr>

        <tbody>
        <?php
        if($numero > 0){
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

        $id = $row['id'];

        echo '<tr>';
        echo '<td class="text-center align-middle">'.$row['id'].'</td>';
        echo '<td class="align-middle"><b>'.$row['titulo'].'</b></td>';
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

    </div>



    </div>