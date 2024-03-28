<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

$sql = "SELECT
op_orden_servicio.id,
op_orden_servicio.id_estacion,
op_orden_servicio.id_usuario,
op_orden_servicio.fecha,
op_orden_servicio.folio,
op_orden_servicio.codigo,
op_orden_servicio.no_control,
tb_estaciones.nombre,
tb_estaciones.razonsocial,
tb_estaciones.rfc,
tb_estaciones.direccioncompleta,
tb_estaciones.email
FROM op_orden_servicio 
INNER JOIN tb_estaciones 
ON op_orden_servicio.id_estacion = tb_estaciones.id WHERE op_orden_servicio.id = '".$GET_idReporte."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$idEstacion = $row['id_estacion'];
$Codigo = $row['codigo'];
$NoControl = $row['no_control'];
$RazonSocial = $row['razonsocial'];
$RFC = $row['rfc'];
$Email = $row['email'];
$Direccion = $row['direccioncompleta'];
$explode = explode(" ", $row['fecha']);
$Fecha = $explode[0];

}

?>
<html lang="es">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Dirección de operaciones</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <link rel="shortcut icon" href="<?php echo RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="apple-touch-icon" href="<?php echo RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>alertify.css">
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>themes/default.rtl.css">
  <link href="<?php echo RUTA_CSS ?>bootstrap.css" rel="stylesheet" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?php echo RUTA_JS ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  <style media="screen">
  .LoaderPage {
  position: fixed;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background: url('../imgs/iconos/load-img.gif') 50% 50% no-repeat rgb(249,249,249);
  }
  </style>
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

  <div class="p-4">
  <div class="card">
  <div class="card-body">
  <div class="border-bottom pb-5">
  <div class="float-left">
  <h5 class="card-title"><img class="pr-2" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()"> Orden de Servicio</h5>
  </div>
  </div>

  <div class="row">
    <div class="col-6">
    
  <div class="border p-3 mt-3">
   
   <table class="table table-sm table-bordered " style="font-size: .9em;">
    <tr>
      <td>Ref. Operativa</td>
      <td rowspan="3" class="text-center align-middle"><h5>Orden de Servicio</h5></td>
      <td>Sucursal:</td>
      <td><b><?=$session_nomestacion;?></b></td>
    </tr>
    <tr>
      <td>Departamento de Mantenimiento</td>
       <td>Fecha:</td>
       <td><b><?=FormatoFecha($Fecha);?></b></td>
    </tr>

    <tr>
      <td>Código: <b><?=$Codigo;?></b></td>
      <td>No. De control:</td>
      <td><b><?=$NoControl;?></b></td>
    </tr>
     
   </table> 

   <hr>
      <table class="table table-sm table-bordered " style="font-size: .9em;">
          <tr>
            <td colspan="2" class="text-center align-middle"><b>DATOS DE LA ESTACIÓN DE SERVICIO</b></td>
          </tr>
        <tr>
          <td class="align-middle"><b>Razón social:</b></td>
          <td class="align-middle bg-light"><?=$RazonSocial;?></td>
        </tr>
        <tr>
          <td class="align-middle"><b>RFC.</b></td>
          <td class="align-middle bg-light"><?=$RFC;?></td>
        </tr>
        <tr>
          <td class="align-middle"><b>Dirección:</b></td>
          <td class="align-middle bg-light"><?=$Direccion;?></td>
        </tr>
        <tr>
          <td class="align-middle"><b>Mail:</b></td>
          <td class="align-middle bg-light"><?=$Email;?></td>
        </tr>
       </table>

     <hr>
        <table class="table table-sm table-bordered " style="font-size: .9em;">
        <tr>
            <td class="align-middle">Tramite:</td>
            <td class="text-center align-middle"><b>COMPRA DE REFACCCIONES E INSTALACIÓN</b></td>
          </tr>
        <tr>
          <td class="align-middle"><b>Marco Normativo</b></td>
          <td class="align-middle bg-light">
          NORMA Oficial Mexicana NOM-001-SEDE-2012, Instalaciones Eléctricas (utilización) (Continúa en la Segunda Sección)</br>
          NORMA Oficial Mexicana NOM-013-ENER-2013, Eficiencia energética para sistemas de alumbrado en vialidades.</br>
          NORMA Oficial Mexicana NOM-007-ENER-2014, Eficiencia energética para sistemas de alumbrado en edificios no residenciales.
          </td>
        </tr>
       </table>

    </div>
    </div>
    <div class="col-6">

      <div class="border p-3 mt-3">

        <h6>TIPO DE SERVICIO</h6>

        <div class="row mt-3">
          <div class="col-2">
          <b>Periódico</b> <input type="radio" name="exampleRadios">
          </div>
          <div class="col-2">
          <b>Ordinario</b> <input type="radio" name="exampleRadios">
          </div>
          <div class="col-3">
          <b>Extraordinario</b> <input type="radio" name="exampleRadios">
          </div>
        </div>

        <div class="mt-2">ORDEN DE SERVICIO REVISIÓN INTERNA: <b>Si</b> <input type="radio" name="Radios"> <b>No</b> <input type="radio" name="Radios"> </div>

        <div class="row mt-2">
          <div class="col-6">
            Técnica aplicada:
            <textarea class="form-control"></textarea>
          </div>
          <div class="col-6">
            Equipo utilizado:
            <textarea class="form-control"></textarea>
          </div>
        </div>

       <hr>

       <div class="row">
        <div class="col-6">
          <table class="table table-sm table-bordered " style="font-size: .9em;">
          <tr>
            <td colspan="2" class="text-center align-middle">Tipo de trabajo a realizar:</td>
            <td class="text-center align-middle">Prestador autorizado, No. De Autorización</td>
          </tr>
        <tr>
          <td class="align-middle">Mecánico</td>
          <td class="align-middle bg-light"><input type="checkbox" name=""></td>
          <td class="p-0"><input type="text" class="form-control rounded-0" style="font-size: .9em;"></td>
        </tr>
        <tr>
          <td class="align-middle">Eléctrico</td>
          <td class="align-middle bg-light"><input type="checkbox" name=""></td>
          <td class="p-0"><input type="text" class="form-control rounded-0" style="font-size: .9em;"></td>
        </tr>
        <tr>
          <td class="align-middle">Sistemas</td>
          <td class="align-middle bg-light"><input type="checkbox" name=""></td>
          <td class="p-0"><input type="text" class="form-control rounded-0" style="font-size: .9em;"></td>
        </tr>
        <tr>
          <td class="align-middle">Servicio Periódico</td>
          <td class="align-middle bg-light"><input type="checkbox" name=""></td>
          <td class="p-0"><input type="text" class="form-control rounded-0" style="font-size: .9em;"></td>
        </tr>
       </table>
        </div>
        <div class="col-6">
        
          <table class="table table-sm table-bordered " style="font-size: .9em;">
          <tr>
            <td colspan="2" class="text-center align-middle">Área</td>
          </tr>
        <tr>
          <td class="align-middle">Zona de despacho</td>
          <td class="align-middle bg-light text-center"><input type="checkbox" name=""></td>
        </tr>
        <tr>
          <td class="align-middle">Zona de tanques</td>
          <td class="align-middle bg-light text-center"><input type="checkbox" name=""></td>
        </tr>
        <tr>
          <td class="align-middle">Cuarto eléctrico</td>
          <td class="align-middle bg-light text-center"><input type="checkbox" name=""></td>
        </tr>
        <tr>
          <td class="align-middle">Cuarto de residuos</td>
          <td class="align-middle bg-light text-center"><input type="checkbox" name=""></td>
        </tr>
        <tr>
          <td class="align-middle">Bodega aceites</td>
          <td class="align-middle bg-light text-center"><input type="checkbox" name=""></td>
        </tr>
        <tr>
          <td class="align-middle">Baños</td>
          <td class="align-middle bg-light text-center"><input type="checkbox" name=""></td>
        </tr>
       </table>

        </div> 
       </div>

      <h6>Descripción de los trabajos</h6>
       <textarea class="form-control"></textarea>

       <h6 class="mt-2">SEGUIMIENTO A LA ORDEN DE SERVICIO:</h6>

       <div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" >
  <label class="form-check-label" for="exampleRadios1">
    1. Detenida por falta de refacciones
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
  <label class="form-check-label" for="exampleRadios2">
    2. En proceso     
  </label>
</div>
<div class="form-check disabled">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="option3" >
  <label class="form-check-label" for="exampleRadios3">
    3. No autorizada para su reparación
  </label>
</div>
<div class="form-check disabled">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios4" value="option4" >
  <label class="form-check-label" for="exampleRadios4">
    4. Terminada
  </label>
</div>

<div class="mt-1">
  Trabajo terminado en tiempo y forma: <b>Si</b> <input type="radio" name="Radios"> <b>No</b> <input type="radio" name="Radios">
</div>

<div class="mt-2">No. De Registro en la bitácora de Mantenimiento:</div>
<input type="text" class="form-control">

<div class="mt-2">Fecha de Registro:</div>
<input type="date" class="form-control">
<div class="mt-2">
Contrato vigente con el prestador de servicio: <b>Si</b> <input type="radio" name="Radios"> <b>No</b> <input type="radio" name="Radios">
</div>

          <table class="table table-sm table-bordered mt-2" style="font-size: .9em;">
          <tr>
            <td colspan="4" class="text-center align-middle bg-secondary text-light font-weight-bold">Descripción de pagos</td>
          </tr>
        <tr>
          <td class="align-middle text-center font-weight-bold">Concepto</td>
          <td class="align-middle text-center font-weight-bold">Proveedor</td>
          <td class="align-middle text-center font-weight-bold">Importe</td>
          <td class="align-middle text-center font-weight-bold">No. De Documento</td>
        </tr>
        <tr>
          <td class="align-middle p-0 m-0"><textarea class="form-control rounded-0 border-0" style="font-size: .9em;"></textarea></td>
          <td class="align-middle p-0 m-0"><textarea class="form-control rounded-0 border-0" style="font-size: .9em;"></textarea></td>
          <td class="align-middle p-0 m-0"><textarea class="form-control rounded-0 border-0" style="font-size: .9em;"></textarea></td>
          <td class="align-middle p-0 m-0"><textarea class="form-control rounded-0 border-0" style="font-size: .9em;"></textarea></td>
        </tr>
       </table>

       <h6>En caso que no describir justificación y tiempo de terminación</h6>
       <textarea class="form-control mb-2"></textarea>

       <h6>Costo de los trabajos a realizar</h6>
       <textarea class="form-control mb-2"></textarea>

       <h6>Pagos pendientes</h6>
       <textarea class="form-control mb-2"></textarea>

       <h6>Costo de las reparaciones y observaciones</h6>
       <textarea class="form-control mb-2"></textarea>


       <hr>

          <div class="col-6">
          <div class="mb-2 text-secondary text-center">Responsable Técnico de la ES</div>
          <div id="signature-pad" class="signature-pad mt-2" >
          <div class="signature-pad--body">
          <canvas style="width: 100%; height: 150px; border: 1px black solid;" id="canvas"></canvas>
          </div>
          <input type="hidden" name="base64" value="" id="base64">
          </div> 
          <div class="text-right mt-2">
          <button class="btn btn-info btn-sm" onclick="resizeCanvas()"><small>Limpiar</small></button>
          </div>
          </div>

          <hr>
          
        
        <div class="text-right">
        <button type="button" class="btn btn-primary">Finalizar</button>
        </div>


      </div>
    </div>
  </div>

  </div>
  </div>
  </div>

  <div class="modal" id="Modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div id="ContenidoModal"></div>    
    </div>
  </div>
</div>

  <script src="<?php echo RUTA_JS ?>bootstrap.min.js"></script>
  </body>
  </html>
