<?php
require '../../../help.php';
$idEstacion = $_GET['idEstacion'];
$year = $_GET['year'];

$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($idEstacion);

if($idEstacion == 0){
$Estacion = '';
$consulta = '';
}else{
$Estacion = '('.$datosEstacion['localidad'].'), ';
$consulta = "AND op_solicitud_cheque.id_estacion = $idEstacion";

}


?> 

<style>
.card3 {
cursor: auto;
}


.product-info .btn {
  background-color: #215d98; /* Color de fondo */
  color: white; /* Color del texto */
  text-transform: uppercase;
  font-size: 0.875rem;
  border: none;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.product-info .btn:hover {
  background-color: #4bb7e6; /* Color de fondo al pasar el ratón */
}

</style>

<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Portal</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Reporte Anual <?=$Estacion?> <?=$year?></li>
</ol>
</div>

<div class="row">
<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
<h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Reporte Anual <?=$Estacion?> <?=$year?></h3>
</div>
<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
<button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="ModalBuscar()">
<span class="btn-label2"><i class="fa-solid fa-search"></i></i></span>Buscar
</button>
</div>
</div>
<hr>
</div>  


<div class="row ">

<!----- 1. Corte Diario ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2">    
<section class="card3 plan2 shadow-lg">
<div class="inner2">

<div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>detalle-corte-diario.png" draggable="false"/></div>

<div class="product-info">
<p class="mb-0 pb-0">Reporte Anual  <?=$year?></p>
<h2>Corte Diario</h2>
<!-- Botón de ejemplo -->
<button type="button" class="btn btn-labeled2 btn-success ms-3 mt-2 mb-1">
<span class="btn-label2"><i class="fa-regular fa-file-pdf"></i></span>Descargar PDF</button>

<button type="button" class="btn btn-labeled2 btn-success ms-3 mt-2 mb-1">
<span class="btn-label2"><i class="fa-regular fa-file-excel"></i></span>Descargar Excel</button>
<!-- O si prefieres un enlace -->
<!-- <a href="#" class="btn btn-primary mt-2">Ver Detalles</a> -->
</div>

</div>
</section>
</div>



<!----- 2. Solicitud de Cheque ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2">    
<section class="card3 plan2 shadow-lg">
<div class="inner2">
  
<div class="product-image">
<img src="<?=RUTA_IMG_ICONOS;?>detalle-cheque.png" draggable="false"/>
</div>

<div class="product-info">
<p class="mb-0 pb-0">Reporte Anual <?=$year?></p>
<h2 class="mb-3">Solicitud Cheque</h2>
<!-- Botón de ejemplo -->
<button type="button" class="btn btn-labeled2 btn-success ms-3">
<span class="btn-label2"><i class="fa-regular fa-file-pdf"></i></span>Descargar PDF</button>

<button type="button" class="btn btn-labeled2 btn-success ms-3">
<span class="btn-label2"><i class="fa-regular fa-file-excel"></i></span>Descargar Excel</button>
<!-- O si prefieres un enlace -->
<!-- <a href="#" class="btn btn-primary mt-2">Ver Detalles</a> -->
</div>

</div>
</section>
</div>



<div class="col-12 mt-4">

<?php

$num = 1;

$sql_lista = "
SELECT 
  op_solicitud_cheque.id_estacion, 
  CASE 
      WHEN op_solicitud_cheque.id_estacion = 8 THEN tb_puestos.tipo_puesto
      ELSE tb_estaciones.nombre
  END AS nombre_estacion,  
  SUM(CASE WHEN op_solicitud_cheque.id_mes = 1 THEN op_solicitud_cheque.monto ELSE 0 END) AS Ene,
  SUM(CASE WHEN op_solicitud_cheque.id_mes = 2 THEN op_solicitud_cheque.monto ELSE 0 END) AS Feb,
  SUM(CASE WHEN op_solicitud_cheque.id_mes = 3 THEN op_solicitud_cheque.monto ELSE 0 END) AS Mar,
  SUM(CASE WHEN op_solicitud_cheque.id_mes = 4 THEN op_solicitud_cheque.monto ELSE 0 END) AS Abr,
  SUM(CASE WHEN op_solicitud_cheque.id_mes = 5 THEN op_solicitud_cheque.monto ELSE 0 END) AS May,
  SUM(CASE WHEN op_solicitud_cheque.id_mes = 6 THEN op_solicitud_cheque.monto ELSE 0 END) AS Jun,
  SUM(CASE WHEN op_solicitud_cheque.id_mes = 7 THEN op_solicitud_cheque.monto ELSE 0 END) AS Jul,
  SUM(CASE WHEN op_solicitud_cheque.id_mes = 8 THEN op_solicitud_cheque.monto ELSE 0 END) AS Ago,
  SUM(CASE WHEN op_solicitud_cheque.id_mes = 9 THEN op_solicitud_cheque.monto ELSE 0 END) AS Sep,
  SUM(CASE WHEN op_solicitud_cheque.id_mes = 10 THEN op_solicitud_cheque.monto ELSE 0 END) AS Oct,
  SUM(CASE WHEN op_solicitud_cheque.id_mes = 11 THEN op_solicitud_cheque.monto ELSE 0 END) AS Nov,
  SUM(CASE WHEN op_solicitud_cheque.id_mes = 12 THEN op_solicitud_cheque.monto ELSE 0 END) AS Dic,
  SUM(op_solicitud_cheque.monto) AS TotalAnual
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
    <th>Total Anual</th>
    </tr>
    </thead>';

    echo '<tbody class="bg-white">';

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
echo '</tbody>';
echo '</table>';

echo '</div>';


?>

</div>



</div>

