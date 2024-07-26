<?php
require ('../../../../help.php');
$idOrganigrama = $_GET['idOrganigrama'];
$idEstacion = $_GET['idEstacion'];
$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($idEstacion);


if ($idOrganigrama == 0) {
$sql_organigrama = "SELECT * FROM op_rh_organigrama_estacion WHERE id_estacion = '" . $idEstacion . "' ORDER BY version DESC LIMIT 1";
} else {
$sql_organigrama = "SELECT * FROM op_rh_organigrama_estacion WHERE id = '" . $idOrganigrama . "' ";
}

$result_organigrama = mysqli_query($con, $sql_organigrama);
$numero_organigrama = mysqli_num_rows($result_organigrama);
if ($numero_organigrama > 0) {
while ($row_organigrama = mysqli_fetch_array($result_organigrama, MYSQLI_ASSOC)) {
$archivo = '<img style="width: 100%" src="archivos/organigrama/' . $row_organigrama['archivo'] . '">';
}
} else {
$archivo = '';
}
 
$sql_lista = "SELECT * FROM op_rh_organigrama_estacion WHERE id_estacion = '" . $idEstacion . "' ORDER BY version DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

$tablaAL = "";
$ColorTB = "tables-bg";
$tablaDesc1 = '<th class="text-center align-middle">Versión</th>';
$tablaDesc2 = '<th class="align-middle text-center" width="20"><img src="'.RUTA_IMG_ICONOS.'eliminar.png"></th>';
$Div2 = '';
$ocultarTitle = "";


if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
$Estacion = "";
if($idEstacion == 9){
$Div2 = '<hr>';
$tablaAL = '<tr class="tables-bg">
<th class="text-center align-middle tableStyle fw-bold" colspan="6">Autolavado</th>
</tr>';
$tablaDesc = "td";
$tablaDesc1 = '<td class="text-center align-middle tableStyle fw-bold">Versión</td>';
$tablaDesc2 = '<td class="align-middle text-center" width="20"><img src="'.RUTA_IMG_ICONOS.'eliminar.png"></td>';
$ColorTB = "title-table-bg";
$ocultarTitle = "d-none";

}

}else{
$ColorTB = "tables-bg";
$Estacion = '('.$datosEstacion['localidad'].')';

}

  

?>

<?=$Div2 ?>

<div class="col-12 <?=$ocultarTitle?>">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Recursos Humanos</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Organigrama <?=$Estacion?></li>
</ol>
</div>

<div class="row">
<div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
<h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Organigrama <?=$Estacion?></h3>
</div>

<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
<div class="text-end">


<?php 
if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
if ($idEstacion == 2) { 
?>

<div class="dropdown d-inline ms-2">
<button type="button" class="btn btn-primary btn-labeled2" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
<span class="btn-label2"> <i class="fa-solid fa-plus"></i></span>Agregar
</button>

<ul class="dropdown-menu">
<li onclick="Mas(<?= $idEstacion ?>)"><a class="dropdown-item pointer"> <i class="fa-solid fa-gas-pump"></i> Palo Solo</a></li>
<li onclick="Mas(9)"><a class="dropdown-item pointer"> <i class="fa-solid fa-car"></i> Autolavado</a></li>
</ul>
</div>

<?php } else { ?>
<button type="button" class="btn btn-labeled2 btn-primary" onclick="Mas(<?=$idEstacion?>)"> <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
<?php }
}else{
?>
<button type="button" class="btn btn-labeled2 btn-primary" onclick="Mas(<?=$idEstacion?>)"> <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
<?php }  ?>

</div>

</div>
</div>

<hr>
          
</div>


 
<div class="row">
    <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 mb-3">
        <?= $archivo; ?>
    </div>
    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
        <div>
            <div class="table-responsive">
                <table class="custom-table " style="font-size: .8em;" width="100%">
                    <thead class="<?=$ColorTB?>">

                    <?=$tablaAL?>
                        <tr>
                    <?=$tablaDesc1?>                            
                            <th class="text-center align-middle tableStyle font-weight-bold">Fecha y hora</th>
                            <th class="text-center align-middle tableStyle font-weight-bold">Observaciones</th>
                            <?=$tablaDesc2?>                            

                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <?php
                        if ($numero_lista > 0) {

                            while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
                                $id = $row_lista['id'];
                                $explode = explode(' ', $row_lista['fechacreacion']);

                                echo '<tr class="pointer" onclick="SelEstacion(' . $idEstacion . ',' . $id . ')">
                                    <th class="align-middle text-center"><b>' . $row_lista['version'] . '</b></th>
                                    <td class="align-middle">' . $ClassHerramientasDptoOperativo->FormatoFecha($explode[0]) . ', ' . date("g:i a", strtotime($explode[1])) . '</td>
                                    <td class="text-center align-middle"><small>' . $row_lista['observaciones'] . '</small></td>
                                    <td class="align-middle text-center pointer" width="20" onclick="Eliminar(' . $idEstacion . ',' . $id . ')"><img src="' . RUTA_IMG_ICONOS . 'eliminar.png"></td>
                                    </tr>';
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
        // verifica la estacion en la que se encuentra
        if (in_array($idEstacion, [1, 2, 3, 4, 5, 6, 7, 14])):
            echo $ClassRecursosHumanosGeneral->mostrarEstacion($idEstacion);
        endif;
        ?>
    </div>
</div>
</div>