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
$dato2 = $row_lista['dato2'];
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
$CProduct0 = "#76bd1d";

}else if ($producto == "G PREMIUM") {
$bgproducto = "bg-premium";
$CProduct0 = "#e21683";

}else if ($producto == "G DIESEL") {
$bgproducto = "bg-diesel";
$CProduct0 = "#000000";
}

$Diferencia1 = $dato1 - $dato2;
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


?>
    

<div class="border mb-3">
<div class="p-3">

<div>
  <b style="color: <?=$CProduct0;?>"><?=$producto ;?></b>
</div>


<hr>

<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0 font-weight-light">

<tr>
<td class="bg-success text-white"><b><?=nombremes($GET_mes);?></b></td>
<td>Rep. Volumetrico</td>
<td>Reg. Contables</td>
<td>Diferencias</td>
</tr>
<tr>
<td>Inventario final</td>
<td class="text-end p-0 pb-0 mb-0">
<input type="number" id="1<?=$id;?>" step="any" style="width: 100%;" class="text-end border-0 font-weight-light pt-1 pb-1" value="<?=$dato1;?>" onkeyup="Edit(1,1,<?=$id;?>,<?=$dato2;?>,<?=$IdReporte;?>,<?=$GET_mes;?>)"></td>

<td class="text-end p-0 pb-0 mb-0">
<input type="number" id="2<?=$id;?>" step="any" style="width: 100%;" class="text-end border-0 font-weight-light pt-1 pb-1" value="<?=$dato2;?>" onkeyup="Edit(2,1,<?=$id;?>,<?=$dato1;?>,<?=$IdReporte;?>,<?=$GET_mes;?>)"></td>

<td class="text-end <?=$color1;?>" id="D1<?=$id;?>"><?=number_format($Diferencia1,2);?></td>
</tr>

<tr>
<td>Compras L</td>

<td class="text-end p-0 pb-0 mb-0">
<input type="number" id="3<?=$id;?>" step="any" style="width: 100%;" class="text-end border-0 font-weight-light pt-1 pb-1" value="<?=$dato3;?>" onkeyup="Edit(3,2,<?=$id;?>,<?=$dato4;?>,<?=$IdReporte;?>,<?=$GET_mes;?>)"></td>

<td class="text-end p-0 pb-0 mb-0">
<input type="number" id="4<?=$id;?>" step="any" style="width: 100%;" class="text-end border-0 font-weight-light pt-1 pb-1" value="<?=$dato4;?>" onkeyup="Edit(4,2,<?=$id;?>,<?=$dato3;?>,<?=$IdReporte;?>,<?=$GET_mes;?>)"></td>
<td class="text-end <?=$color2;?>" id="D2<?=$id;?>"><?=number_format($Diferencia2,2);?></td>
</tr>

<tr>
<td>$</td>

<td class="text-end p-0 pb-0 mb-0">
$ <input type="number" id="5<?=$id;?>" step="any" style="width: 90%;" class="text-end border-0 font-weight-light pt-1 pb-1" value="<?=$dato5;?>" onkeyup="Edit(5,3,<?=$id;?>,<?=$dato6;?>,<?=$IdReporte;?>,<?=$GET_mes;?>)"></td>

<td class="text-end p-0 pb-0 mb-0">
$ <input type="number" id="6<?=$id;?>" step="any" style="width: 90%;" class="text-end border-0 font-weight-light pt-1 pb-1" value="<?=$dato6;?>" onkeyup="Edit(6,3,<?=$id;?>,<?=$dato5;?>,<?=$IdReporte;?>,<?=$GET_mes;?>)"></td>
<td class="text-end <?=$color3;?>" id="D3<?=$id;?>">$ <?=number_format($Diferencia3,2);?></td>
</tr>

<tr>
<td>Ventas L</td>

<td class="text-end p-0 pb-0 mb-0">
<input type="number" id="7<?=$id;?>" step="any" style="width: 100%;" class="text-end border-0 font-weight-light pt-1 pb-1" value="<?=$dato7;?>" onkeyup="Edit(7,4,<?=$id;?>,<?=$dato8;?>,<?=$IdReporte;?>,<?=$GET_mes;?>)"></td>

<td class="text-end p-0 pb-0 mb-0">
<input type="number" id="8<?=$id;?>" step="any" style="width: 100%;" class="text-end border-0 font-weight-light pt-1 pb-1" value="<?=$dato8;?>" onkeyup="Edit(8,4,<?=$id;?>,<?=$dato7;?>,<?=$IdReporte;?>,<?=$GET_mes;?>)"></td>
<td class="text-end <?=$color4;?>" id="D4<?=$id;?>"><?=number_format($Diferencia4,2);?></td>
</tr>

<tr>
<td>$</td>

<td class="text-end p-0 pb-0 mb-0">
$ <input type="number" id="9<?=$id;?>" step="any" style="width: 90%;" class="text-end border-0 font-weight-light pt-1 pb-1" value="<?=$dato9;?>" onkeyup="Edit(9,5,<?=$id;?>,<?=$dato10;?>,<?=$IdReporte;?>,<?=$GET_mes;?>)"></td>

<td class="text-end p-0 pb-0 mb-0">
$ <input type="number" id="10<?=$id;?>" step="any" style="width: 90%;" class="text-end border-0 font-weight-light pt-1 pb-1" value="<?=$dato10;?>" onkeyup="Edit(10,5,<?=$id;?>,<?=$dato9;?>,<?=$IdReporte;?>,<?=$GET_mes;?>)"></td>
<td class="text-end <?=$color5;?>" id="D5<?=$id;?>">$ <?=number_format($Diferencia5,2);?></td>
</tr>

</table>
</div>

<hr>

<div ><small>Comentario:</small></div>
<textarea class="form-control rounded-0 mt-1 font-weight-light" id="Comentario<?=$id;?>" onkeyup="Comentario(<?=$id;?>)"><?=$comentario;?></textarea>

</div>
</div>


<?php

}


$sql = "SELECT * FROM op_control_volumetrico_resumen_aceites WHERE id_mes = '".$IdReporte."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$piezas = $row['piezas'];
$volumetrico = $row['volumetrico'];
$contables = $row['contables'];

$diferenciaA = $volumetrico - $contables;

if( is_numeric($diferenciaA) AND ($diferenciaA >=0) ){
$colorA = "text-black";
}else{
$colorA = "text-danger";
}
}

?>




<div class="border mb-3">
<div class="p-3">

<div ><b>ACEITES</b></div>
<hr>

<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0 font-weight-light">

<tr>
<td class="bg-success text-white"><b><?=nombremes($GET_mes);?></b></td>
<td>Piezas</td>
<td>Rep. Volumetrico</td>
<td>Reg. Contables</td>
<td>Diferencias</td>
</tr>
<tr>
<td>Ventas</td>

<td class="p-0 pb-0 mb-0">
<input type="number" id="Piezas" step="any" style="width: 100%;" class="text-end border-0 font-weight-light pt-1 pb-1" value="<?=$piezas;?>" onkeyup="EditAceites(this,1,<?=$IdReporte;?>)">
</td>

<td class="text-end p-0 pb-0 mb-0">
<input type="number" id="Volumetrico" step="any" style="width: 100%;" class="text-end border-0 font-weight-light pt-1 pb-1" value="<?=$volumetrico;?>" onkeyup="EditAceites(this,2,<?=$IdReporte;?>)">
</td>

<td class="p-0 pb-0 mb-0">
<input type="number" id="Contables" step="any" style="width: 100%;" class="text-end border-0 font-weight-light pt-1 pb-1" value="<?=$contables;?>" onkeyup="EditAceites(this,3,<?=$IdReporte;?>)">
</td>

<td class="text-end <?=$colorA;?>" id="DiferenciaA">$ <?=number_format($diferenciaA,2);?></td>
</tr>
</table>
</div>

</div>
</div>