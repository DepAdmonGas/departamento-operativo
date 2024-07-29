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
 
function Detalle($IdReporte,$producto,$con){


   if($producto == "G SUPER"){
   $Color = "background: #76bd1d;color: white;";
   $total = 4920;
   }else if($producto == "G PREMIUM"){
   $Color = "background: #e21683;color: white;";
   $total = 4190; 
   }else if($producto == "G DIESEL"){
   $Color = "background: #5e0f8e;color: white;";
   $total = 903;
   }

   $contenido = "";
   $TOImporteF = 0;
   $TOBruto = 0;
   $TODif1 = 0;
   $TONeto = 0;
   $TODif2 = 0;
   $TOMC = 0;
   $TODif3 = 0;
   $MermaBruto = 0;
  $MermaNeto = 0;
  $MermaMC = 0;

$sql_lista = "SELECT * FROM op_embarques WHERE id_mes = '".$IdReporte."' AND producto = '".$producto."' ORDER BY fecha ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$explode = explode("-", $row_lista['fecha']);
$id = $row_lista['id'];
if($row_lista['bruto'] == 0){
$Bruto = 0;   
}else{
$Bruto = $row_lista['bruto'];
}

if($row_lista['neto'] == 0){
$Neto = 0;
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

$MermaBruto = $TOImporteF - $TOBruto;
$MermaNeto = $TOImporteF - $TONeto;
$MermaMC = $TOImporteF - $TOMC;
}

if ($TOImporteF != 0) {
    $P_IF_MB = $MermaBruto / $TOImporteF;
    $P_MN_IF = $MermaNeto / $TOImporteF;
    $P_MI_IF = $MermaMC / $TOImporteF;
    $P_MM_IF = $total / $TOImporteF;
} else {
    $P_IF_MB = 0; // o cualquier valor que tenga sentido en tu contexto
    $P_MN_IF = 0;
    $P_MI_IF = 0;
    $P_MM_IF = 0;
}

$contenido .= '<div class="table-responsive">
<table class="custom-table mb-2 mt-1" style="font-size: 0.70em;" width="100%">';

$contenido .= '
<thead>
<tr style="'.$Color.'">
    <th class="font-weight-bold text-center align-middle">'.$producto.'</th>
    <th class="font-weight-bold text-center align-middle"></th>
    <th class="font-weight-bold text-center align-middle">Mermas</th>
    <th class="font-weight-bold text-center align-middle">Porcentaje</th>
</thead>
</tr>';


$contenido .= '<tbody class="bg-white">';
$contenido .= '<tr>
    <th class="font-weight-bold text-center align-middle">Totales</th>
    <td class="font-weight-bold text-center align-middle"></td>
    <td class="font-weight-bold text-center align-middle"></td>
    <td class="font-weight-bold text-center align-middle"></td>
  </tr>';
$contenido .= '<tr>
    <th class="font-weight-bold text-center align-middle">Factura</th>
    <td class="font-weight-bold text-center align-middle">'.number_format($TOImporteF).'</td>
    <td class="font-weight-bold text-center align-middle">0</td>
    <td class="font-weight-bold text-center align-middle"></td>
  </tr>';
$contenido .= '<tr>
    <th class="font-weight-bold text-center align-middle">Bruto</th>
    <td class="font-weight-bold text-center align-middle">'.number_format($TOBruto).'</td>
    <td class="font-weight-bold text-center align-middle">'.number_format($MermaBruto).'</td>
    <td class="font-weight-bold text-center align-middle">'.number_format($P_IF_MB,2).'%</td>
  </tr>';
$contenido .= '<tr>
    <th class="font-weight-bold text-center align-middle">Neto</th>
    <td class="font-weight-bold text-center align-middle">'.number_format($TONeto).'</td>
    <td class="font-weight-bold text-center align-middle">'.number_format($MermaNeto).'</td>
    <td class="font-weight-bold text-center align-middle">'.number_format($P_MN_IF,2).'%</td>
  </tr>';
$contenido .= '<tr>
    <th class="font-weight-bold text-center align-middle">Metro contador</th>
    <td class="font-weight-bold text-center align-middle">'.number_format($TOMC).'</td>
    <td class="font-weight-bold text-center align-middle">'.number_format($MermaMC).'</td>
    <td class="font-weight-bold text-center align-middle">'.number_format($P_MI_IF,2).'%</td>
  </tr>';
$contenido .= '<tr>
    <th class="font-weight-bold text-center align-middle">Inventario</th>
    <td class="font-weight-bold text-center align-middle"></td>
    <td class="font-weight-bold text-center align-middle">'.number_format($total).'</td>
    <td class="font-weight-bold text-center align-middle">'.number_format($P_MM_IF,2).'%</td>
  </tr>';
$contenido .= '</tbody></table>
</div>';

return $contenido;
}

$Detalle1 = Detalle($IdReporte,'G SUPER',$con);
$Detalle2 = Detalle($IdReporte,'G PREMIUM',$con);
$Detalle3 = Detalle($IdReporte,'G DIESEL',$con);
 
?>



<div class="row">
<div class="col-12 mb-3">
<hr>
<h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Subtotales del Analisis de Compra</h3>
</div>

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
 


