<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

function Firma($idReporte,$detalle,$rutafirma,$con){
 
$sql_firma = "SELECT 
op_corte_dia_firmas.id AS idFirma,
op_corte_dia_firmas.id_usuario, 
op_corte_dia_firmas.firma,
op_corte_dia_firmas.fecha,
tb_usuarios.nombre
FROM op_corte_dia_firmas
INNER JOIN tb_usuarios
ON op_corte_dia_firmas.id_usuario = tb_usuarios.id WHERE id_reportedia  = '".$idReporte."' AND detalle = '".$detalle."' ORDER BY idFirma DESC LIMIT 1 ";
   $result_firma = mysqli_query($con, $sql_firma);
   while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){
   $idFirma = $row_firma['idFirma'];
   $nombre = $row_firma['nombre'];
   $firma = $row_firma['firma'];
   $explode = explode(' ', $row_firma['fecha']);
   }

   if($detalle == "Elaboró"){

   $contenido .= '<div class="text-center mt-1">';
   $contenido .= '<img src="'.$rutafirma.$firma.'" width="150px" height="70px">';
   $contenido .= '<div class="text-center mt-1 border-top pt-2"><b>'.$nombre.'</b></div>';
   $contenido .= '</div>';

   }else if($detalle == "Superviso" || $detalle == "VoBo"){
    
    $Detalle = '<div class="border-bottom text-center p-3" style="font-size: 0.95em;"><small>El formato se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';


    $contenido .= '<div class="">';
    $contenido .= $Detalle;
    $contenido .= '<div class="mb-1 text-center pt-2"><b>'.$nombre.'</b></div>';
    $contenido .= '</div>';

 
   }

   return $contenido;

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

  Ventas(<?=$GET_idReporte;?>);
  AceitesLubricantes(<?=$GET_idReporte;?>);
  Prosegur(<?=$GET_idReporte;?>);
  TarjetasBancarias(<?=$GET_idReporte;?>);
  ClientesControlgas(<?=$GET_idReporte;?>);
  PagoCliente(<?=$GET_idReporte;?>);
  DifPagoCliente(<?=$GET_idReporte;?>);
  DiferenciaTotal(<?=$GET_idReporte;?>);
  Total1234(<?=$GET_idReporte;?>);

  ListaDocumentos(<?=$GET_idReporte;?>);
  
  });

  function Regresar(){
   window.history.back();
  }

  function Ventas(idReporte){
  $('#DivConecntradoVentas').html('<div class="text-center"><img width="30px" src="../../../../imgs/iconos/load-img.gif"></div>');
  $('#DivConecntradoVentas').load('../../../../public/admin/vistas/concentrado-ventas.php?idReporte=' + idReporte);
  } 
 
  function AceitesLubricantes(idReporte){
  $('#DivAceitesLubricantes').html('<div class="text-center"><img width="30px" src="../../../imgs/iconos/load-img.gif"></div>');
    $('#DivAceitesLubricantes').load('../../../../public/admin/vistas/venta-aceites-lubricantes.php?idReporte=' + idReporte);    
  }
 
    function Prosegur(idReporte){
    $('#DivProsegur').html('<div class="text-center"><img width="30px" src="../../../../imgs/iconos/load-img.gif"></div>');
    $('#DivProsegur').load('../../../../public/admin/vistas/prosegur.php?idReporte=' + idReporte);    
  } 

    function TarjetasBancarias(idReporte){
    $('#DivTarjetasBancarias').html('<div class="text-center"><img width="30px" src="../../../../imgs/iconos/load-img.gif"></div>');
    $('#DivTarjetasBancarias').load('../../../../public/admin/vistas/tarjetas-bancarias.php?idReporte=' + idReporte); 
  } 

    function ClientesControlgas(idReporte){
    $('#DivControlgas').html('<div class="text-center"><img width="30px" src="../../../../imgs/iconos/load-img.gif"></div>');
    $('#DivControlgas').load('../../../../public/admin/vistas/clientes-controlgas.php?idReporte=' + idReporte);  
  }

    function PagoCliente(idReporte){
    $('#DivPagoClientes').html('<div class="text-center"><img width="30px" src="../../../../imgs/iconos/load-img.gif"></div>');
    $('#DivPagoClientes').load('../../../../public/admin/vistas/pago-clientes.php?idReporte=' + idReporte); 
  }
 
  function DifPagoCliente(idReporte){

  $('#DifPagoCliente').load('../../../../public/corte-diario/vistas/diferencia-pagocliente-total.php?idReporte=' + idReporte);
}

function DiferenciaTotal(idReporte){

  $('#DiferenciaTotal').load('../../../../public/corte-diario/vistas/diferencia-total.php?idReporte=' + idReporte);
} 

function Total1234(idReporte){
  $('#Total1234').load('../../../../public/corte-diario/vistas/totales-1234.php?idReporte=' + idReporte);
}

  function PDF(idReporte){

  window.location = "../../../../public/corte-diario/vistas/pdf-corte-ventas.php?idReporte=" + idReporte;

  }

  function ListaDocumentos(idReporte){
  $('#Documentos').load('../../../../public/admin/vistas/lista-documentos.php?idReporte=' + idReporte);   
  }

  function FirmarCorte(idReporte){


  var ctx = document.getElementById("canvas");
  var image = ctx.toDataURL();
  document.getElementById('base64').value = image;

  var base64 = $('#base64').val();
  

   var parametros = {
    "base64" : base64,
    "idReporte" : idReporte
    };

       $.ajax({
     data:  parametros,
     url:   '../../../../public/admin/modelo/agregar-firma.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){
    
     },
     success:  function (response) {

    if (response == 1) {
    location.reload();
    }else{
    alertify.error('Error al firmar el corte')
    }

     }
     });


  
   }


     function CrearToken(idReporte){
    $(".LoaderPage").show();

    var parametros = {
    "idReporte" : idReporte
    };

    $.ajax({
    data:  parametros,
    url:   '../../../../public/admin/modelo/token-ccorte-diario.php',
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

    function FirmarFormato(idReporte,tipoFirma){

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
    url:   '../../../../public/admin/modelo/firmar-corte-diario.php',
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

  </script>
  </head>
 
  <body>
  <div class="LoaderPage"></div>


    <?php 

   $sql_dia = "SELECT id_mes,fecha FROM op_corte_dia WHERE id = '".$GET_idReporte."' ";
   $result_dia = mysqli_query($con, $sql_dia);
   while($row_dia = mysqli_fetch_array($result_dia, MYSQLI_ASSOC)){
   $idmes = $row_dia['id_mes'];
   $dia = $row_dia['fecha'];
   }

  ?>

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
     <?=FormatoFecha($dia);?>
      </h5>

    </div>

    </div>

    </div>


    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12">
    <img class="float-end pointer" src="<?=RUTA_IMG_ICONOS;?>pdf.png" onclick="PDF(<?=$GET_idReporte;?>)">
    </div>

    </div>

  <hr>

    <div class="row">

<!---------- TABLA - CONCENTRADO DE VENTAS ---------->
      
      <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 mb-3">
      <div class="border mt-2">
      <div class="bg-light p-2 text-center">
        <strong>CONCENTRADO DE VENTAS</strong> 
      </div>

      <div class="p-2">
      <div id="DivConecntradoVentas" ></div> 
      </div>

      </div>


      <div class="border mt-3">
      <div class="bg-light p-2 text-center">
      <strong>RELACION DE VENTA DE ACEITES Y LUBRICANTES</strong>
      </div>

      <div class="p-2">
      <div id="DivAceitesLubricantes"></div>
      </div>
      
     </div>    

    <div class="border mt-3">
      <div class="p-2">

      <div id="Documentos"></div>         

      </div>

      </div>

      </div>



      <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mt-2">

   
        <div class="border">
          
          <div class="bg-light p-2 text-center">
            <strong>PROSEGUR</strong>
          </div>

        <div class="p-2">
            <div id="DivProsegur"></div>
        </div>

        </div>

        <div class="border mt-3">          
           <div class="bg-light p-2 text-center">
            <strong>MONEDEROS Y BANCOS</strong>
            </div>

            <div class="p-2">
            <div id="DivTarjetasBancarias"></div> 
            </div>

        </div>

        <hr>
        <div class="border mt-3">          
          <div class="bg-light p-2 text-center">
            <strong>CLIENTES (ATIO)</strong>
          </div>

          <div class="p-2">
          <div id="DivControlgas"></div> 
          </div>

        </div>

<div class="table-responsive" >
        <table class="table table-sm table-bordered pb-0 mb-0 mt-2">
          <tr>
            <td>C TOTAL (1+2+3)</td>
            <td class="bg-light align-middle text-end" id="Total1234"></td>
          </tr>
        </table>
</div>


<div class="table-responsive" >
        <table class="table table-sm table-bordered pb-0 mb-0 mt-2">
          <tr>
            <td><strong>DIFERENCIA (B-C)</strong></td>
            <td class="bg-light align-middle text-end" id="DiferenciaTotal"></td>
          </tr>
        </table>
</div>


        <div class="border mt-3">
          <div class="bg-light p-2 text-center">
            <strong>PAGO DE CLIENTES</strong>
            </div>

            <div class="p-2">
            <div id="DivPagoClientes" ></div>  
            </div> 

        </div>

<div class="table-responsive" >
        <table class="table table-sm table-bordered pb-0 mb-0 mt-2">
          <tr>
            <td>DIF PAGO DE CLIENTES</td>
            <td class="bg-light align-middle text-end" id="DifPagoCliente"></td>
            <td>(4-5)</td>
          </tr>
        </table>
</div>
        
        <hr>

       <div class="border mt-3">          
          <div class="bg-light p-2 text-center">
            <strong>OBSERVACIONES:</strong>            
           </div> 
            <?php 

            $sql_observaciones = "SELECT * FROM op_observaciones WHERE idreporte_dia = '".$GET_idReporte."' ";
            $result_observaciones = mysqli_query($con, $sql_observaciones);
            while($row_observaciones = mysqli_fetch_array($result_observaciones, MYSQLI_ASSOC)){

            $observaciones = $row_observaciones['observaciones'];

             }

             ?>
             <div class="p-2"><?=$observaciones;?></div>
            
        </div>

      </div>


    </div>

    <hr>


    <?php 

function ValidaFirma($idReporte,$detalle,$con){

$sql_firma = "SELECT 
op_corte_dia_firmas.id_usuario, 
op_corte_dia_firmas.firma,
tb_usuarios.nombre
FROM op_corte_dia_firmas
INNER JOIN tb_usuarios
ON op_corte_dia_firmas.id_usuario = tb_usuarios.id WHERE id_reportedia  = '".$idReporte."' AND detalle = '".$detalle."' ";
   $result_firma = mysqli_query($con, $sql_firma);
   $numero_lista = mysqli_num_rows($result_firma);

return $numero_lista;
}

$Elaboro = ValidaFirma($GET_idReporte,'Elaboró',$con);
$Superviso = ValidaFirma($GET_idReporte,'Superviso',$con);
$VoBo = ValidaFirma($GET_idReporte,'VoBo',$con);
 ?>

<div class="row">
<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
<div class="border p-3">
<div class="text-center font-weight-bold">ELABORÓ</div>
<hr>
<?php 
if($Elaboro > 0){
$RElaboro = Firma($GET_idReporte,'Elaboró',RUTA_IMG_Firma,$con);
echo $RElaboro;
}else{
echo '<div class=" col-12 text-center mb-3">';
echo '<div class="p-2"><small>No se encontró firma del corte diario</small></div>';
echo '<div class="text-center mt-1 border-top "></div>';
echo '</div>'; 
}
?>
</div>
</div>

<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
<div class="border p-3">
<?php 
if($Superviso > 0){
echo '<div class="text-center font-weight-bold">SUPERVISO</div>';
echo '<hr>';
$RSuperviso = Firma($GET_idReporte,'Superviso',RUTA_IMG_Firma,$con);
echo $RSuperviso;
}else{
if($Session_IDUsuarioBD == 19){
?>
  <div class="text-center font-weight-bold">SUPERVISO</div>
  <hr>
  <h4 class="text-primary text-center">Token Móvil</h4>
  <small class="text-secondary">Agregue el token enviado a su número de teléfono o de clic en el siguiente botón para crear uno</small>
  <button class="btn btn-sm mt-2" onclick="CrearToken(<?=$GET_idReporte;?>)"><small>Crear nuevo token</small></button>
  <hr>

  <div class="input-group mt-3">
    <input type="text" class="form-control" placeholder="Token de seguridad" aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
    <div class="input-group-append">
      <button class="btn btn-outline-secondary" type="button" onclick="FirmarFormato(<?=$GET_idReporte;?>,'Superviso')">Firmar corte diario</button>
    </div>
  </div>

<?php 

}else{

echo '<div class="col-12 mb-3"><div class="alert alert-warning text-center" role="alert">
  ¡Falta la Firma de supervisión!
</div></div>'; 
}
}
?>
</div>
</div>


<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">

<?php 
if($VoBo > 0){
echo '<div class="border p-3">';

echo '<div class="text-center font-weight-bold">VO.BO.</div>';
echo '<hr>';

$RVoBo = Firma($GET_idReporte,'VoBo',RUTA_IMG_Firma,$con);
echo $RVoBo;
}else{
if($Session_IDUsuarioBD == 2){
?>
  <div class="border p-3 mt-3">
  <div class="mb-2 text-secondary text-center">VO.BO.</div>
  <hr>
  <h4 class="text-primary">Token Móvil</h4>
  <small class="text-secondary">Agregue el token enviado a su número de teléfono o de clic en el siguiente botón para crear uno</small>
  <button class="btn btn-sm" onclick="CrearToken(<?=$GET_idReporte;?>)"><small>Crear nuevo token</small></button>

  <div class="input-group mt-3">
    <input type="text" class="form-control" placeholder="Token de seguridad" aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
    <div class="input-group-append">
      <button class="btn btn-outline-secondary" type="button" onclick="FirmarFormato(<?=$GET_idReporte;?>,'VoBo')">Firmar corte diario</button>
    </div>
  </div>
  </div>


<?php 
}else{
echo '<div class="col-12 mb-3"><div class="alert alert-warning text-center" role="alert">
  ¡Falta la Firma de VOBO!
</div></div></div>'; 
}
}
?>

</div>
</div>

 

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
       <div class="text-secondary">El corte diario fue firmado.</div>


      <div class="text-end">
        <button type="button" class="btn btn-primary" onclick="location.reload();">Aceptar</button>
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
       <div class="text-secondary">El corte diario no fue firmado.</div>


      <div class="text-end">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
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

