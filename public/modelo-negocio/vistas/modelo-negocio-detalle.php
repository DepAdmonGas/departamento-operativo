 <?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

$sql_lista = "SELECT * FROM op_modelo_negocio WHERE id = '".$GET_idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista); 
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){ 
$Titulo = $row_lista['titulo']; 
$Descripcion = $row_lista['descripcion'];
}

$sql_documento = "SELECT * FROM op_modelo_negocio_documento WHERE id_modelo_negocio = '".$GET_idReporte."' ";
$result_documento = mysqli_query($con, $sql_documento);
$numero_documento = mysqli_num_rows($result_documento);

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
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  ModeloNegocioVB(<?=$GET_idReporte;?>);
  });

  function Regresar(){
  window.history.back();
  }

  function ModeloNegocioVB(idReporte){
  $('#CotenidoVB').load('../public/modelo-negocio/vistas/modelo-negocio-vb.php?idReporte=' + idReporte); 
  } 

  function CrearToken(idReporte){

  $(".LoaderPage").show();

    var parametros = {
    "idReporte" : idReporte
    };

    $.ajax({
    data:  parametros,
    url:   '../public/modelo-negocio/modelo/token-modelo-negocio.php',
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

  function CrearTokenEmail(idReporte){
      $(".LoaderPage").show();

    var parametros = {
    "idReporte" : idReporte
    };

    $.ajax({
    data:  parametros,
    url:   '../public/modelo-negocio/modelo/token-email-modelo-negocio.php',
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

  function Firmar(idReporte){

  var TokenValidacion = $('#TokenValidacion').val();

    var parametros = {
    "idReporte" : idReporte,
    "TokenValidacion" : TokenValidacion
    };

  if(TokenValidacion != ""){
  $('#TokenValidacion').css('border',''); 

    $(".LoaderPage").show();

      $.ajax({
    data:  parametros,
    url:   '../public/modelo-negocio/modelo/firmar-modelo-negocio.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    $(".LoaderPage").hide();

    if(response == 1){

    alertify.message('El Modelo de negocio fue firmado'); 
    ModeloNegocioVB(idReporte);  

    }else{
     alertify.error('Error al firmar el Modelo de negocio');
    }

    }
    });

  }else{
  $('#TokenValidacion').css('border','2px solid #A52525'); 
  }

  }

   function GuardarComentario(idReporte){

    var Comentario = $('#Comentario').val();

    var parametros = {
    "idReporte" : idReporte,
    "Comentario" : Comentario
    };

    if(Comentario != ""){
    $('#Comentario').css('border',''); 

    $.ajax({
    data:  parametros,
    url:   '../public/modelo-negocio/modelo/comentario-modelo-negocio.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    $('#Comentario').val('');
    
     alertify.success('Comentario agregado exitosamente');
      ModeloNegocioVB(idReporte);

    }else{
     alertify.error('Error al agregar comentario');  
    }

    }
    });

    }else{
    $('#Comentario').css('border','2px solid #A52525'); 
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

     <h5>Modelo de negocio </h5>
    
    </div>
    </div>

    </div>



    </div>

<hr>

<div class="row">

<div class="col-12 col-sm-5 mb-3">
<div class="p-3 border">
<div class="text-secondary"><small>Titulo:</small></div>
<h5><?=$Titulo;?></h5>

<div class="text-secondary mt-2"><small>Descripción:</small></div>
<h6><?=$Descripcion;?></h6>

<div class="text-secondary mt-3"><small>Documentos:</small></div>

<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0 mt-2" style="font-size: .8em;">
<thead class="tables-bg">
<tr>
<th class="align-middle">Nombre del archivo</th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
</tr>
</thead>
<tbody>
<?php
if ($numero_documento > 0) {
while($row_documento = mysqli_fetch_array($result_documento, MYSQLI_ASSOC)){

$id = $row_documento['id'];

echo '<tr>';
echo '<td class="align-middle font-weight-light">'.$row_documento['nombre'].'</td>';
echo '<td class="align-middle font-weight-light"><a href="../archivos/modelo-negocio/'.$row_documento['archivo'].'" download><img src="'.RUTA_IMG_ICONOS.'pdf.png"></a></td>';
echo '</tr>';

}
}else{
echo "<tr><td colspan='3' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>

</div>
</div>


<div class="col-12 col-sm-7">
<div id="CotenidoVB"></div>
</div>

</div>
 
  </div>
  </div>
  </div>

  </div>
  </div>

  </div>


    <div class="modal" id="Modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="margin-top: 83px;">
      <div id="ModalContenido"></div>
      </div>
    </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>


  </body>
  </html>
           