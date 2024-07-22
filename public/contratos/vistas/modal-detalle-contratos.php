<?php
require('../../../app/help.php');
$idContrato = $_GET['idContrato'];

$sql_lista_contrato = "SELECT * FROM op_contratos WHERE id_contratos = '".$idContrato ."'";
$result_lista_contrato = mysqli_query($con, $sql_lista_contrato);
$numero_lista_contrato = mysqli_num_rows($result_lista_contrato);


while($row_lista_contrato = mysqli_fetch_array($result_lista_contrato, MYSQLI_ASSOC)){
$GET_idEstacion = $row_lista_contrato['id_estacion'];
$fecha = $ClassHerramientasDptoOperativo->FormatoFecha($row_lista_contrato['fecha']);
$descripcion = !empty($row_lista_contrato['descripcion']) ? $row_lista_contrato['descripcion'] : 'S/I';
$archivo = $row_lista_contrato['archivo'];
$objeto = !empty($row_lista_contrato['objeto']) ? $row_lista_contrato['objeto'] : 'S/I';
$proveedor = !empty($row_lista_contrato['proveedor']) ? $row_lista_contrato['proveedor'] : 'S/I';

if($row_lista_contrato['vencimiento'] == '0000-00-00'){
$vencimiento = 'S/I';
} else {
$vencimiento = $ClassHerramientasDptoOperativo->FormatoFecha($row_lista_contrato['vencimiento']);	
}

$firmas = !empty($row_lista_contrato['firmas']) ? $row_lista_contrato['firmas'] : 'S/I';
$comentario = !empty($row_lista_contrato['comentario']) ? $row_lista_contrato['comentario'] : 'Sin comentarios.';
$cate = $row_lista_contrato['categoria'];

}


if($archivo  != ""){
$pdfInput = '<iframe class="border-0 mt-1" src="'.RUTA_ARCHIVOS.'contratos-es/'.$archivo.'" width="100%" height="400px"></iframe>';

}else{
$pdfInput = '<header class="bg-light py-5">
    <div class="container px-5">
    <div class="row gx-5 align-items-center justify-content-center">
  
    <div class="col-xl-5 col-xxl-6 d-xl-block text-center">
    <img class="my-2" style="width: 100%" src="'.RUTA_IMG_ICONOS.'no-busqueda.png" width="50%">
    </div>
   
    <div class="col-lg-8 col-xl-7 col-xxl-6">
    <div class="my-2 text-center"> <h1 class="display-3 fw-bolder text-dark">No se encontró la información</h1> </div>
    </div>
    
    </div>
    </div>
    </header>';

}

?>

 <div class="modal-header">
  <h5 class="modal-title">Detalle contrato</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
 </div>


<div class="modal-body">

<div class="row">

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
<h6 class="mb-1">Documento:</h6>
<label><?=$descripcion?></label>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
<h6 class="mb-1">Fecha:</h6>
<label><?=$fecha?></label>
</div>

<div class="col-12 mb-3">
<h6 class="mb-1">PDF:</h6>
<?=$pdfInput;?>
</div>

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
<h6 class="mb-1">Objeto:</h6>
<label><?=$objeto?></label>
</div>

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
<h6 class="mb-1">Proveedor:</h6>
<label><?=$proveedor?></label>
</div>

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
<h6 class="mb-1">Vencimiento:</h6>
<label><?=$vencimiento?></label>
</div>

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
<h6 class="mb-1">Personas que firman:</h6>
<label><?=$firmas?></label>
</div>

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
<h6 class="mb-1 ">Comentario:</h6>
<label><?=$comentario?></label>
</div>

</div>
</div>

<div class="modal-footer">
 
<button type="button" class="btn btn-labeled2 btn-danger" onclick="eliminarContrato(<?=$idContrato?>,<?=$GET_idEstacion?>,'<?=$cate;?>')">
<span class="btn-label2"><i class="fa-solid fa-xmark"></i></span>Eliminar</button>

<button type="button" class="btn btn-labeled2 btn-success" onclick="ModalEditarContrato(<?=$idContrato?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Editar</button>

</div>
     