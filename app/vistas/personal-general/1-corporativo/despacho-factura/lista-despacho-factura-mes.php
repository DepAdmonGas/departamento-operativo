<?php
require ('../../../../help.php');

$idEstacion = $_GET['idEstacion'];
$Year = $_GET['Year'];
$Mes = $_GET['Mes'];

$ProductoUno = $corteDiarioGeneral->getProducto($idEstacion,'producto_uno');
$ProductoDos = $corteDiarioGeneral->getProducto($idEstacion,'producto_dos');
$ProductoTres = $corteDiarioGeneral->getProducto($idEstacion,'producto_tres');


$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosEstacion($idEstacion);

if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo" ){
$ocultarTB = "";
$Estacion = '';

}else{
$ocultarTB = "d-none";
$Estacion = ' ('.$datosEstacion['nombre'].')';

}
?>


<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.go(-3)"  class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Corporativo</a></li>
<li class="breadcrumb-item"><a onclick="history.go(-2)"  class="text-uppercase text-primary pointer"> Despacho VS Factura</a></li>
<li class="breadcrumb-item"><a onclick="history.go(-1)"  class="text-uppercase text-primary pointer"> <?=$Year?></a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase"><?=$ClassHerramientasDptoOperativo->nombremes($Mes)?> </li>
</ol>
 
<div class="row"> 
<div class="col-12"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> 
Despacho VS Factura<?=$Estacion?>, <?=$ClassHerramientasDptoOperativo->nombremes($Mes)?> <?=$Year?></h3> 
</div>
</div>

<hr>
</div>


 
<div class="table-responsive">
<table class="custom-table " style="font-size: .8em;" width="100%">
 
        <thead>
            <tr >
                <th rowspan="2" class="text-center align-middle" style="background: #ffffff;"></th>
                <th rowspan="2" class="text-center text-dark align-middle" style="background: #ffffff;">Fecha</th>
                <th class="text-white text-center align-middle" style="background: #74bc1f;">Litros</th>
                <th class="text-white text-center align-middle" style="background: #74bc1f;">Pesos</th>
                <th class="text-white text-center align-middle" style="background: #e01883;">Litros</th>
                <th class="text-white text-center align-middle" style="background: #e01883;">Pesos</th>
                <th class="text-white text-center align-middle" style="background: #5c108c;">Litros</th>
                <th class="text-white text-center align-middle" style="background: #5c108c;">Pesos</th>
                <th class="text-dark text-start align-middle" style="background: #ffffff;" >Litros</th>
                <th class="text-dark text-end align-middle" style="background: #ffffff;">Pesos</th>
            </tr>
            <tr>
                <td class="text-white text-center fw-bold" style="background: #74bc1f;">G SUPER</td>
                <th class="text-white text-end text-center" style="background: #74bc1f;">G SUPER</th>
                <th class="text-white text-center" style="background: #e01883;">G PREMIUM</th>
                <th class="text-white text-end text-center" style="background: #e01883;">G PREMIUM</th>
                <th class="text-white text-center" style="background: #5c108c;">G DIESEL</th>
                <th class="text-white text-end text-center" style="background: #5c108c;">G DIESEL</th>
                <th class =" text-start text-dark" style="background: #ffffff;">TOTAL</th>
                <td class=" text-end text-dark fw-bold" style="background: #ffffff;">TOTAL</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_listadia = "
                SELECT 
                op_corte_year.id_estacion,
                op_corte_year.year,
                op_corte_mes.mes,
                op_corte_dia.id AS idDia,
                op_corte_dia.fecha
                FROM op_corte_year
                INNER JOIN op_corte_mes ON op_corte_year.id = op_corte_mes.id_year
                INNER JOIN op_corte_dia ON op_corte_mes.id = op_corte_dia.id_mes 
                WHERE op_corte_year.id_estacion = '" . $idEstacion . "' AND 
                op_corte_year.year = '" . $Year . "' AND 
                op_corte_mes.mes = '" . $Mes . "'";
            $result_listadia = mysqli_query($con, $sql_listadia);
            $numero_listadia = mysqli_num_rows($result_listadia);
            $GTProducto1 = 0;
            $GTProducto2 = 0;
            $GTProducto3 = 0;
            $GTotalLitros = 0;

            $GTPProducto1 = 0;
            $GTPProducto2 = 0;
            $GTPProducto3 = 0;
            $GTotalPrecio = 0;

            $GTLProductouno = 0;
            $GTLProductodos = 0;
            $GTLProductotres = 0;
            $GTotalALP = 0;
            $GTPProductouno = 0;
            $GTPProductodos = 0;
            $GTPProductotres = 0;
            $GTotalAPP = 0;

            $GTDiLPoUno = 0;
            $GTDiLPoDos = 0;
            $GTDiLPoTres = 0;
            $GTDiToLitros = 0;
            $GTDiPPoUno = 0;
            $GTDiPPoDos = 0;
            $GTDiPPoTres = 0;
            $GTDiToPesos = 0;

            while ($row_listadia = mysqli_fetch_array($result_listadia, MYSQLI_ASSOC)) {
                $idDias = $row_listadia['idDia'];
                $fecha = $row_listadia['fecha'];

                $corteDiarioGeneral->validaDia($idDias);

                $Producto1 = $corteDiarioGeneral->totalVentas($idDias, $ProductoUno);
                $Producto2 = $corteDiarioGeneral->totalVentas($idDias, $ProductoDos);
                $Producto3 = $corteDiarioGeneral->totalVentas($idDias, $ProductoTres);

                $TotalLitros = $Producto1['TotalLitros'] + $Producto2['TotalLitros'] + $Producto3['TotalLitros'];
                $TotalPrecio = $Producto1['TotalPrecio'] + $Producto2['TotalPrecio'] + $Producto3['TotalPrecio'];

                $TotalAtio = $corteDiarioGeneral->totalAtio($idDias);

                $TotalALP = $TotalAtio['LProductouno'] + $TotalAtio['LProductodos'] + $TotalAtio['LProductotres'];
                $TotalAPP = $TotalAtio['PProductouno'] + $TotalAtio['PProductodos'] + $TotalAtio['PProductotres'];

                $DiLPoUno = $Producto1['TotalLitros'] - $TotalAtio['LProductouno'];
                $DiLPoDos = $Producto2['TotalLitros'] - $TotalAtio['LProductodos'];
                $DiLPoTres = $Producto3['TotalLitros'] - $TotalAtio['LProductotres'];
                $DiToLitros = $TotalLitros - $TotalALP;


                $DiPPoUno = $Producto1['TotalPrecio'] - $TotalAtio['PProductouno'];
                $DiPPoDos = $Producto2['TotalPrecio'] - $TotalAtio['PProductodos'];
                $DiPPoTres = $Producto3['TotalPrecio'] - $TotalAtio['PProductotres'];
                $DiToPesos = $TotalPrecio - $TotalAPP;


                echo '<tr class="bg-white">
                
                        <th class="bg-primary fw-normal text-white">VENTAS</th>
                        <td class="text-center align-middle no-hover" rowspan="3">' . $ClassHerramientasDptoOperativo->FormatoFecha($fecha) . '</td>
                        <td class ="text-start" id="' . $idDias . 'L1">' . number_format($Producto1['TotalLitros'], 2) . '</td>
                        <td class ="text-start" id="' . $idDias . 'L4">$ ' . number_format($Producto1['TotalPrecio'], 2) . '</td>
                        <td class ="text-start" id="' . $idDias . 'L2">' . number_format($Producto2['TotalLitros'], 2) . '</td>
                        <td class ="text-start" id="' . $idDias . 'L5">$ ' . number_format($Producto2['TotalPrecio'], 2) . '</td>
                        <td class ="text-start" id="' . $idDias . 'L3">' . number_format($Producto3['TotalLitros'], 2) . '</td>
                        <td class ="text-start" id="' . $idDias . 'L6">$ ' . number_format($Producto3['TotalPrecio'], 2) . '</td>
                        <td class="fw-bold text-start">' . number_format($TotalLitros, 2) . '</td>
                        <td class="fw-bold text-end">$ ' . number_format($TotalPrecio, 2) . '</td>
                        </tr>
                        <tr tr class = "bg-white">
                        <th class="bg-info fw-normal text-white">DESPACHO</th>
                        <td class="p-0"><input type="number" class="border-0 p-2" value="' . $TotalAtio['LProductouno'] . '" style="width: 100%;" onkeyup="Editar(this,' . $idDias . ',1)"></td>
                        <td class="p-0"><input type="number" class="border-0 p-2" value="' . $TotalAtio['PProductouno'] . '" style="width: 100%;" onkeyup="Editar(this,' . $idDias . ',4)"></td>

                        <td class="p-0"><input type="number" class="border-0 p-2" value="' . $TotalAtio['LProductodos'] . '" style="width: 100%;" onkeyup="Editar(this,' . $idDias . ',2)"></td>
                        <td class="p-0"><input type="number" class="border-0 p-2" value="' . $TotalAtio['PProductodos'] . '" style="width: 100%;" onkeyup="Editar(this,' . $idDias . ',5)"></td>

                        <td class="p-0"><input type="number" class="border-0 p-2" value="' . $TotalAtio['LProductotres'] . '" style="width: 100%;" onkeyup="Editar(this,' . $idDias . ',3)"></td>
                        <td class="p-0"><input type="number" class="border-0 p-2" value="' . $TotalAtio['PProductotres'] . '" style="width: 100%;" onkeyup="Editar(this,' . $idDias . ',6)"></td>

                        <td class="fw-bold text-start">' . number_format($TotalALP, 2) . '</td>
                        <td class="fw-bold text-end">$ ' . number_format($TotalAPP, 2) . '</td>

                        </tr>
                        <tr class = "bg-white ">
                        <th class="bg-white fw-normal">DIFERENCIA</th>
                        <td class="font-weight-bold text-start" ' . $corteDiarioGeneral->esNegativo($DiLPoUno) . ' id="' . $idDias . 'LC1">' . number_format($DiLPoUno, 2) . '</td>
                        <td class="font-weight-bold text-start" ' . $corteDiarioGeneral->esNegativo($DiPPoUno) . ' id="' . $idDias . 'LC4">$ ' . number_format($DiPPoUno, 2) . '</td>
                        <td class="font-weight-bold  text-start" ' . $corteDiarioGeneral->esNegativo($DiLPoDos) . ' id="' . $idDias . 'LC2">' . number_format($DiLPoDos, 2) . '</td>
                        <td class="font-weight-bold text-start" ' . $corteDiarioGeneral->esNegativo($DiPPoDos) . ' id="' . $idDias . 'LC5">$ ' . number_format($DiPPoDos, 2) . '</td>
                        <td class="font-weight-bold text-start" ' . $corteDiarioGeneral->esNegativo($DiLPoTres) . ' id="' . $idDias . 'LC3" >' . number_format($DiLPoTres, 2) . '</td>
                        <td class="font-weight-bold text-start" ' . $corteDiarioGeneral->esNegativo($DiPPoTres) . ' id="' . $idDias . 'LC6" >$ ' . number_format($DiPPoTres, 2) . '</td>
                        <td class="fw-bold text-start"' . $corteDiarioGeneral->esNegativo($DiToLitros) . '>' . number_format($DiToLitros, 2) . '</td>
                        <td class="fw-bold  text-end" ' . $corteDiarioGeneral->esNegativo($DiToPesos) . '>$ ' . number_format($DiToPesos, 2) . '</td>

                        </tr>

                        <tr><th colspan="10" class="bg-light no-hover2 p-2"></th></tr>';

                $GTProducto1 = $GTProducto1 + $Producto1['TotalLitros'];
                $GTProducto2 = $GTProducto2 + $Producto2['TotalLitros'];
                $GTProducto3 = $GTProducto3 + $Producto3['TotalLitros'];
                $GTotalLitros = $GTotalLitros + $TotalLitros;

                $GTPProducto1 = $GTPProducto1 + $Producto1['TotalPrecio'];
                $GTPProducto2 = $GTPProducto2 + $Producto2['TotalPrecio'];
                $GTPProducto3 = $GTPProducto3 + $Producto3['TotalPrecio'];
                $GTotalPrecio = $GTotalPrecio + $TotalPrecio;

                $GTLProductouno = $GTLProductouno + $TotalAtio['LProductouno'];
                $GTLProductodos = $GTLProductodos + $TotalAtio['LProductodos'];
                $GTLProductotres = $GTLProductotres + $TotalAtio['LProductotres'];
                $GTotalALP = $GTotalALP + $TotalALP;
                $GTPProductouno = $GTPProductouno + $TotalAtio['PProductouno'];
                $GTPProductodos = $GTPProductodos + $TotalAtio['PProductodos'];
                $GTPProductotres = $GTPProductotres + $TotalAtio['PProductotres'];
                $GTotalAPP = $GTotalAPP + $TotalAPP;

                $GTDiLPoUno = $GTDiLPoUno + $DiLPoUno;
                $GTDiLPoDos = $GTDiLPoDos + $DiLPoDos;
                $GTDiLPoTres = $GTDiLPoTres + $DiLPoTres;
                $GTDiToLitros = $GTDiToLitros + $DiToLitros;
                $GTDiPPoUno = $GTDiPPoUno + $DiPPoUno;
                $GTDiPPoDos = $GTDiPPoDos + $DiPPoDos;
                $GTDiPPoTres = $GTDiPPoTres + $DiPPoTres;
                $GTDiToPesos = $GTDiToPesos + $DiToPesos;
            }

            ?> 

    <tr class="bg-white">
    <th class="bg-primary fw-normal text-white">VENTAS</th>
    <td class="align-middle bg-white" rowspan="3" class="text-center align-middle"><b>TOTAL</b></td>
    <td><?= number_format($GTProducto1, 2); ?></td>
    <td class="text-end">$<?= number_format($GTPProducto1, 2); ?></td>
    <td><?= number_format($GTProducto2, 2); ?></td>
    <td class="text-end">$<?= number_format($GTPProducto2, 2); ?></td>
    <td><?= number_format($GTProducto3, 2); ?></td>
    <td class="text-end">$<?= number_format($GTPProducto3, 2); ?></td>
    <td class="bg-light"><?= number_format($GTotalLitros, 2); ?></td>
    <td class="bg-light text-end">$<?= number_format($GTotalPrecio, 2); ?></td>
    </tr>

    <tr class="bg-white">            
    <th class="bg-primary fw-normal text-white">DESPACHO</th>
    <td><?= number_format($GTLProductouno, 2); ?></td>
    <td class="text-end">$<?= number_format($GTPProductouno, 2); ?></td>
    <td><?= number_format($GTLProductodos, 2); ?></td>
    <td class="text-end">$<?= number_format($GTPProductodos, 2); ?></td>
    <td><?= number_format($GTLProductotres, 2); ?></td>
    <td class="text-end">$<?= number_format($GTPProductotres, 2); ?></td>
    <td class="bg-light"><?= number_format($GTotalALP, 2); ?></td>
    <td class="bg-light text-end">$<?= number_format($GTotalAPP, 2); ?></td>
    </tr>

            <tr class="bg-white">               
                 <td class="bg-light font-weight-bold">DIFERENCIA</td>
                <td class="font-weight-bold <?= $corteDiarioGeneral->esNegativo($GTDiLPoUno); ?>"><?= number_format($GTDiLPoUno, 2); ?></td>
                <td class="font-weight-bold <?= $corteDiarioGeneral->esNegativo($GTDiPPoUno); ?> text-end">
                    $<?= number_format($GTDiPPoUno, 2); ?></td>
                <td class="font-weight-bold <?= $corteDiarioGeneral->esNegativo($GTDiLPoDos); ?>"><?= number_format($GTDiLPoDos, 2); ?></td>
                <td class="font-weight-bold <?= $corteDiarioGeneral->esNegativo($GTDiPPoDos); ?> text-end">
                    $<?= number_format($GTDiPPoDos, 2); ?></td>
                <td class="font-weight-bold <?= $corteDiarioGeneral->esNegativo($GTDiLPoTres); ?>"><?= number_format($GTDiLPoTres, 2); ?>
                </td>
                <td class="font-weight-bold <?= $corteDiarioGeneral->esNegativo($GTDiPPoTres); ?> text-end">
                    $<?= number_format($GTDiPPoTres, 2); ?></td>
                <td class="font-weight-bold <?= $corteDiarioGeneral->esNegativo($GTDiToLitros); ?>"><?= number_format($GTDiToLitros, 2); ?>
                </td>
                <td class="font-weight-bold <?= $corteDiarioGeneral->esNegativo($GTDiToPesos); ?> text-end">
                    $<?= number_format($GTDiToPesos, 2); ?></td>

            </tr>
        </tbody>
    </table>
</div>