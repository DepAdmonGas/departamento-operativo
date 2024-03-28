<?php
require('../../../app/help.php');

$idTPV = $_GET['idTPV'];

$sql_lista = "SELECT * FROM op_terminales_tpv WHERE id = '".$idTPV."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$tpv = $row_lista['tpv'];
$noserie = $row_lista['no_serie'];
$modelo = $row_lista['modelo'];
$lote = $row_lista['no_lote'];
$tipoconexion = $row_lista['tipo_conexion'];
$noafiliacion = $row_lista['no_afiliacion'];
$telefono = $row_lista['telefono'];
$estado = $row_lista['estado'];
$rollos = $row_lista['rollos'];
$cargadores = $row_lista['cargadores'];
$pedestales = $row_lista['pedestales'];
}


?>
<div class="modal-header">
<h5 class="modal-title">Falla TPV: <?=$tpv;?>, No DE SERIE: <?=$noserie;?></h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

 <div class="mb-1 text-secondary">Falla:</div>
 <select class="form-select rounded-0" id="Falla">
<option></option>
<option>Falla en impresora</option>
<option>Se le va la señal</option>
<option>La pila no retiene carga</option>
<option>Centro de carga </option>
<option>Ya no prende </option>
<option>Se cayo </option>
<option>Se mojo </option>
<option>Falla en la botonera </option>
<option>Falla en el touch</option>
<option>Se pasmo</option>
<option>Se traba</option>
<option>Cargador</option>
<option>No genera cierre de lote</option>

</select>


</div>

      <div class="modal-footer">
      	<button type="button" class="btn btn-danger" onclick="ModalFalla(<?=$idTPV;?>)">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="GuardarFalla(<?=$idTPV;?>)">Guardar</button>
      </div>
