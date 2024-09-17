<?php
require('app/help.php');

$datosSolicitudCheque = $corteDiarioGeneral->obtenerDatosSolicitudCheque($GET_idReporte);
$fecha = $datosSolicitudCheque['fecha'];
$beneficiario = $datosSolicitudCheque['beneficiario'];
$monto = $datosSolicitudCheque['monto'];
$moneda = $datosSolicitudCheque['moneda'];
$nofactura = $datosSolicitudCheque['no_factura'];
$email = $datosSolicitudCheque['email'];
$concepto = $datosSolicitudCheque['concepto'];
$solicitante = $datosSolicitudCheque['solicitante'];
$telefono = $datosSolicitudCheque['telefono'];
$cfdi = $datosSolicitudCheque['cfdi'];
$metodo_pago = $datosSolicitudCheque['metodo_pago'];
$forma_pago = $datosSolicitudCheque['forma_pago'];
$banco = $datosSolicitudCheque['banco'];
$nocuenta = $datosSolicitudCheque['no_cuenta'];
$cuentaclabe = $datosSolicitudCheque['cuenta_clabe'];
$referencia = $datosSolicitudCheque['referencia'];
$observaciones = $datosSolicitudCheque['observaciones'];
$status = $datosSolicitudCheque['status'];
$razonsocial = $datosSolicitudCheque['razonsocial'];
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

  function SolicitudCheque(year){
  window.location.href = "solicitud-cheque/" + year;
  }

  function Guardar(IdReporte){
   
    var ctx = document.getElementById("canvas");
    var image = ctx.toDataURL();
    document.getElementById('base64').value = image;

    var Fecha              = $('#Fecha').val();
    var Beneficiario       = $('#Beneficiario').val();
    var Monto              = $('#Monto').val();
    var Moneda             = $('#Moneda').val();
    var NoFactura          = $('#NoFactura').val();
    var Correo             = $('#Correo').val();
    var Concepto           = $('#Concepto').val();
    var Solicitante        = $('#Solicitante').val();
    var Telefono           = $('#Telefono').val();
    var CFDI               = $('#CFDI').val();
    var Metodopago         = $('#Metodopago').val();
    var FormaPago          = $('#FormaPago').val();
    var Banco              = $('#Banco').val();
    var NoCuenta           = $('#NoCuenta').val();
    var NoCuentaClave      = $('#NoCuentaClave').val();
    var Referencia         = $('#Referencia').val();
    var Observaciones      = $('#Observaciones').val();

    if (signaturePad.isEmpty()) {
    var base64 = "";
    } else {
    var base64 = $('#base64').val();
    }

    var RS = $('#RazonSocial').val();

    if(RS == undefined){
    RazonSocial = "";
    }else{
    RazonSocial = RS; 
    }

    var data = new FormData(); 
    var url = '../../../../../public/admin/modelo/editar-solicitud-cheque.php';
 
    FacturaPresupuesto = document.getElementById("FacturaPresupuesto");
    FacturaPresupuesto_file = FacturaPresupuesto.files[0];
    FacturaPresupuesto_filePath = FacturaPresupuesto.value;

    PrefacturaPDF = document.getElementById("PrefacturaPDF");
    PrefacturaPDF_file = PrefacturaPDF.files[0];
    PrefacturaPDF_filePath = PrefacturaPDF.value;

    FacturaPDF = document.getElementById("FacturaPDF");
    FacturaPDF_file = FacturaPDF.files[0];
    FacturaPDF_filePath = FacturaPDF.value;

    FacturaXML = document.getElementById("FacturaXML");
    FacturaXML_file = FacturaXML.files[0];
    FacturaXML_filePath = FacturaXML.value;

    CaratulaB = document.getElementById("CaratulaB");
    CaratulaB_file = CaratulaB.files[0];
    CaratulaB_filePath = CaratulaB.value;

    ConstanciaS = document.getElementById("ConstanciaS");
    ConstanciaS_file = ConstanciaS.files[0];
    ConstanciaS_filePath = ConstanciaS.value;

    OrdenServicio = document.getElementById("OrdenServicio");
    OrdenServicio_file = OrdenServicio.files[0];
    OrdenServicio_filePath = OrdenServicio.value;

    OrdenCompra = document.getElementById("OrdenCompra");
    OrdenCompra_file = OrdenCompra.files[0];
    OrdenCompra_filePath = OrdenCompra.value;

    OrdenMantenimiento = document.getElementById("OrdenMantenimiento");
    OrdenMantenimiento_file = OrdenMantenimiento.files[0];
    OrdenMantenimiento_filePath = OrdenMantenimiento.value;

    PolizaGarantia = document.getElementById("PolizaGarantia");
    PolizaGarantia_file = PolizaGarantia.files[0];
    PolizaGarantia_filePath = PolizaGarantia.value;

    Prorrateo = document.getElementById("Prorrateo");
    Prorrateo_file = Prorrateo.files[0];
    Prorrateo_filePath = Prorrateo.value;

    ReembolsoCajaChica = document.getElementById("ReembolsoCajaChica");
    ReembolsoCajaChica_file = ReembolsoCajaChica.files[0];
    ReembolsoCajaChica_filePath = ReembolsoCajaChica.value;

    Cotizacion = document.getElementById("Cotizacion");
    Cotizacion_file = Cotizacion.files[0];
    Cotizacion_filePath = Cotizacion.value;

    NotaPDF = document.getElementById("NotaPDF");
    NotaPDF_file = NotaXML.files[0];
    NotaPDF_filePath = NotaXML.value;

    NotaXML = document.getElementById("NotaXML");
    NotaXML_file = NotaXML.files[0];
    NotaXML_filePath = NotaXML.value;

    Contrato = document.getElementById("Contrato");
    Contrato_file = Contrato.files[0];
    Contrato_filePath = Contrato.value;


    ComPDF = document.getElementById("ComPDF");
    ComPDF_file = ComPDF.files[0];
    ComPDF_filePath = ComPDF.value;

    ComXML = document.getElementById("ComXML");
    ComXML_file = ComXML.files[0];
    ComXML_filePath = ComXML.value;

  if(Fecha != ""){
  $('#Fecha').css('border',''); 
  if(Beneficiario != ""){
  $('#Beneficiario').css('border',''); 
  if(Monto != ""){
  $('#Monto').css('border',''); 
  if(NoFactura != ""){
  $('#NoFactura').css('border',''); 
  if(Correo != ""){
  $('#Correo').css('border',''); 
  if(Concepto != ""){
  $('#Concepto').css('border',''); 
  if(Solicitante != ""){
  $('#Solicitante').css('border',''); 
  if(Telefono != ""){
  $('#Telefono').css('border',''); 
  if(CFDI != ""){
  $('#CFDI').css('border',''); 
  if(Metodopago != ""){
  $('#Metodopago').css('border',''); 
  if(FormaPago != ""){
  $('#FormaPago').css('border',''); 
  if(Banco != ""){
  $('#Banco').css('border',''); 
  if(NoCuenta != ""){
  $('#NoCuenta').css('border',''); 
  if(NoCuentaClave != ""){
  $('#NoCuentaClave').css('border',''); 
  if(Referencia != ""){
  $('#Referencia').css('border',''); 

  if(signaturePad.isEmpty()){
  $('#canvas').css('border','2px solid #A52525'); 
  alertify.error('Falta ingresar la firma'); 
  }else{
  $('#canvas').css('border','1px solid #000000'); 
 

  data.append('IdReporte', IdReporte);
  data.append('Fecha', Fecha);
  data.append('RazonSocial', RazonSocial); 
  data.append('Beneficiario', Beneficiario);
  data.append('Monto', Monto);
  data.append('Moneda', Moneda);
  data.append('NoFactura', NoFactura);
  data.append('Correo', Correo);
  data.append('Concepto', Concepto);
  data.append('Solicitante', Solicitante);
  data.append('Telefono', Telefono);
  data.append('CFDI', CFDI);
  data.append('Metodopago', Metodopago);
  data.append('FormaPago', FormaPago);
  data.append('Banco', Banco);
  data.append('NoCuenta', NoCuenta);
  data.append('NoCuentaClave', NoCuentaClave);
  data.append('Referencia', Referencia);
  data.append('Observaciones', Observaciones);
  data.append('FacturaPresupuesto_file', FacturaPresupuesto_file);
  data.append('FacturaPDF_file', FacturaPDF_file);
  data.append('FacturaXML_file', FacturaXML_file);
  data.append('CaratulaB_file', CaratulaB_file);
  data.append('ConstanciaS_file', ConstanciaS_file);
  data.append('PrefacturaPDF_file', PrefacturaPDF_file);
  data.append('OrdenServicio_file', OrdenServicio_file);
  data.append('OrdenCompra_file', OrdenCompra_file);
  data.append('OrdenMantenimiento_file', OrdenMantenimiento_file);
  data.append('PolizaGarantia_file', PolizaGarantia_file);

  data.append('Prorrateo_file', Prorrateo_file);
  data.append('ReembolsoCajaChica_file', ReembolsoCajaChica_file);
  data.append('Cotizacion_file', Cotizacion_file);

  data.append('NotaPDF_file', NotaPDF_file);
  data.append('NotaXML_file', NotaXML_file);

  data.append('Contrato_file', Contrato_file);

  data.append('ComPDF_file', ComPDF_file);
  data.append('ComXML_file', ComXML_file);
  data.append('base64', base64);

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

  }
  
  }else{
  $('#Referencia').css('border','2px solid #A52525'); 
  }
  }else{
  $('#NoCuentaClave').css('border','2px solid #A52525'); 
  }
  }else{
  $('#NoCuenta').css('border','2px solid #A52525'); 
  }
  }else{
  $('#Banco').css('border','2px solid #A52525'); 
  }
  }else{
  $('#FormaPago').css('border','2px solid #A52525'); 
  }
  }else{
  $('#Metodopago').css('border','2px solid #A52525'); 
  }
  }else{
  $('#CFDI').css('border','2px solid #A52525'); 
  }
  }else{
  $('#Telefono').css('border','2px solid #A52525'); 
  }
  }else{
  $('#Solicitante').css('border','2px solid #A52525'); 
  }
  }else{
  $('#Concepto').css('border','2px solid #A52525'); 
  }
  }else{
  $('#Correo').css('border','2px solid #A52525'); 
  }
  }else{
  $('#NoFactura').css('border','2px solid #A52525'); 
  }
  }else{
  $('#Monto').css('border','2px solid #A52525'); 
  }
  }else{
  $('#Beneficiario').css('border','2px solid #A52525'); 
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
  <div class="container">
  <div class="cardAG">
  <div class="border-0 p-3">

  <div class="row">
 
  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i>
  Solicitud de cheques</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Editar Solicitud de Cheque</li>
  </ol>
  </div>
   
  <div class="row"> 
  <div class="col-12 mb-1"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Editar Solicitud de Cheque</h3> </div>
  </div>

  <hr>
  </div>


  <div class="col-12">  
  <div class="row">  

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary fw-bold">* FECHA:</div>
  <input type="date" class="form-control rounded-0" id="Fecha" value="<?=$fecha;?>"> 
  </div> 

  <?php if($Session_IDEstacion == 8){ ?>
  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary">RAZON SOCIAL:</div>
  <select class="form-select rounded-0" id="RazonSocial">
  <option><?=$razonsocial;?></option>
  <option>ADMINISTRADORA DE GASOLINERAS INTERLOMAS</option>
  <option>ADMINISTRADORA DE GASOLINERAS S.A. DE C.V.</option>
  <option>ADMINISTRADORA DE GASOLINERAS SAN AGUSTÍN S.A. DE C.V.</option>
  <option>GASOMIRA S.A. DE C.V.</option>
  <option>GASOLINERA VALLE DE GUADALUPE S.A. DE C.V.</option>
  <option>ADMINISTRADORA DE GASOLINERAS ESMEGAS S.A. DE C.V.</option>
  <option>ADMINISTRADORA DE GASOLINERAS XOCHIMILCO S.A. DE C.V.</option>
  <option>INMOBILIARIA PALO SOLO S.A. DE C.V.</option>
  <option>INMOBILIARIA VALLE DE HUIXQUILUCAN, S.A. DE C.V.</option>
  <option>ADMINISTRADORA DE GASOLINERIAS BOSQUE REAL S.A. DE C.V.</option>
  <option>BIENES RAÍCES SALTE, S.A. DE C.V.</option>
  <option>ARRENDATARIA DE COPOPRIEDADES LEO, S.A. DE C.V.</option>
  <option>INMOBILIARIA TOMASIN, S.A. DE C.V.</option>
  <option>OPERACIÓN SERVICIO Y MANTENIMIENTO DE PERSONAL S.A. DE C.V.</option>
  <option>FIDEICOMISO DE ADMINISTRACIÓN No. 2176/2016</option>
  <option>BANCA MIFEL, S.A., FIDEICOMISO 2176/2016</option>        
  <option>DE VILLASANTE HERBERT RODRIGO EMILIO, Y COPS.</option>
  <option>AURELIO QUINZAÑOS SUAREZ Y COPROPIETARIOS</option>
  <option>AURELIO QUINZAÑOS SUAREZ</option>
  </select>
  </div> 
  <?php } ?>

  <?php if($Session_IDEstacion == 14){ ?>
  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary">RAZON SOCIAL:</div>
  <select class="form-select rounded-0" id="Depto">
  <option><?=$razonsocial;?></option>
  <option value="23">BANCAMIFEL, SOCIEDAD ANÓNIMA, FIDEICOMISO 2176/2016</option>
  </select>
  </div> 
  <?php } ?>

  </div> 
  </div>   


  <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 mb-2">
  <div class="mb-1 text-secondary fw-bold">* NOMBRE DEL BENEFICIARIO:</div>
  <input type="text" class="form-control rounded-0" id="Beneficiario" value="<?=$beneficiario;?>">
  </div>

  <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 mb-2">
  <div class="mb-1 text-secondary fw-bold">* MONTO:</div>
  <input type="number" min="0" class="form-control rounded-0" id="Monto" value="<?=$monto;?>" >
  </div>

  <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 mb-2">
  <div class="mb-1 text-secondary">MONEDA:</div>
  <select class="form-select rounded-0" id="Moneda">
  <option><?=$moneda;?></option>
  <option>MXN</option>
  <option>USD</option>
  </select>
  </div>

       
  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary fw-bold">* FACTURA NO:</div>
  <input type="text" min="0" class="form-control rounded-0" id="NoFactura" value="<?=$nofactura;?>" >
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary fw-bold">* CORREO ELÉCTRONICO:</div>
  <input type="text" min="0" class="form-control rounded-0" id="Correo" value="<?=$email;?>" >
  </div>

  <div class="col-12 mb-2">  
  <div class="mb-1 text-secondary mt-2 fw-bold">* CONCEPTO:</div>
  <textarea class="form-control rounded-0" id="Concepto"><?=$concepto;?></textarea>
  </div>
   
  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary fw-bold">* NOMBRE DEL SOLICITANTE:</div>
  <input type="text" class="form-control rounded-0" id="Solicitante" value="<?=$solicitante;?>">
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary fw-bold">* TELÉFONO:</div>
  <input type="text" class="form-control rounded-0" id="Telefono" value="<?=$telefono;?>" >
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary">USO DEL CDFI:</div>
  <select class="form-select rounded-0" id="CFDI">
  <option value="<?=$cfdi;?>"><?=$cfdi;?></option>
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

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
  <div class="mb-1 text-secondary fw-bold">* MÉTODO DE PAGO:</div>
  <select class="form-select rounded-0" id="Metodopago">
  <option value="<?=$metodo_pago;?>"><?=$metodo_pago;?></option>
  <option>PUE Pago en una sola exhibición</option>
  <option>PPD Pago en parcialidades o diferido</option>
  </select>
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary fw-bold">* BANCO:</div>
  <input type="text" class="form-control rounded-0" id="Banco" value="<?=$banco;?>" >
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary fw-bold">* NO. DE CUENTA: </div>
  <input type="text" class="form-control rounded-0" id="NoCuenta" value="<?=$nocuenta;?>" >
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary fw-bold">* NO. DE CUENTA CLABE:</div>
  <input type="text" class="form-control rounded-0" id="NoCuentaClave" value="<?=$cuentaclabe;?>" >
  </div>
 
  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary fw-bold">*REFERENCIA/CONVENIO:</div>
  <input type="text" class="form-control rounded-0" id="Referencia" value="<?=$referencia;?>" >
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">      
  <div class="mb-1 text-secondary fw-bold">* FORMA DE PAGO:</div>
  <select class="form-select rounded-0" id="FormaPago">
  <option value="<?=$forma_pago;?>"><?=$forma_pago;?></option>
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

  <div class="col-12"><hr></div>
            
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-2">  
            <div class="mb-1 text-secondary mt-2">PRESUPUESTO:</div>
            <input type="file" class="form-control rounded-0" id="FacturaPresupuesto">
            </div>
          
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-2">  
            <div class="mb-1 text-secondary mt-2">PREFACTURA PDF:</div>
            <input type="file" class="form-control rounded-0" id="PrefacturaPDF">
            </div>
          
          
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-2">  
            <div class="mb-1 text-secondary mt-2">FACTURA PDF:</div>
            <input type="file" class="form-control rounded-0" id="FacturaPDF">
            </div>
          
          
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-2">  
            <div class="mb-1 text-secondary mt-2">FACTURA XML:</div>
            <input type="file" class="form-control rounded-0" id="FacturaXML">
            </div>
          
          
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-2">  
            <div class="mb-1 text-secondary mt-2">CARATULA BANCARIA</div>
            <input type="file" class="form-control rounded-0" id="CaratulaB">
            </div>
          
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-2">  
            <div class="mb-1 text-secondary mt-2">CONSTANCIA DE SITUACION</div>
            <input type="file" class="form-control rounded-0" id="ConstanciaS">
            </div>
          
          
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-2">  
            <div class="mb-1 text-secondary mt-2">ORDEN DE SERVICIO</div>
            <input type="file" class="form-control rounded-0" id="OrdenServicio">
            </div>
          
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-2">  
            <div class="mb-1 text-secondary mt-2">ORDEN DE COMPRA</div>
            <input type="file" class="form-control rounded-0" id="OrdenCompra">
            </div>
          
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-2">  
            <div class="mb-1 text-secondary mt-2">ORDEN DE MANTENIMIENTO</div>
            <input type="file" class="form-control rounded-0" id="OrdenMantenimiento">          
            </div>
          
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-2">  
            <div class="mb-1 text-secondary mt-2">PÓLIZA DE GARANTÍA</div>
            <input type="file" class="form-control rounded-0" id="PolizaGarantia"> 
            </div>
          
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-2">  
            <div class="mb-1 text-secondary mt-2">PRORRATEO</div>
            <input type="file" class="form-control rounded-0" id="Prorrateo"> 
            </div>
          
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-2">  
            <div class="mb-1 text-secondary mt-2">REEMBOLSO CAJA CHICA</div>
            <input type="file" class="form-control rounded-0" id="ReembolsoCajaChica"> 
            </div>
          
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-2">  
            <div class="mb-1 text-secondary mt-2">COTIZACIÓN</div>
            <input type="file" class="form-control rounded-0" id="Cotizacion"> 
            </div>
          
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-2">  
            <div class="mb-1 text-secondary mt-2">NOTA DE CREDITO PDF:</div>
            <input type="file" class="form-control rounded-0" id="NotaPDF"> 
            </div>
          
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-2">  
            <div class="mb-1 text-secondary mt-2">NOTA DE CREDITO XML:</div>
            <input type="file" class="form-control rounded-0" id="NotaXML"> 
            </div>
            
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-2">  
            <div class="mb-1 text-secondary mt-2">CONTRATO:</div>
            <input type="file" class="form-control rounded-0" id="Contrato"> 
            </div>
          
          
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-2"> 
            <div class="mb-1 text-secondary mt-2">COMPLEMENTO DE PAGO PDF:</div>
            <input type="file" class="form-control rounded-0" id="ComPDF">
            </div>
          
          
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-2"> 
            <div class="mb-1 text-secondary mt-2">COMPLEMENTO DE PAGO XML:</div>
            <input type="file" class="form-control rounded-0" id="ComXML">
            </div>
          
            <div class="col-12"><hr></div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="table-responsive">
  <table class="custom-table" style="font-size: 12.5px;" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">OBSERVACIONES:</th> </tr>
  </thead>
  <tbody>
  <tr class="no-hover">
  <th class="align-middle text-center bg-light p-0">  
  <textarea class="form-control rounded-0 bg-light border-0" id="Observaciones" style="height:190px" placeholder="Escribe aqui tu comentario..."><?=$observaciones;?></textarea>
  </th>
  </tr>
  </tbody>
  </table>
  </div>
  </div>
  
  <!---------- FIRMA ---------->
  <?php if($status == 0){ ?>
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">FIRMA DEL ENCARGADO</th> </tr>
  </thead>
  <tbody>
  <tr>
  <th class="align-middle text-center p-0 no-hover2">          
  <div id="signature-pad" class="signature-pad ">
  <div class="signature-pad--body ">
  <canvas style="width: 100%; height: 150px; border-right: .1px solid #215d98; border-left: .1px solid #215d98; cursor: crosshair;" id="canvas"></canvas>
  </div>
  <input type="hidden" name="base64" value="" id="base64">
  </div> 
  </th>
  </tr>

  <tr>
  <th class="align-middle text-center p-2 bg-danger text-white" onclick="resizeCanvas()">  
  <i class="fa-solid fa-arrow-rotate-left"></i> Limpiar firma        
  </th>
  </tr>

  </tbody>
  </table>
  </div>

  <div class="col-12">
  <hr>
  <button type="button" class="btn btn-labeled2 btn-success float-end" onclick="Guardar(<?=$GET_idReporte;?>)">
  <span class="btn-label2"><i class="fa fa-check"></i></span>Editar</button>
  </div>

  <?php } ?>

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
  <script src="<?=RUTA_JS2 ?>signature-pad-functions.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>


  </body>
  </html>
