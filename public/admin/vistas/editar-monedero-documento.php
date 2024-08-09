<?php
require('../../../app/help.php');

$IdReporte = $_GET['IdReporte'];
$year = $_GET['year'];
$mes = $_GET['mes'];
$id = $_GET['id'];

$sql_lista = "SELECT * FROM op_monedero_documento WHERE id = '".$id."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$fecha = $row_lista['fecha']; 
$monedero = $row_lista['monedero']; 
$diferencia = $row_lista['diferencia']; 
}
?>

<div class="modal-body"> 

<div class="row">

<div class="col-12">
<div class="mb-1 text-secondary">Agregar fecha</div>
<input type="date" class="form-control" id="Fecha" value="<?=$fecha;?>">
</div>


<div class="col-12 mb-2">
<div class="mb-1 text-secondary">Agregar monedero</div>
<select class="form-select" id="Cilote">
<option><?=$monedero;?></option>
<option>Edenred</option>
<option>Efectivale</option>
<option>Inburgas</option>
<option>Ultragas</option>
<option>Sodexo</option>
</select>
</div>


<div class="col-12 mb-2">
<div class="mb-1 text-secondary">Diferencia</div>
<input class="form-control" type="number" class="form-control" id="Diferencia" step="any" value="<?=$diferencia;?>">
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
<div class="mb-1 text-secondary">Agregar PDF</div>
<input class="form-control" type="file" id="PDF">
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
<div class="mb-1 text-secondary">Agregar XML</div>
<input class="form-control" type="file" id="XML">
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
<div class="mb-1 text-secondary">Agregar EXCEL</div>
<input class="form-control" type="file" id="EXCEL">
</div>


<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
<div class="mb-2 text-secondary">Soporte de diferencia</div>
<input class="form-control" type="file" id="SoporteD">
</div>

</div>
</div>

        
<div class="modal-footer"> 

<button type="button" class="btn btn-labeled2 btn-danger" onclick="Cancelar(<?=$IdReporte;?>,<?=$year;?>,<?=$mes;?>)">
<span class="btn-label2"><i class="fa fa-xmark"></i></span>Cancelar</button>


<button type="button" class="btn btn-labeled2 btn-success" onclick="EditarInfo(<?=$IdReporte;?>,<?=$year;?>,<?=$mes;?>,<?=$id;?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>


</div>