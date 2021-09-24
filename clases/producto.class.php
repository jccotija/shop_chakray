<?php
require_once "conexion/conexion.php";
require_once "respuestas.class.php";


class producto extends conexion
{

    private $table = "PRODUCTO";
    private $productoId = "";
    private $name = "";
    private $token = "";

    public function listaProductos($pagina = 1){
        $inicio  = 0 ;
        $cantidad = 100;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
        }
        $query = "SELECT * FROM " . $this->table . " limit $inicio,$cantidad";
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }

    public function obtenerProducto($id){
        $query = "SELECT * FROM " . $this->table . " WHERE ID = '$id'";
        return parent::obtenerDatos($query);

    }

    public function post($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);

        if(!isset($datos['token'])){
            return $_respuestas->error_401();
        }else{
            $this->token = $datos['token'];
            $arrayToken =   $this->buscarToken();
            if($arrayToken){

                if(!isset($datos['name'])){
                    return $_respuestas->error_400();
                }else{
                    $this->name = $datos['name'];
                    $resp = $this->insertarProducto();
                    if($resp){
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "ID" => $resp
                        );
                        return $respuesta;
                    }else{
                        return $_respuestas->error_500();
                    }
                }
            }else{
                return $_respuestas->error_401("El Token que envió es inválido o ha caducado.");
            }
        }
    }


    private function insertarProducto(){
        $query = "INSERT INTO " . $this->table . " (NAME)
        values ('" . $this->name . "')"; 
        $resp = parent::nonQueryId($query);
        if($resp){
            return $resp;
        }else{
            return 0;
        }
    }
    
    public function put($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);

        if(!isset($datos['token'])){
            return $_respuestas->error_401();
        }else{
            $this->token = $datos['token'];
            $arrayToken =   $this->buscarToken();
            if($arrayToken){
                if(!isset($datos['id'])){
                    return $_respuestas->error_400();
                }else{
                    $this->productoId = $datos['id'];
                    if(isset($datos['name'])) { $this->name = $datos['name']; }
        
                    $resp = $this->modificarProducto();

                    // print_r($resp);die();
                    if($resp){
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "ID" => $this->productoId
                        );
                        return $respuesta;
                    }else{
                        $params = [
                            "ID" => $this->productoId
                        ];
                        return $_respuestas->error_422($params, "No se realizó ningún cambio en el registro.");
                    }
                }
            }else{
                return $_respuestas->error_401("El Token que envió es inválido o ha caducado.");
            }
        }
    }

    private function modificarProducto(){
        $query = "UPDATE " . $this->table . " SET NAME ='" . $this->name . "' WHERE ID = '" .$this->productoId . "'"; 
        $resp = parent::nonQuery($query);
        if($resp >= 1){
            return $resp;
        }else{
            return 0;
        }
    }

    public function delete($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);

        if(!isset($datos['token'])){
            return $_respuestas->error_401();
        }else{
            $this->token = $datos['token'];
            $arrayToken =   $this->buscarToken();
            if($arrayToken){

                if(!isset($datos['id'])){
                    return $_respuestas->error_400();
                }else{
                    $this->productoId = $datos['id'];
                    $resp = $this->eliminarProducto();
                    if($resp){
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "ID" => $this->productoId
                        );
                        return $respuesta;
                    }else{
                        return $_respuestas->error_500();
                    }
                }
            }else{
                return $_respuestas->error_401("El Token que envió es inválido o ha caducado.");
            }
        }
    }

    private function eliminarProducto(){
        $query = "DELETE FROM " . $this->table . " WHERE ID= '" . $this->productoId . "'";
        $resp = parent::nonQuery($query);
        if($resp >= 1 ){
            return $resp;
        }else{
            return 0;
        }
    }

    private function buscarToken(){
        $query = "SELECT  ID,USUARIOID,ESTADO from USUARIO_TOKEN WHERE TOKEN = '" . $this->token . "' AND ESTADO = 'Activo'";
        $resp = parent::obtenerDatos($query);
        if($resp){
            return $resp;
        }else{
            return 0;
        }
    }
}