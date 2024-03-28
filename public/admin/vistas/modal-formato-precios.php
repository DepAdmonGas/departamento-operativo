<?php
require('../../../app/help.php');

$IdPrecio = $_GET['Id'];
$year = $_GET['year'];
$mes = $_GET['mes'];
$action = $_GET['action'];
 
 
$oldDate = strtotime($year.'-'.$mes.'-01');
$fechaMin = date('Y-m-d', $oldDate);

$sqlFormato = "SELECT * FROM op_formato_precios WHERE id = '".$IdPrecio."' ";
$resultFormato = mysqli_query($con, $sqlFormato);
$numeroFormato = mysqli_num_rows($resultFormato);

while($rowFormato = mysqli_fetch_array($resultFormato, MYSQLI_ASSOC)){
$fecha = $rowFormato['fecha'];
}

?>

<div class="modal-header">
  <h5 class="modal-title">Agregar precios</h5>
</div>


<div class="modal-body">

<div class="text-secondary mb-1">Fecha:</div>
<input type="date" class="form-control rounded-0 mb-3" min="<?=$fechaMin;?>" id="Fecha" value="<?=$fecha;?>">



<div style="overflow-y: hidden;">
<table class="table table-sm table-bordered mt-2" style="font-size: .85em;">
	<thead>
		<tr>
			<th class="text-center align-middle">Producto</th>
			<th class="text-center align-middle">Pemex</th>

			<th class="text-center align-middle">Delivery G500 Network-Vopack</th>	
			<th class="text-center align-middle">Delivery G500 Network-Tuxpan</th>	
			<th class="text-center align-middle">Pick up G500 Network-Vopack</th>			
			<th class="text-center align-middle">Pick up G500 Network-Tuxpan</th>
			<th class="text-center align-middle">Tuxpan G500 CORP</th>
			<th class="text-center align-middle">Tizayuca</th>
			<th class="text-center align-middle">$ Pick up sin flete</th>

			
		</tr>
	</thead>
	<tbody>

<?php 
$sql_lista = "SELECT * FROM op_formato_precios_detalle WHERE id_precio = '".$IdPrecio."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$id = $row_lista['id'];
$productoFP = $row_lista['producto'];

if($row_lista['pemex'] == 0){
$pemex = "";
}else{
$pemex = $row_lista['pemex']; 
}

if($row_lista['delivery'] == 0){
$delivery = "";
}else{
$delivery = $row_lista['delivery']; 
}

if($row_lista['pickup_vopack'] == 0){
$pickupvopack = "";
}else{
$pickupvopack = $row_lista['pickup_vopack']; 
}

if($row_lista['pickup_tuxpan'] == 0){
$pickuptuxpan = "";
}else{
$pickuptuxpan = $row_lista['pickup_tuxpan']; 
}

if($row_lista['tizayuca'] == 0){
$tizayuca = "";
}else{
$tizayuca = $row_lista['tizayuca']; 
}

if($row_lista['pickup_sinflete'] == 0){
$pickupsinflete = "";
}else{
$pickupsinflete = $row_lista['pickup_sinflete']; 
}

if($row_lista['tuxpan_g500'] == 0){
$tuxpang500 = "";
}else{
$tuxpang500 = $row_lista['tuxpan_g500']; 
}

if($row_lista['delivery_vopack'] == 0){
$deliveryvopack = "";
}else{
$deliveryvopack = $row_lista['delivery_vopack']; 
}

if($row_lista['delivery_tuxpan'] == 0){
$deliverytuxpan = "";
}else{
$deliverytuxpan = $row_lista['delivery_tuxpan']; 
}


echo '<tr>
<td class="align-middle"><b>'.$productoFP.'</b></td>

<td class="p-0 m-0">
<input type="number" class="form-control rounded-0 border-0 p-1 text-center" value="'.$pemex.'" oninput="EditPrecio(this,'.$id.',1)" style="font-size: .9em;"/>
</td>

<td class="p-0 m-0">
<input type="number" class="form-control rounded-0 border-0 p-1 text-center" value="'.$deliveryvopack.'" oninput="EditPrecio(this,'.$id.',10)" style="font-size: .9em;"/>
</td>

<td class="p-0 m-0">
<input type="number" class="form-control rounded-0 border-0 p-1 text-center" value="'.$deliverytuxpan.'" oninput="EditPrecio(this,'.$id.',11)" style="font-size: .9em;"/>
</td>

<td class="p-0 m-0">
<input type="number" class="form-control rounded-0 border-0 p-1 text-center" value="'.$pickupvopack.'" oninput="EditPrecio(this,'.$id.',3)" style="font-size: .9em;"/>
</td>

<td class="p-0 m-0">
<input type="number" class="form-control rounded-0 border-0 p-1 text-center" value="'.$pickuptuxpan.'" oninput="EditPrecio(this,'.$id.',4)" style="font-size: .9em;"/>
</td>

<td class="p-0 m-0">
<input type="number" class="form-control rounded-0 border-0 p-1 text-center" value="'.$tuxpang500.'" oninput="EditPrecio(this,'.$id.',9)" style="font-size: .9em;"/>
</td>

<td class="p-0 m-0">
<input type="number" class="form-control rounded-0 border-0 p-1 text-center" value="'.$tizayuca.'" oninput="EditPrecio(this,'.$id.',5)" style="font-size: .9em;"/>
</td>

<td class="p-0 m-0">
<input type="number" class="form-control rounded-0 border-0 p-1 text-center" value="'.$pickupsinflete.'" oninput="EditPrecio(this,'.$id.',6)" style="font-size: .9em;"/>
</td>


</tr>';

}
?>		
	</tbody>									
</table>
</div>


<div  class="row mt-2 justify-content-md-center">
 
 <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 "> 

 <div style="overflow-y: hidden;">   
    <table class="table table-sm table-bordered" style="font-size: .85em;">
  <thead>
    <tr>
      <th class="align-middle text-center" colspan="2">Precio Transporte</th>
    </tr>
  </thead>
  <tbody>

<?php 
$sql = "SELECT * FROM op_formato_precios_transporte WHERE id_formato = '".$IdPrecio."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

$idTransporte = $row['id'];

if($row['precio'] == 0){
$precioT = "";
}else{
$precioT = $row['precio']; 
}

echo '<tr>
<td class="align-middle"><b>'.$row['detalle'].'</b></td>

<td class="p-0 m-0">
<input type="number" class="form-control rounded-0 border-0 p-1 text-center" value="'.$precioT.'" oninput="EditPrecio(this,'.$idTransporte.',7)" style="font-size: .9em;"/>
</td>
</tr>';

}
?>    
  </tbody>
   
</table>
</div>

</div>

</div>

</div>


<div class="modal-footer">
<?php if($action == 1){

echo '<button type="button" class="btn btn-secondary rounded-0" onclick="Cancelar('.$IdPrecio.','.$year.','.$mes.')">Cancelar</button>';
echo '<button type="button" class="btn btn-primary rounded-0" onclick="Guardar('.$IdPrecio.','.$year.','.$mes.')">Agregar</button>';

}else{

echo '<button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Cancelar</button>';
echo '<button type="button" class="btn btn-primary rounded-0" data-dismiss="modal">Guardar</button>';

} ?>
  
  
</div>
