<?php
require('app/help.php');

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
  <link href="<?=RUTA_CSS2;?>navbar-utilities.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

  <script src="<?=RUTA_JS?>size-window.js"></script> 
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  sizeWindow();

    if(sessionStorage){
   
    if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion')) {

      idestacion = sessionStorage.getItem('idestacion');
      year = sessionStorage.getItem('year');
      mes = sessionStorage.getItem('mes');

      var ListaES = document.getElementById("ListaEstaciones");
      var ListaGNRL = document.getElementById("ListaGeneral");

      if(idestacion != 0){
      $('#ListaAnalisis').load('../../../public/admin/vistas/lista-analisis-compra.php?idEstacion=' + idestacion + '&year=' + year + '&mes=' + mes);
      $('#SubtotalAnalisis').load('../../../public/admin/vistas/subtotal-analisis-compra.php?idEstacion=' + idestacion + '&year=' + year + '&mes=' + mes);
      $('#TotalAnalisis').load('../../../public/admin/vistas/total-analisis-compra.php?idEstacion=' + idestacion + '&year=' + year + '&mes=' + mes);
      ListaES.style.display = "block";
      ListaGNRL.style.display = "none";

      }else{
      $('#TotalAnalisisGeneral').load('../../../public/admin/vistas/total-analisis-compra-general.php?year=' + year + '&mes=' + mes);
      ListaES.style.display = "none";
      ListaGNRL.style.display = "block";

      }   
  

  }
     
  } 
  
  });

    function Regresar(){
    window.history.back();

    sessionStorage.removeItem('idestacion');
    sessionStorage.removeItem('year');
    sessionStorage.removeItem('mes');
    sessionStorage.removeItem('scrollTop');

    }

    function SelEstacion(idestacion,year,mes){
    sizeWindow();  
    sessionStorage.setItem('idestacion', idestacion);
    sessionStorage.setItem('year', year);
    sessionStorage.setItem('mes', mes);
    sessionStorage.setItem('scrollTop', 0);

    var ListaES = document.getElementById("ListaEstaciones");
    var ListaGNRL = document.getElementById("ListaGeneral");

    if(idestacion != 0){
    ListaES.style.display = "block";
    ListaGNRL.style.display = "none";

    $('#ListaAnalisis').load('../../../public/admin/vistas/lista-analisis-compra.php?idEstacion=' + idestacion + '&year=' + year + '&mes=' + mes);
    $('#SubtotalAnalisis').load('../../../public/admin/vistas/subtotal-analisis-compra.php?idEstacion=' + idestacion + '&year=' + year + '&mes=' + mes);
    $('#TotalAnalisis').load('../../../public/admin/vistas/total-analisis-compra.php?idEstacion=' + idestacion + '&year=' + year + '&mes=' + mes);

    }else{
    ListaES.style.display = "none";
    ListaGNRL.style.display = "block";
    $('#TotalAnalisisGeneral').load('../../../public/admin/vistas/total-analisis-compra-general.php?year=' + year + '&mes=' + mes);

    }


    }


  function replaceAll( text, busca, reemplaza ){
  while (text.toString().indexOf(busca) != -1)
  text = text.toString().replace(busca,reemplaza);
  return text;
  }

  function BrutoNeto(val,opcion,id){

  var litros = $('#LtsF' + id).text();
  var LitrosF = replaceAll(litros, ",", "" );
  var input = val.value;
  var Diferencia1 = parseFloat(input) - parseFloat(LitrosF);
  

  var parametros = {
  "id" : id,
  "valor" : input,
  "opcion" : opcion
  };

    $.ajax({
    data:  parametros,
    url:   '../../../public/admin/modelo/editar-importacion-analisis-compra.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    $('#Dif' + opcion + id).text(Diferencia1);

    idestacion = sessionStorage.getItem('idestacion');
    year = sessionStorage.getItem('year');
    mes = sessionStorage.getItem('mes');
    $('#SubtotalAnalisis').load('../../../public/admin/vistas/subtotal-analisis-compra.php?idEstacion=' + idestacion + '&year=' + year + '&mes=' + mes); 

    }else{
    alertify.error('Error al guardar');  
    }

    }
    });

  }


  </script>
  </head>

<body> 
<div class="LoaderPage"></div>


  <!---------- CONTENIDO Y BARRA DE NAVEGACION ---------->
 <div class="wrapper"> 
  <!---------- BARRA DE NAVEGACION ---------->
  <nav id="sidebar">
          
  <div class="sidebar-header text-center">
  <img class="" src="<?=RUTA_IMG_LOGOS."Logo.png";?>" style="width: 100%;">
  </div>

    <ul class="list-unstyled components">
   
    <?php
      
      if($Session_IDUsuarioBD == 509){
        $referencia = "href= ../../importacion ";
        $nombreBar2 = "Menu";

      }else{
        $referencia = "href=".SERVIDOR_ADMIN." ";
        $nombreBar2 = "Menu";
      }
      ?>
 
    <li>
    <a class="pointer" <?=$referencia?>>
    <i class="fa-solid fa-house" aria-hidden="true" style="padding-right: 10px;"></i><?=$nombreBar2?>
    </a>
    </li>


    <li>
    <a class="pointer" onclick="Regresar()">
    <i class="fas fa-arrow-left" aria-hidden="true" style="padding-right: 10px;"></i>Regresar
    </a>
    </li>

    <?php

$sql_listaestacion = "SELECT id, nombre FROM tb_estaciones WHERE numlista <= 8";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);

   while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
    $id = $row_listaestacion['id'];
    $estacion = $row_listaestacion['nombre'];

   echo '  
  <li>
    <a class="pointer" onclick="SelEstacion('.$id.','.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';    
    }
    

?> 

<li>
    <a class="pointer" onclick="SelEstacion(0,<?=$GET_year?>,<?=$GET_mes?>)">
    <i class="fa-solid fa-file-lines" aria-hidden="true" style="padding-right: 10px;"></i>
    Total General
    </a>
  </li>

</ul>
</nav>

  <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
 <nav class="navbar navbar-expand navbar-light navbar-bg" >
  
  <i class="fa-solid fa-bars menu-btn rounded pointer" 
  id="sidebarCollapse"></i>

  <div class="pointer">
  <a class="text-dark" onclick="history.back()">Análisis de compra, <?=nombremes($GET_mes);?> del <?=$GET_year;?></a>
  </div>
 
   
  <div class="navbar-collapse collapse">

  <div class="dropdown-divider"></div>

  <ul class="navbar-nav navbar-align">

  <li class="nav-item dropdown">
  <a class=" dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
  <i class="align-middle" data-feather="settings"></i>
  </a>

 
  <a class="nav-link dropdown-toggle d-none d-sm-inline-block pointer" data-bs-toggle="dropdown">
  
  <img src="<?=RUTA_IMG_ICONOS."usuarioBar.png";?>" class="avatar img-fluid rounded-circle"/>

  <span class="text-dark" style="padding-left: 10px;">
  <?=$session_nompuesto;?>  
  </span>
  </a>
  
  <div class="dropdown-menu dropdown-menu-end">
  
  <div class="user-box">

  <div class="u-text">
  <p class="text-muted">Nombre de usuario:</p>
  <h4><?=$session_nomusuario;?></h4>
  </div>

  </div>

 
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="<?=PERFIL_ADMIN?>">
  <i class="fa-solid fa-user" style="padding-right: 5px;"></i>Perfil
  </a>
 
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="<?=RUTA_SALIR2?>salir">
  <i class="fa-solid fa-power-off" style="padding-right: 5px;"></i> Cerrar Sesión
  </a>

  </div>
  </li>
  
  </ul>
  </div>

  </nav>
 
  <!---------- CONTENIDO PAGINA WEB----------> 

  <!---------- CONTENIDO PAGINA WEB----------> 
  <div class="contendAG">
  <div class="row">  
  
  <div class="col-12" id="ListaEstaciones">

  <div id="ListaAnalisis"></div>
  <div id="SubtotalAnalisis"></div>
  <div id="TotalAnalisis" ></div>  
  </div> 


  <div class="col-12" id="ListaGeneral"> <div id="TotalAnalisisGeneral"></div> </div>

  </div>
  </div> 

</div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>
  
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>


  </body>
  </html>
