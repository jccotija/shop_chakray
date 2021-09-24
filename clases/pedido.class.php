<?php
require_once "conexion/conexion.php";
require_once "respuestas.class.php";


class pedido extends conexion
{

    private $table = "PEDIDO";
    private $daughterTable = "PRODUCTO_PEDIDO";
    private $pedidoId = "";
    private $user = "";
    private $email = "";
    private $state = "";
    private $productoPedidoId = "";
    private $productoPedidoPedido = "";
    private $productoPedidoProducto = "";
    private $productoPedidoCantidad = "";
    private $token = "";
//912bc00f049ac8464472020c5cd06759

    public function listaPedidos($pagina = 1){
        $inicio  = 0 ;
        $cantidad = 100;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
        }
        $query = "SELECT ID, USER, EMAIL, STATE FROM " . $this->table . " limit $inicio,$cantidad";
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }

    public function obtenerPedido($id){
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
                if(!isset($datos['id']) || !isset($datos['user']) || !isset($datos['email']) || !isset($datos['productoId']) || !isset($datos['cantidad'])){
                    return $_respuestas->error_400();
                }else{
                    $this->pedidoId = $datos['id'];
                    $this->user = $datos['user'];
                    $this->email = $datos['email'];
                    $this->state = 'Solicitado';
                    $this->productoPedidoPedido = $datos['id'];
                    $this->productoPedidoProducto = $datos['productoId'];
                    $this->productoPedidoCantidad = $datos['cantidad']; 
                    $resp = $this->insertarPedido();
                    if($resp){
                        $respProdPed = $this->insertarPedidoProducto();
                        // print_r($respProdPed);die();
                        if($respProdPed) {
                            $respuesta = $_respuestas->response;
                            $respuesta["result"] = array(
                                "ID_PEDIDO" => $this->pedidoId,
                                "ID_PRODUCTO_PEDIDO" => $respProdPed
                            );
                            return $respuesta;
                        }
                    }else{
                        return $_respuestas->error_500();
                    }
                }
            }else{
                return $_respuestas->error_401("El Token que envió es inválido o ha caducado.");
            }
        }
    }


    private function insertarPedido(){
        $query = "INSERT INTO " . $this->table . " (ID, USER, EMAIL, STATE)
        values ('" . $this->pedidoId . "','" . $this->user . "','" . $this->email . "','" . $this->state . "')"; 
        $resp = parent::nonQuery($query);
        if($resp >= 1){
            return $resp;
        }else{
            return 0;
        }
    }

    private function insertarPedidoProducto(){
        $query = "INSERT INTO " . $this->daughterTable . " (PEDIDO, PRODUCTO, CANTIDAD)
        values ('" . $this->productoPedidoPedido . "','" . $this->productoPedidoProducto . "','" . $this->productoPedidoCantidad . "')"; 
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
                    $this->pedidoId = $datos['id'];
                    if(isset($datos['state'])) { $this->state = $datos['state']; }
        
                    $resp = $this->modificarPedido();

                    if($resp){
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "ID" => $this->pedidoId
                        );
                        return $respuesta;
                    }else{
                        $params = [
                            "ID" => $this->pedidoId
                        ];
                        return $_respuestas->error_422($params, "No se realizó ningún cambio en el registro.");
                    }
                }
            }else{
                return $_respuestas->error_401("El Token que envió es inválido o ha caducado.");
            }
        }
    }

    private function modificarPedido(){
        $query = "UPDATE " . $this->table . " SET STATE ='" . $this->state . "' WHERE ID = '" .$this->pedidoId . "'"; 
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
                    $this->pedidoId = $datos['id'];
                    $resp = $this->eliminarPedido();
                    if($resp){
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "ID" => $this->pedidoId
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

    private function eliminarPedido(){
        $query = "DELETE FROM " . $this->table . " WHERE ID= '" . $this->pedidoId . "'";
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