<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];
$idEstacion = $_GET['idEstacion'];
$year = $_GET['year'];
$SemQui = $_GET['SemQui'];
$descripcion = $_GET['descripcion'];

if($Session_IDUsuarioBD == 19 || $Session_IDUsuarioBD == 318){
  $ocultarPrima = "";
  $ocultarOriginal = "d-none";
  $ocultarFormulario = "";
  
  }else{

  if($Session_IDUsuarioBD == 354){
    $ocultarPrima = "d-none";
    $ocultarOriginal = "";
    $ocultarFormulario = "d-none";
  }else{
    $ocultarPrima = "d-none";
    $ocultarOriginal = "d-none";
    $ocultarFormulario = "";
  }

      
}

function PersonalNomina($idPersonal, $con){
    $sql = "SELECT nombre_completo FROM op_rh_personal 
    WHERE op_rh_personal.id = '".$idPersonal."' ";

    $result = mysqli_query($con, $sql);
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $nombreNomina = $row['nombre_completo'];
    }

    return $nombreNomina; 
}

function ToAlertaBd($GET_usuario,$con){
    
  $sql_listaPV = "SELECT id, inicio_notificacion, limite_notificacion, titulo_nomina, status
  FROM op_recibo_nomina_v2_prima_vacacional
  WHERE id_usuario = '".$GET_usuario."' AND status = 0 ORDER BY id ASC LIMIT 1";

  $result_listaPV = mysqli_query($con, $sql_listaPV);
  $numero_listaPV = mysqli_num_rows($result_listaPV); 
  
  if($numero_listaPV > 0){
  
  $valor = 0;
  }else{
  $valor = 1;
  }

  return $valor;
  }


$sql_personal = "SELECT id_usuario, importe_total, doc_nomina, doc_nomina_firma, nomina_original, prima_vacacional 
FROM op_recibo_nomina_v2 WHERE id = '".$idReporte."'";

$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);

while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
$GET_usuario = $row_personal['id_usuario'];
$importe_total = $row_personal['importe_total'];
$doc_nomina = $row_personal['doc_nomina'];
$doc_nomina_firma = $row_personal['doc_nomina_firma'];
$nomina_original = $row_personal['nomina_original'];
$prima_vacacional = $row_personal['prima_vacacional'];
}

$nombre_personal = PersonalNomina($GET_usuario,$con);
$ToAlertaBD = ToAlertaBd($GET_usuario,$con);


if($prima_vacacional == 0 && $ToAlertaBD == 0){
   $ocultarOpcion = '';

}else if($prima_vacacional == 0 && $ToAlertaBD == 1){
  $ocultarOpcion = 'd-none';

}else if($prima_vacacional == 1 && $ToAlertaBD == 1){
   $ocultarOpcion = 'd-none';

}else if($prima_vacacional == 2 && $ToAlertaBD == 1){
   $ocultarOpcion = '';

}else{
   $ocultarOpcion = 'd-none';

}


?>

 
<div class="modal-header">
<h5 class="modal-title"><?=$nombre_personal?> - <?=$descripcion?> <?=$SemQui?></h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">


<div class="col-12 <?=$ocultarOriginal?>">

<h6 class="text-secondary">¿Se recibio el recibo de nomina original (firmado)?:</h6>
<div class="row">

<div class="col-4 mb-2">
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="Original" id="Si" value="1"  <?php if($nomina_original == 1){echo 'checked';} ?> >
  <label class="form-check-label" for="Si">SI</label>
</div>
</div>

<div class="col-4 mb-2">
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="Original" id="No" value="0" <?php if($nomina_original == 0){echo 'checked';} ?> >
  <label class="form-check-label" for="No">NO</label>
</div>
</div>
</div>

</div>


<div class="col-12 <?=$ocultarFormulario?>">

<h6 class="text-secondary">Importe:</h6>
<input class="form-control mb-3" type="number" id="Importe" value="<?=$importe_total?>">

<div class="row">

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
<h6 class="text-secondary">Recibo de Nomina:</h6>
<input class="form-control" type="file" id="DocumentoAcuse">
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
<h6 class="text-secondary">Recibo de Nomina <b>(Firmado)</b>:</h6>
<input class="form-control" type="file" id="DocumentoFirma">
</div>


<div class="col-12 mt-3 <?=$ocultarPrima?> <?=$ocultarOpcion?>">
<div class="border p-3">

<h6 class="text-secondary">¿Se realizo el pago de prima vacacional?:</h6>
<hr>

<div class="row">
<div class="col-4 mb-2">
  <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="PrimaV" id="Si" value="2"  <?php if($prima_vacacional == 2){echo 'checked';} ?> >
  <label class="form-check-label" for="Si">SI</label>
</div>
</div>

<div class="col-4 mb-2">
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="PrimaV" id="No" value="0" <?php if($prima_vacacional == 0){echo 'checked';} ?> >
  <label class="form-check-label" for="No">NO</label>
</div>
</div>

</div>
</div>

</div>
</div>

</div>



</div>

</div> 


<div class="modal-footer">

    <button type="button" class="btn btn-labeled2 btn-danger" data-bs-dismiss="modal">
    <span class="btn-label2"><i class="fa-solid fa-xmark"></i></span>Cancelar</button>

    <button type="button" class="btn btn-labeled2 btn-success" onclick="EditarNominaInfo(<?=$idReporte?>,<?=$idEstacion?>,<?=$year?>,<?=$SemQui?>,'<?=$descripcion?>',<?=$GET_usuario?>,<?=$prima_vacacional?>,<?=$ToAlertaBD?>)">
    <span class="btn-label2"><i class="fa fa-check"></i></span>Editar</button>

  </div>

 