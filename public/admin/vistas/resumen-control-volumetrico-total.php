<?php
require('../../../app/help.php');
$IdReporte = $_GET['IdReporte'];
$GET_mes = $_GET['Mes'];


$sql_lista = "SELECT * FROM op_control_volumetrico_resumen WHERE id_mes = '".$IdReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$producto = $row_lista['producto'];
$dato1 = $row_lista['dato1'];

if ($row_lista['dato2'] == 0) {
$dato2 = "";
$Diferencia1 = "";
}else{
$dato2 = $row_lista['dato2'];
$Diferencia1 = $dato1 - $dato2;
} 

$dato3 = $row_lista['dato3'];
$dato4 = $row_lista['dato4'];
$dato5 = $row_lista['dato5'];
$dato6 = $row_lista['dato6'];
$dato7 = $row_lista['dato7'];
$dato8 = $row_lista['dato8'];
$dato9 = $row_lista['dato9'];
$dato10 = $row_lista['dato10'];
$comentario = $row_lista['comentario'];

if ($producto == "G SUPER") {
$bgproducto = "bg-super";
}else if ($producto == "G PREMIUM") {
$bgproducto = "bg-premium";
}else if ($producto == "G DIESEL") {
$bgproducto = "bg-diesel";
}


$Diferencia2 = $dato3 - $dato4;
$Diferencia3 = $dato5 - $dato6;
$Diferencia4 = $dato7 - $dato8;
$Diferencia5 = $dato9 - $dato10;

if( is_numeric($Diferencia1) AND ($Diferencia1 >= 0) ){
$color1 = "text-black";
}else{
$color1 = "text-danger";
}

if( is_numeric($Diferencia2) AND ($Diferencia2 >=0) ){
$color2 = "text-black";
}else{
$color2 = "text-danger";
}

if( is_numeric($Diferencia3) AND ($Diferencia3 >=0) ){
$color3 = "text-black";
}else{
$color3 = "text-danger";
}

if( is_numeric($Diferencia4) AND ($Diferencia4 >=0) ){
$color4 = "text-black";
}else{
$color4 = "text-danger";
}

if( is_numeric($Diferencia5) AND ($Diferencia5 >=0) ){
$color5 = "text-black";
}else{
$color5 = "text-danger";
}

$GTdato3 = $GTdato3 + $dato3;
$GTdato4 = $GTdato4 + $dato4;
$GTdato5 = $GTdato5 + $dato5;
$GTdato6 = $GTdato6 + $dato6;
$GTdato7 = $GTdato7 + $dato7;
$GTdato8 = $GTdato8 + $dato8;
$GTdato9 = $GTdato9 + $dato9;
$GTdato10 = $GTdato10 + $dato10;
}


?>



<div class="border mb-3">
<div class="p-3">

<div ><b>GRAN TOTAL</b></div>
<hr>

<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0 font-weight-light">

<tr>
<td class="bg-success text-white"><b><?=nombremes($GET_mes);?></b></td>
<td>Rep. Volumetrico</td>
<td>Reg. Contables</td>
</tr>
<tr>
<td>Compras L</td>
<td class="text-right font-weight-bold"><?=number_format($GTdato3);?></td>
<td class="text-right font-weight-bold"><?=number_format($GTdato4);?></td>
</tr>
<tr>
<td>$</td>
<td class="text-right font-weight-bold">$ <?=number_format($GTdato5,2);?></td>
<td class="text-right font-weight-bold">$ <?=number_format($GTdato6,2);?></td>
</tr>
<tr>
<td>Ventas L</td>
<td class="text-right font-weight-bold"><?=number_format($GTdato7);?></td>
<td class="text-right font-weight-bold"><?=number_format($GTdato8);?></td>
</tr>
<tr>
<td>$</td>
<td class="text-right font-weight-bold">$ <?=number_format($GTdato9,2);?></td>
<td class="text-right font-weight-bold">$ <?=number_format($GTdato10,2);?></td>
</tr>	
</table>
</div>

</div>
</div>


