<?php
require ('../../../../../help.php');
$GET_idReporte = $_GET['idReporte']; 

$sql_formatos = "SELECT fecha_creacion, year, quincena, status FROM op_rh_dia_doble_registro WHERE id = '" . $GET_idReporte . "' ";
$result_formatos = mysqli_query($con, $sql_formatos);

while ($row_formatos = mysqli_fetch_array($result_formatos, MYSQLI_ASSOC)) {
$explode = explode(' ', $row_formatos['fecha_creacion']);
$HoraFormato = date("g:i a",strtotime($explode[1]));
$quincena = $row_formatos['quincena'];
$year = $row_formatos['year'];
$status = $row_formatos['status'];

}

$mes = $ClassHerramientasDptoOperativo->obtenerMesPorQuincena($quincena);
//---------- FECHA DE INICIO Y FIN DE LA QUINCENA ----------
$fechaNomiaQuincena = $ClassHerramientasDptoOperativo->fechasNominaQuincenas($year,$mes,$quincena);
$inicioQuincenaDay = $fechaNomiaQuincena['inicioQuincenaDay'];
$finQuincenaDay = $fechaNomiaQuincena['finQuincenaDay'];

?>


<div class="modal-header">
<h5 class="modal-title">Detalle Dias Dobles</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
<div class="row">

<div class="col-12 text-end mb-3 ">
  <b>No. de Folio:</b> 00<?=$GET_idReporte?>
  
  <p>Huixquilucan, Edo. de México a <?=$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.$HoraFormato;?></p>
  </div>

  <div class="col-12">
  <b>Lic. Alejandro Guzmán</b>
  <br>
  <p><b>Departamento de Recursos Humanos</b></p>
  <p>Buenos días, Por medio de la presente, les informo sobre los días dobles asignados al personal del Departamento de Dirección de Operaciones, correspondientes a la <b>Quincena No. <?=$quincena?></b>, 
  que abarca del <b><?=$ClassHerramientasDptoOperativo->FormatoFecha($inicioQuincenaDay)?></b>
  al <b><?=$ClassHerramientasDptoOperativo->FormatoFecha($finQuincenaDay)?></b> 
  <br> A continuación, detallo la información para cada uno de los colaboradores:
  </p>
  </div>


  <div class="col-12">

  <div class="table-responsive mb-4">
  <table class="custom-table" width="100%">

  <thead class="tables-bg">
  <tr>
  <th class="align-middle text-center">#</th>
  <th class="align-middle text-center">Empleado</th>
  <th class="align-middle text-center">Dia Doble</th>

  </tr>
  </thead>

  <tbody class="bg-light">
  <?php
  $sql_lista = "SELECT * FROM op_rh_dia_doble_personal WHERE id_registro = '" . $GET_idReporte . "' ORDER BY id_usuario ASC";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);

  if ($numero_lista > 0) {
  $num = 1;
  while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
  $id = $row_lista['id'];
 
  $idUsuario = $row_lista['id_usuario'];
  $datosPersonal = $ClassHerramientasDptoOperativo->obtenerDatosPersonal($idUsuario);
  $NombreC = $datosPersonal['nombre_personal'];
  $fecha_doble = $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha_doble']);

  echo '<tr>';              
  echo '<th class="align-middle text-center">' . $num . '</th>';      
  echo '<td class="align-middle text-center">' . $NombreC . '</td>';  
  echo '<td class="align-middle text-center">' . $fecha_doble . '</td>';       
  echo '</tr>';
       
  $num++;                     
  }

  } else {
  echo "<tr><th colspan='15' class='text-center text-secondary fw-normal'><small>No se encontró información para mostrar </small></th></tr>";
  }
  ?>

  </tbody>
  </table>
  </div>




  <div class="col-12 text-center"><p>Sin más por el momento quedo de usted.</p><hr></div>
  </div>



  <!---------- fIRMAS DE ELABORACION DEL FORMATO ---------->
  <div class="col-12">
  <div class="row">

  <?php 
  $sql_firma = "SELECT * FROM op_rh_dias_dobles_firma WHERE id_formato = '".$GET_idReporte."' ";
  $result_firma = mysqli_query($con, $sql_firma);
  $numero_firma = mysqli_num_rows($result_firma);

  while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){
  $explode = explode(' ', $row_firma['fecha']);

  $datosUsuario = $ClassHerramientasDptoOperativo->obtenerDatosUsuario($row_firma['id_usuario']);
  $nombreUser = $datosUsuario['nombre'];


  if($row_firma['tipo_firma'] == "A"){
  $TipoFirma = "NOMBRE Y FIRMA DE QUIEN ELABORÓ";
  $Detalle = '<div class="border-0 text-center"><img src="'.RUTA_IMG_Firma.''.$row_firma['firma'].'" width="70%"></div>';
    
  }else if($row_firma['tipo_firma'] == "B"){
  $TipoFirma = "NOMBRE Y FIRMA DE VOBO";
  $Detalle = '<div class="text-center" style="font-size: 1em;"><small class="text-secondary">La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
    
  }else if($row_firma['tipo_firma'] == "C"){
  $TipoFirma = "NOMBRE Y FIRMA DE AUTORIZACIÓN";
  $Detalle = '<div class="text-center" style="font-size: 1em;"><small class="text-secondary">La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';

  }
    
  echo '  <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-2">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">'.$nombreUser.'</th> </tr>
  </thead>
  <tbody class="bg-light">
  <tr>
  <th class="align-middle text-center no-hover2">'.$Detalle.'</th>
  </tr>

  <tr>
  <th class="align-middle text-center no-hover2">'.$TipoFirma.'</th>
  </tr>
  
  </tbody>
  </table>
  </div>';
  }

  ?>
  </div>
    </div> 


  </div>

</div> 