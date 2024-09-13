<?php
require('../../../../../app/help.php');
$idReporte = $_GET['idReporte'];

?>
<script type="text/javascript">
  $('.selectize').selectize({
    sortField: 'text'
});
</script>

<div class="modal-header">
<h5 class="modal-title">Nuevo Pivoteo</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">



    <div class="text-secondary fw-bold">* PRODUCTO:</div>
    <select class="form-select mb-2" id="Producto">
        <option></option>
        <option>87 OCTANOS</option>
        <option>91 OCTANOS</option>
        <option>DIESEL</option>
    </select>

    <div class="text-secondary fw-bold">* LITROS:</div>
    <input type="number" class="form-control mb-2" id="Litros">

    <div class="text-secondary fw-bold">* TANQUE:</div>
    <div id="ResulTanque"></div>
    <select class="form-select mb-2" id="Tanque">
        <option></option>
        <option>Pipa</option>
        <option>Tanque 1</option>
        <option>Tanque 2</option>
    </select>

    <div class="text-secondary fw-bold">* TAD:</div>
    <select class="form-select mb-2" id="TAD">
        <option></option>
        <option>Atlacomulco</option>
        <option>Tizayuca</option>
        <option>Tuxpan</option>
        <option>Puebla</option>
        <option>Vopack</option>
    </select>




    <div class="text-secondary fw-bold">* UNIDAD:</div>
    <select class="selectize pointer"  id="Unidad">
        <option></option>

        <?php
        $sql_unidades = "SELECT no_unidad FROM tb_unidades_transporte WHERE estado = 0 ORDER BY no_unidad ASC";
        $result_unidades = mysqli_query($con, $sql_unidades);
        $numero_unidades = mysqli_num_rows($result_unidades);

        while ($row_unidades = mysqli_fetch_array($result_unidades, MYSQLI_ASSOC)) {
            $no_unidad = $row_unidades['no_unidad'];

            echo '<option>' . $no_unidad . '</option>';
        }

        ?>


    </select>

    <div class="text-secondary fw-bold">* CHOFER:</div>
    <select class="selectize pointer"  id="Chofer">
        <option></option>

        <?php
        $sql_chofer = "SELECT nombre_chofer FROM tb_pivoteo_chofer WHERE estado = 0 ORDER BY nombre_chofer ASC";
        $result_chofer = mysqli_query($con, $sql_chofer);
        $numero_chofer = mysqli_num_rows($result_chofer);

        while ($row_chofer = mysqli_fetch_array($result_chofer, MYSQLI_ASSOC)) {
            $nombre_chofer = $row_chofer['nombre_chofer'];

            echo '<option>' . $nombre_chofer . '</option>';
        }

        ?>


    </select>

</div>


<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="Guardar(<?=$idReporte?>,<?=$Session_IDEstacion?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>

</div>
