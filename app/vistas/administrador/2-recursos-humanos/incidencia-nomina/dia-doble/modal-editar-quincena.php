<?php 
require('../../../../../../app/help.php');
$idReporte = $_GET['idReporte'];

?>

<div class="modal-header">
<h5 class="modal-title">Editar quincena</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
<div class="row">

 
<div class="col-12 mb-3">
<div class="fw-bold text-secondary">* NO. DE QUINCENA:</div>
<select class="form-select mt-1" id="QuincenaDO"> 
  <option value="">Selecciona una opción...</option>

  <?php
  // Inicializar la variable de enumeración
  $quincenaNumero = 1;


  for ($mes = 1; $mes <= 12; $mes++) {
  /*
  echo "<option value='" . $quincenaNumero . "'>Quincena " . $quincenaNumero . "</option><br>";
  $quincenaNumero++;
  echo "<option value='" . $quincenaNumero . "'>Quincena " . $quincenaNumero . "</option><br>";
  $quincenaNumero++;
  */
  // Calcular el primer día del mes
  $primer_dia = mktime(0, 0, 0, $mes, 1, $year);
      
  // Calcular el último día del mes
  $ultimo_dia = mktime(0, 0, 0, $mes + 1, 0, $year);

  // Agregar opciones al elemento select
  echo "<option value='" . $quincenaNumero++ . "'>Quincena " . $quincenaNumero - 1 . ": del " . date('d-m-Y', $primer_dia) . " al 15-" . date('m-Y', $primer_dia) . "</option>";
  echo "<option value='" . $quincenaNumero++ . "'>Quincena " . $quincenaNumero -1 . ": del 16-" . date('m-Y', $primer_dia) . " al " . date('d-m-Y', $ultimo_dia) . "</option>";
  }

  ?>

  </select>
</div>   
</div>
</div>
 

<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="editarQuincenaDO(<?=$idReporte?>)"><span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
</div>
