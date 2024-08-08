<?php
require('../../../app/help.php');
$idReporte = $_GET['idReporte'];


$sql = "SELECT * FROM op_nivel_explosividad WHERE id = '".$idReporte."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$idEstacion = $row['id_estacion'];
$folio = $row['folio'];  
$fecha = $row['fecha'];  
} 

$sqlEstacion = "SELECT razonsocial, permisocre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$resultEstacion = mysqli_query($con, $sqlEstacion);
while($rowEstacion = mysqli_fetch_array($resultEstacion, MYSQLI_ASSOC)){
$Estacion = $rowEstacion['razonsocial']; 
$Cre = $rowEstacion['permisocre'];  
}

$sqlDetalle = "SELECT * FROM op_nivel_explosividad_detalle WHERE id_reporte = '".$idReporte."' ";
$resultDetalle = mysqli_query($con, $sqlDetalle);
$numeroDetalle = mysqli_num_rows($resultDetalle);

if($numeroDetalle > 0){
while($rowDetalle = mysqli_fetch_array($resultDetalle, MYSQLI_ASSOC)){
$elemento1 = !empty($rowDetalle['elemento1']) ? $rowDetalle['elemento1'] : "S/I";
$elemento2 = !empty($rowDetalle['elemento2']) ? $rowDetalle['elemento2'] : "S/I";  
$elemento3 = !empty($rowDetalle['elemento3']) ? $rowDetalle['elemento3'] : "S/I"; 
$elemento4 = !empty($rowDetalle['elemento4']) ? $rowDetalle['elemento4'] : "S/I";
$elemento5 = !empty($rowDetalle['elemento5']) ? $rowDetalle['elemento5'] : "S/I";  
$elemento6 = !empty($rowDetalle['elemento6']) ? $rowDetalle['elemento6'] : "S/I"; 
$elemento7 = !empty($rowDetalle['elemento7']) ? $rowDetalle['elemento7'] : "S/I";
$elemento8 = !empty($rowDetalle['elemento8']) ? $rowDetalle['elemento8'] : "S/I";  
$elemento9 = !empty($rowDetalle['elemento9']) ? $rowDetalle['elemento9'] : "S/I"; 
$elemento10 = !empty($rowDetalle['elemento10']) ? $rowDetalle['elemento10'] : "S/I";
$elemento11 = !empty($rowDetalle['elemento11']) ? $rowDetalle['elemento11'] : "S/I";  
$elemento12 = !empty($rowDetalle['elemento12']) ? $rowDetalle['elemento12'] : "S/I"; 
$elemento13 = !empty($rowDetalle['elemento13']) ? $rowDetalle['elemento13'] : "S/I";
$elemento14 = !empty($rowDetalle['elemento14']) ? $rowDetalle['elemento14'] : "S/I";  
$elemento15 = !empty($rowDetalle['elemento15']) ? $rowDetalle['elemento15'] : "S/I"; 
$elemento16 = !empty($rowDetalle['elemento16']) ? $rowDetalle['elemento16'] : "S/I";
$elemento17 = !empty($rowDetalle['elemento17']) ? $rowDetalle['elemento17'] : "S/I";  
$elemento18 = !empty($rowDetalle['elemento18']) ? $rowDetalle['elemento18'] : "S/I"; 
$observaciones = !empty($rowDetalle['observaciones']) ? $rowDetalle['observaciones'] : "S/I";  
}

}



$sql_lista = "SELECT * FROM op_nivel_explosividad_pozo_motobomba WHERE id_reporte = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

function Usuario($idUsuario, $con){
$sqlEstacion = "SELECT nombre FROM tb_usuarios WHERE id = '".$idUsuario."' ";
$resultEstacion = mysqli_query($con, $sqlEstacion);
while($rowEstacion = mysqli_fetch_array($resultEstacion, MYSQLI_ASSOC)){
$nombre = $rowEstacion['nombre'];  
}
return $nombre;
}

?>



<div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"> <i class="fa-solid fa-chevron-left"></i> Nivel de explosividad</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Detalle de medición</li>
  </ol>
  </div>

  <div class="row">
  <div class="col-12"><h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Detalle de medición</h3></div>

  </div>
  <hr>
  </div>


  <div class="table-responsive">
  <table class="custom-table mb-3" style="font-size: 12.5px;" width="100%">

  <thead class="tables-bg">

  <tr>
  <th class="align-middle text-center" colspan="3" >Estacion de Servicio:<?=$Estacion;?>, <?=$Cre;?></th>
  </tr>

  <tr class="title-table-bg">
  <td class="align-middle text-center"><b>FOLIO:</b> 00<?=$folio;?></td>
  <td class="align-middle text-center"><b>REFERENCIA:</b> NOM 005 ASEA 2016</td>
  <td class="align-middle text-center"><b>FECHA:</b> <?=$ClassHerramientasDptoOperativo->FormatoFecha($fecha);?></td>
  </tr>
  </thead> 

  <tbody class="bg-light">
  <tr>
  <th class="align-middle text-center no-hover2 fw-normal"><b>Tipo de Medicion</b> <br> <?=$elemento1?></th>
  <td class="align-middle text-center no-hover2"><b>Verificador</b> <br> <?=$elemento2?></td>
  <td class="align-middle text-center no-hover2"><b>Observaciones</b> <br> <?=$elemento3?></td>
  </tr>

  <tr>
  <th class="align-middle text-center no-hover2 fw-normal"><b>Estacionamiento</b> <br> <?=$elemento4?> PPM</th>
  <td class="align-middle text-center no-hover2"><b>Local Comercial</b> <br> <?=$elemento5?> PPM</td>
  <td class="align-middle text-center no-hover2">  <b>Oficinas</b> <br> <?=$elemento6?> PPM</td>
  </tr>

  <tr>
  <th class="align-middle text-center no-hover2 fw-normal"><b>Bodega Local</b> <br> <?=$elemento7?> PPM</th>
  <td class="align-middle text-center no-hover2"><b>Baños Empleados</b> <br> <?=$elemento8?> PPM</td>
  <td class="align-middle text-center no-hover2">  <b>Bodega de Aceites</b> <br> <?=$elemento9?> PPM</td>
  </tr>

  <tr>
  <th class="align-middle text-center no-hover2 fw-normal"><b>Baños Hombres</b> <br> <?=$elemento10?> PPM</th>
  <td class="align-middle text-center no-hover2"><b>Baños Mujeres</b> <br> <?=$elemento11?> PPM</td>
  <td class="align-middle text-center no-hover2"><b>Cuarto de Sucios</b> <br> <?=$elemento12?> PPM</td>
  </tr>

  <tr>
  <th class="align-middle text-center no-hover2 fw-normal"><b>Cuarto de Maquinas</b> <br> <?=$elemento13?> PPM</th>
  <td class="align-middle text-center no-hover2"><b>Zona 1 Despacho</b> <br> <?=$elemento14?> PPM</td>
  <td class="align-middle text-center no-hover2"><b>Zona 2 Despacho</b> <br> <?=$elemento15?> PPM</td>
  </tr>

  <tr>
  <th class="align-middle text-center no-hover2 fw-normal"><b>Zona 3 Despacho</b> <br> <?=$elemento16?> PPM</th>
  <td class="align-middle text-center no-hover2"><b>Cuarto de aditivo</b> <br> <?=$elemento17?> PPM</td>
  <td class="align-middle text-center no-hover2"><b>Zona de tanques</b> <br> <?=$elemento18?> PPM</td>
  </tr>

  </tbody>

  </table>
  </div>

  <!----------  ------------>
  <div class="row">

  <div class="col-xl-9 col-lg-9 col-md-6 col-sm-12 mb-3">
  <div class="table-responsive">
  <table class="custom-table mb-3" style="font-size: 12.5px;" width="100%">
  <thead class="tables-bg">
  <tr>
  <th class="align-middle text-center">Detalle</th>
  <th class="align-middle text-center">PPM</th>
  <th class="align-middle text-center">Ubicación de Pozos</th>
  </tr>
  </thead>
      
  <tbody class="bg-light">
  <?php
    if ($numero_lista > 0) {
    while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

    echo '<tr>';
    echo '<th class="align-middle text-center no-hover2 fw-normal">'.$row_lista['pozo_motobomba'].'</th>';
    echo '<td class="align-middle text-center no-hover2">'.$row_lista['ppm'].'</td>';
    echo '<td class="align-middle text-center no-hover2">'.$row_lista['ubicacion'].'</td>';
    echo '</tr>';

    }
    }else{
    echo "<tr><td colspan='4' class='text-center text-secondary no-hover2'><small>No se encontró información para mostrar </small></td></tr>";
    }
    ?>
  </tbody>
  </table>
  </div>

  <div class="table-responsive">
  <table class="custom-table mb-3" style="font-size: 12.5px;" width="100%">

  <thead>
  <tr class="navbar-bg align-middle text-center">
  <th>Observaciones</th>
  </tr>
  </thead>

  <tbody class="bg-light">
  <tr>
  <th class="p-3 no-hover2 fw-normal"><?=$observaciones?></t>
  </tr>
  </tbody>

  </table>
  </div>  

  </div>


  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
  <div class="table-responsive">
  <table class="custom-table" style="font-size: 12.5px;" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">PARTICULAS POR MILLON PPM</th> </tr>
  </thead>
  <tbody>
  <tr class="no-hover2"> <th class="align-middle text-center bg-light"><img src="<?=RUTA_IMG_ICONOS;?>SPD202ex.PNG" width="75%"></th> </tr>
  <tr class="no-hover2" style="font-size: .95em;"> <th class="align-middle text-center bg-light">LAS MEDICIONES SON CON EQUIPO "COMBUSTIBLE GAS ALARM DETECTOR SPD202/Ex"</th> </tr>

  </tbody>
  </table>
  </div>
  
  </div>

  <div class="col-12">
  <hr>

  <h5 class="text-secondary mb-3">Firmas:</h5>
  <div class="row">
    <?php
    $sql_firma = "SELECT * FROM op_nivel_explosividad_firma WHERE id_reporte = '".$idReporte."' ";
    $result_firma = mysqli_query($con, $sql_firma);
    $numero_firma = mysqli_num_rows($result_firma);
    while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

    $Usuario = Usuario($row_firma['id_usuario'], $con);  


    echo '  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
    <table class="custom-table" style="font-size: 14px;" width="100%">
    <thead class="tables-bg">
    <tr> <th class="align-middle text-center">'.$row_firma['tipo_firma'].'</th> </tr>
    </thead>
    <tbody class="bg-light">
    <tr>
    <th class="align-middle text-center no-hover2"><img src="'.RUTA_IMG.'firma/'.$row_firma['imagen_firma'].'" width="100%"></th>
    </tr>
  
    <tr>
    <th class="align-middle text-center no-hover2">'.$Usuario.'</th>
    </tr>
    
    </tbody>
    </table>
    </div>';
    }
  

    ?> 
  </div>

  </div>
  </div>