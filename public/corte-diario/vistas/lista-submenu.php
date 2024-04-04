<?php
require('../../../app/help.php');

$elemento = $_GET["elemento"];

$sql_menu = "SELECT tb_submenu_puestos.id_submenu_puestos, 
tb_menu_do.elemento_menu_do,
tb_submenu_do.elemento_submenu_do, 
tb_submenu_do.ruta_submenu_do, 
tb_submenu_do.imagen, 
tb_submenu_puestos.id_puesto 
FROM tb_submenu_puestos 
INNER JOIN tb_submenu_do ON tb_submenu_puestos.id_submenu_do = tb_submenu_do.id_submenu_do 
INNER JOIN tb_puestos on tb_submenu_puestos.id_puesto = tb_puestos.id 
INNER JOIN tb_menu_do on tb_submenu_do.id_menu_do = tb_menu_do.id_menu_do 
WHERE tb_submenu_puestos.id_puesto = '".$session_idpuesto."' AND tb_menu_do.elemento_menu_do = '".$elemento."' ORDER BY tb_submenu_puestos.id_submenu_do ASC;";

$result_menu = mysqli_query($con, $sql_menu );
$numero_menu  = mysqli_num_rows($result_menu);

?>  

<div class="row">

<?php

$num = 1;
while($row_menu = mysqli_fetch_array($result_menu, MYSQLI_ASSOC)){
$elemento_submenu_do = $row_menu['elemento_submenu_do'];
$ruta_submenu_do = $row_menu['ruta_submenu_do'];
$imagen = $row_menu['imagen'];

if($elemento == "Importación"){
?>
 
 
  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-1 mt-2">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer" onclick="rutaSubMenuDO('<?=$ruta_submenu_do;?>')">        
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5 class="text-secondary"><?=$elemento_submenu_do;?></h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?><?=$imagen;?>">   
  </div>
  </div>
  </div>
 

<?php
}else if($elemento == "Comercializadora"){
?>

<div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
<div class="card card-menuB rounded shadow-sm p-3 pointer" onclick="rutaSubMenuDO('<?=$ruta_submenu_do;?>')">
                  
<div class="d-flex justify-content-between">
<div class="d-flex flex-row align-items-center">
<div class="icon"> 
<?=$imagen;?>
</div>
<div class="m-details ms-2"> 
<h7><?=$elemento_submenu_do;?></h7> 
</div>

</div>
</div>

</div>
</div>


<?php
}else{
?>


<div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
<div class="card card-menuB rounded shadow-sm p-3 pointer" onclick="rutaSubMenuDO('<?=$ruta_submenu_do;?>')">
                  
<div class="d-flex justify-content-between">
<div class="d-flex flex-row align-items-center">
<div class="icon"> 

<i class="fa-solid fa-<?=$num?> color-CB"></i>
</div>
<div class="m-details ms-2"> 
<h7><?=$elemento_submenu_do;?></h7> 
</div>

</div>
</div>

</div>
</div>


<?php
}

$num++;
}
?>


 
</div>