  <?php
  require('../../../app/help.php');

  $idReporte = $_GET['idReporte'];
  $idStatus = $_GET['idStatus'];

  $sql_lista = "SELECT op_rh_localidades.localidad 
  FROM op_orden_compra_razon_social 
  INNER JOIN op_rh_localidades ON op_rh_localidades.id = op_orden_compra_razon_social.id_estacion WHERE op_orden_compra_razon_social.id_ordencompra = '".$idReporte."' ";

  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);
 
  while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
    $nombreES = $row_lista['localidad'];
  }

  //---------- OCULTAR BOTON DE ACCION ----------//
  if($idStatus == 0){
    $ocultarE = '';
  }else{
    $ocultarE = 'd-none';
  }

  
  //---------- BOTON DE ACCION ----------//
  if($numero_lista > 0){
    $botonAccion = '<img src="'.RUTA_IMG_ICONOS.'editar-tb.png" class="pointer float-end" onclick="ModalEstacion('.$idReporte.',1)">';
  }else{
    $botonAccion = '<img src="'.RUTA_IMG_ICONOS.'agregar.png" class="pointer float-end" onclick="ModalEstacion('.$idReporte.',0)">';
  }


  //---------- ESTACIONES DE SERVICIO ----------//
  if($nombreES == "Quitarga"){
    $nombreRS = "COMERCIAL GASOLINERA QUITARGA";
    $rfc = "CGQ120525C15";
    $contacto = "Calle Plaza Tajin No. 433, Col. CTM Culhuacan Secc. V, C.P. 04480";
  }else if($nombreES == "Comercializadora"){
    $nombreRS = "COMERCIALIZALIZADORA DE ARTICULOS GASOLINEROS";
    $rfc = "CAG05052557A";
    $contacto = "Carretera Rio Hondo Huixquilucan No. 401, San Bartolomé Coatepec, C.P. 52770";
  
  }else{

  $sql_lista_es = "SELECT razonsocial, rfc, direccioncompleta
  FROM tb_estaciones WHERE nombre = '".$nombreES."' ";

  $result_lista_es = mysqli_query($con, $sql_lista_es);
  $numero_lista_es = mysqli_num_rows($result_lista_es);

  while($row_lista_es = mysqli_fetch_array($result_lista_es, MYSQLI_ASSOC)){
  $nombreRS = $row_lista_es['razonsocial'];
  $rfc = $row_lista_es['rfc'];
  $contacto = $row_lista_es['direccioncompleta'];
  }


  }

  ?>

<div class="row <?=$ocultarE?>">
<div class="col-12">
<?=$botonAccion?>
</div>
</div>
<hr class="<?=$ocultarE?>">

  <div class="table-responsive">
    <table class="table table-sm table-bordered mb-0" style="font-size: .9em;">
      <tr class="tables-bg">
      <th colspan="2" class=" text-center">DATOS DE LA ESTACION</th>
      </tr>
        
<?php
  
  if($numero_lista > 0){

echo '<tr>
      <td class="align-middle"><b>Razón Social:</b></td>
      <td class="align-middle">'.$nombreRS.'</td>
      </tr>

      <tr>
      <td class="align-middle"><b>RFC:</b></td>
      <td class="align-middle">'.$rfc.'</td>
      </tr>
        
      <tr>
      <td class="align-middle"><b>Dirección:</b></td>
      <td class="align-middle">'.$contacto.'</td>
      </tr>';

  }else{
  echo "<tr><td colspan='2' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
  }
 
?>
      

    </table>
  </div>