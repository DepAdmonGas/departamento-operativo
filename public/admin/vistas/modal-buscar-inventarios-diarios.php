<?php
require('../../../app/help.php');
?>
<div class="modal-header">
<h5 class="modal-title">Buscar</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

 
<label class="text-secondary mt-2">Mes:</label>
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="Buscar()">Buscar</button>
      </div>