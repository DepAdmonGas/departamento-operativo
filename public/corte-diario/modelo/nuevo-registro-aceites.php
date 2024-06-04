<?php
require('../../../app/help.php');

$idReporte = $_POST['idReporte'];
$GET_year = $_POST['year'];
$GET_mes = $_POST['mes'];

function IdReporte($Session_IDEstacion,$GET_year,$GET_mes,$con){
   $sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '".$Session_IDEstacion."' AND year = '".$GET_year."' ";
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

$IdMes = IdReporte($Session_IDEstacion,$GET_year,$GET_mes,$con);

$sql_listaaceite = "SELECT
op_aceites.id,
op_aceites.id_aceite,
op_aceites.concepto,
op_aceites.precio,
op_inventario_aceites.id_mes,
op_inventario_aceites.exhibidores,
op_inventario_aceites.bodega
FROM op_inventario_aceites
INNER JOIN op_aceites
ON op_inventario_aceites.id_aceite = op_aceites.id WHERE op_inventario_aceites.id_estacion = '".$Session_IDEstacion."' AND id_mes = '".$IdMes."' ";
    $result_listaaceite = mysqli_query($con, $sql_listaaceite);
    while($row_listaaceite = mysqli_fetch_array($result_listaaceite, MYSQLI_ASSOC)){

    $noAceite = $row_listaaceite['id_aceite'];
    $concepto = $row_listaaceite['concepto'];
    $precio = $row_listaaceite['precio'];

    Validaaceites($idReporte,$noAceite,$concepto,$precio,$con);  
    }

function Validaaceites($idReporte,$noAceite,$concepto,$precio,$con){
  
   $sql_reporte = "SELECT idreporte_dia, concepto FROM op_aceites_lubricantes WHERE idreporte_dia = '".$idReporte."' AND concepto = '".$concepto."' ";
   $result_reporte = mysqli_query($con, $sql_reporte);
   $numero_reporte = mysqli_num_rows($result_reporte);

    if($numero_reporte == 0){
    $sql_insert = "INSERT INTO op_aceites_lubricantes (
    idreporte_dia,
    id_aceite,
    concepto,
    cantidad,
    precio_unitario
    )
    VALUES 
    (
    '".$idReporte."',
    '".$noAceite."',
    '".$concepto."',
    0,
    '".$precio."'
    )";
    mysqli_query($con, $sql_insert);
  }
  }


//------------------
mysqli_close($con);
//------------------