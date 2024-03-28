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

 
<div class="row">

<?php
 
 
if ($numero_lista > 0){
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

$res_neto = $descarga_neto - $litros;
$res_bruto = $descarga_bruto - $litros;
$res_lts_c = $litros_c - $litros;

$porcentaje_neto = 100; 
$porcentaje_bruto = number_format((($res_bruto * $porcentaje_neto) / -$res_neto),2);
$porcentaje_lts_c = number_format((($res_lts_c * $porcentaje_neto) / -$res_neto),2);

$tolerancia = number_format((($litros * 0.55) / 100),0);
$reclamomerma = number_format(($tolerancia + $res_lts_c),0);

$archivo = $row_lista['archivo'];

if($embarque == "Pemex"){
$ocultarLabel = "d-none";
}else{
$ocultarLabel = "";
}


echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-2 mb-1">
<div class="border p-3">';


echo '<div class="row">';

echo '<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 mt-2 mb-1">';
echo '<div class="table-responsive">
<table class="table table-bordered table-sm pb-0 mb-0" style="font-size: 0.9em;">


  <tr class="text-center align-middle text-white" style="background: #7668af">
    <th class="font-weight-bold" colspan="4">'.$fecha.','.$hora.' <br></th>
  </tr>


  <tr class="text-center align-middle text-white" style="background: #7668af">
    <th class="font-weight-bold" colspan="1">Tipo</th>
    <th class="font-weight-bold" colspan="3">'.$embarque.' <label class="'.$ocultarLabel.'">/ '.$transporte.'</label></th>
  </tr>
  
  <tr class="text-center align-middle text-white" style="background: #7668af">
    <th class="font-weight-bold">Tanque</th>
    <td class="font-weight-bold">'.$tanque.'</td>

    <th class="font-weight-bold">Producto</th>
    <td class="font-weight-bold ">'.$producto.'</td>
  </tr>

    <tr class="text-center align-middle text-white" style="background: #7668af">
    <th class="font-weight-bold">TAD</th>
    <td class="font-weight-bold">'.$tad.'</td>

    <th class="font-weight-bold">Unidad</th>
    <td class="font-weight-bold ">'.$unidad.'</td>
  </tr>

 <tr class="text-center align-middle text-white" style="background: #84b6f4">
    <th class="font-weight-bold">Factura</th>
    <th class="font-weight-bold">Tirilla de Descarga Neto</th>
    <th class="font-weight-bold">Tirilla de Descarga Bruto</th>
    <th class="font-weight-bold">Cuenta Litros a 20° C</th>
 </tr>

  <tr class="text-center align-middle">
    <td class="font-weight-bold" rowspan="2">'.$litros.'</td>
    <td class="font-weight-bold">'.$descarga_neto.'</td>
    <td class="font-weight-bold">'.$descarga_bruto.'</td>
    <td class="font-weight-bold">'.$litros_c.'</td>
 </tr>

   <tr class="text-center align-middle" style="background: #f4b084">
    <td class="font-weight-bold">'.$res_neto.'</td>
    <td class="font-weight-bold">'.$res_bruto.'</td>
    <td class="font-weight-bold">'.$res_lts_c.'</td>
 </tr>


  <tr class="text-center align-middle">
    <th class="font-weight-bold" rowspan="2">Total Merma</th>
    <td class="font-weight-bold" style="background: #f4b084">'.$res_neto.'</td>
    <td class="font-weight-bold" style="background: #f4b084">'.$res_bruto.'</td>
    <td class="font-weight-bold" style="background: #f4b084">'.$res_lts_c.'</td>
 </tr>

    <tr class="text-center align-middle" style="background: #fcfcda">
    <td class="font-weight-bold">'.$porcentaje_neto.'%</td>
    <td class="font-weight-bold">'.$porcentaje_bruto.'</td>
    <td class="font-weight-bold">'.$porcentaje_lts_c.'</td>
 </tr>

 <tr class="text-center align-middle">
    <th class="font-weight-bold text-white" style="background: #84b6f4">Tolerancia +/-</th>
    <td class="font-weight-bold" style="background: #f4b084">'.$tolerancia.'</th>
    <th class="font-weight-bold text-white" style="background: #84b6f4">Reclamación de merma</td>
    <td class="font-weight-bold" style="background: #f4b084">'.$reclamomerma.'</td>
 </tr>

  <tr class="text-center align-middle">
    <th colspan="2" class="font-weight-bold text-white bg-success">Venta al momento</th>
    <td colspan="2" class="font-weight-bold" >'.$venta_momento.'</th>
 </tr>

   <tr class="text-center align-middle">
    <th colspan="2" class="font-weight-bold text-white bg-success">Folio de merma</th>
    <td colspan="2" class="font-weight-bold" >'.$folio_merma.'</th>
 </tr>

</table>
</div>
</div>


<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mt-2 mb-1">
<img class="border" src="'.RUTA_ARCHIVOS.'cuenta-litros/'.$archivo.'" width="100%" height="100%">
</div>


<div class="col-12 mt-2 mb-1">

<div class="card">
  <div class="card-body">
    <b>Comentarios:</b> '.$comentario.' 
  </div>
</div>

</div>

</div>';

 

echo '</div>
</div>';

}


}else{

echo '<div class="col-12 pb-0 mb-0">
<div class="alert alert-secondary text-center mb-0" role="alert">
  No se encontró información para mostrar.
</div>
</div>';

}

?>

</div>
  
   




