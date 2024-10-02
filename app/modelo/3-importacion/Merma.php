<?php
require "../../bd/inc.conexion.php";
require_once '../../modelo/HerramientasDptoOperativo.php';
class Merma extends Exception{
    private $classConexionBD;
    private $con;
    private $formato;
    public function __construct()
    {
        $this->classConexionBD = Database::getInstance();
        $this->con = $this->classConexionBD->getConnection();
        $this->formato = new herramientasDptoOperativo($this->con);
    }
    private function folio($estacion): int {
        // Preparar la consulta
        $sql = "SELECT folio FROM op_descarga_tuxpa WHERE id_estacion = ? ORDER BY id DESC LIMIT 1";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception('Failed to prepare statement: ' . $this->con->error);
        endif;
    
        $stmt->bind_param('i', $estacion);
        $stmt->execute();
        $stmt->bind_result($folio);
        $stmt->fetch();
    
        // Verificar si no hay filas
        if (is_null($folio)) :
            $id = 1;
        else :
            $id = $folio + 1;
        endif;
    
        $stmt->close();
        return $id;
    }
    
    private function idPrincipal(): int {
        $sql = "SELECT id FROM op_descarga_tuxpa ORDER BY id DESC LIMIT 1";
        $stmt = $this->con->prepare($sql);
        if (!$stmt) :
        throw new Exception('Error al preparar la consulta' . $this->con->error);
        endif;
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();
        // Si no hay filas, establecer $id en 1
        if (is_null($id)) :
            $id = 1;
        else :
            $id += 1;
        endif;    
        $stmt->close();
        return $id;
    }
    
    public function nuevoFormato(array $form,array $docs,array $imgs): string{
        $result = true;
        $path = "../../../archivos/tuxpan/";
        // se mueven los archivos a carpeta y se obtiene el nombre a insertar
        $FacturaRemision = $this->fileUpload($docs[0],$path,"no_factura");
        $InventarioInicial = $this->fileUpload($docs[1],$path,"inventario_inicial");
        $Nice = $this->fileUpload($docs[2],$path,"nice");
        $InventarioFinal = $this->fileUpload($docs[3],$path,"inventario_final");
        $MetroContador = $this->fileUpload($docs[4],$path,"metro_contador");
        $MC20Grados = $this->fileUpload($docs[5],$path,"grados");

        $IdPrincipal = $this->idPrincipal();
        $Folio = $this->folio($form[0]);
        // inicia consulta
        $sql = "INSERT INTO op_descarga_tuxpa (
            id,
            folio,
            id_estacion,
            id_usuario,
            fecha_llegada,
            hora_llegada,
            producto,
            no_factura,
            sellos,
            inventario_inicial,
            nice,
            detuvo_venta,
            inventario_final,
            metro_contador,
            metro_contador20,
            merma,
            operador,
            transportista,
            no_factura_remision,
            litros,
            precio_litro,
            unidad,
            cuenta_litros
            )
            VALUES 
            (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->con->prepare($sql);
        if(!$stmt):
            $result = false;
            throw new Exception("Error al preparar la consulta".$this->con->error);
        endif;
        $stmt->bind_param("iiiisssssssssssdsssddsd",$IdPrincipal,$Folio,$form[0],$form[1],$form[2],$form[3],$form[4],
            $FacturaRemision,$form[5],$InventarioInicial,$Nice,$form[6],$InventarioFinal,$MetroContador,$MC20Grados,
            $form[7],$form[8],$form[9],$form[10],$form[11],$form[12],$form[13],$form[14]);
        if(!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consuta".$stmt->error);
        endif;
        $stmt->close();

        $img1 = $imgs[0];
        $img1 = str_replace('data:image/png;base64,', '', $img1);
        $fileData1 = base64_decode($img1);
        $fileName1 = uniqid().'.png';
        if(file_put_contents('../../../imgs/firma-tuxpan/'.$fileName1, $fileData1)):
            $tipo = 'Encargado de estación';
            $this->agregarFirma($IdPrincipal,$tipo,$fileName1);
        endif;
        $img2 = $imgs[1];
        $img2 = str_replace('data:image/png;base64,', '', $img2);
        $fileData2 = base64_decode($img2);
        $fileName2 = uniqid().'.png';
        if(file_put_contents('../../../imgs/firma-tuxpan/'.$fileName2, $fileData2)):
            $tipo = 'Operador';
            $this->agregarFirma($IdPrincipal,$tipo,$fileName2);
        endif;

        return $result;
    }
    private function fileUpload($doc,$path, $file_name) : string {
        $aleatorio = uniqid();
    
        if (!empty($doc) && isset($doc['name'])) :
            // Obtener la extensión del archivo de manera segura
            $extension = $this->formato->obtenerExtensionArchivo($doc['name']);
    
            // Verifica si la extensión del archivo es segura
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx'];
            if (!in_array($extension, $allowed_extensions)) {
                return "";
            }
    
            // Generar el nombre completo del archivo incluyendo el path
            $upload_path = $path . $aleatorio . "-" . $file_name . "." . $extension;
    
            // Mover el archivo subido al destino final
            if (move_uploaded_file($doc['tmp_name'], $upload_path)) {
                return $aleatorio . "-" . $file_name . "." . $extension;
            }
        endif;        
        return "";
    }
    
    public function agregarFirma($idPrincipal,$tipo,$fileName): void {
        $sql = "INSERT INTO op_descarga_tuxpa_firma (
            id_descarga,
            tipo_firma,
            imagen_firma
            )VALUES (?,?,?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("iss",$idPrincipal,$tipo,$fileName);
        $stmt->execute();
        $stmt->close();
    }
    public function editaFormato(array $form, array $docs):bool {
        $result = true;
        $path = "../../../archivos/tuxpan/";
        // se mueven los archivos a carpeta y se obtiene el nombre a insertar
        $FacturaRemision = $this->fileUpload($docs[0],$path,"no_factura");
        $InventarioInicial = $this->fileUpload($docs[1],$path,"inventario_inicial");
        $Nice = $this->fileUpload($docs[2],$path,"nice");
        $InventarioFinal = $this->fileUpload($docs[3],$path,"inventario_final");
        $MetroContador = $this->fileUpload($docs[4],$path,"metro_contador");
        $MC20Grados = $this->fileUpload($docs[5],$path,"grados");
        // se verifica si estan vacios o no para actualizarlos en la tabla
        if($FacturaRemision != "") :
            $set = "no_factura = ?";
            $this->actualizaFormato($form[13],$set,$FacturaRemision);
        endif;

        if($InventarioInicial != "") :
            $set = "inventario_inicial = ?";
            $this->actualizaFormato($form[13],$set,$InventarioInicial);
        endif;
        
        if($Nice != "") :
            $set = "nice = ?";
            $this->actualizaFormato($form[13],$set,$Nice);
        endif;
        
        if($InventarioFinal != "") :
            $set = "inventario_final = ?";
            $this->actualizaFormato($form[13],$set,$InventarioFinal);
        endif;

        if($MetroContador != "") :
            $set = "metro_contador = ?";
            $this->actualizaFormato($form[13],$set,$MetroContador);
        endif;
        
        if($MC20Grados != "") :
            $set = "metro_contador20 = ?";
            $this->actualizaFormato($form[13],$set,$MC20Grados);
        endif;

        $sql_update = "UPDATE op_descarga_tuxpa 
        SET fecha_llegada = ?, 
            hora_llegada = ?, 
            producto = ?,
            sellos = ?,
            detuvo_venta = ?,
            merma = ?,
            operador = ?,
            transportista = ?,
            no_factura_remision = ?,
            litros = ?, 
            precio_litro = ?,
            unidad = ?,
            cuenta_litros = ?
            WHERE id = ? " ;
        $stmt = $this->con->prepare($sql_update);
        if(!$stmt):
            throw new Exception("Error al preparar la consulta".$this->con->error);
        endif;
        $stmt->bind_param("sssssdsssddsdi",$form[0],$form[1],$form[2],$form[3],$form[4],$form[5],$form[6],
                                        $form[7],$form[8],$form[9],$form[10],$form[11],$form[12],$form[13]);
        if(!$stmt->execute()):
            $result = false;
            throw new Exception("error al ejecutar la consulta".$stmt->error);    
        endif;
        $stmt->close();
        return $result;
    }
    private function actualizaFormato($id,$set,$valor): void {
        $sql = "UPDATE op_descarga_tuxpa SET $set WHERE id = ? " ;
        $stmt = $this->con->prepare($sql);
        if(!$stmt):
            throw new Exception("Error al preparar la consulta".$this->con->error);
        endif;
        $stmt->bind_param("si",$valor,$id);
        if(!$stmt->execute()):
            throw new Exception("Error al ejecutar la consulta".$stmt->error);
        endif;
        $stmt->close();
    }
    public function eliminaFormatoMerma($id): bool{
        // se comienza la transaccion
        $this->con->begin_transaction();

        try {
            // Eliminar de op_descarga_tuxpa
            $sql1 = "DELETE FROM op_descarga_tuxpa WHERE id = ?";
            $stmt1 = $this->con->prepare($sql1);
            if (!$stmt1) :
                throw new Exception("Error al preparar la consulta 1: " . $this->con->error);
            endif;
            $stmt1->bind_param("i", $id);
            if (!$stmt1->execute()) :
                throw new Exception("Error al ejecutar la consulta 1: " . $stmt1->error);
            endif;
            $stmt1->close();
        
            // Eliminar de op_descarga_tuxpa_firma
            $sql2 = "DELETE FROM op_descarga_tuxpa_firma WHERE id_descarga = ?";
            $stmt2 = $this->con->prepare($sql2);
            if (!$stmt2) :
                throw new Exception("Error al preparar la consulta 2: " . $this->con->error);
            endif;
            $stmt2->bind_param("i", $id);
            if (!$stmt2->execute()) :
                throw new Exception("Error al ejecutar la consulta 2: " . $stmt2->error);
            endif;
            $stmt2->close();
        
            // Si todo fue bien, confirmar la transacción
            $this->con->commit();
            return true;
        } catch (Exception $e) {
            // En caso de error, revertir la transacción
            $this->con->rollback();
            throw $e;
        }
        
    }
}