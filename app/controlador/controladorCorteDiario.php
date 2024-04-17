<?php
require "../modelo/CorteDiario.php";
$CorteDiario = new CorteDiario();

switch($_POST['accion']):
    /**  
     *               Corte Ventas
     * 
    */
    case 'nuevo-concentrado-ventas-otros':
        $sessionIdEstacion = $_POST['sessionIdEstacion'];
        $idReporte = $_POST['idReporte'];
        $CorteDiario->nuevoConcentrado($idReporte,$sessionIdEstacion);
        break;
    case 'nuevo-registro-prosegur':
        $idReporte = $_POST['idReporte'];
        $CorteDiario->nuevoProsegur($idReporte);
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
        $CorteDiario->nuevoTarjetas($idReporte,$IdEstacion);
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
        $tarjetas = [$credito,$debito];
        foreach($tarjetas as $tarjeta):
            $CorteDiario->nuevoRegistroControlGas($idReporte,$tarjeta);
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
        $CorteDiario->nuevoRegistroPago($idReporte);
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
            echo $CorteDiario->editarVentasProducto($valor,$idVentas);
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
        
    case 'firma-corte':
        $sessionIdUsuario = $_POST['sessionUsuario'];
        $nombreEstacion = $_POST['nombreEstacion'];
        $img = $_POST['base64'];
        $idReporte = $_POST['idReporte'];
        echo $CorteDiario->agregarFirma($idReporte,$img,$sessionIdUsuario,$nombreEstacion);
        break;
    case 'agregar-documento':
        $idReporte = $_POST['idReporte'];
        $nombreDocumento = $_POST['NombreDocumento'];
        $file = $_FILES['Documento_file'];
        $CorteDiario->agregarDocumento($idReporte,$nombreDocumento,$file);
        break;
    case 'eliminar-documento-corte':
        $id = $_POST['id'];
        echo $CorteDiario->eliminarDocumentoCorte($id);
        break;
    /**
    * 
    *                         TPV
    * 
    */

    case 'nuevo-cierre-lote':
        $idReporte = $_POST['idReporte'];
        $empresa = $_POST['empresa'];
        echo $CorteDiario->nuevoCierreLote($idReporte,$empresa);
        break;
    case 'editar-cierre-lote':
        $tipo = $_POST['type'];
        $cierre = $_POST['nocierre'] ?? $_POST['importe'] ?? $_POST['noticket'];
        $idCierre = $_POST['idCierre'];
        $idReporte = $_POST['idReporte'] ?? 0;
        $empresa = $_POST['empresa'] ?? "";
        echo $CorteDiario->editarCierreLote($tipo,$cierre,$idCierre,$idReporte,$empresa);
        break;
    case 'editar-pendiente-cierre-lote':
        $estado = $_POST['estado'];
        $idCierre = $_POST['idCierre'];
        echo $CorteDiario->editarPendienteCierreLote($estado,$idCierre);
        break;
    /**
     * 
     *                          Clientes
     * 
     */
    endswitch;
?>