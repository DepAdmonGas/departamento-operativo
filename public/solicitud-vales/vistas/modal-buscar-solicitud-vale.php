<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$GET_year = $_GET['year'];
$GET_mes = $_GET['mes'];
$depu = $_GET['depu'];
$orderFolio = $_GET['orderFolio'];
$orderFecha = $_GET['orderFecha'];

$orderCuenta = $_GET['orderCuenta'];
$orderMonto = $_GET['orderMonto'];
$orderSolicitante = $_GET['orderSolicitante'];

$sql_lista = "SELECT solicitante FROM op_solicitud_vale WHERE id_year = '".$GET_year."' AND id_mes = '".$GET_mes."' GROUP BY solicitante";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>  
<div class="modal-header">
<h5 class="modal-title">Buscar</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="mb-1 text-secondary">Nombre del solicitante</div>
<select class="form-select" id="BuscarSolicitante">
<option value=""></option>
<?php 
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
echo '<option value="'.$row_lista['solicitante'].'">'.$row_lista['solicitante'].'</option>';
}
?> 
</select>

<div class="mb-1 mt-2 text-secondary">Cargo a cuenta</div>
<select class="form-select" id="BuscarSolicitante">
<option value=""></option>
<?php 
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
echo '<option value="'.$row_lista['solicitante'].'">'.$row_lista['solicitante'].'</option>';
}
?> 
</select>

</div>


<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="Buscar(<?=$idEstacion;?>,<?=$depu;?>,<?=$GET_year;?>,<?=$GET_mes;?>,'<?=$orderFolio;?>','<?=$orderFecha;?>','<?=$orderCuenta;?>','<?=$orderMonto;?>','<?=$orderSolicitante;?>')">Buscar</button>
</div>

