<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

$sql = "SELECT * FROM op_nivel_explosividad WHERE id = '".$GET_idReporte."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($resul);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$idEstacion = $row['id_estacion'];
$folio = $row['folio'];  
$fecha = $row['fecha'];  
}

$sqlEstacion = "SELECT razonsocial, permisocre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$resultEstacion = mysqli_query($con, $sqlEstacion);
while($rowEstacion = mysqli_fetch_array($resultEstacion, MYSQLI_ASSOC)){
$Estacion = $rowEstacion['razonsocial']; 
$Cre = $rowEstacion['permisocre'];  
}

$sqlDetalle = "SELECT * FROM op_nivel_explosividad_detalle WHERE id_reporte = '".$GET_idReporte."' ";
$resultDetalle = mysqli_query($con, $sqlDetalle);
$numeroDetalle = mysqli_num_rows($resulDetalle);
while($rowDetalle = mysqli_fetch_array($resultDetalle, MYSQLI_ASSOC)){
$elemento1 = $rowDetalle['elemento1'];
$elemento2 = $rowDetalle['elemento2'];  
$elemento3 = $rowDetalle['elemento3']; 
$elemento4 = $rowDetalle['elemento4'];
$elemento5 = $rowDetalle['elemento5'];  
$elemento6 = $rowDetalle['elemento6']; 
$elemento7 = $rowDetalle['elemento7'];
$elemento8 = $rowDetalle['elemento8'];  
$elemento9 = $rowDetalle['elemento9']; 
$elemento10 = $rowDetalle['elemento10'];
$elemento11 = $rowDetalle['elemento11'];  
$elemento12 = $rowDetalle['elemento12']; 
$elemento13 = $rowDetalle['elemento13'];
$elemento14 = $rowDetalle['elemento14'];  
$elemento15 = $rowDetalle['elemento15']; 
$elemento16 = $rowDetalle['elemento16'];
$elemento17 = $rowDetalle['elemento17'];  
$elemento18 = $rowDetalle['elemento18']; 
$observaciones = $rowDetalle['observaciones'];  
}

$sql_lista = "SELECT * FROM op_nivel_explosividad_pozo_motobomba WHERE id_reporte = '".$GET_idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

function Usuario($idUsuario, $con){
$sqlEstacion = "SELECT nombre FROM tb_usuarios WHERE id = '".$idUsuario."' ";
$resultEstacion = mysqli_query($con, $sqlEstacion);
while($rowEstacion = mysqli_fetch_array($resultEstacion, MYSQLI_ASSOC)){
$nombre = $rowEstacion['nombre'];  
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
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" ></script>
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>selectize.css">

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  });

  function Regresar(){
  window.history.back();
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

     <h5>Reporte de medición de explosividad</h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>

  
<div class="container" style="font-size: 1.1em;">

  <div class="border mt-4 mb-3">
  <div class="p-3">

<div class="row">

  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
    <div class="border-bottom p-2">
    FOLIO: <b>00<?=$folio;?></b>
    </div>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
    <div class="border-bottom p-2">
    REFERENCIA: <b>NOM 005 ASEA 2016</b>
    </div>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
    <div class="border-bottom p-2">
    Fecha: <b><?=FormatoFecha($fecha);?></b>
    </div>
  </div>

  <div class="col-12 mb-2">
    <div class="border-bottom p-2">
    <div class="text-center">Estacion de Serv.: <b><?=$Estacion;?>, <?=$Cre;?></b></div>
    </div>
  </div>


  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
    <div class="border-bottom p-2">
      <b>Tipo de Medicion</b>
      <div><?=$elemento1;?></div>
    </div>  
  </div>


  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
    <div class="border-bottom p-2">
      <b>Verificador</b>
      <div><?=$elemento2;?></div>
    </div>
  </div>


  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
    <div class="border-bottom p-2">
      <b>Observaciones</b>
      <div><?=$elemento3;?></div>
    </div>
  </div>


  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
    <div class="border-bottom p-2">
    Estacionamiento: <b><?=$elemento4;?></b> PPM
    </div>
  </div>


  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
    <div class="border-bottom p-2">
    Local Comercial: <b><?=$elemento5;?></b> PPM
    </div>
  </div>


  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
    <div class="border-bottom p-2">
    Oficinas: <b><?=$elemento6;?></b> PPM
    </div>
  </div>


  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
    <div class="border-bottom p-2">
    Oficinas: <b><?=$elemento6;?></b> PPM
    </div>
  </div>
  

  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
    <div class="border-bottom p-2">
    Bodega Local: <b><?=$elemento7;?></b> PPM
    </div>
  </div>


  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
    <div class="border-bottom p-2">
    Baños Empleados: <b><?=$elemento8;?></b> PPM
    </div>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
    <div class="border-bottom p-2">
    Bodega de Aceites: <b><?=$elemento9;?></b> PPM
    </div>
  </div>


  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
    <div class="border-bottom p-2">
    Baños Hombres: <b><?=$elemento10;?></b> PPM
    </div>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
    <div class="border-bottom p-2">
    Baños Mujeres: <b><?=$elemento11;?></b> PPM
    </div>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
    <div class="border-bottom p-2">
    Cuarto de Sucios: <b><?=$elemento12;?></b> PPM
    </div>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
    <div class="border-bottom p-2">
    Cto de Maquinas: <b><?=$elemento13;?></b> PPM
    </div>
  </div>


  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
    <div class="border-bottom p-2">
    Zona 1 Despacho: <b><?=$elemento14;?></b> PPM
    </div>
  </div>
  

  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
    <div class="border-bottom p-2">
    Zona 2 Despacho: <b><?=$elemento15;?></b> PPM
    </div>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
    <div class="border-bottom p-2">
    Zona 3 Despacho: <b><?=$elemento16;?></b> PPM
    </div>
  </div>


  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
    <div class="border-bottom p-2">
    Cto de aditivo: <b><?=$elemento17?></b> PPM
    </div>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
    <div class="border-bottom p-2">
    Zona de tanques: <b><?=$elemento18;?></b> PPM
    </div>
  </div>


</div>
</div>
</div>




<div class="row">

<div class="col-xl-9 col-lg-9 col-md-6 col-sm-12 mb-3">



<div class="table-responsive">
<table class="table table-sm table-bordered mb-3">
      <thead class="tables-bg">
        <tr>
          <th class="align-middle text-center">Detalle</th>
          <th class="align-middle text-center">PPM</th>
          <th class="align-middle text-center">Ubicación de Pozos</th>
        </tr>
      </thead>
      <tbody>
        <?php
    if ($numero_lista > 0) {
    while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

    echo '<tr>';
    echo '<td class="align-middle">'.$row_lista['pozo_motobomba'].'</td>';
    echo '<td class="align-middle text-center">'.$row_lista['ppm'].'</td>';
    echo '<td class="align-middle text-center">'.$row_lista['ubicacion'].'</td>';
    echo '</tr>';

    }
    }else{
    echo "<tr><td colspan='4' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
    }
    ?>
      </tbody>
    </table>
</div>


<div class="border">
<div class="p-3">

    <b >Observaciones:</b>
          <hr>
    <div><?=$observaciones;?></div>

</div>
</div>

</div>


<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
<div class="border">
<div class="p-3">



    <div class="font-weight-light text-center">
      <b>PARTICULAS POR MILLON PPM</b>
      <hr>
    </div>

    <img src="<?=RUTA_IMG_ICONOS;?>SPD202ex.PNG" width="75%">
    <hr>
    <div class="font-weight-light text-center" style="font-size: .9em;">
      LAS MEDICIONES SON CON EQUIPO "COMBUSTIBLE GAS ALARM DETECTOR SPD202/Ex"
    </div>


</div>
</div>
</div>


<div class="col-12">
<div class="border">
<div class="p-3">

  <b>Firmas:</b>
  <hr>



<div class="row">
<?php
$sql_firma = "SELECT * FROM op_nivel_explosividad_firma WHERE id_reporte = '".$GET_idReporte."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$Usuario = Usuario($row_firma['id_usuario'], $con);  

echo '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">';
echo '<div class="border">';
echo '<div class="p-3">';
echo '<div class="text-center mb-1">'.$Usuario.'</div>';
echo '<hr>';
echo '<div class="border p-1 text-center"><img src="../imgs/firma/'.$row_firma['imagen_firma'].'" width="100%"></div>';
echo '<div class="text-center mt-2"><b>'.$row_firma['tipo_firma'].'</b></div>';
echo '</div>';
echo '</div>';
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

