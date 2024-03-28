<?php
require('../../../app/help.php');

$idContrato = $_GET['idContrato'];

$sql_lista_contrato = "SELECT * FROM op_contratos WHERE id_contratos = '".$idContrato ."'";
$result_lista_contrato = mysqli_query($con, $sql_lista_contrato);
$numero_lista_contrato = mysqli_num_rows($result_lista_contrato);

while($row_lista_contrato = mysqli_fetch_array($result_lista_contrato, MYSQLI_ASSOC)){
    $GET_idEstacion = $row_lista_contrato['id_estacion'];
    $descripcion = $row_lista_contrato['descripcion'];
    $fecha = $row_lista_contrato['fecha'];

    $objeto = $row_lista_contrato['objeto'];
    $proveedor = $row_lista_contrato['proveedor'];
    $vencimiento = $row_lista_contrato['vencimiento'];
    $firmas = $row_lista_contrato['firmas'];
    $comentario = $row_lista_contrato['comentario'];
    $cate = $row_lista_contrato['categoria'];
}


?>

 <div class="modal-header">
  <h5 class="modal-title">Detalle contrato</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
 </div>


<div class="modal-body">

<h6 class="mb-1">Fecha:</h6>
<input class="form-control" type="date" id="FechaC" value="<?=$fecha?>">

<h6 class="mt-3 mb-1">Documento:</h6>
<textarea class="form-control" id="DescripcionC"><?=$descripcion?></textarea>

<h6 class="mt-3 mb-1">PDF:</h6>
<input class="form-control" type="file" id="ContratoDoc">

<h6 class="mb-1 mt-3">Objeto:</h6>
<textarea class="form-control" id="Objeto"><?=$objeto;?></textarea>

<h6 class="mb-1 mt-3">Proveedor:</h6>
<textarea class="form-control" id="Proveedor"><?=$proveedor;?></textarea>

<h6 class="mb-1 mt-3">Vencimiento:</h6>
<input type="date" class="form-control" id="Vencimiento" value="<?=$vencimiento;?>">

<h6 class="mb-1 mt-3">Personas que firman:</h6>
<textarea class="form-control" id="Firman"><?=$firmas;?></textarea>

<h6 class="mb-1 mt-3">Comentario:</h6>
<textarea class="form-control" id="Comentario"><?=$comentario;?></textarea>


</div>


<div class="modal-footer">
 <button type="button" class="btn btn-danger" onclick="returnDetalleC(<?=$idContrato?>)">Cancelar</button>
 <button type="button" class="btn btn-primary" onclick="editarContrato(<?=$idContrato?>,<?=$GET_idEstacion?>,'<?=$cate;?>')">Editar</button>
</div>
     