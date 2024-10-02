<?php
require ('../../../app/help.php');
$idProcedimiento = $_GET['idProcedimiento'];

$sql_listProcedimiento = "SELECT modulo, titulo, fecha, archivo FROM op_procedimientos_modulos WHERE id = " . $idProcedimiento . " ";

$result_listProcedimiento = mysqli_query($con, $sql_listProcedimiento);
$numero_listProcedimiento = mysqli_num_rows($result_listProcedimiento);

while ($row_listProcedimiento = mysqli_fetch_array($result_listProcedimiento, MYSQLI_ASSOC)) {

    $GET_idModulo = $row_listProcedimiento['modulo'];
    $titulo = $row_listProcedimiento['titulo'];
    $archivo = $row_listProcedimiento['archivo'];

    $explode = explode(' ', $row_listProcedimiento['fecha']);
    $fecha_dia = FormatoFecha($explode[0]);
}

?>


<div class="modal-header">
    <h5 class="modal-title">Detalle procedimiento</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">

    <div class="row">

        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2" style="font-size:0.9em">
            <div class="font-weight-bold"><b>Titulo:</b></div>
            <?= $titulo; ?>
        </div>


        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2" style="font-size:0.9em">
            <div class="font-weight-bold"><b>Fecha:</b></div>
            <?= $fecha_dia; ?>
        </div>


        <div class="col-12">
            <iframe class="border-0 mt-2" src="<?=RUTA_ARCHIVOS ?>/procedimientos-modulos/<?= $archivo; ?>"
                width="100%" height="650px">
            </iframe>

        </div>

    </div>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-danger float-end" data-bs-dismiss="modal">
    <span class="btn-label2"><i class="fa fa-x"></i></span>Cerrar</button>

  <button type="button" class="btn btn-labeled2 btn-success float-end"
    onclick="eliminarProcedimiento(<?= $idProcedimiento ?>,'<?= $GET_idModulo ?>')">
    <span class="btn-label2"><i class="fa fa-check"></i></span>Eliminar</button>
</div>