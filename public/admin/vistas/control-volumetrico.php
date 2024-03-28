 
<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

    function TotalAtio($idDias,$con){
     $sql = "SELECT * FROM op_despacho_factura WHERE id_dia = '".$idDias."' ";
    $result = mysqli_query($con, $sql);
    $numero = mysqli_num_rows($result);
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
      
    $LProductouno = $row['litros_producto_uno'];
    $LProductodos = $row['litros_producto_dos'];
    $LProductotres = $row['litros_producto_tres'];
    $PProducto_uno = $row['pesos_producto_uno'];
    $PProducto_dos = $row['pesos_producto_dos'];
    $PProducto_tres = $row['pesos_producto_tres'];

    }

    $array = array(
      'LProductouno' => $LProductouno,
      'LProductodos' => $LProductodos,
      'LProductotres' => $LProductotres,
      'PProductouno' => $PProducto_uno,
      'PProductodos' => $PProducto_dos,
      'PProductotres' => $PProducto_tres
    );

    return $array; 
    }

    //---------- 

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
 
  
$IdReporte = IdReporte($GET_idEstacion,$GET_year,$GET_mes,$con);


$sql_estaciones = "SELECT producto_uno, producto_dos, producto_tres FROM tb_estaciones WHERE id = '".$GET_idEstacion."' ";
$result_estaciones = mysqli_query($con, $sql_estaciones);
$numero_estaciones = mysqli_num_rows($result_estaciones);
while($row_estaciones = mysqli_fetch_array($result_estaciones, MYSQLI_ASSOC)){
$ProductoUno  = $row_estaciones['producto_uno'];
$ProductoDos  = $row_estaciones['producto_dos'];
$ProductoTres = $row_estaciones['producto_tres'];
}

ControlVR($IdReporte,$GET_idEstacion,$GET_year,$GET_mes,$ProductoUno,$con);
ControlVR($IdReporte,$GET_idEstacion,$GET_year,$GET_mes,$ProductoDos,$con);

if ($ProductoTres != "") {
ControlVR($IdReporte,$GET_idEstacion,$GET_year,$GET_mes,$ProductoTres,$con);
}

 
function ControlVR($IdReporte,$GET_idEstacion,$GET_year,$GET_mes,$Producto,$con){

$volumen = 0;
$importetotal = 0;

$sql_reportecre = "SELECT id FROM re_reporte_cre_mes WHERE id_estacion = '".$GET_idEstacion."' and mes = '".$GET_mes."' and year = '".$GET_year."' ";
$result_reportecre = mysqli_query($con, $sql_reportecre);
$numero_reportecre = mysqli_num_rows($result_reportecre);
while($row_reportecre = mysqli_fetch_array($result_reportecre, MYSQLI_ASSOC)){
$idReporteCre = $row_reportecre['id'];
}


$sql_creproducto = "SELECT id, producto FROM re_reporte_cre_producto WHERE id_re_mes = '".$idReporteCre."' AND producto = '".$Producto."' ";
$result_creproducto = mysqli_query($con, $sql_creproducto);
$numero_creproducto = mysqli_num_rows($result_creproducto);
while($row_creproducto = mysqli_fetch_array($result_creproducto, MYSQLI_ASSOC)){
$ID = $row_creproducto['id'];
$sql_pipas = "SELECT volumen, importe_total, precio_litro FROM re_reporte_cre_pipas WHERE id_re_producto  = '".$ID."' ";
$result_pipas = mysqli_query($con, $sql_pipas);
$numero_pipas = mysqli_num_rows($result_pipas);
while($row_pipas = mysqli_fetch_array($result_pipas, MYSQLI_ASSOC)){

$ImportePesos = $row_pipas['volumen'] * $row_pipas['precio_litro'];

$volumen = $volumen + $row_pipas['volumen'];
//$importetotal = $importetotal + $row_pipas['importe_total'];
$importetotal = $importetotal + $ImportePesos;

}
}

$sql_corte = "SELECT id FROM op_corte_dia WHERE id_mes  = '".$IdReporte."' ";
$result_corte = mysqli_query($con, $sql_corte);
$numero_corte = mysqli_num_rows($result_corte);
while($row_corte = mysqli_fetch_array($result_corte, MYSQLI_ASSOC)){
$idCorte = $row_corte['id'];
$sql_cortedia = "SELECT litros, precio_litro FROM op_ventas_dia WHERE idreporte_dia  = '".$idCorte."' AND producto = '".$Producto."' ";
$result_cortedia = mysqli_query($con, $sql_cortedia);
$numero_cortedia = mysqli_num_rows($result_cortedia);
while($row_cortedia = mysqli_fetch_array($result_cortedia, MYSQLI_ASSOC)){
$litrosV = $row_cortedia['litros'];
$preciolitroV = $row_cortedia['precio_litro'];
$total = $litrosV * $preciolitroV;

$totalLitros = $totalLitros + $litrosV;
$Grantotal = $Grantotal + $total;
}
}


$sql_listadia = "SELECT 
op_corte_year.id_estacion,
op_corte_year.year,
op_corte_mes.mes,
op_corte_dia.id AS idDia,
op_corte_dia.fecha
FROM op_corte_year
INNER JOIN op_corte_mes ON op_corte_year.id = op_corte_mes.id_year
INNER JOIN op_corte_dia ON op_corte_mes.id = op_corte_dia.id_mes 
WHERE op_corte_year.id_estacion = '".$GET_idEstacion."' AND 
op_corte_year.year = '".$GET_year."' AND 
op_corte_mes.mes = '".$GET_mes."'";
$result_listadia = mysqli_query($con, $sql_listadia);
$numero_listadia = mysqli_num_rows($result_listadia);

while($row_listadia = mysqli_fetch_array($result_listadia, MYSQLI_ASSOC)){
    $idDias = $row_listadia['idDia'];
    $fecha = $row_listadia['fecha'];  

    $TotalAtio = TotalAtio($idDias,$con); 

    $GTLProductouno = $GTLProductouno + $TotalAtio['LProductouno'];
    $GTLProductodos = $GTLProductodos + $TotalAtio['LProductodos'];
    $GTLProductotres = $GTLProductotres + $TotalAtio['LProductotres'];

    $GTPProductouno = $GTPProductouno + $TotalAtio['PProductouno'];
    $GTPProductodos = $GTPProductodos + $TotalAtio['PProductodos'];
    $GTPProductotres = $GTPProductotres + $TotalAtio['PProductotres'];
}


if($Producto == "G SUPER"){
$dato12TB = $GTLProductouno;
$dato14TB = $GTPProductouno;

}else if($Producto == "G PREMIUM"){
$dato12TB = $GTLProductodos;
$dato14TB = $GTPProductodos;

}else if($Producto == "G DIESEL"){
$dato12TB = $GTLProductotres;
$dato14TB = $GTPProductotres;
}


$sql_lista = "SELECT * FROM op_control_volumetrico_resumen WHERE id_mes = '".$IdReporte."' AND producto = '".$Producto."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
if ($numero_lista > 0) {

  $sql_edit1 = "UPDATE op_control_volumetrico_resumen 
  SET dato4 = '".$volumen."', 
  dato6 = '".$importetotal."', 
  dato8 = '".$totalLitros."', 
  dato10 = '".$Grantotal."' ,
  dato12 = '".$dato12TB."' ,
  dato14 = '".$dato14TB."' 

  WHERE id_mes = '".$IdReporte."' AND producto = '".$Producto."' ";
  mysqli_query($con, $sql_edit1);

}else{

$sql_insert = "INSERT INTO op_control_volumetrico_resumen (
    id_mes,
    producto,
    dato1,
    dato2,
    dato3,
    dato4,
    dato5,
    dato6,
    dato7,
    dato8,
    dato9,
    dato10,
    dato11,
    dato12,
    dato13,
    dato14,
    comentario
    )
    VALUES 
    (
    '".$IdReporte."',
    '".$Producto."',
    '',
    '',
    '',
    '".$volumen."',
    '',
    '".$importetotal."',
    '',
    '".$totalLitros."',
    '',
    '".$Grantotal."',
    '',
    '".$dato12TB."',
    '',
    '".$dato14TB."',
    ''   
    )";


  mysqli_query($con, $sql_insert);

}
}

Prefijos($IdReporte,$GET_idEstacion,$con);

function Prefijos($IdReporte,$idEstacion,$con){

if($idEstacion == 1){
ValidaPrefijo($IdReporte,'PG','PUBLICO EN GENERAL',$con);
ValidaPrefijo($IdReporte,'T','TPV',$con);
ValidaPrefijo($IdReporte,'FEVM','WEB',$con);
ValidaPrefijo($IdReporte,'CC','CLIENTES DE CREDITO',$con);
ValidaPrefijo($IdReporte,'CD','CLIENTES DE DEBITO',$con);
ValidaPrefijo($IdReporte,'CA','CLIENTES ANTICIPO',$con);
ValidaPrefijo($IdReporte,'VM','VENTA MOSTRADOR',$con);
ValidaPrefijo($IdReporte,'EDI','MONEDEROS',$con);
ValidaPrefijo($IdReporte,'FA','FACTURA DE ACEITES',$con);
ValidaPrefijo($IdReporte,'RL','RENTAS',$con);
ValidaPrefijo($IdReporte,'S','SODEXO',$con);
ValidaPrefijo($IdReporte,'K','Notas de credito',$con);
ValidaPrefijo($IdReporte,'CP','Complemento de pago',$con);
PrefijoFinalizar($IdReporte,$con);
 
}else if($idEstacion == 2){
ValidaPrefijo($IdReporte,'PG','PUBLICO EN GENERAL',$con);
ValidaPrefijo($IdReporte,'T','TPV',$con);
ValidaPrefijo($IdReporte,'FEVM','WEB',$con);
ValidaPrefijo($IdReporte,'CC','CLIENTES DE CREDITO',$con);
ValidaPrefijo($IdReporte,'CD','CLIENTES DE DEBITO',$con);
ValidaPrefijo($IdReporte,'CA','CLIENTES ANTICIPO',$con);
ValidaPrefijo($IdReporte,'VM','VENTA MOSTRADOR',$con);
ValidaPrefijo($IdReporte,'EDI','MONEDEROS',$con);
ValidaPrefijo($IdReporte,'FA','FACTURA DE ACEITES',$con);
ValidaPrefijo($IdReporte,'AL','AUTOLAVADO',$con);
ValidaPrefijo($IdReporte,'VA','VENTA MOSTRADOR AUTOLAVADO',$con);
ValidaPrefijo($IdReporte,'RL','RENTAS',$con);
ValidaPrefijo($IdReporte,'S','SODEXO',$con);
ValidaPrefijo($IdReporte,'K','Notas de credito',$con);
ValidaPrefijo($IdReporte,'CP','Complemento de pago',$con);
PrefijoFinalizar($IdReporte,$con);

}else if($idEstacion == 3){

ValidaPrefijo($IdReporte,'PG','PUBLICO EN GENERAL',$con);
ValidaPrefijo($IdReporte,'T','TPV',$con);
ValidaPrefijo($IdReporte,'FEVM','WEB',$con);
ValidaPrefijo($IdReporte,'CC','CLIENTES DE CREDITO',$con);
ValidaPrefijo($IdReporte,'CD','CLIENTES DE DEBITO',$con);
ValidaPrefijo($IdReporte,'CA','CLIENTES ANTICIPO',$con);
ValidaPrefijo($IdReporte,'VM','VENTA MOSTRADOR',$con);
ValidaPrefijo($IdReporte,'EDI','MONEDEROS',$con);
ValidaPrefijo($IdReporte,'FA','FACTURA DE ACEITES',$con);
ValidaPrefijo($IdReporte,'RL','RENTAS',$con);
ValidaPrefijo($IdReporte,'S','SODEXO',$con);
ValidaPrefijo($IdReporte,'K','Notas de credito',$con);
ValidaPrefijo($IdReporte,'CP','Complemento de pago',$con);
PrefijoFinalizar($IdReporte,$con);

}else if($idEstacion == 4){

ValidaPrefijo($IdReporte,'PG','PUBLICO EN GENERAL',$con);
ValidaPrefijo($IdReporte,'T','TPV',$con);
ValidaPrefijo($IdReporte,'FEVM','WEB',$con);
ValidaPrefijo($IdReporte,'CC','CLIENTES DE CREDITO',$con);
ValidaPrefijo($IdReporte,'CD','CLIENTES DE DEBITO',$con);
ValidaPrefijo($IdReporte,'CA','CLIENTES ANTICIPO',$con);
ValidaPrefijo($IdReporte,'VM','VENTA MOSTRADOR',$con);
ValidaPrefijo($IdReporte,'EDI','MONEDEROS',$con);
ValidaPrefijo($IdReporte,'FA','FACTURA DE ACEITES',$con);
ValidaPrefijo($IdReporte,'RL','RENTAS',$con);
ValidaPrefijo($IdReporte,'S','SODEXO',$con);
ValidaPrefijo($IdReporte,'K','Notas de credito',$con);
ValidaPrefijo($IdReporte,'CP','Complemento de pago',$con);
PrefijoFinalizar($IdReporte,$con);

}else if($idEstacion == 5){

ValidaPrefijo($IdReporte,'PG','PUBLICO EN GENERAL',$con);
ValidaPrefijo($IdReporte,'T','TPV',$con);
ValidaPrefijo($IdReporte,'FEVM','WEB',$con);
ValidaPrefijo($IdReporte,'CC','CLIENTES DE CREDITO',$con);
ValidaPrefijo($IdReporte,'CD','CLIENTES DE DEBITO',$con);
ValidaPrefijo($IdReporte,'CA','CLIENTES ANTICIPO',$con);
ValidaPrefijo($IdReporte,'VM','VENTA MOSTRADOR',$con);
ValidaPrefijo($IdReporte,'EDI','MONEDEROS',$con);
ValidaPrefijo($IdReporte,'FA','FACTURA DE ACEITES',$con);
ValidaPrefijo($IdReporte,'RL','RENTAS',$con);
ValidaPrefijo($IdReporte,'S','SODEXO',$con);
ValidaPrefijo($IdReporte,'K','Notas de credito',$con);
ValidaPrefijo($IdReporte,'CP','Complemento de pago',$con);
PrefijoFinalizar($IdReporte,$con);

}else if($idEstacion == 6){

ValidaPrefijo($IdReporte,'PG','PUBLICO EN GENERAL',$con);
ValidaPrefijo($IdReporte,'T','TPV',$con);
ValidaPrefijo($IdReporte,'FEVM','WEB',$con);
ValidaPrefijo($IdReporte,'CC','CLIENTES DE CREDITO',$con);
ValidaPrefijo($IdReporte,'CD','CLIENTES DE DEBITO',$con);
ValidaPrefijo($IdReporte,'CA','CLIENTES ANTICIPO',$con);
ValidaPrefijo($IdReporte,'VM','VENTA MOSTRADOR',$con);
ValidaPrefijo($IdReporte,'EDI','MONEDEROS',$con);
ValidaPrefijo($IdReporte,'FA','FACTURA DE ACEITES',$con);
ValidaPrefijo($IdReporte,'RL','RENTAS',$con);
ValidaPrefijo($IdReporte,'S','SODEXO',$con);
ValidaPrefijo($IdReporte,'K','Notas de credito',$con);
ValidaPrefijo($IdReporte,'CP','Complemento de pago',$con);
PrefijoFinalizar($IdReporte,$con);

}else if($idEstacion == 7){

ValidaPrefijo($IdReporte,'PG','PUBLICO EN GENERAL',$con);
ValidaPrefijo($IdReporte,'T','TPV',$con);
ValidaPrefijo($IdReporte,'FEVM','WEB',$con);
ValidaPrefijo($IdReporte,'VM','VENTA MOSTRADOR',$con);
ValidaPrefijo($IdReporte,'EDI','MONEDEROS',$con);
ValidaPrefijo($IdReporte,'FA','FACTURA DE ACEITES',$con);
ValidaPrefijo($IdReporte,'RL','RENTAS',$con);
ValidaPrefijo($IdReporte,'S','SODEXO',$con);
ValidaPrefijo($IdReporte,'K','Notas de credito',$con);
ValidaPrefijo($IdReporte,'CP','Complemento de pago',$con);
PrefijoFinalizar($IdReporte,$con);

}else if($idEstacion == 14){

ValidaPrefijo($IdReporte,'PG','PUBLICO EN GENERAL',$con);
ValidaPrefijo($IdReporte,'T','TPV',$con);
ValidaPrefijo($IdReporte,'FEVM','WEB',$con);
ValidaPrefijo($IdReporte,'CC','CLIENTES DE CREDITO',$con);
ValidaPrefijo($IdReporte,'CD','CLIENTES DE DEBITO',$con);
ValidaPrefijo($IdReporte,'CA','CLIENTES ANTICIPO',$con);
ValidaPrefijo($IdReporte,'VM','VENTA MOSTRADOR',$con);
ValidaPrefijo($IdReporte,'EDI','MONEDEROS',$con);
ValidaPrefijo($IdReporte,'FA','FACTURA DE ACEITES',$con);
ValidaPrefijo($IdReporte,'RL','RENTAS',$con);
ValidaPrefijo($IdReporte,'S','SODEXO',$con);
ValidaPrefijo($IdReporte,'K','Notas de credito',$con);
ValidaPrefijo($IdReporte,'CP','Complemento de pago',$con);
PrefijoFinalizar($IdReporte,$con);
}

}

 
function ValidaPrefijo($IdReporte,$Serie,$Detalle,$con){

$sql = "SELECT * FROM op_control_volumetrico_prefijos_finalizar WHERE id_mes = '".$IdReporte."' AND estado = 1  ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if ($numero == 0) {


$sql_lista = "SELECT * FROM op_control_volumetrico_prefijos WHERE id_mes = '".$IdReporte."' AND serie = '".$Serie."' AND descripcion = '".$Detalle."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
if ($numero_lista == 0) {

$sql_insert = "INSERT INTO op_control_volumetrico_prefijos (
    id_mes,  
    serie, 
    descripcion, 
    total
    )
    VALUES 
    (
    '".$IdReporte."',
    '".$Serie."',
    '".$Detalle."',
    0     
    )";


 mysqli_query($con, $sql_insert);

}
}
}

function PrefijoFinalizar($IdReporte,$con){

$sql_lista = "SELECT * FROM op_control_volumetrico_prefijos_finalizar WHERE id_mes = '".$IdReporte."' AND estado = 1  ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
if ($numero_lista == 0) {

    $sql_insert = "INSERT INTO op_control_volumetrico_prefijos_finalizar (
    id_mes,  
    estado
    )
    VALUES 
    (
    '".$IdReporte."',
    1
    )";


 mysqli_query($con, $sql_insert);

}

}

ResumenAceite($IdReporte,$con);
function ResumenAceite($IdReporte,$con){

$sql_lista = "SELECT * FROM op_control_volumetrico_resumen_aceites WHERE id_mes = '".$IdReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
if ($numero_lista == 0) {

    $sql_insert = "INSERT INTO op_control_volumetrico_resumen_aceites (
    id_mes,  
    volumetrico
    )
    VALUES 
    (
    '".$IdReporte."',
    0
    )";


 mysqli_query($con, $sql_insert);

}

} 

//-------------------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------------------

function IdReporteYear($Session_IDEstacion,$GET_year,$con){
   $sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '".$Session_IDEstacion."' AND year = '".$GET_year."' ";
   $result_year = mysqli_query($con, $sql_year);
   while($row_year = mysqli_fetch_array($result_year, MYSQLI_ASSOC)){
   $idyear = $row_year['id'];
   }
   return $idyear;
   }

$IdReporteYear = IdReporteYear($GET_idEstacion,$GET_year,$con);

$sqlE = "SELECT producto_tres FROM tb_estaciones WHERE id = '".$GET_idEstacion."' ";
$resultE = mysqli_query($con, $sqlE);
$numeroE = mysqli_num_rows($resultE);
while($row = mysqli_fetch_array($resultE, MYSQLI_ASSOC)){
$GDiesel = $row['producto_tres'];
}


ValidaIF($IdReporte,'G SUPER',1,$con);
ValidaIF($IdReporte,'G PREMIUM',1,$con);

if($GDiesel != ""){
ValidaIF($IdReporte,'G DIESEL',1,$con);
}

ValidaIF($IdReporte,'Aceites y Lubricantes',1,$con);
ValidaIF($IdReporte,'IEPS',1,$con);

ValidaIF($IdReporte,'Público en General',2,$con);
ValidaIF($IdReporte,'Clientes crédito',2,$con);
ValidaIF($IdReporte,'Monederos electronicos',2,$con);
ValidaIF($IdReporte,'Facturas aceites y lubricantes',2,$con);
ValidaIF($IdReporte,'Clientes débito',2,$con);
ValidaIF($IdReporte,'Ventas mostrador',2,$con);
ValidaIF($IdReporte,'TPV',2,$con);
ValidaIF($IdReporte,'Página WEB',2,$con);
ValidaIF($IdReporte,'Clientes débito',2,$con);


function ValidaIF($IdReporte,$detalle,$posicion,$con){

$sql = "SELECT * FROM op_ingresos_facturacion_contabilidad WHERE id_year = '".$IdReporte."' AND detalle = '".$detalle."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if ($numero == 0) {

$sql_insert = "INSERT INTO op_ingresos_facturacion_contabilidad  (
    id_year,
    detalle,
    posicion,
    enero,
    febrero,
    marzo,
    abril,
    mayo,
    junio,
    julio,
    agosto,
    septiembre,
    octubre,
    noviembre,
    diciembre
    )
    VALUES 
    (
    '".$IdReporte."',
    '".$detalle."',
    '".$posicion."',
    0,0,0,0,0,0,0,0,0,0,0,0  
    )";

 mysqli_query($con, $sql_insert);

}
}
//-------------------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------------------
?>
<html lang="es">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Dirección de operaciones</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <link rel="shortcut icon" href="<?=RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="apple-touch-icon" href="<?=RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="stylesheet" href="<?=RUTA_CSS2 ?>alertify.css">
  <link rel="stylesheet" href="<?=RUTA_CSS2 ?>themes/default.rtl.css">
  <link href="<?=RUTA_CSS2;?>bootstrap.min.css" rel="stylesheet" />
  <link href="<?=RUTA_CSS2;?>navbar-general.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");

  ListaControl(<?=$IdReporte;?>);
  ListaResumen(<?=$IdReporte;?>,<?=$GET_mes;?>);
  ListaResumenTotal(<?=$IdReporte;?>,<?=$GET_mes;?>);
  ListaPrefijos(<?=$GET_idEstacion;?>,<?=$IdReporteYear;?>,<?=$GET_mes;?>,<?=$IdReporte;?>);
  PrefijoTotal(<?=$GET_idEstacion;?>,<?=$IdReporte;?>);
  GranTotal(<?=$GET_idEstacion;?>,<?=$IdReporte;?>);

  Comentarios(<?=$GET_idEstacion;?>,<?=$IdReporte;?>);

  });
 
  function Regresar(){ 
   window.history.back();
  }

  function ListaDirectorio(){
  $('#ListaDirectorio').load('../../../../public/admin/vistas/lista-directorio.php');
  }

  function ListaControl(IdReporte){

    $('#ListaControl').load('../../../../public/admin/vistas/lista-control-volumetrico.php?IdReporte=' + IdReporte); 
  }  

  function ListaResumen(IdReporte,mes){ 
  $('#ListaResumen').load('../../../../public/admin/vistas/lista-control-volumetrico-resumen.php?IdReporte=' + IdReporte + '&Mes=' + mes);
  }   

  function ListaResumenTotal(IdReporte,mes){
  $('#ListaResumenTotal').load('../../../../public/admin/vistas/total-control-volumetrico-resumen.php?IdReporte=' + IdReporte + '&Mes=' + mes);
  }   

  function ListaPrefijos(idEstacion,IdReporteYear,GET_mes,IdReporte){
    $('#ListaPrefijo').load('../../../../public/admin/vistas/lista-control-volumetrico-prefijo.php?IdReporte=' + IdReporte  + '&IdReporteYear=' + IdReporteYear +'&GET_mes=' + GET_mes + '&idEstacion=' + idEstacion);
  }  
 
  function PrefijoTotal(idEstacion,IdReporte){

  $('#PrefijoTotal').load('../../../../public/admin/vistas/control-volumetrico-total-prefijo.php?IdReporte=' + IdReporte + '&idEstacion=' + idEstacion);

  }

  function GranTotal(idEstacion,IdReporte){
  $('#GranTotal').load('../../../../public/admin/vistas/control-volumetrico-gran-total.php?IdReporte=' + IdReporte + '&idEstacion=' + idEstacion);  
  }
  
function btnModal(){
  $('#Modal').modal('show');
  }

  function Guardar(IdReporte){

    var NombreDocumento = $('#NombreDocumento').val();
    var Documento = $('#Documento').val();

    var Fecha = $('#Fecha').val();
    var Anexos = $('#Anexos').val();

    var data = new FormData();
    var url = '../../../../public/admin/modelo/agregar-control-volumetrico.php';

    Documento = document.getElementById("Documento");
    Documento_file = Documento.files[0];
    Documento_filePath = Documento.value;

    if (Documento_filePath != "") {
    $('#Documento').css('border','');

    data.append('IdReporte', IdReporte);
    data.append('Documento_file', Documento_file);
    data.append('Fecha', Fecha);
    data.append('Anexos', Anexos);

    $(".LoaderPage").show();

    $.ajax({
    url: url,
    type: 'POST',
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(data){

      $(".LoaderPage").hide();

    alertify.success('Registro agregado exitosamente.');
    ListaControl(IdReporte);
    $('#Documento').css('border','');
    $('#Documento').val('');
    $('#Modal').modal('hide');

    });

    }else{
    $('#Documento').css('border','2px solid #A52525');
    }
    
  }

  function Eliminar(idReporte,id){

    var parametros = {
  "idReporte" : idReporte,
    "id" : id
    };

       $.ajax({
     data:  parametros,
     url:   '../../../../public/admin/modelo/eliminar-control-volumetrico.php',
     type:  'post',
     beforeSend: function() {
    $(".LoaderPage").show();
     },
     complete: function(){
    
     },
     success:  function (response) {

    if (response == 1) {

    $(".LoaderPage").hide();
   
   alertify.success('Registro eliminado exitosamente.');
    ListaControl(idReporte);

    }else{
    alertify.error('Error al eliminar')
    $(".LoaderPage").hide();

    }

     }
     });

  }

  function Comentario(id){
  var Comentario = $('#Comentario' + id).val();

  var parametros = {
    "id" : id,
    "Comentario" : Comentario
    };

      $.ajax({
     data:  parametros,
     url:   '../../../../public/admin/modelo/agregar-comentario-control-volumetrico.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){
    
     },
     success:  function (response) {

    if (response == 1) {
    alertify.success('Registro agregado exitosamente.');
    }else{
    alertify.error('Error al eliminar')
   
    }

     }
     });
  
  }

  function Edit(dato,dif,id,total,IdReporte,mes){

  var input = $('#' + dato + id).val();

  if (dato == 1){
  var Diferencia = input - total;
  }else if(dato == 2){
  var Diferencia = total - input;
  }else{
  var Diferencia = input - total; 
  }

  var parametros = {
  "dato" : dato,
  "id" : id,
  "input" : input
  };
   
     $.ajax({
     data:  parametros,
     url:   '../../../../public/admin/modelo/editar-comentario-control-volumetrico.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){
    
     },
     success:  function (response) {

    if (response == 1) {

    $('#D' + dif + id).text(Diferencia);

    if(dato == 3){
    
    var inputRC = document.getElementById('RC' + id);
    var valorCelda = inputRC.textContent.replace(/,/g, '');

    var numeroEntero = parseFloat(valorCelda);
    //alert(numeroEntero)

    var valParametro = ((input * 100) / numeroEntero) - 100;


    if(valParametro == "inf" || valParametro == "INF" || valParametro == "nan" || valParametro == "NaN" || valParametro == "Infinity"){
    var valParametro2 = 0;
    $('#D8' + id).text(valParametro2.toFixed(2));  
    ListaResumenTotal(IdReporte,mes);

    }else{

    $('#D8' + id).text(valParametro.toFixed(2)); 
    ListaResumenTotal(IdReporte,mes);

    }


    }else{

      ListaResumenTotal(IdReporte,mes); 
    }


   
    
    }else{
    alertify.error('Error al eliminar')
   
    }

     }
     });

  }

function EditPrefijo(id,IdReporte,IdReporteYear,GET_mes,idEstacion){

var Total = $('#Total' + id).val();

var parametros = {
    "Total" : Total,
    "IdReporteYear" : IdReporteYear,
    "GET_mes" : GET_mes,
    "id" : id
    };

       $.ajax({
     data:  parametros,
     url:   '../../../../public/admin/modelo/editar-prefijo-control-volumetrico.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){
    
     },
     success:  function (response) {

    if (response == 1) {

   PrefijoTotal(idEstacion,IdReporte);
   GranTotal(idEstacion,IdReporte);

    }else{
    alertify.error('Error al guardar')
   
    }

     }
     });

}

function EditAceites(val,IdReporte,GET_mes){

Total = val.value;

var parametros = {
    "Total" : Total,
    "IdReporte" : IdReporte
    };

       $.ajax({
     data:  parametros,
     url:   '../../../../public/admin/modelo/editar-control-volumetrico-aceite.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){
    
     },
     success:  function (response) {

    if (response == 1) {



    }else{
    alertify.error('Error al guardar')
   
    }

     }
     }); 

}
 
function Comentarios(idEstacion,IdReporte){
  $('#Comentarios').load('../../../../public/admin/vistas/control-volumetrico-comentarios.php?IdReporte=' + IdReporte + '&idEstacion=' + idEstacion);  
} 

function GuardarComentario(idReporte,idEstacion){

  var Comentario = $('#Comentario').val();

  var parametros = {
    "idReporte" : idReporte,
    "Comentario" : Comentario
    };

    if(Comentario != ""){
    $('#Comentario').css('border',''); 

    $.ajax({
    data:  parametros,
    url:   '../../../../public/admin/modelo/agregar-comentario-volumetrico.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){
    },
    success:  function (response) {

    if (response == 1) {
    $('#Comentario').val('');
    alertify.success('Registro agregado exitosamente.');
    Comentarios(idEstacion,idReporte);

    }else{
     alertify.error('Error al eliminar la solicitud');  
    }

    }
    });

    }else{
    $('#Comentario').css('border','2px solid #A52525'); 
    }

    }

  </script>
  </head>
  
  <body>
    
  <div class="LoaderPage"></div>

    <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
  <?php include_once "public/navbar/navbar-perfil.php";?>
  <!---------- CONTENIDO PAGINA WEB----------> 
  <div class="contendAG">
  <div class="row">

  <div class="col-12 mb-3">
  <div class="cardAG">
  <div class="border-0 p-3">

    <div class="row">

    <div class="col-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()"> 
    <div class="row">

     <div class="col-12">

    <h5>Control volumétrico, <?=nombremes($GET_mes);?> <?=$GET_year;?></h5>

    </div>

    </div>

    </div>

    </div>

  <hr> 

<div class="row">
 
<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">

<div id="ListaResumen"></div>
<div id="ListaResumenTotal"></div>

</div>


<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">

<div id="ListaControl"></div>
<div id="ListaPrefijo"></div>
<div id="PrefijoTotal"></div>


<div class="border">
<div class="p-3">

<div id="Comentarios"></div>

</div>
</div>

</div>


<div class="col-12 mt-3">
<div id="GranTotal" class="tables-bg"></div>
</div>

</div>
  

  </div>
  </div>
  </div>

  </div>
  </div>

  </div>

  


<div class="modal" id="Modal">
  <div class="modal-dialog" style="margin-top: 83px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar anexos</h5>
       
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>
      <div class="modal-body">
        
        <div class="mb-1 text-secondary">Agregar fecha</div>
        <input type="date" class="form-control" id="Fecha">

        <div class="mb-1 mt-2 text-secondary">Agregar anexo</div>
        <select class="form-control" id="Anexos"> 
          <option></option>
          <option>Tirilla de inventarios</option>
          <option>Control de despachos</option>
          <option>Control volumétrico</option>
          <option>Acuse de recepción controles volumétricos</option>
          <option>Acuse de aceptación controles volumétricos</option>
          <option>Jarreo</option>
        </select>

        <div class="mb-1 mt-2 text-secondary">Agregar documento</div>
        <input class="form-control" type="file" id="Documento">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Guardar(<?=$IdReporte;?>)">Guardar</button>
      </div>
    </div>
  </div>
</div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>
  
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>

