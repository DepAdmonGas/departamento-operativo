 <?php
require('../../../app/help.php');
$idLicitacion = $_GET['idLicitacion'];

$sql_listLicitacion = "SELECT fecha, nombre_formato, archivo FROM op_licitacion_municipal WHERE id = ".$idLicitacion." "; 

$result_listLicitacion = mysqli_query($con, $sql_listLicitacion);
$numero_listLicitacion = mysqli_num_rows($result_listLicitacion);

while($row_listLicitacion = mysqli_fetch_array($result_listLicitacion, MYSQLI_ASSOC)){

$explode = explode(' ', $row_listLicitacion['fecha']);
$fecha_dia = FormatoFecha($explode[0]);

$nombre_formato = $row_listLicitacion['nombre_formato'];
$archivo = $row_listLicitacion['archivo'];

}

?>


<div class="modal-header">
<h5 class="modal-title">Detalle Licitancia Municipal</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
 
 
<div class="modal-body">
	
<div class="row">

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2" style="font-size:0.9em"> 
<div class="font-weight-bold"><b>Nombre del formato:</b></div>
<?=$nombre_formato;?>
</div>  


<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2" style="font-size:0.9em"> 
<div class="font-weight-bold"><b>Fecha:</b></div>
<?=$fecha_dia;?>
</div> 
 

<div class="col-12 mb-2"> 
<iframe class="border-0 mt-2 mb-3" src="<?php echo RUTA_ARCHIVOS?>licitacion-municipal/<?=$archivo;?>" width="100%" height="600px">
</iframe>

</div> 



</div>

</div>
    
   <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
   </div>