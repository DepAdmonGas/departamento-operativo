<?php
require('app/help.php');
$sql = "SELECT * FROM op_rh_formatos WHERE id = '".$GET_idFormato."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$fecha = $row['fecha']; 
$idEstacion = $row['id_localidad'];
$formato = $row['formato'];
}

$sqlDetalle = "SELECT * FROM op_rh_formatos_vacaciones WHERE id_formulario = '".$GET_idFormato."' ";
$resultDetalle = mysqli_query($con, $sqlDetalle);
$numeroDetalle = mysqli_num_rows($resultDetalle);
while($rowDetalle = mysqli_fetch_array($resultDetalle, MYSQLI_ASSOC)){
$idusuario = $rowDetalle['id_usuario']; 
$numdias = $rowDetalle['num_dias'];
$fechainicio = $rowDetalle['fecha_inicio'];
$fechatermino = $rowDetalle['fecha_termino'];
$fecharegreso = $rowDetalle['fecha_regreso'];
$observaciones = $rowDetalle['observaciones'];
}
 
$sql_personal = "SELECT
op_rh_personal.id,
op_rh_personal.id_estacion,
op_rh_personal.nombre_completo,
op_rh_personal.puesto AS idPuesto,
op_rh_personal.curp,
op_rh_personal.sd,
op_rh_puestos.puesto,
op_rh_personal.documentos,
op_rh_personal.estado
FROM op_rh_personal
INNER JOIN op_rh_puestos 
ON op_rh_personal.puesto = op_rh_puestos.id
WHERE op_rh_personal.id_estacion = '".$idEstacion."' AND op_rh_personal.id <> '".$idusuario."' AND op_rh_personal.estado = 1 ORDER BY op_rh_personal.id ASC ";
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);



function NombrePersonal($id,$con){

$sql_personal = "SELECT nombre_completo FROM op_rh_personal WHERE id = '".$id."' ";
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);
while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
$return = $row_personal['nombre_completo']; 
}
return $return;
}
?>
<html lang="es">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Dirección de operaciones</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <link rel="shortcut icon" href="<?=RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="apple-touch-icon" href="<?=RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="stylesheet" href="<?=RUTA_CSS2 ?>alertify.css">
  <link rel="stylesheet" href="<?=RUTA_CSS2 ?>themes/default.rtl.css">
  <link href="<?=RUTA_CSS2;?>bootstrap.min.css" rel="stylesheet" />
  <link href="<?=RUTA_CSS2;?>navbar-general.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <script type="text/javascript" src="<?php echo RUTA_JS ?>signature_pad.js"></script>
  
  <style media="screen">
  .grayscale {
    filter: opacity(50%); 
  }
  </style>

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  $('[data-toggle="tooltip"]').tooltip();

  });

  function Regresar(){
  window.history.back();
  }

function Finalizar(estado,idReporte,idEstacion){


var Personal = $('#Personal').val();
var NumDias = $('#NumDias').val();
var FechaInicio = $('#FechaInicio').val();
var FechaTermino = $('#FechaTermino').val();
var FechaRegreso = $('#FechaRegreso').val();
var Observaciones = $('#Observaciones').val();

var data = new FormData();
var url = '../public/recursos-humanos/modelo/agregar-solicitud-vacaciones.php';

if(Personal != ""){
$('#Personal').css('border',''); 
if(NumDias != ""){
$('#NumDias').css('border',''); 
if(FechaInicio != ""){
$('#FechaInicio').css('border',''); 
if(FechaTermino != ""){
$('#FechaTermino').css('border','');
if(FechaRegreso != ""){
$('#FechaRegreso').css('border',''); 

  data.append('estado', estado);
  data.append('idReporte', idReporte);
  data.append('Personal', Personal);
  data.append('NumDias', NumDias);
  data.append('FechaInicio', FechaInicio);
  data.append('FechaTermino', FechaTermino);
  data.append('FechaRegreso', FechaRegreso);
  data.append('Observaciones', Observaciones);

    $(".LoaderPage").show();

    $.ajax({
    url: url,
    type: 'POST',
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(data){

    if(data == 1){
      Regresar();
     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al crear la solicitud'); 
     }
     

    }); 


}else{
$('#FechaRegreso').css('border','2px solid #A52525'); 
}
}else{
$('#FechaTermino').css('border','2px solid #A52525'); 
}
}else{
$('#FechaInicio').css('border','2px solid #A52525'); 
}
}else{
$('#NumDias').css('border','2px solid #A52525'); 
}
}else{
$('#Personal').css('border','2px solid #A52525'); 
}


}
  </script>
  </head>

  
<body> 
<div class="LoaderPage"></div>


  <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
  <?php include_once "public/navbar/navbar-perfil.php";?>
  <!---------- CONTENIDO PAGINA WEB----------> 
  <div class="contendAG">
  <div class="row">

  <div class="col-12 mb-3">
  <div class="cardAG">
  <div class="border-0 p-3">

    <div class="row">
    <div class="col-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">

     <h5>Vacaciones personal</h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>

 
  <div class="container">


    <div class="row">


    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 mb-2 mt-2">
        <div class="mb-1"><h6>* Nombre completo:</h6></div>
        <select class="form-select" id="Personal">
        <option value="<?=$idusuario;?>"><?=NombrePersonal($idusuario,$con);?></option>
        <?php 
        while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
        echo '<option value="'.$row_personal['id'].'">'.$row_personal['nombre_completo'].'</option>';
        }
        ?>
        </select>
      </div>


    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 mb-2 mt-2">
        <div class="mb-1"><h6>* Número de días a disfrutar:</h6></div>
        <input type="number" class="form-control" id="NumDias" value="<?=$numdias;?>">
      </div>
    </div>

    <hr>
    
    <div class="row">

      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2 mt-2">
        <div class="mb-1"><h6>* Del:</h6></div>
        <input type="date" class="form-control" id="FechaInicio" value="<?=$fechainicio?>">
      </div>

      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2 mt-2">
        <div class="mb-1"><h6>* Al:</h6></div>
        <input type="date" class="form-control" id="FechaTermino" value="<?=$fechatermino?>">
      </div>


      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2 mt-2">
        <div class="mb-1"><h6>* Regresando el:</h6></div>
        <input type="date" class="form-control" id="FechaRegreso" value="<?=$fecharegreso?>">
      </div>
    </div>

     <hr>

          <div class="row">


   <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-2 mt-2">
          <div class="mb-1"><h6>Observaciones:</h6></div>
          <textarea class="form-control rounded-0" id="Observaciones"><?=$observaciones;?></textarea>
    </div>



          </div>

          <hr>

<div class="text-end mt-3">
<button type="button" class="btn btn-success" onclick="Finalizar(<?=$numeroDetalle;?>,<?=$GET_idFormato;?>,<?=$idEstacion;?>)">Finalizar vacaciones</button>
</div>
</div>
     
  </div>
  </div>
  </div>

  </div>
  </div>

  </div>




  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>


</body>
</html>