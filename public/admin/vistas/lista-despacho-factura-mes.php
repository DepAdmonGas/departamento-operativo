<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$Year = $_GET['Year'];
$Mes = $_GET['Mes'];

$sql_estaciones = "SELECT nombre, producto_uno, producto_dos, producto_tres FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_estaciones = mysqli_query($con, $sql_estaciones);
$numero_estaciones = mysqli_num_rows($result_estaciones);
while($row_estaciones = mysqli_fetch_array($result_estaciones, MYSQLI_ASSOC)){
$estacion = $row_estaciones['nombre'];
$ProductoUno  = $row_estaciones['producto_uno'];
$ProductoDos  = $row_estaciones['producto_dos'];
$ProductoTres = $row_estaciones['producto_tres'];
}

function TotalVentas($idDias,$Producto,$con){

$sql = "SELECT * FROM op_ventas_dia WHERE idreporte_dia = '".$idDias."' AND producto = '".$Producto."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$litros = $row['litros'];
$preciolitro = $row['precio_litro'];
$LitrosPrecio = $litros * $preciolitro;

$TotalLitros = $TotalLitros + $litros;
$TotalPrecio = $TotalPrecio + $LitrosPrecio;
}

$array = array(
	'TotalLitros' => $TotalLitros,
	'TotalPrecio' => $TotalPrecio
);

return $array;
}
 
function TotalAtio($idDias,$con){
 $sql = "SELECT * FROM op_despacho_factura WHERE id_dia = '".$idDias."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
  
$LProductouno = $row['litros_producto_uno'];
$LProductodos = $row['litros_producto_dos'];
$LProductotres = $row['litros_producto_tres'];
$PProducto_uno = $row['pesos_producto_uno'];
$PProducto_dos = $row['pesos_producto_dos'];
$PProducto_tres = $row['pesos_producto_tres'];

}

$array = array(
  'LProductouno' => $LProductouno,
  'LProductodos' => $LProductodos,
  'LProductotres' => $LProductotres,
  'PProductouno' => $PProducto_uno,
  'PProductodos' => $PProducto_dos,
  'PProductotres' => $PProducto_tres
);

return $array; 
}

function ValidaDia($idDias,$con){
$sql = "SELECT * FROM op_despacho_factura WHERE id_dia = '".$idDias."' LIMIT 1 ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);  
if($numero == 0){

$sql_insert = "INSERT INTO op_despacho_factura (
    id_dia,
    litros_producto_uno,
    litros_producto_dos,
    litros_producto_tres,
    pesos_producto_uno,
    pesos_producto_dos,
    pesos_producto_tres
    )
    VALUES 
    (
    '".$idDias."',
    0,
    0,
    0,
    0,
    0,
    0
    )";

if(mysqli_query($con, $sql_insert)){

}else{

}

}
}

function es_negativo($num){
if(is_numeric($num) and $num<0) {
$result = "text-danger";
}else{
$result = "text-black";
}
return $result;
}

?>


<div class="border-0 p-3">

<div ><h5><?=$estacion;?></h5></div>
<hr>

<div class="table-responsive">
<table class="table table-sm table-bordered" style="font-size: .8em">
<thead>
<tr>
<th rowspan="2" class="text-center align-middle"></th>
<th rowspan="2" class="text-center align-middle">Fecha</th>
<th class="text-white text-center align-middle" style="background: #74bc1f">Litros</th>
<th class="text-white text-center align-middle" style="background: #74bc1f">Pesos</th>
<th class="text-white text-center align-middle" style="background: #e01883">Litros</th>
<th class="text-white text-center align-middle" style="background: #e01883">Pesos</th>
<th class="text-white text-center align-middle" style="background: #5c108c">Litros</th>
<th class="text-white text-center align-middle" style="background: #5c108c">Pesos</th>
<th colspan="2"></th>
</tr>
<tr>
<th class="text-white text-center" style="background: #74bc1f">G SUPER</th>
<th class="text-white text-end text-center" style="background: #74bc1f">G SUPER</th>
<th class="text-white text-center" style="background: #e01883">G PREMIUM</th>
<th class="text-white text-end text-center" style="background: #e01883">G PREMIUM</th>
<th class="text-white text-center" style="background: #5c108c">G DIESEL</th>
<th class="text-white text-end text-center" style="background: #5c108c">G DIESEL</th>
<th class="bg-light">TOTAL</th>
<th class="bg-light text-end">TOTAL</th>
</tr>
</thead>
<tbody>
<?php
$sql_listadia = "
SELECT 
op_corte_year.id_estacion,
op_corte_year.year,
op_corte_mes.mes,
op_corte_dia.id AS idDia,
op_corte_dia.fecha
FROM op_corte_year
INNER JOIN op_corte_mes ON op_corte_year.id = op_corte_mes.id_year
INNER JOIN op_corte_dia ON op_corte_mes.id = op_corte_dia.id_mes 
WHERE op_corte_year.id_estacion = '".$idEstacion."' AND 
op_corte_year.year = '".$Year."' AND 
op_corte_mes.mes = '".$Mes."'";
$result_listadia = mysqli_query($con, $sql_listadia);
$numero_listadia = mysqli_num_rows($result_listadia);

while($row_listadia = mysqli_fetch_array($result_listadia, MYSQLI_ASSOC)){
$idDias = $row_listadia['idDia'];
$fecha = $row_listadia['fecha']; 

ValidaDia($idDias,$con);

$Producto1 = TotalVentas($idDias,$ProductoUno,$con);
$Producto2 = TotalVentas($idDias,$ProductoDos,$con);
$Producto3 = TotalVentas($idDias,$ProductoTres,$con);

$TotalLitros = $Producto1['TotalLitros'] + $Producto2['TotalLitros'] + $Producto3['TotalLitros'];
$TotalPrecio = $Producto1['TotalPrecio'] + $Producto2['TotalPrecio'] + $Producto3['TotalPrecio'];

$TotalAtio = TotalAtio($idDias,$con);

$TotalALP = $TotalAtio['LProductouno'] + $TotalAtio['LProductodos'] + $TotalAtio['LProductotres'];
$TotalAPP = $TotalAtio['PProductouno'] + $TotalAtio['PProductodos'] + $TotalAtio['PProductotres'];

$DiLPoUno = $Producto1['TotalLitros'] - $TotalAtio['LProductouno'];
$DiLPoDos = $Producto2['TotalLitros'] - $TotalAtio['LProductodos'];
$DiLPoTres = $Producto3['TotalLitros'] - $TotalAtio['LProductotres'];
$DiToLitros = $TotalLitros - $TotalALP;


$DiPPoUno = $Producto1['TotalPrecio'] - $TotalAtio['PProductouno'];
$DiPPoDos = $Producto2['TotalPrecio'] - $TotalAtio['PProductodos'];
$DiPPoTres = $Producto3['TotalPrecio'] - $TotalAtio['PProductotres'];
$DiToPesos = $TotalPrecio - $TotalAPP;

echo '<tr>
<td class="bg-primary font-weight-bold text-white">VENTAS</td>
<td class="align-middle" rowspan="3" class="text-center align-middle"><b>'.FormatoFecha($fecha).'</b></td>
<td>'.number_format($Producto1['TotalLitros'],2).'</td>
<td class="text-end">$'.number_format($Producto1['TotalPrecio'],2).'</td>
<td>'.number_format($Producto2['TotalLitros'],2).'</td>
<td class="text-end">$'.number_format($Producto2['TotalPrecio'],2).'</td>
<td>'.number_format($Producto3['TotalLitros'],2).'</td>
<td class="text-end">$'.number_format($Producto3['TotalPrecio'],2).'</td>
<td class="bg-light">'.number_format($TotalLitros,2).'</td>
<td class="bg-light text-end">$'.number_format($TotalPrecio,2).'</td>
</tr>
<tr>
<td class="bg-info font-weight-bold text-white">DESPACHO</td>
<td>'.number_format($TotalAtio['LProductouno'],2).'</td>
<td class="text-end">$'.number_format($TotalAtio['PProductouno'],2).'</td>
<td>'.number_format($TotalAtio['LProductodos'],2).'</td>
<td class="text-end">$'.number_format($TotalAtio['PProductodos'],2).'</td>
<td>'.number_format($TotalAtio['LProductotres'],2).'</td>
<td class="text-end">$'.number_format($TotalAtio['PProductotres'],2).'</td>
<td class="bg-light">'.number_format($TotalALP,2).'</td>
<td class="bg-light text-end">$'.number_format($TotalAPP,2).'</td>

</tr>
<tr>
<td class="bg-light font-weight-bold">DIFERENCIA</td>
<td class="font-weight-bold '.es_negativo($DiLPoUno).'">'.number_format($DiLPoUno,2).'</td>
<td class="font-weight-bold '.es_negativo($DiPPoUno).' text-end">$'.number_format($DiPPoUno,2).'</td>
<td class="font-weight-bold '.es_negativo($DiLPoDos).'">'.number_format($DiLPoDos,2).'</td>
<td class="font-weight-bold '.es_negativo($DiPPoDos).' text-end">$'.number_format($DiPPoDos,2).'</td>
<td class="font-weight-bold '.es_negativo($DiLPoTres).'">'.number_format($DiLPoTres,2).'</td>
<td class="font-weight-bold '.es_negativo($DiPPoTres).' text-end">$'.number_format($DiPPoTres,2).'</td>
<td class="font-weight-bold '.es_negativo($DiToLitros).'">'.number_format($DiToLitros,2).'</td>
<td class="font-weight-bold '.es_negativo($DiToPesos).' text-end">$'.number_format($DiToPesos,2).'</td>
</tr>
<tr><td colspan="10"></td></tr>';


$GTProducto1 = $GTProducto1 + $Producto1['TotalLitros'];
$GTProducto2 = $GTProducto2 + $Producto2['TotalLitros'];
$GTProducto3 = $GTProducto3 + $Producto3['TotalLitros'];
$GTotalLitros = $GTotalLitros + $TotalLitros;

$GTPProducto1 = $GTPProducto1 + $Producto1['TotalPrecio'];
$GTPProducto2 = $GTPProducto2 + $Producto2['TotalPrecio'];
$GTPProducto3 = $GTPProducto3 + $Producto3['TotalPrecio'];
$GTotalPrecio = $GTotalPrecio + $TotalPrecio;

$GTLProductouno = $GTLProductouno + $TotalAtio['LProductouno'];
$GTLProductodos = $GTLProductodos + $TotalAtio['LProductodos'];
$GTLProductotres = $GTLProductotres + $TotalAtio['LProductotres'];
$GTotalALP = $GTotalALP + $TotalALP;
$GTPProductouno = $GTPProductouno + $TotalAtio['PProductouno'];
$GTPProductodos = $GTPProductodos + $TotalAtio['PProductodos'];
$GTPProductotres = $GTPProductotres + $TotalAtio['PProductotres'];
$GTotalAPP = $GTotalAPP + $TotalAPP;

$GTDiLPoUno = $GTDiLPoUno + $DiLPoUno;
$GTDiLPoDos = $GTDiLPoDos + $DiLPoDos;
$GTDiLPoTres = $GTDiLPoTres + $DiLPoTres;
$GTDiToLitros = $GTDiToLitros + $DiToLitros;
$GTDiPPoUno = $GTDiPPoUno + $DiPPoUno;
$GTDiPPoDos = $GTDiPPoDos + $DiPPoDos;
$GTDiPPoTres = $GTDiPPoTres + $DiPPoTres;
$GTDiToPesos = $GTDiToPesos + $DiToPesos;

}

?>
<tr>
<td class="bg-primary font-weight-bold text-white">VENTAS</td>
<td class="align-middle" rowspan="3" class="text-center align-middle"><b>TOTAL</b></td>
<td><?=number_format($GTProducto1,2);?></td>
<td class="text-end">$<?=number_format($GTPProducto1,2);?></td>
<td><?=number_format($GTProducto2,2);?></td>
<td class="text-end">$<?=number_format($GTPProducto2,2);?></td>
<td><?=number_format($GTProducto3,2);?></td>
<td class="text-end">$<?=number_format($GTPProducto3,2);?></td>
<td class="bg-light"><?=number_format($GTotalLitros,2);?></td>
<td class="bg-light text-end">$<?=number_format($GTotalPrecio,2);?></td>
</tr>
<tr>
<td class="bg-info font-weight-bold text-white">DESPACHO</td>
<td><?=number_format($GTLProductouno,2);?></td>
<td class="text-end">$<?=number_format($GTPProductouno,2);?></td>
<td><?=number_format($GTLProductodos,2);?></td>
<td class="text-end">$<?=number_format($GTPProductodos,2);?></td>
<td><?=number_format($GTLProductotres,2);?></td>
<td class="text-end">$<?=number_format($GTPProductotres,2);?></td>
<td class="bg-light"><?=number_format($GTotalALP,2);?></td>
<td class="bg-light text-end">$<?=number_format($GTotalAPP,2);?></td>

</tr>
<tr>
<td class="bg-light font-weight-bold">DIFERENCIA</td>
<td class="font-weight-bold <?=es_negativo($GTDiLPoUno);?>"><?=number_format($GTDiLPoUno,2);?></td>
<td class="font-weight-bold <?=es_negativo($GTDiPPoUno);?> text-end">$<?=number_format($GTDiPPoUno,2);?></td>
<td class="font-weight-bold <?=es_negativo($GTDiLPoDos);?>"><?=number_format($GTDiLPoDos,2);?></td>
<td class="font-weight-bold <?=es_negativo($GTDiPPoDos);?> text-end">$<?=number_format($GTDiPPoDos,2);?></td>
<td class="font-weight-bold <?=es_negativo($GTDiLPoTres);?>"><?=number_format($GTDiLPoTres,2);?></td>
<td class="font-weight-bold <?=es_negativo($GTDiPPoTres);?> text-end">$<?=number_format($GTDiPPoTres,2);?></td>
<td class="font-weight-bold <?=es_negativo($GTDiToLitros);?>"><?=number_format($GTDiToLitros,2);?></td>
<td class="font-weight-bold <?=es_negativo($GTDiToPesos);?> text-end">$<?=number_format($GTDiToPesos,2);?></td>

</tr>

</tbody>
</table>


</div>
</div>


       