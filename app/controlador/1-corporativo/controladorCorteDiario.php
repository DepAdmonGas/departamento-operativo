<?php
require "../../modelo/1-corporativo/CorteDiario.php";
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
    case 'agregar-pagos-cliente':
        $file  =   $_FILES['Comprobante_file'] ?? [''];
        $idReporte = $_POST['idReporte'];
        $cliente = $_POST['Cliente'];
        $total = $_POST['Total'];
        $tipo = $_POST['Tipo'];
        $formaPago = $_POST['FormaPago'];
        echo $CorteDiario->agregarPagosClientes($file,$idReporte,$cliente,$total,$tipo,$formaPago);
        break;
    case 'agregar-consumos-cliente':
        $idReporte = $_POST['idReporte'];
        $cliente = $_POST['Cliente'];
        $total = $_POST['Total'];
        $tipo = $_POST['Tipo'];
        echo $CorteDiario->agregarConsumos($idReporte,$cliente,$total,$tipo);
        break;
    case 'eliminar-consumo-pago':
        $id = $_POST['id'];
        echo $CorteDiario->elimarConsumosPagos($id);
        break;
    case 'agregar-cliente':
        $idEstacion = $_POST['idestacion'];
        $cuenta = $_POST['Cuenta'];
        $cliente = $_POST['Cliente'];
        $tipo = $_POST['Tipo'];
        $rfc = $_POST['RFC'];
        $Doc1  =   $_FILES['CartaCredito_file'] ?? [''];
        $Doc2  =   $_FILES['ActaConstitutiva_file'] ?? [''];
        $Doc3  =   $_FILES['ComprobanteDom_file'] ?? [''];
        $Doc4  =   $_FILES['Identificacion_file'] ?? [''];
        $doc = [$Doc1,$Doc2,$Doc3,$Doc4];
        echo $CorteDiario->agregarCliente($idEstacion,$cuenta,$cliente,$tipo,$rfc,$doc);
        break;
    case 'editar-cliente-credito':
        $idCliente = $_POST['idCliente'];
        $cuenta = $_POST['Cuenta'];
        $cliente = $_POST['Cliente'];
        $tipo = $_POST['Tipo'];
        $rfc = $_POST['RFC'];
        $Doc1  =   $_FILES['CartaCredito_file'] ?? [''];
        $Doc2  =   $_FILES['ActaConstitutiva_file'] ?? [''];
        $Doc3  =   $_FILES['ComprobanteDom_file'] ?? [''];
        $Doc4  =   $_FILES['Identificacion_file'] ?? [''];
        $doc = [$Doc1,$Doc2,$Doc3,$Doc4];
        echo $CorteDiario->editarClienteCredito($idCliente,$cuenta,$cliente,$tipo,$rfc,$doc);
        break;
    case 'editar-cliente-debito':
        $cuenta = $_POST['Cuenta'];
        $cliente = $_POST['Cliente'];
        $tipo = $_POST['Tipo'];
        $id=$_POST['idCliente'];
        echo $CorteDiario->editarClienteDebito($cuenta,$cliente,$tipo,$id);
        break;
    case 'editar-saldo-inicial':
        $total = $_POST['total'];
        $id = $_POST['id'];
        echo $CorteDiario->editarSaldoInicial($id,$total);
        break;
    case 'finaliza-resumen-cliente-mes':
            $id = $_POST['IdReporte'];
            $CorteDiario->finalizaResumenClientesMes($id);
            break;
        /**
         * 
         *              ACEITES
         * 
         */
    case 'editar-reporte-aceite':
        $tipo = $_POST['type'] ?? '';
        $valor =  $_POST['pedido'] ?? $_POST['fisico'] ?? $_POST['facturado'] ?? $_POST['mostrador'] ?? '';
        $id = $_POST['idaceite'];
        echo $CorteDiario->editarReporteAceite($tipo,$valor,$id);
        break;
    case 'agregar-documento-aceite':
        $doc1 = $_FILES['Ficha_file'] ?? [''];
        $doc2 = $_FILES['Imagen_file'] ?? [''];
        $doc3 = $_FILES['Factura_file'] ?? [''];
        $doc = [$doc1,$doc2,$doc3];
        $idReporte = $_POST['idReporte'];
        $year = $_POST['year'];
        $mes = $_POST['mes'];
        $CorteDiario->agregarDocumentoAceite($doc,$idReporte,$year,$mes);
        break;
    case 'editar-documento-aceite':
        $doc1 = $_FILES['Ficha_file'] ?? [''];
        $doc2 = $_FILES['Imagen_file'] ?? [''];
        $doc3 = $_FILES['Factura_file'] ?? [''];
        $doc = [$doc1,$doc2,$doc3];
        $year = $_POST['year'];
        $mes = $_POST['mes'];
        $id = $_POST['id'];
        $CorteDiario->editarDocumentoAceite($doc,$id,$year,$mes);
        break;
    case 'eliminar-documento-aceite':
        $id = $_POST['id'];
        echo $CorteDiario->eliminarDocumentoAceite($id);
        break;
    case 'finalizar-aceites':
        $idReporte = $_POST['IdReporte'];
        $idEstacion = $_POST['idEstacion'];
        $nombreEstacion = $_POST['nombreEstacion'];
        echo $CorteDiario->finalizarAceite($idEstacion,$idReporte,$nombreEstacion);
        break;
    case 'agregar-factura-archivo-aceite':
        $factura = $_FILES['Factura_file'] ?? [''];
        $year = $_POST['year'];
        $mes = $_POST['mes'];
        $id = $_POST['IdReporte'];
        $fechaAceite = $_POST['fechaAceite'];
        $conceptoAceite = $_POST['conceptoAceite'];
        echo $CorteDiario->agregarFacturaArchivoAceite($id,$fechaAceite, $conceptoAceite, $factura, $mes,$year);
        break;
    case 'eliminar-factura-archivo-aceite':
        $id = $_POST['id'];
        echo $CorteDiario->eliminarFacturaArchivoAceite( $id );
        break;
    /**
     * 
     *      MONEDEROS
     * 
     * 
     */
    case 'editar-documento-monedero':
        $id = $_POST['id'];
        $fecha = $_POST['Fecha'];
        $monedero = $_POST['Cilote'];
        $diferencia = $_POST['Diferencia'];
        $pdf = $_FILES['PDF_file'] ?? [''];
        $xml = $_FILES['XML_file'] ?? [''];
        $excel = $_FILES['EXCEL_file'] ?? [''];
        $doc = [$pdf,$xml,$excel];
        $CorteDiario->agregarDocumentoMonedero($doc, $id, $fecha, $monedero,$diferencia);
        break;
    case 'guardar-documento-edi':
        $id = $_POST['id'];
        $complemento = $_POST['Complemento'];
        $pdf  = $_FILES['PDF_file'] ?? [''];
        $xml  = $_FILES['XML_file'] ?? [''];
        $doc = [$pdf,$xml];
        echo $CorteDiario->agregarDocumentoEdi($doc,$id,$complemento);
        break;
    case 'eliminar-documento-monedero-edi':
        $id = $_POST['id'];
        echo $CorteDiario->eliminarDocumentoEdi($id);
        break;
    /**
     * 
     *      EMBARQUES
     * 
     * 
     * 
     */
    case 'agregar-comentario-embarques':
        $idEmbarque = $_POST['id'];
        $idEstacion = $_POST['idEstacion'];
        $comentario = $_POST['Comentario'];
        echo $CorteDiario->agregarComentarioEmbarques($idEmbarque, $idEstacion, $comentario);
        break;
    case 'agregar-embarque':
        // valores del formulario 
        $idReporte = $_POST['IdReporte'] ?? "";
        $fecha = $_POST['Fecha'] ?? "";
        $embarque = $_POST['Embarque'] ?? "";
        $noDocumento = $_POST['NoDocumento'] ?? "";
        $importe = $_POST['ImporteF'] ?? "";
        $merma = $_POST['Merma'] ?? "";
        $nombreTransporte = $_POST['NombreTransporte'] ?? "";
        $producto = $_POST['Producto'] ?? "";
        $chofer = $_POST['Chofer'] ?? "";
        $unidad = $_POST['Unidad'] ?? "";
        $precioLitro = $_POST['PrecioLitro'] ?? "";
        $tad = $_POST['Tad'] ?? "";
        $valores = [$idReporte,$fecha,$embarque,$noDocumento,$importe,$merma, $nombreTransporte,$producto,$chofer, $unidad,$precioLitro, $tad];
        // archivos del formulario
        $file = $_FILES['Documento_file']??[''];
        $pdf = $_FILES['PDF_file']??[''];
        $xml = $_FILES['XML_file']??[''];
        $copa = $_FILES['CoPa_file']??[''];
        $ncpdf = $_FILES['NCPDF_file']??[''];
        $ncxml = $_FILES['NCXML_file']??[''];
        $compdf = $_FILES['ComPDF_file']??[''];
        $comxml = $_FILES['ComXML_file']??[''];
        $doc = [$file,$pdf, $xml,$copa,$ncpdf,$ncxml, $compdf,$comxml];
        echo $CorteDiario->agregarEmbarques($doc,$valores);
        break;
    case 'elimina-embarque':
        $id = $_POST['id'];
        echo $CorteDiario->eliminaEmbarque($id);
        break;
    case 'actualiza-embarque':
        $fecha = $_POST['Fecha'] ?? "";
        $embarque = $_POST['Embarque'] ?? "";
        $noDocumento = $_POST['NoDocumento'] ?? "";
        $importe = $_POST['ImporteF'] ?? "";
        $merma = $_POST['Merma'] ?? "";
        $nombreTransporte = $_POST['NombreTransporte'] ?? "";
        $producto = $_POST['Producto'] ?? "";
        $chofer = $_POST['Chofer'] ?? "";
        $unidad = $_POST['Unidad'] ?? "";
        $precioLitro = $_POST['PrecioLitro'] ?? "";
        $tad = $_POST['Tad'] ?? "";
        $id = $_POST['id'] ?? "";
        $valores = [$fecha,$embarque,$noDocumento,$importe,$merma, $nombreTransporte,$producto,$chofer, $unidad,$precioLitro, $tad,$id];
        $file = $_FILES['Documento_file']??[''];
        $pdf = $_FILES['PDF_file']??[''];
        $xml = $_FILES['XML_file']??[''];
        $copa = $_FILES['CoPa_file']??[''];
        $ncpdf = $_FILES['NCPDF_file']??[''];
        $ncxml = $_FILES['NCXML_file']??[''];
        $compdf = $_FILES['ComPDF_file']??[''];
        $comxml = $_FILES['ComXML_file']??[''];
        $doc = [$file,$pdf, $xml,$copa,$ncpdf,$ncxml, $compdf,$comxml];
        $CorteDiario->actualizaEmbarque($doc,$valores);
        break;
    endswitch;
