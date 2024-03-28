<?php
require('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];
$Year = $_GET['Year'];

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}

$sql_lista = "SELECT
op_corte_year.id AS idYear,
op_corte_year.id_estacion,
op_corte_year.year,
op_corte_mes.id AS idMes,
op_corte_mes.mes
FROM
op_corte_year
INNER JOIN op_corte_mes 
ON op_corte_year.id = op_corte_mes.id_year WHERE id_estacion = '".$idEstacion."' AND op_corte_year.year = '".$Year."' ORDER BY op_corte_mes.mes ASC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

  function IdReporte($GET_idEstacion,$GET_year,$GET_mes,$con){
   $sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '".$GET_idEstacion."' AND year = '".$GET_year."' ";
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

   function GranTotal($IdReporte,$idEstacion,$con){

    $sql_lista = "SELECT * FROM op_control_volumetrico_prefijos WHERE id_mes = '".$IdReporte."' ";
    $result_lista = mysqli_query($con, $sql_lista);
    $numero_lista = mysqli_num_rows($result_lista);

    while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
    $id = $row_lista['id'];
    $serie = $row_lista['serie'];

    if($serie != "RL" AND $serie != "S" AND $serie != "K" AND $serie != "CP"){
    $total = $row_lista['total'];    
    }else{
    $total = 0;  
    }
    $suma = $suma + $total;
    }

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

    $GTdato3 = $GTdato3 + $dato3;
    $GTdato4 = $GTdato4 + $dato4;
    $GTdato5 = $GTdato5 + $dato5;
    $GTdato6 = $GTdato6 + $dato6;
    $GTdato7 = $GTdato7 + $dato7;
    $GTdato8 = $GTdato8 + $dato8;
    $GTdato9 = $GTdato9 + $dato9;
    $GTdato10 = $GTdato10 + $dato10;
    }

    $Aceites = Aceites($IdReporte,$con);
    $ResumenAceite = $Aceites['Grantotal'];
    $GRANTOTAL = $GTdato10 + $ResumenAceite;
    $Resultado = $suma - $GRANTOTAL;
    return $Resultado;
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

function Aceites($IdReporte,$con){

    $sql_listaaceites = "SELECT * FROM op_aceites_lubricantes_reporte WHERE id_mes = '".$IdReporte."' ";
    $result_listaaceites = mysqli_query($con, $sql_listaaceites);
    while($row_listaaceites = mysqli_fetch_array($result_listaaceites, MYSQLI_ASSOC)){
    $noaceite = $row_listaaceites['id_aceite'];
    $preciou = $row_listaaceites['precio'];
    $totalaceites = totalaceites($IdReporte, $noaceite, $con);
    $Total = $preciou * $totalaceites;
    $TotAceites = $TotAceites + $totalaceites;
    $Grantotal = $Grantotal + $Total;
    } 
    $array = array('TotAceites' => $TotAceites, 'Grantotal' => $Grantotal);
    return $array;
}

?> 
<script type="text/javascript">
$(document).ready(function($){
$('[data-toggle="tooltip"]').tooltip();
});
</script>

<div class="border-0 p-3">
<div class="row">
<div class="col-10">
    <div class="row">
    <div class="col-12">
    <div class="row">
    <div class="col-12">
    <h5>Control volumétrico <?=$Year;?> <?=$estacion;?></h5>
    </div>
    </div>
    </div>
    </div>
</div>
</div>

<hr>

<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0">
<thead class="tables-bg">
 <tr>
  <th class="align-middle tableStyle font-weight-bold">AÑO</th>
  <th class="align-middle tableStyle font-weight-bold">MES</th>
  <th class="align-middle tableStyle font-weight-bold text-end">TOTAL</th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
  </tr>
</thead> 
<tbody>

<?php
if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$id = $row_lista['id']; 
$mes = $row_lista['mes'];

$IdReporte = IdReporte($idEstacion,$Year,$mes,$con);

$GranTotal = GranTotal($IdReporte,$idEstacion,$con);

echo '<tr>';
echo '<td class="align-middle"><b>'.$row_lista['year'].'</b></td>';
echo '<td class="align-middle"><b>'.nombremes($row_lista['mes']).'</b></td>';
echo '<td class="align-middle text-end"><b>'.number_format($GranTotal,2).'</b></td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="Detalle('.$idEstacion.','.$Year.','.$mes.')" data-toggle="tooltip" data-placement="top" title="Detalle"></td>';
echo '</tr>';

$num++;
}
}else{
echo "<tr><td colspan='3' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>

</div>