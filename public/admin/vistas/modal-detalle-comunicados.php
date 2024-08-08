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

?>

<div class="modal-header">
<h5 class="modal-title">Detalle comunicado</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
<iframe class="border-0 mt-2 mb-3" src="<?=RUTA_ARCHIVOS?>/comunicados/<?=$archivo;?>" width="100%" height="600px">
</iframe>

</div> 


<div class="col-12"> 

<div class="table-responsive">
<table class="custom-table" style="font-size:0.9em" width="100%">

<thead class="tables-bg">

<tr>
<th class="align-middle text-center" colspan="3">Personal que visualizo el comunicado</th>
</tr>

<tr class="title-table-bg">
<td class="align-middle text-center fw-bold">Nombre del gerente</td>
<th class="align-middle text-center">Estacion</th>
<td class="align-middle text-center fw-bold">Fecha de visualización</td>
</tr>
	
</thead>

<tbody class="bg-light">
<?php

if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$nombreEngargado = $row_lista['nombreUSU'];
$nombreEstacion = $row_lista['nombreES'];

$explode = explode(' ', $row_lista['fechaVS']);

$fechaVs = FormatoFecha($explode[0]);
$horaVS = date("g:i a",strtotime($row_lista['fechaVS']));


echo '<tr>';

echo '<th class="text-center align-middle fw-normal">'.$nombreEngargado.'</th>';
echo '<td class="text-center align-middle">'.$nombreEstacion.'</td>';
echo '<td class="text-center align-middle">'.$fechaVs.', '.$horaVS.'</td>';

echo '</tr>';

}
}else{
echo "<tr><th colspan='3' class='text-center text-secondary fw-normal no-hover2'><small>No se encontró información para mostrar </small></th></tr>";	
}
?>

</tbody>
</table>
</div>

 

</div> 


</div>

</div>
    