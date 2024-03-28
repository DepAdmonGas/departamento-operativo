<?php
require('../../../app/help.php');

$idContrato = $_GET['idContrato'];

$sql_lista_contrato = "SELECT * FROM op_contratos WHERE id_contratos = '".$idContrato ."'";
$result_lista_contrato = mysqli_query($con, $sql_lista_contrato);
$numero_lista_contrato = mysqli_num_rows($result_lista_contrato);

while($row_lista_contrato = mysqli_fetch_array($result_lista_contrato, MYSQLI_ASSOC)){
    $GET_idEstacion = $row_lista_contrato['id_estacion'];
    $descripcion = $row_lista_contrato['descripcion'];
    $archivo = $row_lista_contrato['archivo'];

    $objeto = $row_lista_contrato['objeto'];
    $proveedor = $row_lista_contrato['proveedor'];

    if($row_lista_contrato['vencimiento'] == '0000-00-00'){
    $vencimiento = 'S/I';
    }else{
    $vencimiento = $row_lista_contrato['vencimiento'];	
    }
    
    $firmas = $row_lista_contrato['firmas'];
    $comentario = $row_lista_contrato['comentario'];

    $cate = $row_lista_contrato['categoria'];
}



if($archivo  != ""){
$pdfInput = '<iframe class="border-0 mt-1" src="'.RUTA_ARCHIVOS.'contratos-es/'.$archivo.'" width="100%" height="400px">
  </iframe>';

}else{
$pdfInput = 'S/I';
}

 

?>

 <div class="modal-header">
  <h5 class="modal-title">Detalle contrato</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
 </div>


<div class="modal-body">

<h6 class="mb-1">Documento:</h6>
<label><?=$descripcion?></label>

<h6 class="mt-3 mb-1">PDF:</h6>
<?=$pdfInput;?>


<h6 class="mb-1 mt-1">Objeto:</h6>
<label><?=$objeto?></label>

<h6 class="mb-1 mt-1">Proveedor:</h6>
<label><?=$proveedor?></label>

<h6 class="mb-1 mt-1">Vencimiento:</h6>
<label><?=FormatoFecha($vencimiento)?></label>

<h6 class="mb-1 mt-1">Personas que firman:</h6>
<label><?=$firmas?></label>

<h6 class="mb-1 mt-1">Comentario:</h6>
<label><?=$comentario?></label>

</div>


<div class="modal-footer">
 <button type="button" class="btn btn-danger" onclick="eliminarContrato(<?=$idContrato?>,<?=$GET_idEstacion?>,'<?=$cate;?>')">Eliminar</button>
 <button type="button" class="btn btn-primary" onclick="ModalEditarContrato(<?=$idContrato?>)">Editar</button>
</div>
     