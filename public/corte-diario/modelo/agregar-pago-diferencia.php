<?php
require ('../../../app/help.php');

$aleatorio = uniqid();
$File = $_FILES['Documento_file']['name'];
$upload_folder = "../../../archivos/" . $aleatorio . "-" . $File;
$PDFNombre = $aleatorio . "-" . $File;

$RepAceite = $_POST['idaceite'];
$year = $_POST['year'];
$mes = $_POST['mes'];

function IdReporte($Session_IDEstacion, $GET_year, $GET_mes, $con)
{
  $sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '" . $Session_IDEstacion . "' AND year = '" . $GET_year . "' ";
  $result_year = mysqli_query($con, $sql_year);
  while ($row_year = mysqli_fetch_array($result_year, MYSQLI_ASSOC)) {
    $idyear = $row_year['id'];
  }

  $sql_mes = "SELECT id, id_year, mes FROM op_corte_mes WHERE id_year = '" . $idyear . "' AND mes = '" . $GET_mes . "' ";
  $result_mes = mysqli_query($con, $sql_mes);
  while ($row_mes = mysqli_fetch_array($result_mes, MYSQLI_ASSOC)) {
    $idmes = $row_mes['id'];
  }

  return $idmes;
}

function idAceite($idaceite, $con)
{

  $sql_reporte = "SELECT id FROM op_aceites WHERE id_aceite = '" . $idaceite . "' LIMIT 1 ";
  $result_reporte = mysqli_query($con, $sql_reporte);
  $numero_reporte = mysqli_num_rows($result_reporte);
  while ($row_mes = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)) {
    $return = $row_mes['id'];
  }
  return $return;
}

function totalaceites($IdReporte, $noaceite, $con)
{
  $cantidad = 0;
  $sql_listaaceite = "SELECT * FROM op_corte_dia WHERE id_mes = '" . $IdReporte . "' ";
  $result_listaaceite = mysqli_query($con, $sql_listaaceite);
  while ($row_listaaceite = mysqli_fetch_array($result_listaaceite, MYSQLI_ASSOC)) {
    $id = $row_listaaceite['id'];
    $sql_listatotal = "SELECT * FROM op_aceites_lubricantes WHERE idreporte_dia = '" . $id . "' AND id_aceite = '" . $noaceite . "' LIMIT 1 ";
    $result_listatotal = mysqli_query($con, $sql_listatotal);
    while ($row_listatotal = mysqli_fetch_array($result_listatotal, MYSQLI_ASSOC)) {
      $cantidad = $cantidad + $row_listatotal['cantidad'];
    }
  }
  return $cantidad;
}

function valRow($valor)
{

  if ($valor == 0) {
    $resultado = 0;
  } else {
    $resultado = number_format($valor, 2, '.', '');
  }

  return $resultado;

}

function ActualizarAlmacen($IdReporte, $idAceite, $diferencia, $con)
{
  $sql_reporte = "SELECT id, bodega FROM op_inventario_aceites WHERE id_mes = '" . $IdReporte . "' AND id_aceite = '" . $idAceite . "' ";
  $result_reporte = mysqli_query($con, $sql_reporte);
  $numero_reporte = mysqli_num_rows($result_reporte);
  while ($row_reporte = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)) {

    $bodega = $row_reporte['bodega'] + $diferencia;

    $sql = "UPDATE op_inventario_aceites SET bodega ='" . $bodega . "' WHERE id ='" . $row_reporte['id'] . "' ";

    if (mysqli_query($con, $sql)) {
    }

  }
}

$sql_reporte = "SELECT * FROM op_aceites_lubricantes_reporte WHERE id = '" . $RepAceite . "' ";
$result_reporte = mysqli_query($con, $sql_reporte);
$numero_reporte = mysqli_num_rows($result_reporte);
while ($row_reporte = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)) {
  $concepto = $row_reporte['concepto'];
  $inventario_bodega = valRow($row_reporte['inventario_bodega']);
  $inventario_exibidores = valRow($row_reporte['inventario_exibidores']);
  $bodega = valRow($row_reporte['bodega']);
  $exibidores = valRow($row_reporte['exibidores']);
  $pedido = valRow($row_reporte['pedido']);
  $noaceite = $row_reporte['id_aceite'];
  $idmes = $row_reporte['id_mes'];
  $totalaceites = totalaceites($idmes, $noaceite, $con);
  $idAceite = idAceite($noaceite, $con);
  $inventarioI = $bodega + $exibidores;
  $inventarioF = $inventarioI + $pedido - $totalaceites;
  $inventario_final = $inventario_bodega + $inventario_exibidores;
  $diferencia = $inventario_final - $inventarioF;
}

if ($mes == 12) {
  $nwyear = $year + 1;
  $nwmes = 1;
  $IdReporte = IdReporte($Session_IDEstacion, $nwyear, $nwmes, $con);
} else {
  $nwyear = $year;
  $nwmes = $mes + 1;
  $IdReporte = IdReporte($Session_IDEstacion, $nwyear, $nwmes, $con);
}


if (move_uploaded_file($_FILES['Documento_file']['tmp_name'], $upload_folder)) {

  $sql_insert = "INSERT INTO op_aceites_lubricantes_reporte_pagodiferencia (
    id_aceite,
    id_reporte,
    nomaceite,
    diferencia,
    documento,
    comentario,
    estado
    )
    VALUES 
    (
    '" . $_POST['idaceite'] . "',  
    '" . $IdReporte . "',
    '" . $noaceite . "',
    '" . abs($diferencia) . "',
    '" . $PDFNombre . "',
    '" . $_POST['Comentario'] . "',
    0
    )";
  mysqli_query($con, $sql_insert);

  ActualizarAlmacen($IdReporte, $idAceite, abs($diferencia), $con);
}



//------------------
mysqli_close($con);
//------------------
