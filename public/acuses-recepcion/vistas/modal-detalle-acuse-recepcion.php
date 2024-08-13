<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];

$sql = "SELECT * FROM op_acuse_recepcion WHERE id = '".$idReporte."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

$id = $row['id'];
$explode = explode(" ", $row['fecha_creacion']);
$Fecha = $explode[0];
$Hora = date("g:i a",strtotime($explode[1]));
$Empresa = $row['empresa'];
$NombreRecibe = $row['nombre_recibe'];

$NombreEntrega = NombreEntrega($row['personal_entrega'],$con);


$explode1 = explode(" ", $row['fecha']);
$FechaEntrega = FormatoFecha($explode1[0]).', '.date("g:i a",strtotime($explode1[1]));
}

function NombreEntrega($id,$con){
$sql = "SELECT nombre FROM tb_usuarios WHERE id = '".$id."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Nombre = $row['nombre'];
}

return $Nombre;
}

$sql_lista = "SELECT * FROM op_acuse_recepcion_documentos WHERE id_acuse = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);	

?> 

<div class="modal-header">
<h5 class="modal-title">Acuse de Recepción (<?=FormatoFecha($Fecha);?>, <?=$Hora;?>)</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body"> 

<div class="text-secondary">Empresa:</div>
<div class="mb-3"><h6><?=$Empresa;?></h6></div>

<div class="row">

<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-3">
<div class="mb-1 text-secondary">Quién entrega:</div>
<h6><?=$NombreEntrega;?></h6>
</div>

<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-3">
<div class="mb-1 text-secondary">Quién recibió:</div>
<h6><?=$NombreRecibe;?></h6> 
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
<div class="mb-1 text-secondary">Fecha y hora:</div>
<h6><?=$FechaEntrega;?></h6>   
</div>

</div>


<div class="table-responsive">
<table id="tabla_bitacora" class="custom-table mt-3" style="font-size: .9em;" width="100%">
<thead class="tables-bg">

<tr>
<th class="text-center align-middle fw-bold" colspan="5">Documentos</th>
</tr>

 <tr class="title-table-bg">
  <td class="text-center align-middle fw-bold">#</td>
  <th class="align-middle text-center fw-bold">Nombre del documento</th>
  <th class="align-middle text-center fw-bold">Número paginas</th>
  <th class="align-middle text-center fw-bold">Original</th>
  <td class="align-middle text-center fw-bold">Copia</td>
  </tr>
</thead> 

<tbody class="bg-light">
<?php
if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

	if($row_lista['original'] == 0){
    $Original = 'NO';
	}else{
	$Original = '<b>SI</b>';	
	}

	if($row_lista['copia'] == 0){
    $Copia = 'NO';
	}else{
	$Copia = '<b>SI</b>';	
	}

echo '<tr>';
echo '<th class="align-middle text-center">'.$num.'</th>';
echo '<td class="align-middle text-center">'.$row_lista['documento'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['paginas'].'</td>';
echo '<td class="align-middle text-center">'.$Original.'</td>';
echo '<td class="align-middle text-center">'.$Copia.'</td>';
echo '</tr>';

$num++;
}
}else{
echo "<tr><td colspan='7' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>



</div>
