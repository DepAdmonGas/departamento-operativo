<?php 
require('../../../app/help.php');

$year = $_POST['Year'];
$mes = $_POST['Mes'];
$fechaPrecio = $_POST['Fecha'];

function id($con){
$sql = "SELECT id FROM op_formato_precios ORDER BY id desc LIMIT 1";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if ($numero == 0) {
$numid = 1;
}else{
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$numid = $row['id'] + 1;
}
}
return $numid;
}
 
function Producto($id, $con){
  
	$sql_insert1 = "INSERT INTO op_formato_precios_detalle_c (
    id_precio,	
    producto,	
   
    pemex,
    delivery_montera,
    delivery_tuxpan,
    delivery_vopak,

    pickup_montera,
    pickup_tuxpan,
    pickup_vopak,
    pickup_tizayuca,
    pickup_puebla
    )

    VALUES 

    ('".$id."','Super',0,0,0,0,0,0,0,0,0),
    ('".$id."','Premium',0,0,0,0,0,0,0,0,0),
    ('".$id."','Diesel',0,0,0,0,0,0,0,0,0)"; 

    mysqli_query($con, $sql_insert1);

    }
  
	function Precios($id, $con){

	$sql_insert1 = "INSERT INTO op_formato_precios_transporte (
    id_formato,
    detalle,
    precio
    )
    VALUES 
    ('".$id."','Tuxpan',0.63),
    ('".$id."','Tizayuca',0.4),
    ('".$id."','Puebla',0.4844)"; 

	mysqli_query($con, $sql_insert1);

	}
   
   $id = id($con);
 
    $sql_insert = "INSERT INTO op_formato_precios (
    id,
    fecha,
    year,
    mes,
    estatus
    )
    VALUES 
    ( 
    '".$id."',
    '".$fechaPrecio."',
    '".$year."',
    '".$mes."',
    0)"; 

    if(mysqli_query($con, $sql_insert)){

    Producto($id, $con);
    Precios($id, $con);

    echo $id;
    }else{
    echo 0;    
    }

    //------------------
mysqli_close($con);
//------------------