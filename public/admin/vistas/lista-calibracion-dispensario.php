<?php
require('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];
$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosEstacion($idEstacion);

$sql_listaestacion = "SELECT localidad, recuperacion_vapores FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}

$sql_lista = "SELECT * FROM op_calibracion_dispensario WHERE id_estacion = '".$idEstacion."' ORDER BY year DESC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

//---------- Configuracion personal ----------//
if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
  $titleMenu = '<i class="fa-solid fa-house"></i> Almacén';
  $Estacion = '';
  $ocultarTB = "d-none";
  
  }else{ 
  $titleMenu = '<i class="fa-solid fa-chevron-left"></i> Mantenimiento';
  $Estacion = '('.$datosEstacion['nombre'].')';
  $ocultarTB = "";
    
  } 
  

?>
 
 <div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"> <?=$titleMenu?></a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Calibración de dispensarios <?=$Estacion?></li>
</ol>
</div>

<div class="row">
<div class="col-xl-9 col-lg-9 col-md-6 col-sm-12"><h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Calibración de dispensarios <?=$Estacion?></h3></div>
<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
<button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="ModalNuevo(<?=$idEstacion;?>)">
<span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
</div>

</div>
<hr>
</div>



<div class="table-responsive">
<table id="tabla_calibracion_<?=$idEstacion?>" class="custom-table" style="font-size: 12.5px;" width="100%">

      <thead class="title-table-bg">
        <tr>
          <th class="align-middle text-center" width="48">#</th>
          <th class="align-middle text-center">Fecha</th>
          <th class="align-middle text-center">Año</th>
          <th class="align-middle text-center">Periodo</th>
          <th class="align-middle text-center" width="24"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
          <th class="align-middle" width="24"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
        </tr>
      </thead>
      <tbody class="bg-white">
        <?php
		if ($numero_lista > 0) {
    $num = 1;
    
		while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
    $Fecha = explode(" ", $row_lista['fecha']);

		echo '<tr>';
		echo '<th class="align-middle text-center">'.$num.'</th>';
		echo '<td class="align-middle text-center">'.$ClassHerramientasDptoOperativo->FormatoFecha($Fecha[0]).'</td>';
    echo '<td class="align-middle text-center"><b>'.$row_lista['year'].'</b></td>';
    echo '<td class="align-middle text-center">'.$row_lista['periodo'].'</td>';
    echo '<td class="text-center align-middle"><a href="'.RUTA_ARCHIVOS.''.$row_lista['archivo'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></td>';
		echo '<td class="text-center align-middle"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$idEstacion.','.$row_lista['id'].')"></td>';
		echo '</tr>';
    $num++;
		}
		}else{
		echo "<tr><td colspan='6' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
		}
		?>
      </tbody>
    </table>
  </div>

