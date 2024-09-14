<?php
require('../../../app/help.php');
$idPersonal = $_GET['idPersonal'];
$Year = $_GET['Year'];

$datosUsuario = $ClassHerramientasDptoOperativo->obtenerDatosPersonal($idPersonal);
$NomUsuario = $datosUsuario['nombre_personal'];

$sql = "SELECT 
op_rh_formatos.id,
op_rh_formatos.id_localidad,
op_rh_formatos.status,
op_rh_formatos_vacaciones.id_usuario,
op_rh_formatos_vacaciones.num_dias,
op_rh_formatos_vacaciones.fecha_inicio,
op_rh_formatos_vacaciones.fecha_termino,
op_rh_formatos_vacaciones.fecha_regreso,
op_rh_formatos_vacaciones.observaciones
FROM op_rh_formatos 
RIGHT JOIN op_rh_formatos_vacaciones 
ON op_rh_formatos.id = op_rh_formatos_vacaciones.id_formulario 
WHERE op_rh_formatos_vacaciones.id_usuario = '".$idPersonal."' AND YEAR(fecha_inicio) = '".$Year."' ORDER BY id ASC";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

?>


<div class="modal-header">
<h5 class="modal-title">Detalle Vacaciones <?=$Year?> - <?=$NomUsuario?></h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="table-responsive">
<table id="tabla_bitacora" class="custom-table" style="font-size: 12.5px;" width="100%">

    <thead class="tables-bg">
        <tr>
        <th class="align-middle text-center" width="80px">#</th>
        <th class="align-middle text-center">Fecha de Inicio</th>
        <th class="align-middle">Fecha de Termino</th>
        <th class="align-middle">Dias</th>
        <th class="align-middle text-center" width="32px"><img src="<?=RUTA_IMG_ICONOS?>ver-tb.png"></th>
        <th class="align-middle text-center" width="32px"><img src="<?=RUTA_IMG_ICONOS?>eliminar.png"></th>

     </tr>
    </thead>

    <tbody class="bg-light"> 
    <?php 
    if ($numero > 0) {
    $num = 1;
    $sumaDias = 0;
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $idReporte = $row['id'];
    $numdias = $row['num_dias'];
    $fechainicio = $row['fecha_inicio'];
    $fechatermino = $row['fecha_termino'];
    $fecharegreso = $row['fecha_regreso'];
    $status = $row['status'];
    $Localidad = $row['id_localidad'];
    $observaciones = $row['observaciones'];


    if($status == ""){
    $trColor = 'style="background-color: #ffb6af"';
    $detalle = '<img src="'.RUTA_IMG_ICONOS.'ver-tb.png" class="grayscale">';
    $eliminar = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" class="grayscale">'; 

    }else{ 
    $trColor = "";
    $detalle = '<img src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="detalleVacaciones2('.$idReporte.', '.$idPersonal.', '.$Year.')">';
    $eliminar = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="DeleteFormulario('.$Localidad.','.$idPersonal.','.$Year.','.$idReporte.')">';    
    }
      
    echo '<tr '.$trColor.'>
    <th class="align-middle text-center">'.$num.'</th>
    <td class="align-middle text-center">'.$ClassHerramientasDptoOperativo->FormatoFecha($fechainicio).'</td>
    <td class="align-middle text-center">'.$ClassHerramientasDptoOperativo->FormatoFecha($fechatermino).'</td>
    <td class="align-middle text-center">'.$numdias.'</td>
    <td class="align-middle text-center" width="32px">'.$detalle.'</td>
    <td class="align-middle text-center" width="32px">'.$eliminar.'</td>
    </tr>';
    
    if($status == ""){
    $numdiasVal = 0;
    }else{
    $numdiasVal = $numdias;
    }

    $sumaDias = $sumaDias + $numdiasVal;
    $num++;
    }

    echo '<tr>
    <th class="align-middle text-end" colspan="3" >Total Dias:</th>
    <th class="align-middle text-center">'.$sumaDias.'</th>
    <th class="align-middle text-center" colspan="2"></th>
    </tr>';


    }else{
    echo "<tr style='background-color: #fff'>
    <th colspan='9' class='text-center text-secondary fw-normal bg-light'><small>No se encontró información para mostrar </small></th>
    </tr>";
    }
    
  ?>
  </tbody>
  </table>
  </div>

  </div>

  <div class="modal-footer">
  <button type="button" class="btn btn-labeled2 btn-danger" data-bs-dismiss="modal">
  <span class="btn-label2"><i class="fa-solid fa-xmark"></i></span>Cerrar</button>
  </div>