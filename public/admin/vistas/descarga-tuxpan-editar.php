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
$idEstacionD = $row_lista['id_estacion'];
$Estacion = Estacion($row_lista['id_estacion'],$con);

$fechaInput = $row_lista['fecha_llegada'];
$fechallegada = FormatoFecha($row_lista['fecha_llegada']);

$horaInput = $row_lista['hora_llegada'];
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
  window.history.back();
  }

  function EditarFormato(idFormato){

  var Fechallegada = $('#Fechallegada').val();
  var Horallegada = $('#Horallegada').val();
  var Productos = $('#Productos').val();

  var Merma = $('#Merma').val();
  var Operador = $('#Operador').val();
  var Transportista = $('#Transportista').val();

  var NoFactura = $('#NoFactura').val();
  var Litros = $('#Litros').val();
  var PrecioLitro = $('#PrecioLitro').val();
  var Unidad = $('#Unidad').val();
  var CuentaLitros = $('#CuentaLitros').val();

  FacturaRemision = document.getElementById("FacturaRemision");
  FacturaRemision_file = FacturaRemision.files[0];
  FacturaRemision_filePath = FacturaRemision.value;

  InventarioInicial = document.getElementById("InventarioInicial");
  InventarioInicial_file = InventarioInicial.files[0];
  InventarioInicial_filePath = InventarioInicial.value;

  Nice = document.getElementById("Nice");
  Nice_file = Nice.files[0];
  Nice_filePath = Nice.value;

  InventarioFinal = document.getElementById("InventarioFinal");
  InventarioFinal_file = InventarioFinal.files[0];
  InventarioFinal_filePath = InventarioFinal.value;

  MetroContador = document.getElementById("MetroContador");
  MetroContador_file = MetroContador.files[0];
  MetroContador_filePath = MetroContador.value;

  MC20Grados = document.getElementById("MC20Grados");
  MC20Grados_file = MC20Grados.files[0];
  MC20Grados_filePath = MC20Grados.value;  


    if ($('#SellosAlterados1').is(':checked')) {        
    Sellos = 'SI';
    }else{
    Sellos = 'NO';
    }

    if ($('#sdvdld1').is(':checked')) {        
    Sdvdld = 'SI';
    }else{
    Sdvdld = 'NO';
    }


    var data = new FormData();
    var url = '../public/admin/modelo/editar-descarga-tuxpan.php';

  if(Litros != ""){
  $('#Litros').css('border','');
  if(PrecioLitro != ""){
  $('#PrecioLitro').css('border','');
  if(CuentaLitros != ""){
  $('#CuentaLitros').css('border','');
  if(Merma != ""){
  $('#Merma').css('border','');
  if(Unidad != ""){
  $('#Unidad').css('border','');
  if(Operador != ""){
  $('#Operador').css('border','');
  if(Transportista != ""){
  $('#Transportista').css('border','');



  data.append('idFormato', idFormato);
  data.append('Fechallegada', Fechallegada);
  data.append('Horallegada', Horallegada);
  data.append('Productos', Productos);
  data.append('Merma', Merma);
  data.append('Operador', Operador);
  data.append('Transportista', Transportista);
  data.append('FacturaRemision_file', FacturaRemision_file);
  data.append('InventarioInicial_file', InventarioInicial_file);
  data.append('Nice_file', Nice_file);
  data.append('InventarioFinal_file', InventarioFinal_file);
  data.append('MetroContador_file', MetroContador_file);
  data.append('MC20Grados_file', MC20Grados_file);
  data.append('Sellos', Sellos);
  data.append('Sdvdld', Sdvdld);

  data.append('NoFactura', NoFactura);
  data.append('Litros', Litros);
  data.append('PrecioLitro', PrecioLitro);
  data.append('Unidad', Unidad);
  data.append('CuentaLitros', CuentaLitros);

  
  $(".LoaderPage").show();

    $.ajax({
    url: url,
    type: 'POST',
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(data){

    $(".LoaderPage").hide();
    Regresar();

    });


  }else{
  $('#Transportista').css('border','2px solid #A52525'); 
  alertify.error('Faltan transportista');  
  }
  }else{
  $('#Operador').css('border','2px solid #A52525'); 
  alertify.error('Faltan operador');  
  }
  }else{
  $('#Unidad').css('border','2px solid #A52525'); 
  alertify.error('Faltan unidad');
  }
  }else{
  $('#Merma').css('border','2px solid #A52525'); 
  alertify.error('Faltan merma');
  }
  }else{
  $('#CuentaLitros').css('border','2px solid #A52525'); 
  alertify.error('Faltan el cuenta litros');
  }
  }else{
  $('#PrecioLitro').css('border','2px solid #A52525'); 
  alertify.error('Faltan el precio por litro');
  }
  }else{
  $('#Litros').css('border','2px solid #A52525'); 
  alertify.error('Faltan los litros');
  }

  }
 

  function mermaLts(e,num){
  
  var valor = e.value;
  var LitrosInput = $('#Litros').val();
  var CuentaLitrosInput = $('#CuentaLitros').val();

  if(num == 1){
  var merma =  valor - CuentaLitrosInput;
  $('#Merma').val(merma);

  }else if(num == 2){

  var merma2 =  LitrosInput - valor;
  $('#Merma').val(merma2);

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
    <div class="col-10">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">

     <h5>Editar formato de descarga merma</h5>
    
    </div>
    </div>

    </div>

    <div class="col-2">
    <span class="badge rounded-pill tables-bg float-end" style="font-size:14px">Folio: 00<?=$folio;?></span>
    </div>


    </div>

  <hr> 

<div class="row">

    <div class="col-12 col-sm-6 mb-2">
    <div class="text-secondary mb-1">Estación de descarga:</div>
    <select class="form-control" id="Estacion" disabled>
    <option value="<?=$idEstacionD;?>"><?=$Estacion;?></option>
    </select>
  </div>


    <div class="col-12 col-sm-6 mb-2">
    <div class="text-secondary mb-1">Responsable de la estación:</div>
    <div id="Personal">
    <select class="form-control" id="Responsable" disabled>
    <option value="<?=$idUsuario;?>"><?=$Personal;?></option>
    </select>
    </div>
  </div>

  <div class="col-12 mb-2">
  <div class="text-secondary mb-1">Fecha y hora de llegada de full:</div>
  <div class="row">
  <div class="col-12 col-sm-6 mb-2">
  <input type="date" class="form-control" id="Fechallegada" value="<?=$fechaInput;?>"> 
  </div>

  <div class="col-12 col-sm-6 mb-2">
  <input type="time" class="form-control" id="Horallegada" value="<?=$horaInput;?>"> 
  </div>
  </div>
  </div>


  <div class="col-12 col-sm-6 mb-2">
  <div class="text-secondary mb-1">Productos recibido:</div>
  <select class="form-select" id="Productos">
    <option><?=$producto;?></option>

    <?php
    if($producto == "87 oct"){
      $ocultar87 = "d-none";
    }

    if($producto == "91 oct"){
      $ocultar91 = "d-none";
    }

    if($producto == "Diesel"){
    $ocultarD = "d-none";
    }

    ?>

    <option class="<?=$ocultar87?>">87 oct</option>
    <option class="<?=$ocultar91?>">91 oct</option>
    <option class="<?=$ocultarD?>">Diesel</option>
  </select>
  </div>


  <div class="col-12 col-sm-6 mb-2">
  <div class="text-secondary mb-1">Numero Factura o Remisión:</div>
  <input type="text" class="form-control" id="NoFactura" value="<?=$nofacturaremision;?>">
  </div>

  <div class="col-12 col-sm-6 mb-2">
  <div class="text-secondary mb-1">Litros:</div>
  <input type="number" class="form-control" id="Litros" value="<?=$litros?>" onkeyup="mermaLts(this,1)">   
  </div>

  <div class="col-12 col-sm-6 mb-2">
  <div class="text-secondary mb-1">Precio por litro:</div>
  <input type="number" class="form-control" id="PrecioLitro" value="<?=$preciolitro;?>">  
  </div>

  <div class="col-12 col-sm-6 mb-2">
  <div class="text-secondary mb-1">Cuenta litro:</div>
  <input type="number" class="form-control" id="CuentaLitros" value="<?=$cuentalitros;?>" onkeyup="mermaLts(this,2)">   
  </div>


  <div class="col-12 col-sm-6 mb-2">
  <div class="text-secondary mb-1">Anexar merma en Litros:</div>
  <input type="number" class="form-control" id="Merma" value="<?=$merma;?>" disabled>
  </div> 


  <div class="col-12 col-sm-6 mb-2">
  <div class="text-secondary mb-1">Unidad:</div>
  <input type="text" class="form-control" id="Unidad" value="<?=$unidad;?>">
  </div>

  <div class="col-12 col-sm-6 mb-2">
  <div class="text-secondary mb-1">Nombre del operador de la unidad:</div>
  <input type="text" class="form-control" id="Operador" value="<?=$operador;?>">
  </div>

  <div class="col-12 col-sm-6 mb-2">
  <div class="text-secondary mb-1">Compañía de Transportista:</div>
  <input type="text" class="form-control" id="Transportista" value="<?=$transportista;?>">
  </div>

  <div class="col-12 col-sm-6 mb-2">
  <div class="text-secondary mb-1">Factura o Remisión:</div>
  <input type="file" class="form-control" id="FacturaRemision">
  </div>


  <div class="col-12 col-sm-6 mb-2">
  <div class="text-secondary mb-1">Sellos alterados:</div>
 
  <?php
  if($sellos == "SI"){
  $checkSellosSI = "checked";  
  }

  if($sellos == "NO"){
  $checkSellosNO = "checked";     
  }

  ?>

  <div class="form-check">
  <input class="form-check-input" type="radio" name="Radios1" id="SellosAlterados1" style="width: 18px; height: 18px;margin-top: 4px;" <?=$checkSellosSI;?>>
  <label class="form-check-label" for="SellosAlterados1" style="margin-left: 10px;">
    SI
  </label>
  </div>

  <div class="form-check">
  <input class="form-check-input" type="radio" name="Radios1" id="SellosAlterados2" style="width: 18px; height: 18px;margin-top: 4px;" <?=$checkSellosNO;?>>
  <label class="form-check-label" for="SellosAlterados2" style="margin-left: 10px;">
    NO
  </label>
  </div>
  </div>


  <div class="col-12 col-sm-6 mb-2">
  <div class="text-secondary mb-1">Se detuvo venta durante la descarga:</div>

  <?php
  if($detuvoventa == "SI"){
  $checkDescargaSI = "checked";  
  }

  if($detuvoventa == "NO"){
  $checkDescargaNO = "checked";     
  }

  ?>

  <div class="form-check">
    <input class="form-check-input" type="radio" name="Radios2" id="sdvdld1" style="width: 18px; height: 18px;margin-top: 4px;" <?=$checkDescargaSI;?>>
    <label class="form-check-label" for="sdvdld1" style="margin-left: 10px;">
      SI
    </label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="radio" name="Radios2" id="sdvdld2" style="width: 18px; height: 18px;margin-top: 4px;" <?=$checkDescargaNO;?>>
    <label class="form-check-label" for="sdvdld2" style="margin-left: 10px;">
      NO
    </label>
  </div>
  </div>



  <div class="col-12 col-sm-6 mb-2">
  <div class="text-secondary mb-1">Reporte de inventario Inicial con fecha y hora:</div>
  <input type="file" class="form-control" id="InventarioInicial">
  </div>

  <div class="col-12 col-sm-6 mb-2">
  <div class="text-secondary mb-1">Medida Nice:</div>
  <input type="file" class="form-control" id="Nice">
  </div>

  <div class="col-12 col-sm-6 mb-2">
  <div class="text-secondary mb-1">Reporte de inventario final con fecha y hora:</div>
  <input type="file" class="form-control" id="InventarioFinal">
  </div>

  <div class="col-12 col-sm-6 mb-2">
  <div class="text-secondary mb-1">Metro contador temperatura normal:</div>
  <input type="file" class="form-control" id="MetroContador">
  </div>


  <div class="col-12 col-sm-6 mb-2">
  <div class="text-secondary mb-1">Metro contador a 20 grados:</div>
  <input type="file" class="form-control" id="MC20Grados">
  </div>



</div>


  </div>
  </div>

  </div>

  <!----- FIRMAS ----->
  <div class="col-12 mb-3">
  <div class="cardAG">
  <div class="border-0 p-3"> 

  <div class="row">
  <div class="col-12"> 
  <h5>Firmas</h5>
  <hr> 
  </div>
  </div>

<div class="row justify-content-md-center">
<?php

$sql_firma = "SELECT * FROM op_descarga_tuxpa_firma WHERE id_descarga = '".$GET_idReporte."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

echo '<div class="col-12 col-sm-4 mt-2 mb-1">';
echo '<div class="mb-2 text-center"><b>'.$row_firma['tipo_firma'].'</b></div>';
echo '<div class="border p-1 text-center"><img src="'.RUTA_IMG.'firma-tuxpan/'.$row_firma['imagen_firma'].'" width="100%"></div>';
echo '</div>';
}

?> 
</div>

  <hr>

  <div class="row al">
  <div class="col-12">
  <button class="btn btn-success btn-block p-2 mb-2 mt-2 float-end" onclick="EditarFormato(<?=$GET_idReporte?>)">Editar y Finalizar</button>
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
