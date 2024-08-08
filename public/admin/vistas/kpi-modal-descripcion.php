<?php
require('../../../app/help.php');
$valor = $_GET['valor'];
 
if($valor == 100){
$titulo = "Corte Diario";  
$Descripcion = "<p> La calificación de la Apertura de Cortes Diarios se realiza asignando un punto (<b>1 punto</b>) cada vez que se abre un corte en una estación.</p>
<p>Este proceso implica otorgar una puntuación acumulativa, donde cada nueva apertura de corte contribuye a incrementar el puntaje total. Es importante llevar un registro preciso de cada apertura de corte efectuado en la estación, por lo que se debera de evitar la apertura constante para tener un buen historial. </p>


<h6>No. de aperturas por estación: </h6>
<p> La evaluación de las aperturas de cortes diarios se visualizara de acuerdo a los 12 meses del año (<b>Mensual</b>), y se presentará el resumen general de la evaluación obtenida durante todo el año (<b>Anual</b>).  </p>

<h5>No. de aperturas de todas las estaciones: </h5>
<p> La evaluación de las aperturas de cortes diarios se mostrará un resumen general de la evaluación obtenida a lo largo de todo el año (Anual). Esto permitirá destacar las estaciones que están llevando a cabo el proceso de manera efectiva.<br>
<br><b>Nota: Se considerará una mejor evaluación a aquellas estaciones con un menor número de aperturas.</b></p>"; 

}else if($valor == 101){
$titulo = "Facturas de Monederos";     
$Descripcion = "<p> 
La evaluación de las Facturas de Monederos se lleva a cabo según los 5 monederos base: Edenred, Efectivale, Inburgas, Ultragas y Sodexo. Cada uno de ellos tiene un valor de 3 puntos, y la puntuación total se obtiene mediante la suma, alcanzando un máximo de <b>15 puntos</b>.
<br><br> 1. Se otorgarán <b>3 puntos</b> si la factura se carga antes del día 20 o en días anteriores del mes.
<br> 2. Se otorgarán <b>2 puntos</b> si la factura se cargue entre el día 21 y el día 25 del mes.
<br> 3. Se otorgará <b>1 punto</b> si la factura se carga entre el día 26 y el día 28 del mes.
<br> 4. No se asignarán puntos si la factura se carga a partir del día 29 del mes en adelante.
</p>
<p>Este proceso implica otorgar una puntuación acumulativa, donde cada factura de monederos contribuye a incrementar el puntaje total. Es importante llevar un registro preciso de cada registro de factura de monederos efectuado en la estación, por lo que se debera de evitar el no subir la documentacion para tener un buen historial. </p>


<h6>No. de aperturas por estación: </h6>
<p> La evaluación de la factura de monederos se visualizara de acuerdo a los 12 meses del año (<b>Mensual</b>), y se presentará el resumen general de la evaluación obtenida durante todo el año (<b>Anual</b>).  </p>

<h6>No. de aperturas de todas las estaciones: </h6>
<p> La evaluación de la factura de monederos se mostrará un resumen general de la evaluación obtenida a lo largo de todo el año (Anual). Esto permitirá destacar las estaciones que están llevando a cabo el proceso de manera efectiva.<br>
<br><b>Nota: Se considerará una mejor evaluación a aquellas estaciones con un mayor número de cumplimiento (15 puntos al mes y 180 puntos de manera anual).</b></p>"; 

}

?>
 
    
<div class="modal-header">
<h5 class="modal-title">Forma de Evaluacion - <?=$titulo?></h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
 
<div class="modal-body">

<?=$Descripcion?>
 
</div>

<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-danger float-end m-2" data-bs-dismiss="modal">
<span class="btn-label2"><i class="fa fa-x"></i></span>Cerrar</button>
</div>