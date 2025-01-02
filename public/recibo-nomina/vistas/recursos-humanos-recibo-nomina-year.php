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
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  
  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">
  <script type="text/javascript" src="<?=RUTA_JS ?>alertify.js"></script> 

  <script type="text/javascript">
  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  sizeWindow();

  if(sessionStorage){ 
  if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion')) {

  idEstacion = sessionStorage.getItem('idestacion');
  year = sessionStorage.getItem('year');
  last = sessionStorage.getItem('last');

  if(idEstacion == 1 || idEstacion == 2 || idEstacion == 3 || idEstacion == 4 || idEstacion == 5 || idEstacion == 9 || idEstacion == 14){
  semana = sessionStorage.getItem('semana');
  sessionStorage.removeItem('quincena');
  SelSemanasES(idEstacion,year,semana,last);

  }else{
  quincena = sessionStorage.getItem('quincena');
  sessionStorage.removeItem('semana');
  SelQuincenasES(idEstacion,year,quincena,last);   
  }
  
  }   
     
  } 
 
  });  
 
  function Regresar(){
  sessionStorage.removeItem('idestacion');
  sessionStorage.removeItem('year');
  sessionStorage.removeItem('semana');
  sessionStorage.removeItem('quincena');
  sessionStorage.removeItem('last');
  sessionStorage.removeItem('scrollTop');
  window.history.back();
  }

  function EvaluacionNomina(year){
  sessionStorage.removeItem('idestacion');
  sessionStorage.removeItem('year');
  sessionStorage.removeItem('semana');
  sessionStorage.removeItem('last');
  sessionStorage.removeItem('scrollTop');
  window.location.href = "../recursos-humanos-recibos-nomina-evaluacion/" + year;
  }

  function RevisionNomina(year){
  sessionStorage.removeItem('idestacion');
  sessionStorage.removeItem('year');
  sessionStorage.removeItem('semana');
  sessionStorage.removeItem('quincena');
  sessionStorage.removeItem('last');
  sessionStorage.removeItem('scrollTop');
  window.location.href = "../recursos-humanos-recibos-nomina-revision/" + year;
  }


  //---------- SELECCIONAR SEMANAS DE LA ESTACION ----------
  function SelSemanasES(idEstacion,year,semana,last){

  function initializeDataTable(tableId) {
  sizeWindow();
  sessionStorage.setItem('idestacion', idEstacion);
  sessionStorage.setItem('year', year);
  sessionStorage.setItem('semana', semana);
  sessionStorage.setItem('last', last);
  sessionStorage.removeItem('quincena');

  let targets;
  
  if(last != semana){

  if(<?=$Session_IDUsuarioBD?> == 19 || <?=$Session_IDUsuarioBD?> == 318){
  targets = [6,7,8,9];
  }else if(<?=$Session_IDUsuarioBD?> == 354){
  targets = [5,6,7,8,9];
  }else{
  targets = [5,6,7,8];
  }

  }else{



  if(<?=$Session_IDUsuarioBD?> == 19 || <?=$Session_IDUsuarioBD?> == 318){
  targets = [6,7,8,9,10];
  }else if(<?=$Session_IDUsuarioBD?> == 354){
  targets = [5,6,7,8,9,10];
  }else{
  targets = [5,6,7,8,9];
  }

  }


  $('#ListaNomina').load('../public/recibo-nomina/vistas/lista-nomina-semanas.php?idEstacion=' + idEstacion +  '&year=' + year + '&semana=' + semana, function() {
    // Clonar y remover las filas antes de inicializar DataTables
    var $lastRows = $('#' + tableId + ' .ultima-fila').clone();
    $('#' + tableId + ' .ultima-fila').remove();

    $('#' + tableId).DataTable({
      "stateSave": true,
      "language": {
        "url": "<?=RUTA_JS2?>/es-ES.json"
      },
      "order": [[0, "asc"]],
      "lengthMenu": [25, 50, 75, 100],
      "columnDefs": [
        { "orderable": false, "targets": targets },
        { "searchable": false, "targets": targets }
      ],
      "drawCallback": function(settings) {
        // Remover cualquier fila 'ultima-fila' existente para evitar duplicados
        $('#' + tableId + ' .ultima-fila').remove();
        // Añadir las filas clonadas al final del tbody
        $('#' + tableId + ' tbody').append($lastRows.clone());
      }
    });
  });
  }

  initializeDataTable('tabla_nomina_semana_' + idEstacion);
  }


  function SelNoSemana(idEstacion,year,last){
  sizeWindow();
  var semana = $('#SemanaEstacion_' + idEstacion).val();
  sessionStorage.setItem('semana', semana);

  SelSemanasES(idEstacion,year,semana,last)
  }


  //---------- SELECCIONAR QUINCENAS DE LA ESTACION ----------
  function SelQuincenasES(idEstacion,year,quincena,last){
    
  function initializeDataTableQ(tableId) {
  sizeWindow();
  sessionStorage.setItem('idestacion', idEstacion);
  sessionStorage.setItem('year', year);
  sessionStorage.setItem('quincena', quincena);
  sessionStorage.removeItem('last');
  sessionStorage.removeItem('semana');

  let targets;
  if(last != quincena){

  if(<?=$Session_IDUsuarioBD?> == 19 || <?=$Session_IDUsuarioBD?> == 318){
  targets = [6,7,8,9];
  }else if(<?=$Session_IDUsuarioBD?> == 354){
  targets = [5,6,7,8,9];
  }else{
  targets = [5,6,7,8];
  }

  }else{



  if(<?=$Session_IDUsuarioBD?> == 19 || <?=$Session_IDUsuarioBD?> == 318){
  targets = [6,7,8,9,10];
  }else if(<?=$Session_IDUsuarioBD?> == 354){
  targets = [5,6,7,8,9,10];
  }else{
  targets = [5,6,7,8,9];
  }

  }

  $('#ListaNomina').load('../public/recibo-nomina/vistas/lista-nomina-quincenas.php?idEstacion=' + idEstacion +  '&year=' + year + '&quincena=' + quincena, function() {
    // Clonar y remover las filas antes de inicializar DataTables
    var $lastRows = $('#' + tableId + ' .ultima-fila').clone();
    $('#' + tableId + ' .ultima-fila').remove();

    $('#' + tableId).DataTable({
      "stateSave": true,
      "language": {
        "url": "<?=RUTA_JS2?>/es-ES.json"
      },
      "order": [[0, "asc"]],
      "lengthMenu": [25, 50, 75, 100],
      "columnDefs": [
        { "orderable": false, "targets": targets },
        { "searchable": false, "targets": targets }
      ],
      "drawCallback": function(settings) {
        // Remover cualquier fila 'ultima-fila' existente para evitar duplicados
        $('#' + tableId + ' .ultima-fila').remove();
        // Añadir las filas clonadas al final del tbody
        $('#' + tableId + ' tbody').append($lastRows.clone());
      }
    });
  });
  }

  initializeDataTableQ('tabla_nomina_quincena_' + idEstacion);
  }


 

  function SelNoQuincena(idEstacion,year,last){
  sizeWindow();
  var quincena = $('#QuincenaEstacion_' + idEstacion).val();
  sessionStorage.setItem('quincena', quincena);

  SelQuincenasES(idEstacion,year,quincena,last)
  }


  //---------- ACUSES AGUINALDO DE NOMINA DEL PERSONAL ----------
  function AguinaldosNomina(idEstacion,year,mes,SemQui,descripcion,last){
  $('#Modal').modal('show');  
  $('#DivContenido').load('../public/recibo-nomina/vistas/modal-acuses-aguinaldo.php?idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes + '&SemQui=' + SemQui + '&descripcion=' + descripcion + '&last=' + last);
  }


  function SubirAguinaldos(idAcuse,idEstacion,year,mes,SemQui,descripcion,last){
  
  var AcuseNomina = $('#DocumentoAcuse').val();
  var data = new FormData(); 
  var url = '../public/recibo-nomina/modelo/subir-acuse-aguinaldo-mexdesa.php';

  DocumentoAcuse = document.getElementById("DocumentoAcuse");
  DocumentoAcuse_file = DocumentoAcuse.files[0];
  DocumentoAcuse_filePath = DocumentoAcuse.value;

  if(AcuseNomina != ""){
  $('#DocumentoAcuse').css('border',''); 

  data.append('idAcuse', idAcuse);
  data.append('idEstacion', idEstacion);
  data.append('year', year);
  data.append('mes', mes);
  data.append('SemQui', SemQui);
  data.append('descripcion', descripcion);
  data.append('DocumentoAcuse_file', DocumentoAcuse_file);

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
  sizeWindow() 
  $('#DivContenido').load('../public/recibo-nomina/vistas/modal-acuses-aguinaldo.php?idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes + '&SemQui=' + SemQui + '&descripcion=' + descripcion + '&last=' + last);
  alertify.success('Archivo agregado exitosamente.');

  }else{
  $(".LoaderPage").hide();
  alertify.error('Error al cargar el archivo'); 
  $('#Modal').modal('hide'); 

  }
    
  }); 

  }else{
  $('#DocumentoAcuse').css('border','2px solid #A52525'); 
  }
 
  }

  function FinalizarAguinaldo(idAguinaldo,idEstacion,year,mes,SemQui,descripcion,last){

  var data = new FormData(); 
  var url = '../public/recibo-nomina/modelo/finalizar-aguinaldos.php';

  alertify.confirm('',
  function(){

  data.append('idAguinaldo', idAguinaldo);
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
  sizeWindow() 
    
  if(descripcion == "Semana"){
  SelSemanasES(idEstacion,year,SemQui,last);

  }else{
  SelQuincenasES(idEstacion,year,SemQui,last);

  }

  $('#Modal').modal('hide'); 
  alertify.success('Actividad finalizada exitosamente.');

  }else{
  $(".LoaderPage").hide();
  alertify.error('Error al finalizar la actividad'); 

  }
    
  }); 

  },
  function(){
  }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea finalizar la actividad?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
    
  }


  //---------- ACUSES DE RECIBO DE NOMINA DEL PERSONAL ----------
  function AcusesNomina(idEstacion,year,mes,SemQui,descripcion,last){
  $('#Modal').modal('show');  
  $('#DivContenido').load('../public/recibo-nomina/vistas/modal-acuses-nomina.php?idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes + '&SemQui=' + SemQui + '&descripcion=' + descripcion  + '&last=' + last);
  }

  function SubirAcusesNomina(idAcuse,idEstacion,year,mes,SemQui,descripcion,last){
  
  var AcuseNomina = $('#DocumentoAcuse').val();
  var data = new FormData(); 
  var url = '../public/recibo-nomina/modelo/subir-acuse-nomina-mexdesa.php';

  DocumentoAcuse = document.getElementById("DocumentoAcuse");
  DocumentoAcuse_file = DocumentoAcuse.files[0];
  DocumentoAcuse_filePath = DocumentoAcuse.value;

  if(AcuseNomina != ""){
  $('#DocumentoAcuse').css('border',''); 

  data.append('idAcuse', idAcuse);
  data.append('idEstacion', idEstacion);
  data.append('year', year);
  data.append('mes', mes);
  data.append('SemQui', SemQui);
  data.append('descripcion', descripcion);
  data.append('DocumentoAcuse_file', DocumentoAcuse_file);

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
  sizeWindow() 
  $('#DivContenido').load('../public/recibo-nomina/vistas/modal-acuses-nomina.php?idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes + '&SemQui=' + SemQui + '&descripcion=' + descripcion  + '&last=' + last);
  alertify.success('Archivo agregado exitosamente.');

  }else{
  $(".LoaderPage").hide();
  alertify.error('Error al cargar el archivo'); 
  $('#Modal').modal('hide'); 

  }
    
  }); 

  }else{
  $('#DocumentoAcuse').css('border','2px solid #A52525'); 
  }
 
  }


  //---------- COMENTARIOS DEL RECIBO DE NOMINA ----------
  function ModalComentario(idReporte,idEstacion,year,mes,SemQui,descripcion,last){
  $('#ModalComentario').modal('show');  
  $('#DivContenidoComentario').load('../public/recibo-nomina/vistas/modal-comentarios-nomina.php?idReporte=' + idReporte + '&idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes + '&SemQui=' + SemQui + '&descripcion=' + descripcion + '&last=' + last);
  }
 
  function GuardarComentario(idReporte,idEstacion,year,mes,SemQui,descripcion,last){
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
    ModalComentario(idReporte,idEstacion,year,mes,SemQui,descripcion,last)
  if(descripcion == "Semana"){
  SelSemanasES(idEstacion,year,SemQui,last);

  }else{
  SelQuincenasES(idEstacion,year,SemQui,last);

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
  function EditarRecibosNomina(idReporte,idEstacion,year,SemQui,descripcion,last){
  $('#Modal').modal('show'); 
  $('#DivContenido').load('../public/recibo-nomina/vistas/modal-editar-info-nomina.php?idReporte=' + idReporte + '&idEstacion=' + idEstacion + '&year=' + year + '&SemQui=' + SemQui + '&descripcion=' + descripcion  + '&last=' + last);
  }


  function EditarNominaInfo(idReporte,idEstacion,year,SemQui,descripcion,idUsuario,valPrima,valAlerta,last){

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

  DocumentoAguinaldo = document.getElementById("DocumentoAguinaldo");
  DocumentoAguinaldo_file = DocumentoAguinaldo.files[0];
  DocumentoAguinaldo_filePath = DocumentoAguinaldo.value;
 
  if(Importe != ""){
  $('#Importe').css('border','');  

  data.append('idReporte', idReporte);
  data.append('idUsuario', idUsuario);
  data.append('Importe', Importe);
  data.append('DocumentoAcuse_file', DocumentoAcuse_file);
  data.append('DocumentoFirma_file', DocumentoFirma_file);
  data.append('DocumentoAguinaldo_file', DocumentoAguinaldo_file);
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
  SelSemanasES(idEstacion,year,SemQui,last);

  }else{
  SelQuincenasES(idEstacion,year,SemQui,last);

  }

  sizeWindow()
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
  function FinalizarNomina(idResponsable,idEstacion,year,mes,SemQui,descripcion,last){

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
  sizeWindow() 
    
  if(descripcion == "Semana"){
  SelSemanasES(idEstacion,year,SemQui,last);

  }else{
  SelQuincenasES(idEstacion,year,SemQui,last);

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

  <!---------- CONTENIDO Y BARRA DE NAVEGACION ---------->
  <div class="wrapper"> 
  <!---------- BARRA DE NAVEGACION ---------->
  <nav id="sidebar">
           
  <div class="sidebar-header text-center"> <img class="" src="<?=RUTA_IMG_LOGOS."Logo.png";?>" style="width: 100%;"> </div>

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

  <?php if ($Session_IDUsuarioBD == 19 || $Session_IDUsuarioBD == 318) { ?>

  <li>
  <a class="pointer" onclick="EvaluacionNomina(<?=$GET_year?>)">
  <i class="fa-solid fa-chart-pie" aria-hidden="true" style="padding-right: 10px;"></i>
  <b>Evaluación (KPI's)</b>
  </a>
  </li>
 
    
  <li>
  <a class="pointer" onclick="RevisionNomina(<?=$GET_year?>)">
  <i class="fa-solid fa-eye" aria-hidden="true" style="padding-right: 10px;"></i>
  <b>Revisión</b>
  </a>
  </li>

  <?php
  }

  function UltimaSemanaYear($year) {
    // Crear un objeto para el 31 de diciembre del año dado
    $ultimoDia = new DateTime("$year-12-31");
         
    // Si el día no pertenece al año ISO actual (ej. cae en la semana 1 del siguiente año)
    if ($ultimoDia->format('W') == '01') {
    // Retroceder una semana para obtener la última semana del año actual
    $ultimoDia->modify('-1 week');
    }
         
    return $ultimoDia->format(format: 'W');
    }

  $sql_listaestacion = "SELECT id, numlista, localidad FROM op_rh_localidades WHERE numlista <= 8 OR numlista = 10 OR numlista = 12 OR numlista = 14 OR numlista = 15 OR numlista = 16 OR numlista = 17 ORDER BY numlista ASC";

  $result_listaestacion = mysqli_query($con, $sql_listaestacion);
  while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
  $id = $row_listaestacion['id'];
  $estacion = $row_listaestacion['localidad'];

  if($id == 1 || $id == 2 || $id == 3 || $id == 4 || $id == 5 || $id == 9 || $id == 14){
  // Obtener la fecha actual
  $currentDate = time(); // Puedes usar una fecha específica con strtotime() si lo deseas

  // Calcular el número de día de la semana (de 1 a 7, donde 4 es jueves y 3 es miércoles)
  $diaSemana = date('N', $currentDate);

  // Si la semana termina el miércoles, ajustamos la fecha para obtener el inicio de la semana
  if ($diaSemana >= 4) {
  $inicioSemana = strtotime('last Wednesday', $currentDate);
  } else {
  $inicioSemana = strtotime('Wednesday last week', $currentDate);
  }

  // Obtener el número de semana actual considerando que la semana comienza el jueves (4)
  $GET_semana = date('W', $inicioSemana);

    
  $UltimaSemanaYear =  UltimaSemanaYear($GET_year);

  $SelEstacion = "onclick='SelSemanasES(".$id.",".$GET_year.",".$GET_semana.",".$UltimaSemanaYear.")'";

  }else{
   
  // Obtener el número del día en el año actual
  $numeroDiaAnio = date('z') + 1; // Se agrega 1 ya que 'z' cuenta desde 0
  // Calcular el número de quincena
  $GET_quincena = ceil($numeroDiaAnio / 15); // Redondear hacia arriba para obtener el número de quincena
  $SelEstacion = "onclick='SelQuincenasES(".$id.",".$GET_year.",".$GET_quincena.",24)'";

  } 

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

  }else if($estacion == "Dirección de operaciones" || $estacion == "Departamento Gestión" || $estacion == "Departamento Jurídico" ||
  $estacion == "Departamento Mantenimiento" || $estacion == "Departamento Sistemas"){
  $icon = "fa-solid fa-briefcase"; 

  }else{
  $icon = "fa-solid fa-gas-pump";    
  }

  echo '  
  <li class="'.$ocultarDiv.'">
  <a class="pointer" '.$SelEstacion.'> <i class="'.$icon.'" aria-hidden="true" style="padding-right: 10px;"></i> '.$estacion.'</a>
  </li>';

  }
  ?> 

  </ul>
  </nav>

  <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
  <nav class="navbar navbar-expand navbar-light navbar-bg" >
  
  <i class="fa-solid fa-bars menu-btn rounded pointer" id="sidebarCollapse"></i>

  <div class="pointer"> <a class="text-dark" onclick="history.back()">Recursos humanos </a> </div>
 
  <div class="navbar-collapse collapse">
  <div class="dropdown-divider"></div>

  <ul class="navbar-nav navbar-align">

  <li class="nav-item dropdown">
  <a class=" dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown"> <i class="align-middle" data-feather="settings"></i></a>

  <a class="nav-link dropdown-toggle d-none d-sm-inline-block pointer" data-bs-toggle="dropdown">
  <img src="<?=RUTA_IMG_ICONOS."usuarioBar.png";?>" class="avatar img-fluid rounded-circle"/>
  <span class="text-dark" style="padding-left: 10px;"><?=$session_nompuesto;?></span>
  </a>
  
  <div class="dropdown-menu dropdown-menu-end">
  
  <div class="user-box">
  <div class="u-text"> <p class="text-muted">Nombre de usuario:</p> <h4><?=$session_nomusuario;?></h4></div>
  </div>

  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="<?=PERFIL_ADMIN?>"> <i class="fa-solid fa-user" style="padding-right: 5px;"></i>Perfil</a>
 
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="<?=RUTA_SALIR2?>salir"><i class="fa-solid fa-power-off" style="padding-right: 5px;"></i> Cerrar Sesión</a>
  </div>

  </li>
  </ul>
  </div>

  </nav>
 
  <!---------- CONTENIDO PAGINA WEB----------> 
  <div class="contendAG">
  <div class="row">  
  
  <div class="col-12" id="ListaNomina"> </div> 

  </div>
  </div>

  </div>
  </div>

  <!---------- MODAL ----------> 
  <div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content" id="DivContenido">
  </div>
  </div>
  </div>

   <!---------- MODAL COMENTARIO----------> 
   <div class="modal fade" id="ModalComentario" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
  <div class="modal-content" id="DivContenidoComentario">
  </div>
  </div>
  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>


</body>
</html>