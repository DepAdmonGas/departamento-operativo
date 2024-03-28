<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

$sql = "SELECT * FROM op_pivoteo WHERE id = '".$GET_idReporte."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result); 
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$idestacion = $row['id_estacion'];
$nocontrol = $row['nocontrol'];
$fecha = $row['fecha'];
$sucursal = $row['sucursal'];
$causa = $row['causa'];
$estatus = $row['estatus'];
}

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idestacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
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
 
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  
  });

  function Regresar(){
  window.history.back();
  }
 

function Finalizar(idReporte){

let Sucursal = $('#Sucursal').val();
let Fecha = $('#Fecha').val();
let Causa = $('#Causa').val();

if(Sucursal != ""){
$('#Sucursal').css('border',''); 
if(Fecha != ""){
$('#Fecha').css('border',''); 
if(Causa != ""){
$('#Causa').css('border',''); 

 var parametros = {
    "idReporte" : idReporte,
    "Sucursal" : Sucursal,
    "Fecha" : Fecha,
    "Causa" : Causa
    };

    $.ajax({
    data:  parametros,
    url:   '../public/corte-diario/modelo/finalizar-pivoteo-detalle.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

 
    if (response == 1) {

      Regresar();

    }else{
    alertify.error('Error al eliminar el pedido');
    }

    }
    });

}else{
$('#Causa').css('border','2px solid #A52525'); 
}
}else{
$('#Fecha').css('border','2px solid #A52525'); 
}
}else{
$('#Sucursal').css('border','2px solid #A52525'); 
}

}

function Editar(e,id,opcion){

 var parametros = {
    "valor" : e.value,
    "id" : id,
    "opcion" : opcion
    };

    $.ajax({
    data:  parametros,
    url:   '../../public/admin/modelo/editar-pivoteo-detalle.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

 
    if (response == 1) {

      if(opcion == 3){
      $('#TAD' + id).text(e.value)
      }else if(opcion == 4){
      $('#Unidad' + id).text(e.value)
      }else if(opcion == 5){
      $('#Chofer' + id).text(e.value)
      }else if(opcion == 10){
      $('#Tanque' + id).text(e.value)
      }else if(opcion == 11){
      $('#Litros' + id).text(e.value)
      }else if(opcion == 12){
      $('#Producto' + id).text(e.value)
      }
   
    }else{
    alertify.error('Error al actualizar');
    }

    }
    });
    }

    function CrearToken(idReporte){
    $(".LoaderPage").show();

    var parametros = {
    "idReporte" : idReporte
    };

    $.ajax({
    data:  parametros,
    url:   '../../public/admin/modelo/token-pivoteo.php',
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
    });

    }

  function FirmarPivoteo(idReporte,tipoFirma){

let Sucursal = $('#Sucursal').val();
let Fecha = $('#Fecha').val();
let Causa = $('#Causa').val();

    var TokenValidacion = $('#TokenValidacion').val();

    var parametros = {
    "idReporte" : idReporte,
    "tipoFirma" : tipoFirma,
    "TokenValidacion" : TokenValidacion,
    "Sucursal" : Sucursal,
    "Fecha" : Fecha,
    "Causa" : Causa
    };

  if(Sucursal != ""){
  $('#Sucursal').css('border','');
  if(Fecha != ""){
  $('#Fecha').css('border','');
  if(Causa != ""){
  $('#Causa').css('border','');
  if(TokenValidacion != ""){
  $('#TokenValidacion').css('border',''); 

    $(".LoaderPage").show();

      $.ajax({
    data:  parametros,
    url:   '../../public/admin/modelo/firmar-pivoteo.php',
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
     alertify.error('Error al firmar la solicitud');
    }

    }
    });

  }else{
  $('#TokenValidacion').css('border','2px solid #A52525'); 
  }
  }else{
  $('#Causa').css('border','2px solid #A52525'); 
  }
  }else{
  $('#Fecha').css('border','2px solid #A52525'); 
  }
  }else{
  $('#Sucursal').css('border','2px solid #A52525'); 
  }

    } 

  function ModalEditar(idReporte,Categoria){
  $('#Modal').modal('show');  
  $('#DivContenido').load('../../public/admin/vistas/modal-editar-pivoteo.php?idReporte=' + idReporte + '&Categoria=' + Categoria);
  }

  function Guardar(idReporte, Categoria){
  let EstacionFC = $('#EstacionFC').val();
  let EstacionOtroFC = $('#EstacionOtroFC').val();
  let DestinoOtroFC = $('#DestinoOtroFC').val();

  var parametros = {
    "id" : idReporte,
    "EstacionFC" : EstacionFC,
    "EstacionOtroFC" : EstacionOtroFC,
    "DestinoOtroFC" : DestinoOtroFC,
    "opcion" : 6,
    "Categoria" : Categoria
    };

    $.ajax({
    data:  parametros,
    url:   '../../public/admin/modelo/editar-pivoteo-detalle.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {

      location.reload();
    }else{
    alertify.error('Error al actualizar');
    }

    }
    });

  }

    function Otro(idReporte){

    var parametros = {
    "idReporte" : idReporte,
    "Producto" : "",
    "Litros" : "",
    "Tanque" : "",
    "TAD" : "",
    "Unidad" : "",
    "Chofer" : ""
    };

    $.ajax({
    data:  parametros,
    url:   '../../public/corte-diario/modelo/agregar-pivoteo-detalle.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
  location.reload();
    }else{
    alertify.error('Error al guardar');
    }

    }
    });

  }

      function Eliminar(idEstacion,id){

    var parametros = {
    "id" : id
    };

 alertify.confirm('',
 function(){

      $.ajax({
    data:  parametros,
    url:   '../../public/corte-diario/modelo/eliminar-pivoteo-detalle.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

 
    if (response == 1) {
    location.reload();
    }else{
    alertify.error('Error al eliminar el pedido');
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
    <div class="col-12">

     <h5>Pivoteo <?=$estacion;?></h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>

  <div class="table-responsive">
<table class="table table-sm table-bordered">
<tbody>
  <tr>
    <td class="align-middle"><b>Depto. Operativo</b></td>
    <td class="align-middle text-center" rowspan="3" width="400px"><b>Pivoteo</b></td>
    <td class="align-middle text-end"><b>Sucursal:</b></td>
    <td class="p-0">
      <textarea class="form-control rounded-0 border-0" id="Sucursal" onkeyup="Editar(this,<?=$GET_idReporte;?>,7)"><?=$sucursal;?></textarea>
    </td>
  </tr>
  <tr>
    <td class="align-middle" rowspan="2"><b>G500 Network Operación y Finanzas</b></td>
    <td class="align-middle text-end"><b>Fecha:</b></td>
    <td class="p-0"><input type="date" class="form-control rounded-0 border-0" value="<?=$fecha;?>" id="Fecha" onchange="Editar(this,<?=$GET_idReporte;?>,8)"></td>
  </tr>
  <tr>
    <td class="align-middle text-end"><b>No. De control:</b></td>
    <td><b>0<?=$nocontrol;?></b></td>
  </tr>
</tbody>
</table>
</div>


<h6 >Causa:</h6>
<textarea class="form-control rounded-0 mb-3" id="Causa" onkeyup="Editar(this,<?=$GET_idReporte;?>,9)"><?=$causa;?></textarea>

<div class="border p-3"> 

<div class="text-end">
<button type="button" class="btn btn-primary" onclick="Otro(<?=$GET_idReporte;?>)">Nuevo</button> 
</div>

<hr>
<?php 

$sql_lista = "SELECT * FROM op_pivoteo_detalle WHERE id_pivoteo = '".$GET_idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if($numero_lista > 0){

while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$id_pivoteo = $row_lista['id_pivoteo'];
$estacionfc = $row_lista['estacion_fc'];
$destinofc = $row_lista['destino_fc'];
$productofc = $row_lista['producto_fc'];
$tanquefc = $row_lista['tanque_fc'];
$facturafc = $row_lista['factura_fc'];
$litros = $row_lista['litros'];
$tad = $row_lista['tad'];
$unidad = $row_lista['unidad'];
$chofer = $row_lista['chofer'];
$estacionfn = $row_lista['estacion_fn'];
$destinofn = $row_lista['destino_fn'];
$tanquefn = $row_lista['tanque_fn'];
$facturafn = $row_lista['factura_fn'];


echo '<div class="row">';

echo '<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">';
echo '<div class="table-responsive">';
echo '<table class="table table-sm table-bordered mb-3">';
echo '<tbody>';
echo '<tr class="tables-bg text-center">
     <th width="50%" colspan="3">Documentación Facturada (CANCELAR)</th>
   </tr>';

echo '<tr>
    <td><b>Estación:</b></td>
    <td>'.$estacionfc.'</td>
    <td width="24px" class="text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="ModalEditar('.$id.',1)"></td>
    </tr>';

    echo '<tr>
    <td><b>Destino:</b></td>
    <td colspan="2">'.$destinofc.'</td>
    </tr>';

    echo '<tr>
    <td><b>Producto:</b></td>
    <td colspan="2" class="p-0">
    <select class="form-select border-0 rounded-0" onchange="Editar(this,'.$id.',12)">
    <option>'.$productofc.'</option>
    <option>87 OCTANOS</option>
    <option>91 OCTANOS</option>
    <option>DIESEL</option>
    </select></td>
    </tr>';

    echo '<tr>
    <td><b>Factura:</b></td>
    <td colspan="2" class="p-0"><input type="text" class="form-control border-0 rounded-0" value="'.$facturafc.'" onkeyup="Editar(this,'.$id.',1)"></td>

    </tr>';

    echo '<tr>
    <td><b>Litros:</b></td>
    <td colspan="2" class="p-0"><input type="number" class="form-control border-0 rounded-0" value="'.$litros.'" onkeyup="Editar(this,'.$id.',11)"></td>

    </tr>';

    echo '<tr>
    <td><b>Tanque:</b></td>
    <td colspan="2" class="p-0">
    <select class="form-select border-0 rounded-0" id="Tanque" onchange="Editar(this,'.$id.',10)">
    <option>'.$tanquefc.'</option>
    <option>Pipa</option>
    <option>Tanque 1</option>
    <option>Tanque 2</option>
    </select></td>
    </tr>';

    echo '<tr>
    <td><b>TAD:</b></td>
    <td colspan="2" class="p-0">
    <select class="form-select border-0 rounded-0" onchange="Editar(this,'.$id.',3)">
    <option>'.$tad.'</option>
    <option>Atlacomulco</option>
    <option>Tizayuca</option>
    <option>Tuxpan</option>
    <option>Puebla</option>
    <option>Vopack</option>
    </select>
    </td>
    </tr>';

    echo '<tr>
    <td><b>Unidad:</b></td>
    <td colspan="2" class="p-0">
    <select class="form-select border-0 rounded-0" onchange="Editar(this,'.$id.',4)">
    <option>'.$unidad.'</option>
    <option>TSF-1153</option>
    <option>TSF-1141</option>
    <option>TSF-1172</option>
    <option>TSF-1179</option>
    <option>TSF-1143</option>
    <option>TSF-1142</option>
    <option>TSF-1174</option>
    <option>TSF-1155</option>
    <option>PAS-515</option>
    <option>PAS-575</option>
    <option>PAS-585</option>
    <option>PAS-573</option>
    <option>PAS-569</option>
    <option>PAS-523</option>
    <option>PAS-535</option>
    <option>PAS-579</option>
    <option>PAS-545</option>
    <option>PAS-533</option>
    <option>PAS-547</option>
    <option>PAS-543</option>
    <option>FZC3403</option>
    <option>FZC3649</option>
    <option>PL-32</option>
    <option>PL-33</option>
    <option>PL-35</option>
    <option>PL-36</option>
    <option>PL-40</option>
    <option>PL-38</option>
    <option>439EW2</option>
	<option>PAS-537</option>
    </select>
    </td>
    </tr>';

    echo '<tr>
    <td><b>Chofer:</b></td>
    <td colspan="2" class="p-0">
    <select class="form-select border-0 rounded-0" onchange="Editar(this,'.$id.',5)">
    <option>'.$chofer.'</option>
    <option>JAIME JAVIER ROMERO CAMPOS</option>
    <option>JAVIER TREJO GREGORIO</option>
    <option>FRANCISCO ALCANTARA JIMÉNEZ</option>
    <option>JOEL ROSALES ROMERO</option>
    <option>ATANACIO SIERRA IBARRA</option>
    <option>JORGE ARMANDO ESTRADA LOPEZ</option>
    <option>JAVIER TREJO GREGORIO</option>
    <option>WILSON ALEJANDRO MONTEJO MAZA</option>
    <option>JULIO REYES FARIAS</option>
    <option>ENRIQUE MÉNDEZ ASCENCIO</option>
    <option>OMAR LUNA ZAGAL</option> 
    <option>JOSÉ FELICIANO LÓPEZ DOMÍNGUEZ</option>
    <option>NODRIEL BÁRCENAS CERÓN</option>
    <option>ROGELIO GUSTAVO HERNANDEZ PARADA</option>
    <option>GALVAN ARANDA ADAN</option>
    <option>JOSÉ ANTONIO VILLALBA OLIVER</option>
    <option>NICOLAS PEREZ ROMERO</option>
    <option>CARLOS NICANDRO CASTILLO BAUTISTA</option>
    <option>VICTOR HUGO PEREZ CARRASCO</option>
    <option>ENRIQUE GONZALEZ RANGEL</option>
    <option>JORGE REYNOSO GONZALES</option>
    <option>GEOVANI GARCIA SALAZAR</option>
    <option>VICTOR MANUEL CUELLAR RAMOS</option>
    <option>CESAR GONZALEZ FLORES</option>
    <option>ALEJANDRO AFFIF ENRIQUEZ</option>
    <option>FRANCISCO CUELLAR RAMOS</option>
    <option>CESAR HERNANDEZ RUGERIO</option>
    </select>    
    </td>
    </tr>';

echo '</tbody>';
echo '</table>';
echo '</div>';
echo '</div>';



echo '<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">';
echo '<div class="table-responsive">';

echo '<table class="table table-sm table-bordered mb-0">';
echo '<tbody>';
echo '<tr class="tables-bg text-center">
     <th width="50%" colspan="3">Documentación a Refacturar</th>
   </tr>';

echo '<tr>
    <td ><b>Estación:</b></td>
    <td>'.$estacionfn.'</td>
    <td width="24px" class="text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="ModalEditar('.$id.',2)"></td>
    </tr>';

    echo '<tr>
    <td><b>Destino:</b></td>
    <td colspan="2">'.$destinofn.'</td>
    </tr>';

    echo '<tr>
    <td height="38" ><b>Producto:</b></td>
    <td  height="38" colspan="2"><div id="Producto'.$id.'">'.$productofc.'</div></td>
    </tr>';

    echo '<tr>
    <td><b>Factura:</b></td>
    <td colspan="2" class="p-0"><input type="text" class="form-control border-0 rounded-0" value="'.$facturafn.'" onkeyup="Editar(this,'.$id.',2)"></td>
    </tr>';

    echo '<tr>
    <td height="37"><b>Litros:</b></td>
    <td height="37"><b>Litros:</b></td>
    <td colspan="2"><div id="Litros'.$id.'">'.number_format($litros,2).'</div></td>
    </tr>';

    echo '<tr>
    <td height="37"><b>Tanque:</b></td>
    <td height="37" colspan="2"><div id="Tanque'.$id.'">'.$tanquefn.'</div></td>
    </tr>';

    echo '<tr>
    <td height="37"><b>TAD:</b></td>
    <td height="37" colspan="2"><div id="TAD'.$id.'">'.$tad.'</div></td>
    </tr>';

    echo '<tr>
    <td height="37"><b>Unidad:</b></td>
    <td height="37" colspan="2"><div id="Unidad'.$id.'">'.$unidad.'</div></td>
    </tr>';

    echo '<tr>
    <td height="37"><b>Chofer:</b></td>
    <td height="37" colspan="2"><div id="Chofer'.$id.'">'.$chofer.'</div></td>
    </tr>';

echo '</tbody>';
echo '</table>';


echo '</div>';
echo '</div>';


echo '</div>';



echo '<div class="text-end mt-3">
<button type="button" class="btn btn-sm btn-danger" onclick="Eliminar('.$GET_idReporte.','.$id.')">Eliminar</button> 
</div>';

echo '<hr>';

}

}else{


echo '<div class="alert alert-warning text-center align-middle mb-0" role="alert">
No se encontró información para mostrar
</div>'; 

}

?>

</div>

<?php if($Session_IDUsuarioBD == 273 || $Session_IDUsuarioBD == 19){ ?>
<div class="row">
<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
<div class="border p-3 mt-3">
<div class="mb-2 text-secondary text-center">FIRMA</div>
<hr>
<h4 class="text-primary text-center">Token Móvil</h4>
<small class="text-secondary">Agregue el token enviado a su número de teléfono o de clic en el siguiente botón para crear uno</small>
<button class="btn btn-sm" onclick="CrearToken(<?=$GET_idReporte;?>)"><small>Crear nuevo token</small></button>

<div class="input-group mt-3">
  <input type="text" class="form-control" placeholder="Token de seguridad" aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="button" onclick="FirmarPivoteo(<?=$GET_idReporte;?>,'B')">Firmar solicitud</button>
  </div>
</div>
</div>
</div>
</div>
<?php }?>



  </div>
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

   <div class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" id="ModalFinalizado">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top: 83px;">
      <div class="modal-body">

       <h5 class="text-info">El token fue validado correctamente.</h5>
       <div class="text-secondary">El pivoteo fue firmado.</div>


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
       <div class="text-secondary">El pivoteo no fue firmado.</div>


      <div class="text-end">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
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
