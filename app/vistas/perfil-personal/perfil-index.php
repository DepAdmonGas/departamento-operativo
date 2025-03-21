<?php
require('app/help.php');

$sql = "SELECT nombre, usuario, password FROM tb_usuarios WHERE id = '".$Session_IDUsuarioBD."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
$usuario = $row['usuario'];
$password = $row['password'];
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
  <script type="text/javascript" src="<?php echo RUTA_JS ?>signature_pad.js"></script>

  <script type="text/javascript">

$(document).ready(function(){
$('[data-toggle="tooltip"]').tooltip();

$('#mostrar_usuario').click(function () {

         var type = $("#UsuarioPerfil").attr("type");

         if (type === "password") {
           $('#UsuarioPerfil').attr('type', 'text');
         }else{
           $('#UsuarioPerfil').attr('type', 'password');
         }


       });

         $('#mostrar_password').click(function () {

         var type = $("#PasswordPerfil").attr("type");

         if (type === "password") {
           $('#PasswordPerfil').attr('type', 'text');
         }else{
           $('#PasswordPerfil').attr('type', 'password');
         }


       });

});


  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  $('[data-toggle="tooltip"]').tooltip();

  });

    function Regresar(){
   window.history.back();
  }

  function UsuarioAleatorio()
{
  long=parseInt(10);
  var caracteres = "abcdefghijkmnpqrtuvwxyzABCDEFGHIJKLMNPQRTUVWXYZ2346789";
  var contraseña = "";
  for (i=0; i<long; i++) contraseña += caracteres.charAt(Math.floor(Math.random()*caracteres.length));
  $('#NomUsuario').val(contraseña);
}

function PasswordAleatorio(){
  long=parseInt(10);
  var caracteres = "abcdefghijkmnpqrtuvwxyzABCDEFGHIJKLMNPQRTUVWXYZ2346789";
  var contraseña = "";
  for (i=0; i<long; i++) contraseña += caracteres.charAt(Math.floor(Math.random()*caracteres.length));
  $('#PasswordOriginal').val(contraseña);
  $('#PasswordCopia').val(contraseña);
}

function Cargar(){
location.reload();
}

function Editar(IDUsuarioBD){

  $('#NomUsuario').css('border','');
  $('#PasswordOriginal').css('border','');
  $('#PasswordCopia').css('border','');

  var NomUsuario = $('#NomUsuario').val();
  var PasswordOriginal = $('#PasswordOriginal').val();
  var PasswordCopia = $('#PasswordCopia').val();

  if (NomUsuario != "") {
  if (PasswordOriginal != "") {
  if (PasswordCopia != "") {
  if (PasswordOriginal == PasswordCopia) {

    var parametros = {
      "idUsuario" : IDUsuarioBD,
      "NomUsuario" : NomUsuario,
      "PasswordOriginal" : PasswordOriginal
      };

      alertify.confirm('',
      function(){

        $.ajax({
         data:  parametros,
         url:   'public/home/modelo/editar-usuario.php',
         type:  'post',
         beforeSend: function() {
        $(".LoaderPage").show();
         },
         complete: function(){
        $('#Result').html(""); 
         },
         success:  function (response) {


          if(response == 1){
          $(".LoaderPage").hide();
          alertify.success('El usuario y contraseña fueron editados');
          window.setTimeout("Cargar()",1000);
           
          }else{
          $(".LoaderPage").hide();
          alertify.error('Error al editar el usuario y contraseña');   
          }

         }
         });

      },
      function(){
      }).setHeader('Editar Usuario o Contraseña').set({transition:'zoom',message: '¿Desea editar el nombre de usuario y contraseña?, si da clic en el botón aceptar tendrá que iniciar una nueva sesión por seguridad.',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();


  }else{
  $('#PasswordOriginal').css('border','2px solid #A52525');
  $('#PasswordCopia').css('border','2px solid #A52525');
  alertify.warning('Verifique que las contraseñas coincidan');
  }
  }else{
  $('#PasswordCopia').css('border','2px solid #A52525');
  }
  }else{
  $('#PasswordOriginal').css('border','2px solid #A52525');
  }
  }else{
  $('#NomUsuario').css('border','2px solid #A52525');
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
  <div class="cardAG p-3 container">
  <div class="row">

  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item" onclick="history.back()"><a class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Portal</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Perfil (<?=$nombre;?>)</li>
  </ol>
  </div>

  <div class="row">
  <div class="col-12">
  <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Perfil (<?=$nombre;?>)</h3>
  </div>
  </div>

  <hr>
  </div>


  <div class="col-12 mb-3">
  <div class="table-responsive">

  <table class="custom-table" style="font-size: 12.5px;" width="100%">
  <thead class="tables-bg">
  <tr> 
  <th class="align-middle text-center" colspan="2">Usuario</th> 
  <th class="align-middle text-center" colspan="2">Contraseña</th> 
  </tr>
  </thead>

  <tbody class="bg-light">
  <tr>
  <th class="align-middle text-center bg-light" width="40px">
  <a id="mostrar_usuario" class="pointer">
  <img src="<?=RUTA_IMG_ICONOS."ver-tb.png"; ?>">
  </a>
  </th>
  <th class="align-middle text-center bg-light"><input class="bg-light" type="password" id="UsuarioPerfil" style="font-size: 1.2em;border: 0;" value="<?=$usuario?>" readonly disabled/></th>
  <th class="align-middle text-center bg-light" width="40px">    
  <a id="mostrar_password" class="pointer">
  <img src="<?=RUTA_IMG_ICONOS."ver-tb.png"; ?>">
  </a></th>
  <th class="align-middle text-center bg-light"><input class="bg-light" type="password" id="PasswordPerfil" style="font-size: 1.2em;border: 0;" value="<?=$password?>" readonly disabled/>  </th>
  </tr>
  </tbody>
  </table>

  </div>
  </div>


  <div class="col-12">
          
  <div class="form-group mb-3">
  <div class="row no-gutters">
       
  <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
  <div class="text-secondary font-weight-light mb-1">Usuario:</div>
  <input class="form-control input-style" type="text" id="NomUsuario" value="<?=$usuario;?>" placeholder="Usuario" style="border-radius: 0px;" >
  </div>

  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mt-2">
  <br>
  <div class="text-center">
  <a onclick="UsuarioAleatorio()" class="pointer">
  <button type="button" class="btn btn-labeled2 btn-primary">
  <span class="btn-label2"><i class="fa-solid fa-shuffle"></i></span>Crear usuario aleatorio</button>
  </a>
  </div>
  </div>
  </div>
  </div>

  <div class="row ">
        
  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
  <div class="text-secondary font-weight-light mb-1">Contraseña:</div>
  <input class="form-control input-style" type="password" id="PasswordOriginal" value="<?=$password;?>" placeholder="Contraseña">
  </div>

  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
  <br>
  <div class="text-center">
  <a onclick="PasswordAleatorio()">
  <button type="button" class="btn btn-labeled2 btn-primary">
  <span class="btn-label2"><i class="fa-solid fa-shuffle"></i></span>Crear contraseña aleatoria</button>
  </a>
  </div>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
  <div class="text-secondary font-weight-light mb-1">Repite Contraseña:</div>
  <input class="form-control input-style" type="password" id="PasswordCopia" value="<?=$password;?>"  placeholder="Repite tu contraseña">
  </div>

  <div class="col-12">
  <hr>
  <button type="button" class="btn btn-labeled2 btn-success float-end" onclick="Editar(<?=$Session_IDUsuarioBD;?>)">
  <span class="btn-label2"><i class="fa fa-check"></i></span>Editar acceso</button>
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