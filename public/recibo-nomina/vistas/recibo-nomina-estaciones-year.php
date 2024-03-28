<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

  function SemanaActual(){  
    // Obtener la fecha actual
    $currentDate = time(); // Puedes usar una fecha específica con strtotime() si lo deseas
    // Calcular el número de día de la semana (de 1 a 7, donde 4 es jueves y 3 es miércoles)
    $diaSemana = date('N', $currentDate);

    // Si la semana termina el miércoles, ajustamos la fecha para obtener el inicio de la semana
    if ($diaSemana >= 4) {
    $inicioSemana = strtotime('last Wednesday', $currentDate);
    
    }else{
    $inicioSemana = strtotime('Wednesday last week', $currentDate);
    }
 
    // Obtener el número de semana actual considerando que la semana comienza el jueves (4)
    return $semanaActual = date('W', $inicioSemana);
  }


  function departamentosNomina($puesto,$con){
    $sql_lista4 = "SELECT * FROM op_rh_localidades WHERE localidad LIKE '%" . $puesto . "%'";
    $result_lista4 = mysqli_query($con, $sql_lista4);
    $numero_lista4 = mysqli_num_rows($result_lista4);
  
    while($row_lista4 = mysqli_fetch_array($result_lista4, MYSQLI_ASSOC)){
    $GET_id_localidad = $row_lista4['id'];
    }

    return $GET_id_localidad;

  }  



  if($session_nompuesto == "Sistemas" || $session_nompuesto == "Gestoria" || $session_nompuesto == "Mantenimiento" || $session_nompuesto == "Departamento Jurídico"){
  
  if($session_nompuesto == "Gestoria"){
    $puesto = 'Gestion';
  
  }else{
    $puesto = $session_nompuesto;  
  }
  
  $GET_semana = 0;
  $GET_id_localidad = departamentosNomina($puesto,$con);
  // Obtener el número del día en el año actual
  $numeroDiaAnio = date('z') + 1; // Se agrega 1 ya que 'z' cuenta desde 0
  $GET_quincena = ceil($numeroDiaAnio / 15); // Redondear hacia arriba para obtener el número de quincena
  $noneDiv = "d-none";


  }else{
 
  $GET_semana = SemanaActual();
  
  if($Session_IDEstacion == 2){
  $GET_id_localidad = 9;
  $numeroDiaAnio = date('z') + 1; // Se agrega 1 ya que 'z' cuenta desde 0
  $GET_quincena = ceil($numeroDiaAnio / 15); // Redondear hacia arriba para obtener el número de quincena
  $noneDiv = "";

  }else{
  $numeroDiaAnio = 0; // Se agrega 1 ya que 'z' cuenta desde 0
  $GET_id_localidad = 0;
  $GET_quincena = 0;
  $noneDiv = "d-none";

  }


  }




?>
<html lang="es">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Dirección de operaciones </title>
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
  
  <style media="screen">
  .grayscale {
      filter: opacity(50%); 
  }
  </style>

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");

  if('<?=$session_nompuesto?>' == "Sistemas" || '<?=$session_nompuesto?>' == "Gestoria" || '<?=$session_nompuesto?>' == "Mantenimiento" || '<?=$session_nompuesto?>' == "Departamento Jurídico"){
  SelQuincenasES(<?=$GET_id_localidad?>,<?=$GET_year?>,<?=$GET_quincena?>)

  }else{
  SelSemanasES(<?=$Session_IDEstacion?>,<?=$GET_year?>,<?=$GET_semana?>)
  
  }

  });
 
  function Regresar(){
  window.history.back();
  }

   //---------- SELECCIONAR SEMANAS DE LA ESTACION ----------
  function SelSemanasES(idEstacion,year,semana){
    
    sessionStorage.setItem('idestacion', idEstacion);
    sessionStorage.setItem('year', year);
    sessionStorage.setItem('semana', semana);

    $('#ListaNomina').load('../public/recibo-nomina/vistas/lista-nomina-semanas.php?idEstacion=' + idEstacion +  '&year=' + year + '&semana=' + semana);

    if(idEstacion == 2){
    $('#ListaNominaPS').load('../public/recibo-nomina/vistas/lista-nomina-semanas.php?idEstacion=' + 9 +  '&year=' + year + '&semana=' + semana);
    }

  } 

  function SelNoSemana(idEstacion,year){
    var semana = $('#SemanaEstacion').val();
    sessionStorage.setItem('semana', semana);
    $('#ListaNomina').load('../public/recibo-nomina/vistas/lista-nomina-semanas.php?idEstacion=' + idEstacion +  '&year=' + year + '&semana=' + semana);

    if(idEstacion == 2){
    $('#ListaNominaPS').load('../public/recibo-nomina/vistas/lista-nomina-semanas.php?idEstacion=' + 9 +  '&year=' + year + '&semana=' + semana);

    }

  }

  
 //---------- SELECCIONAR QUINCENAS DE LA ESTACION ----------
 function SelQuincenasES(idEstacion,year,quincena){
    sessionStorage.setItem('idestacion', idEstacion);
    sessionStorage.setItem('year', year);
    sessionStorage.setItem('quincena', quincena);
    sessionStorage.removeItem('semana');
   
    $('#ListaNomina').load('../public/recibo-nomina/vistas/lista-nomina-quincenas.php?idEstacion=' + idEstacion +  '&year=' + year + '&quincena=' + quincena);
 
  }
 

  function SelNoQuincena(idEstacion,year){

    var quincena = $('#QuincenaEstacion').val();
    sessionStorage.setItem('quincena', quincena);
    
    $('#ListaNomina').load('../public/recibo-nomina/vistas/lista-nomina-quincenas.php?idEstacion=' + idEstacion +  '&year=' + year + '&quincena=' + quincena);

  }



//---------- COMENTARIOS DEL RECIBO DE NOMINA ----------
function ModalComentario(idReporte,idEstacion,year,mes,SemQui,descripcion){
  $('#Modal').modal('show');  
  $('#DivContenido').load('../public/recibo-nomina/vistas/modal-comentarios-nomina.php?idReporte=' + idReporte + '&idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes + '&SemQui=' + SemQui + '&descripcion=' + descripcion);
}
 
 
function GuardarComentario(idReporte,idEstacion,year,mes,SemQui,descripcion){
var Comentario = $('#Comentario').val();

var parametros = {
"idReporte" : idReporte,
"Comentario" : Comentario
}; 

if(Comentario != ""){
$('#Comentario').css('border',''); 
  
$.ajax({
data:  parametros,
url:   '../public/recibo-nomina/modelo/agregar-comentario-nomina-v2.php',
type:  'post',
beforeSend: function() {
},
complete: function(){

},
success:  function (response) {

if (response == 1) {

$('#Comentario').val('');
$('#DivContenido').load('../public/recibo-nomina/vistas/modal-comentarios-nomina.php?idReporte=' + idReporte + '&idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes + '&SemQui=' + SemQui + '&descripcion=' + descripcion);

if(descripcion == "Semana"){

if(idEstacion == 9){
$('#ListaNominaPS').load('../public/recibo-nomina/vistas/lista-nomina-semanas.php?idEstacion=' + 9 +  '&year=' + year + '&semana=' + SemQui);
}else{
$('#ListaNomina').load('../public/recibo-nomina/vistas/lista-nomina-semanas.php?idEstacion=' + idEstacion +  '&year=' + year + '&semana=' + SemQui);
}

}else{
$('#ListaNomina').load('../public/recibo-nomina/vistas/lista-nomina-quincenas.php?idEstacion=' + idEstacion +  '&year=' + year + '&quincena=' + SemQui);

}


}else{
 alertify.error('Error al guardar el comentario');  
}

} 
});

}else{
$('#Comentario').css('border','2px solid #A52525'); 
}

}


//---------- EDITAR INFORMACION DEL RECIBO DE NOMINA ----------
function EditarRecibosNomina(idReporte,idEstacion,year,SemQui,descripcion){
  $('#Modal').modal('show'); 
  $('#DivContenido').load('../public/recibo-nomina/vistas/modal-editar-info-nomina.php?idReporte=' + idReporte + '&idEstacion=' + idEstacion + '&year=' + year + '&SemQui=' + SemQui + '&descripcion=' + descripcion);
 }


function EditarNominaInfo(idReporte,idEstacion,year,SemQui,descripcion,idUsuario,valPrima,valAlerta){

  var Importe = $('#Importe').val();
  var radios = document.getElementsByName('Original');
  var radios2 = document.getElementsByName('PrimaV');


  // Iterar sobre los elementos de tipo radio
  for (var i = 0; i <= radios.length; i++) {
  // Verificar si el radio está seleccionado
  if (radios[i].checked) {
  // Mostrar el valor del radio seleccionado
  var original = radios[i].value;
  break; // Salir del bucle una vez que se encuentra el radio seleccionado
  }
  }

  // Iterar sobre los elementos de tipo radio
  for (var i = 0; i <= radios2.length; i++) {
  // Verificar si el radio está seleccionado
  if (radios2[i].checked) {
  // Mostrar el valor del radio seleccionado
  var primaV = radios2[i].value;
  break; // Salir del bucle una vez que se encuentra el radio seleccionado
  }
  }

var data = new FormData(); 
var url = '../public/recibo-nomina/modelo/editar-reporte-nomina-info.php';

DocumentoAcuse = document.getElementById("DocumentoAcuse");
DocumentoAcuse_file = DocumentoAcuse.files[0];
DocumentoAcuse_filePath = DocumentoAcuse.value;

DocumentoFirma = document.getElementById("DocumentoFirma");
DocumentoFirma_file = DocumentoFirma.files[0];
DocumentoFirma_filePath = DocumentoFirma.value;


  if(Importe != ""){
  $('#Importe').css('border',''); 

  data.append('idReporte', idReporte);
  data.append('idUsuario', idUsuario);
  data.append('Importe', Importe);
  data.append('DocumentoAcuse_file', DocumentoAcuse_file);
  data.append('DocumentoFirma_file', DocumentoFirma_file);
  data.append('NominaOriginal', original);
  data.append('PrimaVacacional', primaV);
  data.append('ValorPrima', valPrima);
  data.append('ValorAlerta', valAlerta);


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
       
       if(descripcion == "Semana"){

        if(idEstacion == 9){
        $('#ListaNominaPS').load('../public/recibo-nomina/vistas/lista-nomina-semanas.php?idEstacion=' + 9 +  '&year=' + year + '&semana=' + SemQui);
        }else{
        $('#ListaNomina').load('../public/recibo-nomina/vistas/lista-nomina-semanas.php?idEstacion=' + idEstacion +  '&year=' + year + '&semana=' + SemQui);
        }

        }else{
        $('#ListaNomina').load('../public/recibo-nomina/vistas/lista-nomina-quincenas.php?idEstacion=' + idEstacion +  '&year=' + year + '&quincena=' + SemQui);

        }

       alertify.success('Registro editado exitosamente.');
     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al editar'); 
      $('#Modal').modal('hide'); 
     }
     

    }); 


  }else{
  $('#Importe').css('border','2px solid #A52525'); 
  }

}
   
//---------- PUNTAJE RECIBO DE NOMINA (KPI) ----------
function FinalizarNomina(idResponsable,idEstacion,year,mes,SemQui,descripcion){

var data = new FormData(); 
var url = '../public/recibo-nomina/modelo/finalizar-recibos-nomina.php';

alertify.confirm('',
function(){

data.append('idResponsable', idResponsable);
data.append('idEstacion', idEstacion);
data.append('year', year);
data.append('mes', mes);
data.append('SemQui', SemQui);
data.append('descripcion', descripcion);

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
  
  if(descripcion == "Semana"){
     
     if(idEstacion == 9){
     $('#ListaNominaPS').load('../public/recibo-nomina/vistas/lista-nomina-semanas.php?idEstacion=' + 9 +  '&year=' + year + '&semana=' + SemQui);
     }else{
     $('#ListaNomina').load('../public/recibo-nomina/vistas/lista-nomina-semanas.php?idEstacion=' + idEstacion +  '&year=' + year + '&semana=' + SemQui);
     }

     }else{
     $('#ListaNomina').load('../public/recibo-nomina/vistas/lista-nomina-quincenas.php?idEstacion=' + idEstacion +  '&year=' + year + '&quincena=' + SemQui);

     }

  if(idResponsable == 1){
  $('#Modal').modal('hide'); 
  }
  alertify.success('Actividad finalizada exitosamente.');

  }else{
  $(".LoaderPage").hide();
  alertify.error('Error al finalizar la actividad'); 
  
  if(idResponsable == 1){
  $('#Modal').modal('hide'); 
  }

  }
  
  }); 

},
function(){

}).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea finalizar la actividad?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
  
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
  <div id="ListaNomina" class="cardAG"></div>
  </div> 

  </div>

  </div>
  </div>
  </div>

  
  
  <div class="col-12 <?=$noneDiv?>">
  <div class="cardAG">
  <div class="border-0 p-3">

  <div class="row">
  
  <div class="col-12">
  <div id="ListaNominaPS" class="cardAG"></div>
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
      <div id="DivContenido"></div>
      </div>
    </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
