<?php 

class respuestas
{

    public  $response = [
        'status' => "ok",
        "result" => array()
    ];

    public function error_405(){
        http_response_code(405);
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "405",
            "error_msg" => "Metodo no permitido"
        );
        return $this->response;
    }

    public function error_200($valor = "Datos incorrectos"){
        http_response_code(200);
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "200",
            "error_msg" => $valor
        );
        return $this->response;
    }

    public function error_400(){
        http_response_code(400);
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "400",
            "error_msg" => "Datos enviados incompletos o con formato incorrecto"
        );
        return $this->response;
    }

    public function error_500($valor = "Error interno del servidor"){
        http_response_code(500);
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "500",
            "error_msg" => $valor
        );
        return $this->response;
    }

    public function error_401($valor = "No autorizado"){
        http_response_code(401);
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "401",
            "error_msg" => $valor
        );
        return $this->response;
    }

    public function error_422($params = [], $valor = "No se realizó la operación."){
        http_response_code(422);
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "422",
            "error_msg" => $valor
        );
        $this->response['result'] = array_merge($this->response['result'], $params);
        return $this->response;
    }
    
    

}

?>