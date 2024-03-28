<?php
require('../../../app/help.php');
$idComunicado = $_GET['idComunicado'];

$sql_listComunicados = "SELECT titulo, fecha, archivo FROM tb_comunicados_do WHERE id_comunicado = ".$idComunicado." "; 

$result_listComunicados = mysqli_query($con, $sql_listComunicados);
$numero_listComunicados = mysqli_num_rows($result_listComunicados);

while($row_listComunicados = mysqli_fetch_array($result_listComunicados, MYSQLI_ASSOC)){


$titulo = $row_listComunicados['titulo'];
$archivo = $row_listComunicados['archivo'];

$explode = explode(' ', $row_listComunicados['fecha']);
$fecha_dia = FormatoFecha($explode[0]);
}

?>


<div class="modal-header">
<h5 class="modal-title">Detalle comunicado</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
 
 
<div class="modal-body">
	
<div class="row">

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2" style="font-size:0.9em"> 
<div class="font-weight-bold"><b>Titulo:</b></div>
<?=$titulo;?>
</div>  


<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2" style="font-size:0.9em"> 
<div class="font-weight-bold"><b>Fecha:</b></div>
<?=$fecha_dia;?>
</div> 
 

<div class="col-12 mb-2"> 
<iframe class="border-0 mt-2 mb-3" src="<?php echo RUTA_ARCHIVOS?>/comunicados/<?=$archivo;?>" width="100%" height="600px">
</iframe>

</div> 


<div class="col-12"> 
<div class="font-weight-bold" style="font-size:0.9em"><b>Personal que visualizo el comunicado:</b></div>

  
<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0 mt-1 font-weight-light" style="font-size:0.9em">

<thead class="tables-bg">
	<th class="align-middle text-center">Nombre del gerente</th>
	<th class="align-middle text-center">Estacion</th>
	<th class="align-middle text-center">Fecha de visualización</th>	
</thead>

<tbody>
<?php

$sql_lista = "SELECT 

tb_usuarios.nombre as nombreUSU,
tb_estaciones.nombre as nombreES,
tb_comunicados_grte.fecha as fechaVS

FROM tb_comunicados_grte

INNER JOIN tb_usuarios
ON tb_comunicados_grte.id_gerente = tb_usuarios.id

INNER JOIN tb_estaciones
ON tb_usuarios.id_gas = tb_estaciones.id

WHERE tb_comunicados_grte.id_comunicado = ".$idComunicado." ORDER BY tb_comunicados_grte.fecha ASC";

$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {

while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$nombreEngargado = $row_lista['nombreUSU'];
$nombreEstacion = $row_lista['nombreES'];

$explode = explode(' ', $row_lista['fechaVS']);

$fechaVs = FormatoFecha($explode[0]);
$horaVS = date("g:i a",strtotime($row_lista['fechaVS']));


  

echo '<tr>';

echo '<td class="text-center align-middle">'.$nombreEngargado.'</td>';
echo '<td class="text-center align-middle">'.$nombreEstacion.'</td>';
echo '<td class="text-center align-middle">'.$fechaVs.', '.$horaVS.'</td>';

echo '</tr>';

}
}else{
echo "<tr><td colspan='3' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";	
}
?>

</tbody>
</table>
</div>

 

</div> 


</div>

</div>
    