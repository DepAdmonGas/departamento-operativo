<?php
require('../../../app/help.php');

$IDEstacion = $_POST['IDEstacion'];

function IdCompra($con){
$sql = "SELECT id FROM op_orden_mantenimiento ORDER BY id DESC LIMIT 1 ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if($numero == 0){
$Result = 1;	
}else{
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Result = $row['id'] + 1;
}	
}
return $Result;
}

function Folio($con){
$sql = "SELECT folio FROM op_orden_mantenimiento ORDER BY folio DESC LIMIT 1 ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if($numero == 0){
$Result = 1;	
}else{
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Result = $row['folio'] + 1;
}	
}
return $Result;
}

$IdCompra = IdCompra($con);
$NumFolio = Folio($con);

function Areas($idPedido,$area,$con){

$sql_insert = "INSERT INTO op_orden_mantenimiento_area (
id_mantenimiento,
area,
estatus
    )
    VALUES 
    (
    '".$idPedido."',
    '".$area."',
    0 
    )";

mysqli_query($con, $sql_insert);

}

function Trabajo($idPedido,$area,$con){

$sql_insert = "INSERT INTO op_orden_mantenimiento_trabajo (
id_mantenimiento,
trabajo,
estatus,
detalle

    )
    VALUES 
    (
    '".$idPedido."',
    '".$area."',
    0,
    ''         
    )";

mysqli_query($con, $sql_insert);

}

$sql = "INSERT INTO op_orden_mantenimiento (
    id, id_estacion, id_usuario, folio, codigo, no_control, tipo_mantenimiento, tipo_trabajo, marco_normativo,
    entrada_vigor, estatus_tramite, descripcion, seguimiento, trabajo_terminado, contrato_vigente, garantia_trabajo,
    obervaciones, estatus
      )
      VALUES
      (
      '".$IdCompra."',
      '".$IDEstacion."',
      '".$Session_IDUsuarioBD."',
      '".$NumFolio."',
      'M-001',
      '',
      '',
      '',
      '',
      '',
      '',
      '',
      '',
      '',
      '',
      '',
      '',
      0
      )";

      if(mysqli_query($con, $sql)){

      Areas($IdCompra,'Zona de despacho',$con);
      Areas($IdCompra,'Zona de tanques',$con);
      Areas($IdCompra,'Cuarto eléctrico',$con);
      Areas($IdCompra,'Cuarto de residuos',$con);
      Areas($IdCompra,'Bodega aceites',$con);
      Areas($IdCompra,'Baños',$con);

      Trabajo($IdCompra,'Mecánico',$con);
      Trabajo($IdCompra,'Eléctrico',$con);
      Trabajo($IdCompra,'Sistemas',$con);
      Trabajo($IdCompra,'Servicio Periódico',$con);

      echo $IdCompra;
      }else{
      echo 0;
      }


//------------------
mysqli_close($con);
//------------------