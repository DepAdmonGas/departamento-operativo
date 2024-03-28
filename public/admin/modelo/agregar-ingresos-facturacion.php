<?php
require('../../../app/help.php');

function IdReporte($Session_IDEstacion,$GET_year,$con){
   $sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '".$Session_IDEstacion."' AND year = '".$GET_year."' ";
   $result_year = mysqli_query($con, $sql_year);
   while($row_year = mysqli_fetch_array($result_year, MYSQLI_ASSOC)){
   $idyear = $row_year['id'];
   }


   return $idyear;
   }

echo $IdReporte = IdReporte($_POST['idestacion'],$_POST['year'],$con);

ValidaIF($IdReporte,'G SUPER',1,$con);
ValidaIF($IdReporte,'G PREMIUM',1,$con);
ValidaIF($IdReporte,'G DIESEL',1,$con);


ValidaIF($IdReporte,'Aceites y Lubricantes',1,$con);
ValidaIF($IdReporte,'IEPS',1,$con);

ValidaIF($IdReporte,'Público en General',2,$con);
ValidaIF($IdReporte,'Clientes crédito',2,$con);
ValidaIF($IdReporte,'Monederos electronicos',2,$con);
ValidaIF($IdReporte,'Facturas aceites y lubricantes',2,$con);
ValidaIF($IdReporte,'Clientes débito',2,$con);
ValidaIF($IdReporte,'Ventas mostrador',2,$con);
ValidaIF($IdReporte,'TPV',2,$con);
ValidaIF($IdReporte,'Página WEB',2,$con);
ValidaIF($IdReporte,'Clientes débito',2,$con);


function ValidaIF($IdReporte,$detalle,$posicion,$con){

$sql = "SELECT * FROM op_ingresos_facturacion_contabilidad WHERE id_year = '".$IdReporte."' AND detalle = '".$detalle."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if ($numero == 0) {

$sql_insert = "INSERT INTO op_ingresos_facturacion_contabilidad  (
    id_year,
    detalle,
    posicion,
    enero,
    febrero,
    marzo,
    abril,
    mayo,
    junio,
    julio,
    agosto,
    septiembre,
    octubre,
    noviembre,
    diciembre
    )
    VALUES 
    (
    '".$IdReporte."',
    '".$detalle."',
    '".$posicion."',
    0,0,0,0,0,0,0,0,0,0,0,0  
    )";


 mysqli_query($con, $sql_insert);

}
}


//------------------
mysqli_close($con);
//------------------