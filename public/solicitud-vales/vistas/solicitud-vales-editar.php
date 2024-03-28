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

var Estacion      = $('#Estacion').val();
var Cuentas      = $('#Cuentas').val();

var Autorizadopor      = $('#Autorizadopor').val();
var MetodoAutorizacion      = $('#MetodoAutorizacion').val();

Archivo = document.getElementById("Archivo");
Archivo_file = Archivo.files[0];
Archivo_filePath = Archivo.value;

var data = new FormData();
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

  data.append('idEstacion', idEstacion);
  data.append('idReporte', idReporte);
  data.append('GETyear', GETyear);
  data.append('GETmes', GETmes);

  data.append('Fecha', Fecha);
  data.append('Monto', Monto);
  data.append('Moneda', Moneda);
  data.append('Concepto', Concepto);
  data.append('Solicitante', Solicitante);
  data.append('Observaciones', Observaciones);
  data.append('Archivo_file', Archivo_file);

  data.append('Estacion', Estacion);
  data.append('Cuentas', Cuentas);

  data.append('Autorizadopor', Autorizadopor);
  data.append('MetodoAutorizacion', MetodoAutorizacion);

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
      alertify.error('Error al crear la solicitud de vale'); 
     }
     
    }); 

}else{
$('#Solicitante').css('border','2px solid #A52525'); 
}
}else{
$('#Concepto').css('border','2px solid #A52525'); 
}
}else{
$('#Moneda').css('border','2px solid #A52525'); 
}
}else{
$('#Monto').css('border','2px solid #A52525'); 
}
}else{
$('#Fecha').css('border','2px solid #A52525'); 
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

     <h5>Editar Solicitud de vale</h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>

<div class="container">
  <div class="row">

  <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary">FECHA:</div>
  <input type="date" class="form-control rounded-0" id="Fecha" value="<?=$fecha;?>"> 
  </div>

  <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 mb-2">
  <div class="mb-1 text-secondary">MONTO:</div>
  <input type="number" min="0" class="form-control rounded-0" id="Monto" value="<?=$monto;?>">
  </div>


  <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 mb-2">
  <div class="mb-1 text-secondary">MONEDA:</div>
  <select class="form-select rounded-0" id="Moneda">
  <option><?=$moneda;?></option>
  <option>MXN</option>
  <option>USD</option>
  </select>
  </div>

  </div>
      
  <div class="row ">

  <div class="col-12 mb-2">  
  <div class="mb-1 text-secondary mt-2">CONCEPTO:</div>
  <textarea class="form-control rounded-0" id="Concepto"><?=$concepto;?></textarea>
  </div>

        
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary">NOMBRE DEL SOLICITANTE:</div>
  <input type="text" class="form-control rounded-0" id="Solicitante" value="<?=$solicitante;?>" >
  </div>

  </div>

    <?php if($GET_idEstacion == 8){ ?>
  <h6>Cargo a cuenta:</h6>
  <div class="row">

    <div class="col-6">
      <div class="mb-1 text-secondary mt-2">ESTACION:</div>
      <select class="form-control rounded-0" id="Estacion">
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
    
      <div class="col-6">
      
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
  <?php } ?>

    <div class="row">
  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2 mt-2">  
  <div class="mb-1 text-secondary">AUTORIZADO POR:</div>
  <input type="text" class="form-control rounded-0" value="<?=$autorizadopor;?>" id="Autorizadopor" >
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2 mt-2">  
  <div class="mb-1 text-secondary">METODO DE AUTORIZACION:</div>
  <select class="form-control rounded-0" id="MetodoAutorizacion">
    <option><?=$metodoautorizacion;?></option>
    <option>Personal</option>
    <option>Telefónica</option>
  </select>
  </div>


  <div class="row mt-2">          
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary">OBSERVACIONES:</div>
  <textarea class="form-control rounded-0" id="Observaciones"></textarea>
  </div>
  </div>
  </div>

  <div class="row">          
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary">OBSERVACIONES:</div>
  <textarea class="form-control rounded-0" id="Observaciones"><?=$observaciones;?></textarea>
  </div>
  </div>

<div class="mb-1 text-secondary mt-2">Archivo:</div>
<input type="file" class="form-control" id="Archivo">

<hr>
<div class="text-end">
<button type="button" class="btn btn-primary" onclick="Guardar(<?=$GET_idEstacion;?>,<?=$GET_idReporte;?>,<?=$GET_year;?>,<?=$GET_mes;?>)">Guardar</button>
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



