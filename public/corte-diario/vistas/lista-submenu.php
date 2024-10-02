<?php
require ('../../../app/help.php');

$elemento = $_GET["elemento"];

$sql_menu = "SELECT tb_submenu_puestos.id_submenu_puestos, 
           tb_menu_do.elemento_menu_do, 
           tb_submenu_do.elemento_submenu_do, 
           tb_submenu_do.ruta_submenu_do, 
           tb_submenu_do.imagen, 
           tb_submenu_puestos.id_puesto 
    FROM tb_submenu_puestos 
    INNER JOIN tb_submenu_do ON tb_submenu_puestos.id_submenu_do = tb_submenu_do.id_submenu_do 
    INNER JOIN tb_puestos ON tb_submenu_puestos.id_puesto = tb_puestos.id 
    INNER JOIN tb_menu_do ON tb_submenu_do.id_menu_do = tb_menu_do.id_menu_do 
    WHERE tb_submenu_puestos.id_puesto = '" . $session_idpuesto . "' 
      AND tb_menu_do.elemento_menu_do LIKE '%$elemento%' 
    ORDER BY tb_submenu_puestos.id_submenu_do ASC";

$result_menu = mysqli_query($con, $sql_menu);

?>
<div class="row">
  <?php

  $num = 1;
  while ($row_menu = mysqli_fetch_array($result_menu, MYSQLI_ASSOC)) {
    $elemento_submenu_do = $row_menu['elemento_submenu_do'];
    $ruta_submenu_do = $row_menu['ruta_submenu_do'];
    $imagen = $row_menu['imagen'];

    if ($elemento == "Importacion") {
      ?>

      <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2" onclick="rutaSubMenuDO('<?= $ruta_submenu_do; ?>')">
        <section class="card3 plan2 shadow-lg">
          <div class="inner2">

            <div class="product-image"><img src="<?= RUTA_IMG_ICONOS; ?><?= $imagen; ?>" draggable="false" /></div>

            <div class="product-info">
              <h2><?= $elemento_submenu_do; ?></h2>
            </div>

          </div>
        </section>
      </div>



      <?php
    } else if ($elemento == "Comercializadora") {
      ?>

        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-1">
          <article class="plan card2 border-0 shadow position-relative" onclick="rutaSubMenuDO('<?= $ruta_submenu_do; ?>')">

            <div class="inner">
              <div class="row">
                <div class="col-2"> <span class="pricing"><?= $imagen; ?></span> </div>
                <div class="col-10">
                  <h5 class="text-white text-center"><?= $elemento_submenu_do; ?></h5>
                </div>
              </div>

            </div>
          </article>
        </div>

      <?php
    } else {
      ?>



        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-1">
          <article class="plan card2 border-0 shadow position-relative" onclick="rutaSubMenuDO('<?= $ruta_submenu_do; ?>')">

            <div class="inner">
              <div class="row">
                <div class="col-2"> <span class="pricing"><i class="fa-solid fa-<?= $num ?>"></i></span> </div>
                <div class="col-10">
                  <h5 class="text-white text-center"><?= $elemento_submenu_do; ?></h5>
                </div>
              </div>

            </div>
          </article>
        </div>

      <?php
    }


    $num++;
  }
  ?>
</div>