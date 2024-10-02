<?php
require('../../../../app/help.php');

$sql_menu = "SELECT tb_menu_puestos_do.id_menu_do, 
tb_menu_do.elemento_menu_do, 
tb_menu_do.ruta_menu_do, 
tb_menu_do.icono, 
tb_menu_puestos_do.id_puesto 
FROM tb_menu_puestos_do 
INNER JOIN tb_menu_do ON tb_menu_puestos_do.id_menu_do = tb_menu_do.id_menu_do 
INNER JOIN tb_puestos on tb_menu_puestos_do.id_puesto = tb_puestos.id 
WHERE tb_menu_puestos_do.id_puesto = '".$session_idpuesto."' ORDER BY tb_menu_puestos_do.id_menu_do ASC"; 

$result_menu = mysqli_query($con, $sql_menu );
$numero_menu  = mysqli_num_rows($result_menu);

?>  

<div class="row">

<?php
$num = 1;
while($row_menu = mysqli_fetch_array($result_menu, MYSQLI_ASSOC)){
$elemento_menu_do = $row_menu['elemento_menu_do'];
$ruta_menu_do = $row_menu['ruta_menu_do'];
$icono = $row_menu['icono'];
?>
 

 <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
 <article class="plan card2 border-0 shadow position-relative" onclick="rutaMenuDO('<?=$ruta_menu_do;?>')">
        
 <div class="inner">
 <div class="row">
 <div class="col-2"> <span class="pricing"><i class="fa-solid fa-<?=$num?>"></i></span> </div>
 <div class="col-10"><h5 class="text-white text-center"><?=$elemento_menu_do;?></h5></div>
 </div>

 </div>
 </article>
 </div>

 
<?php
$num++;
}

if($session_nompuesto == "Sistemas" || $session_nompuesto == "Gestoria" || $session_nompuesto == "Mantenimiento" || $session_nompuesto == "Departamento Jurídico"){ ?>

 <!----- RECIBOS DE NOMINA----->
 <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
 <article class="plan card2 border-0 shadow position-relative" onclick="ReciboNominaV2()">
        
 <div class="inner">
 <div class="row">
 <div class="col-2"> <span class="pricing">  <i class="fa-solid fa-file-invoice"></i></span> </div>
 <div class="col-10"><h5 class="text-white text-center">Recibos de nomina</h5></div>
 </div>

 </div>
 </article>
 </div>

  <?php } ?>

  <?php if($session_nompuesto == "Mantenimiento"){ ?>
 
 <!----- ALMACEN ----->
 <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
 <article class="plan card2 border-0 shadow position-relative" onclick="Almacen()">
        
 <div class="inner">
 <div class="row">
 <div class="col-2"> <span class="pricing">  <i class="fa-solid fa-store"></i></span> </div>
 <div class="col-10"><h5 class="text-white text-center">Almacen</h5></div>
 </div>

 </div>
 </article>
 </div>

  <?php } ?>

  <?php if($session_nompuesto == "Gestoria"){ ?>

 <!----- SOLICITUD DE CHEQUE ----->
 <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
 <article class="plan card2 border-0 shadow position-relative" onclick="SolicitudCheque()">
        
 <div class="inner">
 <div class="row">
 <div class="col-2"> <span class="pricing">  <i class="fa-solid fa-money-check-dollar"></i></span> </div>
 <div class="col-10"><h5 class="text-white text-center">Solicitud de cheques</h5></div>
 </div>

 </div>
 </article>
 </div>


 <!----- EMBARQUES ----->
 <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
 <article class="plan card2 border-0 shadow position-relative" onclick="Embarques()">
        
 <div class="inner">
 <div class="row">
 <div class="col-2"> <span class="pricing">  <i class="fa-solid fa-truck-ramp-box"></i></span> </div>
 <div class="col-10"><h5 class="text-white text-center">Embarques</h5></div>
 </div>

 </div>
 </article>
 </div>

 <!----- PAPELERIA ----->
 <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
 <article class="plan card2 border-0 shadow position-relative" onclick="Papeleria()">
        
 <div class="inner">
 <div class="row">
 <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-folder-plus"></i></span> </div>
 <div class="col-10"><h5 class="text-white text-center">Pedido de papeleria</h5></div>
 </div>

 </div>
 </article>
 </div>

  <?php } 
  if($session_nompuesto == "Gestoria"){ ?>

 <!----- SOLICITUD DE VALES ----->
 <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
 <article class="plan card2 border-0 shadow position-relative" onclick="SolicitudVales()">
        
 <div class="inner">
 <div class="row">
 <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-money-check"></i></span> </div>
 <div class="col-10"><h5 class="text-white text-center">Solicitud de vales</h5></div>
 </div>

 </div>
 </article>
 </div>

 <?php } 
 if($Session_IDUsuarioBD == 346){ ?>

 <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
 <article class="plan card2 border-0 shadow position-relative" onclick="AcuseRecepcionAuditor()">
        
 <div class="inner">
 <div class="row">
 <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-file"></i></span> </div>
 <div class="col-10"><h5 class="text-white text-center">Acuses de Recepcion</h5></div>
 </div>

 </div>
 </article>
 </div>

 
 <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
 <article class="plan card2 border-0 shadow position-relative" onclick="DescargaTuxpanAuditor()">
        
 <div class="inner">
 <div class="row">
 <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-truck-ramp-box"></i></span> </div>
 <div class="col-10"><h5 class="text-white text-center">Formato de descarga de merma</h5></div>
 </div>

 </div>
 </article>
 </div>

<?php } ?>

</div>