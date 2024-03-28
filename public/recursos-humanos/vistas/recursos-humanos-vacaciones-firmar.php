<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

$sqlPV = "SELECT * FROM op_rh_vacaciones_pago WHERE id = '".$GET_idReporte."' ";
$resultPV = mysqli_query($con, $sqlPV);
while($rowPV = mysqli_fetch_array($resultPV, MYSQLI_ASSOC)){
$NomMes = nombremes($rowPV['mes']);
$NomYear = $rowPV['year'];
$IdEstacion = $rowPV['id_estacion'];
}

$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$IdEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}

function Personal($idPersonal,$con)
{
$sql = "SELECT id, nombre_completo, puesto, fecha_ingreso FROM op_rh_personal WHERE id = '".$idPersonal."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Nombre = $row['nombre_completo'];
$Fecha = $row['fecha_ingreso']; 
$Puesto = Puesto($row['puesto'],$con);
}
$array = array('Nombre' => $Nombre, 'Fecha' => $Fecha, 'Puesto' => $Puesto);

return $array;
}

function Puesto($idPuesto,$con){
$sql = "SELECT puesto FROM op_rh_puestos WHERE id = '".$idPuesto."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Puesto = $row['puesto'];
}
return $Puesto;
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

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");

    });

    function Regresar(){window.history.back();}
    function CrearToken(idReporte){
    $(".LoaderPage").show();

    var parametros = {
    "idReporte" : idReporte
    };

    $.ajax({
    data:  parametros,
    url:   '../public/recursos-humanos/modelo/token-pago-vacaciones.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    $(".LoaderPage").hide();

   if(response == 1){
     alertify.message('El token fue enviado por mensaje');   
   }else{
     alertify.error('Error al crear el token');   
   }

    }
    });

    }

    function FirmarSolicitud(idReporte,tipoFirma){

    var TokenValidacion = $('#TokenValidacion').val();

    var parametros = {
    "idReporte" : idReporte,
    "tipoFirma" : tipoFirma,
    "TokenValidacion" : TokenValidacion
    };

  if(TokenValidacion != ""){
  $('#TokenValidacion').css('border',''); 

    $(".LoaderPage").show();

      $.ajax({
    data:  parametros,
    url:   '../public/recursos-humanos/modelo/firmar-pago-vacaciones.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    $(".LoaderPage").hide();

    if(response == 1){

    $('#ModalFinalizado').modal('show'); 

    }else{
     $('#ModalError').modal('show');
     alertify.error('Error al firmar la solicitud');
    }

    }
    });

  }else{
  $('#TokenValidacion').css('border','2px solid #A52525'); 
  }

  }

       function CrearTokenEmail(idReporte){
    $(".LoaderPage").show();

    var parametros = {
    "idReporte" : idReporte
    };

    $.ajax({
    data:  parametros,
    url:   '../public/recursos-humanos/modelo/token-email-pago-vacaciones.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    $(".LoaderPage").hide();

   if(response == 1){
     alertify.message('El token fue enviado por correo electrónico');   
   }else{
     alertify.error('Error al crear el token');   
   }

    }
    });
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
    
    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12">
    <h5>Firmar pago de vacaciones</h5>
    </div>

    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
    <span class="badge rounded-pill tables-bg float-end" style="font-size:12.5px"><?=$estacion;?> - <?=$NomMes;?> <?=$NomYear;?></span>
    </div>

    </div>

    </div>
    </div>

  <hr>

 <div class="table-responsive">
<table class="table table-sm table-bordered mb-0">
  <thead>
    <tr class="tables-bg">
      <th class="align-middle">Nombre</th>
      <th class="align-middle">Puesto</th>
      <th class="align-middle">Fecha ingreso</th>
      <th class="align-middle">Años laborales</th>
      <th class="align-middle">Días vacaciones</th>
    </tr>
  </thead>
  <tbody>
  <?php 
  $sql = "SELECT * FROM op_rh_vacaciones_pago_detalle WHERE id_vacaciones_pago = '".$GET_idReporte."' ";
  $result = mysqli_query($con, $sql);
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
  $Personal = Personal($row['id_personal'],$con);

  echo '<tr>
  <td class="align-middle">'.$Personal['Nombre'].'</td>
  <td class="align-middle">'.$Personal['Puesto'].'</td>
  <td class="align-middle">'.FormatoFecha($Personal['Fecha']).'</td>
  <td class="align-middle">'.$row['year'].' años</td>
  <td class="align-middle">'.$row['dias'].' días</td>
  </tr>';
  }

  ?>
  </tbody>
</table>
</div>


<?php if($Session_IDUsuarioBD == 2){ ?>
<div class="row">
<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-3">
<div class="border p-3 ">
<div class="mb-2 text-secondary text-center">FIRMA DE AUTORIZACIÓN</div>
<hr>
<h4 class="text-primary text-center">Token Móvil</h4>
<small class="text-secondary">Agregue el token enviado a su número de teléfono o de clic en el siguiente botón para crear uno</small>
<br>
<button class="btn btn-sm btn-light mt-2" onclick="CrearToken(<?=$GET_idReporte;?>)"><small>Crear token</small></button>
<button class="btn btn-sm btn-light mt-2" onclick="CrearTokenEmail(<?=$GET_idReporte;?>)"><small>Crear token vía email</small></button>
<hr>
<div class="input-group mt-3">
  <input type="text" class="form-control" placeholder="Token de seguridad" aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="button" onclick="FirmarSolicitud(<?=$GET_idReporte;?>,'A')">Firmar solicitud</button>
  </div>
</div>
</div>
</div>
</div>
<?php }?>



  </div>
  </div>
  </div>

  </div>
  </div>

  </div>



 <div class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" id="ModalFinalizado">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top: 83px;">
      <div class="modal-body">

       <h5 class="text-info">El token fue validado correctamente.</h5>
       <div class="text-secondary">La solicitud pago de vacaciones fue firmada.</div>


      <div class="text-end">
        <button type="button" class="btn btn-primary" onclick="Regresar()">Aceptar</button>
      </div>

      </div>
    </div>
  </div>
</div>

  <div class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" id="ModalError">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top: 83px;">
      <div class="modal-body">

       <h5 class="text-danger">El token no fue aceptado, vuelva a generar uno nuevo o inténtelo mas tarde </h5>
       <div class="text-secondary">La solicitud pago de vacaciones no fue firmada.</div>


      <div class="text-end">
        <button type="button" class="btn btn-primary mt-2" data-bs-dismiss="modal">Aceptar</button>
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