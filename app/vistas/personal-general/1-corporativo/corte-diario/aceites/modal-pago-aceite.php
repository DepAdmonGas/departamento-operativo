<?php
require '../../../../help.php';
$idaceite = $_GET['idaceite'];
$year = $_GET['year'];
$mes = $_GET['mes'];
$result = $corteDiarioGeneral->modalPagoAceite($idaceite);
?>

<div class="modal-header">
    <h5 class="modal-title">Pago de diferencia</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

    <div class="alert alert-secondary" role="alert">
        Solo cuentas con 5 días para realizar el pago de diferencias.
    </div>

    Se debe pagar la cantidad de <b><?= abs($result[0]); ?>pzs</b>, del siguiente aceite o lubricante</br>
    <b><?= $result[1]; ?></b>
    <hr>
    <div class="mt-2 mb-1"><small>* Selecciona el documento de pago (PDF)</small></div>
    <input class="form-control" type="file" id="Documento">

    <div class="mt-2 mb-1"><small>* Comentario</small></div>
    <textarea class="form-control" id="Comentario"></textarea>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-primary"
        onclick="PagarDiferencia(<?= $idaceite; ?>,<?= $year ?>,<?= $mes; ?>,<?= $Session_IDEstacion; ?>)">Pagar</button>
</div>