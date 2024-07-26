<?php
require('../../../app/help.php');
$idReporte = $_GET['idReporte'];
$idPersonal = $_GET['idPersonal'];
$year = $_GET['year'];

$datosUsuario = $ClassHerramientasDptoOperativo->obtenerDatosPersonal($idPersonal);
$NomUsuario = $datosUsuario['nombre_personal'];
function NombreEstacion($id,$con){
$return = "";
$sql_listaestacion = "SELECT id, localidad FROM op_rh_localidades WHERE id = '".$id."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$return = $row_listaestacion['localidad'];	
}
return $return;
}

function Firmas($idFormato,$tipo,$con){
    $resultado = "";
    $id_usuario = "";
    
    $sql_firma = "SELECT * FROM op_rh_formatos_firma WHERE id_formato = '".$idFormato."' AND tipo_firma = '".$tipo."' ";
    $result_firma = mysqli_query($con, $sql_firma);
    $numero_firma = mysqli_num_rows($result_firma);
    while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){
    $explode = explode(' ', $row_firma['fecha']);
    $firma = $row_firma['firma'];
    $id_usuario = $row_firma['id_usuario'];
    }
    
    if($numero_firma != 0){
    $Detalle = '<div class="text-center" style="font-size: 1em;"><small class="text-secondary">La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';    
    }else{
    $Detalle = '<div class="text-center text-danger"><small>Falta firma</small></div>'; 
    }
    
    $resultado.= '  <div class="col-12">
    <table class="custom-table" style="font-size: 14px;" width="100%">
    <thead class="tables-bg">
    <tr> <th class="align-middle text-center">'.PersonalPortal($id_usuario,$con).'</th> </tr>
    </thead>
    <tbody class="bg-light">
    <tr>
    <th class="align-middle text-center no-hover2">'.$Detalle.'</th>
    </tr>

    <tr>
    <th class="align-middle text-center no-hover2">NOMBRE Y FIRMA DE AUTORIZACIÓN</th>
    </tr>
    
    </tbody>
    </table>
    </div>';

    
    return $resultado;
    }

    function PersonalPortal($idusuario,$con){
        $nombre = "Sin información";
        $sql = "SELECT nombre FROM tb_usuarios WHERE id = '".$idusuario."' ";
        $result = mysqli_query($con, $sql);
        $numero = mysqli_num_rows($result);
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $nombre = $row['nombre'];
        }
        return $nombre;
        }

$sql = "SELECT 
op_rh_formatos.id_localidad,
op_rh_formatos.status,
op_rh_formatos_vacaciones.id_usuario,
op_rh_formatos_vacaciones.num_dias,
op_rh_formatos_vacaciones.fecha_inicio,
op_rh_formatos_vacaciones.fecha_termino,
op_rh_formatos_vacaciones.fecha_regreso,
op_rh_formatos_vacaciones.observaciones
FROM op_rh_formatos 
RIGHT JOIN op_rh_formatos_vacaciones 
ON op_rh_formatos.id = op_rh_formatos_vacaciones.id_formulario 
WHERE op_rh_formatos.id = '".$idReporte."'";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);


while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$idusuario = $row['id_usuario']; 
$numdias = $row['num_dias'];
$fechainicio = $row['fecha_inicio'];
$fechatermino = $row['fecha_termino'];
$fecharegreso = $row['fecha_regreso'];
$observaciones2 = $row['observaciones'];
$Localidad = $row['id_localidad'];

}
    
if($observaciones2 == ""){
$observaciones = "Sin observaciones";
}else{
$observaciones = $observaciones2;
}
    

?>


<div class="modal-header">
<h5 class="modal-title">Detalle Vacaciones <?=$year?> - <?=$NomUsuario?></h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">
<div class="table-responsive">
<table class="custom-table mb-3" style="font-size: 12.5px;" width="100%">
<tr>
<td class="font-weight-bold tables-bg"><b>Área o Departamento:</b></td>
<td class="font-weight-bold tables-bg"><b>Nombre completo:</b></td>
<td class="font-weight-bold tables-bg"><b>Número de días a disfrutar:</b></td>
</tr>
<tr>
<td class="bg-light"><?=NombreEstacion($Localidad,$con);?></td>
<td class="bg-light"><?=$NomUsuario?></td>
<td class="bg-light"><?=$numdias;?></td>
</tr>

<tr>
<th class="tables-bg">Del:</th>
<td class="tables-bg"><b>Al:</b></td>
<th class="tables-bg">Regresando el:</th>
</tr>
<tr>
<td class="bg-light"><?=FormatoFecha($fechainicio);?></td>
<td class="bg-light"><?=FormatoFecha($fechatermino);?></td>
<td class="bg-light"><?=FormatoFecha($fecharegreso);?></td>
</tr>

</table>
</div>
 
<div class="table-responsive">
<table class="custom-table" style="font-size: 12.5px;" width="100%">
<thead class="tables-bg">
<tr> <th class="align-middle text-center">Observaciones</th> </tr>
</thead>
<tbody>
<tr class="no-hover">
<th class="align-middle text-center fw-normal bg-light"><?=$observaciones?></th>
</tr>
</tbody>
</table>
</div>



<hr>


<?=$Solicitante = Firmas($idReporte,'C',$con)?>

</div>


<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-danger" onclick="regresarModal(<?=$idPersonal?>,<?=$year?>)">
<span class="btn-label2"><i class="fa-solid fa-chevron-left"></i></span>Regresar</button>

<button type="button" class="btn btn-labeled2 btn-success" onclick="DescargarPDF(<?=$idReporte?>)">
<span class="btn-label2"><i class="fa-regular fa-file-pdf"></i></span>Descargar PDF</button>
</div>





