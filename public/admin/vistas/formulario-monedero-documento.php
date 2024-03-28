<?php
require('../../../app/help.php');
$IdReporte = $_GET['IdReporte'];
$year = $_GET['year'];
$mes = $_GET['mes'];

?>


  
<div class="row">
 
<div class="col-12 mb-2">
<div class="mb-1 text-secondary">Agregar fecha</div>
        <input type="date" class="form-control" id="Fecha">
</div>

<div class="col-12 mb-2"> 
  <div class="mb-1 text-secondary">Agregar monedero</div>
  <select class="form-select" id="Cilote">
  <option></option>
  <option>Edenred</option>
  <option>Efectivale</option>
  <option>Inburgas</option>
  <option>Ultragas</option>
  <option>Sodexo</option>
  </select>
</div>

<div class="col-12 mb-2"> 
    <div class="mb-1 text-secondary">Diferencia</div>
    <input type="number" class="form-control" id="Diferencia" step="any">
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3"> 
        <div class="mb-1 text-secondary">Agregar PDF</div>
        <input class="form-control" type="file" id="PDF">
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3"> 
        <div class="mb-1 text-secondary">Agregar XML</div>
        <input class="form-control" type="file" id="XML">
</div>

</div>

<hr>
      <div class="text-end mt-3">
      	<button type="button" class="btn btn-danger" onclick="Cancelar(<?=$IdReporte;?>,<?=$year;?>,<?=$mes;?>)">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="Guardar(<?=$IdReporte;?>,<?=$year;?>,<?=$mes;?>)">Guardar</button>
      </div> 
 