<?php
require('../../../app/help.php');

$year = $_GET['year'];
$mes = $_GET['mes'];
$idDias = $_GET['idDias'];
$idEstacion = $_GET['idEstacion'];
?>

<div class="modal-header">
<h5 class="modal-title">Activar corte</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<div class="text-secondary">Motivo:</div>
<textarea class="form-control mt-2" id="Detalle"></textarea>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="NewRegistro(<?=$idEstacion;?>,<?=$year;?>,<?=$mes;?>,<?=$idDias;?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Activar</button>
</div>

 