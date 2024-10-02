<?php
require('../../../app/help.php');
$tipo = $_GET['tipo'];


if($tipo == 1){
$titulo = "Notas de Remisión";
$Descripcion = "<p> 
La evaluación de las Notas de Remisión se lleva a cabo según las 3 notas base: QUAKER STATE, G5 y BARDAHL. Cada uno de ellos tiene un valor de <b>3 puntos</b>, y la puntuación total se obtiene mediante la suma, alcanzando un máximo de <b>9 puntos</b>.
<br><br> 1. Se otorgarán <b>3 puntos</b> si la Nota de Remisión se carga antes del día 20 o en días anteriores del mes.
<br> 2. Se otorgarán <b>2 puntos</b> si la Nota de Remisión se cargue entre el día 21 y el día 25 del mes.
<br> 3. Se otorgará <b>1 punto</b> si la Nota de Remisión se carga entre el día 26 y el día 28 del mes.
<br> 4. No se asignarán puntos si la Nota de Remisión se carga a partir del día 29 del mes en adelante.
</p> 
<p>Este proceso implica otorgar una puntuación acumulativa, donde cada Nota de Remisión contribuye a incrementar el puntaje total. Es importante llevar un registro preciso de cada registro de las Notas de Remisión efectuado en la estación, por lo que se debera de evitar el no subir la documentacion para tener un buen historial. </p>


<h6>No. de aperturas por estación: </h6>
<p> La evaluación de las Notas de Remisión se visualizara de acuerdo a los 12 meses del año (<b>Mensual</b>), y se presentará el resumen general de la evaluación obtenida durante todo el año (<b>Anual</b>).  </p>

<h6>No. de aperturas de todas las estaciones: </h6>
<p> La evaluación de la Notas de Remisión se mostrará un resumen general de la evaluación obtenida a lo largo de todo el año (Anual). Esto permitirá destacar las estaciones que están llevando a cabo el proceso de manera efectiva.<br>
<br><b>Nota: Se considerará una mejor evaluación a aquellas estaciones con un mayor número de cumplimiento (9 puntos al mes y 108 puntos de manera anual).</b></p>"; 

    
}else if($tipo == 2){
$titulo = "Facturas";
$Descripcion = "<p> 
La evaluación de las facturas se lleva a cabo según las 3 facturas base: QUAKER STATE, G5 y BARDAHL. Cada uno de ellos tiene un valor de <b>3 puntos</b>, y la puntuación total se obtiene mediante la suma, alcanzando un máximo de <b>9 puntos</b>.
<br><br> 1. Se otorgarán <b>3 puntos</b> si la factura se carga antes del día 20 o en días anteriores del mes.
<br> 2. Se otorgarán <b>2 puntos</b> si la factura se cargue entre el día 21 y el día 25 del mes.
<br> 3. Se otorgará <b>1 punto</b> si la factura se carga entre el día 26 y el día 28 del mes.
<br> 4. No se asignarán puntos si la factura se carga a partir del día 29 del mes en adelante.
</p> 
<p>Este proceso implica otorgar una puntuación acumulativa, donde cada factura contribuye a incrementar el puntaje total. Es importante llevar un registro preciso de cada registro de las facturas efectuado en la estación, por lo que se debera de evitar el no subir la documentacion para tener un buen historial. </p>


<h6>No. de aperturas por estación: </h6>
<p> La evaluación de las facturas se visualizara de acuerdo a los 12 meses del año (<b>Mensual</b>), y se presentará el resumen general de la evaluación obtenida durante todo el año (<b>Anual</b>).  </p>

<h6>No. de aperturas de todas las estaciones: </h6>
<p> La evaluación de las facturas se mostrará un resumen general de la evaluación obtenida a lo largo de todo el año (Anual). Esto permitirá destacar las estaciones que están llevando a cabo el proceso de manera efectiva.<br>
<br><b>Nota: Se considerará una mejor evaluación a aquellas estaciones con un mayor número de cumplimiento (9 puntos al mes y 108 puntos de manera anual).</b></p>"; 
    

}else if($tipo == 3){
$titulo = "Facturas Ventas Mostrador";
$Descripcion = "<p> 
La evaluación de las Facturas Venta Mostrador se lleva a cabo de acuerdo a lo siguiente:
<br><br> 1. Se otorgarán <b>3 puntos</b> si la factura se carga antes del día 2 o en días anteriores del mes.
<br> 2. Se otorgarán <b>2 puntos</b> si la factura se cargue el dia 3 del mes.
<br> 3. Se otorgará <b>1 punto</b> si la factura se carga entre el dia 4 del mes.
<br> 4. No se asignarán puntos si la factura se carga a partir del día 5 del mes en adelante.
</p> 
<p>Este proceso implica otorgar una puntuación acumulativa, donde cada factura contribuye a incrementar el puntaje total. Es importante llevar un registro preciso de cada registro de las facturas efectuado en la estación, por lo que se debera de evitar el no subir la documentacion para tener un buen historial. </p>


<h6>No. de aperturas por estación: </h6>
<p> La evaluación de las facturas se visualizara de acuerdo a los 12 meses del año (<b>Mensual</b>), y se presentará el resumen general de la evaluación obtenida durante todo el año (<b>Anual</b>).  </p>

<h6>No. de aperturas de todas las estaciones: </h6>
<p> La evaluación de las facturas se mostrará un resumen general de la evaluación obtenida a lo largo de todo el año (Anual). Esto permitirá destacar las estaciones que están llevando a cabo el proceso de manera efectiva.<br>
<br><b>Nota: Se considerará una mejor evaluación a aquellas estaciones con un mayor número de cumplimiento (3 puntos al mes y 36 puntos de manera anual).</b></p>"; 
  
    
}else if($tipo == 4){
$titulo = "Fichas de Deposito Faltante";
$Descripcion = "<p> 
La evaluación de las Ficha de Deposito Faltante se lleva a cabo de acuerdo a lo siguiente:
<br><br> 1. Se otorgarán <b>3 puntos</b> si la ficha se carga antes del día 2 o en días anteriores del mes.
<br> 2. Se otorgarán <b>2 puntos</b> si la ficha se cargue entre el día 3 y el día 10 del mes.
<br> 3. Se otorgará <b>1 punto</b> si la ficha se cargue entre el día 11 y el día 20 del mes.
<br> 4. No se asignarán puntos si la ficha se carga a partir del día 21 del mes en adelante.
</p> 
<p>Este proceso implica otorgar una puntuación acumulativa, donde cada ficha contribuye a incrementar el puntaje total. Es importante llevar un registro preciso de cada registro de las fichas efectuado en la estación, por lo que se debera de evitar el no subir la documentacion para tener un buen historial. </p>


<h6>No. de aperturas por estación: </h6>
<p> La evaluación de las ficha se visualizara de acuerdo a los 12 meses del año (<b>Mensual</b>), y se presentará el resumen general de la evaluación obtenida durante todo el año (<b>Anual</b>).  </p>

<h6>No. de aperturas de todas las estaciones: </h6>
<p> La evaluación de las ficha se mostrará un resumen general de la evaluación obtenida a lo largo de todo el año (Anual). Esto permitirá destacar las estaciones que están llevando a cabo el proceso de manera efectiva.<br>
<br><b>Nota: Se considerará una mejor evaluación a aquellas estaciones con un mayor número de cumplimiento (3 puntos al mes y 36 puntos de manera anual).</b></p>"; 
  
}
?>
 

<div class="modal-header">
<h5 class="modal-title">Forma de Evaluacion (<?=$titulo?>)</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
<?=$Descripcion?>
</div>
 
<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-danger" data-bs-dismiss="modal">
<span class="btn-label2"><i class="fa fa-xmark"></i></span>Cerrar</button>
</div>


