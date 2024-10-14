<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

function Estacion($idEstacion,$con){
$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}
return $estacion;
}

function Responsable($idUsuario,$con){
$sql_usuario = "SELECT 
tb_usuarios.nombre AS nombreUSU,
tb_estaciones.nombre AS nombrebreES
FROM tb_usuarios
INNER JOIN tb_estaciones
on tb_usuarios.id_gas = tb_estaciones.id
WHERE tb_usuarios.id = '".$idUsuario."'";

$result_usuario = mysqli_query($con, $sql_usuario);
while($row_usuario = mysqli_fetch_array($result_usuario, MYSQLI_ASSOC)){
$usuario = $row_usuario['nombreUSU'];
$estacion = $row_usuario['nombrebreES'];
}
    $array = array('nombreUSU' => $usuario, 'nombrebreES' => $estacion);
    return $array;
}


$sql_lista = "SELECT * FROM op_rh_permisos WHERE id = '".$GET_idReporte."' ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$idestacion = $row_lista['id_estacion'];
$idpersonal = $row_lista['id_personal'];

$Estacion = Estacion($idestacion,$con);
$Responsable = Responsable($idpersonal,$con);
$nameUSUR = $Responsable['nombreUSU'];

$diastomados = $row_lista['dias_tomados'];
$observaciones = $row_lista['observaciones'];
$FechaInicio = $row_lista['fecha_inicio'];
$FechaTermino = $row_lista['fecha_termino'];
$Motivo = $row_lista['motivo'];

$idComodin = $row_lista['cubre_turno'];
$Comodin = Responsable($idComodin,$con);

$nameUSU = $Comodin['nombreUSU'];
$nameES = $Comodin['nombrebreES'];

}

function Personal($idusuario,$con){
$sql = "SELECT nombre FROM tb_usuarios WHERE id = '".$idusuario."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
} 

function FirmaSC($idReporte,$tipoFirma,$con){
$sql_lista = "SELECT * FROM op_rh_permisos_firma WHERE id_permiso = '".$idReporte."' AND tipo_firma = '".$tipoFirma."' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
}

$firmaB = FirmaSC($GET_idReporte,'B',$con);
$firmaC = FirmaSC($GET_idReporte,'C',$con);

?>

<html lang="es">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Departamento Operativo</title>
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
  <script type="text/javascript" src="<?php echo RUTA_JS ?>signature_pad.js"></script>

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");

    });

  function Regresar(){
  window.history.back();
  }

  function CrearToken(idReporte,idVal){

  $(".LoaderPage").show();

  var parametros = {
    "idReporte" : idReporte,
    "idVal" : idVal
    };

    $.ajax({
    data:  parametros,
    url:   '../public/recursos-humanos/modelo/token-permiso.php',
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
    })
 
  } 

      function FirmarPermiso(idReporte,tipoFirma){

    var TokenValidacion = $('#TokenValidacion').val();

    var parametros = {
    "idReporte" : idReporte,
    "tipoFirma" : tipoFirma,
    "TokenValidacion" : TokenValidacion
    };

  if(TokenValidacion != ""){
  $('#TokenValidacion').css('border',''); 

    $(".LoaderPage").show();

      $.ajax({
    data:  parametros,
    url:   '../public/recursos-humanos/modelo/firmar-permiso.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    }, 
    success:  function (response) {

    $(".LoaderPage").hide();

    if(response == 1){

    $('#ModalFinalizado').modal('show'); 

    }else{
     $('#ModalError').modal('show');
     alertify.error('Error al firmar el permiso');
    }

    }
    });

  }else{
  $('#TokenValidacion').css('border','2px solid #A52525'); 
  }

  }

  function Firmar(idReporte,tipoFirma){

  var data = new FormData();
  var url = '../public/recursos-humanos/modelo/agregar-permisos.php';  

  var ctx = document.getElementById("canvas");
  var image = ctx.toDataURL();
  document.getElementById('base64').value = image;
  var base64 = $('#base64').val();

  data.append('tipo',  3);
  data.append('idReporte', idReporte);
  data.append('tipoFirma', tipoFirma);
  data.append('base64', base64);

   $.ajax({
    url: url,
    type: 'POST',
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(data){

    if(data == 1){
      Regresar();
     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al crear el permiso'); 
     }
     
    });

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
    <h5>Firmar Permiso </h5>
    </div>

    </div>

    </div>

    </div>

  <hr>

  <div class="row">
    
  <div class="col-12">  
  <div class="row">
    
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
      <small class="text-secondary">Estación:</small>
      <h5><?=$Estacion;?></h5>
    </div>

    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
      <small class="text-secondary">Colaborador:</small>
      <h5><?=$nameUSUR;?></h5>
    </div>

    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
      <small class="text-secondary">Días tomados:</small>
      <h5><?=$diastomados;?></h5>
    </div>
  
  </div>
  </div>


  <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
  <div class="row">

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
      <small class="text-secondary">Del:</small>
      <h5><?=FormatoFecha($FechaInicio);?></h5>
    </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
      <small class="text-secondary">Hasta:</small>
      <h5><?=FormatoFecha($FechaTermino);?></h5>
    </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
          <small class="text-secondary">Motivo:</small>
      <h5><?=$Motivo;?></h5>
    </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
      <small class="text-secondary">Observaciones:</small>
      <h5><?=$observaciones;?></h5>
    </div>

  </div>
  </div>


  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
  <div class="row">
   
    <div class="col-12">
      <small class="text-secondary">Estacion de quien cubre:</small>
      <h5><?=$nameES;?></h5>
    </div>

    <div class="col-12">
      <small class="text-secondary">Quien cubre:</small>
      <h5><?=$nameUSU;?></h5>
    </div>



  </div>
  </div>

  </div>



<hr> 

<div class="row">

<?php

$sql_firma = "SELECT * FROM op_rh_permisos_firma WHERE id_permiso = '".$GET_idReporte."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$explode = explode(' ', $row_firma['fecha']);

if($row_firma['tipo_firma'] == "A"){
$TipoFirma = "NOMBRE Y FIRMA DEL QUE SOLICITA";
$Detalle = '<div class="border p-1 text-center"><img src="../imgs/firma/'.$row_firma['firma'].'" width="70%"></div>';


}else if($row_firma['tipo_firma'] == "B"){
$TipoFirma = "NOMBRE Y FIRMA DEL QUE CUBRE";
$Detalle = '<div class="border p-1 text-center"><img src="../imgs/firma/'.$row_firma['firma'].'" width="70%"></div>';

}else if($row_firma['tipo_firma'] == "C"){
$TipoFirma = "NOMBRE Y FIRMA DE VoBo";
$Detalle = '<div class="border-bottom text-center p-3"><small>La solicitud de permiso se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';


}

echo '<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">';
echo '<div class="border p-3">';
echo '<div class="text-center">'.Personal($row_firma['id_usuario'],$con).' <hr> </div>';
echo $Detalle;
echo '<h6 class="mt-2 text-secondary text-center">'.$TipoFirma.'</h6>';
echo '</div>';
echo '</div>';
}

?>


<?php
if($firmaB == 0){
if($Session_IDUsuarioBD == $idComodin){
?>
<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12"> 
<div class="border p-3">
          <div class="mb-2 text-secondary text-center">FIRMA DEL PERSONAL QUE CUBRE</div>
          <hr>
          <div id="signature-pad" class="signature-pad mt-2" >
          <div class="signature-pad--body">
          <canvas style="width: 100%; height: 150px; border: 1px black solid;" id="canvas"></canvas>
          </div>
          <input type="hidden" name="base64" value="" id="base64">
          </div> 
          <div class="text-end mt-2">
          <button class="btn btn-info btn-sm text-white" onclick="resizeCanvas()"><small>Limpiar</small></button>
          </div>
          <hr>

          <div class="text-end">
          <button class="btn btn-primary text-white" onclick="Firmar(<?=$GET_idReporte;?>,'B')"><small>Agregar Firma</small></button>
          </div>
</div>
</div>


<?php
}else if($Session_IDUsuarioBD == 318){

echo '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mt-2 mb-3"><div class="text-center alert alert-warning" role="alert">
   ¡Aun no es posible firmar! <br> El personal que cubre no ha firmado el formato para poder finalizar la solicitud.
</div></div>';


}else{
echo '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mt-2 mb-3"><div class="text-center alert alert-warning" role="alert">
¡No cuentas con los permisos para firmar!
</div></div>';
}

 
}else if($firmaC == 0){
if($Session_IDUsuarioBD == 318){
?>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
  <div class="table-responsive">
  <table class="custom-table" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">FIRMA DE VOBO</th> </tr>
  </thead>
  <tbody>
  
  <tr>
  <th class="align-middle text-center bg-light">
  <h4 class="text-primary text-center">Token Móvil</h4>
  <small class="text-secondary" style="font-size: .75em;">Agregue el token enviado a su número de teléfono o de clic en el siguiente botón para crear uno:</small>
  <br>

  <!-- 
  <button type="button" class="btn btn-labeled2 btn-success text-light mt-2" onclick="CrearToken(<?=$GET_idReporte;?>,1)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-solid fa-comment-sms"></i></span>Crear nuevo token SMS</button>

  <button type="button" class="btn btn-labeled2 btn-success text-light mt-2" onclick="CrearToken(<?=$GET_idReporte;?>,2)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-brands fa-whatsapp"></i></span>Crear nuevo token Whatsapp</button>
  -->
  <button type="button" class="btn btn-labeled2 btn-primary text-light mt-2" onclick="CrearToken(<?=$GET_idReporte;?>,3)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-brands fa-telegram"></i></span>Crear nuevo token Telegram</button>
  </th>
  </tr>

  <!-- 
  <th class="align-middle text-center bg-light ">
  <small class="text-danger" style="font-size: .75em;">Nota: En caso de no recibir el token de WhatsApp, agrega el número <b>+1 555-617-9367</b><br>
   a tus contactos y envía un mensaje por WhatsApp a ese número con la palabra "OK".
  </small>
  </th>
  -->

  <tr class="no-hover">
  <th class="align-middle text-center bg-light p-0">
  <div class="input-group">
  <input type="text" class="form-control border-0 bg-light" placeholder="Token de seguridad" aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
  <div class="input-group-append">
  <button class="btn btn-outline-success" type="button" onclick="FirmarPermiso(<?=$GET_idReporte;?>,'C')">Firmar permiso</button>
  </div>
  </div>
  </th>
  </tr>
  </tbody>
  </table>
  </div>
  </div>
 
<?php
}else{

echo '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mt-2 mb-3"><div class="text-center alert alert-warning" role="alert">
¡No cuentas con los permisos para firmar!
</div></div>';

}

}
?>  



</div>


  </div>
  </div>
  </div>

  </div>
  </div>

  </div>


<div class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" id="ModalFinalizado">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top: 83px;">
      <div class="modal-body">

       <h5 class="text-info">El token fue validado correctamente.</h5>
       <div class="text-secondary">El permiso fue firmada.</div>


      <div class="text-end">
        <button type="button" class="btn btn-primary" onclick="Regresar()">Aceptar</button>
      </div>

      </div>
    </div>
  </div>
</div>

  <div class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" id="ModalError">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top: 83px;">
      <div class="modal-body">

       <h5 class="text-danger">El token no fue aceptado, vuelva a generar uno nuevo o inténtelo mas tarde </h5>
       <div class="text-secondary">El permiso no fue firmada.</div>


      <div class="text-end">
      <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
      </div>

      </div>
    </div>
  </div>
</div>

      <script type="text/javascript">

var wrapper = document.getElementById("signature-pad");

var canvas = wrapper.querySelector("canvas");
var signaturePad = new SignaturePad(canvas, {
  backgroundColor: 'rgb(255, 255, 255)'
});

function resizeCanvas() {

  var ratio =  Math.max(window.devicePixelRatio || 1, 1);

  canvas.width = canvas.offsetWidth * ratio;
  canvas.height = canvas.offsetHeight * ratio;
  canvas.getContext("2d").scale(ratio, ratio);

  signaturePad.clear();
}

window.onresize = resizeCanvas;
resizeCanvas();

</script>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

</body>
</html>