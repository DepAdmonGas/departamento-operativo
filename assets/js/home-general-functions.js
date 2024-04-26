$(document).ready(function ($) {
$(".LoaderPage").fadeOut("slow");
listaMenu()
});

function Regresar() {
    window.history.back();
}

//---------- LISTADO DE ACTIVIDADES USUARIOS ----------//
function listaMenu() {
    $('#DivlistaMenuDO').load('app/vistas/personal-general/home/lista-general-menu.php');
}

//---------- RUTAS DIRECCION DE OPERACIONES ----------//
function rutaMenuDO(ruta) {
    window.location.href = ruta;
}

function SolicitudVales() {
    window.location.href = "solicitud-vales";
}

function SolicitudCheque() {
    window.location.href = "solicitud-cheque";
}

function Aceites() {
    window.location.href = "aceites";
}

function TerminalesPV() {
    window.location.href = "terminales-tpv";
}

function PrecioCombustible() {
    window.location.href = "administracion/precio-combustible";
}

function Refacciones() {
    window.location.href = "refacciones";
}

function Pinturas() {
    window.location.href = "pinturas";
}

function Papeleria() {
    window.location.href = "papeleria";
}

function Limpieza() {
    window.location.href = "limpieza";
}

function SolicitudAditivo() {
    window.location.href = "solicitud-aditivo";
}

function Embarques() {
    window.location.href = "administracion/embarques";
}

function OrdenMantenimiento() {
    window.location.href = "orden-mantenimiento";
}
function OrdenServicio() {
    window.location.href = "orden-servicio";
}

function OrdenCompra() {
    window.location.href = "orden-compra";
}

function ReciboNomina() {
    window.location.href = "recibo-nomina";
}

function ReciboNominaV2() {
    window.location.href = "recibos-nomina";
}

function RecursosHumanos() {
    window.location.href = "recursos-humanos";
}

function Almacen() {
    window.location.href = "administracion/almacen";
}

function PedidoMaterial() {
    window.location.href = "pedido-material";
}

function CalibracionDispensarios() {
    window.location.href = "calibracion-dispensarios";
}

function MedicionExplosividad() {
    window.location.href = "nivel-explosividad";
}

function comunicadoEncargado() {
    window.location.href = "comunicados";
}

function AcuseRecepcionAuditor() {
    window.location.href = "administracion/acuses-recepcion";
}

function DescargaTuxpanAuditor() {
    window.location.href = "descarga-tuxpan";
}