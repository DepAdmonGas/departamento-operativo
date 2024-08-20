<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$idReporte = $_GET['idReporte'];

function Refaccion($idrefaccion,$con){
$sql_lista = "SELECT * FROM op_refacciones WHERE id = '".$idrefaccion."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$nombre = $row_lista['nombre'];
}
return $nombre;
}

$sql_reporte = "SELECT * FROM op_refacciones_reporte WHERE id = '".$idReporte."' ";
$result_reporte = mysqli_query($con, $sql_reporte);
$numero_reporte = mysqli_num_rows($result_reporte);
while($row_reporte = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)){
$fecha = $row_reporte['fecha']; 
$hora = $row_reporte['hora']; 
$dispensario = $row_reporte['dispensario'];
$motivo = $row_reporte['motivo']; 
$status = $row_reporte['status']; 
}
?>

  <script type="text/javascript">
  $('.selectize').selectize({
      sortField: 'text'
    });
  </script>


<div class="modal-header">
<h5 class="modal-title">Reporte de refacciones</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

        <div class="row">
        

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
        <div class="mb-1 text-secondary">* Fecha:</div>
        <input type="date" class="form-control rounded-0" id="Fecha" value="<?=$fecha;?>">
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
        <div class="mb-1 text-secondary">* Hora:</div>
        <input type="time" class="form-control rounded-0" id="Hora" value="<?=$hora;?>">
        </div>

        <div class="col-12 mb-2">
        <div class="mb-1 text-secondary">* Dispensario:</div>
        <input type="text" class="form-control rounded-0" id="Dispensario" value="<?=$dispensario;?>">
        </div>


        <div class="col-12 mb-2">
        <div class="mb-1 text-secondary">* Motivo:</div>
        <textarea class="form-control rounded-0" id="Motivo"><?=$motivo;?></textarea>
        </div>


        <div class="col-12 mb-2">
        <div class="mb-1 text-secondary">* Archivo:</div>
        <input type="file" class="rounded-0 form-control" id="seleccionArchivos">  
        </div>

        </div>



<?php  if($status == 1){ ?>
        <hr>

        <h6>Refacciones utilizadas</h6>

        <div class="row">

        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12mb-2">
        <div class="mb-1 text-secondary">Refacción:</div>
        <select class="selectize rounded-0" id="Refaccion">
        <option value="">Selecciona una opción...</option>
        <?php 
        $sql_lista = "SELECT * FROM op_refacciones WHERE id_estacion = '".$idEstacion."' AND unidad > 0 AND status = 1 ORDER BY id ASC";
        $result_lista = mysqli_query($con, $sql_lista);
        $numero_lista = mysqli_num_rows($result_lista);
        while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
        echo '<option value="'.$row_lista['id'].'">'.$row_lista['nombre'].'</option>';
        }
        ?>
        </select>  
        </div>

        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-2">
        <div class="mb-1 text-secondary">Unidad utilizada:</div>
        <input type="number" class="form-control rounded-0" id="Unidad">
        </div>

        </div> 



<div class="table-responsive">
<table class="custom-table mt-2" style="font-size: .8em;" width="100%">
<thead class="tables-bg">
  <tr>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>#</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Refacción</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Unidad</b></td>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
  </tr>
</thead> 

<tbody class="bg-light">
<?php
$sql_detalle = "SELECT * FROM op_refacciones_reporte_detalle WHERE id_reporte = '".$idReporte."' ";
$result_detalle = mysqli_query($con, $sql_detalle);
$numero_detalle = mysqli_num_rows($result_detalle);

if ($numero_detalle > 0) {
while($row_detalle = mysqli_fetch_array($result_detalle, MYSQLI_ASSOC)){

$id = $row_detalle['id'];
$idRefaccion = $row_detalle['id_refaccion'];
$NomRefaccion = Refaccion($idRefaccion, $con);
$unidad = $row_detalle['unidad'];
echo '<tr>';
echo '<th class="align-middle text-center">'.$id.' </th>';
echo '<td class="align-middle text-center">'.$NomRefaccion.'</td>';
echo '<td class="align-middle text-center">'.$unidad.'</td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarRefaccionReporte('.$idEstacion.','.$idReporte.', '.$id.', '.$idRefaccion.')"></td>';
echo '</tr>';
}
}else{
echo "<tr><th colspan='8' class='text-center text-secondary fw-normal no-hover2'><small>No se encontró información para mostrar </small></th></tr>";
}
?>
</tbody>
</table>
</div>

<?php  } ?>
</div>



<div class="modal-footer">

<?php  if($status == 0){ ?>

<button type="button" class="btn btn-labeled2 btn-success" onclick="GuardarReporte(<?=$idEstacion;?>,<?=$idReporte;?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
<?php }else{?>


<button type="button" class="btn btn-labeled2 btn-success" onclick="AgregarRR(<?=$idEstacion;?>,<?=$idReporte;?>)">
<span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar Refacción</button>

<?php } ?>

</div>


