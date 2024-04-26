<?php
class FormatoFechas{
    public function nombremes(int $mes): string {
        switch ($mes) :
            case "01":
                $mes = "Enero";
                return $mes;
            case "02":
                $mes = "Febrero";
                return $mes;
            case "03":
                $mes = "Marzo";
                return $mes;
            case "04":
                $mes = "Abril";
                return $mes;
            case "05":
                $mes = "Mayo";
                return $mes;
            case "06":
                $mes = "Junio";
                return $mes;
            case "07":
                $mes = "Julio";
                return $mes;
            case "08":
                $mes = "Agosto";
                return $mes;
            case "09":
                $mes = "Septiembre";
                return $mes;
            case "10":
                $mes = "Octubre";
                return $mes;
            case "11":
                $mes = "Noviembre";
                return $mes;
            case "12":
                $mes = "Diciembre";
                return $mes;
            default:
                $mes = "Mes inválido";
                return $mes;
        endswitch;
    }
    
}
?>