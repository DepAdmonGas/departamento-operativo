<?php
require "../modelo/CorteDiario.php";
$CorteDiario = new CorteDiario();

switch($_POST['accion']):
    case 'nuevo-concentrado-ventas-otros':
        $sessionIdEstacion = $_POST['sessionIdEstacion'];
        $idReporte = $_POST['idReporte'];
        $piezas = "";
        $importe = 0;
        $conceptos =$CorteDiario->getConceptos();
        // Se iteran para mostrar tabla concentrado ventas 
        foreach ($conceptos as $concepto):
            $CorteDiario->nuevoConcentradoVentasOtros($idReporte, $concepto, $piezas, $importe);
        endforeach;
        if($sessionIdEstacion == 2):
            $concepto5 = "7 G BENEFICIOS";
            $CorteDiario->nuevoConcentradoVentasOtros($idReporte,$concepto5,$piezas,$importe);
        endif;
        break;
    case 'nuevo-registro-prosegur':
        $idReporte = $_POST['idReporte'];
        $recibo = "";
        $importe = 0;
        $denominaciones = $CorteDiario->getDenominaciones();
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
        $IdEstacion = $_POST['sessionEstacion'];
        $baucher = 0;
        switch($IdEstacion):
            // Interlomas
            case 1:
                $num = $CorteDiario->getNumero($IdEstacion);
                $tarjetas = $CorteDiario->getTarjetas($IdEstacion);
                // combina dos array de la misma longitud para llenar campos 
                foreach (array_combine($num, $tarjetas) as $num => $bancos) {
                    $CorteDiario->nuevoRegistroTarjetasBancarias($idReporte,$num,$bancos,$baucher);
                }
                break;
            // Palo Solo
            case 2:
                $num = $CorteDiario->getNumero($IdEstacion);
                $tarjetas = $CorteDiario->getTarjetas($IdEstacion);
                foreach (array_combine($num, $tarjetas) as $num => $bancos) {
                    $CorteDiario->nuevoRegistroTarjetasBancarias($idReporte,$num,$bancos,$baucher);
                }
                break;
            // San Agustin    
            case 3:
                $num = $CorteDiario->getNumero($IdEstacion);
                $tarjetas = $CorteDiario->getTarjetas($IdEstacion);
                foreach (array_combine($num, $tarjetas) as $num => $bancos) {
                    $CorteDiario->nuevoRegistroTarjetasBancarias($idReporte,$num,$bancos,$baucher);
                }
                break;
            //Gasomira
            case 4:
                $num = $CorteDiario->getNumero($IdEstacion);
                $tarjetas = $CorteDiario->getTarjetas($IdEstacion);
                foreach (array_combine($num, $tarjetas) as $num => $bancos) {
                    $CorteDiario->nuevoRegistroTarjetasBancarias($idReporte,$num,$bancos,$baucher);
                }
                break;
            // Valle de Guadalupe
            case 5:
                $num = $CorteDiario->getNumero($IdEstacion);
                $tarjetas = $CorteDiario->getTarjetas($IdEstacion);
                foreach (array_combine($num, $tarjetas) as $num => $bancos) {
                    $CorteDiario->nuevoRegistroTarjetasBancarias($idReporte,$num,$bancos,$baucher);
                }
                break;
            // Esmegas
            case 6:
                $num = $CorteDiario->getNumero($IdEstacion);
                $tarjetas = $CorteDiario->getTarjetas($IdEstacion);
                foreach (array_combine($num, $tarjetas) as $num => $bancos) {
                    $CorteDiario->nuevoRegistroTarjetasBancarias($idReporte,$num,$bancos,$baucher);
                }
                break;
            // Xochimilco
            case 7:
                $num = $CorteDiario->getNumero($IdEstacion);
                $tarjetas = $CorteDiario->getTarjetas($IdEstacion);
                foreach (array_combine($num, $tarjetas) as $num => $bancos) {
                    $CorteDiario->nuevoRegistroTarjetasBancarias($idReporte,$num,$bancos,$baucher);
                }
                break;
            case 14:
                $num = $CorteDiario->getNumero($IdEstacion);
                $tarjetas = $CorteDiario->getTarjetas($IdEstacion);
                foreach (array_combine($num, $tarjetas) as $num => $bancos) {
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
        $conceptos = $CorteDiario->pagoConcepto();
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
    case 'firma-corte':
        $sessionIdUsuario = $_POST['sessionUsuario'];
        $nombreEstacion = $_POST['nombreEstacion'];
        $img = $_POST['base64'];
        $idReporte = $_POST['idReporte'];
        echo $CorteDiario->agregarFirma($idReporte,$img,$sessionIdUsuario,$nombreEstacion);
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