<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$GET_year = $_GET['year'];
$GET_mes = $_GET['mes'];

if($_GET['depu'] == 0){
$depu = $session_idpuesto;
}else{
$depu = $_GET['depu'];
}
 
if($idEstacion == 8){
$sql_puesto = "SELECT tipo_puesto FROM tb_puestos WHERE id = '".$depu."' ";
$result_puesto = mysqli_query($con, $sql_puesto);
while($row_puesto = mysqli_fetch_array($result_puesto, MYSQLI_ASSOC)){
$estacion = $row_puesto['tipo_puesto'];
} 
  
$busqueda = 'depto = '.$depu;
}else{
$sql_listaestacion = "SELECT razonsocial FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['razonsocial'];
} 
$busqueda = 'id_estacion = '.$idEstacion; 
}   
  
$sql_lista = "SELECT * FROM op_solicitud_cheque WHERE id_year = '".$GET_year."' AND id_mes = '".$GET_mes."' AND $busqueda ORDER BY fecha DESC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);


function ToComentarios($IdReporte,$con){

$sql_lista = "SELECT id FROM op_solicitud_cheque_comentario WHERE id_solicitud = '".$IdReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);

}

function Pago($id,$con){
$sql_lista = "SELECT id FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$id."' AND nombre = 'PAGO' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);  
}

function FirmaSolicitud($idReporte, $con){
$sql_firma = "SELECT * FROM op_solicitud_cheque_firma WHERE id_solicitud = '".$idReporte."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);

return $numero_firma; 
}



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
 

$IdReporte = IdReporte($idEstacion,$GET_year,$GET_mes,$con);

function statusDocs($idReporte,$detalle,$con){
$sql_detalleDoc = "SELECT detalle FROM op_factura_telcel WHERE id_mes = '".$idReporte."' AND detalle = '".$detalle."' ";
$result_detalleDoc = mysqli_query($con, $sql_detalleDoc);
return $numero_detalleDoc = mysqli_num_rows($result_detalleDoc);

}
 
$statusFactura = statusDocs($IdReporte,'Factura',$con);
$statusPago = statusDocs($IdReporte,'Pago',$con);
 

if($statusFactura > 0){
if($statusPago > 0){
$alertIcon = 'telefono-verde.png';
$alertBg = 'bg-success';
$alertText = "Pagado"; 

}else{
$alertIcon = 'telefono-amarillo.png';
$alertBg = 'bg-warning';
$alertText = "Factura disponible"; 
}

}else{
$alertIcon = 'telefono-red.png';
$alertBg = 'bg-danger';
$alertText = "Sin factura"; 
}

 
?>  
 
<script type="text/javascript">
$(document).ready(function($){
$('[data-toggle="tooltip"]').tooltip();
});
</script>

 
<div class="border-0 p-3">

<div class="row">


<div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 ">
<h4><?=$estacion;?></h4>
</div>


<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 ">

<img class="float-end ms-2 pointer" onclick="Mas(<?=$idEstacion;?>,<?=$depu;?>,<?=$GET_year;?>,<?=$GET_mes;?>)" src="<?=RUTA_IMG_ICONOS;?>agregar.png">
<img class="float-end ms-2 pointer" width="24px" onclick="Telcel(<?=$idEstacion;?>,<?=$GET_year;?>,<?=$GET_mes;?>)" src="<?=RUTA_IMG_ICONOS;?><?=$alertIcon?>">

<?php if($idEstacion == 6 || $idEstacion == 7){ ?>
<img class="float-end ms-2 pointer" width="24px" onclick="FacTelcel(<?=$idEstacion;?>,<?=$depu;?>,<?=$GET_year;?>,<?=$GET_mes;?>)" src="<?=RUTA_IMG_ICONOS;?>factura-tb.png">
<?php } ?>

<span class="badge float-end mt-1 <?=$alertBg?>"><?=$alertText?></span>


</div>

</div>   

  <hr>


<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">

<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle tableStyle font-weight-bold">#</th>
    <?php
  if($estacion == "Gestoria"){
  echo '<th class="text-center align-middle tableStyle font-weight-bold">Razón Social</th>';
  }
  ?>
  <th class="text-center align-middle tableStyle font-weight-bold">Fecha</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Beneficiario</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Monto</th>
  <th class="text-center align-middle tableStyle font-weight-bold">No. Factura</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Concepto</th> 
  <?php
  if($estacion != "Gestoria"){
  echo '<th class="text-center align-middle tableStyle font-weight-bold">Telefono</th>';
  }
  ?> 
  
  <th class="text-center align-middle tableStyle font-weight-bold">Metodo de pago</th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>archivo-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pago-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-firmar-w.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-comentario-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
  </tr>
</thead> 
<tbody>
<?php
if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

$pago = Pago($id,$con);
$Firmas = FirmaSolicitud($id,$con);

if($Firmas == 1){
$Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" onclick="Firmar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$id.')" data-toggle="tooltip" data-placement="top" title="Firmar solicitud">';
}else if($Firmas == 2){
$Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar-vb.png" onclick="Firmar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$id.')" data-toggle="tooltip" data-placement="top" title="Firmar solicitud">';
}else if($Firmas == 3 || $row_lista['status'] == 2){
$Firmar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar-ao.png" data-toggle="tooltip" data-placement="top" title="Firmar solicitud">';
}

if($row_lista['status'] == 0){
$trColor = "table-warning";
$PDF = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Descargar PDF">';
$Pago = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pago-tb.png" data-toggle="tooltip" data-placement="top" title="Agregar pago">';
$Editar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="Editar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$id.')" data-toggle="tooltip" data-placement="top" title="Editar">';
/*$Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" onclick="Firmar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$id.')" data-toggle="tooltip" data-placement="top" title="Firmar solicitud">';*/
$Eliminar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')" data-toggle="tooltip" data-placement="top" title="Eliminar">';
}else if($row_lista['status'] == 1){
$trColor = "table-warning";
$PDF = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Descargar PDF">';
$Pago = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pago-tb.png" data-toggle="tooltip" data-placement="top" title="Agregar pago">';
$Editar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png" data-toggle="tooltip" data-placement="top" title="Editar">';
/*$Firmar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" onclick="Firmar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$id.')" data-toggle="tooltip" data-placement="top" title="Firmar solicitud">';*/
$Eliminar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Eliminar">';


}else if($row_lista['status'] == 2){

if($pago > 0){
$trColor = "table-success";
}else{
$trColor = "";
}


$PDF = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" onclick="DescargarPDF('.$id.')" data-toggle="tooltip" data-placement="top" title="Descargar PDF">';
$Pago = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pago-tb.png" onclick="Pago('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')" data-toggle="tooltip" data-placement="top" title="Agregar pago">';
$Editar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png" data-toggle="tooltip" data-placement="top" title="Editar">';
/*$Firmar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" data-toggle="tooltip" data-placement="top" title="Firmar solicitud">';*/
$Eliminar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Eliminar">';

}else if($row_lista['status'] == 3){
$trColor = "table-info";
$PDF = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Descargar PDF">';
$Pago = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pago-tb.png" data-toggle="tooltip" data-placement="top" title="Agregar pago">';
$Editar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="Editar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$id.')" data-toggle="tooltip" data-placement="top" title="Editar">';
/*$Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" onclick="Firmar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$id.')" data-toggle="tooltip" data-placement="top" title="Firmar solicitud">';*/
$Eliminar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')" data-toggle="tooltip" data-placement="top" title="Eliminar">';
}

  $ToComentarios = ToComentarios($id,$con);

  if($ToComentarios > 0){
    $Nuevo = '<div class="float-end" style="margin-bottom: -5px"><span class="badge bg-danger text-white rounded-circle"><small>'.$ToComentarios.'</small></span></div>';
  }else{
   $Nuevo = ''; 
  }
 
 
  if($depu == 5){
    
    if($session_nompuesto == "Comercializadora"){

    if($row_lista['razonsocial'] == "ADMINISTRADORA DE GASOLINERAS ESMEGAS S.A. DE C.V." OR
    $row_lista['razonsocial'] == "ADMINISTRADORA DE GASOLINERAS XOCHIMILCO S.A. DE C.V." OR
    $row_lista['razonsocial'] == "PROMOTORA DEPORTIVA EL MIRADOR, S.A. DE C.V." OR
    $row_lista['razonsocial'] == "GASOLINERAS CON HISTORIA, S.A. DE C.V."){

echo '<tr class="'.$trColor.'">';
echo '<td class="align-middle text-center">'.$num.'</td>';
if($estacion == "Gestoria"){
echo '<td class="align-middle text-center">'.$row_lista['razonsocial'].'</td>'; 
}
echo '<td class="align-middle text-center"><b>'.FormatoFecha($row_lista['fecha']).' '.date("H:i:s",$row_lista['fecha']).'</b></td>';

echo '<td class="align-middle text-center">'.$row_lista['beneficiario'].'</td>';
echo '<td class="align-middle text-center">$ '.number_format($row_lista['monto'],2).'</td>';
echo '<td class="align-middle text-center">'.$row_lista['no_factura'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['concepto'].'</td>';

if($estacion != "Gestoria"){
echo '<td class="align-middle text-center">'.$row_lista['telefono'].'</td>';
}
echo '<td class="align-middle text-center">'.$row_lista['metodo_pago'].'</td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="ModalDetalle('.$id.')" data-toggle="tooltip" data-placement="top" title="Detalle"></td>';
echo '<td class="align-middle text-center">'.$PDF.'</td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'archivo-tb.png" onclick="ModalArchivos('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')" data-toggle="tooltip" data-placement="top" title="Archivos"></td>';
echo '<td class="align-middle text-center">'.$Pago.'</td>';
echo '<td class="align-middle text-center">'.$Editar.'</td>';
echo '<td class="align-middle text-center">'.$Firmar.'</td>';
echo '<td class="align-middle text-center">'.$Nuevo.'<img width="20" class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" onclick="ModalComentario('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';
echo '<td class="align-middle text-center">'.$Eliminar.'</td>';
echo '</tr>';

$TotalMonto = $TotalMonto + $row_lista['monto'];

   }

    }else if($session_nompuesto == "Recursos humanos"){

    if($row_lista['razonsocial'] == "ADMINISTRADORA DE GASOLINERAS INTERLOMAS" OR
    $row_lista['razonsocial'] == "ADMINISTRADORA DE GASOLINERAS S.A. DE C.V." OR
    $row_lista['razonsocial'] == "ADMINISTRADORA DE GASOLINERAS SAN AGUSTÍN S.A. DE C.V." OR
    $row_lista['razonsocial'] == "GASOLINERA VALLE DE GUADALUPE S.A. DE C.V." OR
    $row_lista['razonsocial'] == "GASOMIRA S.A. DE C.V." OR
    $row_lista['razonsocial'] == "INMOBILIARIA PALO SOLO S.A. DE C.V." OR
    $row_lista['razonsocial'] == "INMOBILIARIA VALLE DE HUIXQUILUCAN, S.A. DE C.V." OR
    $row_lista['razonsocial'] == "ADMINISTRADORA DE GASOLINERIAS BOSQUE REAL S.A. DE C.V." OR
    $row_lista['razonsocial'] == "BIENES RAÍCES SALTE, S.A. DE C.V." OR
    $row_lista['razonsocial'] == "ARRENDATARIA DE COPOPRIEDADES LEO, S.A. DE C.V." OR
    $row_lista['razonsocial'] == "OPERACIÓN SERVICIO Y MANTENIMIENTO DE PERSONAL S.A. DE C.V." OR
    $row_lista['razonsocial'] == "INMOBILIARIA TOMASIN, S.A. DE C.V." OR
    $row_lista['razonsocial'] == "FIDEICOMISO DE ADMINISTRACIÓN No. 2176/2016" OR
    $row_lista['razonsocial'] == "BANCA MIFEL, S.A., FIDEICOMISO 2176/2016"
   ){
      
echo '<tr class="'.$trColor.'">';
echo '<td class="align-middle text-center">'.$num.'</td>';
if($estacion == "Gestoria"){
echo '<td class="align-middle text-center">'.$row_lista['razonsocial'].'</td>'; 
}
echo '<td class="align-middle text-center"><b>'.FormatoFecha($row_lista['fecha']).' '.date("H:i:s",$row_lista['fecha']).'</b></td>';
echo '<td class="align-middle text-center">'.$row_lista['beneficiario'].'</td>';
echo '<td class="align-middle text-center">$ '.number_format($row_lista['monto'],2).'</td>';
echo '<td class="align-middle text-center">'.$row_lista['no_factura'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['concepto'].'</td>';

if($estacion != "Gestoria"){
echo '<td class="align-middle text-center">'.$row_lista['telefono'].'</td>';
}
echo '<td class="align-middle text-center">'.$row_lista['metodo_pago'].'</td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="ModalDetalle('.$id.')" data-toggle="tooltip" data-placement="top" title="Detalle"></td>';
echo '<td class="align-middle text-center">'.$PDF.'</td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'archivo-tb.png" onclick="ModalArchivos('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')" data-toggle="tooltip" data-placement="top" title="Archivos"></td>';
echo '<td class="align-middle text-center">'.$Pago.'</td>';
echo '<td class="align-middle text-center">'.$Editar.'</td>';
echo '<td class="align-middle text-center">'.$Firmar.'</td>';
echo '<td class="align-middle text-center">'.$Nuevo.'<img width="20" class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" onclick="ModalComentario('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';
echo '<td class="align-middle text-center">'.$Eliminar.'</td>';
echo '</tr>';

$TotalMonto = $TotalMonto + $row_lista['monto'];
   }

    }else if($session_nompuesto != "Comercializadora" || $session_nompuesto != "Recursos humanos"){
    echo '<tr class="'.$trColor.'">';
echo '<td class="align-middle text-center">'.$num.'</td>';
if($estacion == "Gestoria"){
echo '<td class="align-middle text-center">'.$row_lista['razonsocial'].'</td>'; 
}
echo '<td class="align-middle text-center"><b>'.FormatoFecha($row_lista['fecha']).' '.date("H:i:s",$row_lista['fecha']).'</b></td>';
echo '<td class="align-middle text-center">'.$row_lista['beneficiario'].'</td>';
echo '<td class="align-middle text-center">$ '.number_format($row_lista['monto'],2).'</td>';
echo '<td class="align-middle text-center">'.$row_lista['no_factura'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['concepto'].'</td>';

if($estacion != "Gestoria"){
echo '<td class="align-middle text-center">'.$row_lista['telefono'].'</td>';
}
echo '<td class="align-middle text-center">'.$row_lista['metodo_pago'].'</td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="ModalDetalle('.$id.')" data-toggle="tooltip" data-placement="top" title="Detalle"></td>';
echo '<td class="align-middle text-center">'.$PDF.'</td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'archivo-tb.png" onclick="ModalArchivos('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')" data-toggle="tooltip" data-placement="top" title="Archivos"></td>';
echo '<td class="align-middle text-center">'.$Pago.'</td>';
echo '<td class="align-middle text-center">'.$Editar.'</td>';
echo '<td class="align-middle text-center">'.$Firmar.'</td>';
echo '<td class="align-middle text-center">'.$Nuevo.'<img width="20" class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" onclick="ModalComentario('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';
echo '<td class="align-middle text-center">'.$Eliminar.'</td>';
echo '</tr>';

$TotalMonto = $TotalMonto + $row_lista['monto'];
    }

  }else{
echo '<tr class="'.$trColor.'">';
echo '<td class="align-middle text-center">'.$num.'</td>';
if($estacion == "Gestoria"){
echo '<td class="align-middle text-center">'.$row_lista['razonsocial'].'</td>'; 
}



echo '<td class="align-middle text-center"><b>'.FormatoFecha($row_lista['fecha']).', '.date("g:i a",strtotime($row_lista['hora'])).'</b></td>';
echo '<td class="align-middle text-center">'.$row_lista['beneficiario'].'</td>'; 
echo '<td class="align-middle text-center">$ '.number_format($row_lista['monto'],2).'</td>';
echo '<td class="align-middle text-center">'.$row_lista['no_factura'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['concepto'].'</td>';

if($estacion != "Gestoria"){
echo '<td class="align-middle text-center">'.$row_lista['telefono'].'</td>';
}
echo '<td class="align-middle text-center">'.$row_lista['metodo_pago'].'</td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="ModalDetalle('.$id.')" data-toggle="tooltip" data-placement="top" title="Detalle"></td>';
echo '<td class="align-middle text-center">'.$PDF.'</td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'archivo-tb.png" onclick="ModalArchivos('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')" data-toggle="tooltip" data-placement="top" title="Archivos"></td>';
echo '<td class="align-middle text-center">'.$Pago.'</td>';
echo '<td class="align-middle text-center">'.$Editar.'</td>';
echo '<td class="align-middle text-center">'.$Firmar.'</td>';
echo '<td class="align-middle text-center">'.$Nuevo.'<img width="20" class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" onclick="ModalComentario('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';
echo '<td class="align-middle text-center">'.$Eliminar.'</td>';
echo '</tr>';

$TotalMonto = $TotalMonto + $row_lista['monto'];
  }

$num++;
}
}else{
echo "<tr><td colspan='16' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>

</tbody>
</table>

<hr>
</div>

<div class="text-end"><?='<h5>Monto total: $'.number_format($TotalMonto,2).'</h5>';?></div>

</div> 