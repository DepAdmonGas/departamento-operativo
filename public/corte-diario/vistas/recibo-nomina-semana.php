 <?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
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
  <link href="<?=RUTA_CSS2;?>navbar-general.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  
  <style media="screen">
  .tooltip1 {
      display:inline-block;
      position:relative;
      text-align:left;
  }

  .tooltip1 .bottom {
      
      top:35px;
      left:35%;
      transform:translate(-50%, 0);
      padding:5px;
      color:white;
      background-color:black;
      font-weight:normal;
      font-size:13px;
      border-radius:8px;
      position:absolute;
      z-index:999999999;
      box-shadow:0 1px 8px rgba(0,0,0,0.5);
      display:none;
      text-align: center;
  }

  .tooltip1:hover .bottom {
      display:block;
  }

  .grayscale {
      filter: opacity(50%); 
  }
  </style>
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");

  Nomina(<?=$Session_IDEstacion;?>,<?=$session_idpuesto;?>,<?=$GET_year;?>,<?=$GET_mes;?>,<?=$GET_semana;?>);
  
  if(<?=$Session_IDEstacion;?> == 2){
  Nomina2(9,<?=$session_idpuesto;?>,<?=$GET_year;?>,<?=$GET_mes;?>,<?=$GET_semana;?>);
  }


  
  });

  function Regresar(){
   window.history.back();
  }
  
   function Nomina(idEstacion,esdep,year,mes,semana){
    $('#ListaNomina').load('../../../public/corte-diario/vistas/lista-nomina-mes.php?idEstacion=' + idEstacion + '&esdep=' + esdep + '&year=' + year + '&mes=' + mes + '&semana=' + semana);
    } 
  

  function Nomina2(idEstacion,esdep,year,mes,semana){
  $('#ListaNomina2').load('../../../public/corte-diario/vistas/lista-nomina-mes-ps.php?idEstacion=' + idEstacion + '&esdep=' + esdep + '&year=' + year + '&mes=' + mes + '&semana=' + semana);
  } 
 

  function Editar(id,idEstacion,esdep,year,mes,idPersonal,semana){ 

     $('#Modal').modal('show');  
    $('#DivContenido').load('../../../public/recursos-humanos/vistas/modal-formulario-editar-nomina.php?id=' + id + '&idEstacion=' + idEstacion + '&esdep=' + esdep + '&year=' + year + '&mes=' + mes + '&idPersonal=' + idPersonal + '&semana=' + semana);
  }  
      
  
  function EditarDocumento(id,idEstacion,esdep,year,mes,semana,idPersonal){  

    var Documento   = $('#Documento').val();
  
    var data = new FormData();
    var url = '../../../public/corte-diario/modelo/editar-reporte-nomina.php';

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

      if(idEstacion == 9){
        idEstacionVal = 2;
      }else{
        idEstacionVal = idEstacion;
      }

  Nomina(idEstacionVal,<?=$session_idpuesto;?>,<?=$GET_year;?>,<?=$GET_mes;?>,<?=$GET_semana;?>);
  
  if(<?=$Session_IDEstacion;?> == 2){
  Nomina2(9,<?=$session_idpuesto;?>,<?=$GET_year;?>,<?=$GET_mes;?>,<?=$GET_semana;?>);
  }


       alertify.success('Documento editado exitosamente');

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

  function ModalComentario(id,idEstacion,esdep,year,mes,semana){
   $('#Modal').modal('show');  
    $('#DivContenido').load('../../../public/recursos-humanos/vistas/modal-comentarios-nomina.php?id=' + id + '&idEstacion=' + idEstacion + '&esdep=' + esdep + '&year=' + year + '&mes=' + mes + '&semana=' + semana);
 }

 function GuardarComentario(id,idEstacion,esdep,year,mes,semana){

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


      if(idEstacion == 9){
        idEstacionVal = 2;
      }else{
        idEstacionVal = idEstacion;
      }

  Nomina(idEstacionVal,<?=$session_idpuesto;?>,<?=$GET_year;?>,<?=$GET_mes;?>,<?=$GET_semana;?>);
  if(<?=$Session_IDEstacion;?> == 2){
  Nomina2(9,<?=$session_idpuesto;?>,<?=$GET_year;?>,<?=$GET_mes;?>,<?=$GET_semana;?>);
  }

    $('#DivContenido').load('../../../public/recursos-humanos/vistas/modal-comentarios-nomina.php?id=' + id + '&idEstacion=' + idEstacion + '&esdep=' + esdep + '&year=' + year + '&mes=' + mes + '&semana=' + semana);
    }else{
     alertify.error('Error al guardar el comentario');  
    }

    }
    });

    }else{
    $('#Comentario').css('border','2px solid #A52525'); 
    }

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
    var url = '../../../public/corte-diario/modelo/agregar-reporte-nomina.php';

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

      if(idEstacion == 9){
        idEstacionVal = 2;
      }else{
        idEstacionVal = idEstacion;
      }

  Nomina(idEstacionVal,<?=$session_idpuesto;?>,<?=$GET_year;?>,<?=$GET_mes;?>,<?=$GET_semana;?>);

  if(<?=$Session_IDEstacion;?> == 2){
  Nomina2(9,<?=$session_idpuesto;?>,<?=$GET_year;?>,<?=$GET_mes;?>,<?=$GET_semana;?>);
  }


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

     
  function SubirPDF(id,idEstacion,year,mes,semana,idPersonal){  
    $('#Modal').modal('show');  
    $('#DivContenido').load('../../../public/recursos-humanos/vistas/modal-formulario-editar-nomina.php?id=' + id + '&idEstacion=' + idEstacion + '&esdep=' + 0 + '&year=' + year + '&mes=' + mes + '&semana=' + semana + '&idPersonal=' + idPersonal);
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
       $('#Modal').modal('hide'); 

      if(idEstacion == 9){
        idEstacionVal = 2;
      }else{
        idEstacionVal = idEstacion;
      }

  Nomina(idEstacionVal,<?=$session_idpuesto;?>,<?=$GET_year;?>,<?=$GET_mes;?>,<?=$GET_semana;?>);
  if(<?=$Session_IDEstacion;?> == 2){
  Nomina2(9,<?=$session_idpuesto;?>,<?=$GET_year;?>,<?=$GET_mes;?>,<?=$GET_semana;?>);
  }


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

      if(idEstacion == 9){
        idEstacionVal = 2;
      }else{
        idEstacionVal = idEstacion;
      }

  Nomina(idEstacionVal,<?=$session_idpuesto;?>,<?=$GET_year;?>,<?=$GET_mes;?>,<?=$GET_semana;?>);
  if(<?=$Session_IDEstacion;?> == 2){
  Nomina2(9,<?=$session_idpuesto;?>,<?=$GET_year;?>,<?=$GET_mes;?>,<?=$GET_semana;?>);
  }

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
    <div class="col-11">

     <h5>Recibos de nomina, <?=$nombreSemana?> - <?=nombremes($GET_mes);?> <?=$GET_year;?></h5>
    
    </div>

    <div class="col-1">
    <img class="ml-2 float-end pointer" onclick="Mas(<?=$Session_IDEstacion;?>,<?=$GET_year;?>,<?=$GET_mes;?>,<?=$GET_semana;?>)" src="<?=RUTA_IMG_ICONOS;?>agregar.png">
    </div>

    </div>


    </div>
    </div>

  <hr>  


  <div id="ListaNomina"></div>
  <div id="ListaNomina2"></div>
  

  </div>
  </div>
  </div>

  </div>
  </div>

  </div>

  <div class="modal" id="Modal">
    <div class="modal-dialog">
      <div class="modal-content" style="margin-top: 83px;">
      <div id="DivContenido"></div>
      </div>
    </div>
  </div>



  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>

