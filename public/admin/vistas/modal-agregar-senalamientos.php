<?php
require('../../../app/help.php');

$Senalamiento = $_GET['Senalamiento'];

if($_GET['Senalamiento'] == 1){
$titulo = 'NOM-003-SEGOB-2011';

}else if($_GET['Senalamiento'] == 2){
$titulo = 'NOM-005-ASEA-2016';

}else if($_GET['Senalamiento'] == 3){
$titulo = 'IMAGEN G500';
}

?>

<script type="text/javascript">
$(document).ready(function($){
  
const $seleccionArchivos = document.querySelector("#seleccionArchivos"),
$imagenPrevisualizacion = document.querySelector("#imagenPrevisualizacion");


$seleccionArchivos.addEventListener("change", () => {
const archivos = $seleccionArchivos.files;
if (!archivos || !archivos.length) {
$imagenPrevisualizacion.src = "";
return;
}
const primerArchivo = archivos[0];
const objectURL = URL.createObjectURL(primerArchivo);
$imagenPrevisualizacion.src = objectURL;

});

});
</script>

<div class="modal-header">
<h5 class="modal-title">Agregar señalamiento (<?=$titulo?>)</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">

<div class="row">
<div class="col-12">
<div class="mb-2 text-secondary">Diseño:</div>
<input type="file" class="rounded-0 form-control" id="seleccionArchivos" accept="image/*" style="font-size: .8em;">  
<div class="text-center mt-2"><img id="imagenPrevisualizacion" width="150px"></div>
</div>
</div>

<div class="mb-1 mt-2 text-secondary">Dimensión:</div>
<input type="text" class="form-control rounded-0" id="Dimension">   

<hr> 

<div class="row">
  
<div class="col-12 mb-3">
<button type="button" class="btn btn-labeled2 btn-danger float-end ms-2" onclick="eliminarFila()">
<span class="btn-label2"><i class="fa-solid fa-table"></i></span>Eliminar fila</button>

<button type="button" class="btn btn-labeled2 btn-primary float-end ms-2" onclick="agregarFila()">
<span class="btn-label2"><i class="fa-solid fa-table"></i></span>Agregar fila</button>
</div>

</div>
    
<div class="table-responsive">
<table id="tablaprueba" class="custom-table" style="font-size: .9em;" width="100%">
<thead class="tables-bg">
<tr>
<th colspan="2">Colores</th>
</tr>
<tr class="title-table-bg">
<td class="fw-bold">Titulo</td>
<td class="fw-bold">Detalle</td>
</tr>
</thead>
<tbody class="bg-light p-3"></tbody>
</table>
</div> 


<hr>


  <div class="mb-2 mt-2 text-secondary">Ubicación:</div>
  <textarea class="form-control rounded-0" id="Ubicacion"></textarea>

        <div class="mt-2 mb-2 text-secondary">Reproducción:</div>
        <textarea class="form-control rounded-0" id="Reproduccion"></textarea>

        <div class="row mt-2">
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
          <div class="mb-2 text-secondary">Stock vinil:</div>
          <input type="text" class="form-control rounded-0" id="vinil">
          </div>
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
          <div class="mb-2 text-secondary">Stock placa:</div>
          <input type="text" class="form-control rounded-0" id="placa">
          </div>
     </div>

      </div>

<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="Guardar(<?=$Senalamiento;?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
</div>
