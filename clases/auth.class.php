<?php
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class auth extends conexion
{
    public function login($json) {
        $_respuestas = new respuestas();
        $datos = json_decode($json, true);
        if(!isset($datos['usuario']) || !isset($datos["password"])){
            //falta algún dato
            return $_respuestas->error_400();
        }else{
            $usuario = $datos['usuario'];
            $password = $datos['password'];
            $password = parent::encriptar($password);
            $datos = $this->obtenerDatosUsuario($usuario);
            if($datos){
                //verificar contraseña
                if($password == $datos[0]['PASSWORD']){
                    if($datos[0]['ESTADO'] == "Activo"){
                        $insertToken  = $this->insertarToken($datos[0]['ID']);
                        if($insertToken){
                            $result = $_respuestas->response;
                            $result["result"] = array(
                                "token" => $insertToken
                            );
                            return $result;
                        }else{
                            return $_respuestas->error_500("Error interno, No hemos podido guardar");
                        }
                    }else{
                        return $_respuestas->error_200("El usuario está inactivo");
                    }
                }else{
                    return $_respuestas->error_200("La contraseña es inválida");
                }
            }else{
                return $_respuestas->error_200("El usuaro $usuario no existe.");
            }
        }
    }



    private function obtenerDatosUsuario($correo){
        $query = "SELECT ID,PASSWORD,ESTADO FROM USUARIO WHERE USUARIO = '$correo'";
        $datos = parent::obtenerDatos($query);
        if(isset($datos[0]["ID"])){
            return $datos;
        }else{
            return 0;
        }
    }


    private function insertarToken($usuarioid){
        $val = true;
        $token = bin2hex(openssl_random_pseudo_bytes(16,$val));
        $date = date("Y-m-d H:i");
        $estado = "Activo";
        $query = "INSERT INTO USUARIO_TOKEN (USUARIOID,TOKEN,ESTADO,FECHA)VALUES('$usuarioid','$token','$estado','$date')";
        $insertToken = parent::nonQuery($query);
        if($insertToken){
            return $token;
        }else{
            return 0;
        }
    }
}