<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
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

  function Guardar(){
    var Fecha              = $('#Fecha').val();
    var RazonSocial        = $('#RazonSocial').val();
    var ActividadEco       = $('#ActividadEco').val();
    var Email              = $('#Email').val();
    var RFC                = $('#RFC').val();
    var Ciudad             = $('#Ciudad').val();
    var Telefono1          = $('#Telefono1').val();
    var Telefono2          = $('#Telefono2').val();
    var Direccion          = $('#Direccion').val();
    var Beneficiario       = $('#Beneficiario').val();
    var Banco              = $('#Banco').val();
    var Metodopago         = $('#Metodopago').val();
    var CFDI               = $('#CFDI').val();
    var Moneda             = $('#Moneda').val();
    var FormaPago          = $('#FormaPago').val();

    var Descripcion        = $('#Descripcion').val();

    var FechaConstancia    = $('#FechaConstancia').val();
    var FechaCaratula      = $('#FechaCaratula').val();

    var data = new FormData();
    var url = '../public/admin/modelo/agregar-proveedor-almacen.php';
  
    var DocConstancia    = $('#ConstanciaS').val();
    ConstanciaS = document.getElementById("ConstanciaS");
    ConstanciaS_file = ConstanciaS.files[0];
    ConstanciaS_filePath = ConstanciaS.value;

    var DocCaratula    = $('#CaratulaB').val();
    CaratulaB = document.getElementById("CaratulaB");
    CaratulaB_file = CaratulaB.files[0];
    CaratulaB_filePath = CaratulaB.value;

  if(Fecha != ""){
  $('#Fecha').css('border',''); 

  if(RazonSocial != ""){
  $('#RazonSocial').css('border',''); 

  if(ActividadEco != ""){
  $('#ActividadEco').css('border',''); 

  if(Email != ""){
  $('#Email').css('border',''); 

  if(RFC != ""){
  $('#RFC').css('border',''); 

  if(Ciudad != ""){
  $('#Ciudad').css('border',''); 

  if(Telefono1 != ""){
  $('#Telefono1').css('border',''); 

  if(Direccion != ""){
  $('#Direccion').css('border',''); 

  if(Beneficiario != ""){
  $('#Beneficiario').css('border',''); 

  if(Banco != ""){
  $('#Banco').css('border',''); 

  if(Metodopago != ""){
  $('#Metodopago').css('border',''); 

  if(CFDI != ""){
  $('#CFDI').css('border',''); 

  if(FormaPago != ""){
  $('#FormaPago').css('border',''); 

  if(Descripcion != ""){
  $('#Descripcion').css('border',''); 

  if(DocConstancia != ""){
  $('#ConstanciaS').css('border',''); 

  if(FechaConstancia != ""){
  $('#FechaConstancia').css('border',''); 

  if(DocCaratula != ""){
  $('#CaratulaB').css('border',''); 

  if(FechaCaratula != ""){
  $('#FechaConstancia').css('border',''); 

  data.append('Fecha', Fecha);
  data.append('RazonSocial', RazonSocial);  
  data.append('ActividadEco', ActividadEco);
  data.append('Email', Email);
  data.append('RFC', RFC);
  data.append('Ciudad', Ciudad);
  data.append('Telefono1', Telefono1);
  data.append('Telefono2', Telefono2);
  data.append('Direccion', Direccion);
  data.append('Beneficiario', Beneficiario);
  data.append('Banco', Banco);
  data.append('Metodopago', Metodopago);
  data.append('CFDI', CFDI);
  data.append('Moneda', Moneda);
  data.append('FormaPago', FormaPago);

  data.append('Descripcion', Descripcion);

  data.append('FechaConstancia', FechaConstancia);
  data.append('FechaCaratula', FechaCaratula);
 
  data.append('ConstanciaS_file', ConstanciaS_file);
  data.append('CaratulaB_file', CaratulaB_file);

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
      alertify.error('Error al crear el proveedor'); 
     }
     
    }); 
  
  }else{
  $('#FechaCaratula').css('border','2px solid #A52525'); 
  }

  }else{
  $('#CaratulaB').css('border','2px solid #A52525'); 
  }

  }else{
  $('#FechaConstancia').css('border','2px solid #A52525'); 
  }

  }else{
  $('#ConstanciaS').css('border','2px solid #A52525'); 
  }

  }else{
  $('#Descripcion').css('border','2px solid #A52525'); 
  }

  }else{
  $('#FormaPago').css('border','2px solid #A52525'); 
  }

  }else{
  $('#CFDI').css('border','2px solid #A52525'); 
  }

  }else{
  $('#Metodopago').css('border','2px solid #A52525'); 
  }

  }else{
  $('#Banco').css('border','2px solid #A52525'); 
  }

  }else{
  $('#Beneficiario').css('border','2px solid #A52525'); 
  }

  }else{
  $('#Direccion').css('border','2px solid #A52525'); 
  }

  }else{
  $('#Telefono1').css('border','2px solid #A52525'); 
  }

  }else{
  $('#Ciudad').css('border','2px solid #A52525'); 
  }

  }else{
  $('#RFC').css('border','2px solid #A52525'); 
  }

  }else{
  $('#Email').css('border','2px solid #A52525'); 
  }

  }else{
  $('#ActividadEco').css('border','2px solid #A52525'); 
  }

  }else{
  $('#RazonSocial').css('border','2px solid #A52525'); 
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

     <h5>Crear Proveedor</h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>

  <div class="container">
 
  <div class="border p-3 mb-3"> 

  <h6>INFORMACIÓN GENERAL</h6>
  <hr>

  <div class="row">

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary">FECHA:</div>
  <input type="date" class="form-control rounded-0" id="Fecha" value="<?=$fecha_del_dia;?>"> 
  </div>

  </div>
      
  <div class="row ">
          
    <div class="col-12 mb-2">
    <div class="mb-1 text-secondary">RAZÓN SOCIAL:</div>
    <input type="text" class="form-control rounded-0" id="RazonSocial" >
    </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
    <div class="mb-1 text-secondary">ACTIVIDAD ECONOMICA:</div>
    <input type="text" min="0" class="form-control rounded-0" id="ActividadEco" >
    </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
    <div class="mb-1 text-secondary">E-MAIL:</div>
    <input type="text" min="0" class="form-control rounded-0" id="Email" >
    </div>

    <div class="col-12 mb-2">
    <div class="mb-1 text-secondary">RFC:</div>
    <input type="text" min="0" class="form-control rounded-0" id="RFC" >
    </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
    <div class="mb-1 text-secondary">CIUDAD:</div>
    <input type="text" min="0" class="form-control rounded-0" id="Ciudad" >
    </div>

    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mb-2">  
    <div class="mb-1 text-secondary">TELÉFONO 1:</div>
    <input type="number" class="form-control rounded-0" id="Telefono1" >
    </div>

    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mb-2">  
    <div class="mb-1 text-secondary">TELÉFONO 2:</div>
    <input type="number" class="form-control rounded-0" id="Telefono2" >
    </div>

    <div class="col-12 mb-2">
    <div class="mb-1 text-secondary">DIRECCIÓN:</div>
    <input type="text" min="0" class="form-control rounded-0" id="Direccion" >
    </div>

    <div class="col-12 mb-2">
    <div class="mb-1 text-secondary">NOMBRE DEL BENEFICIARIO:</div>
    <input type="text" min="0" class="form-control rounded-0" id="Beneficiario" >
    </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
    <div class="mb-1 text-secondary">BANCO:</div>
    <input type="text" class="form-control rounded-0" id="Banco" >
    </div>


    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
    <div class="mb-2 text-secondary">MÉTODO DE PAGO:</div>
    <select class="form-select rounded-0" id="Metodopago">
      <option value="">Seleccione una opcion...</option>
      <option>PUE Pago en una sola exhibición</option>
      <option>PPD Pago en parcialidades o diferido</option>
    </select>
    </div>

    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 mb-2">  
    <div class="mb-2 text-secondary">USO DEL CDFI:</div>
    <select class="form-select rounded-0" id="CFDI">
        <option value="">Seleccione una opcion...</option>
        <option>G01 Adquisicion de Mercancias</option>
        <option>G02 Devoluciones, Descuentos o Bonificaciones</option>
        <option>G03 Gastos en General</option>
        <option>I01 Construcciones</option>
        <option>I02 Mobiliario y Equipo de Oficina por Inversiones</option>
        <option>I03 Equipo de Transporte</option>
        <option>I04 Equipo de Computo y Accesorios</option>
        <option>I05 Dados, Troqueles, Moldes, Matrices y Herramental</option>
        <option>I06 Comunicaciones Telefonicas</option>
        <option>I07 Comunicaciones Satelitales</option>
        <option>I08 Otra Maquinaria y Equipo</option>
        <option>P01 Por Definir</option>
    </select>
    </div>

    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 mb-2">
    <div class="mb-1 text-secondary">MONEDA:</div>
    <select class="form-select rounded-0" id="Moneda">
        <option>MXN</option>
        <option>USD</option>
    </select>
    </div>

    <div class="col-12 mb-2">     
    <div class="mb-1 text-secondary">FORMA DE PAGO:</div>
    <select class="form-select rounded-0" id="FormaPago">
        <option value="">Seleccione una opcion...</option>
        <option>01  Efectivo</option>
        <option>02  Cheque nominativo</option>
        <option>02  Cheque Certificado</option>
        <option>03  Transferencia electrónica de fondos</option>
        <option>04  Tarjeta de crédito</option>
        <option>05  Monedero electrónico</option>
        <option>06  Dinero electrónico</option>
        <option>08  Vales de despensa</option>
        <option>12  Dación en pago</option>
        <option>13  Pago por subrogación</option>
        <option>14  Pago por consignación</option>
        <option>15  Condonación</option>
        <option>17  Compensación</option>
        <option>23  Novación</option>
        <option>24  Confusión</option>
        <option>25  Remisión de deuda</option>
        <option>26  Prescripción o caducidad</option>
        <option>27  A satisfacción del acreedor</option>
        <option>28  Tarjeta de débito</option>
        <option>29  Tarjeta de servicios</option>
        <option>30  Aplicación de anticipos</option>
        <option>31  Intermediario pagos</option>
        <option>99  Por definir</option>
    </select>
    </div>

  </div>
  </div>

  <!---------- PRODUCTOS O SERVICIOS OFRECIDOS ---------->
  <div class="border p-3 mb-3"> 

  <h6>PRODUCTOS O SERVICIOS OFRECIDOS</h6>
  <hr>

  <div class="col-12 mb-2">  
  <div class="mb-1 text-secondary">DESCRIPCIÓN:</div>
  <textarea class="form-control rounded-0" id="Descripcion"></textarea>
  </div>

  </div>



  <!---------- ANEXAR LA DOCUMENTACION ---------->
  <div class="border p-3 mb-3"> 

  <h6>ANEXAR LA DOCUMENTACION</h6>
  <hr>
  
  <div class="row">

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary">CONSTANCIA DE SITUACION FISCAL:</div>
  <input type="file" class="form-control" id="ConstanciaS">
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary">FECHA ULTIMA ACTUALIZACIÓN:</div>
  <input type="date" class="form-control rounded-0" id="FechaConstancia"> 
  </div>


  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary">CARATULA BANCARIA:</div>
  <input type="file" class="form-control" id="CaratulaB">
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary">FECHA ULTIMA ACTUALIZACIÓN:</div>
  <input type="date" class="form-control rounded-0" id="FechaCaratula"> 
  </div>


  </div>

  </div>

  <hr>

  <div class="text-end">
   <button type="button" class="btn btn-primary" onclick="Guardar()">Guardar</button>
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
