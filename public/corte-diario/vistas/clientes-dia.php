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
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" ></script>
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>selectize.css">

  <style media="screen">
 
.tableFixHead{
  overflow-y: scroll;
}
.tableFixHead thead th{
  position: sticky;
  top: 0px;
  box-shadow: 2px 2px 7px #ECECEC;
}
  </style>


  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");

  $('.select').selectize({
  sortField: 'text'
  });
  
  var margint = -530;
  var ventana_alto = $(document).height();
  ResultAlto = ventana_alto - margint;
  box = document.getElementsByClassName('tableFixHead')[0];
  box.style.height = ResultAlto + 'px'; 

   ListaConsumoPago(<?=$GET_idReporte;?>);

  });

  function Regresar(){
   window.history.back();
  }

  function ListaConsumoPago(idReporte){
 $('#ConsumosPagos').load('../../../public/corte-diario/vistas/lista-consumo-pagos.php?idReporte=' + idReporte);
  } 
 
  function ClientesLista(year, mes, idDias){
   window.location.href = "../../../clientes-lista/" + year + "/" + mes + "/" + idDias;
  }

  function Agregar(){
  $('#Modal').modal('show');
  }

  function Guardar(idReporte){ 

  var agregar = 0;
  var data = new FormData();
  data.append('accion','agregar-pagos-cliente');
  var url = '../../../app/controlador/1-corporativo/controladorCorteDiario.php';
  //var url = '../../../public/corte-diario/modelo/agregar-pagos.php';

  var Cliente = $('#Cliente').val();
  var Total = $('#Total').val();
  var Tipo = $('#Tipo').val();
  var FormaPago = $('#FormaPago').val();

  Comprobante = document.getElementById("Comprobante");
  Comprobante_file = Comprobante.files[0];
  Comprobante_filePath = Comprobante.value;

  if (Cliente != "") {
  $('#BorderCliente').css('border','');
  if (Total != "") {
  $('#Total').css('border','');
  if (Tipo != "") {
  $('#Tipo').css('border','');

  if(Tipo == "Consumo"){
  AgregarConsumo(idReporte);
  }else if(Tipo == "Pago"){

  if (FormaPago != "") {
  $('#FormaPago').css('border','');

if (FormaPago == "Tarjeta") {

    if (Comprobante_filePath != "") {
    $('#Comprobante').css('border','');

    data.append('idReporte', idReporte);
    data.append('Cliente', Cliente);
    data.append('Tipo', Tipo);
    data.append('Total', Total);
    data.append('FormaPago', FormaPago);
    data.append('Comprobante_file', Comprobante_file);
    agregar = 1;

    }else{
    agregar = 0;
    $('#Comprobante').css('border','2px solid #A52525'); 
    }

}else if(FormaPago == "Transferencia"){
    
    data.append('idReporte', idReporte);
    data.append('Cliente', Cliente);
    data.append('Tipo', Tipo);
    data.append('Total', Total);
    data.append('FormaPago', FormaPago);
    data.append('Comprobante_file', Comprobante_file);
    agregar = 1;



}else{

    data.append('idReporte', idReporte);
    data.append('Cliente', Cliente);
    data.append('Tipo', Tipo);
    data.append('Total', Total);
    data.append('FormaPago', FormaPago);
    data.append('Comprobante_file', '');
    agregar = 1

}

 
  if (agregar == 1) {

    $.ajax({
    url: url,
    type: 'POST',
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(data){
    if (data == 1) {

    $('#Modal').modal('hide');

    var $select = $('#Cliente').selectize();
    var control = $select[0].selectize;
    //control.reload();

    $('#Total').val('');
    $('#Tipo').val('');
    $('#FormaPago').val('');
    $('#Cliente').val('');

    document.getElementById("DivFPago").style.display = "none";

    ListaConsumoPago(idReporte);
     alertify.success('Registro agregado exitosamente.')

    }else{
    alertify.error('Error al agregar')
    }

     });

  }



  }else{
  $('#FormaPago').css('border','2px solid #A52525');  
  }

  }

  }else{
  $('#Tipo').css('border','2px solid #A52525');
  }  
  }else{
  $('#Total').css('border','2px solid #A52525');
  }
  }else{
  $('#BorderCliente').css('border','2px solid #A52525');
  }

  }

  function AgregarConsumo(idReporte){

   var Cliente = $('#Cliente').val();
  var Total = $('#Total').val();
  var Tipo = $('#Tipo').val();

  var parametros = {
  "idReporte" : idReporte,
    "Cliente" : Cliente,
    "Total" : Total,
    "Tipo" : Tipo,
    "accion" : "agregar-consumos-cliente"
    };

           $.ajax({
     data:  parametros,
     url : '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
     //url:   '../../../public/corte-diario/modelo/agregar-consumos.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){
    
     },
     success:  function (response) {
    if (response == 1) {
    $('#Modal').modal('hide');
    
    var $select = $('#Cliente').selectize();
    var control = $select[0].selectize;
    control.clear();

    $('#Total').val('');
    $('#Tipo').val('');
    $('#FormaPago').val('');

    document.getElementById("DivFPago").style.display = "none";


    ListaConsumoPago(idReporte);    
    alertify.success('Registro agregado exitosamente.')

    }else{
    alertify.error('Error al agregar')
    }

     }
     });

  }
  //------------------------------------------------------------

  function Eliminar(idReporte,id){

var parametros = {
  "idReporte" : idReporte,
    "id" : id,
    "accion" : "eliminar-consumo-pago"
    };

       $.ajax({
     data:  parametros,
     url:'../../../app/controlador/1-corporativo/controladorCorteDiario.php',
     //url:   '../../../public/corte-diario/modelo/eliminar-consumos-pagos.php',
     type:  'post',
     beforeSend: function() {},
     complete: function(){},
     success:  function (response) {

      if (response == 1) {
      
   
    ListaConsumoPago(idReporte);
     alertify.success('Registro eliminado exitosamente.')

    }else{
    alertify.error('Error al eliminar')
    }

     }
     });

  }

  function VerTipoPago(val){

  var ConsumoPago = val.value;

  if (ConsumoPago == "Pago" || ConsumoPago == "Transferencia") {
  document.getElementById("DivFPago").style.display = "block";
  }else{
  document.getElementById("DivFPago").style.display = "none";
  }

  }

  function ValPago(val){

  var TipoPago = val.value;

  if (TipoPago == "Tarjeta" || TipoPago == "Transferencia") {
   document.getElementById("DivComprobante").style.display = "block";
  }else{
  document.getElementById("DivComprobante").style.display = "none";
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

    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-1">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">
    
    <h5>
    Clientes, <?=FormatoFecha($dia);?>
    </h5>

    </div>
    </div>

    </div>


    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
    <img class="float-end pointer ms-2" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="Agregar()">
    <img class="float-end pointer ms-2" src="<?=RUTA_IMG_ICONOS;?>clientes.png" onclick="ClientesLista(<?=$GET_year;?>,<?=$GET_mes;?>,<?=$GET_idReporte;?>)">
    </div>

</div>

  <hr>

  
  <div class="tableFixHead">
  <div id="ConsumosPagos"></div>
  </div>

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
        <h5 class="modal-title" >Consumos y Pagos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">  


<div class="mb-1">
  <small>* Selecciona el cliente</small>
</div>

<div id="BorderCliente">
  <select placeholder="Cliente" id="Cliente" class="select">
    <option value="">Cliente</option>
      <?php
     $sql_cliente = "SELECT * FROM op_cliente WHERE id_estacion = '".$Session_IDEstacion."' ";
     $result_cliente = mysqli_query($con, $sql_cliente);

    if($row_cliente['cliente'] == ""){
      $ocultar = "d-none";
    }else{
      $ocultar = "";
    }

     while($row_cliente = mysqli_fetch_array($result_cliente, MYSQLI_ASSOC)){
     echo '<option value="'.$row_cliente['id'].'">'.$row_cliente['cliente'].'</option>';
     }
      ?>
  </select>
</div>


  <div class="mt-2 mb-1"><small>* Agregue total</small></div>
  <input type="number" class="form-control rounded-0" min="0" placeholder="Total" id="Total">

  <div class="mb-1 mt-2"><small>* Selecciona Consumo o Pago</small></div>

  <select id="Tipo" class="form-select" onchange="VerTipoPago(this)">
    <option value="">Consumos o Pagos</option>
    <option>Consumo</option>
    <option>Pago</option>
  </select>


  <div id="DivFPago" style="display: none;">
  <hr>

  <div class="mb-1">
  <small>* Forma de pago</small>
  </div>
  <select id="FormaPago" class="form-select" onchange="ValPago(this)">
    <option value="">Forma de pago</option>
    <option>Efectivo</option>
    <option>Tarjeta</option>
    <option>Transferencia</option>
    <option>Cheque</option>
    <option>Monederos</option>

  </select>


  <div id="DivComprobante" style="display: none;">
  <div class="mb-1 mt-2"><small>* Voucher</small></div>
  <input class="form-control" type="file" id="Comprobante">
  </div>

  </div>

    
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-primary" onclick="Guardar(<?=$GET_idReporte;?>)">Guardar</button>
      </div>
    </div>
  </div>
</div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>

