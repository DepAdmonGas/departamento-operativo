 <?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$sql_lista = "SELECT * FROM op_incidencias_estaciones WHERE id_estacion = '".$idEstacion."' ORDER BY fecha ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);


$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}

?>

 
  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item" onclick="history.back()"><a class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Portal</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Incidencias (<?=$estacion;?>)</li>
  </ol>
  </div>

  <div class="row">
  <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 mb-1">
  <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Incidencias (<?=$estacion;?>)</h3>
  </div>

  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mt-2">
  <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="ModalNuevaIncidencia(<?=$idEstacion;?>)">
  <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
  </div>

  </div>

  <hr>
  </div>

 
  <div class="table-responsive">
  <table id="table_incidencias" class="custom-table" style="font-size: .9em;" width="100%">
  <thead class="tables-bg">
    <th class="text-center align-middle font-weight-bold">#</th>
    <th class="text-center align-middle font-weight-bold">Fecha y hora</th>
    <th class="text-center align-middle font-weight-bold">Incidente</th>
    <th class="text-center align-middle font-weight-bold">Responsable</th>
    <th class="text-center align-middle font-weight-bold">Asunto</th>
    <th class="text-center align-middle font-weight-bold">Comentarios</th>
    <th class="align-middle text-center" width="20"><i class="fas fa-ellipsis-v"></i></th>

  </thead> 

  <tbody class="bg-white">
  <?php
  if ($numero_lista > 0) {
  $num = 1;
  while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
  $id_incidencia = $row_lista['id_incidencias_estaciones'];
  $fecha = $row_lista['fecha'];
  $hora = $row_lista['hora'];
  $incidente = $row_lista['incidente'];
  $responsable = $row_lista['responsable'];
  $asunto = $row_lista['asunto'];
  $comentarios = $row_lista['comentarios'];
  $archivo = $row_lista['archivo'];
  
  $Detalle = '<a class="dropdown-item" onclick="ModalVerIncidencia('.$id_incidencia.')"><i class="fa-regular fa-eye"></i> Detalle</a>';
  
  $Editar = '<a class="dropdown-item" onclick="ModalEditarIncidencia('.$id_incidencia.','.$idEstacion.')"><i class="fa-solid fa-pencil"></i> Editar</a>';
  $Eliminar = '<a class="dropdown-item" onclick="EliminarIncidencia('.$id_incidencia.','.$idEstacion.')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';

  if($archivo != ""){
  $PDF = '<a class="dropdown-item" href="'.RUTA_ARCHIVOS.'incidencias/'.$archivo.'" download><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
  }else{
  $MultimediaTB = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png">';
  $PDF = '<a class="dropdown-item"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
  }  
  
  echo '<tr>';
  echo '<th class="align-middle text-center">'.$num.'</th>';
  echo '<td class="align-middle text-center">'.FormatoFecha($fecha).',  '.date("g:i a",strtotime($hora)).'</td>';
  echo '<td class="align-middle text-center">'.$incidente.'</td>';
  echo '<td class="align-middle text-center">'.$responsable.'</td>';
  echo '<td class="align-middle text-center">'.$asunto.'</td>';
  echo '<td class="align-middle text-center">'.$comentarios.'</td>';

  echo '<td class="align-middle text-center"> 
          <div class="dropdown">
            <a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-ellipsis-v"></i>
            </a>

            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
              ' . $Detalle . '
              ' . $PDF . '
              ' . $Editar . '
              ' . $Eliminar . '
            </div>
          </div>
        </td>';
  echo '</tr>';

  $num++;
  }
  }
  ?>
  </tbody>
  </table>
  </div>

