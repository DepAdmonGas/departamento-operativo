<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];
$Categoria = $_GET['Categoria'];
?>
<div class="modal-header">
<h5 class="modal-title">Editar Pivoteo</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
  
 
<div class="modal-body">

<?php 
if($Categoria == 1){
echo '<h6>DOCUMENTACIÓN FACTURADA (CANCELAR)</h6>';
}else{
echo '<h6>DOCUMENTACIÓN A REFACTURAR</h6>';
}
?>


<div class="mt-2 fw-bold text-secondary">ESTACIÓN:</div>
<select class="form-select" id="EstacionFC">
<option></option>
<?php
$sql_lista = "SELECT * FROM tb_estaciones WHERE numlista <= 8";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista); 
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
echo '<option>'.$row_lista['razonsocial'].'</option>';
}
?>
<option>SERVICIO MENA, S.A. DE C.V.</option>
<option>SUPER SERVICIO VALLEJO, S.A. DE C.V.</option>
<option>SUPER SERVICIO PERIFERICO, S.A. DE C.V.</option>
</select>

<div class="border p-3 mt-3">
<div class="text-center"><small>OTRA ESTACIÓN:</small></div>
<hr>

<div class="text-secondary fw-bold">ESTACIÓN:</div>
<input type="text" class="form-control" id="EstacionOtroFC">

<div class="mt-2 text-secondary fw-bold">DESTINO:</div>
<input type="number" class="form-control" id="DestinoOtroFC">

</div>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="Guardar(<?=$idReporte;?>,<?=$Categoria;?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
</div>



