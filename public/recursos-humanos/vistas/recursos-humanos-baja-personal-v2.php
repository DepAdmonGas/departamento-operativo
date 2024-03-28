<?php
require('app/help.php');
 
if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

$sql = "SELECT
op_rh_personal.fecha_ingreso, 
op_rh_personal.no_colaborador, 
op_rh_personal.nombre_completo, 
op_rh_puestos.puesto 
FROM op_rh_personal 
INNER JOIN op_rh_puestos ON op_rh_personal.puesto = op_rh_puestos.id
WHERE op_rh_personal.id = '".$GET_idPersonal."' ";

$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$fecha_ingreso = $row['fecha_ingreso'];
$no_colaborador = $row['no_colaborador'];
$nombrePersonal = $row['nombre_completo'];
$puesto = $row['puesto'];
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

  function Regresar(){
  window.history.back();
  }

  function BajaPersonal(idPersonal){

    let FechaBaja = $('#FechaBaja').val();
    let Motivo = $('#Motivo').val();
    let Detalle = $('#Detalle').val();
    
    ActaHechos = document.getElementById("ActaHechos");
    ActaHechos_file = ActaHechos.files[0];
    ActaHechos_filePath = ActaHechos.value;

    CartaRenuncia = document.getElementById("CartaRenuncia");
    CartaRenuncia_file = CartaRenuncia.files[0];
    CartaRenuncia_filePath = CartaRenuncia.value;

    ValFiniquito = document.getElementById("Finiquito");
    Finiquito_file = ValFiniquito.files[0];
    Finiquito_filePath = ValFiniquito.value;

    var data = new FormData();
    var url = '../public/recursos-humanos/modelo/agregar-baja-personal.php';

    data.append('idPersonal', idPersonal);
    data.append('FechaBaja', FechaBaja);
    data.append('Motivo', Motivo);
    data.append('Detalle', Detalle);  
    data.append('ActaHechos_file', ActaHechos_file);
    data.append('CartaRenuncia_file', CartaRenuncia_file);
    data.append('Finiquito_file', Finiquito_file);

    if(FechaBaja != ""){
    $('#FechaBaja').css('border','');
    if(Motivo != ""){
    $('#Motivo').css('border','');    
    if(Detalle != ""){
    $('#Detalle').css('border','');

    $(".LoaderPage").show();

    $.ajax({
    url: url,
    type: 'POST',
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(result){


    if(result == 1){
       
     Regresar();
     
     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al dar de baja personal'); 
     }
      
    }); 

    }else{
    $('#Detalle').css('border','2px solid #A52525'); 
    }
    }else{
    $('#Motivo').css('border','2px solid #A52525'); 
    }
    }else{
    $('#FechaBaja').css('border','2px solid #A52525'); 
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

     <h5>Baja de personal</h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>

  <div class="row">
    <div class="col-12 col-md-4">
      <div class="text-secondary"><small>Fecha ingreso:</small></div>
      <div class="mt-1"><h6><?=FormatoFecha($fecha_ingreso);?></h6></div>
    </div>
     <div class="col-12 col-md-2">
      <div class="text-secondary"><small>No. de colaborador:</small></div>
      <div class="mt-1"><h6><?=$no_colaborador;?></h6></div>
    </div>
    <div class="col-12 col-md-4">
      <div class="text-secondary"><small>Nombre completo:</small></div>
      <div class="mt-1"><h6><?=$nombrePersonal;?></h6></div>
    </div>
    <div class="col-12 col-md-2">
      <div class="text-secondary"><small>Puesto:</small></div>
      <div class="mt-1"><h6><?=$puesto;?></h6></div>
    </div>
  </div>

  <div class="row">
     <div class="col-12 col-md-4">

      <div class="text-secondary mt-2">Fecha baja:</div>
      <input class="form-control mt-1" type="date" id="FechaBaja">

     </div>
    <div class="col-12 col-md-4">
      
      <div class="text-secondary mt-2">Motivo:</div>
      <input type="text" list="DataList" class="form-control mt-1" id="Motivo">
      <datalist id="DataList">
        <option>Renuncia voluntaria</option>
        <option>Mala practica</option>
        <option>Abandono laboral</option>
      </datalist>

    </div>
    <div class="col-12 col-md-4">

      <div class="text-secondary mt-2">Detalle:</div>
      <textarea class="form-control mt-1" rows="1" id="Detalle"></textarea>

    </div>
     <div class="col-12 col-md-4">

      <div class="text-secondary mt-2">Acta de hechos:</div>
      <input class="form-control mt-1" type="file" id="ActaHechos">

     </div>
      <div class="col-12 col-md-4">

      <div class="text-secondary mt-2">Carta de Renuncia:</div>
      <input class="form-control mt-1" type="file" id="CartaRenuncia">

     </div>
     <div class="col-12 col-md-4">

      <div class="text-secondary mt-2">Finiquito:</div>
      <input class="form-control mt-1" type="file" id="Finiquito">

     </div>
  </div>

<hr>

  <div class="text-end">
  <button type="button" class="btn btn-primary" onclick="BajaPersonal(<?=$GET_idPersonal;?>)">Dar baja</button>
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
