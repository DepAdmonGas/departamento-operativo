<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$year = $_GET['year'];
$mes = $_GET['mes'];
$SemQui = $_GET['SemQui'];
$descripcion = $_GET['descripcion'];
$last = $_GET['last'];

// Obtener el personal de la estación (solo activos)
$sql_personal_estacion = "SELECT id, nombre_completo FROM op_rh_personal WHERE id_estacion = $idEstacion AND estado = 1 ORDER BY id DESC";
$result_personal_estacion = mysqli_query($con, $sql_personal_estacion);
$personal_data = [];

// Guardar los datos en un array asociativo
while ($row = mysqli_fetch_assoc($result_personal_estacion)) {
    $personal_data[$row['id']] = $row['nombre_completo'];
}

// Obtener los usuarios que ya están en op_recibo_nomina_v2
$sql_recibo_nomina = "SELECT id_usuario FROM op_recibo_nomina_v2 WHERE id_estacion = $idEstacion AND year = $year AND mes = $mes AND no_semana_quincena = $SemQui";
$result_recibo_nomina = mysqli_query($con, $sql_recibo_nomina);
$recibo_ids = [];

// Guardar los IDs de usuarios que ya están en la nómina
while ($row = mysqli_fetch_assoc($result_recibo_nomina)) {
    $recibo_ids[] = $row['id_usuario'];
}

// Filtrar solo los que NO están en la nómina
$faltantes = array_diff(array_keys($personal_data), $recibo_ids);
?>
<script>
    $(document).ready(function() {
        $('#personal_nomina').selectize({
            placeholder: 'Selecciona al personal',
            allowEmptyOption: false,
            maxItems: null, // Permite seleccionar múltiples opciones
            create: false
        });
    });
</script>

<div class="modal-header">
    <h5 class="modal-title">Agregar Personal</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
    <div class="mb-3">
    <label class="text-secondary fw-bold mb-1">* Selecciona el nombre del personal:</label>
<div id="personal-container">
    <?php if (!empty($faltantes)) { ?>
        <select class="selectize" id="personal_nomina" multiple>
            <?php foreach ($faltantes as $idUsuario) { ?>
                <option value="<?= htmlspecialchars($idUsuario) ?>">
                    <?= htmlspecialchars($personal_data[$idUsuario]) ?>
                </option>
            <?php } ?>
        </select>
    <?php } else { ?>
        <span class="badge rounded-pill bg-success float-start" style="font-size: .78em;">
            Ningún usuario por agregar
        </span>
    <?php } ?>
</div>

    </div>
</div>

<div class="modal-footer">
    <?php if (!empty($faltantes)) { ?>
        <button type="button" class="btn btn-labeled2 btn-success" onclick="guardarPersonal(<?= $idEstacion ?>, <?= $year ?>, <?= $mes ?>, <?= $SemQui ?>, '<?= $descripcion ?>', <?= $last ?>)">
            <span class="btn-label2"><i class="fa fa-check"></i></span> Agregar
        </button>
    <?php } ?>
</div>
