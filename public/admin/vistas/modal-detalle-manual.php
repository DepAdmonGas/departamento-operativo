 <?php
require('../../../app/help.php');
$idManual = $_GET['idManual'];

$sql_listManuales = "SELECT descripcion, fecha, documento FROM tb_manuales_do WHERE id_manuales_do = ".$idManual." "; 

$result_listManuales = mysqli_query($con, $sql_listManuales);
$numero_listManuales = mysqli_num_rows($result_listManuales);

while($row_listManuales = mysqli_fetch_array($result_listManuales, MYSQLI_ASSOC)){


$descripcion = $row_listManuales['descripcion'];
$documento = $row_listManuales['documento'];

$explode = explode(' ', $row_listManuales['fecha']);
$fecha_dia = FormatoFecha($explode[0]);
}

?>


<div class="modal-header">
<h5 class="modal-title">Detalle manual de procedimientos</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
 
 
<div class="modal-body">
	
<div class="row">

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2" style="font-size:0.9em"> 
<div class="font-weight-bold"><b>Descripción:</b></div>
<?=$descripcion;?>
</div>  


<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2" style="font-size:0.9em"> 
<div class="font-weight-bold"><b>Fecha:</b></div>
<?=$fecha_dia;?>
</div> 
 

<div class="col-12 mb-2"> 
<iframe class="border-0 mt-2 mb-3" src="<?php echo RUTA_ARCHIVOS?>/manual-procedimiento/<?=$documento;?>" width="100%" height="600px">
</iframe>

</div> 



</div>

</div>
    
   <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger" onclick="eliminarManual(<?=$idManual?>)">Eliminar</button>
   </div>