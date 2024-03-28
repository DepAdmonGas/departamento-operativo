    <?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

$sql_lista_cl = "SELECT 
op_cuenta_litros.fecha,
op_cuenta_litros.estatus,
tb_estaciones.nombre

FROM op_cuenta_litros 
INNER JOIN tb_estaciones ON op_cuenta_litros.id_estacion = tb_estaciones.id

WHERE op_cuenta_litros.id_cuenta_litros = '".$GET_idCLitros."' ";


$result_lista_cl = mysqli_query($con, $sql_lista_cl);
$numero_lista_cl = mysqli_num_rows($result_lista_cl);
while($row_lista_cl = mysqli_fetch_array($result_lista_cl, MYSQLI_ASSOC)){
$fecha = $row_lista_cl['fecha']; 
$nombreES = $row_lista_cl['nombre']; 
$estatus = $row_lista_cl['estatus']; 
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
  tablasFormatoCL(<?=$GET_idCLitros?>)
  });

  function Regresar(){
  window.history.back();
  }
 

  function tablasFormatoCL(idCuentaLitros){
  $('#FormatoCuentaL').load('../public/admin/vistas/lista-cuenta-litros-detalle.php?idCuentaLitros=' + idCuentaLitros);
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
     <h5>Tabla de Descarga (Cuenta Litros) - <?=$nombreES?></h5>
    </div>

    </div>

    </div>
    </div>

  <hr>


  <div id="FormatoCuentaL"></div>

  </div>
  </div>
  </div>

  </div>
  </div>

  </div>



<div class="modal fade bd-example-modal-lg" id="ModalCL">
<div class="modal-dialog">
<div class="modal-content" style="margin-top: 83px;">
<div id="ContenidoModalCL"></div>
</div>
</div>
</div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
 