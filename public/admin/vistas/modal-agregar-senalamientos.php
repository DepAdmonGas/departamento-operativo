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
<h5 class="modal-title">Agregar señalamiento</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">

<h6><?=$titulo;?></h6>

    <div class="row">
    <div class="col-12 ">
    <div class="mb-2 text-secondary">Diseño:</div>

    <input type="file" class="rounded-0 form-control" id="seleccionArchivos" accept="image/*" style="font-size: .8em;">  
    <div class="text-center mt-2">
    <img id="imagenPrevisualizacion" width="150px">
    </div>

    </div>
    </div>

      	<div class="mb-1 mt-2 text-secondary">Dimensión:</div>
        <input type="text" class="form-control rounded-0" id="Dimension">   

      <hr>
      <div class="mb-2 mt-2 text-secondary">Colores:</div>
    

<div class="table-responsive">
      <table class="table table-bordered table-sm" id="tablaprueba">
      <thead class="tables-bg">
        <tr>
          <th>Titulo</th>
          <th>Detalle</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
</div> 


<div class="row">
    
    <div class="col-12">
      <button type="button" class="btn btn-danger btn-sm float-end ms-2" onclick="eliminarFila()">Eliminar</button>
      <button type="button" class="btn btn-primary btn-sm float-end" onclick="agregarFila()">Agregar</button>
    </div>

</div>

<hr>


        <div class="mb-2 mt-2 text-secondary">Ubicación:</div>
        <textarea class="form-control rounded-0" id="Ubicacion"></textarea>

        <div class="mt-2 mb-2 text-secondary">Reproducción:</div>
        <textarea class="form-control rounded-0" id="Reproduccion"></textarea>

        <div class="row mt-2">
          <div class="col-6">
          <div class="mb-2 text-secondary">Stock vinil:</div>
          <input type="text" class="form-control rounded-0" id="vinil">
          </div>
          <div class="col-6">
          <div class="mb-2 text-secondary">Stock placa:</div>
          <input type="text" class="form-control rounded-0" id="placa">
          </div>
     </div>

      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-primary" onclick="Guardar(<?=$Senalamiento;?>)">Guardar</button>
      </div>
