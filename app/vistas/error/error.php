<?php 
require('app/help.php');

?>
 
  <!DOCTYPE html>
  <html lang="es">
  
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Departamento Operativo</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <link rel="shortcut icon" href="<?=RUTA_IMG_ICONOS?>/icono-web.ico">
    <link rel="apple-touch-icon" href="<?=RUTA_IMG_ICONOS?>/icono-web.ico">
    <link href="<?=RUTA_CSS2;?>bootstrap.min.css" rel="stylesheet" />
    <link href="<?=RUTA_CSS2;?>login.min.css" rel="stylesheet" />
  </head>

  <body>
    <div class="login-page" style="background-color: #5d84c3; display: flex; justify-content: center; align-items: center; height: 100vh;">
      <div class="container" style="width: 100%;">
        <div class="row" style = " display: flex;  justify-content: center; align-items: center;">
          <div class="col-lg-10 offset-lg-1">
            <div class="bg-white shadow">
              <div class="row " style = " display: flex;  justify-content: center; align-items: center;">
                <!----- FORMULARIO LOGIN ----->
                <div class="col-md-7 form-login" >
                  <div class="py-4 px-4">
                    <div class="row p-3">
                      <div class="d-flex align-items-center mb-2">
                        <img class="img-logo" src="imgs/logo/Logo.png" style="width: 70%;">
                      </div>

                      <!----- INPUT USUARIO ----->
                      <div class="col-12 mb-3">
                        <h1 style ="font-size: 50px; margin-bottom: 20px; color: #395173;">Error 404</h1>
                        <p style ="font-size: 24px;  margin-bottom: 20px; color: #395173;">Lo sentimos, la página que estás buscando no se pudo encontrar.</p>
                      </div>
                      <!----- BOTON DE Regreso ----->
                      <div class="col-12" id="myForm">
                        <button type="submit" class="btn btn-sm btn-primary float-end " id="btnRegresar">Regresar</button>
                      </div>
                      <div class="col-12 mt-3" id="resultadoDiv"></div>
                    </div>
                  </div>
                </div>
                <!----- IMAGEN DE LA ESTACION DE SERVICIO ----->                           
                <div class="col-md-5 d-none d-md-block">
                  <img class="img-fluid py-4 px-4 row p-3 " src="imgs/logo/error-404.png" style="height: 10%;">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>
        document.getElementById("btnRegresar").onclick = function() {
            window.history.back();
        };
    </script>
    <script src="<?=RUTA_JS ?>login-function.js"></script>
    <script src="<?=RUTA_JS ?>bootstrap.min.js"></script>
  </body>
</html>