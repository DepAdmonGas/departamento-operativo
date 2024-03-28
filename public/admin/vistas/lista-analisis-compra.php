<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$GET_year = $_GET['year'];
$GET_mes = $_GET['mes']; 

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}

function IdReporte($idEstacion,$GET_year,$GET_mes,$con){
   $sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '".$idEstacion."' AND year = '".$GET_year."' ";
   $result_year = mysqli_query($con, $sql_year);
   while($row_year = mysqli_fetch_array($result_year, MYSQLI_ASSOC)){
   $idyear = $row_year['id'];
   }

   $sql_mes = "SELECT id, id_year, mes FROM op_corte_mes WHERE id_year = '".$idyear."' AND mes = '".$GET_mes."' ";
   $result_mes = mysqli_query($con, $sql_mes);
   while($row_mes = mysqli_fetch_array($result_mes, MYSQLI_ASSOC)){
   $idmes = $row_mes['id'];
   }
   return $idmes;
   }

   $IdReporte = IdReporte($idEstacion,$GET_year,$GET_mes,$con); 

   ValidarEmbarques($idEstacion,$IdReporte,$con);

   function ValidarEmbarques($idEstacion,$IdReporte,$con){

    $sql_lista = "SELECT * FROM op_embarques WHERE id_mes = '".$IdReporte."' AND (bruto = 0 OR neto = 0) ";
    $result_lista = mysqli_query($con, $sql_lista);
    $numero_lista = mysqli_num_rows($result_lista);
    while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

    $id = $row_lista['id'];
    $fecha = $row_lista['fecha'];
    $embarque = $row_lista['embarque'];
    $importef = $row_lista['importef'];

    $BuscarBrutoNeto = BuscarBrutoNeto($idEstacion,$fecha,$importef,$con);

    $sql_edit = "UPDATE op_embarques SET 
    bruto = '".$BuscarBrutoNeto['bruto']."',
    neto = '".$BuscarBrutoNeto['neto']."'
    WHERE id='".$id."' ";
    mysqli_query($con, $sql_edit);

   }
   }

   function BuscarBrutoNeto($idEstacion,$fecha,$importef,$con){

    $sql_lista = "SELECT neto, bruto FROM op_mediciones WHERE id_estacion = '".$idEstacion."' AND fecha = '".$fecha."' AND factura = '".$importef."' ";
    $result_lista = mysqli_query($con, $sql_lista);
    $numero_lista = mysqli_num_rows($result_lista);
    while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

     $neto = $row_lista['neto'];
     $bruto = $row_lista['bruto'];
   }

   $array = array('neto' => $neto, 'bruto' => $bruto);

   return $array;
  }

function Detalle($IdReporte,$producto,$con){

   if($producto == "G SUPER"){
   $Color = "background: #76bd1d;color: white;";
   }else if($producto == "G PREMIUM"){
   $Color = "background: #e21683;color: white;";
   }else if($producto == "G DIESEL"){
   $Color = "background: #5e0f8e;color: white;";
   }



$sql_lista = "SELECT * FROM op_embarques WHERE id_mes = '".$IdReporte."' AND producto = '".$producto."' ORDER BY fecha ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
if ($numero_lista > 0) {
$contenido .= '

<div class="table-responsive">
<table class="table table-bordered table-sm mb-2 mt-1" style="font-size: 0.8em;">
<thead>
   <tr style="'.$Color.'">
   <th class="font-weight-bold text-center" colspan="10">'.$producto.'</th>
   </tr>
  <tr>
    <td class="font-weight-bold text-center align-middle" colspan="2"></td>
    <td class="font-weight-bold text-center align-middle">Lts. Factura</td>
    <td class="font-weight-bold text-center align-middle">Tipo</td>
    <td class="font-weight-bold text-center align-middle">Bruto</td>
    <td class="font-weight-bold text-center align-middle">Dif</td>
    <td class="font-weight-bold text-center align-middle">Neto</td>
    <td class="font-weight-bold text-center align-middle">Dif</td>
    <td class="font-weight-bold text-center align-middle">Metro Contador</td>
    <td class="font-weight-bold text-center align-middle">Dif</td>
  </tr>
</thead>';
$contenido .= '<tbody>';
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$explode = explode("-", $row_lista['fecha']);
$id = $row_lista['id'];
if($row_lista['bruto'] == 0){
$Bruto = "";   
}else{
$Bruto = $row_lista['bruto'];
}

if($row_lista['neto'] == 0){
$Neto = "";
}else{
$Neto = $row_lista['neto'];
}

$Diferencia1 = $Bruto - $row_lista['importef'];
$Diferencia2 = $Neto - $row_lista['importef'];

$MCPO = round($row_lista['importef'] * 0.5/100);
$MetroContador = $row_lista['importef'] - $MCPO;

$Diferencia3 = $MetroContador - $row_lista['importef'];

$TOImporteF = $TOImporteF + $row_lista['importef'];
$TOBruto = $TOBruto + $row_lista['bruto'];
$TODif1 = $TODif1 + $Diferencia1;
$TONeto = $TONeto + $row_lista['neto'];
$TODif2 = $TODif2 + $Diferencia2;
$TOMC = $TOMC + $MetroContador;
$TODif3 = $TODif3 + $Diferencia3;

$contenido .= '<tr>';
$contenido .= '<td class="align-middle">'.$explode[2].'</td>';
$contenido .= '<td class="align-middle">'.get_nombre_dia($row_lista['fecha']).'</td>';
$contenido .= '<td class="align-middle" id="LtsF'.$id.'">'.number_format($row_lista['importef']).'</td>';
$contenido .= '<td class="align-middle">'.$row_lista['embarque'].'</td>';
$contenido .= '<td class="align-middle p-0 m-0"><input type="number" class="form-control pr-1 pl-1 pb-1 border-0 rounded-0" style="font-size: 0.9em;" onkeyup="BrutoNeto(this,1,'.$id.')" value="'.$Bruto.'"></td>';
$contenido .= '<td class="align-middle" id="Dif1'.$id.'">'.number_format($Diferencia1).'</td>';
$contenido .= '<td class="align-middle p-0 m-0"><input type="number" class="form-control pr-1 pl-1 pb-1 border-0 rounded-0" style="font-size: 0.9em;" onkeyup="BrutoNeto(this,2,'.$id.')" value="'.$Neto.'"></td>';
$contenido .= '<td class="align-middle" id="Dif2'.$id.'">'.number_format($Diferencia2).'</td>';
$contenido .= '<td class="align-middle">'.number_format($MetroContador).'</td>';
$contenido .= '<td class="align-middle">'.number_format($Diferencia3).'</td>';
$contenido .= '</tr>';  
}

$contenido .= '<tr>';
$contenido .= '<td></td>';
$contenido .= '<td></td>';
$contenido .= '<td class="font-weight-bold">'.number_format($TOImporteF).'</td>';
$contenido .= '<td></td>';
$contenido .= '<td class="font-weight-bold">'.number_format($TOBruto).'</td>';
$contenido .= '<td class="font-weight-bold">'.number_format($TODif1).'</td>';
$contenido .= '<td class="font-weight-bold">'.number_format($TONeto).'</td>';
$contenido .= '<td class="font-weight-bold">'.number_format($TODif2).'</td>';
$contenido .= '<td class="font-weight-bold">'.number_format($TOMC).'</td>';
$contenido .= '<td class="font-weight-bold">'.number_format($TODif3).'</td>';
$contenido .= '</tr>'; 

$contenido .= '</tbody></table>
</div>';

}else{
$contenido .= '<div class="text-center text-secondary p-2 border mb-2 mt-1"><small>No se encontró información para mostrar </small></div>';
}

return $contenido;
}

$Detalle1 = Detalle($IdReporte,'G SUPER',$con);
$Detalle2 = Detalle($IdReporte,'G PREMIUM',$con);
$Detalle3 = Detalle($IdReporte,'G DIESEL',$con);

?>

<div class="cardAG p-3">

<div class=""><h4><?=$estacion;?></h4></div> 
<hr>


<div class="row">

<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12"> 
<?=$Detalle1;?>
</div>

<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12"> 
<?=$Detalle2;?>
</div>

<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12"> 
<?=$Detalle3;?>
</div>
</div>

</div>


