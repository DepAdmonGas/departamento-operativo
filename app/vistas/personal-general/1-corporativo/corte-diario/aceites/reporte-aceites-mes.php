<?php
require '../../../../../help.php';

$GET_year = $_GET['year'];
$GET_mes = $_GET['mes'];

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

  function InventarioFin($IdReporte,$con){
  $sql_reporte = "SELECT id FROM op_aceites_lubricantes_reporte_finalizar WHERE id_mes = '".$IdReporte."' LIMIT 1 ";
   $result_reporte = mysqli_query($con, $sql_reporte);
   $numero_reporte = mysqli_num_rows($result_reporte);
 
   return $numero_reporte;
   }

   $IdReporte = IdReporte($Session_IDEstacion,$GET_year,$GET_mes,$con); 
   $InventarioFin = InventarioFin($IdReporte,$con);

   if ($InventarioFin == 1) {
    $disabled = "disabled";
    $disabledStyle = "inputD";
   }else{
    $disabled = "";
    $disabledStyle = "";
   }

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
ON op_inventario_aceites.id_aceite = op_aceites.id WHERE op_inventario_aceites.id_estacion = '".$Session_IDEstacion."' AND id_mes = '".$IdReporte."' ";
    $result_listaaceite = mysqli_query($con, $sql_listaaceite);
    while($row_listaaceite = mysqli_fetch_array($result_listaaceite, MYSQLI_ASSOC)){

    $noAceite = $row_listaaceite['id_aceite'];
    $concepto = $row_listaaceite['concepto'];
    $precio = $row_listaaceite['precio'];
    $exhibidores = $row_listaaceite['exhibidores'];
    $bodega = $row_listaaceite['bodega'];

    if($InventarioFin == 0){
    Validaaceites($IdReporte,$noAceite,$concepto,$precio,$exhibidores,$bodega,$con);
    }else{}
    }

    function Validaaceites($idReporte,$noAceite,$concepto,$precio,$exhibidores,$bodega,$con){
  
   $sql_reporte = "SELECT id_mes, concepto FROM op_aceites_lubricantes_reporte WHERE id_mes = '".$idReporte."' AND concepto = '".$concepto."' ";
   $result_reporte = mysqli_query($con, $sql_reporte);
   $numero_reporte = mysqli_num_rows($result_reporte);

    if($numero_reporte == 0){
    $sql_insert = "INSERT INTO op_aceites_lubricantes_reporte (
    id_mes,
    id_aceite,
    concepto,
    precio,
    bodega,
    exibidores,
    pedido,
    inventario_bodega,
    inventario_exibidores,
    producto_facturado,
    factura_venta_mostrador
    )
    VALUES 
    (
    '".$idReporte."',
    '".$noAceite."',
    '".$concepto."',
    '".$precio."',
    '".$bodega."',
    '".$exhibidores."',
    0,
    0,
    0,
    0,
    0
    )";
    mysqli_query($con, $sql_insert);
  }
  }

  function ultimodia($year,$mes) { 
      $month = $mes;
      $year = $year;
      $day = date("d", mktime(0,0,0, $month+1, 0, $year)); 
      return date('d', mktime(0,0,0, $month, $day, $year));
  };
 
  
  function primerdia($year,$mes) {
      $month = $mes;
      $year = $year;
      return date('d', mktime(0,0,0, $month, 1, $year));
  }

  $Pdia = primerdia($GET_year,$GET_mes);
  $Udia = ultimodia($GET_year,$GET_mes);

function cantidadaceites($IdReporte, $fecha, $noaceite, $con){

  $cantidad = 0;

      $sql_listaaceite = "SELECT * FROM op_corte_dia WHERE id_mes = '".$IdReporte."' AND fecha = '".$fecha."' LIMIT 1 ";
    $result_listaaceite = mysqli_query($con, $sql_listaaceite);
    while($row_listaaceite = mysqli_fetch_array($result_listaaceite, MYSQLI_ASSOC)){
      $id = $row_listaaceite['id'];
    }


    $sql_listatotal = "SELECT * FROM op_aceites_lubricantes WHERE idreporte_dia = '".$id."' AND id_aceite = '".$noaceite."' LIMIT 1 ";
    $result_listatotal = mysqli_query($con, $sql_listatotal);
    while($row_listatotal = mysqli_fetch_array($result_listatotal, MYSQLI_ASSOC)){
      $cantidad = $row_listatotal['cantidad'];
    }

    return $cantidad;

    }

    function totalaceites($IdReporte,$noaceite, $con){

    $sql_listaaceite = "SELECT * FROM op_corte_dia WHERE id_mes = '".$IdReporte."' ";
    $result_listaaceite = mysqli_query($con, $sql_listaaceite);
    while($row_listaaceite = mysqli_fetch_array($result_listaaceite, MYSQLI_ASSOC)){
      $id = $row_listaaceite['id'];

       $sql_listatotal = "SELECT * FROM op_aceites_lubricantes WHERE idreporte_dia = '".$id."' AND id_aceite = '".$noaceite."' LIMIT 1 ";
    $result_listatotal = mysqli_query($con, $sql_listatotal);
    while($row_listatotal = mysqli_fetch_array($result_listatotal, MYSQLI_ASSOC)){
      $cantidad = $cantidad + $row_listatotal['cantidad'];


    }

    }

    return $cantidad;

    }

    function precioaceite($IdReporte, $fecha, $noaceite, $con){

      $sql_listaaceite = "SELECT * FROM op_corte_dia WHERE id_mes = '".$IdReporte."' AND fecha = '".$fecha."' LIMIT 1 ";
    $result_listaaceite = mysqli_query($con, $sql_listaaceite);
    while($row_listaaceite = mysqli_fetch_array($result_listaaceite, MYSQLI_ASSOC)){
      $id = $row_listaaceite['id'];
    }

    $total = 0;
    $sql_listatotal = "SELECT * FROM op_aceites_lubricantes WHERE idreporte_dia = '".$id."' AND id_aceite = '".$noaceite."' LIMIT 1 ";
    $result_listatotal = mysqli_query($con, $sql_listatotal);
    while($row_listatotal = mysqli_fetch_array($result_listatotal, MYSQLI_ASSOC)){
      $cantidad = $row_listatotal['cantidad'];
      $precio = $row_listatotal['precio_unitario'];

      $total = $cantidad * $precio;

      
    }

    return $total;

    }

    function totalprecio($IdReporte, $fecha, $noaceite, $con){
      $cantidad = 0;
    $sql_listaaceite = "SELECT * FROM op_corte_dia WHERE id_mes = '".$IdReporte."' ";
    $result_listaaceite = mysqli_query($con, $sql_listaaceite);
    while($row_listaaceite = mysqli_fetch_array($result_listaaceite, MYSQLI_ASSOC)){
      $id = $row_listaaceite['id'];

       $sql_listatotal = "SELECT * FROM op_aceites_lubricantes WHERE idreporte_dia = '".$id."' AND id_aceite = '".$noaceite."' LIMIT 1 ";
    $result_listatotal = mysqli_query($con, $sql_listatotal);
    while($row_listatotal = mysqli_fetch_array($result_listatotal, MYSQLI_ASSOC)){
      $cantidad = $cantidad + $row_listatotal['cantidad'];
      $precio = $row_listatotal['precio_unitario'];

      $total = $cantidad * $precio;


    }

    }

    return $total;

    }

    function totalcantidad($IdReporte, $fecha, $noaceite, $con){
      $cantidad = 0;
      $sql_listaaceite = "SELECT * FROM op_corte_dia WHERE id_mes = '".$IdReporte."' AND fecha = '".$fecha."' ";
    $result_listaaceite = mysqli_query($con, $sql_listaaceite);
    while($row_listaaceite = mysqli_fetch_array($result_listaaceite, MYSQLI_ASSOC)){
      $id = $row_listaaceite['id'];
    


    $sql_listatotal = "SELECT * FROM op_aceites_lubricantes WHERE idreporte_dia = '".$id."' ";
    $result_listatotal = mysqli_query($con, $sql_listatotal);
    while($row_listatotal = mysqli_fetch_array($result_listatotal, MYSQLI_ASSOC)){
      $cantidad = $cantidad + $row_listatotal['cantidad'];
    }

    return $cantidad;
  }

    

    }

    function totalimporte($IdReporte, $fecha, $noaceite, $con){

      $sql_listaaceite = "SELECT * FROM op_corte_dia WHERE id_mes = '".$IdReporte."' AND fecha = '".$fecha."' ";
    $result_listaaceite = mysqli_query($con, $sql_listaaceite);
    while($row_listaaceite = mysqli_fetch_array($result_listaaceite, MYSQLI_ASSOC)){
      $id = $row_listaaceite['id'];
    


    $sql_listatotal = "SELECT * FROM op_aceites_lubricantes WHERE idreporte_dia = '".$id."' ";
    $result_listatotal = mysqli_query($con, $sql_listatotal);
    $totalimporte = 0;

    while($row_listatotal = mysqli_fetch_array($result_listatotal, MYSQLI_ASSOC)){
      $cantidad = $row_listatotal['cantidad'];
      $precio = $row_listatotal['precio_unitario'];

      $total = $cantidad * $precio;

      $totalimporte = $totalimporte + $total;

    }

      return $totalimporte;

    }


  }

PagoDiferencias($IdReporte,$con);

function PagoDiferencias($IdReporte,$con){

$sql_reporte = "SELECT * FROM op_aceites_lubricantes_reporte_pagodiferencia WHERE id_reporte = '".$IdReporte."' AND estado = 0 ";
    $result_reporte = mysqli_query($con, $sql_reporte);
    while($row_reporte = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)){
    $id = $row_reporte['id'];
    $nomaceite = $row_reporte['nomaceite'];
    $diferencia = $row_reporte['diferencia'];

ActualizarAlmacen($id,$IdReporte,$nomaceite,$diferencia,$con);

}
}

  function ActualizarAlmacen($id,$IdReporte,$idAceite,$diferencia,$con){
    $sql_reporte = "SELECT id, bodega FROM op_aceites_lubricantes_reporte WHERE id_mes = '".$IdReporte."' AND id_aceite = '".$idAceite."' ";
    $result_reporte = mysqli_query($con, $sql_reporte);
    $numero_reporte = mysqli_num_rows($result_reporte);
    while($row_reporte = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)){

        $bodega = $row_reporte['bodega'] + $diferencia;

    $sql = "UPDATE op_aceites_lubricantes_reporte SET bodega ='".$bodega."' WHERE id ='".$row_reporte['id']."' ";

        $sql1 = "UPDATE op_aceites_lubricantes_reporte_pagodiferencia SET estado = 1 WHERE id ='".$id."' ";

    if (mysqli_query($con, $sql)) {}
    if (mysqli_query($con, $sql1)) {}

    }
  }

/*
  if($GET_mes == 12){
  $GET_yearS = $GET_year + 1;
  $GET_mesS = 1;
  }else{
  $GET_yearS = $GET_year;
  $GET_mesS = $GET_mes + 1;
  }

$IdReporteSig = IdReporte($Session_IDEstacion,$GET_yearS,$GET_mesS,$con); 

  $sql = "SELECT
op_aceites.id,
op_aceites.id_aceite,
op_aceites.concepto,
op_aceites.precio,
op_inventario_aceites.id_mes,
op_inventario_aceites.exhibidores,
op_inventario_aceites.bodega
FROM op_inventario_aceites
INNER JOIN op_aceites
ON op_inventario_aceites.id_aceite = op_aceites.id WHERE op_inventario_aceites.id_estacion = '".$Session_IDEstacion."' AND op_inventario_aceites.id_mes = '".$IdReporteSig."' ";
    $result = mysqli_query($con, $sql);
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

    $noAceite = $row['id_aceite'];
    $exhibidores = $row['exhibidores'];
    $bodega = $row['bodega'];


    ValidaaceitesSig($IdReporte,$noAceite,$exhibidores,$bodega,$con);


    }

  function ValidaaceitesSig($IdReporte,$noAceite,$exhibidores,$bodega,$con){
  
    $sql_edit = "UPDATE op_aceites_lubricantes_reporte SET 
    inventario_bodega = '".$bodega."',
    inventario_exibidores = '".$exhibidores."'
    WHERE id_mes ='".$IdReporte."' AND id_aceite = '".$noAceite."' ";
    mysqli_query($con, $sql_edit);

  }

*/

?>

<div class="table-responsive">
  <table class="custom-table" style="font-size: .75em;" width="100%">
    <thead class="tables-bg">
        <tr>
            <th class="align-middle text-center">#</th>
            <th colspan="2" class="align-middle text-center">Concepto</th>
            <th class="align-middle text-center">Precio Unitario</th>
            <th class="align-middle text-center">Bodega</th>
            <th class="align-middle text-center">Exhibidores</th>
            <th class="align-middle text-center">Inventario Inicial</th>
            <th class="align-middle text-center">Compras / Pedido</th>
            <th class="align-middle text-center">Ventas del mes</th>
            <th class="align-middle text-center">Inventario Final</th>
            <th class="align-middle text-center">Inventario fisico Bodega</th>
            <th class="align-middle text-center">Inventario fisico Exhibidores</th>
            <th class="align-middle text-center">Inventario fisico Final</th>
            <th class="align-middle text-center">Diferencia</th>
            <th class="align-middle text-center">Diferencia $</th>
            <th class="align-middle text-center">Prod. Facturados</th>
            <th class="align-middle text-center">Factura venta mostrador</th>
            <th class="align-middle text-center">Fac. total</th>
            <th class="align-middle text-center">Dif. En Facturacion</th>
            <?php
            for ($Pdia = 1; $Pdia <= $Udia; $Pdia++) {
                echo "<th class='align-middle text-center'>" . $Pdia . "</th>";
            }
            ?>
            <th class="align-middle text-center ">Total</th>
            <?php
            for ($Pdia = 1; $Pdia <= $Udia; $Pdia++) {
                echo "<th class='align-middle text-center'>" . $Pdia . "</th>";
            }
            ?>
            <th class="align-middle text-center">Total</th>
        </tr>
        
    </thead>
    <tbody class="bg-white">
        <?php
        $sql_listaaceites = "SELECT * FROM op_aceites_lubricantes_reporte WHERE id_mes = '" . $IdReporte . "' AND id_aceite <> 0 ORDER BY id_aceite ASC";
        #$sql_listaaceites = "SELECT * FROM op_aceites_lubricantes_reporte WHERE id_mes = '" . $IdReporte . "' ORDER BY id_aceite ASC ";
        $result_listaaceites = mysqli_query($con, $sql_listaaceites);
        $idaceite = 0;
        $noaceite = 0;
        $totalBodegas = 0;
        $totalExibidores = 0;
        $totalInventarioI = 0;
        $totalPedido = 0;
        $totalVentasM = 0;
        $totalInventarioF = 0;
        $totalInventarioBodega = 0;
        $totalInventarioExibidores = 0;
        $totalInventarioFinal = 0;
        $totalDiferencia = 0;
        $totalDigPrecio = 0;
        $sumt = 0;
        $importeneto = 0;
        $ventas = 0;
        while ($row_listaaceites = mysqli_fetch_array($result_listaaceites, MYSQLI_ASSOC)) {

            $idaceite = $row_listaaceites['id'];
            $noaceite = $row_listaaceites['id_aceite'];
            $preciou = $row_listaaceites['precio'];
            $bodega = (int) $row_listaaceites['bodega'];
            $exibidores = (int) $row_listaaceites['exibidores'];
            $pedido = (int) $row_listaaceites['pedido'];

            $inventario_bodega = (int) $row_listaaceites['inventario_bodega'];
            $inventario_exibidores = (int) $row_listaaceites['inventario_exibidores'];

            $producto_facturado = (int) $row_listaaceites['producto_facturado'];
            $factura_venta_mostrador = (int) $row_listaaceites['factura_venta_mostrador'];

            $totalaceites = $corteDiarioGeneral->totalaceites($IdReporte, $noaceite);

            $inventarioI = $bodega + $exibidores;
            $inventarioF = $inventarioI + $pedido - $totalaceites;

            $inventario_final = $inventario_bodega + $inventario_exibidores;

            $diferencia = $inventario_final - $inventarioF;
            $difPrecio = $row_listaaceites['precio'] * $diferencia;

            $factotal = $factura_venta_mostrador + $producto_facturado;
            $diffactura = $factotal - $ventas;
            $iconDiferencia = '';

            if (is_numeric($diferencia) and ($diferencia < 0)) {

                if ($InventarioFin == 1) {
                    $ValidaPagoD = $corteDiarioGeneral->validaPagoD($idaceite);

                    if ($ValidaPagoD == 0) {
                        $iconDiferencia = '<div class="float-start"><img src="' . RUTA_IMG_ICONOS . 'merma-si.png" onclick="ModalDiferencia(' . $idaceite . ',' . $GET_year . ',' .
                            $GET_mes . ')"></div>';
                    } else {
                        $iconDiferencia = '<div class="float-start"><img src="' . RUTA_IMG_ICONOS . 'merma-no.png" onclick="ModalDetalle(' . $idaceite . ')"></div>';
                    }

                }
            }

            $totalBodegas = $totalBodegas + $bodega;
            $totalExibidores = $totalExibidores + $exibidores;
            $totalInventarioI = $totalInventarioI + $inventarioI;
            $totalPedido = $totalPedido + $pedido;
            $totalVentasM = $totalVentasM + $totalaceites;
            $totalInventarioF = $totalInventarioF + $inventarioF;
            $totalInventarioBodega = $totalInventarioBodega + $inventario_bodega;
            $totalInventarioExibidores = $totalInventarioExibidores + $inventario_exibidores;
            $totalInventarioFinal = $totalInventarioFinal + $inventario_final;
            $totalDiferencia = $totalDiferencia + $diferencia;
            $totalDigPrecio = $totalDigPrecio + $difPrecio;

            ?>

            <tr>
                <th class="align-middle p-1 text-center"><?= $idaceite;?></th>
                <td class="align-middle p-1"><b><?= $noaceite; ?></b></td>
                <td class="align-middle p-1"><b><?= $row_listaaceites['concepto']; ?></b></td>
                <td class="align-middle text-end p-1"><?= number_format($row_listaaceites['precio'], 2); ?></td>
                <td class="align-middle text-end"><?= $bodega; ?></td>

                <td class="align-middle text-end"><?= $exibidores; ?></td>

                <td id="inventarioi-<?= $idaceite; ?>" class="align-middle text-end">
                    <?= number_format($inventarioI, 2); ?></td>

                <td class="align-middle p-0 "><input id="pedido-<?= $idaceite; ?>" class="<?= $disabledStyle; ?> p-3 fw-bold" type="number"
                        name="" style="border: 0px;width: 100%;height: 100%; text-align: right;"
                        value="<?= $pedido; ?>" onkeyup="EditPedido(this,<?= $idaceite; ?>)" <?= $disabled; ?>></td>

                <td id="ventas-<?= $idaceite; ?>" class="align-middle text-end"><?= $totalaceites; ?></td>

                <td id="inventariof-<?= $idaceite; ?>" class="align-middle text-end">
                    <?= number_format($inventarioF, 2); ?></td>

                <td class="align-middle p-0"><input id="fisicoB-<?= $idaceite; ?>" class="<?= $disabledStyle; ?> p-3 fw-bold" type="number"
                        name="" style="border: 0px;width: 100%;height: 100%; text-align: right;"
                        value="<?= $inventario_bodega; ?>" onkeyup="EditFisicoBodega(this,<?= $idaceite; ?>)" <?= $disabled; ?>>
                </td>

                <td class="align-middle p-0"><input id="fisicoE-<?= $idaceite; ?>" class="<?= $disabledStyle; ?> p-3 fw-bold" type="number"
                        name="" style="border: 0px;width: 100%;height: 100%; text-align: right;"
                        value="<?= $inventario_exibidores; ?>" onkeyup="EditFisicoExhibidor(this,<?= $idaceite; ?>)"
                        <?= $disabled; ?>></td>

                <td class="align-middle text-end" id="fisicoFin-<?= $idaceite; ?>"><?= $corteDiarioGeneral->valRow($inventario_final); ?></td>

                <td id="diferencia-<?= $idaceite; ?>" class="align-middle text-end">
                    <?= number_format($diferencia, 2); ?>     <?= $iconDiferencia; ?></td>

                <td class="align-middle p-1 text-end">$ <?= number_format($difPrecio, 2); ?></td>

                <td class="align-middle p-0"><input id="facturado-<?= $idaceite; ?>" class="<?= $disabledStyle; ?> p-3 fw-bold"
                        type="number" name="" style="border: 0px;width: 100%;height: 100%; text-align: right;"
                        value="<?= $producto_facturado; ?>" onkeyup="EditFacturados(this,<?= $idaceite; ?>)" <?= $disabled; ?>>
                </td>

                <td class="align-middle p-0"><input id="mostrador-<?= $idaceite; ?>" class="<?= $disabledStyle; ?> p-3 fw-bold"
                        type="number" name="" style="border: 0px;width: 100%;height: 100%; text-align: right;"
                        value="<?= $factura_venta_mostrador; ?>" onkeyup="EditMostrador(this,<?= $idaceite; ?>)"
                        <?= $disabled; ?>></td>

                <td id="factotal-<?= $idaceite; ?>" class="align-middle text-end"><?= number_format($factotal, 2); ?>
                </td>

                <td id="diffactura-<?= $idaceite; ?>" class="align-middle text-end">
                    <?= number_format($diffactura, 2); ?></td>

                    <?php

for ($Pdia = 1; $Pdia <= $Udia; $Pdia++) {
  
  $fecha = $GET_year."-".$GET_mes."-".$Pdia;
  $cantidad = cantidadaceites($IdReporte, $fecha, $noaceite, $con);

  echo "<td class='align-middle text-center'>".$cantidad."</td>";

}


$sumt = $sumt + $totalaceites;
?>
<td class="align-middle text-center bg-light fw-bold"><?=$totalaceites;?></td>
<?php
$TotalSumaAceites = 0;
for ($Pdia = 1; $Pdia <= $Udia; $Pdia++) {

  $fechap = $GET_year."-".$GET_mes."-".$Pdia;
  $precioaceite = precioaceite($IdReporte, $fechap, $noaceite, $con);
  $TotalSumaAceites = $TotalSumaAceites + $precioaceite;
  echo "<td class='align-middle text-center'>".number_format($precioaceite,2)."</td>";
}
$totalprecio = totalprecio($IdReporte, $fecha, $noaceite, $con);
$importeneto = $importeneto + $totalprecio;
?>
<td class="align-middle text-center bg-light"><?=number_format($TotalSumaAceites,2);?></td>
</tr>

<?php
}    
?>

        <tr class="fw-bold">

            <th class="text-end bg-light" colspan="4">TOTAL</th>
            <td class="align-middle text-end bg-light"><?= number_format($totalBodegas, 2); ?></td>
            <td class="align-middle text-end bg-light"><?= number_format($totalExibidores, 2); ?></td>
            <td class="align-middle text-end bg-light"><?= number_format($totalInventarioI, 2); ?></td>
            <td class="align-middle text-end bg-light"><?= number_format($totalPedido, 2); ?></td>
            <td class="align-middle text-end bg-light"><?= number_format($totalVentasM, 2); ?></td>
            <td class="align-middle text-end bg-light"><?= number_format($totalInventarioF, 2); ?></td>
            <td class="align-middle text-end bg-light"><?= number_format($totalInventarioBodega, 2); ?></td>
            <td class="align-middle text-end bg-light"><?= number_format($totalInventarioExibidores, 2); ?></td>
            <td class="align-middle text-end bg-light"><?= number_format($totalInventarioFinal, 2); ?></td>
            <td class="align-middle text-end bg-light"><?= number_format($totalDiferencia, 2); ?></td>
            <td class="align-middle text-end bg-light">$<?= number_format($totalDigPrecio, 2); ?></td>
            <td class="align-middle text-end bg-light"></td>
            <td class="align-middle text-end bg-light"></td>
            <td class="align-middle text-end bg-light"></td>
            <td class="align-middle text-end bg-light"></td>
<?php
    for ($Pdia = 1; $Pdia <= $Udia; $Pdia++) {

      $fecha = $GET_year."-".$GET_mes."-".$Pdia;
      $totalcantidad = totalcantidad($IdReporte, $fecha, $noaceite, $con);

      echo "<td class='align-middle text-center'>".$totalcantidad."</td>";
    }
    ?>
    <td class="align-middle text-center bg-light"><?php echo $sumt; ?></td>
    <?php
    for ($Pdia = 1; $Pdia <= $Udia; $Pdia++) {

      $fecha = $GET_year."-".$GET_mes."-".$Pdia;
      $totalimporte = totalimporte($IdReporte, $fecha, $noaceite, $con);

      echo "<td class='align-middle text-center'>".number_format($totalimporte,2)."</td>";
    }
    ?>
            <td class="align-middle text-center bg-light"><?= number_format($importeneto, 2); ?></td>
        </tr>
    </tbody>
</table>
</div>   