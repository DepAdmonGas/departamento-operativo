<?php
$componentes_url = parse_url($_SERVER["REQUEST_URI"]);
$rura = $componentes_url['path'];

$partes_ruta = explode("/", $rura);
$partes_ruta = array_filter($partes_ruta);
$partes_ruta = array_slice($partes_ruta, 0);
$ruta_elegida = 'app/vistas/error/error.php';

if ($partes_ruta[0] == 'departamento-operativo') {

if (count($partes_ruta) == 1) {
$ruta_elegida = 'app/vistas/personal-general/home/home-index.php';

}else if (count($partes_ruta) == 2) {

    switch ($partes_ruta[1]) {

    //---------- 1.CORPORATIVO ---------- 
    case 'corporativo':
    $ruta_elegida = 'app/vistas/personal-general/1-corporativo/corporativo-index.php';
    break;

    case 'corte-diario':
    //$ruta_elegida = 'public/corte-diario/vistas/index.php';
    $Pagina = 'corte-diario';
    $ruta_elegida = 'app/vistas/personal-general/1-corporativo/corporativo-year.php';
    break;

    case 'solicitud-cheque':
    //$ruta_elegida = 'public/corte-diario/vistas/solicitud-cheque-index.php';
    $Pagina = 'solicitud-cheque';
    $ruta_elegida = 'app/vistas/personal-general/1-corporativo/corporativo-year.php';
    break;

    case 'ingresos-facturacion':
    $Pagina = 'ingresos-facturacion';
    $ruta_elegida = 'app/vistas/personal-general/1-corporativo/corporativo-year.php';
    //$ruta_elegida = 'public/corte-diario/vistas/ingresos-facturacion-index.php';
    break;

    case 'estimulo-fiscal':
    //$ruta_elegida = 'public/corte-diario/vistas/estimulo-fiscal-index.php';
    $ruta_elegida = 'app/vistas/personal-general/1-corporativo/estimulo-fiscal/estimulo-fiscal-index.php';
    break;

    case 'despacho-factura':
    //$ruta_elegida = 'public/corte-diario/vistas/despacho-factura-index.php';
    $Pagina = 'despacho-factura';
    $ruta_elegida = 'app/vistas/personal-general/1-corporativo/corporativo-year.php';
    break;

    case 'solicitud-vales':
    //$ruta_elegida = 'public/solicitud-vales/vistas/index.php';
    $Pagina = 'solicitud-vales';
    $ruta_elegida = 'app/vistas/personal-general/1-corporativo/corporativo-year.php';
    break; 

    //---------- 2. RECURSOS HUMANOS ----------
    case 'recursos-humanos':
    //$ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-index.php';
    $ruta_elegida = 'app/vistas/contenido/2-recursos-humanos/recursos-humanos-index.php';
    break;
 
    //----- Personal -----
    case 'recursos-humanos-estacion-personal':
    //$ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-estacion-personal.php';
    $ruta_elegida = 'app/vistas/personal-general/2-recursos-humanos/personal/personal-index.php';
    break;
   
    case 'recursos-humanos-personal':
    //$ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-personal-index.php';
    $ruta_elegida = 'app/vistas/administrador/2-recursos-humanos/personal/personal-index.php';
    break;

    case 'recursos-humanos-baja-personal':
    //$ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-baja-personal-index.php';
    $ruta_elegida = 'app/vistas/administrador/2-recursos-humanos/baja-personal/baja-personal-estaciones.php';
    break;

    //----- Lista negra -----
    case 'recursos-humanos-estacion-lista-negra':
    //$ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-estacion-lista-negra.php';
    $ruta_elegida = 'app/vistas/personal-general/2-recursos-humanos/lista-negra/lista-negra-index.php';
    break;

    case 'recursos-humanos-lista-negra':
    //$ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-lista-negra-index.php';
    $ruta_elegida = 'app/vistas/administrador/2-recursos-humanos/lista-negra/lista-negra-index.php';
    break;

    //----- Biometricos -----
    case 'recursos-humanos-estacion-biometrico':
    //$ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-estacion-asistencia.php';
    $ruta_elegida = 'app/vistas/personal-general/2-recursos-humanos/biometrico/biometrico-index.php';
    break;
 
    case 'recursos-humanos-biometrico':
    //$ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-asistencia.php';
    $ruta_elegida = 'app/vistas/administrador/2-recursos-humanos/biometrico/biometrico-index.php';

    break;

 
    case 'administracion':
                $ruta_elegida = 'public/admin/vistas/index.php';
                break;
            case 'embarques':
                $ruta_elegida = 'public/corte-diario/vistas/embarques-index.php';
                break;

            case 'mediciones':
                //$ruta_elegida = 'public/corte-diario/vistas/mediciones-index.php';
                $ruta_elegida = 'app/vistas/personal-general/3-importacion/mediciones/mediciones-index.php';
                break;



            case 'terminales-tpv':
                $ruta_elegida = 'public/corte-diario/vistas/terminales-tpv-index.php';
                break;

            case 'refacciones':
                //$ruta_elegida = 'public/corte-diario/vistas/refacciones-index.php';
                $ruta_elegida = 'app/vistas/personal-general/4-almacen/refacciones/refacciones-index.php';
                break;
 
            case 'refacciones-almacen':
                //$ruta_elegida = 'public/corte-diario/vistas/refacciones-almacen-index.php';
                $ruta_elegida = 'app/vistas/contenido/4-almacen/refacciones/refacciones-almacen.php';
                break;

            case 'refacciones-transaccion':
                $ruta_elegida = 'public/corte-diario/vistas/refacciones-transaccion-index.php';
                break;

            case 'pinturas':
                $ruta_elegida = 'public/corte-diario/vistas/pinturas-index.php';
                break;

            case 'pinturas-inventario':
                $ruta_elegida = 'public/corte-diario/vistas/pinturas-inventario-index.php';
                break;

            case 'pinturas-reporte':
                $ruta_elegida = 'public/corte-diario/vistas/pinturas-reporte-index.php';
                break;

            case 'papeleria':
                $ruta_elegida = 'public/corte-diario/vistas/papeleria-index.php';
                break;

            case 'papeleria-inventario':
                $ruta_elegida = 'public/corte-diario/vistas/papeleria-inventario-index.php';
                break;

            case 'papeleria-reporte':
                $ruta_elegida = 'public/corte-diario/vistas/papeleria-reporte-index.php';
                break;

            case 'limpieza':
                $ruta_elegida = 'public/corte-diario/vistas/limpieza-index.php';
                break;
            case 'limpieza-inventario':
                $ruta_elegida = 'public/corte-diario/vistas/limpieza-inventario-index.php';
                break;
            case 'limpieza-reporte':
                $ruta_elegida = 'public/corte-diario/vistas/limpieza-reporte-index.php';
                break;



            case 'solicitud-aditivo':
                $ruta_elegida = 'public/corte-diario/vistas/solicitud-aditivo-index.php';
                break;

            case 'firma-electronica':
                $ruta_elegida = 'public/firma-electronica/firma-electronica-index.php';
                break;



            case 'recursos-humanos-organigrama':
                $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-organigrama-index.php';
                break;

            case 'recursos-humanos-estacion-organigrama':
                $ruta_elegida = 'app/vistas/personal-general/2-recursos-humanos/organigrama/organigrama.php';
                //$ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-estacion-organigrama.php';
                break;

            case 'recursos-humanos-formatos':
                $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-formatos-index.php';
                break;

            case 'recursos-humanos-horario-personal':
                $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-horario-personal-index.php';
                break;


            case 'recursos-humanos-estacion-permisos':
                $ruta_elegida = 'app/vistas/personal-general/2-recursos-humanos/permisos/permiso-index.php';
                //$ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-estacion-permisos.php';
                break;


            case 'recursos-humanos-estacion-horario-personal':
                //$ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-estacion-horario-personal.php';
                $ruta_elegida = 'app/vistas/personal-general/2-recursos-humanos/horario-personal/horario-index.php';
                break;

            case 'recursos-humanos-estacion-programar-horario':
                //$ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-estacion-programar-horario.php';
                $ruta_elegida = 'app/vistas/personal-general/2-recursos-humanos/programar-horario/programar-horario-index.php';
                break;

            case 'recursos-humanos-configuracion':
                $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-configuracion-index.php';
                break;

            case 'recursos-humanos-estacion-configuracion':
                $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-estacion-configuracion.php';
                break;

            case 'recursos-humanos-estacion-formatos':
                //$ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-estacion-formatos.php';
                $ruta_elegida = 'app/vistas/personal-general/2-recursos-humanos/formatos/formatos-index.php';
                break;

            case 'recursos-humanos-configuracion-perfil':
                $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-configuracion-perfil-index.php';
                break;

            case 'recursos-humanos-configuracion-puesto':
                $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-configuracion-puestos-index.php';
                break;

            case 'recursos-humanos-configuracion-retardo-horarios-incidencias':
                $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-configuracion-retardo-horarios-incidencias-index.php';
                break;

            case 'recursos-humanos-estacion-configuracion-retardo-horarios-incidencias':
                $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-estacion-configuracion-retardo-horarios-incidencias.php';
                break;





            //---------- RECIBOS DE NOMINA V2 ----------
            case 'recibos-nomina':
            $ruta_elegida = 'public/recibo-nomina/vistas/recibo-nomina-estaciones-index.php';
            break;

            case 'recursos-humanos-recibos-nomina':
                $ruta_elegida = 'public/recibo-nomina/vistas/recursos-humanos-recibo-nomina-index.php';
                break;
            //----------

            //---------- ROLES DE COMODINES ----------
            case 'recursos-humanos-roles':
                $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-roles-index.php';
                break;
            //----------

            //---------- INCIDENCIAS DE NOMINA ----------
            case 'recursos-humanos-incidencia-nomina':
                $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-incidencia-nomina-index.php';
                break;
            //----------

            case 'recursos-humanos-lista-formatos':
                $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-lista-formatos-index.php';
                break;

            case 'recursos-humanos-recibo-nomina':
                $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-nomina-index.php';
                break;

            case 'recibo-nomina':
                $ruta_elegida = 'public/corte-diario/vistas/recibo-nomina-index.php';
                break;

            case 'recursos-humanos-permisos':
                $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-permisos-index.php';
                break;


            case 'recursos-humanos-vacaciones':
                $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-vacaciones-index.php';
                break;

            case 'calibracion-dispensarios':
                $ruta_elegida = 'public/corte-diario/vistas/calibracion-dispensarios-index.php';
                break;

            case 'nivel-explosividad':
                $ruta_elegida = 'public/corte-diario/vistas/nivel-explosividad-index.php';
                break;
 
            //-----------------------------------------------------------------------------------------

            case 'orden-mantenimiento':
                $ruta_elegida = 'public/orden-mantenimiento/vistas/orden-mantenimiento-index.php';
                break;

            case 'orden-servicio':
                $ruta_elegida = 'public/orden-servicio/vistas/orden-servicio-index.php';
                break;

            case 'orden-compra':
                $ruta_elegida = 'public/orden-compra/vistas/orden-compra-index.php';
                break;

            case 'pivoteo':
                //$ruta_elegida = 'public/corte-diario/vistas/pivoteo-index.php';
                $ruta_elegida = 'app/vistas/personal-general/3-importacion/pivoteo/pivoteo-index.php';
                break;

            //-----------------------------------------------------------------------------------------

            case 'descarga-tuxpan':
                //$ruta_elegida = 'public/admin/vistas/descarga-tuxpan-index.php';
                $ruta_elegida = 'app/vistas/personal-general/3-importacion/formato-descarga-merma/descarga-index.php';
                break;

            case 'perfil':
                $ruta_elegida = 'app/vistas/perfil-personal/perfil-index.php';
                break;

            case 'pedido-material':
                $ruta_elegida = 'public/corte-diario/vistas/pedido-material-index.php';
                break;

            case 'miselanea-30-31':
                $ruta_elegida = 'public/miselanea-30-31/vistas/index.php';
                break;


            //--------------- Comunicado Gerente -----------------------------    
            case 'comunicados':
                $ruta_elegida = 'public/comunicados/vistas/comunicados-index.php';
                break;

            //--------------MODELO DE NEGOCIOS -------------------------
            case 'modelo-negocio':
                $ruta_elegida = 'public/modelo-negocio/vistas/index.php';
                break;


            //-------------- SEGUROS -------------------------
            case 'seguros':
                $ruta_elegida = 'public/seguros/vistas/seguros-index.php';
                break;


            //-------------- CONTRATOS -------------------------
            case 'precios-combustible':
            $ruta_elegida = 'public/corte-diario/vistas/precios-combustible-index.php';
            break;

            case 'pedido-papeleria':
                $ruta_elegida = 'public/admin/vistas/pedido-papeleria-op-index.php';
                break;

            case 'pedido-limpieza':
                $ruta_elegida = 'public/admin/vistas/pedido-limpieza-op-index.php';
                break;


            //-------------- VISTAS USUARIOS DEIRECCION DE OPERACIONES -------------------------



            case 'importacion':
                $ruta_elegida = 'public/corte-diario/vistas/importacion-index.php';
                break;

            case 'cuenta-litros':
                $ruta_elegida = 'public/corte-diario/vistas/cuenta-litros-index.php';
                break;

            case 'almacen':
                $ruta_elegida = 'public/corte-diario/vistas/almacen-index.php';
                break;
 
            case 'pedidos':
                $ruta_elegida = 'public/corte-diario/vistas/pedidos-index.php';
                break;




            //----- Mantenimiento preventivo -----//
            case 'mantenimiento-preventivo':
                $ruta_elegida = 'public/corte-diario/vistas/mantenimiento-preventivo-index.php';
                break;

            //----- CERRAR SESION DEL USUARIO -----//
            case 'salir':
                $ruta_elegida = 'app/modelo/acceso/logout-usuarios.php';
                break;



        }

    } else if (count($partes_ruta) == 3) {
    //-------------------- 1.CORPORATIVO -------------------- 

    // 1. Corte Diario -----
    if ($partes_ruta[1] == 'corte-diario') {
    $Pagina = $partes_ruta[1];
     $GET_year = $partes_ruta[2];
    //$ruta_elegida = 'public/corte-diario/vistas/corte-diario-year.php';
    $ruta_elegida = 'app/vistas/personal-general/1-corporativo/corporativo-mes.php';
    
    // 2. Solicitud de Cheque -----
    }else if ($partes_ruta[1] == 'solicitud-cheque') {
    $Pagina = $partes_ruta[1];
    $GET_year = $partes_ruta[2];
    //$ruta_elegida = 'public/corte-diario/vistas/solicitud-cheque-year.php';
    $ruta_elegida = 'app/vistas/personal-general/1-corporativo/corporativo-mes.php';
    } else if ($partes_ruta[1] == 'solicitud-cheque-editar') {
    $GET_idReporte = $partes_ruta[2];
    //$ruta_elegida = 'public/corte-diario/vistas/solicitud-cheque-editar.php';
    $ruta_elegida = 'app/vistas/personal-general/1-corporativo/solicitud-cheque/solicitud-cheque-editar.php';
    } else if ($partes_ruta[1] == 'solicitud-cheque-firmar') {
    $GET_idReporte = $partes_ruta[2];
    //$ruta_elegida = 'public/corte-diario/vistas/solicitud-cheque-firmar.php';
    $ruta_elegida = 'app/vistas/personal-general/1-corporativo/solicitud-cheque/solicitud-cheque-firmar.php';
    
    // 3. Ingresos vs Facturacion -----
    } else if ($partes_ruta[1] == 'ingresos-facturacion') {
    $Pagina = $partes_ruta[1];
    $GET_year = $partes_ruta[2];
    //$ruta_elegida = 'public/corte-diario/vistas/ingresos-facturacion-year.php';
    $ruta_elegida = 'app/vistas/personal-general/1-corporativo/ingresos-facturacion/ingresos-facturacion-index.php';
    }

    // 5. Despacho vs Ventas -----
    else if ($partes_ruta[1] == 'despacho-factura') {
    $Pagina = $partes_ruta[1];
    $GET_year = $partes_ruta[2];
    //$ruta_elegida = 'public/corte-diario/vistas/despacho-factura-year.php';
    $ruta_elegida = 'app/vistas/personal-general/1-corporativo/corporativo-mes.php';
    }

    // 6. Solicitud de Vales -----
    else if ($partes_ruta[1] == 'solicitud-vales') {
    $Pagina = $partes_ruta[1];
    $GET_year = $partes_ruta[2];
    //$ruta_elegida = 'public/solicitud-vales/vistas/solicitud-vales-year-admin.php';
    $ruta_elegida = 'app/vistas/personal-general/1-corporativo/corporativo-mes.php';
    }
  
    //-------------------- 2. RECURSOS HUMANOS  -------------------- 
    
    // -- Asistencia Personal -----
    else if ($partes_ruta[1] == 'recursos-humanos-personal-asistencia') {
    $GET_idPersonal = $partes_ruta[2]; 
    //$ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-personal-asistencia.php';
    $ruta_elegida = 'app/vistas/contenido/2-recursos-humanos/biometrico/biometrico-personal.php';

    //-- Baja Personal -----
    }else if ($partes_ruta[1] == 'recursos-humanos-baja-personal') {
    $GET_idPersonal = $partes_ruta[2];
    //$ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-baja-personal-v2.php';
    $ruta_elegida = 'app/vistas/administrador/2-recursos-humanos/baja-personal/baja-personal.php';

    }else if ($partes_ruta[1] == 'recursos-humanos-detalle-baja-personal') {
    $GET_idBaja = $partes_ruta[2];
    $ruta_elegida = 'app/vistas/administrador/2-recursos-humanos/baja-personal/detalle-baja-personal.php';


    //-------------------- 3. IMPORTACION  -------------------- 
    }else if ($partes_ruta[1] == 'descarga-tuxpan-nuevo') {
    $GET_idEstacion = $partes_ruta[2];
    $ruta_elegida = 'app/vistas/contenido/3-importacion/formato-descarga-merma/nueva-descarga.php';

    //-------------- CONTRATOS -------------------------
    } else if ($partes_ruta[1] == 'contratos') {
    $GET_Categoria = $partes_ruta[2];
    $ruta_elegida = 'public/contratos/vistas/contratos-index.php';
    

    } else if ($partes_ruta[2] == 'aceites') {
            $ruta_elegida = 'public/aceites/vistas/index.php';

            //---------- Comunicados (Dpto. Operativo) ----------//
        } else if ($partes_ruta[2] == 'comunicados') {
            $ruta_elegida = 'public/admin/vistas/comunicados-admin-index.php';

            //---------- Constancia de Situacion Fiscal (Dpto. Operativo) ----------//
        } else if ($partes_ruta[2] == 'constancia-situacion-fiscal') {
            $ruta_elegida = 'public/admin/vistas/csf-admin-index.php';

            //---------- Reportes Estaciones(Direccion) ----------//
        } else if ($partes_ruta[2] == 'reportes') {
            $ruta_elegida = 'public/reportes/vistas/reportes-menu-index.php';

        } else if ($partes_ruta[2] == 'descarga-reporte-demo-pdf') {
            $ruta_elegida = 'public/reportes/vistas/reporte-demo-pdf.php';


            //---------- Licitacion Municipal (Dpto. Operativo) ----------//
        } else if ($partes_ruta[2] == 'licitacion-municipal') {
            $ruta_elegida = 'public/admin/vistas/licitacion-municipal-index.php';

            //---------- Manual Procedimiento (Dpto. Operativo) ----------//
        } else if ($partes_ruta[2] == 'manual-procedimiento') {
            $ruta_elegida = 'public/admin/vistas/manual-procedimiento-admin-index.php';

        } else if ($partes_ruta[2] == 'procedimientos') {
            $ruta_elegida = 'public/procedimientos/vistas/procedimientos-admin-index.php';

            //---------- Pedidos (Admin) ----------//
        } else if ($partes_ruta[2] == 'reportes-anuales') {
            $ruta_elegida = 'app/vistas/administrador/0-reportes-anuales/index.php';

            //---------- Pedidos (Admin) ----------//
        }
        else if ($partes_ruta[2] == 'pedidos') {
            $ruta_elegida = 'public/admin/vistas/pedidos-admin-index.php';

            //---------- Camioneta Saveiro ----------//
        } else if ($partes_ruta[2] == 'camioneta-saveiro') {
            $ruta_elegida = 'public/admin/vistas/camioneta-saveiro-admin-index.php';

        } else if ($partes_ruta[2] == 'inventario-aceites') {
            $ruta_elegida = 'public/admin/vistas/inventario-aceites-index.php';
        } else if ($partes_ruta[2] == 'corte-diario') {
            $ruta_elegida = 'public/admin/vistas/corte-diario.php';
        }

        //---------- RESUMEN MONEDEROS (SERVICIO SOCIAL)----------
        else if ($partes_ruta[2] == 'resumen-aceites') {
            $ruta_elegida = 'public/admin/vistas/resumen-aceites-ss.php';
        }else if($partes_ruta[2] == 'reporte-solicitud-cheque'){
            $ruta_elegida = 'app/vistas/administrador/0-reportes-anuales/reporte.php';
        }

        //---------- RESUMEN MONEDEROS (SERVICIO SOCIAL)----------
        else if ($partes_ruta[2] == 'resumen-monedero') {
            $ruta_elegida = 'public/admin/vistas/resumen-monedero-ss.php';
        } else if ($partes_ruta[2] == 'bitacora-aditivo') {
            $ruta_elegida = 'public/admin/vistas/bitacora-aditivo-index.php';
        } else if ($partes_ruta[2] == 'embarques') {
            $ruta_elegida = 'public/admin/vistas/embarques-index.php';
        } else if ($partes_ruta[1] == 'embarques') {
            $GET_year = $partes_ruta[2];
            $ruta_elegida = 'public/corte-diario/vistas/embarques-year.php';
        } else if ($partes_ruta[2] == 'precio-combustible') {
            $ruta_elegida = 'public/admin/vistas/precio-combustible-index.php';
        } else if ($partes_ruta[2] == 'precio-combustible-formato') {
            $ruta_elegida = 'public/admin/vistas/precio-combustible-formato-index.php';
        } else if ($partes_ruta[2] == 'mediciones') {
            $ruta_elegida = 'public/admin/vistas/mediciones-index.php';
        } else if ($partes_ruta[2] == 'ingresos-facturacion') {
            $ruta_elegida = 'public/admin/vistas/ingresos-facturacion-index.php';
        } else if ($partes_ruta[2] == 'terminales-tpv') {
            $ruta_elegida = 'public/admin/vistas/terminales-tpv-index.php';
        } else if ($partes_ruta[2] == 'almacen') {
            $ruta_elegida = 'public/admin/vistas/almacen.php';
        } else if ($partes_ruta[2] == 'mantenimiento') {
            $ruta_elegida = 'public/admin/vistas/mantenimiento.php';
        } else if ($partes_ruta[2] == 'refacciones') {
            $ruta_elegida = 'public/admin/vistas/refacciones-index.php';
        } else if ($partes_ruta[2] == 'pinturas') {
            $ruta_elegida = 'public/admin/vistas/pinturas-index.php';
        } else if ($partes_ruta[1] == 'pinturas-pedido') {
            $GET_idReporte = $partes_ruta[2];
            $ruta_elegida = 'public/corte-diario/vistas/pinturas-pedido.php';
        } else if ($partes_ruta[1] == 'pedido-pinturas') {
            $GET_idReporte = $partes_ruta[2];
            $ruta_elegida = 'public/admin/vistas/pdf-pedido-pinturas.php';
        }

        //---------- PEDIDOS DPTO. OPERATIVO (CARMEN) ----------
        else if ($partes_ruta[2] == 'pedidos-pinturas') {
            $ruta_elegida = 'public/admin/vistas/pedido-pinturas-op-index.php';
        } else if ($partes_ruta[2] == 'pedidos-papeleria') {
            $ruta_elegida = 'public/admin/vistas/pedido-papeleria-op-index.php';
        } else if ($partes_ruta[2] == 'pedidos-limpieza') {
            $ruta_elegida = 'public/admin/vistas/pedido-limpieza-op-index.php';
        }
        //-------------------------------------------------------
        else if ($partes_ruta[2] == 'papeleria') {
            $ruta_elegida = 'public/admin/vistas/papeleria-index.php';
        } else if ($partes_ruta[1] == 'pedido-papeleria') {
            $GET_idReporte = $partes_ruta[2];
            $ruta_elegida = 'public/admin/vistas/pdf-pedido-papeleria.php';
        } else if ($partes_ruta[2] == 'limpieza') {
            $ruta_elegida = 'public/admin/vistas/limpieza-index.php';
        } else if ($partes_ruta[2] == 'senalamientos') {
            $ruta_elegida = 'public/admin/vistas/senalamientos-index.php';
        } else if ($partes_ruta[2] == 'senalamientos-dispensario') {
            $ruta_elegida = 'public/admin/vistas/senalamientos-dispensario.php';
        } else if ($partes_ruta[2] == 'pedido-material') {
            $ruta_elegida = 'public/admin/vistas/pedido-material-index.php';
        } else if ($partes_ruta[2] == 'orden-compra') {
            $ruta_elegida = 'public/orden-compra/vistas/orden-compra-inicio-index.php';
        } else if ($partes_ruta[2] == 'orden-mantenimiento') {
            $ruta_elegida = 'public/orden-mantenimiento/vistas/orden-mantenimiento-estacion-index.php';
        } else if ($partes_ruta[2] == 'solicitud-cheque') {
            $ruta_elegida = 'public/corte-diario/vistas/solicitud-cheque-index.php';
        } else if ($partes_ruta[1] == 'pinturas-reporte') {
            $GET_idReporte = $partes_ruta[2];
            $ruta_elegida = 'public/corte-diario/vistas/pinturas-reporte-detalle-index.php';
        } else if ($partes_ruta[1] == 'papeleria-reporte') {
            $GET_idReporte = $partes_ruta[2];
            $ruta_elegida = 'public/corte-diario/vistas/papeleria-reporte-detalle-index.php';
        } else if ($partes_ruta[1] == 'limpieza-reporte') {
            $GET_idReporte = $partes_ruta[2];
            $ruta_elegida = 'public/corte-diario/vistas/limpieza-reporte-detalle-index.php';
        } else if ($partes_ruta[1] == 'pedido-limpieza') {
            $GET_idReporte = $partes_ruta[2];
            $ruta_elegida = 'public/admin/vistas/pdf-pedido-limpieza.php';
        } else if ($partes_ruta[2] == 'reporte-cre') {
            $ruta_elegida = 'public/admin/vistas/reporte-cre-index.php';
        } else if ($partes_ruta[2] == 'estimulo-fiscal') {
            $ruta_elegida = 'public/admin/vistas/estimulo-fiscal-index.php';
        } else if ($partes_ruta[2] == 'despacho-factura') {
            $ruta_elegida = 'public/admin/vistas/despacho-factura-index.php';
        } else if ($partes_ruta[1] == 'solicitud-cheque-pdf') {
            $GET_idReporte = $partes_ruta[2];
            $ruta_elegida = 'public/admin/vistas/solicitud-cheque-pdf.php';
        } else if ($partes_ruta[1] == 'recursos-humanos-nomina') {
            $GET_year = $partes_ruta[2];
            $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-nomina-year.php';
        }

        //---------- RECIBOS DE NOMINA V2 ----------
        else if ($partes_ruta[1] == 'recursos-humanos-recibos-nomina') {
            $GET_year = $partes_ruta[2];
            $ruta_elegida = 'public/recibo-nomina/vistas/recursos-humanos-recibo-nomina-year.php';
        }

        else if ($partes_ruta[1] == 'recursos-humanos-recibos-nomina-evaluacion') {
            $GET_year = $partes_ruta[2];
            $ruta_elegida = 'public/recibo-nomina/vistas/recursos-humanos-recibo-nomina-evaluacion.php';
        } else if ($partes_ruta[1] == 'recursos-humanos-recibos-nomina-revision') {
            $GET_year = $partes_ruta[2];
            $ruta_elegida = 'public/recibo-nomina/vistas/recursos-humanos-recibo-nomina-revision.php';
        } else if ($partes_ruta[1] == 'recibos-nomina') {
            $GET_year = $partes_ruta[2];
            $ruta_elegida = 'public/recibo-nomina/vistas/recibo-nomina-estaciones-year.php';
        }




        //---------------------------------------------
        else if ($partes_ruta[1] == 'recibo-nomina') {
            $GET_year = $partes_ruta[2];
            $ruta_elegida = 'public/corte-diario/vistas/recibo-nomina-year.php';
        } else if ($partes_ruta[2] == 'corporativo') {
            $ruta_elegida = 'public/admin/vistas/corporativo-index.php';
        } else if ($partes_ruta[2] == 'importacion') {
            $ruta_elegida = 'public/admin/vistas/importacion-index.php';
        } else if ($partes_ruta[2] == 'importacion-inventarios-diarios') {
            $ruta_elegida = 'public/admin/vistas/importacion-inventarios-diarios-index.php';
        } else if ($partes_ruta[2] == 'importacion-analisis-compra') {
            $ruta_elegida = 'public/admin/vistas/importacion-analisis-compra-index.php';
        }

        //---------- PRECIOS DE COMBUSTIBLE DIARIOS ----------
        else if ($partes_ruta[2] == 'precios-combustible') {
            $ruta_elegida = 'public/admin/vistas/precios-combustible-index.php';
        }


        //---------- MANTENIMIENTO PREVENTIVO ----------
        else if ($partes_ruta[2] == 'mantenimiento-preventivo') {
            $ruta_elegida = 'public/admin/vistas/mantenimiento-preventivo-index.php';
        } else if ($partes_ruta[2] == 'mantenimiento-preventivo') {
            $ruta_elegida = 'public/admin/vistas/mantenimiento-preventivo-index.php';
        }


        //---------- CUENTA LITROS ----------
        else if ($partes_ruta[2] == 'cuenta-litros') {
            $ruta_elegida = 'public/admin/vistas/cuenta-litros-index.php';
        } else if ($partes_ruta[2] == 'pivoteo') {
            $ruta_elegida = 'public/admin/vistas/pivoteo-index.php';
        } else if ($partes_ruta[1] == 'recursos-humanos-formatos-firma') {
            $GET_idFormato = $partes_ruta[2];
            $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-formatos-firmar.php';
        } else if ($partes_ruta[1] == 'recursos-humanos-formatos-pdf') {
            $GET_idFormato = $partes_ruta[2];
            $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-formatos-pdf.php';
        } else if ($partes_ruta[1] == 'recursos-humanos-formatos-1') {
            $GET_idFormato = $partes_ruta[2];
            $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-formatos1.php';
        } else if ($partes_ruta[1] == 'recursos-humanos-formatos-vacaciones') {
            $GET_idFormato = $partes_ruta[2];
           //$ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-formatos-vacaciones.php';
            $ruta_elegida = 'app/vistas/contenido/2-recursos-humanos/formatos/formato-vacaciones.php';
        } else if ($partes_ruta[1] == 'recursos-humanos-personal-asistencia') {
            $GET_idPersonal = $partes_ruta[2];
            $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-personal-asistencia.php';

        } else if ($partes_ruta[1] == 'descarga-tuxpan-detalle') {
            $GET_idReporte = $partes_ruta[2];
            //$ruta_elegida = 'public/admin/vistas/descarga-tuxpan-detalle.php';
            $ruta_elegida = 'app/vistas/contenido/3-importacion/formato-descarga-merma/detalle-merma.php';
        } else if ($partes_ruta[1] == 'descarga-tuxpan-editar') {
            $GET_idReporte = $partes_ruta[2];
            //$ruta_elegida = 'public/admin/vistas/descarga-tuxpan-editar.php';
            $ruta_elegida = 'app/vistas/contenido/3-importacion/formato-descarga-merma/editar-detalle-merma.php';
        } else if ($partes_ruta[2] == 'descarga-tuxpan') {
            $ruta_elegida = 'public/admin/vistas/descarga-tuxpan-admin.php';
        } else if ($partes_ruta[2] == 'nivel-explosividad') {
            $ruta_elegida = 'public/admin/vistas/nivel-explosividad-index.php';
        } else if ($partes_ruta[2] == 'calibracion-dispensarios') {
            $ruta_elegida = 'public/admin/vistas/calibracion-dispensarios-index.php';
        } else if ($partes_ruta[1] == 'recursos-humanos-estacion-programar-horario-nuevo') {
            $GET_idReporte = $partes_ruta[2];
            //$ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-estacion-programar-horario-nuevo.php';
            $ruta_elegida = 'app/vistas/contenido/2-recursos-humanos/programar-horario/nuevo-horario.php';
        } else if ($partes_ruta[1] == 'recursos-humanos-estacion-programar-horario-detalle') {
            $GET_idReporte = $partes_ruta[2];
            //$ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-estacion-programar-horario-detalle.php';
            $ruta_elegida = 'app/vistas/contenido/2-recursos-humanos/programar-horario/detalle-horario.php';
        } else if ($partes_ruta[2] == 'solicitud-aditivo') {
            $ruta_elegida = 'public/admin/vistas/solicitud-aditivo-index.php';
        } else if ($partes_ruta[1] == 'solicitud-aditivo-pdf') {
            $GET_idReporte = $partes_ruta[2];
            $ruta_elegida = 'public/admin/vistas/solicitud-aditivo-pdf.php';
        }

        //------------------------------------------------------------------------
        else if ($partes_ruta[1] == 'orden-servicio-nuevo') {
            $GET_idReporte = $partes_ruta[2];
            $ruta_elegida = 'public/orden-servicio/vistas/orden-servicio-nuevo.php';
        } else if ($partes_ruta[1] == 'pedido-material-pdf') {
            $GET_idPedido = $partes_ruta[2];
            $ruta_elegida = 'public/admin/vistas/pedido-material-pdf.php';
        } else if ($partes_ruta[1] == 'nivel-explosividad-detalle') {
            $GET_idReporte = $partes_ruta[2];
            $ruta_elegida = 'public/corte-diario/vistas/nivel-explosividad-detalle.php';
        }


        //----------------------------------------------------------------------------
        else if ($partes_ruta[1] == 'miselanea-30-31') {
            $GET_idYear = $partes_ruta[2];
            $ruta_elegida = 'public/miselanea-30-31/vistas/miselanea-30-31.php';
        } else if ($partes_ruta[1] == 'pivoteo-editar') {
            $GET_idReporte = $partes_ruta[2];
            //$ruta_elegida = 'public/corte-diario/vistas/pivoteo-editar.php';
            $ruta_elegida = 'app/vistas/personal-general/3-importacion/pivoteo/editar-pivoteo.php';
        } else if ($partes_ruta[1] == 'pivoteo-pdf') {
            $GET_idReporte = $partes_ruta[2];
            //$ruta_elegida = 'public/admin/vistas/pivoteo-pdf.php';
            $ruta_elegida = 'app/vistas/contenido/3-importacion/pivoteo/pivoteo-pdf.php';
        } else if ($partes_ruta[1] == 'recursos-humanos-vacaciones-firmar') {
            $GET_idReporte = $partes_ruta[2];
            $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-vacaciones-firmar.php';
        } else if ($partes_ruta[1] == 'recursos-humanos-vacaciones-pdf') {
            $GET_idReporte = $partes_ruta[2];
            $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-vacaciones-pdf.php';
        } else if ($partes_ruta[2] == 'incidencias') {
            $ruta_elegida = 'public/incidencias/vistas/incidencias-index.php';
        } else if ($partes_ruta[2] == 'estacion-incidencias') {
            $ruta_elegida = 'public/estacion-incidencias/vistas/estacion-incidencias-admin-index.php';
        } else if ($partes_ruta[1] == 'estacion-incidencias') {
            $GET_idEstacion = $partes_ruta[2];
            $ruta_elegida = 'public/estacion-incidencias/vistas/estacion-incidencias-index.php';
        }

        //-------------------- MODELO DE NEGOCIO DETALLE
        else if ($partes_ruta[1] == 'modelo-negocio-detalle') {
            $GET_idReporte = $partes_ruta[2];
            $ruta_elegida = 'public/modelo-negocio/vistas/modelo-negocio-detalle.php';
        }

        //---------- PRECIOS DIARIOS DE COMBUSTIBLE ----------
        else if ($partes_ruta[1] == 'precios-combustible') {
            $GET_idyear = $partes_ruta[2];
            $ruta_elegida = 'public/corte-diario/vistas/precios-combustible-year-index.php';
        } else if ($partes_ruta[2] == 'mantenimiento-preventivo') {
            $ruta_elegida = 'public/admin/vistas/mantenimiento-preventivo-index.php';
        } else if ($partes_ruta[2] == 'mantenimiento-preventivo') {
            $ruta_elegida = 'public/admin/vistas/mantenimiento-preventivo-index.php';
        } else if ($partes_ruta[2] == 'control-volumetrico') {
            $ruta_elegida = 'public/admin/vistas/control-volumetrico-year.php';
        } else if ($partes_ruta[1] == 'recursos-humanos-permisos-firmar') {
            $GET_idReporte = $partes_ruta[2];
            //$ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-permisos-firmar.php';
            $ruta_elegida = 'app/vistas/contenido/2-recursos-humanos/permisos/firmar.php';
        } else if ($partes_ruta[1] == 'recursos-humanos-permiso-nuevo') {
            $GET_idEstacion = $partes_ruta[2];
            //$ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-permisos-nuevo.php';
            $ruta_elegida = 'app/vistas/contenido/2-recursos-humanos/permisos/nuevo-permiso.php';
        } else if ($partes_ruta[1] == 'recursos-humanos-permiso-editar') {
            $GET_idPermiso = $partes_ruta[2];
            $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-permisos-editar.php';
        }


        //---------- CUENTA LITROS ----------
        else if ($partes_ruta[1] == 'cuenta-litros') {
            $GET_idyear = $partes_ruta[2];
            $ruta_elegida = 'public/corte-diario/vistas/cuenta-litros-year-index.php';
        } else if ($partes_ruta[1] == 'cuenta-litros-formato') {
            $GET_idCLitros = $partes_ruta[2];
            $ruta_elegida = 'public/corte-diario/vistas/cuenta-litros-formato.php';
        } else if ($partes_ruta[1] == 'cuenta-litros-detalle') {
            $GET_idCLitros = $partes_ruta[2];
            $ruta_elegida = 'public/corte-diario/vistas/cuenta-litros-detalle.php';
        } else if ($partes_ruta[1] == 'orden-compra-detalle') {
            $GET_idReporte = $partes_ruta[2];
            $ruta_elegida = 'public/orden-compra/vistas/orden-compra-detalle-personal.php';
        } else if ($partes_ruta[1] == 'orden-compra-descargar') {
            $GET_idReporte = $partes_ruta[2];
            $ruta_elegida = 'public/orden-compra/vistas/orden-compra-descargar.php';
        }


        //----- Vales
        else if ($partes_ruta[1] == 'solicitud-vales-firmar') {
            $GET_idReporte = $partes_ruta[2];
            $ruta_elegida = 'public/solicitud-vales/vistas/solicitud-vales-firmar.php';
        } else if ($partes_ruta[1] == 'solicitud-vales-pdf') {
            $GET_idReporte = $partes_ruta[2];
            $ruta_elegida = 'public/solicitud-vales/vistas/solicitud-vales-pdf.php';
        }

        //---------- PROVEEDORES ----------
        else if ($partes_ruta[2] == 'proveedores') {
            $ruta_elegida = 'public/admin/vistas/proveedores-index.php';
        } else if ($partes_ruta[2] == 'proveedores-nuevo') {
            $ruta_elegida = 'public/admin/vistas/proveedores-nuevo-index.php';
        }

        //---------- RECIBO DE NOMINA INDIVIDUAL ----------
        else if ($partes_ruta[1] == 'recibo-nomina-individual') {
            $GET_idPersonal = $partes_ruta[2];
            $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-nomina-individual-index.php';
        }


        //---------- Acuses de Recepcion (Dpto. Operativo) ----------//
        else if ($partes_ruta[2] == 'acuses-recepcion') {
            $ruta_elegida = 'public/acuses-recepcion/vistas/acuses-recepcion-index.php';
        }


        //---------- RECURSOS HUMANOS (EVALUACION KPI) ----------//
        else if ($partes_ruta[1] == 'recursos-humanos-evaluacion-personal') {
            $GET_idEstacion = $partes_ruta[2];
            $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-evaluacion-personal-index.php';
        }

        else if ($partes_ruta[1] == 'precios-combustible-detalle') {
            $GET_idPrecio = $partes_ruta[2];
            $ruta_elegida = 'public/admin/vistas/precios-combustible-detalle.php';
        } 

    } else if (count($partes_ruta) == 4) {


        //---------- 1. CORPOTATIVO ----------
        if ($partes_ruta[1] == 'solicitud-cheque') {
            $Pagina = $partes_ruta[1];
            $GET_year = $partes_ruta[2];
            $GET_mes = $partes_ruta[3];
            //$ruta_elegida = 'public/corte-diario/vistas/solicitud-cheque-mes.php';
            $ruta_elegida = 'app/vistas/personal-general/1-corporativo/solicitud-cheque/solicitud-cheque-mes.php';
        } else if ($partes_ruta[1] == 'solicitud-cheque-crear') {
            $GET_year = $partes_ruta[2];
            $GET_mes = $partes_ruta[3];
            //$ruta_elegida = 'public/corte-diario/vistas/solicitud-cheque-crear.php';
            $ruta_elegida = 'app/vistas/personal-general/1-corporativo/solicitud-cheque/solicitud-cheque-crear.php';

        }// 6. Solicitud de Vales 
        else if ($partes_ruta[1] == 'solicitud-vales') {
        $Pagina = $partes_ruta[1];
        $GET_year = $partes_ruta[2];
        $GET_mes = $partes_ruta[3];
        //$ruta_elegida = 'public/solicitud-vales/vistas/solicitud-vales-mes.php';
        $ruta_elegida = 'app/vistas/personal-general/1-corporativo/solicitud-vales/solicitud-vales-mes.php';
        }else if ($partes_ruta[1] == 'corte-diario') {
            $Pagina = $partes_ruta[1];
            $GET_year = $partes_ruta[2];
            $GET_mes = $partes_ruta[3];
            $ruta_elegida = 'app/vistas/personal-general/1-corporativo/corte-diario/corte-diario-index.php';
            //$ruta_elegida = 'public/corte-diario/vistas/corte-diario-mes.php';
        } else if ($partes_ruta[1] == 'cuenta-litros') {
            $GET_idYear = $partes_ruta[2];
            $GET_idMes = $partes_ruta[3];
            $ruta_elegida = 'public/corte-diario/vistas/cuenta-litros-mes-index.php';
        } else if ($partes_ruta[1] == 'aceites-mes') {
            $GET_year = $partes_ruta[2];
            $GET_mes = $partes_ruta[3];
            $ruta_elegida = 'app/vistas/personal-general/1-corporativo/corte-diario/aceites/aceites-mes.php';
            //$ruta_elegida = 'public/corte-diario/vistas/aceites-mes.php';
        } else if ($partes_ruta[1] == 'clientes-mes') {
            $GET_year = $partes_ruta[2];
            $GET_mes = $partes_ruta[3];
            $ruta_elegida = 'app/vistas/personal-general/1-corporativo/corte-diario/clientes/clientes-mes.php';
            //$ruta_elegida = 'public/corte-diario/vistas/clientes-mes.php';
        } else if ($partes_ruta[1] == 'embarques-mes') {
            $GET_year = $partes_ruta[2];
            $GET_mes = $partes_ruta[3];
            $ruta_elegida = 'app/vistas/personal-general/1-corporativo/corte-diario/embarques/embarques-mes.php';
            //$ruta_elegida = 'public/corte-diario/vistas/embarques-mes.php';
        } else if ($partes_ruta[2] == 'corte-diario') {
            $GET_year = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/corte-diario-year.php';
        }


        //---------- RESUMEN ACEITES (SERVICIO SOCIAL)----------
        else if ($partes_ruta[2] == 'resumen-aceites') {
            $GET_year = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/resumen-aceites-year-ss.php';
        }

        //---------- RESUMEN MONEDEROS (SERVICIO SOCIAL)----------
        else if ($partes_ruta[2] == 'resumen-monedero') {
            $GET_year = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/resumen-monedero-year-ss.php';
        } else if ($partes_ruta[1] == 'control-despacho') {
            $GET_year = $partes_ruta[2];
            $GET_mes = $partes_ruta[3];
            $ruta_elegida = 'public/corte-diario/vistas/control-despacho.php';
        } else if ($partes_ruta[1] == 'resumen-impuestos') {
            $GET_year = $partes_ruta[2];
            $GET_mes = $partes_ruta[3];
            $ruta_elegida = 'app/vistas/personal-general/1-corporativo/corte-diario/impuestos/resumen-impuestos.php';
            //$ruta_elegida = 'public/corte-diario/vistas/resumen-impuestos.php';
        } else if ($partes_ruta[1] == 'resumen-monedero') {
            $GET_year = $partes_ruta[2];
            $GET_mes = $partes_ruta[3];
            $ruta_elegida = 'app/vistas/personal-general/1-corporativo/corte-diario/monedero/resumen-monedero.php';
            //$ruta_elegida = 'public/corte-diario/vistas/resumen-monedero.php';
        } else if ($partes_ruta[2] == 'embarques') {
            $GET_year = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/embarques-year.php';
        } else if ($partes_ruta[1] == 'embarques') {
            $GET_year = $partes_ruta[2];
            $GET_mes = $partes_ruta[3];
            $ruta_elegida = 'public/corte-diario/vistas/embarques-mes.php';
        } else if ($partes_ruta[2] == 'precio-combustible') {
            $GET_dia = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/detalle-precio-combustible.php';
        } else if ($partes_ruta[2] == 'ingresos-facturacion') {
            $GET_year = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/ingresos-facturacion-year.php';
        } else if ($partes_ruta[2] == 'ingresos-facturacion-resumen') {
            $GET_reporte = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/ingresos-facturacion-resumen.php';
        } else if ($partes_ruta[2] == 'solicitud-cheque') {
            $GET_year = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/solicitud-cheque-year.php';
        } else if ($partes_ruta[2] == 'solicitud-cheque-firmar') {
            $GET_idReporte = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/solicitud-cheque-firmar.php';
        } else if ($partes_ruta[2] == 'pedido-pinturas') {
            $GET_idPedido = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/pdf-pedido-papeleria.php';
        } else if ($partes_ruta[2] == 'pedido-material') {
            $GET_idPedido = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/pedido-material-formulario.php';
        } else if ($partes_ruta[2] == 'pedido-material-firma') {
            $GET_idPedido = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/pedido-material-firma.php';
        } else if ($partes_ruta[1] == 'despacho-factura') {
            $Pagina = $partes_ruta[1];
            $GET_year = $partes_ruta[2];
            $GET_mes = $partes_ruta[3];
            //$ruta_elegida = 'public/corte-diario/vistas/despacho-factura-mes.php';
            $ruta_elegida = 'app/vistas/personal-general/1-corporativo/despacho-factura/despacho-factura-index.php';
        } else if ($partes_ruta[2] == 'solicitud-cheque-pdf') {
            $GET_idReporte = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/solicitud-cheque-pdf.php';
        } else if ($partes_ruta[1] == 'recursos-humanos-nomina') {
            $GET_year = $partes_ruta[2];
            $GET_mes = $partes_ruta[3];
            $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-nomina-mes.php';
        } else if ($partes_ruta[1] == 'recibo-nomina') {
            $GET_year = $partes_ruta[2];
            $GET_mes = $partes_ruta[3];
            $ruta_elegida = 'public/corte-diario/vistas/recibo-nomina-mes.php';
        } else if ($partes_ruta[2] == 'importacion-inventarios-diarios') {
            $GET_idReporte = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/importacion-inventarios-diarios-nuevo.php';
        } else if ($partes_ruta[2] == 'importacion-analisis-compra') {
            $GET_year = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/importacion-analisis-compra-mes.php';
        } else if ($partes_ruta[2] == 'descarga-tuxpan-detalle') {
            $GET_idReporte = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/descarga-tuxpan-detalle-admin.php';
        } else if ($partes_ruta[2] == 'descarga-tuxpan-pdf') {
            $GET_idReporte = $partes_ruta[3];
            //$ruta_elegida = 'public/admin/vistas/descarga-tuxpan-pdf.php';
            $ruta_elegida = 'app/vistas/contenido/3-importacion/formato-descarga-merma/descarga-pdf.php';
        } else if ($partes_ruta[2] == 'nivel-explosividad') {
            $GET_idReporte = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/nivel-explosividad-nuevo.php';
        } else if ($partes_ruta[2] == 'nivel-explosividad-detalle') {
            $GET_idReporte = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/nivel-explosividad-detalle.php';
        } else if ($partes_ruta[2] == 'formato-precios-detalle') {
            $GET_idPrecio = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/formato-precios-detalle.php';
        } else if ($partes_ruta[2] == 'solicitud-aditivo-firmar') {
            $GET_idReporte = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/solicitud-aditivo-firmar.php';
        } else if ($partes_ruta[2] == 'orden-compra-nuevo') {
            $GET_idReporte = $partes_ruta[3];
            $ruta_elegida = 'public/orden-compra/vistas/orden-compra-nuevo.php';
        } else if ($partes_ruta[2] == 'orden-compra-firmar') {
            $GET_idReporte = $partes_ruta[3];
            $ruta_elegida = 'public/orden-compra/vistas/orden-compra-firmar.php';
        } else if ($partes_ruta[2] == 'orden-compra-detalle') {
            $GET_idReporte = $partes_ruta[3];
            $ruta_elegida = 'public/orden-compra/vistas/orden-compra-detalle.php';
        } else if ($partes_ruta[2] == 'orden-compra-descargar') {
            $GET_idReporte = $partes_ruta[3];
            $ruta_elegida = 'public/orden-compra/vistas/orden-compra-descargar.php';
        } else if ($partes_ruta[2] == 'orden-mantenimiento-nuevo') {
            $GET_idReporte = $partes_ruta[3];
            $ruta_elegida = 'public/orden-mantenimiento/vistas/orden-mantenimiento-nuevo.php';
        } else if ($partes_ruta[2] == 'orden-mantenimiento-detalle') {
            $GET_idReporte = $partes_ruta[3];
            $ruta_elegida = 'public/orden-mantenimiento/vistas/orden-mantenimiento-detalle.php';
        } else if ($partes_ruta[2] == 'orden-mantenimiento-firmar') {
            $GET_idReporte = $partes_ruta[3];
            $ruta_elegida = 'public/orden-mantenimiento/vistas/orden-mantenimiento-firmar.php';
        } else if ($partes_ruta[2] == 'orden-mantenimiento-descargar') {
            $GET_idReporte = $partes_ruta[3];
            $ruta_elegida = 'public/orden-mantenimiento/vistas/orden-mantenimiento-descargar.php';
        } else if ($partes_ruta[2] == 'refacciones-transaccion') {
            $GET_idReporte = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/refacciones-transaccion-index.php';
        } else if ($partes_ruta[2] == 'refacciones-transaccion-firmar') {
            $GET_idReporte = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/refacciones-transaccion-firmar.php';
        } else if ($partes_ruta[2] == 'refacciones-transaccion-pdf') {
            $GET_idReporte = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/refacciones-transaccion-pdf.php';
        } else if ($partes_ruta[2] == 'pedido-pinturas-firmar') {
            $GET_idReporte = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/pedido-pinturas-firmar.php';
        } else if ($partes_ruta[2] == 'pinturas-pedido') {
            $GET_idReporte = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/pedido-pinturas-complementos.php';
        } else if ($partes_ruta[2] == 'pedido-papeleria-firmar') {
            $GET_idReporte = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/pedido-papeleria-firmar.php';
        } else if ($partes_ruta[2] == 'pedido-limpieza-firmar') {
            $GET_idReporte = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/pedido-limpieza-firmar.php';
        } else if ($partes_ruta[2] == 'pivoteo-editar') {
            $GET_idReporte = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/pivoteo-editar.php';
        } else if ($partes_ruta[2] == 'etapa-documental') {
            $GET_idYear = $partes_ruta[3];
            $ruta_elegida = 'public/miselanea-30-31/vistas/etapa-documental.php';
        } else if ($partes_ruta[2] == 'etapa-sitio') {
            $GET_idYear = $partes_ruta[3];
            $ruta_elegida = 'public/miselanea-30-31/vistas/etapa-sitio.php';
        } else if ($partes_ruta[2] == 'certificacion') {
            $GET_idYear = $partes_ruta[3];
            $ruta_elegida = 'public/miselanea-30-31/vistas/certificacion.php';
        } else if ($partes_ruta[2] == 'incidencias') {
            $GET_idyear = $partes_ruta[3];
            $ruta_elegida = 'public/incidencias/vistas/incidencias-year-index.php';
        }

        else if ($partes_ruta[2] == 'despacho-factura') {
        $GET_year = $partes_ruta[3];
        $ruta_elegida = 'public/admin/vistas/despacho-factura-year.php'; 


        //---------- LICITACION MUNICIPAL ----------
         }else if ($partes_ruta[2] == 'licitacion-municipal') {
            $GET_idyear = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/licitacion-municipal-year.php';
        }


        //---------- PRECIOS DIARIOS DE COMBUSTIBLE ----------
        else if ($partes_ruta[2] == 'precios-combustible') {
            $GET_idyear = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/precios-combustible-year-index.php';
        }

        //---------- PRECIOS DIARIOS DE COMBUSTIBLE ----------
        else if ($partes_ruta[2] == 'orden-compra') {
            $GET_idyear = $partes_ruta[3];
            $ruta_elegida = 'public/orden-compra/vistas/orden-compra-year-index.php';
        }

        //---------- CUENTA LITROS ----------
        else if ($partes_ruta[2] == 'cuenta-litros') {
            $GET_idyear = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/cuenta-litros-year-index.php';
        } else if ($partes_ruta[1] == 'precios-combustible') {
            $GET_idYear = $partes_ruta[2];
            $GET_idMes = $partes_ruta[3];
            $ruta_elegida = 'public/corte-diario/vistas/precios-combustible-mes.php';
        } else if ($partes_ruta[2] == 'precios-combustible-formulario') {
            $GET_IdPrecio = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/precios-combustible-nuevo.php';
        } else if ($partes_ruta[2] == 'cuenta-litros-formato') {
            $GET_idCLitros = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/cuenta-litros-formato.php';
        } else if ($partes_ruta[2] == 'cuenta-litros-detalle') {
            $GET_idCLitros = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/cuenta-litros-detalle.php';
        } else if ($partes_ruta[2] == 'precios-combustible-editar') {
            $GET_idReporte = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/precios-combustible-editar.php';
        } else if ($partes_ruta[2] == 'control-volumetrico') {
            $GET_idYear = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/control-volumetrico-mes.php';
        }


        //--- Vales
        else if ($partes_ruta[1] == 'admin-solicitud-vales') {
            $GET_year = $partes_ruta[2];
            $GET_mes = $partes_ruta[3];
            $ruta_elegida = 'public/solicitud-vales/vistas/solicitud-vales-mes-admin.php';
        } else if ($partes_ruta[1] == 'solicitud-vales') {
            $GET_year = $partes_ruta[2];
            $GET_mes = $partes_ruta[3];
            $ruta_elegida = 'public/solicitud-vales/vistas/solicitud-vales-mes.php';
        } else if ($partes_ruta[2] == 'procedimientos') {
            $GET_modulo = $partes_ruta[3];
            $ruta_elegida = 'public/procedimientos/vistas/procedimientos-modulo-index.php';
        }


        //---------- PROVEEDORES ----------
        else if ($partes_ruta[2] == 'proveedores-editar') {
            $GET_idProveedor = $partes_ruta[3];
            $ruta_elegida = 'public/admin/vistas/proveedores-editar-index.php';
        }


        //---------- RECIBO DE NOMINA INDIVIDUAL ----------
        else if ($partes_ruta[1] == 'recibo-nomina-individual') {
            $GET_idPersonal = $partes_ruta[2];
            $GET_year = $partes_ruta[3];
            $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-nomina-individual-year.php';
        }

        //---------- Acuses de Recepcion (Dpto. Operativo) ----------//
        else if ($partes_ruta[2] == 'acuses-recepcion-editar') {
            $GET_idReporte = $partes_ruta[3];
            $ruta_elegida = 'public/acuses-recepcion/vistas/acuses-recepcion-editar.php';
        }



    } else if (count($partes_ruta) == 5) {

        if ($partes_ruta[1] == 'corte-ventas') {
            $GET_year = $partes_ruta[2];
            $GET_mes = $partes_ruta[3];
            $GET_idReporte = intval($partes_ruta[4]);
            $ruta_elegida = 'app/vistas/personal-general/1-corporativo/corte-diario/ventas/corte-ventas-dia.php';
            //$ruta_elegida = 'public/corte-diario/vistas/corte-ventas-dia.php';

        } else if ($partes_ruta[1] == 'cierre-lote') {
            $GET_year = $partes_ruta[2];
            $GET_mes = $partes_ruta[3];
            $GET_idReporte = $partes_ruta[4];
            $ruta_elegida = 'app/vistas/personal-general/1-corporativo/corte-diario/tpv/cierre-lote-dia.php';
            //$ruta_elegida = 'public/corte-diario/vistas/cierre-lote-dia.php';
        } else if ($partes_ruta[1] == 'monedero') {
            $GET_year = $partes_ruta[2];
            $GET_mes = $partes_ruta[3];
            $GET_idReporte = $partes_ruta[4];
            $ruta_elegida = 'app/vistas/personal-general/1-corporativo/corte-diario/monedero/monedero-dia.php';
            //$ruta_elegida = 'public/corte-diario/vistas/monedero-dia.php';
        } else if ($partes_ruta[1] == 'impuestos-mes') {
            $GET_year = $partes_ruta[2];
            $GET_mes = $partes_ruta[3];
            $GET_idReporte = $partes_ruta[4];
            $ruta_elegida = 'app/vistas/personal-general/1-corporativo/corte-diario/impuestos/impuestos-dia.php';
            //$ruta_elegida = 'public/corte-diario/vistas/inpuestos-mes.php';
        } else if ($partes_ruta[2] == 'corte-diario') {
            $GET_year = $partes_ruta[3];
            $GET_mes = $partes_ruta[4];
            $ruta_elegida = 'public/admin/vistas/corte-diario-mes.php';
        }

        //---------- RESUMEN ACEITES (SERVICIO SOCIAL)----------
        else if ($partes_ruta[2] == 'resumen-aceites') {
            $GET_year = $partes_ruta[3];
            $GET_mes = $partes_ruta[4];
            $ruta_elegida = 'public/admin/vistas/resumen-aceites-mes-ss.php';
        }

        //---------- RESUMEN MONEDERO (SERVICIO SOCIAL)----------
        else if ($partes_ruta[2] == 'resumen-monedero') {
            $GET_year = $partes_ruta[3];
            $GET_mes = $partes_ruta[4];
            $ruta_elegida = 'public/admin/vistas/resumen-monedero-mes-ss.php';
        } else if ($partes_ruta[2] == 'inventario-aceites') {
            $GET_idEstacion = $partes_ruta[3];
            $GET_idMes = $partes_ruta[4];
            $ruta_elegida = 'public/admin/vistas/inventario-inicial.php';
        } else if ($partes_ruta[2] == 'resumen-control-despacho') {
            $GET_year = $partes_ruta[3];
            $GET_mes = $partes_ruta[4];
            $ruta_elegida = 'public/admin/vistas/resumen-control-despacho.php';
        }
        if ($partes_ruta[1] == 'clientes') {
            $GET_year = $partes_ruta[2];
            $GET_mes = $partes_ruta[3];
            $GET_idReporte = $partes_ruta[4];
            $ruta_elegida = 'app/vistas/personal-general/1-corporativo/corte-diario/clientes/clientes-dia.php';
            //$ruta_elegida = 'public/corte-diario/vistas/clientes-dia.php';
        }
        if ($partes_ruta[1] == 'clientes-lista') {
            $GET_year = $partes_ruta[2];
            $GET_mes = $partes_ruta[3];
            $GET_idReporte = $partes_ruta[4];
            $ruta_elegida = 'app/vistas/personal-general/1-corporativo/corte-diario/clientes/clientes-lista.php';
            //$ruta_elegida = 'public/corte-diario/vistas/clientes-lista.php';
        } else if ($partes_ruta[2] == 'embarques') {
            $GET_year = $partes_ruta[3];
            $GET_mes = $partes_ruta[4];
            $ruta_elegida = 'public/admin/vistas/embarques-mes.php';
        } else if ($partes_ruta[2] == 'solicitud-cheque') {
            $GET_year = $partes_ruta[3];
            $GET_mes = $partes_ruta[4];
            $ruta_elegida = 'public/admin/vistas/solicitud-cheque-mes.php';
        } else if ($partes_ruta[2] == 'despacho-factura') {
            $GET_year = $partes_ruta[3];
            $GET_mes = $partes_ruta[4];
            $ruta_elegida = 'public/admin/vistas/despacho-factura-mes.php';
        } else if ($partes_ruta[2] == 'importacion-analisis-compra') {
            $GET_year = $partes_ruta[3];
            $GET_mes = $partes_ruta[4];
            $ruta_elegida = 'public/admin/vistas/importacion-analisis-compra-detalle.php';
        }
 
        /* ----- OCULTAR RUTA FORMATO DE PRECIOS 

        else if ($partes_ruta[2] == 'formato-precios') {
        $GET_year = $partes_ruta[3];
        $GET_mes = $partes_ruta[4];
        $ruta_elegida = 'public/admin/vistas/formato-precios.php';
        }

        ----- */ else if ($partes_ruta[2] == 'analisis-compra') {
            $GET_year = $partes_ruta[3];
            $GET_mes = $partes_ruta[4];
            $ruta_elegida = 'public/admin/vistas/analisis-compras-resumen.php';
        } else if ($partes_ruta[2] == 'incidencias') {
            $GET_idYear = $partes_ruta[3];
            $GET_idMes = $partes_ruta[4];
            $ruta_elegida = 'public/incidencias/vistas/incidencias-mes-index.php';
        }

        /* ----- OCULTAR RUTA FORMATO DE PRECIOS 
        else if ($partes_ruta[2] == 'precios-combustible') {
        $GET_idYear = $partes_ruta[3];
        $GET_idMes = $partes_ruta[4];
        $ruta_elegida = 'public/admin/vistas/formato-precios.php';
        }
        ----- */ else if ($partes_ruta[2] == 'precios-combustible') {
            $GET_idYear = $partes_ruta[3];
            $GET_idMes = $partes_ruta[4];
            $ruta_elegida = 'public/admin/vistas/precios-combustible-mes.php';
        } else if ($partes_ruta[2] == 'cuenta-litros') {
            $GET_idYear = $partes_ruta[3];
            $GET_idMes = $partes_ruta[4];
            $ruta_elegida = 'public/admin/vistas/cuenta-litros-mes-index.php';
        } else if ($partes_ruta[2] == 'orden-compra') {
            $GET_idYear = $partes_ruta[3];
            $GET_idMes = $partes_ruta[4];
            $ruta_elegida = 'public/orden-compra/vistas/orden-compra-mes-index.php';
        }


        //---------- RECIBO DE NOMINA INDIVIDUAL ----------
        else if ($partes_ruta[1] == 'recibo-nomina-individual') {
            $GET_idPersonal = $partes_ruta[2];
            $GET_year = $partes_ruta[3];
            $GET_mes = $partes_ruta[4];
            $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-nomina-individual-mes.php';
        } else if ($partes_ruta[1] == 'recursos-humanos-nomina') {
            $GET_year = $partes_ruta[2];
            $GET_mes = $partes_ruta[3];
            $GET_semana = $partes_ruta[4];
            $ruta_elegida = 'public/recursos-humanos/vistas/recursos-humanos-nomina-semana.php';
        } else if ($partes_ruta[1] == 'recibo-nomina') {
            $GET_year = $partes_ruta[2];
            $GET_mes = $partes_ruta[3];
            $GET_semana = $partes_ruta[4];
            $ruta_elegida = 'public/corte-diario/vistas/recibo-nomina-semana.php';
        }


    } else if (count($partes_ruta) == 6) {

    // ---------- 1. CORPORATIVO ----------//

    // 6. Solicitud de Vales -----
    if ($partes_ruta[1] == 'solicitud-vales-nuevo') {
    $GET_year = $partes_ruta[2];
    $GET_mes = $partes_ruta[3];
    $GET_idEstacion = $partes_ruta[4];
    $GET_depu = $partes_ruta[5];
    //$ruta_elegida = 'public/solicitud-vales/vistas/solicitud-vales-crear.php';
    $ruta_elegida = 'app/vistas/contenido/1-corporativo/solicitud-vales/solicitud-vales-crear.php';


    }else if($partes_ruta[2] == 'corte-ventas') {
    $GET_year = $partes_ruta[3];
    $GET_mes = $partes_ruta[4];
    $GET_idReporte = $partes_ruta[5];
    $ruta_elegida = 'public/admin/vistas/corte-ventas-dia.php';
    }else if ($partes_ruta[2] == 'cierre-lote') {
            $GET_year = $partes_ruta[3];
            $GET_mes = $partes_ruta[4];
            $GET_idReporte = $partes_ruta[5];
            $ruta_elegida = 'public/admin/vistas/cierre-lote-dia.php';
        } else if ($partes_ruta[2] == 'monedero') {
            $GET_year = $partes_ruta[3];
            $GET_mes = $partes_ruta[4];
            $GET_idReporte = $partes_ruta[5];
            $ruta_elegida = 'public/admin/vistas/monedero-dia.php';
        } else if ($partes_ruta[2] == 'clientes') {
            $GET_year = $partes_ruta[3];
            $GET_mes = $partes_ruta[4];
            $GET_idReporte = $partes_ruta[5];
            $ruta_elegida = 'public/admin/vistas/clientes-dia.php';
        } else if ($partes_ruta[2] == 'clientes-lista') {
            $GET_year = $partes_ruta[3];
            $GET_mes = $partes_ruta[4];
            $GET_idReporte = $partes_ruta[5];
            $ruta_elegida = 'public/admin/vistas/clientes-lista.php';
        } else if ($partes_ruta[2] == 'impuestos-mes') {
            $GET_year = $partes_ruta[3];
            $GET_mes = $partes_ruta[4];
            $GET_idReporte = $partes_ruta[5];
            $ruta_elegida = 'public/admin/vistas/inpuestos-mes.php';
        } else if ($partes_ruta[2] == 'aceites-mes') {
            $GET_idEstacion = $partes_ruta[3];
            $GET_year = $partes_ruta[4];
            $GET_mes = $partes_ruta[5];
            $ruta_elegida = 'public/admin/vistas/aceites-mes.php';
        } else if ($partes_ruta[2] == 'clientes-mes') {
            $GET_idEstacion = $partes_ruta[3];
            $GET_year = $partes_ruta[4];
            $GET_mes = $partes_ruta[5];
            $ruta_elegida = 'public/admin/vistas/clientes-mes.php';
        } else if ($partes_ruta[2] == 'resumen-mes') {
            $GET_idEstacion = $partes_ruta[3];
            $GET_year = $partes_ruta[4];
            $GET_mes = $partes_ruta[5];
            $ruta_elegida = 'public/admin/vistas/resumen-mes.php';
        } else if ($partes_ruta[2] == 'resumen-impuestos') {
            $GET_idEstacion = $partes_ruta[3];
            $GET_year = $partes_ruta[4];
            $GET_mes = $partes_ruta[5];
            $ruta_elegida = 'public/admin/vistas/resumen-impuestos.php';
        } else if ($partes_ruta[2] == 'resumen-monedero') {
            $GET_idEstacion = $partes_ruta[3];
            $GET_year = $partes_ruta[4];
            $GET_mes = $partes_ruta[5];
            $ruta_elegida = 'public/admin/vistas/resumen-monedero.php';
        } else if ($partes_ruta[2] == 'resumen-periodo-monedero') {
            $GET_idEstacion = $partes_ruta[3];
            $GET_year = $partes_ruta[4];
            $GET_mes = $partes_ruta[5];
            $ruta_elegida = 'public/admin/vistas/resumen-periodo-monedero.php';
        } else if ($partes_ruta[2] == 'factura-telcel') {
            $GET_idEstacion = $partes_ruta[3];
            $GET_year = $partes_ruta[4];
            $GET_mes = $partes_ruta[5];
            $ruta_elegida = 'public/admin/vistas/factura-telcel.php';
        }

        //---------- KPI ACTIVACION DE CORTE DIARIO ----------
        else if ($partes_ruta[2] == 'corte-diario-evaluacion') {
            $GET_year = $partes_ruta[3];
            $GET_mes = $partes_ruta[4];
            $GET_idEstacion = $partes_ruta[5];
            $ruta_elegida = 'public/admin/vistas/kpi-activacion-corte-diario.php';
        }
        //----------------------------------------------------

        //---------- KPI MONEDEROS ----------
        else if ($partes_ruta[2] == 'resumen-monedero-evaluacion') {
            $GET_year = $partes_ruta[3];
            $GET_mes = $partes_ruta[4];
            $GET_idEstacion = $partes_ruta[5];
            $ruta_elegida = 'public/admin/vistas/kpi-resumen-monedero.php';
        }
        //----------------------------------------------------
 
        //---------- KPI ACEITES ----------
        else if ($partes_ruta[2] == 'aceites-evaluacion') {
            $GET_year = $partes_ruta[3];
            $GET_mes = $partes_ruta[4];
            $GET_idEstacion = $partes_ruta[5];
            $ruta_elegida = 'public/admin/vistas/kpi-aceites.php';
        }
        //----------------------------------------------------
        else if ($partes_ruta[2] == 'control-volumetrico') {
            $GET_idEstacion = $partes_ruta[3];
            $GET_year = $partes_ruta[4];
            $GET_mes = $partes_ruta[5];
            $ruta_elegida = 'public/admin/vistas/control-volumetrico.php';
        } else if ($partes_ruta[2] == 'control-volumetrico-resumen') {
            $GET_idEstacion = $partes_ruta[3];
            $GET_year = $partes_ruta[4];
            $GET_mes = $partes_ruta[5];
            $ruta_elegida = 'public/admin/vistas/control-volumetrico-resumen.php';
        } else if ($partes_ruta[2] == 'concentrado-ventas') {
            $GET_idEstacion = $partes_ruta[3];
            $GET_year = $partes_ruta[4];
            $GET_mes = $partes_ruta[5];
            $ruta_elegida = 'public/admin/vistas/concentrado-ventas-producto.php';
        } else if ($partes_ruta[2] == 'analisis-compra') {
            $GET_idEstacion = $partes_ruta[3];
            $GET_year = $partes_ruta[4];
            $GET_mes = $partes_ruta[5];
            $ruta_elegida = 'public/admin/vistas/analisis-compras.php';
        } else if ($partes_ruta[2] == 'incidencias') {
            $GET_idCategoria = $partes_ruta[3];
            $GET_idYear = $partes_ruta[4];
            $GET_mes = $partes_ruta[5];
            $ruta_elegida = 'public/incidencias/vistas/incidencias-detalle-index.php';

        } else if ($partes_ruta[1] == 'solicitud-vales-editar') {
            $GET_year = $partes_ruta[2];
            $GET_mes = $partes_ruta[3];
            $GET_idEstacion = $partes_ruta[4];
            $GET_idReporte = $partes_ruta[5];
            $ruta_elegida = 'public/solicitud-vales/vistas/solicitud-vales-editar.php';
        }




    } else if (count($partes_ruta) == 7) {

        if ($partes_ruta[2] == 'solicitud-cheque-nuevo') {
            $GET_year = $partes_ruta[3];
            $GET_mes = $partes_ruta[4];
            $GET_idEstacion = $partes_ruta[5];
            $GET_depu = $partes_ruta[6];
            $ruta_elegida = 'public/admin/vistas/solicitud-cheque-crear.php';

        } else if ($partes_ruta[2] == 'solicitud-cheque-editar') {
            $GET_year = $partes_ruta[3];
            $GET_mes = $partes_ruta[4];
            $GET_idEstacion = $partes_ruta[5];
            $GET_idReporte = $partes_ruta[6];
            $ruta_elegida = 'public/admin/vistas/solicitud-cheque-editar.php';


        }

    }
}

include_once $ruta_elegida;

?>