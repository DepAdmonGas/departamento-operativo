<?php
require ('../../../app/help.php');

$idReporte = $_GET['idReporte'];
$idStatus = $_GET['idStatus'];
$nombreES = "";
$sql_lista = "SELECT op_rh_localidades.localidad 
  FROM op_orden_compra_razon_social 
  INNER JOIN op_rh_localidades ON op_rh_localidades.id = op_orden_compra_razon_social.id_estacion WHERE op_orden_compra_razon_social.id_ordencompra = '" . $idReporte . "' ";

$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
  $nombreES = $row_lista['localidad'];
}

//---------- OCULTAR BOTON DE ACCION ----------//
if ($idStatus == 0) {
  $ocultarE = '';
} else {
  $ocultarE = 'd-none';
}


//---------- BOTON DE ACCION ----------//
$name = 'Agregar';
$num = 0;
if ($numero_lista > 0) {
  $name = 'Editar';
  $num = 1;
}
$botonAccion = '<button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="ModalEstacion(' . $idReporte . ',' . $num . ')">
  <span class="btn-label2"><i class="fa fa-plus"></i></span>' . $name . ' estacion</button>';

//---------- ESTACIONES DE SERVICIO ----------//
if ($nombreES == "Quitarga") {
  $nombreRS = "COMERCIAL GASOLINERA QUITARGA";
  $rfc = "CGQ120525C15";
  $contacto = "Calle Plaza Tajin No. 433, Col. CTM Culhuacan Secc. V, C.P. 04480";
} else if ($nombreES == "Comercializadora") {
  $nombreRS = "COMERCIALIZALIZADORA DE ARTICULOS GASOLINEROS";
  $rfc = "CAG05052557A";
  $contacto = "Carretera Rio Hondo Huixquilucan No. 401, San Bartolomé Coatepec, C.P. 52770";

} else {

  $sql_lista_es = "SELECT razonsocial, rfc, direccioncompleta
  FROM tb_estaciones WHERE nombre = '" . $nombreES . "' ";

  $result_lista_es = mysqli_query($con, $sql_lista_es);
  $numero_lista_es = mysqli_num_rows($result_lista_es);

  while ($row_lista_es = mysqli_fetch_array($result_lista_es, MYSQLI_ASSOC)) {
    $nombreRS = $row_lista_es['razonsocial'];
    $rfc = $row_lista_es['rfc'];
    $contacto = $row_lista_es['direccioncompleta'];
  }


}

?>
<hr class="<?= $ocultarE ?>">
<div class="row <?= $ocultarE ?>">
  <div class="col-12">
    <?= $botonAccion ?>
  </div>
</div>


<div class="table-responsive mt-2">
  <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="tables-bg">
      <tr class="tables-bg">
        <th colspan="2" class=" text-center">DATOS DE LA ESTACION</th>
      </tr>
    </thead>
    <tbody class="bg-light">
      <?php

      if ($numero_lista > 0) {

        echo '<tr>
            <th class="align-middle">Razón Social:</th>
            <td class="align-middle">' . $nombreRS . '</td>
            </tr>

            <tr>
            <th class="align-middle">RFC:</th>
            <td class="align-middle">' . $rfc . '</td>
            </tr>
              
            <tr>
            <th class="align-middle">Dirección:</th>
            <td class="align-middle">' . $contacto . '</td>
            </tr>';

      } else {
        echo "<tr><th colspan='2' class='text-center text-secondary'><small>No se encontró información para mostrar </small></th></tr>";
      }

      ?>

    </tbody>

  </table>
</div>