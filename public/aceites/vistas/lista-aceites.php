<?php
require('../../../app/help.php');

?>


<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.go(-1)"  class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Corporativo</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase"> Aceites </li>
</ol>
</div>
 
<div class="row"> 
<div class="col-6"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Aceites</h3> </div>

<div class="col-6"> 

<button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="NewAceite()">
<span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>

</div>

</div>
<hr>
</div>


<div class="table-responsive">
<table id="tabla_bitacora" class="custom-table" style="font-size: .9em;" width="100%">

<thead class="tables-bg">
	<th class="text-center align-middle">ID</th>
	<th class="align-middle">CONCEPTO</th>
    <th class="text-center align-middle">PZAS CAJAS</th>
	<th class="text-center align-middle">PRECIO UNITARIO</th>
</thead>
<tbody>
	<?php

	$sql_listaaceite = "SELECT * FROM op_aceites ORDER BY id_aceite ASC";
    $result_listaaceite = mysqli_query($con, $sql_listaaceite);
    while($row_listaaceite = mysqli_fetch_array($result_listaaceite, MYSQLI_ASSOC)){

    $idAceite = $row_listaaceite['id'];
    $noAceite = $row_listaaceite['id_aceite'];
    $concepto = $row_listaaceite['concepto'];
    $precio = $row_listaaceite['precio'];
    $piezas = $row_listaaceite['piezas'];
    ?>
    <tr>
    	<td class="p-0 align-middle" width="80px">
    		<input id="noAceite-<?=$idAceite;?>" type="number" min="0" style="border: 0px;width: 100%;padding: 10px;height: 100%; text-align: center;" onkeyup="EditNoAceite(this,<?=$idAceite;?>)" value="<?=$noAceite;?>" placeholder="ID">
    	</td>        
    	<td class="p-0 align-middle">
    		<input id="concepto-<?=$idAceite;?>" type="text" min="0" style="border: 0px;width: 100%;padding: 10px;height: 100%; text-align: left;" onkeyup="EditConcepto(this,<?=$idAceite;?>)" value="<?=$concepto;?>" placeholder="CONCEPTO">
    	</td>
        <td class="p-0 align-middle" width="80px">
            <input id="noAceite-<?=$idAceite;?>" type="number" min="0" style="border: 0px;width: 100%;padding: 10px;height: 100%; text-align: center;" onkeyup="EditPiezas(this,<?=$idAceite;?>)" value="<?=$piezas;?>" placeholder="PIEZAS">
        </td>
    	<td class="p-0 align-middle" width="150px">
    		<input id="precio-<?=$idAceite;?>" type="text" min="0" style="border: 0px;width: 100%;padding: 10px;height: 100%; text-align: right;" onkeyup="EditPrecio(this,<?=$idAceite;?>)" value="<?=number_format($precio,2);?>" placeholder="PRECIO UNITARIO">
    	</td>
    </tr>

    <?php
	}

    ?>
</tbody>
</table>
</div>

