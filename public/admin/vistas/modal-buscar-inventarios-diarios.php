<?php
require('../../../app/help.php');
?>
<div class="modal-header">
<h5 class="modal-title">Buscar</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">

  <label class="text-secondary">Año:</label>
  <select class="form-select" id="Year">
  <option value="0">Selecciona</option>
  <?php
  $Year = date("Y");
  for ($i = $Year; $i >= 2021; $i--) {
  echo '<option value="'.$i.'">'.$i.'</option>';
  }
  ?>
  </select>

 
<label class="text-secondary mt-3">Mes:</label>
<select class="form-select" id="Mes">
<option value="0">Selecciona</option>
<option value="1">Enero</option>
<option value="2">Febrero</option>
<option value="3">Marzo</option>
<option value="4">Abril</option>
<option value="5">Mayo</option>
<option value="6">Junio</option>
<option value="7">Julio</option>
<option value="8">Agosto</option>
<option value="9">Septiembre</option>
<option value="10">Octubre</option>
<option value="11">Noviembre</option>
<option value="12">Diciembre</option>  
</select>
</div>


      <div class="modal-footer">

        <button type="button" class="btn btn-labeled2 btn-danger" data-bs-dismiss="modal">
        <span class="btn-label2"><i class="fa fa-xmark"></i></span>Cancelar</button>

        <button type="button" class="btn btn-labeled2 btn-success" onclick="Buscar()">
        <span class="btn-label2"><i class="fa fa-search"></i></span>Buscar</button>

      </div>