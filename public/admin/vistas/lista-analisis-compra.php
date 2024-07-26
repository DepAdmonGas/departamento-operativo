<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$GET_year = $_GET['year'];
$GET_mes = $_GET['mes']; 

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}
 
function IdReporte($idEstacion,$GET_year,$GET_mes,$con){
   $sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '".$idEstacion."' AND year = '".$GET_year."' ";
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
http://localhost:8080/departamento-operativo/administracion
   ValidarEmbarques($idEstacion,$IdReporte,$con);

   function ValidarEmbarques($idEstacion,$IdReporte,$con){

    $sql_lista = "SELECT * FROM op_embarques WHERE id_mes = '".$IdReporte."' AND (bruto = 0 OR neto = 0) ";
    $result_lista = mysqli_query($con, $sql_lista);
    $numero_lista = mysqli_num_rows($result_lista);
    while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

    $id = $row_lista['id'];
    $fecha = $row_lista['fecha'];
    $embarque = $row_lista['embarque'];
    $importef = $row_lista['importef'];

    $BuscarBrutoNeto = BuscarBrutoNeto($idEstacion,$fecha,$importef,$con);

    $sql_edit = "UPDATE op_embarques SET 
    bruto = '".$BuscarBrutoNeto['bruto']."',
    neto = '".$BuscarBrutoNeto['neto']."'
    WHERE id='".$id."' ";
    mysqli_query($con, $sql_edit);

   }
   }

   function BuscarBrutoNeto($idEstacion,$fecha,$importef,$con){
    $neto = 0;
    $bruto = 0;

    $sql_lista = "SELECT neto, bruto FROM op_mediciones WHERE id_estacion = '".$idEstacion."' AND fecha = '".$fecha."' AND factura = '".$importef."' ";
    $result_lista = mysqli_query($con, $sql_lista);
    $numero_lista = mysqli_num_rows($result_lista);
    while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

     $neto = $row_lista['neto'];
     $bruto = $row_lista['bruto'];
   }

   $array = array('neto' => $neto, 'bruto' => $bruto);

   return $array;
  }

  function Detalle($IdReporte,$producto,$con){
    if($producto == "G SUPER"){
        $Color = "background: #76bd1d;color: white;";
    }else if($producto == "G PREMIUM"){
        $Color = "background: #e21683;color: white;";
    }else if($producto == "G DIESEL"){
        $Color = "background: #5e0f8e;color: white;";
    }

    $contenido = "";
    $TOImporteF = 0;
    $TOBruto = 0;
    $TODif1 = 0;
    $TONeto = 0;
    $TODif2 = 0;
    $TOMC = 0;
    $TODif3 = 0;

    $sql_lista = "SELECT * FROM op_embarques WHERE id_mes = '".$IdReporte."' AND producto = '".$producto."' ORDER BY fecha ASC";
    $result_lista = mysqli_query($con, $sql_lista);
    $numero_lista = mysqli_num_rows($result_lista);
    if ($numero_lista > 0) {
        $contenido .= '<div class="table-responsive">
        <table class="custom-table mb-2 mt-1" style="font-size: 0.70em;" width="100%">
        <thead class="title-table-bg">
            <tr style="'.$Color.'">
                <th class="font-weight-bold text-center" colspan="'.($numero_lista + 2).'">'.$producto.'</th>
            </tr>
            <tr>
                <td class="fw-bold text-center align-middle"></td>';

        while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
          $explode = explode("-", $row_lista['fecha']);

            $contenido .= '<td class="fw-bold text-center align-middle">'.$explode[2].'</td>';
        }

        $contenido .= '<td class="fw-bold text-center align-middle">Total</td></tr></thead><tbody class="bg-white">';

        $campos = [
            "Día" => [],
            "Lts. Factura" => [],
            "Tipo" => [],
            "Bruto" => [],
            "Dif1" => [],
            "Neto" => [],
            "Dif2" => [],
            "Metro Contador" => [],
            "Dif3" => []
        ];

        mysqli_data_seek($result_lista, 0);
        while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
            $explode = explode("-", $row_lista['fecha']);
            $id = $row_lista['id'];
            $Bruto = $row_lista['bruto'] ?: 0;
            $Neto = $row_lista['neto'] ?: 0;
            $Diferencia1 = $Bruto - $row_lista['importef'];
            $Diferencia2 = $Neto - $row_lista['importef'];
            $MCPO = round($row_lista['importef'] * 0.5/100);
            $MetroContador = $row_lista['importef'] - $MCPO;
            $Diferencia3 = $MetroContador - $row_lista['importef'];

            $campos["Día"][] = get_nombre_dia($row_lista['fecha']);
            $campos["Lts. Factura"][] = number_format($row_lista['importef']);
            $campos["Tipo"][] = $row_lista['embarque'];
            $campos["Bruto"][] = '<input type="number" class="form-control border-0 rounded-0 p-2" style="font-size: 0.9em; width: 100%; height: 100%;" onkeyup="BrutoNeto(this,1,'.$id.')" value="'.$Bruto.'">';
            $campos["Dif1"][] = number_format($Diferencia1);
            $campos["Neto"][] = '<input type="number" class="form-control border-0 rounded-0 p-2" style="font-size: 0.9em; width: 100%; height: 100%;" onkeyup="BrutoNeto(this,2,'.$id.')" value="'.$Neto.'">';
            $campos["Dif2"][] = number_format($Diferencia2);
            $campos["Metro Contador"][] = number_format($MetroContador);
            $campos["Dif3"][] = number_format($Diferencia3);

            $TOImporteF += $row_lista['importef'];
            $TOBruto += $row_lista['bruto'];
            $TODif1 += $Diferencia1;
            $TONeto += $row_lista['neto'];
            $TODif2 += $Diferencia2;
            $TOMC += $MetroContador;
            $TODif3 += $Diferencia3;
        }

        foreach ($campos as $campo => $valores) {
            $contenido .= '<tr><th class="fw-bold text-center align-middle">'.$campo.'</th>';
            foreach ($valores as $valor) {
                $contenido .= '<td class="align-middle p-0">'.$valor.'</td>';
            }
            if ($campo == "Lts. Factura") {
                $contenido .= '<td class="fw-bold">'.number_format($TOImporteF).'</td>';
            } elseif ($campo == "Bruto") {
                $contenido .= '<td class="fw-bold">'.number_format($TOBruto).'</td>';
            } elseif ($campo == "Dif1") {
                $contenido .= '<td class="fw-bold">'.number_format($TODif1).'</td>';
            } elseif ($campo == "Neto") {
                $contenido .= '<td class="fw-bold">'.number_format($TONeto).'</td>';
            } elseif ($campo == "Dif2") {
                $contenido .= '<td class="fw-bold">'.number_format($TODif2).'</td>';
            } elseif ($campo == "Metro Contador") {
                $contenido .= '<td class="fw-bold">'.number_format($TOMC).'</td>';
            } elseif ($campo == "Dif3") {
                $contenido .= '<td class="fw-bold">'.number_format($TODif3).'</td>';
            } else {
                $contenido .= '<td></td>';
            }
            $contenido .= '</tr>';
        }

        $contenido .= '</tbody></table></div>';

    } else {
        $contenido .= '
        
        <div class="alert mb-2 mt-1 text-center" role="alert" style="'.$Color.'">
        No se encontró información para mostrar
        </div>';
    }

    return $contenido;
}


$Detalle1 = Detalle($IdReporte,'G SUPER',$con);
$Detalle2 = Detalle($IdReporte,'G PREMIUM',$con);
$Detalle3 = Detalle($IdReporte,'G DIESEL',$con);

?>


<div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Importación</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Analisis de Compra (<?=$estacion;?>)</li>
  </ol>
  </div>

  <div class="row">
  <div class="col-12">
  <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Analisis de Compra (<?=$estacion;?>)</h3>
  </div>
  </div>

  <hr>
  </div>


  <div class="row">
  <div class="col-12"> 
  <?=$Detalle1;?>
  </div>

  <div class="col-12"> 
  <?=$Detalle2;?>
  </div>

  <div class="col-12"> 
  <?=$Detalle3;?>
  </div>
  </div>