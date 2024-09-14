<?php 
require('../../../../../../app/help.php');
$idReporte = $_GET['idReporte'];
$idEstacion = $_GET['idEstacion'];

$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($idEstacion);
$estacion = '('.$datosEstacion['localidad'].')';

$sql_formatos = "SELECT fecha FROM op_rh_formatos WHERE id = '" . $idReporte . "' ";
$result_formatos = mysqli_query($con, $sql_formatos);

while ($row_formatos = mysqli_fetch_array($result_formatos, MYSQLI_ASSOC)) {
$explode = explode(' ', $row_formatos['fecha']);
$HoraFormato = date("g:i a",strtotime($explode[1]));
}

$sql_lista = "SELECT * FROM op_rh_formatos_prima_vacacional WHERE id_formulario = '" . $idReporte . "' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
    while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
    $id = $row_lista['id'];
    $datosPersonal = $ClassHerramientasDptoOperativo->obtenerDatosPersonal($row_lista['id_personal']);
    $NombreC = $datosPersonal['nombre_personal']; 
    $fecha_ingreso = $ClassHerramientasDptoOperativo->FormatoFecha($datosPersonal['fecha_ingreso']); 
 
    $idEstaciones = $row_lista['id_estacion'];      
    $datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($idEstaciones);
    $nombreEstacion = $datosEstacion['localidad'];
      
    $periodo = $row_lista['periodo'];      

    }

    $contenido = '<th class="text-center fw-normal">'.$NombreC.'</th>
    <th class="text-center fw-normal">'.$fecha_ingreso.'</th>
    <th class="text-center fw-normal">'.$nombreEstacion.'</th>';

    $btnAccion = '<button type="button" class="btn btn-labeled2 btn-danger float-end" onclick="eliminarPersonal('.$id.','.$idReporte.','.$idEstacion.')">
    <span class="btn-label2"><i class="fa-regular fa-trash-can"></i></span>Eliminar personal</button>';

    $ocultar = "";
    $ocultar2 = "d-none";


    }else{

    $periodo = "";
    $contenido = '<th colspan="3" class="text-center text-secondary fw-normal no-hover2">No se encontró información para mostrar</th>';

    $btnAccion = '<button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="modalPrimaVacacional('.$idReporte.','.$idEstacion.')">
    <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar personal</button>';

    $ocultar = "d-none";
    $ocultar2 = "";

}

?>
 
  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Recursos Humanos</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Formulario Solicitud Prima Vacacional <?=$estacion?></li>
  </ol>
  </div>

  <div class="row">
  <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
  <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Formulario Solicitud Prima Vacacional <?=$estacion?></h3>
  </div>
                  
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">    
  <?=$btnAccion?>   
  </div>
                
  </div>      
  <hr>   
  </div>


  <div class="col-12 text-end mb-3 ">
  <b>Formato:</b> RH-FV-06
  <br>
  <b>No. De control:</b> 00<?=$idReporte?>
  
  <p>Huixquilucan, Edo. de México a <?=$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.$HoraFormato;?></p>
  </div>

  <div class="col-12">
  <b>Lic. Alejandro Guzmán</b>
  <br>
  <p><b>Departamento de Recursos Humanos</b></p>
  <p>
  Sirva la presente para enviarle un cordial saludo, al mismo tiempo, me permito solicitarle el pago de mi prima vacacional, correspondiente al periodo de  
  <input class="form-control ms-2" type="number" value="<?=$periodo?>" style="display: inline-block; width: auto; width: 150px" disabled>
  </p>
  </div>


  <!---------- TABLA DEL PERSONAL ---------->
  <div class="col-12">
  <div class="table-responsive mb-4">
  <table class="custom-table" width="100%">

  <thead class="tables-bg">
  <tr>
  <th class="align-middle text-center">Colaborador</th>
  <th class="align-middle text-center">Fecha de ingreso</th>
  <th class="align-middle text-center">Estacion / Departamento</th>

  </tr>
  </thead>

  <tbody class="bg-light">
  <tr>             
    <?=$contenido?>      
  </tr>
  </tbody>
  </table>
  </div>
    </div>
 

    
  <div class="col-12 text-center"><p>Sin más por el momento quedo de usted.</p><hr></div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2 <?=$ocultar?>">
<div class="table-responsive">
<table class="custom-table" style="font-size: .8em;" width="100%">

<thead class="tables-bg">
<tr><th class="text-center align-middle">Firma de quien elabora</th></tr>
</thead>

<tbody class="bg-light"> 
<tr>
<td class="no-hover2 p-0">
<div id="signature-pad" class="signature-pad border-0" style="cursor:crosshair">
<div class="signature-pad--body">
<canvas style="width: 100%; height: 200px; border-right: 0.1px solid rgb(33, 93, 152); border-left: 0.1px solid rgb(33, 93, 152); cursor: crosshair; touch-action: none;" id="canvas" width="900" height="150"></canvas>  
<input type="hidden" name="base64" value="" id="base64">
</div>
</div>
</td>
</tr> 
                    
<tr><th colspan="6" class="bg-danger text-white p-2" onclick="resizeCanvas()"><i class="fa-solid fa-broom"></i> Limpiar firma</th></tr>
</tbody>
</table>
</div>
</div>

<div class="col-12 <?=$ocultar?>">
<hr>
<button type="button" class="btn btn-labeled2 btn-success float-end" onclick="Finalizar(<?=$idReporte?>,'A')">
<span class="btn-label2"><i class="fa fa-check"></i></span>Finalizar</button>
</div>

<div class="col-12 mt-2 pb-0 mb-0 <?=$ocultar2?>">
<div class="text-center alert alert-warning" role="alert">¡Aun no es posible finalizar! <br> Se debe de agregar el registro del personal.</div>
</div>

<script src="<?= RUTA_JS2 ?>signature-pad-functions.js"></script>
