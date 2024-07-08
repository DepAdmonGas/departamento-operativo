 <?php
require('app/help.php');

$sql_lista_f = "SELECT * FROM op_formato_precios WHERE id = '".$GET_IdPrecio."' ";
$result_lista_f = mysqli_query($con, $sql_lista_f);
$numero_lista_f = mysqli_num_rows($result_lista_f);
while($row_lista_f = mysqli_fetch_array($result_lista_f, MYSQLI_ASSOC)){
$fecha = $row_lista_f['fecha']; 
$estatus = $row_lista_f['estatus']; 
}
 
if($estatus == 0){
$ocultar = "";
}else{
$ocultar = "d-none";
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
 
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  tablasPrecios(<?=$GET_IdPrecio?>)
  });

  function Regresar(){
  window.history.back();
  } 

  function tablasPrecios(idPrecio){
  $('#tablasPrecios').load('../../public/admin/vistas/lista-tablas-precios.php?idPrecio=' + idPrecio);
  }

  function EditPrecio(e,id,num){
    
  var PemexV = $('#PemexV' + id).val();

  var MonterraVD = $('#MonterraVD' + id).val();
  var VopakVD = $('#VopakVD' + id).val();
  var TuxpanVD = $('#TuxpanVD' + id).val();

  var VopakVP = $('#VopakVP' + id).val();
  var TuxpanVP = $('#TuxpanVP' + id).val();
  var MonterraVP = $('#MonterraVP' + id).val();
  var TizayuVP = $('#TizayuVP' + id).val();
  var PueblaVP = $('#PueblaVP' + id).val();

  var VopakP = $('#VopakP' + id).val();
  var TuxpanP = $('#TuxpanP' + id).val();
  var MonterraP = $('#MonterraP' + id).val();
  var TizayuP = $('#TizayuP' + id).val();
  var PueblaP = $('#PueblaP' + id).val();

  var valor = e.value;
 
  var parametros = {
  "valor" : valor,
  "id" : id,
  "num" : num
  }; 
 
  $.ajax({ 
  data:  parametros,
  url:   '../../public/admin/modelo/editar-formato-precios.php',
  type:  'post',
  beforeSend: function() {
     
  },
  complete: function(){
    
  },
  success:  function (response) {
  if (response == 1) {

  if(num == 1){
 
  //----- DELIVERY -----
	var difMvsPD =  MonterraVD - valor;
  $('#MonterraD' + id).val(difMvsPD.toFixed(4));

  var difMvsVD = VopakVD - valor;
  $('#VopakD' + id).val(difMvsVD.toFixed(4));

	var difMvsTD = TuxpanVD - valor;
  $('#TuxpanD' + id).val(difMvsTD.toFixed(4));

	//----- PICK UP -----
    var DifMvsVP = valor - VopakVP;
    $('#VopakP' + id).val(DifMvsVP);

	  var DifMvsTP = valor - TuxpanVP;
    $('#TuxpanP' + id).val(DifMvsTP);

    var DifMvsPP = valor - MonterraVP ;
    $('#MonterraP' + id).val(DifMvsPP);

    var DifMvsTiP = valor - TizayuVP;
    $('#TizayuP' + id).val(DifMvsTiP);

    var DifMvsPuP = valor - PueblaVP;
    $('#PueblaP' + id).val(DifMvsPuP);


    }else if(num == 2){
	  var difMvsPD = valor - PemexV;
    $('#TuxpanVD' + id).val(valor);
    $('#MonterraD' + id).val(difMvsPD.toFixed(4));
    $('#TuxpanD' + id).val(difMvsPD.toFixed(4));

    }else if(num == 4){
    var difMvsVD = valor - PemexV;
    $('#VopakD' + id).val(difMvsVD.toFixed(4));


    }else if(num == 14){
    var textIVA = (valor * 0.16);
    var DecIVA = textIVA.toFixed(4);
    $('#inputIVA' + id).val(DecIVA);

    var textRetencion = (valor * 0.04);
    var DecRetencion = textRetencion.toFixed(4);
    $('#inputRetencion' + id).val(DecRetencion);

    var textTotalPU = (valor * 1) + (valor * 0.16) - (valor * 0.04);
    var tarifa = $('input[name="inputTotalPU' + id +'"]').val(textTotalPU.toFixed(4));

    tablasPrecios(<?=$GET_IdPrecio?>)

    }else if(num == 15){
    alertify.success('Fecha actualizada exitosamente')

    //----- DELIVERY -----
    }else if(num == 10){
    var tarifa = $('#inputVopack').val();
    var tarifaF = parseFloat(tarifa);

    var totalRes1 = tarifaF + parseFloat(valor);
    var totalRes2 = totalRes1 - parseFloat(PemexV);

    $('#VopakP' + id).val(totalRes2.toFixed(4));
    

    }else if(num == 9){
    var tarifa = $('#inputTuxpan').val();
    var tarifaF = parseFloat(tarifa);

    var totalRes1 = tarifaF + parseFloat(valor);
    var totalRes2 = totalRes1 - parseFloat(PemexV);

    $('#MonterraVP' + id).val(valor);

    $('#TuxpanP' + id).val(totalRes2.toFixed(4));
    $('#MonterraP' + id).val(totalRes2.toFixed(4));

    }else if(num == 12){
    var tarifa = $('#inputTizayuca').val();
    var tarifaF = parseFloat(tarifa);

    var totalRes1 = tarifaF + parseFloat(valor);
    var totalRes2 = totalRes1 - parseFloat(PemexV);

    $('#TizayuP' + id).val(totalRes2.toFixed(4));
 
    }else if(num == 13){
    var tarifa = $('#inputPuebla').val();
    var tarifaF = parseFloat(tarifa);

    var totalRes1 = tarifaF + parseFloat(valor);
    var totalRes2 = totalRes1 - parseFloat(PemexV);

    $('#PueblaP' + id).val(totalRes2.toFixed(4));
 
    //----- BOTON GUARDAR -----
    }else if(num == 0){
    window.history.back();

    }

    }else{
    alertify.error('Error al editar')

  }

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

  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.go(-1)"  class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Precios diarios de combustible</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase"><?=$ClassHerramientasDptoOperativo->FormatoFecha($fecha)?> </li>
  </ol>
  </div>
 
  <div class="row"> 
  <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"><?=$ClassHerramientasDptoOperativo->FormatoFecha($fecha)?></div>
  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mt-2 <?=$ocultar?>">
  <button type="button" class="btn btn-labeled2 btn-success float-end" onclick="EditPrecio(this,<?=$GET_IdPrecio?>,0)"> <span class="btn-label2"><i class="fa fa-check"></i></span>Finalizar</button>
  </div>
  </div>

  <hr>
  </div>

  <div class="col-12 mb-3"> 
  <div class="table-responsive">
  <table class="custom-table" style="font-size: 12.5px;" width="100%">
  
  <thead class="title-table-bg">
  <tr class="tables-bg">
  <th class="align-middle text-center" colspan="6">Precio del transporte</th>
  </tr>

  <tr>
  <td class="align-middle text-center fw-bold">Terminal</td>
  <th class="align-middle text-center">Pickup</th>
  <th class="align-middle text-center">IVA 16%</th>
  <th class="align-middle text-center">Retencion 4%</th>
  <td class="align-middle text-center fw-bold">Tarifa final transporte <br> Pickup</td>
  </tr>
  </thead>

  <tbody class="bg-white">

  <?php 
  $sql = "SELECT * FROM op_formato_precios_transporte WHERE id_formato = '".$GET_IdPrecio."' ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
  
  $idTransporte = $row['id'];
  $detalle = $row['detalle'];

  if($row['precio'] == 0){
  $precioT = 0;
  $precioIVA = number_format(0,4);
  $precioRetencion = number_format(0,4);
  $totalPickUp = number_format(0,4);

  }else{
  $precioT = $row['precio']; 
  $precioIVA = number_format(($precioT * 0.16),4);
  $precioRetencion = number_format(($precioT * 0.04),4);
  $totalPickUp = number_format(($precioT + $precioIVA - $precioRetencion),4);
  }

  echo '<tr class="text-center">
  <td class="align-middle no-hover"><b>'.$detalle.'</b></td>

  <td class="p-0 no-hover">
  <input type="number" class="form-control rounded-0 border-0 text-center" value="'.$precioT.'" onkeyup="EditPrecio(this,'.$idTransporte.',14)" style="font-size: .9em;"/>
  </td> 
  
  <td class="p-0 no-hover"> 
  <input type="number" class="form-control rounded-0 border-0 text-center bg-white" id="inputIVA'.$idTransporte.'"  value="'.$precioIVA.'" style="font-size: .9em; " disabled/>
  </td>

  <td class="p-0 no-hover"> 
  <input type="number" class="form-control rounded-0 border-0 text-center bg-white" id="inputRetencion'.$idTransporte.'" value="'.$precioRetencion.'" style="font-size: .9em; " disabled/>
  </td>

  <td class="p-0 no-hover"> 
  <input type="number" class="form-control rounded-0 border-0 text-center bg-white"  id="input'.$detalle.'" name="inputTotalPU'.$idTransporte.'" value='.$totalPickUp.' style="font-size: .9em; " disabled/>
  </td>

  </tr>';
  
  }

  ?>    
  </tbody>
   

  </table>
  </div>
  </div>

  <div class="col-12" id="tablasPrecios"></div>

  </div>
  </div>

  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
 