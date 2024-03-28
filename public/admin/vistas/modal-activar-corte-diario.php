<?php
require('../../../app/help.php');

$year = $_GET['year'];
$mes = $_GET['mes'];
$idDias = $_GET['idDias'];
$idEstacion = $_GET['idEstacion'];
?>

<div class="modal-header">
<h5 class="modal-title">Activar corte</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<div class="text-secondary">Motivo:</div>
<textarea class="form-control mt-2" id="Detalle"></textarea>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="NewRegistro(<?=$idEstacion;?>,<?=$year;?>,<?=$mes;?>,<?=$idDias;?>)">Guardar</button>
</div>

