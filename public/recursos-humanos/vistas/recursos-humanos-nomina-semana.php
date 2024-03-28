      <?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

function ToSolicitud($idEstacion,$year,$mes,$semana,$con){
 
if($semana == 1){
  $nombreSemana = "Primera semana";

}else if($semana == 2){
  $nombreSemana = "Segunda semana";

}else if($semana == 3){
  $nombreSemana = "Tercera semana";

}else if($semana == 4){
  $nombreSemana = "Cuarta semana";

}else if($semana == 5){
  $nombreSemana = "Quinta semana";

}else if($semana == 6){
  $nombreSemana = "Primera quincena";

}else if($semana == 7){
  $nombreSemana = "Segunda quincena";

}else if($semana == 8){
  $nombreSemana = "Aguinaldo";
}


$sql_lista = "SELECT id FROM op_recibo_nomina WHERE id_estacion = '".$idEstacion."' AND year = '".$year."' AND mes = '".$mes."' AND periodo = '".$nombreSemana."' AND status = 0 ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
}
 

if($GET_semana == 1){
  $nombreSemana = "Primera Semana";
  $consulta = "numlista <= 8 OR numlista = 10";

}else if($GET_semana == 2){
  $nombreSemana = "Segunda Semana";
  $consulta = "numlista <= 8 OR numlista = 10";

}else if($GET_semana == 3){
  $nombreSemana = "Tercera Semana";
  $consulta = "numlista <= 8 OR numlista = 10";

}else if($GET_semana == 4){
  $nombreSemana = "Cuarta Semana";
  $consulta = "numlista <= 8 OR numlista = 10";

}else if($GET_semana == 5){
  $nombreSemana = "Quinta Semana";
  $consulta = "numlista <= 8 OR numlista = 10";

}else if($GET_semana == 6){
  $nombreSemana = "Primera Quincena";
  $consulta = "numlista = 12 OR numlista = 14 OR numlista = 15 OR numlista = 16 OR numlista = 17";

}else if($GET_semana == 7){
  $nombreSemana = "Segunda Quincena";
   $consulta = "numlista = 12 OR numlista = 14 OR numlista = 15 OR numlista = 16 OR numlista = 17";

}else if($GET_semana == 8){
  $nombreSemana = "Aguinaldo";
  $consulta = "numlista <= 8 OR numlista = 10 OR numlista = 12 OR numlista = 14 OR numlista = 15 OR numlista = 16 OR numlista = 17";

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
  <link href="<?=RUTA_CSS2;?>navbar-utilities.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

  <script src="<?=RUTA_JS?>size-window.js"></script>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  
  <style media="screen">
  .grayscale {
      filter: opacity(50%); 
  }
  </style>
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  sizeWindow();
  
  if(sessionStorage){ 
    if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion')) {

      idestacion = sessionStorage.getItem('idestacion');
      year = sessionStorage.getItem('year');
      mes = sessionStorage.getItem('mes')
      semana = sessionStorage.getItem('semana')


      $('#ListaEmbarques').load('../../../public/recursos-humanos/vistas/lista-nomina-mes.php?idEstacion=' + idestacion + '&year=' + year + '&mes=' + mes + '&semana=' + semana);
          
    }   
     
    } 

    });  
 
  function Regresar(){
   sessionStorage.removeItem('idestacion');
   sessionStorage.removeItem('year');
   sessionStorage.removeItem('mes');
   sessionStorage.removeItem('semana');
   sessionStorage.removeItem('scrollTop');
   window.history.back();
  }


  function SelEstacion(idEstacion,year,mes,semana){
    sizeWindow();
    sessionStorage.setItem('idestacion', idEstacion);
    sessionStorage.setItem('year', year);
    sessionStorage.setItem('mes', mes);
    sessionStorage.setItem('semana', semana);

    $('#ListaEmbarques').load('../../../public/recursos-humanos/vistas/lista-nomina-mes.php?idEstacion=' + idEstacion +  '&year=' + year + '&mes=' + mes + '&semana=' + semana);
  }

   function Mas(idEstacion,year,mes,semana){
    $('#Modal').modal('show');  
    $('#DivContenido').load('../../../public/recursos-humanos/vistas/modal-formulario-nomina.php?idEstacion=' + idEstacion  + '&year=' + year + '&mes=' + mes + '&semana=' + semana);
  } 
 
  
  
 function AgregarDocumento(idEstacion,year,mes,semana){  
    
    var Personal    = $('#Personal').val();
    var Documento   = $('#Documento').val();

    var Percepciones  = $('#Percepciones').val();
    var Deducciones   = $('#Deducciones').val();
    var ISR           = $('#ISR').val();
    var ISR2          = $('#ISR2').val();
    var Total         = $('#Total').val();


    var data = new FormData(); 
    var url = '../../../public/recursos-humanos/modelo/agregar-reporte-nomina.php';

    Documento = document.getElementById("Documento");
    Documento_file = Documento.files[0];
    Documento_filePath = Documento.value;
  
 
  if(Personal != ""){
  $('#Personal').css('border',''); 

  if(Percepciones != ""){
  $('#Percepciones').css('border',''); 

  if(Deducciones != ""){
  $('#Deducciones').css('border',''); 

  if(ISR != ""){
  $('#ISR').css('border',''); 

  if(ISR2 != ""){
  $('#ISR2').css('border',''); 

  if(Total != ""){
  $('#Total').css('border',''); 

  if(Documento_filePath != ""){
  $('#Documento_filePath').css('border',''); 

  data.append('idEstacion', idEstacion);
  data.append('idPersonal', Personal);

  data.append('Percepciones', Percepciones);
  data.append('Deducciones', Deducciones);
  data.append('ISR', ISR);
  data.append('ISR2', ISR2);
  data.append('Total', Total);

  data.append('year', year);
  data.append('mes', mes);
  data.append('Periodo', semana);
  data.append('Documento_file', Documento_file);

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
       $(".LoaderPage").hide();
       $('#Modal').modal('hide'); 
       SelEstacion(idEstacion,year,mes,semana);
       sizeWindow()
       alertify.success('Registro creado exitosamente.');
     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al crear'); 
      $('#Modal').modal('hide'); 
     }
     

    }); 

  }else{
  $('#Documento').css('border','2px solid #A52525'); 
  }

  }else{
  $('#Total').css('border','2px solid #A52525'); 
  }


  }else{
  $('#ISR2').css('border','2px solid #A52525'); 
  }


  }else{
  $('#ISR').css('border','2px solid #A52525'); 
  }


  }else{
  $('#Deducciones').css('border','2px solid #A52525'); 
  }


  }else{
  $('#Percepciones').css('border','2px solid #A52525'); 
  }

  }else{
  $('#Personal').css('border','2px solid #A52525'); 
  }

 }

  function Eliminar(id,idEstacion,year,mes,semana){

    var parametros = {
    "id" : id
    };

alertify.confirm('', 
 function(){

      $.ajax({
    data:  parametros,
    url:   '../../../public/recursos-humanos/modelo/eliminar-reporte-nomina.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
     SelEstacion(idEstacion,year,mes,semana); 
      sizeWindow()
      alertify.success('Registro eliminado exitosamente.'); 
    }else{
     alertify.error('Error al eliminar');  
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();


  }

  function SubirPDF(id,idEstacion,year,mes,semana,idPersonal){ 
     
    $('#Modal').modal('show');  
    $('#DivContenido').load('../../../public/recursos-humanos/vistas/modal-formulario-editar-nomina.php?id=' + id + '&idEstacion=' + idEstacion + '&esdep=' + 0 + '&year=' + year + '&mes=' + mes + '&semana=' + semana + '&idPersonal=' + idPersonal);
  }   
   
  function EditarDocumento(id,idEstacion,esdep,year,mes,semana,idPersonal){  

     var Periodo     = $('#Periodo').val();
    var Documento   = $('#Documento').val();

    var data = new FormData();
    var url = '../../../public/recursos-humanos/modelo/editar-reporte-nomina.php';
 
    Documento = document.getElementById("Documento");
    Documento_file = Documento.files[0];
    Documento_filePath = Documento.value;

  if(Documento_filePath != ""){
  $('#Documento_filePath').css('border',''); 

  data.append('id', id);
  data.append('Documento_file', Documento_file);
  data.append('idPersonal', idPersonal);

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
       $(".LoaderPage").hide();
       $('#Modal').modal('hide'); 
       SelEstacion(idEstacion,year,mes,semana); 
      sizeWindow()
      alertify.success('Registro editado exitosamente.'); 
     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al editar'); 
      $('#Modal').modal('hide'); 
     }
     
    }); 

  }else{
  $('#Documento').css('border','2px solid #A52525'); 
  }


  }

  function ModalComentario(id,idEstacion,year,mes,semana){
   $('#Modal').modal('show');  
    $('#DivContenido').load('../../../public/recursos-humanos/vistas/modal-comentarios-nomina.php?id=' + id + '&idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes + '&semana=' + semana);
 }

 function GuardarComentario(id,idEstacion,year,mes,semana){

    var Comentario = $('#Comentario').val();

    var parametros = {
    "idReporte" : id,
    "Comentario" : Comentario
    }; 

    if(Comentario != ""){
    $('#Comentario').css('border',''); 

    $.ajax({
    data:  parametros,
    url:   '../../../public/recursos-humanos/modelo/agregar-comentario-nomina.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    $('#Comentario').val('');
    SelEstacion(idEstacion,year,mes,semana);   
    sizeWindow() 
    $('#DivContenido').load('../../../public/recursos-humanos/vistas/modal-comentarios-nomina.php?id=' + id + '&idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes + '&semana=' + semana);
    }else{
     alertify.error('Error al guardar el comentario');  
    }

    } 
    });

    }else{
    $('#Comentario').css('border','2px solid #A52525'); 
    }

    }


    function editarNomina(id,idEstacion,year,mes,semana,idPersonal){

    $('#Modal').modal('show');  
    $('#DivContenido').load('../../../public/recursos-humanos/vistas/modal-formulario-editar-datos-nomina.php?id=' + id + '&idEstacion=' + idEstacion + '&esdep=' + 0 + '&year=' + year + '&mes=' + mes + '&semana=' + semana + '&idPersonal=' + idPersonal);
    }


    function EditarNominaServer(id,idEstacion,year,mes,semana){

    var Documento   = $('#Documento').val();

    var Percepciones  = $('#Percepciones').val();
    var Deducciones   = $('#Deducciones').val();
    var ISR           = $('#ISR').val();
    var ISR2          = $('#ISR2').val();
    var Total         = $('#Total').val();


    var data = new FormData(); 
    var url = '../../../public/recursos-humanos/modelo/editar-datos-reporte-nomina.php';

    Documento = document.getElementById("Documento");
    Documento_file = Documento.files[0];
    Documento_filePath = Documento.value;
  
  if(Percepciones != ""){
  $('#Percepciones').css('border',''); 

  if(Deducciones != ""){
  $('#Deducciones').css('border',''); 

  if(ISR != ""){
  $('#ISR').css('border',''); 

  if(ISR2 != ""){
  $('#ISR2').css('border',''); 

  if(Total != ""){
  $('#Total').css('border',''); 

  data.append('idNomina', id);
  data.append('Percepciones', Percepciones);
  data.append('Deducciones', Deducciones);
  data.append('ISR', ISR);
  data.append('ISR2', ISR2);
  data.append('Total', Total);

  data.append('Documento_file', Documento_file);

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
       $(".LoaderPage").hide();
       $('#Modal').modal('hide'); 
       SelEstacion(idEstacion,year,mes,semana);
       sizeWindow()
       alertify.success('Registro editado exitosamente.');
     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al crear'); 
      $('#Modal').modal('hide'); 
     }
     

    }); 



  }else{
  $('#Total').css('border','2px solid #A52525'); 
  }


  }else{
  $('#ISR2').css('border','2px solid #A52525'); 
  }


  }else{
  $('#ISR').css('border','2px solid #A52525'); 
  }


  }else{
  $('#Deducciones').css('border','2px solid #A52525'); 
  }


  }else{
  $('#Percepciones').css('border','2px solid #A52525'); 
  }


  }
 


  function AcuseNomina(idEstacion,year,mes,semana){
    $('#Modal').modal('show');  
    $('#DivContenido').load('../../../public/recursos-humanos/vistas/modal-acuse-nomina.php?idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes + '&semana=' + semana);
  }



    function GuardarAcuse(idEstacion,year,mes,semana){

    var fecha   = $('#Fecha').val();
    var Documento   = $('#Documento').val();

    var data = new FormData(); 
    var url = '../../../public/recursos-humanos/modelo/agregar-acuse-nomina.php';

    Documento = document.getElementById("Documento");
    Documento_file = Documento.files[0];
    Documento_filePath = Documento.value;
  
  if(fecha != ""){
  $('#Fecha').css('border',''); 

  if(Documento_filePath != ""){
  $('#Documento_filePath').css('border',''); 

  data.append('idEstacion', idEstacion);
  data.append('year', year);
  data.append('mes', mes);
  data.append('semana', semana);
  data.append('fecha', fecha);


  data.append('Documento_file', Documento_file);

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
       $(".LoaderPage").hide();
    $('#DivContenido').load('../../../public/recursos-humanos/vistas/modal-acuse-nomina.php?idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes + '&semana=' + semana);
       alertify.success('Registro agregado exitosamente.');
     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al crear'); 
      $('#Modal').modal('hide'); 
     }
     

    }); 

  }else{
  $('#Documento').css('border','2px solid #A52525'); 
  }

  }else{
  $('#Fecha').css('border','2px solid #A52525'); 
  }


  }
 

    function EliminarAcuse(idArchivo,idEstacion,year,mes,semana){

    var parametros = {
    "idArchivo" : idArchivo
    };
 
alertify.confirm('', 
 function(){

      $.ajax({
    data:  parametros,
    url:   '../../../public/recursos-humanos/modelo/eliminar-acuse-nomina.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    $('#DivContenido').load('../../../public/recursos-humanos/vistas/modal-acuse-nomina.php?idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes + '&semana=' + semana);
      sizeWindow()
      alertify.success('Registro eliminado exitosamente.'); 
    }else{
     alertify.error('Error al eliminar');  
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


  <!---------- CONTENIDO Y BARRA DE NAVEGACION ---------->
 <div class="wrapper"> 
  <!---------- BARRA DE NAVEGACION ---------->
  <nav id="sidebar">
           
  <div class="sidebar-header text-center">
  <img class="" src="<?=RUTA_IMG_LOGOS."Logo.png";?>" style="width: 100%;">
  </div>

    <ul class="list-unstyled components">
   
    <li>
    <a class="pointer" href="<?=SERVIDOR_ADMIN?>">
    <i class="fa-solid fa-house" aria-hidden="true" style="padding-right: 10px;"></i>Menu
    </a>
    </li>


    <li>
    <a class="pointer" onclick="Regresar()">
    <i class="fas fa-arrow-left" aria-hidden="true" style="padding-right: 10px;"></i>Regresar
    </a>
    </li>

 
  <?php
  $sql_listaestacion = "SELECT id, numlista, localidad FROM op_rh_localidades WHERE $consulta ORDER BY numlista ASC";
  $result_listaestacion = mysqli_query($con, $sql_listaestacion);
  while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
  $id = $row_listaestacion['id'];
  $estacion = $row_listaestacion['localidad'];

 
   if ($id == 6 || $id == 7) {
    $ocultarDiv = "d-none";
   
   }else{
     $ocultarDiv = "";
   }


if($estacion == "Comodines"){
 $icon = "fa-solid fa-users";

}else if($estacion == "Autolavado"){
 $icon = "fa-solid fa-car";

}else if($estacion == "Almacen"){
$icon = "fa-sharp fa-solid fa-shop";

}else if($estacion == "Directivos"){
$icon = " fa-solid fa-user-tie"; 

}else if($estacion == "Servicio Profesionales Operación Servicio y Mantenimiento de Personal"){
$icon = "fa-solid fa-screwdriver-wrench";

}else if($estacion == "Dirección de operaciones" ||
 $estacion == "Departamento Gestión" ||
 $estacion == "Departamento Jurídico" ||
 $estacion == "Departamento Mantenimiento" ||
 $estacion == "Departamento Sistemas"){
   $icon = "fa-solid fa-briefcase"; 


}else{
 $icon = "fa-solid fa-gas-pump";    
}


$ToSolicitud = ToSolicitud($id,$GET_year,$GET_mes,$GET_semana,$con);

  if($ToSolicitud > 0){
    $Total = '<div class="float-end"><span class="badge bg-danger text-white rounded-circle"><small>'.$ToSolicitud.'</small></span></div>';
  }else{
   $Total = ''; 
  }

  echo '  
  <li class="'.$ocultarDiv.'">
    <a class="pointer" onclick="SelEstacion('.$id.','.$GET_year.','.$GET_mes.','.$GET_semana.')">
    <i class="'.$icon.'" aria-hidden="true" style="padding-right: 10px;"></i>
     '.$Total.' '.$estacion.'
    </a>
  </li>';

}
  ?> 

</ul>
</nav>

  <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
 <nav class="navbar navbar-expand navbar-light navbar-bg" >
  
  <i class="fa-solid fa-bars menu-btn rounded pointer" 
  id="sidebarCollapse"></i>

  <div class="pointer">
  <a class="text-dark" onclick="history.back()">Recibos de nomina, <?=$nombreSemana?> - <?=nombremes($GET_mes);?> <?=$GET_year;?> </a>
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
  <div class="contendAG">
  <div class="row">  
  
  <div class="col-12 mb-3">
  <div id="ListaEmbarques" class="cardAG"></div>
  </div> 

  </div>
  </div>


  </div>
</div>


  <div class="modal" id="Modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="margin-top: 83px;">
      <div id="DivContenido"></div>
      </div>
    </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>
  
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>


</body>
</html>