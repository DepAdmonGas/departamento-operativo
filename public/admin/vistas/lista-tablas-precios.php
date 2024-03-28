<?php
require('../../../app/help.php');
$idPrecio = $_GET['idPrecio'];


$sql_lista_f = "SELECT fecha FROM op_formato_precios WHERE id = '".$idPrecio."' ";
$result_lista_f = mysqli_query($con, $sql_lista_f);
$numero_lista_f = mysqli_num_rows($result_lista_f);
while($row_lista_f = mysqli_fetch_array($result_lista_f, MYSQLI_ASSOC)){
$fecha = $row_lista_f['fecha']; 
}
 

if("2024-02-20" < $fecha){
$ocultarInfo = "d-none";
$colspanTB = "9";

}else{
$ocultarInfo = "";
$colspanTB = "13";

}
 
  
?>

<div class="table-responsive">
<table class="table table-sm table-bordered mt-2 mb-0" style="font-size: .72em;">
<thead class="">

<tr class="bg-light">
<th class="text-center align-middle"></th>
<th class="text-center align-middle" colspan="<?=$colspanTB?>">Delivery</th>
<th class="text-center align-middle" colspan="13">Pick Up</th>
</tr>

<tr>

<th class="text-center align-middle">Producto</th>
<th class="text-center align-middle text-white" style="background-color: #535252;">Pemex</th>

<th class="text-center align-middle" style="background-color: #d6dce4;">Delivery<br>G500 Network<br>Monterra</th>
<th class="text-center align-middle" style="background-color: #d6dce4;">Diferencia<br>vs<br>Pemex</th>

<th class="text-center align-middle <?=$ocultarInfo?>" style="background-color: #cfcfcf;">Delivery<br>G500 Network<br>Vopak</th>
<th class="text-center align-middle <?=$ocultarInfo?>" style="background-color: #cfcfcf;">Diferencia<br>vs<br>Pemex</th>

<th class="text-center align-middle" style="background-color: #e2efda;">Delivery<br>G500 Network<br>Tuxpan</th>
<th class="text-center align-middle" style="background-color: #e2efda;">Diferencia<br>vs<br>Pemex</th>



<th class="text-center align-middle <?=$ocultarInfo?>" style="background-color: #cfcfcf;">Pick up<br>G500 Network<br>Vopak</th>
<th class="text-center align-middle <?=$ocultarInfo?>" style="background-color: #cfcfcf;">Diferencia<br>vs<br>Pemex</th>

<th class="text-center align-middle" style="background-color: #e2efda;">Pick up<br>G500 Network<br>Tuxpan</th>
<th class="text-center align-middle" style="background-color: #e2efda;">Diferencia<br>vs<br>Pemex</th>

<th class="text-center align-middle" style="background-color: #d6dce4;">Pick up<br>G500 Network<br>Monterra</th>
<th class="text-center align-middle" style="background-color: #d6dce4;">Diferencia<br>vs<br>Pemex</th>


<th class="text-center align-middle" style="background-color: #94b8da;">Pick up<br>G500 Network<br>Tizayuca</th>
<th class="text-center align-middle" style="background-color: #94b8da;">Diferencia<br>vs<br>Pemex</th>

<th class="text-center align-middle" style="background-color: #922d9a;">Pick up<br>G500 Network<br>Puebla</th>
<th class="text-center align-middle" style="background-color: #922d9a;">Diferencia<br>vs<br>Pemex</th>
 
		 
</tr>
</thead>

<tbody>

<?php 

//---------- CONSULTAR PRECIO DE TERMINAL ----------
function PrecioPU($idPrecio,$terminal,$con){

if($terminal == "Tuxpan"){
$detalle = "Tuxpan";

}else if($terminal == "Vopack"){
$detalle = "Vopack";

}else if($terminal == "Atlacomulco"){
$detalle = "Atlacomulco";

}else if($terminal == "Tizayuca"){
$detalle = "Tizayuca";

}else if($terminal == "Puebla"){
$detalle = "Puebla";

}


$sql2 = "SELECT * FROM op_formato_precios_transporte WHERE id_formato = '".$idPrecio."' AND detalle = '".$detalle."' ";
$result2 = mysqli_query($con, $sql2);
$numero2 = mysqli_num_rows($result2);

while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
$valorprecio = $row2['precio'];
}

$precioIVA = number_format(($valorprecio * 0.16),4);
$precioRetencion = number_format(($valorprecio * 0.04),4);
$totalPickUp2 = number_format(($valorprecio + $precioIVA - $precioRetencion),4);

return $totalPickUp2;
}

 $tuxpanVal = PrecioPU($idPrecio,"Tuxpan",$con);
 $vopakVal = PrecioPU($idPrecio,"Vopack",$con);
 $atlacomulcoVal = PrecioPU($idPrecio,"Atlacomulco",$con);
 $tizayucaVal = PrecioPU($idPrecio,"Tizayuca",$con);
 $pueblaVal = PrecioPU($idPrecio,"Puebla",$con);




//---------- TABLA DETALLES DE PRECIOS  ----------
$sql_lista = "SELECT * FROM op_formato_precios_detalle_c WHERE id_precio = '".$idPrecio."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$id = $row_lista['id'];
$productoFP = $row_lista['producto'];

if($row_lista['pemex'] == 0){
$pemex = 0;
}else{
$pemex = $row_lista['pemex']; 
}



//---------- DELIVERY ----------
if($row_lista['delivery_montera'] == 0){
$delivery_montera = 0;
}else{
$delivery_montera = $row_lista['delivery_montera']; 
}

if($row_lista['delivery_vopak'] == 0){
$delivery_vopak = 0;
}else{
$delivery_vopak = $row_lista['delivery_vopak']; 
}
 
if($row_lista['delivery_tuxpan'] == 0){
$delivery_tuxpan = 0;
}else{
$delivery_tuxpan = $row_lista['delivery_tuxpan']; 
}


//---------- PICK UP ----------
if($row_lista['pickup_vopak'] == 0){
$pickup_vopak = 0;
}else{
$pickup_vopak = $row_lista['pickup_vopak']; 
}

if($row_lista['pickup_tuxpan'] == 0){
$pickup_tuxpan = 0;
}else{
$pickup_tuxpan = $row_lista['pickup_tuxpan']; 
}
 
if($row_lista['pickup_montera'] == 0){
$pickup_montera = 0; 
}else{
$pickup_montera = $row_lista['pickup_montera']; 
}

if($row_lista['pickup_tizayuca'] == 0){
$pickup_tizayuca = 0;
}else{
$pickup_tizayuca = $row_lista['pickup_tizayuca']; 
}

if($row_lista['pickup_puebla'] == 0){
$pickup_puebla = 0;
}else{
$pickup_puebla = $row_lista['pickup_puebla']; 
}


$DifPvsMoD = $delivery_montera - $pemex ;
$DifPvsVoD = $delivery_vopak - $pemex ;
$DifPvsTuD = $delivery_tuxpan - $pemex ;


$DifPvsVoP = ($vopakVal + $pickup_vopak) - $pemex;
$DifPvsTuP = ($tuxpanVal + $pickup_tuxpan) - $pemex;
$DifPvsMoP = ($tuxpanVal + $pickup_montera) - $pemex;
$DifPvsTiP = ($tizayucaVal + $pickup_tizayuca) - $pemex;
$DifPvsPuP = ($pueblaVal + $pickup_puebla) - $pemex;


if($row_lista['producto'] == "Super"){
$ColorProducto = "background-color: #74bc1f;";
}else if($row_lista['producto'] == "Premium"){
$ColorProducto = "background-color: #e01883; ";
}else if($row_lista['producto'] == "Diesel"){
$ColorProducto = "background-color: #5c108c;"; 
}



echo '<tr>
<td class="align-middle text-white" style="'.$ColorProducto.'"><b>'.$productoFP.'</b></td>

<td class="p-1 m-0">
<input type="number" class="form-control rounded-0 border-0 p-1 text-center align-middle fw-bold" id="PemexV'.$id.'" value="'.$pemex.'" oninput="EditPrecio(this,'.$id.',1)" style="font-size: .9em;"/>
</td>

<td class="p-0 m-0">
<input type="number" class="form-control rounded-0 border-0 p-1 text-center align-middle" id="MonterraVD'.$id.'" value="'.$delivery_montera.'" oninput="EditPrecio(this,'.$id.',2)" style="font-size: .9em;" />
</td>

<td class="table-light"> 
<input type="number" class="form-control rounded-0 border-0 p-1 text-center bg-light align-middle fw-bold" id="MonterraD'.$id.'" value="'.number_format($DifPvsMoD,4).'" style="font-size: .9em; " disabled/>
</td>


<td class="p-0 m-0 '.$ocultarInfo.' ">
<input type="number" class="form-control rounded-0 border-0 p-1 text-center align-middle" id="VopakVD'.$id.'" value="'.$delivery_vopak.'" oninput="EditPrecio(this,'.$id.',4)" style="font-size: .9em;"/>
</td>

<td class="table-light '.$ocultarInfo.'"> 
<input type="number" class="form-control rounded-0 border-0 p-1 text-center bg-light align-middle fw-bold" id="VopakD'.$id.'" value="'.number_format($DifPvsVoD,4).'" style="font-size: .9em; " disabled/>
</td>


<td class="p-0 m-0">
<input type="number" class="form-control rounded-0 border-0 p-1 text-center bg-white align-middle" id="TuxpanVD'.$id.'" value="'.$delivery_tuxpan.'" onchange="EditPrecio(this,'.$id.',3)" style="font-size: .9em;" disabled/>
</td>

<td class="table-light"> 
<input type="number" class="form-control rounded-0 border-0 p-1 text-center bg-light align-middle fw-bold" id="TuxpanD'.$id.'" value="'.number_format($DifPvsTuD,4).'" style="font-size: .9em; " disabled/>
</td>



<td class="p-0 m-0 '.$ocultarInfo.'">
<input type="number" class="form-control rounded-0 border-0 p-1 text-center" id="VopakVP'.$id.'" value="'.$pickup_vopak.'" oninput="EditPrecio(this,'.$id.',10,)" style="font-size: .9em;"/>
</td>

<td class="table-light '.$ocultarInfo.'"> 
<input type="number" class="form-control rounded-0 border-0 p-1 text-center bg-light fw-bold" id="VopakP'.$id.'" value="'.number_format($DifPvsVoP,4).'" style="font-size: .9em; " disabled/>
</td>


<td class="p-0 m-0">
<input type="number" class="form-control rounded-0 border-0 p-1 text-center" id="TuxpanVP'.$id.'"  value="'.$pickup_tuxpan.'" oninput="EditPrecio(this,'.$id.',9)" style="font-size: .9em;"/>
</td>

<td class="table-light"> 
<input type="number" class="form-control rounded-0 border-0 p-1 text-center bg-light fw-bold" id="TuxpanP'.$id.'" value="'.number_format($DifPvsTuP,4).'" style="font-size: .9em; " disabled/>
</td>


<td class="p-0 m-0"> 
<input type="number" class="form-control rounded-0 border-0 p-1 text-center bg-white" id="MonterraVP'.$id.'" value="'.$pickup_montera.'" oninput="EditPrecio(this,'.$id.',8)" style="font-size: .9em;" disabled/>
</td>

<td class="table-light"> 
<input type="number" class="form-control rounded-0 border-0 p-1 text-center bg-light fw-bold" id="MonterraP'.$id.'" value="'.number_format($DifPvsMoP,4).'" style="font-size: .9em; " disabled/>
</td>


<td class="p-0 m-0">
<input type="number" class="form-control rounded-0 border-0 p-1 text-center" id="TizayuVP'.$id.'" value="'.$pickup_tizayuca.'" oninput="EditPrecio(this,'.$id.',12)" style="font-size: .9em;"/>
</td>

<td class="table-light"> 
<input type="number" class="form-control rounded-0 border-0 p-1 text-center bg-light fw-bold" id="TizayuP'.$id.'" value="'.number_format($DifPvsTiP,4).'" style="font-size: .9em; " disabled/>
</td>

<td class="p-0 m-0">
<input type="number" class="form-control rounded-0 border-0 p-1 text-center" id="PueblaVP'.$id.'" value="'.$pickup_puebla.'" oninput="EditPrecio(this,'.$id.',13)" style="font-size: .9em;"/>
</td>

<td class="table-light"> 
<input type="number" class="form-control rounded-0 border-0 p-1 text-center bg-light fw-bold" id="PueblaP'.$id.'" value="'.number_format($DifPvsPuP,4).'"style="font-size: .9em; " disabled/>
</td>

</tr>';

}
?>		

</tbody>									
</table>
</div>
