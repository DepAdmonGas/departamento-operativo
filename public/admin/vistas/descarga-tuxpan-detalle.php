<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

function Estacion($idEstacion,$con){
$sql = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$estacion = $row['nombre'];
}
return $estacion;
}

function Personal($idPersonal,$con){
$sql = "SELECT nombre FROM tb_usuarios WHERE id = '".$idPersonal."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
}

$sql_lista = "SELECT * FROM op_descarga_tuxpa WHERE id = '".$GET_idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$folio = $row_lista['folio'];
$Estacion = Estacion($row_lista['id_estacion'],$con);
$fechallegada = FormatoFecha($row_lista['fecha_llegada']);
$horallegada = date("g:i a",strtotime($row_lista['hora_llegada'])); 
$Personal = Personal($row_lista['id_usuario'],$con);
$producto = $row_lista['producto'];
$sellos = $row_lista['sellos'];
$detuvoventa = $row_lista['detuvo_venta'];
$operador = $row_lista['operador'];
$transportista = $row_lista['transportista'];

$nofactura = $row_lista['no_factura'];
$inventarioinicial = $row_lista['inventario_inicial'];
$nice = $row_lista['nice'];
$inventariofinal = $row_lista['inventario_final'];
$metrocontador = $row_lista['metro_contador'];
$metrocontador20 = $row_lista['metro_contador20'];

$nofacturaremision = $row_lista['no_factura_remision'];
$litros = $row_lista['litros'];
$preciolitro = $row_lista['precio_litro'];
$unidad = $row_lista['unidad'];
$cuentalitros = $row_lista['cuenta_litros'];

$valortolerancia = $litros * .55 / 100;
$tolerancia = round($valortolerancia);

$merma = $litros - $cuentalitros;

$calculaNC = $merma - $tolerancia;

$NC = number_format($calculaNC * $preciolitro,2);

$extensionFactura = pathinfo($nofactura, PATHINFO_EXTENSION);
$extensionInvInicial = pathinfo($inventarioinicial, PATHINFO_EXTENSION);
$extensionNice = pathinfo($nice, PATHINFO_EXTENSION);
$extensionInvFinal = pathinfo($inventariofinal, PATHINFO_EXTENSION);
$extensionmetrocontador = pathinfo($metrocontador, PATHINFO_EXTENSION);
$extensionmetrocontador20 = pathinfo($metrocontador20, PATHINFO_EXTENSION);

 

if($extensionFactura == "pdf"){
$facturaElement = '<iframe class="border-0 mt-0 mb-0" src="'.RUTA_ARCHIVOS.'tuxpan/'.$nofactura.'" width="100%" height="400px"></iframe>';
}else{
$facturaElement = '<img src="'.RUTA_ARCHIVOS.'tuxpan/'.$nofactura.'" width="100%">';
}

if($extensionInvInicial == "pdf"){
$invInicialElement = '<iframe class="border-0 mt-0 mb-0" src="'.RUTA_ARCHIVOS.'tuxpan/'.$inventarioinicial.'" width="100%" height="400px"></iframe>';
}else{
$invInicialElement = '<img src="'.RUTA_ARCHIVOS.'tuxpan/'.$inventarioinicial.'" width="100%">';
}

if($extensionNice == "pdf"){
$niceElement = '<iframe class="border-0 mt-0 mb-0" src="'.RUTA_ARCHIVOS.'tuxpan/'.$nice.'" width="100%" height="400px"></iframe>';
}else{
$niceElement = '<img src="'.RUTA_ARCHIVOS.'tuxpan/'.$nice.'" width="100%">';
}

if($extensionInvInicial == "pdf"){
$invFinalElement = '<iframe class="border-0 mt-0 mb-0" src="'.RUTA_ARCHIVOS.'tuxpan/'.$inventariofinal.'" width="100%" height="400px"></iframe>';
}else{
$invFinalElement = '<img src="'.RUTA_ARCHIVOS.'tuxpan/'.$inventariofinal.'" width="100%">';
}


if($extensionmetrocontador == "pdf"){
$metroElement = '<iframe class="border-0 mt-0 mb-0" src="'.RUTA_ARCHIVOS.'tuxpan/'.$metrocontador.'" width="100%" height="400px"></iframe>';
}else{
$metroElement = '<img src="'.RUTA_ARCHIVOS.'tuxpan/'.$metrocontador.'" width="100%">';
}

if($extensionmetrocontador20 == "pdf"){
$metro20Element = '<iframe class="border-0 mt-0 mb-0" src="'.RUTA_ARCHIVOS.'tuxpan/'.$metrocontador20.'" width="100%" height="400px"></iframe>';
}else{
$metro20Element = '<img src="'.RUTA_ARCHIVOS.'tuxpan/'.$metrocontador20.'" width="100%">';
}

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
 
  <style media="screen">
  .titulos{
    font-size: 1.2em;
  }
  </style>

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  });

  function Regresar(){
  window.location.href = "../descarga-tuxpan";
  }

  function EditarDM(idReporte){
       window.location.href = "../descarga-tuxpan-editar/" + idReporte;  
  }
 

  function Eliminar(idReporte){


    var parametros = {
    "idReporte" : idReporte
    };


alertify.confirm('',
 function(){

    $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/eliminar-descarta-tuxpan.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    Regresar();
    }else{
     alertify.error('Error al eliminar la descarga');  
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();


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
    <div class="col-9">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">

     <h5>Detalle formato de descarga merma</h5>
    
    </div>
    </div>

    </div>

    <div class="col-3">
    <img class="float-end pointer ms-2" src="<?=RUTA_IMG_ICONOS;?>eliminar.png" onclick="Eliminar(<?=$GET_idReporte;?>)">
    <img class="float-end pointer ms-2" src="<?=RUTA_IMG_ICONOS;?>editar-tb.png" onclick="EditarDM(<?=$GET_idReporte;?>)">

    </div>


    </div>

  <hr> 

<div class="row">
<div class="col-12 col-sm-4 mb-3">
<div class="border p-2">
<div class="text-secondary titulos">Folio:</div>
<div class="font-weight-bold titulos">00<?=$folio;?></div>
</div>
</div>

<div class="col-12 col-sm-4 mb-3">
<div class="border p-2">
<div class="text-secondary titulos">Estación de descarga:</div>
<div class="titulos"><?=$Estacion;?></div>
</div>
</div>

<div class="col-12 col-sm-4 mb-3">
<div class="border p-2">
<div class="text-secondary titulos">Responsable de la estación:</div>
<div class="titulos"><?=$Personal;?></div>
</div>
</div>
</div>

<div class="row">
<div class="col-12 col-sm-8 mb-3">
<div class="border p-2">
<div class="text-secondary titulos">Fecha y hora de llegada de full:</div>
<div class="titulos"><?=$fechallegada;?>, <?=$horallegada;?></div>
</div>
</div>


<div class="col-12 col-sm-4 mb-3">
<div class="border p-2">
<div class="text-secondary titulos">Productos recibido:</div>
<div class="titulos"><?=$producto;?></div>
</div>
</div>

<div class="col-12 col-sm-4 mb-3">
<div class="border p-2">
<div class="text-secondary titulos">Numero Factura o Remisión:</div>
<div class="titulos"><?=$nofacturaremision;?></div>
</div>
</div>

<div class="col-12 col-sm-4 mb-3">
<div class="border p-2">
<div class="text-secondary titulos">Litros:</div>
<div class="titulos"><?=number_format($litros,2);?></div>
</div>
</div>

<div class="col-12 col-sm-4 mb-3">
<div class="border p-2">
<div class="text-secondary titulos">Precio por litro:</div>
<div class="titulos"><?=$preciolitro;?></div>
</div>
</div>

<div class="col-12 col-sm-4 mb-3">
<div class="border p-2">
<div class="text-secondary titulos">Cuenta litro:</div>
<div class="titulos"><?=$cuentalitros;?></div>
</div>
</div>

<div class="col-12 col-sm-4 mb-3">
<div class="border p-2">
<div class="text-secondary titulos">Tolerancia:</div>
<div class="titulos"><?=$tolerancia;?></div>
</div>
</div>

<div class="col-12 col-sm-2 mb-3">
<div class="border p-2">
<div class="text-secondary titulos">Merma en Litros:</div>
<div class="titulos"><?=$merma;?></div>
</div>
</div>


<div class="col-12 col-sm-4 mb-3">
<div class="border p-2">
<div class="text-secondary titulos">N.C:</div>
<div class="titulos"><?=$calculaNC;?></div>
</div>
</div>

<div class="col-12 col-sm-4 mb-3">
<div class="border p-2">
<div class="text-secondary titulos">Importe N.C:</div>
<div class="mt-1">$<?=$NC;?></div>
</div>
</div>

<div class="col-12 col-sm-4 mb-3">
<div class="border p-2">
<div class="text-secondary titulos">Unidad:</div>
<div class="titulos"><?=$unidad;?></div>
</div>
</div>

<div class="col-12 col-sm-3 mb-3">
<div class="border p-2">
<div class="text-secondary titulos">Nombre del operador de la unidad:</div>
<div class="titulos"><?=$operador;?></div>
</div>
</div>

<div class="col-12 col-sm-2 mb-3">
<div class="border p-2">
<div class="text-secondary titulos">Compañía de Transportista:</div>
<div class="titulos"><?=$transportista;?></div>
</div>
</div>

</div>

<div class="row">

<div class="col-12 col-sm-2 mb-3">
<div class="border p-3">
<div class="text-secondary titulos">Factura o Remisión:</div>
<hr>
<div class="text-center"><?=$facturaElement?></div>
</div>
</div>

<div class="col-12 col-sm-2 mb-3">
<div class="border p-3">
<div class="text-secondary titulos">Reporte de inventario Inicial con fecha y hora:</div>
<hr>
<div class="text-center"><?=$invInicialElement?></div>
</div>
</div>

<div class="col-12 col-sm-2 mb-3">
<div class="border p-3">
<div class="text-secondary titulos">Medida Nice:</div>
<hr>
<div class="text-center"><?=$niceElement?></div>
</div>
</div>


<div class="col-12 col-sm-2 mb-3">
<div class="border p-3">
<div class="text-secondary titulos">Reporte de inventario final con fecha y hora:</div>
<hr>
<div class="text-center"><?=$invFinalElement?></div>
</div>
</div>


<div class="col-12 col-sm-2 mb-3">
<div class="border p-3">
<div class="text-secondary titulos">Metro contador temperatura normal:</div>
<hr>
<div class="text-center"><?=$metroElement?></div>
</div>
</div>


<div class="col-12 col-sm-2 mb-3">
<div class="border p-3">
<div class="text-secondary titulos">Metro contador a 20 grados:</div>
<hr>
<div class="text-center"><?=$metro20Element?></div>
</div>
</div>

</div>

<div class="row">

<div class="col-12 col-sm-2 mb-3">
<div class="border p-2">
<div class="text-secondary titulos">Sellos alterados:</div>
<div class="titulos"><?=$sellos;?></div>
</div>
</div>

<div class="col-12 col-sm-3 mb-3">
<div class="border p-2">
<div class="text-secondary titulos">Se detuvo venta durante la descarga:</div>
<div class="titulos"><?=$detuvoventa;?></div>
</div>
</div>

</div>

<div class="border p-3">
<div class="text-secondary font-weight-bold titulos mb-1">Firmas:</div>
<hr>
<div class="row justify-content-md-center">
<?php

$sql_firma = "SELECT * FROM op_descarga_tuxpa_firma WHERE id_descarga = '".$GET_idReporte."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

echo '<div class="col-12 col-sm-4">';
echo '<div class="mb-2 text-center"><b>'.$row_firma['tipo_firma'].'</b></div>';
echo '<div class="border p-1 text-center"><img src="'.RUTA_IMG.'firma-tuxpan/'.$row_firma['imagen_firma'].'" width="100%"></div>';
echo '</div>';
}

?> 
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
