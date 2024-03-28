<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

   $sql_dia = "SELECT fecha FROM op_corte_dia WHERE id = '".$GET_idReporte."' ";
   $result_dia = mysqli_query($con, $sql_dia);
   while($row_dia = mysqli_fetch_array($result_dia, MYSQLI_ASSOC)){
   $dia = $row_dia['fecha'];
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
  
  ListaClientes(<?=$GET_idReporte;?>);
  });
 
  function Regresar(){
   window.history.back();
  } 

  function ListaClientes(idReporte){
    $('#ListaClientes').load('../../../../public/admin/vistas/lista-clientes.php?idReporte=' + idReporte);
  }
 
  function Agregar(){
  $('#Modal').modal('show');
  }

  function Guardar(){

  var Cuenta = $('#Cuenta').val();
  var Cliente = $('#Cliente').val();
  var Tipo = $('#Tipo').val();
  var RFC = $('#RFC').val();

  CartaCredito = document.getElementById("CartaCredito");
  CartaCredito_file = CartaCredito.files[0];
  CartaCredito_filePath = CartaCredito.value;

  ActaConstitutiva = document.getElementById("ActaConstitutiva");
  ActaConstitutiva_file = ActaConstitutiva.files[0];
  ActaConstitutiva_filePath = ActaConstitutiva.value;

  ComprobanteDom = document.getElementById("ComprobanteDom");
  ComprobanteDom_file = ComprobanteDom.files[0];
  ComprobanteDom_filePath = ComprobanteDom.value;

  Identificacion = document.getElementById("Identificacion");
  Identificacion_file = Identificacion.files[0];
  Identificacion_filePath = Identificacion.value;

  var data = new FormData();
  var url = '../../../../public/admin/modelo/agregar-cliente.php';

  if (Tipo != "") {
  $('#Tipo').css('border','');

  data.append('idReporte',<?=$GET_idReporte;?>);
  data.append('Cuenta', Cuenta);
  data.append('Cliente', Cliente);
  data.append('Tipo', Tipo);
  data.append('RFC', RFC);
  data.append('CartaCredito_file', CartaCredito_file);
  data.append('ActaConstitutiva_file', ActaConstitutiva_file);
  data.append('ComprobanteDom_file', ComprobanteDom_file);
  data.append('Identificacion_file', Identificacion_file);
  
    $.ajax({
    url: url,
    type: 'POST',
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(response){

    if (response == 1) {
    $('#Modal').modal('hide');
    ListaClientes(<?=$GET_idReporte;?>);

    $('#Cuenta').val('');
    $('#Cliente').val('');
    $('#Tipo').val('');

    }else{
    alertify.error('Error al agregar cliente')
    }

    });

  }else{
  $('#Tipo').css('border','2px solid #A52525');
  }

  }

    function Editar(id){
  $('#ModalEditar').modal('show');
   $('#ModalEditarCliente').load('../../../../public/admin/vistas/modal-editar-cliente.php?idCliente=' + id);
  }  
 
  function EditarCliente(idCliente){
 
  var Cuenta = $('#EditCuenta').val();
  var Cliente = $('#EditCliente').val();
  var Tipo = $('#EditTipo').val();
  var RFC = $('#EditRFC').val();


  CartaCredito = document.getElementById("EditCartaCredito");
  CartaCredito_file = CartaCredito.files[0];
  CartaCredito_filePath = CartaCredito.value;

  ActaConstitutiva = document.getElementById("EditActaConstitutiva");
  ActaConstitutiva_file = ActaConstitutiva.files[0];
  ActaConstitutiva_filePath = ActaConstitutiva.value;

  ComprobanteDom = document.getElementById("EditComprobanteDom");
  ComprobanteDom_file = ComprobanteDom.files[0];
  ComprobanteDom_filePath = ComprobanteDom.value;

  Identificacion = document.getElementById("EditIdentificacion");
  Identificacion_file = Identificacion.files[0];
  Identificacion_filePath = Identificacion.value;

  var data = new FormData();
  var url = '../../../../public/admin/modelo/editar-cliente.php';

  data.append('idCliente', idCliente);
  data.append('Cuenta',  Cuenta);
  data.append('Cliente', Cliente);
  data.append('Tipo', Tipo);
  data.append('RFC', RFC);
  data.append('CartaCredito_file', CartaCredito_file);
  data.append('ActaConstitutiva_file', ActaConstitutiva_file);
  data.append('ComprobanteDom_file', ComprobanteDom_file);
  data.append('Identificacion_file', Identificacion_file);

 
    $.ajax({
    url: url,
    type: 'POST',
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(response){

    if (response == 1) {
    $('#ModalEditar').modal('hide');
    ListaClientes(<?=$GET_idReporte;?>);
    alertify.success('Registro editado exitosamente.')

    $('#EditCuenta').val('');
    $('#EditCliente').val('');
    $('#EditTipo').val('');
    $('#EditRFC').val('');

    }else{
    alertify.error('Error al editar cliente')
    }

    });

  }

  function SelCredito(valor){

  var valor = valor.value;
  var SelCredito = document.getElementById("SelCredito");

if(valor == "Crédito"){
SelCredito.style.display = "block";
}else{
SelCredito.style.display = "none"; 
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

    <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    <div class="row">

     <div class="col-12">

      <h5>
      Lista Clientes
      </h5>

    </div>

    </div>

    </div>


    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12">
    <img class="float-end pointer" src="<?=RUTA_IMG_ICONOS;?>agregar.png" class="ml-2" onclick="Agregar()">
    </div>

    </div>

  <hr>

   <div id="ListaClientes"></div>


  </div>
  </div>
  </div>

  </div>
  </div>

  </div>


  <div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="margin-top: 83px;">
      <div class="modal-header">
        <h5 class="modal-title" >Crear Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">  

        <label class="text-secondary">* Cuenta</label>
        <textarea class="form-control rounded-0" id="Cuenta"></textarea>

        <label class="text-secondary mt-2 mb-1">* Cliente</label>
        <textarea class="form-control rounded-0" id="Cliente"></textarea>

        <label class="text-secondary mt-2 mb-1">* Tipo</label>
        <select class="form-select rounded-0" id="Tipo" onchange="SelCredito(this)">
          <option value="">Selecciona una opción...</option>
          <option value="Crédito">Crédito</option>
          <option value="Débito">Débito</option>
        </select>

        <div id="SelCredito" style="display: none;">
        <hr>
        <label class="text-secondary mb-1">Carta de crédito</label>
        <input class="form-control" type="file" id="CartaCredito">

        <label class="text-secondary mt-2 mb-1">Acta constitutiva</label>
        <div><input class="form-control" type="file" id="ActaConstitutiva"></div>

        <label class="text-secondary mt-2 mb-1">RFC</label>
        <input class="form-control" type="text" class="form-control rounded-0" id="RFC">

        <label class="text-secondary mt-2 mb-1">Comprobante de domicilio</label>
        <div><input class="form-control" type="file" id="ComprobanteDom"></div>

        <label class="text-secondary mt-2 mb-1">Identificación</label>
        <div><input class="form-control" type="file" id="Identificacion"></div>
        </div>
    
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-primary" onclick="Guardar(<?=$GET_idReporte;?>)">Guardar</button>
      </div>
    </div>
  </div>
</div>

  <div class="modal fade" id="ModalEditar" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="margin-top: 83px;">
      <div id="ModalEditarCliente"></div>
    </div>
  </div>
</div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>

