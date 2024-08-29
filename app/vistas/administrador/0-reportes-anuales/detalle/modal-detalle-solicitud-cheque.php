<?php
require ('../../../../../app/help.php');
$idEstacion = $_GET['idEstacion'];
$year = $_GET['year'];

if($idEstacion == 0){
$nombreES = 'General';
$consulta = '';
    
}else{
$sql_estacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_estacion = mysqli_query($con, $sql_estacion);
$numero_estacion = mysqli_num_rows($result_estacion);
        
while($row_estacion = mysqli_fetch_array($result_estacion, MYSQLI_ASSOC)){
$nombreES = $row_estacion['localidad'];	
}
        
$consulta = "AND op_solicitud_cheque.id_estacion = $idEstacion";
}

?>

<div class="modal-header">
<h5 class="modal-title">Detalle Solicitud Cheque - <?=$nombreES?> <?=$year?></h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<?php

$num = 1;

$sql_lista = "
SELECT 
  op_solicitud_cheque.id_estacion, 
  CASE 
      WHEN op_solicitud_cheque.id_estacion = 8 THEN tb_puestos.tipo_puesto
      ELSE tb_estaciones.nombre
  END AS nombre_estacion,  
  COALESCE(SUM(CASE WHEN op_solicitud_cheque.id_mes = 1 THEN op_solicitud_cheque.monto ELSE 0 END), 0) AS Ene,
  COALESCE(SUM(CASE WHEN op_solicitud_cheque.id_mes = 2 THEN op_solicitud_cheque.monto ELSE 0 END), 0) AS Feb,
  COALESCE(SUM(CASE WHEN op_solicitud_cheque.id_mes = 3 THEN op_solicitud_cheque.monto ELSE 0 END), 0) AS Mar,
  COALESCE(SUM(CASE WHEN op_solicitud_cheque.id_mes = 4 THEN op_solicitud_cheque.monto ELSE 0 END), 0) AS Abr,
  COALESCE(SUM(CASE WHEN op_solicitud_cheque.id_mes = 5 THEN op_solicitud_cheque.monto ELSE 0 END), 0) AS May,
  COALESCE(SUM(CASE WHEN op_solicitud_cheque.id_mes = 6 THEN op_solicitud_cheque.monto ELSE 0 END), 0) AS Jun,
  COALESCE(SUM(CASE WHEN op_solicitud_cheque.id_mes = 7 THEN op_solicitud_cheque.monto ELSE 0 END), 0) AS Jul,
  COALESCE(SUM(CASE WHEN op_solicitud_cheque.id_mes = 8 THEN op_solicitud_cheque.monto ELSE 0 END), 0) AS Ago,
  COALESCE(SUM(CASE WHEN op_solicitud_cheque.id_mes = 9 THEN op_solicitud_cheque.monto ELSE 0 END), 0) AS Sep,
  COALESCE(SUM(CASE WHEN op_solicitud_cheque.id_mes = 10 THEN op_solicitud_cheque.monto ELSE 0 END), 0) AS Oct,
  COALESCE(SUM(CASE WHEN op_solicitud_cheque.id_mes = 11 THEN op_solicitud_cheque.monto ELSE 0 END), 0) AS Nov,
  COALESCE(SUM(CASE WHEN op_solicitud_cheque.id_mes = 12 THEN op_solicitud_cheque.monto ELSE 0 END), 0) AS Dic,
  COALESCE(SUM(op_solicitud_cheque.monto), 0) AS TotalAnual
FROM op_solicitud_cheque
LEFT JOIN tb_estaciones ON op_solicitud_cheque.id_estacion = tb_estaciones.id
LEFT JOIN tb_puestos ON op_solicitud_cheque.depto = tb_puestos.id AND op_solicitud_cheque.id_estacion = 8
WHERE op_solicitud_cheque.id_year = ".$year."
AND op_solicitud_cheque.status != 0 ".$consulta."
GROUP BY op_solicitud_cheque.id_estacion, nombre_estacion
ORDER BY 
  CASE 
      WHEN op_solicitud_cheque.id_estacion = 8 THEN 1 
      ELSE 0 
  END, 
  op_solicitud_cheque.id_estacion ASC";

$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

echo '<div class="table-responsive">';
echo '<table class="custom-table" width="100%">';

echo '<thead class="tables-bg">
    <tr>
    <th>No.</th>
    <th>Empresa</th>
    <th>Ene</th>
    <th>Feb</th>
    <th>Mar</th>
    <th>Abr</th>
    <th>May</th>
    <th>Jun</th>
    <th>Jul</th>
    <th>Ago</th>
    <th>Sep</th>
    <th>Oct</th>
    <th>Nov</th>
    <th>Dic</th>
    <th>Total</th>
    </tr>
    </thead>';

echo '<tbody class="bg-light">';

while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
  echo "<tr>
  <td>".$num."</td>
  <td>" . $row_lista["nombre_estacion"] . "</td>
  <td>$ " . number_format($row_lista["Ene"], 2) . "</td>
  <td>$ " . number_format($row_lista["Feb"], 2) . "</td>
  <td>$ " . number_format($row_lista["Mar"], 2) . "</td>
  <td>$ " . number_format($row_lista["Abr"], 2) . "</td>
  <td>$ " . number_format($row_lista["May"], 2) . "</td>
  <td>$ " . number_format($row_lista["Jun"], 2) . "</td>
  <td>$ " . number_format($row_lista["Jul"], 2) . "</td>
  <td>$ " . number_format($row_lista["Ago"], 2) . "</td>
  <td>$ " . number_format($row_lista["Sep"], 2) . "</td>
  <td>$ " . number_format($row_lista["Oct"], 2) . "</td>
  <td>$ " . number_format($row_lista["Nov"], 2) . "</td>
  <td>$ " . number_format($row_lista["Dic"], 2) . "</td>
  <td>$ " . number_format($row_lista["TotalAnual"], 2) . "</td>
  </tr>";

  $num++;
}

if ($numero_lista == 0) {
echo "<tr><td colspan='15' class='text-center'>No se encontro información</td></tr>";
}

echo '</tbody>';
echo '</table>';
echo '</div>';

?>

</div>


<div class="modal-footer">


</div>