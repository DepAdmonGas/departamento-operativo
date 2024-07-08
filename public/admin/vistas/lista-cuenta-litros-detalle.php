<?php
require('../../../app/help.php');
$idCuentaLitros = $_GET['idCuentaLitros']; 
 
$sql_lista = "SELECT 
op_cuenta_litros.fecha,
tb_estaciones.nombre,
op_cuenta_litros_detalle.id_detalle,
op_cuenta_litros_detalle.hora,
op_cuenta_litros_detalle.embarque,
op_cuenta_litros_detalle.transporte,
op_cuenta_litros_detalle.producto,
op_cuenta_litros_detalle.tanque,
op_cuenta_litros_detalle.litros, 
op_cuenta_litros_detalle.descarga_neto,
op_cuenta_litros_detalle.descarga_bruto,
op_cuenta_litros_detalle.litros_c,
op_cuenta_litros_detalle.tad,
op_cuenta_litros_detalle.unidad,
op_cuenta_litros_detalle.venta_momento,
op_cuenta_litros_detalle.folio_merma,
op_cuenta_litros_detalle.comentario,
op_cuenta_litros_detalle.archivo
 
FROM op_cuenta_litros 
INNER JOIN op_cuenta_litros_detalle ON op_cuenta_litros.id_cuenta_litros = op_cuenta_litros_detalle.id_cuenta_litros
INNER JOIN tb_estaciones ON op_cuenta_litros.id_estacion = tb_estaciones.id
WHERE op_cuenta_litros_detalle.id_cuenta_litros = '".$idCuentaLitros."' ORDER BY op_cuenta_litros_detalle.producto DESC";

$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
?>

<div class="col-12">
  
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.go(-1)"  class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Tabla de Descarga (Cuenta litros)</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase"> Detalle de Tabla de Descarga</li>
</ol>
</div>
 
<div class="row"> 
<div class="col-12"> 
<h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Detalle de Tabla de Descarga</h3> 
</div>
</div>

<hr>
</div>


<?php
  
if ($numero_lista > 0){
echo '<div class="row">';
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$id_detalle = $row_lista['id_detalle'];
$fecha = FormatoFecha($row_lista['fecha']);
$hora = date("g:i a",strtotime($row_lista['hora']));
$nombreES = $row_lista['nombre'];

$tanque = $row_lista['tanque'];
$producto = $row_lista['producto'];
$embarque = $row_lista['embarque'];
$transporte = $row_lista['transporte'];

$litros = $row_lista['litros'];
$descarga_neto = $row_lista['descarga_neto'];
$descarga_bruto = $row_lista['descarga_bruto'];
$litros_c = $row_lista['litros_c'];
$comentario = $row_lista['comentario'];

$tad = $row_lista['tad'];
$unidad = $row_lista['unidad'];
$venta_momento = $row_lista['venta_momento'];
$folio_merma = $row_lista['folio_merma'];

$res_neto = number_format($descarga_neto - $litros + $venta_momento,2);
$res_bruto = number_format($descarga_bruto - $litros + $venta_momento,2);
$res_lts_c = number_format($litros_c - $litros,2);

$porcentaje_neto = 100; 

if (is_numeric($res_bruto) && is_numeric($porcentaje_neto) && is_numeric($res_neto) && $res_neto != 0) {
  $porcentaje_bruto = number_format((($res_bruto * $porcentaje_neto) / -$res_neto),0);
  $porcentaje_lts_c = number_format((($res_lts_c * $porcentaje_neto) / -$res_neto),0);
}else{
  $porcentaje_bruto = 0; // O maneja el error de manera adecuada
  $porcentaje_lts_c = 0; // O maneja el error de manera adecuada

}

$tolerancia = number_format((($litros * 0.55) / 100),0);
$reclamomerma = number_format((($litros_c - $litros) + $tolerancia),0);


if($reclamomerma > 0 ){
$mermaValue = 0;
}else{
$mermaValue = $reclamomerma;
}

$archivo = $row_lista['archivo'];

if($embarque == "Pemex"){
$ocultarLabel = "d-none";
}else{
$ocultarLabel = "";
}


  echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">';

  echo '<div class="table-responsive">
  <table id="tabla_bitacora" class="custom-table" style="font-size: 0.8em;" width="100%">

  <thead>
  <tr class="text-center align-middle text-white" style="background: #7668af">
  <th colspan="4">'.$fecha.','.$hora.' <br></th>
  <th rowspan="13" class="bg-white">
  <div style="height: 100%; display: flex; align-items: center; justify-content: center;">
  <img src="'.RUTA_ARCHIVOS.'cuenta-litros/'.$archivo.'" alt="Imagen" style="max-width: 100%; max-height: 100%; width: auto; height: auto;">
  </div>
  </th>
  </tr>

  <tr class="text-center align-middle text-white" style="background: #7668af">
  <td class="fw-bold" colspan="1">Tipo</td>
  <td class="fw-bold" colspan="3">'.$embarque.' <label class="'.$ocultarLabel.'">/ '.$transporte.'</label></td>
  </tr>
  
  <tr class="text-center align-middle text-white" style="background: #7668af">
  <td class="fw-bold">Tanque</td>
  <td>'.$tanque.'</td>

  <th>Producto</th>
  <td class="font-weight-bold ">'.$producto.'</td>
  </tr>

  <tr class="text-center align-middle text-white" style="background: #7668af">
  <td class="fw-bold">TAD</th>
  <td>'.$tad.'</td>

  <th>Unidad</th>
  <td class="font-weight-bold ">'.$unidad.'</td>
  </tr>

  <tr class="text-center align-middle text-white" style="background: #84b6f4">
  <td class="fw-bold">Factura</th>
  <th>Tirilla de Descarga Neto</th>
  <th>Tirilla de Descarga Bruto</th>
  <td class="fw-bold">Cuenta Litros a 20° C</th>
  </tr>

  <tr class="text-center align-middle" >
    <td class="fw-bold bg-white" rowspan="2">'.$litros.'</td>
    <td class="fw-bold bg-white">'.$descarga_neto.'</td>
    <td class="fw-bold bg-white">'.$descarga_bruto.'</td>
    <td class="fw-bold bg-white">'.$litros_c.'</td>
  </tr>

   <tr class="text-center align-middle" style="background: #f4b084">
    <td>'.$res_neto.'</td>
    <td>'.$res_bruto.'</td>
    <td>'.$res_lts_c.'</td>
  </tr>

  <tr class="text-center align-middle">
    <td class="fw-bold bg-white" rowspan="2">Total Merma</td>
    <td style="background: #f4b084">'.$res_neto.'</td>
    <td style="background: #f4b084">'.$res_bruto.'</td>
    <td style="background: #f4b084">'.$res_lts_c.'</td>
  </tr>

    <tr class="text-center align-middle" style="background: #fcfcda">
    <td>'.$porcentaje_neto.'%</td>
    <td>'.$porcentaje_bruto.'</td>
    <td>'.$porcentaje_lts_c.'</td>
  </tr>

  <tr class="text-center align-middle">
    <td class="fw-bold text-white" style="background: #84b6f4">Tolerancia Permitida</td>
    <th class="text-white" style="background: #84b6f4">'.$tolerancia.'</th>
    <th class="text-white" style="background: #84b6f4">'.$litros_c.'</th>
    <td class="fw-bold text-white" style="background: #84b6f4">'.$mermaValue.'</td>
  </tr>

  <tr class="text-center align-middle">
    <td colspan="2" class="fw-bold text-white bg-success">Venta al momento</td>
    <td colspan="2" class="fw-bold bg-white" >'.$venta_momento.'</th>
  </tr>

   <tr class="text-center align-middle">
    <td colspan="2" class="fw-bold text-white bg-success">Folio de merma</td>
    <td colspan="2" class="fw-bold bg-white" >'.$folio_merma.'</th>
  </tr>


  <tr>
  <td colspan="1" class="fw-bold bg-white text-start align-middle">Comentarios:</td>
  <td colspan="3" class="fw-normal bg-white text-start align-middle">'.$comentario.'</td>

  </tr>

  </thead>

  </table>
  </div>';


echo '</div>';

}


echo '</div>';

}else{

echo '<header class="bg-white py-5">
<div class="container px-5">
<div class="row gx-5 align-items-center justify-content-center">

<div class="col-xl-5 col-xxl-6 d-xl-block text-center">
<img class="my-2" style="width: 100%" src="'.RUTA_IMG_ICONOS.'no-busqueda.png" width="50%">
</div>

<div class="col-lg-8 col-xl-7 col-xxl-6">
<div class="my-2 text-center"> <h1 class="display-3 fw-bolder text-dark">No se encontró la información</h1> </div>';

}

?>


  
   




