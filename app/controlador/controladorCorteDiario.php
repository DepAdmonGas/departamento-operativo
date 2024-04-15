<?php
require "../modelo/CorteDiario.php";
$CorteDiario = new CorteDiario();

switch($_POST['accion']):
    case 'nuevo-concentrado-ventas-otros':
        $sessionIdEstacion = $_POST['sessionIdEstacion'];
        $idReporte = $_POST['idReporte'];
        $piezas = "";
        $importe = 0;
        $concepto1= "OTROS";
        $concepto2= "4 ACEITES Y LUBRICANTES";
        $concepto3= "5 AUTOLAVADO";
        $concepto4= "6 ADITIVO PARA DIESEL";
        $concepto5 = "7 G BENEFICIOS";
        $conceptos =[$concepto1,$concepto2,$concepto3,$concepto4];
        // Se iteran los diferentes conceptos para mandar a llamar la funcion
        foreach ($conceptos as $concepto):
            $CorteDiario->nuevoConcentradoVentasOtros($idReporte, $concepto, $piezas, $importe);
        endforeach;
        if($sessionIdEstacion == 2):
            $CorteDiario->nuevoConcentradoVentasOtros($idReporte,$concepto5,$piezas,$importe);
        endif;
        break;
    case 'nuevo-registro-prosegur':
        $idReporte = $_POST['idReporte'];
        $recibo = "";
        $importe = 0;
        $denominacion1 = "BILLETE MATUTINO";
        $denominacion2 = "BILLETE VESPERTINO";
        $denominacion3 = "BILLETE NOCTURNO";
        $denominacion4 = "MORRALLA";
        $denominacion5 = "DEPOSITO BANCARIO";
        $denominacion6 = "CHEQUE 1";
        $denominacion7 = "TRANSFERENCIA 1";
        $denominacion8 = "CHEQUE 2";
        $denominacion9 = "TRANSFERENCIA 2";
        $denominaciones = [$denominacion1,$denominacion2,$denominacion3,$denominacion4,$denominacion5
                        ,$denominacion6,$denominacion7,$denominacion8,$denominacion9];
        foreach ($denominaciones as $denominacion):
            $CorteDiario->nuevoRegistroProsegur($idReporte,$denominacion,$recibo,$importe);
        endforeach;
        break;
    case 'editar-prosegur':
        $idProsegur = $_POST['idProsegur'];
        $tipo = $_POST['type'];
        $valor = $_POST['recibo'] ?? $_POST['importe'] ?? null;
        echo $CorteDiario->editarProsegur($tipo,$valor,$idProsegur);
        break;
    case 'registro-tarjetas-bancarias':
        $idReporte = $_POST['idReporte'];
        $sessionIdEstacion = $_POST['sessionEstacion'];
        $baucher = 0;
        $num1 = "1";
        $num1_1 = "1.1";
        $num2 = "2";
        $num3 = "3";
        $num4 = "4";
        $num5 = "5";
        $num6 = "6";
        $num7 = "7";
        $num8 = "8";
        $num9 = "9";
        $num10 = "10";
        $numA = "A";
        $numB = "B";
        $numC = "C";
        $numE = "E";
        $ticketcard = "TICKETCARD";
        $g500 = "G500 FLETT";
        $accord = "VALE ACCORD";
        $efecticard = "EFECTICARD";
        $efectivale = "VALE EFECTIVALE";
        $sodexo = "SODEXO";
        $valeSodexo = "VALE SODEXO";
        $inburgas = "INBURGAS";
        $america = "AMERICAN EXPRESS";
        $bbva = "BBVA BANCOMER SA";
        $inbursa = "INBURSA";
        $vale = "SI VALE";
        $otros = "OTROS";
        $ultragas = "ULTRAGAS";
        $energex = "ENERGEX";
        
        $interlomas = [$ticketcard,$g500,$accord,$efecticard,$efectivale,$sodexo,$valeSodexo,$inburgas,
                        $america,$bbva,$inbursa,$vale,$otros];
        $numInter = [$num1,$num1_1,$numA,$num2,$numB,$num3,$numC,$num4,$num5,$num6,$numE,$num7,$num10];
        
        $paloSolo = [$ticketcard,$g500,$efecticard,$sodexo,$inburgas,$america,$bbva,$inbursa,$otros];
        $numPalo = [$num1,$num1_1,$num2,$num3,$num4,$num5,$num6,$numE,$num10];
        
        $sanAgustin = [$ticketcard,$g500,$efecticard,$sodexo,$inburgas,$america,$bbva,$inbursa,$vale,$ultragas,
                        $energex,$otros];
        $numAgus = [$num1,$num1_1,$num2,$num3,$num4,$num5,$num6,$numE,$num7,$num8,$num9,$num10];
        
        $gasomira = [$ticketcard,$g500,$efecticard,$sodexo,$inburgas,$america,$bbva,$inbursa,$otros];
        $numGaso = [$num1,$num1_1,$num2,$num3,$num4,$num5,$num6,$numE,$num10];
        
        $valle = [$ticketcard,$g500,$efecticard,$sodexo,$inburgas,$america,$bbva,$inbursa,$otros];
        $numValle = [$num1,$num1_1,$num2,$num3,$num4,$num5,$num6,$numE,$num10];
        
        $esmegas = [$ticketcard,$g500,$efecticard,$efectivale,$sodexo,$valeSodexo,$inburgas,$america,$bbva,
                    $inbursa,$otros];
        $numEsme = [$num1,$num1_1,$num2,$numB,$num3,$numC,$num4,$num5,$num6,$numE,$num10];
        
        $xochimilco = [$ticketcard,$g500,$accord,$efecticard,$efectivale,$sodexo,$inburgas,$america,$bbva,
                        $inbursa,$otros];
        $numXochi = [$num1,$num1_1,$numA,$num2,$numB,$num3,$num4,$num5,$num6,$numE,$num10];
        
        $bosqueReal = [$ticketcard,$g500,$efecticard,$sodexo,$inburgas,$america,$bbva,$otros];
        $numBosque = [$num1,$num1_1,$num2,$num3,$num4,$num5,$num6,$num10];
        
        switch($sessionIdEstacion):
            // Interlomas
            case 1:
                foreach (array_combine($numInter, $interlomas) as $num => $bancos) {
                    $CorteDiario->nuevoRegistroTarjetasBancarias($idReporte,$num,$bancos,$baucher);
                }
                break;
            // Palo Solo
            case 2:
                foreach (array_combine($numPalo, $paloSolo) as $num => $bancos) {
                    $CorteDiario->nuevoRegistroTarjetasBancarias($idReporte,$num,$bancos,$baucher);
                }
                break;
            // San Agustin    
            case 3:
                foreach (array_combine($numAgus, $sanAgustin) as $num => $bancos) {
                    $CorteDiario->nuevoRegistroTarjetasBancarias($idReporte,$num,$bancos,$baucher);
                }
                break;
            //Gasomira
            case 4:
                foreach (array_combine($numGaso, $gasomira) as $num => $bancos) {
                    $CorteDiario->nuevoRegistroTarjetasBancarias($idReporte,$num,$bancos,$baucher);
                }
                break;
            // Valle de Guadalupe
            case 5:
                foreach (array_combine($numValle, $valle) as $num => $bancos) {
                    $CorteDiario->nuevoRegistroTarjetasBancarias($idReporte,$num,$bancos,$baucher);
                }
                break;
            // Esmegas
            case 6:
                foreach (array_combine($numEsme, $esmegas) as $num => $bancos) {
                    $CorteDiario->nuevoRegistroTarjetasBancarias($idReporte,$num,$bancos,$baucher);
                }
                break;
            // Xochimilco
            case 7:
                foreach (array_combine($numXochi, $xochimilco) as $num => $bancos) {
                    $CorteDiario->nuevoRegistroTarjetasBancarias($idReporte,$num,$bancos,$baucher);
                }
                break;
            case 14:
                foreach (array_combine($numBosque, $bosqueReal) as $num => $bancos) {
                    $CorteDiario->nuevoRegistroTarjetasBancarias($idReporte,$num,$bancos,$baucher);
                }
                break;
        endswitch;
        $monederos = [$ticketcard,$g500,$efecticard,$sodexo,$inburgas,$america,$bbva,$inbursa,$ultragas,$energex];
        foreach($monederos as $monedero):
            $CorteDiario->monederosBancos($idReporte,$monedero);
        endforeach;
        break;
    case 'editar-tarjetas-CB':
        $baucher = $_POST['baucher'];
        $idTarjeta = $_POST['idTarjeta'];
        echo $CorteDiario->editarTarjetasCB($baucher,$idTarjeta);
        break;
    case 'nuevo-registro-controlgas':
        $idReporte = $_POST['idReporte'];
        $credito = "CRÉDITO (ANEXO)";
        $debito = "DEBITO (ANEXO)";
        $pago = 0;
        $consumo = 0;
        $tarjetas = [$credito,$debito];
        foreach($tarjetas as $tarjeta):
            $CorteDiario->nuevoRegistroControlGas($idReporte,$tarjeta,$pago,$consumo);
        endforeach;
        break;
    case 'editar-controlgas':
        $idControl = $_POST['idControl'];
        $tipo = $_POST['type'];
        $valor = $_POST['pago'] ?? $_POST['consumo'] ?? null;
        echo $CorteDiario->editarControlGas($tipo,$valor,$idControl);
        break;
    case 'nuevo-registro-pago-clientes':
        $idReporte = $_POST['idReporte'];
        $importe = 0;
        $nota = "";
        $concepto1 = "EFECTIVO";
        $concepto2 = "CHEQUE";
        $concepto3 = "TRANSFERENCIA (SPEI)";
        $concepto4 = "TARJETA DE CREDITO";
        $concepto5 = "DEPOSITO BANCARIO";
        $conceptos = [$concepto1,$concepto2,$concepto3,$concepto4,$concepto5];
        foreach($conceptos as $concepto):
            $CorteDiario->nuevoRegistroPagoClientes($idReporte,$concepto,$importe,$nota);
        endforeach;
        break;
    case 'editar-pago-clientes':
        $idPagoCliente = $_POST['idPagoCliente'];
        $tipo = $_POST['type'];
        $valor = $_POST['importe'] ?? $_POST['nota'] ?? null;
        echo $CorteDiario->editarPagoClientes($tipo,$valor,$idPagoCliente);
        break;
    case 'nuevo-registro-venta':
        $idReporte = $_POST['idReporte'];
        $CorteDiario->nuevoRegistroVentas($idReporte);
        break;
    case 'editar-ventas':
        $idVentas = $_POST['idVentas'] ?? $_POST['idOtros'] ?? $_POST['idReporte'] ?? null;
        $tipo = $_POST['type'];
        $valor = $_POST['producto'] ?? $_POST['litros'] ?? $_POST['jarras'] ?? $_POST['preciolitro'] 
                    ?? $_POST['otros']?? null;
        if($tipo == "producto"):
            $ieps = 0; 
            switch($valor):
                case 'G Super':
                    $ieps = 0.4369;
                    break;
                case 'G PREMIUM':
                    $ieps = 0.5331;
                    break;
                case 'G DIESEL':
                    $ieps = 0.3626;
                    break;
            endswitch;
            echo $CorteDiario->editarVentasProducto($valor,$idVentas,$ieps);
        elseif($tipo == "piezas"):
            echo $CorteDiario->editarVentasPiezas($idVentas);
        elseif($tipo != "producto" && $tipo != "piezas"):
            echo $CorteDiario->editarVentas($tipo,$valor,$idVentas);
        endif;
        break;
    case 'editar-observaciones':
        $idReporte = $_POST['idReporte'];
        $observaciones = $_POST['observaciones'];
        echo $CorteDiario->editarObservaciones($idReporte,$observaciones);
        break;
    case 'nuevo-registro-aceites':
        $sessionIdEstacion = $_POST['sessionIdEstacion'];
        $idReporte = $_POST['idReporte'];
        $year = $_POST['year'];
        $mes = $_POST['mes'];
        $idMes = $CorteDiario->idReporte($sessionIdEstacion,$year,$mes);
        $CorteDiario->nuevoRegistroAceites($idReporte,$idMes,$sessionIdEstacion);

        break;
    case 'editar-aceites-lubricantes':
        $idAceite = $_POST['idAceite'];
        $tipo = $_POST['type'];
        $valor = $_POST['cantidad'] ?? $_POST['precio'] ?? null;
        echo $CorteDiario->editarAceitesLubricantes($tipo,$valor,$idAceite);
        break;
        /**Pendiente */
    case 'agregar-firma':

        break;
    case 'agregar-documento':
        echo $idReporte = $_POST['idReporte'];
        $nombreDocumento = $_POST['NombreDocumento'];
        $aleatorio = uniqid();
        $File = $_FILES['Documento_file']['name'];
        $upload_folder = "../../archivos/".$aleatorio."-".$File;
        $PDFNombre = $aleatorio."-".$File;
        if(move_uploaded_file($_FILES['Documento_file']['tmp_name'], $upload_folder)) {
            echo $CorteDiario->agregarDocumento($idReporte,$nombreDocumento,$PDFNombre);
        }
        break;
    case 'eliminar-documento-corte':
        $id = $_POST['id'];
        echo $CorteDiario->eliminarDocumentoCorte($id);
        break;
    endswitch;
?>