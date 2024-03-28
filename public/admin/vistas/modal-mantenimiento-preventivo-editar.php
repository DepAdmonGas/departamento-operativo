<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];
$idEstacion = $_GET['idEstacion'];

$sql_lista = "SELECT * FROM op_mantenimiento_preventivo WHERE id = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){ 
$nombre = $row_lista['id_encargado']; 
$fecha = $row_lista['fecha']; 
$fecha2 = $row_lista['fecha2']; 
$observaciones = $row_lista['observaciones']; 

}


$sql_personal = "SELECT id, nombre FROM tb_usuarios
WHERE id_gas = '".$idEstacion."' AND id_puesto = 6 ORDER BY nombre ASC ";
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);

function NombrePersonal($id,$con){

$sql_personal = "SELECT nombre FROM tb_usuarios WHERE id = '".$id."' ";
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);
while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
$return = $row_personal['nombre']; 
}
return $return;
}

?>
      <div class="modal-header">
        <h5 class="modal-title">Mantenimiento preventivo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">

        <div class="mb-1 text-secondary">Encargado:</div>        
        <select class="form-select" id="Nombre">
        <option value="<?=$nombre?>"><?=NombrePersonal($nombre,$con)?></option>
        <?php 
        while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
        echo '<option value="'.$row_personal['id'].'">'.$row_personal['nombre'].'</option>';
        }
        ?>
        </select>
    


        <div class="mb-1 mt-2 text-secondary">Fechas de prueba de eficiencia:</div>
        <div class="row">
          
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
        <input type="date" class="form-control" id="Fecha" value="<?=$fecha;?>">
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
        <input type="date" class="form-control" id="Fecha2" value="<?=$fecha2;?>">
        </div>

      </div>
        

        <div class="mb-1 mt-2 text-secondary mt-2">Orden de servicio:</div>
        <input class="form-control" type="file" id="Archivo">


        <div class="mb-1 mt-2 text-secondary mt-2">Observación:</div>
        <textarea class="form-control" id="Observacion"><?=$observaciones;?></textarea>

       

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Guardar(<?=$idEstacion;?>,<?=$idReporte;?>)">Guardar</button>
      </div> 