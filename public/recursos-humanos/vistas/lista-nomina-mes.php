<?php
require('../../../app/help.php');
 
$idEstacion = $_GET['idEstacion'];
$GET_year = $_GET['year'];
$GET_mes = $_GET['mes'];
$GET_semana = $_GET['semana'];

if($GET_semana == 1){
  $nombreSemana = "Primera Semana";

}else if($GET_semana == 2){
  $nombreSemana = "Segunda Semana";

}else if($GET_semana == 3){
  $nombreSemana = "Tercera Semana";

}else if($GET_semana == 4){
  $nombreSemana = "Cuarta Semana";

}else if($GET_semana == 5){
  $nombreSemana = "Quinta Semana";

}else if($GET_semana == 6){
  $nombreSemana = "Primera Quincena";

}else if($GET_semana == 7){
  $nombreSemana = "Segunda Quincena";

}else if($GET_semana == 8){
  $nombreSemana = "Aguinaldo";
}


$sql = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Titulo = $row['localidad'];
}

$sql_lista = "SELECT * FROM op_recibo_nomina WHERE id_estacion = '".$idEstacion."' AND year = '".$GET_year."' AND mes = '".$GET_mes."' AND periodo = '".$nombreSemana."' ORDER BY fecha ASC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

function Personal($idusuario, $con){
$sql = "SELECT nombre FROM tb_usuarios WHERE id = '".$idusuario."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
}

       
function PersonalNomina($idPersonal, $con){
$sql = "SELECT 
op_rh_personal.no_colaborador, 
op_rh_personal.nombre_completo, 
op_rh_puestos.puesto 
FROM op_rh_personal 
INNER JOIN op_rh_puestos ON op_rh_personal.puesto = op_rh_puestos.id
WHERE op_rh_personal.id = '".$idPersonal."' ";

$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$no_colaborador = $row['no_colaborador'];
$nombreNomina = $row['nombre_completo'];
$puesto = $row['puesto'];
}

$array = array(
  'no_colaborador' => $no_colaborador, 
  'nombreNomina' => $nombreNomina,
  'puesto' => $puesto
);

return $array;

}


function DocumentoFirmado($id, $con){
$sql = "SELECT documento FROM op_recibo_nomina_documento WHERE id_nomina = '".$id."'  ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$documento = $row['documento'];
}

return $documento;	
} 

function ToComentarios($IdReporte,$con){

$sql_lista = "SELECT id FROM op_recibo_nomina_comentarios WHERE id_nomina = '".$IdReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
  
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
  <h5><?=$Titulo;?></h5>
</div>
  
<div class="col-2">

<?php if ($session_nompuesto != "Contabilidad" && $session_nompuesto != "Comercializadora" && $session_nompuesto != "Dirección de operaciones servicio social") { ?>
<img class="ms-2 float-end pointer" onclick="Mas(<?=$idEstacion;?>,<?=$GET_year;?>,<?=$GET_mes;?>,<?=$GET_semana;?>)" src="<?=RUTA_IMG_ICONOS;?>agregar.png">
<img class="ms-2 float-end pointer" onclick="AcuseNomina(<?=$idEstacion;?>,<?=$GET_year;?>,<?=$GET_mes;?>,<?=$GET_semana;?>)" src="<?=RUTA_IMG_ICONOS;?>archivo-tb.png">
<?php } ?>

</div>

</div>

<hr>

<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle tableStyle font-weight-bold">#</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Fecha de ingreso</th>
  <!-- <th class="text-center align-middle tableStyle font-weight-bold">Nombre</th> -->
  <th class="text-center align-middle tableStyle font-weight-bold">No. Colaborador</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Nombre del personal</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Puesto</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Percepciones</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Deducciones</th>
  <th class="text-center align-middle tableStyle font-weight-bold">ISR</th>
  <th class="text-center align-middle tableStyle font-weight-bold">ISR (Retenido)</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Total</th>  
  <!-- <th class="text-center align-middle tableStyle font-weight-bold">Periodo</th> -->
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf-firma.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-comentario-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf-subir.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
  </tr>
</thead> 
<tbody> 
<?php
if ($numero_lista > 0) { 
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$nombre = Personal($row_lista['id_usuario'], $con);
$DocumentoFirmado = DocumentoFirmado($id, $con);

$id_personal_nomina = $row_lista['id_personal_nomina'];

if($id_personal_nomina == 0){
  $no_colaborador2 = "-";
  $nombreNomina = 'General';
  $puestoNomina = "-";
  $estadoNomina = 0;
  $ruta_nomina_archivo = 'href="'.RUTA_ARCHIVOS.''.$row_lista['nomina'].'"';
  $ruta_nomina_firma = 'href="'.RUTA_ARCHIVOS.''.$DocumentoFirmado.'"';

  $percepciones = "-";
  $deducciones = "-";
  $isr = "-";
  $isr_retenido = "-";
  $total = "-"; 
  $editarNomina = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png" data-toggle="tooltip" data-placement="top" title="Editar">';


}else{
 $datosNomina = PersonalNomina($id_personal_nomina, $con);
 $no_colaborador = $datosNomina['no_colaborador'];
 $nombreNomina = $datosNomina['nombreNomina'];
 $puestoNomina = $datosNomina['puesto'];

 $percepciones = $row_lista['percepciones']; 
 $deducciones = $row_lista['deducciones'];
 $isr = $row_lista['isr'];
 $isr_retenido = $row_lista['isr_retenido'];
 $total = $row_lista['total'];  
 $editarNomina = '<img class="pointer" onclick="editarNomina('.$id.','.$idEstacion.','.$GET_year.','.$GET_mes.','.$GET_semana.','.$estadoNomina.')" src="'.RUTA_IMG_ICONOS.'editar-tb.png" data-toggle="tooltip" data-placement="top" title="Editar">';

 $estadoNomina = $id_personal_nomina;
 $ruta_nomina_archivo = 'href="'.RUTA_ARCHIVOS.'recibos-nomina/'.$row_lista['nomina'].'"';
 $ruta_nomina_firma = 'href="'.RUTA_ARCHIVOS.'recibos-nomina/firmados/'.$DocumentoFirmado.'"';

if($no_colaborador == 0){
  $no_colaborador2 = "S/I";
}else{
  $no_colaborador2 = $no_colaborador;
}


}



$explode = explode(" ", $row_lista['fecha']);
$fecha = $explode[0];

if($row_lista['status'] == 0){
$PDF = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pdf-firma.png" data-toggle="tooltip" data-placement="top" title="Recibos de nomina firmados">';
$SubirPDF = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf-subir.png" onclick="SubirPDF('.$id.','.$idEstacion.','.$GET_year.','.$GET_mes.','.$GET_semana.','.$estadoNomina.')" data-toggle="tooltip" data-placement="top" title="Subir Recibo de Nomina">';
$Eliminar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$id.','.$idEstacion.','.$GET_year.','.$GET_mes.','.$GET_semana.')" data-toggle="tooltip" data-placement="top" title="Eliminar">';

}else{
$PDF = '<a class="pointer" '.$ruta_nomina_firma.' download>
<img src="'.RUTA_IMG_ICONOS.'pdf-firma.png" data-toggle="tooltip" data-placement="top" title="Recibos de nomina firmados">
</a>';
$SubirPDF = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf-subir.png" onclick="SubirPDF('.$id.','.$idEstacion.','.$GET_year.','.$GET_mes.','.$GET_semana.','.$estadoNomina.')" data-toggle="tooltip" data-placement="top" title="Subir Recibo de Nomina">';
$Eliminar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Eliminar">';

}

  $ToComentarios = ToComentarios($id,$con);

  if($ToComentarios > 0){
  $Nuevo = '<div class="float-end" style="margin-bottom: -5px"><span class="badge bg-danger text-white rounded-circle"><small>'.$ToComentarios.'</small></span></div>';
  }else{
  $Nuevo = ''; 
  } 

echo '<tr>';
echo '<td class="align-middle text-center"><b>'.$num.'</b></td>';
echo '<td class="align-middle text-center">'.FormatoFecha($fecha).'</td>';
// echo '<td class="align-middle text-center">'.$nombre.'</td>';
echo '<td class="align-middle text-center">'.$no_colaborador2 .'</td>';
echo '<td class="align-middle text-center">'.$nombreNomina.'</td>';
echo '<td class="align-middle text-center">'.$puestoNomina.'</td>'; 
echo '<td class="align-middle text-center">'.$percepciones.'</td>'; 
echo '<td class="align-middle text-center">'.$deducciones.'</td>'; 
echo '<td class="align-middle text-center">'.$isr.'</td>'; 
echo '<td class="align-middle text-center">'.$isr_retenido.'</td>'; 
echo '<td class="align-middle text-center">'.$total.'</td>'; //echo '<td class="align-middle text-center"><b>'.$row_lista['periodo'].'</b></td>';
echo '<td class="align-middle text-center"><a class="pointer" '.$ruta_nomina_archivo.' download>
<img src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Recibos de nomina"></a>
</td>';
echo '<td class="align-middle text-center">'.$PDF.'</td>';
echo '<td class="align-middle text-center">'.$Nuevo.'<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" onclick="ModalComentario('.$id.','.$idEstacion.','.$GET_year.','.$GET_mes.','.$GET_semana.')" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';
echo '<td class="align-middle text-center">'.$SubirPDF.'</td>';
echo '<td class="align-middle text-center">'.$editarNomina.'</td>';
echo '<td class="align-middle text-center">'.$Eliminar.'</td>';
echo '</tr>';

$num++;
}
}else{
echo "<tr><td colspan='9' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>

</tbody>
</table>
</div>

</div>

 


