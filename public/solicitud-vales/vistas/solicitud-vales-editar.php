<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

$sql_lista = "SELECT * FROM op_solicitud_vale WHERE id = '".$GET_idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$fecha = $row_lista['fecha'];
$monto = $row_lista['monto'];
$moneda = $row_lista['moneda'];
$concepto = $row_lista['concepto'];
$solicitante = $row_lista['solicitante'];
$observaciones = $row_lista['observaciones'];
$idEstacion = $row_lista['id_estacion'];
$Estacion = Estacion($row_lista['id_estacion'],$con);
$cuenta = $row_lista['cuenta'];

$autorizadopor = $row_lista['autorizado_por'];
$metodoautorizacion = $row_lista['metodo_autorizacion'];
}

function Estacion($idestacion,$con){
$sql_listaestacion = "SELECT id, nombre, razonsocial FROM tb_estaciones WHERE id = '".$idestacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$id = $row_listaestacion['id'];
$estacion = $row_listaestacion['razonsocial'];
$nombre = $row_listaestacion['nombre'];
}
return $nombre;
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

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  });

  function Regresar(){
  window.history.back();
  }

function Guardar(idEstacion,idReporte,GETyear,GETmes){

var Fecha              = $('#Fecha').val();
var Monto              = $('#Monto').val();
var Moneda             = $('#Moneda').val();
var Concepto           = $('#Concepto').val();
var Solicitante        = $('#Solicitante').val();
var Observaciones      = $('#Observaciones').val();
var Estacion           = $('#Estacion').val();
var Cuentas            = $('#Cuentas').val();
var Autorizadopor      = $('#Autorizadopor').val();
var MetodoAutorizacion = $('#MetodoAutorizacion').val();
var Departamento       = $('#Departamento').val();

var data = new FormData();
//var url = '../../../../app/controlador/1-corporativo/controladorSolicitudVale.php';
var url = '../../../../public/solicitud-vales/modelo/editar-solicitud-vale.php';
 
if(Fecha != ""){
$('#Fecha').css('border',''); 
if(Monto != ""){
$('#Monto').css('border',''); 
if(Moneda != ""){
$('#Moneda').css('border',''); 
if(Concepto != ""){
$('#Concepto').css('border',''); 
if(Solicitante != ""){
$('#Solicitante').css('border',''); 
 
// Si el idEstacion es 8 o el usuario es 292, validar Estacion y Cuentas
if (idEstacion == 8 || <?=$Session_IDUsuarioBD?> == 292) {
// Lógica para mandar uno vacío si el otro está lleno
if (Cuentas !== "") {
data.append('Estacion', "");  // Mandar Estacion vacío
data.append('Cuentas', Cuentas);
$('#Estacion').css('border', '');
$('#Cuentas').css('border', '');
}else if (Estacion !== "") {
data.append('Estacion', Estacion);
data.append('Cuentas', "");  // Mandar Cuentas vacío
$('#Estacion').css('border', '');
$('#Cuentas').css('border', '');
}else {
alertify.error('Debe seleccionar una Estación o ingresar una Cuenta.');
$('#Estacion').css('border', '2px solid #A52525');
$('#Cuentas').css('border', '2px solid #A52525');
return; // Detener la ejecución si ninguno está lleno
}

}else{
data.append('Estacion', Estacion);
data.append('Cuentas', Cuentas);
}

if (Autorizadopor != "") {
$('#Autorizadopor').css('border', '');
if (MetodoAutorizacion != "") {
$('#MetodoAutorizacion').css('border', '');

  data.append('idReporte', idReporte);
  data.append('idEstacion', idEstacion);
  data.append('GETyear', GETyear);
  data.append('GETmes', GETmes);
  data.append('idUsuario', <?=$Session_IDUsuarioBD?>);
  data.append('Fecha', Fecha);
  data.append('Monto', Monto);
  data.append('Moneda', Moneda);
  data.append('Concepto', Concepto);
  data.append('Solicitante', Solicitante);
  data.append('Observaciones', Observaciones);
  data.append('Autorizadopor', Autorizadopor);
  data.append('MetodoAutorizacion', MetodoAutorizacion);
  data.append('Departamento', Departamento);

    $(".LoaderPage").show();

    $.ajax({
    url: url,
    type: 'POST',
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(data){
      
      console.log(data)

    if(data == 1){
      Regresar();
     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al editar la solicitud de vale'); 
     }
     
    }); 

  } else {
              $('#MetodoAutorizacion').css('border', '2px solid #A52525');
              alertify.error('Falta ingresar el metodo de autorización.');
            }
          } else {
            $('#Autorizadopor').css('border', '2px solid #A52525');
            alertify.error('Falta ingresar el nombre del quien autoriza.');
          }
        } else {
          $('#Solicitante').css('border', '2px solid #A52525');
          alertify.error('Falta ingresar el nombre del solicitante.');
        }
      } else {
        $('#Concepto').css('border', '2px solid #A52525');
        alertify.error('Falta ingresar el concepto.');
      }
    } else {
      $('#Moneda').css('border', '2px solid #A52525');
      alertify.error('Falta seleccionar la moneda.');
    }
  } else {
    $('#Monto').css('border', '2px solid #A52525');
    alertify.error('Falta ingresar el monto.');
  }
} else {
  $('#Fecha').css('border', '2px solid #A52525');
  alertify.error('Falta ingresar la fecha.');
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
  <div class="container">

  <div class="row">

  <div class="col-12 mb-3">
  <div class="cardAG">
  <div class="border-0 p-3">

  <div class="row">

  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i>
  Solicitud de Vale</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Editar Solicitud de Vale</li>
  </ol>
  </div>
  
  <div class="row"> 
  <div class="col-12 mb-1"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Editar Solicitud de Vale</h3> </div>
  </div>

  <hr>
  </div>

  <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary fw-bold">* FECHA:</div>
  <input type="date" class="form-control rounded-0" id="Fecha" value="<?=$fecha;?>"> 
  </div>

  <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-2">
  <div class="mb-1 text-secondary fw-bold">* MONTO:</div>
  <input type="number" min="0" class="form-control rounded-0" id="Monto" value="<?=$monto;?>">
  </div>


  <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-2">
  <div class="mb-1 text-secondary">MONEDA:</div>
  <select class="form-select rounded-0" id="Moneda">
  <option><?=$moneda;?></option>
  <option>MXN</option>
  <option>USD</option>
  </select>
  </div>


  <div class="col-12 mb-2">  
  <div class="mb-1 text-secondary mt-2 fw-bold">* CONCEPTO:</div>
  <textarea class="form-control rounded-0" id="Concepto"><?=$concepto;?></textarea>
  </div>

        
  <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary fw-bold">* NOMBRE DEL SOLICITANTE:</div>
  <input type="text" class="form-control rounded-0" id="Solicitante" value="<?=$solicitante;?>" >
  </div>

  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary">DEPARTAMENTO:</div>
  <select class="form-select rounded-0" id="Departamento">
    <option value=""></option>
    <option value="2">Sistemas</option>
    <option value="4">Comercializadora</option>
    <option value="5">Gestoria</option>
    <option value="8">Mantenimiento</option>
    <option value="13">Dirección de operaciones</option>
    <option value="15">Departamento Jurídico</option>
  </select>
  </div>

  <?php if($GET_idEstacion == 8 || $Session_IDUsuarioBD == 292){ ?>
  <div class="col-12">  
  <hr>
  <h6>CARGO A CUENTA:</h6>
  <div class="row">

  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">  
      <div class="mb-1 text-secondary mt-2">ESTACION:</div>
      <select class="form-select rounded-0" id="Estacion">
      <option value="<?=$idEstacion;?>"><?=$Estacion;?></option>
      <?php 
        $sql = "SELECT id, nombre, numlista FROM tb_estaciones WHERE numlista <= 8 ORDER BY numlista ASC";
        $result = mysqli_query($con, $sql);
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
          echo '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';
        }
        ?>
      </select>
    </div>
    
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">  
      <div class="mb-1 text-secondary mt-2">CUENTAS:</div>
      <input class="form-control rounded-0" type="text" multiple list="CargoCuentas" id="Cuentas" value="<?=$cuenta;?>" />
      <datalist id="CargoCuentas">
      <option value="Club deportivo"></option>
      <option value="Gasera"></option>
      <option value="Ecatepec"></option>
      <option value="Escuela wingate"></option>
      <option value="Sabino"></option>
      <option value="Acueducto"></option>
      <option value="G500 Corp"></option>
      <option value="Aguascalientes"></option>
      <option value="Verificentro"></option>
      <option value="Castorena"></option>
      <option value="Conflicto zona 2"></option>
      <option value="Conflicto zona 3-Oropeza"></option>
      <option value="Terrenos zona 1"></option>
      <option value="Rancho"></option>
      <option value="AQS"></option>
      <option value="Pozo el mirador"></option>
      <option value="Chaparral"></option>
      <option value="Pozo el estímulo"></option>
      <option value="Remolques"></option>
      <option value="Honorarios"></option>
      <option value="Fraccionadores"></option>
      <option value="MP"></option>
      </datalist>

    </div>
  </div>

  </div>
  <?php } ?>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2 mt-2">  
  <div class="mb-1 text-secondary fw-bold">* AUTORIZADO POR:</div>
  <input type="text" class="form-control rounded-0" value="<?=$autorizadopor;?>" id="Autorizadopor" >
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2 mt-2">  
  <div class="mb-1 text-secondary fw-bold">* METODO DE AUTORIZACION:</div>
  <select class="form-select rounded-0" id="MetodoAutorizacion">
  <option><?=$metodoautorizacion;?></option>
  <option>Personal</option>
  <option>Telefónica</option>
  </select>
  </div>

  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">  
  <div class="mb-1 text-secondary">OBSERVACIONES:</div>
  <textarea class="form-control rounded-0" id="Observaciones"><?=$observaciones;?></textarea>
  </div>
   
  <div class="col-12">  
  <hr>
  <button type="button" class="btn btn-labeled2 btn-success float-end" onclick="Guardar(<?=$GET_idEstacion;?>,<?=$GET_idReporte;?>,<?=$GET_year;?>,<?=$GET_mes;?>)">
  <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
  </div>

  </div>


  </div>

  </div>
  </div>
  </div>

  </div>
  </div>
  </div>
  </div>


  </div>
  </div>

  </div>

<!--
  <script>
  // Obtener los elementos de Estacion y Cuentas
  const estacionSelect = document.getElementById('Estacion');
  const cuentasInput = document.getElementById('Cuentas');

  // Función que deshabilita/activa los elementos dependiendo del valor
  function toggleElements() {
    if (estacionSelect.value !== "") {
      cuentasInput.disabled = true;  // Si hay valor en Estación, deshabilitar Cuentas
    } else {
      cuentasInput.disabled = false;  // Si no hay valor, activar Cuentas
    }
    
    if (cuentasInput.value !== "") {
      estacionSelect.disabled = true;  // Si hay valor en Cuentas, deshabilitar Estación
    } else {
      estacionSelect.disabled = false;  // Si no hay valor, activar Estación
    }
  }

  // Escuchar el cambio de valor en ambos elementos
  estacionSelect.addEventListener('change', toggleElements);
  cuentasInput.addEventListener('input', toggleElements);

  // Llamar la función inicialmente para verificar los valores
  toggleElements();
  </script>
      -->

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>



