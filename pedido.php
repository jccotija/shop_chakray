<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/pedido.class.php';

$_respuestas = new respuestas;
$_pedido = new pedido;

if($_SERVER['REQUEST_METHOD'] == "GET"){

    if(empty($_GET)){
        $listaPedidos = $_pedido->listaPedidos();
        header("Content-Type: application/json");
        echo json_encode($listaPedidos);
        http_response_code(200);
    }elseif(isset($_GET["page"])){
        $pagina = $_GET["page"];
        $listaPedidos = $_pedido->listaPedidos($pagina);
        header("Content-Type: application/json");
        echo json_encode($listaPedidos);
        http_response_code(200);
    }elseif(isset($_GET['id'])){
        $pedidoId = $_GET['id'];
        $datosPedido = $_pedido->obtenerPedido($pedidoId);
        header("Content-Type: application/json");
        echo json_encode($datosPedido);
        http_response_code(200);
    }
    
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    //enviamos los datos al manejador
    $datosArray = $_pedido->post($postBody);
    //delvovemos una respuesta 
    header('Content-Type: application/json');
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);
    
}else if($_SERVER['REQUEST_METHOD'] == "PUT" || $_SERVER['REQUEST_METHOD'] == "PATCH"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    //enviamos datos al manejador
    $datosArray = $_pedido->put($postBody);
    //delvovemos una respuesta 
    header('Content-Type: application/json');
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);

}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    $headers = getallheaders();
    //recibimos los datos enviados por el header
    $send = [
        "token" => $headers["token"],
        "id" =>$headers["id"]
    ];
    $postBody = json_encode($send);
    //enviamos datos al manejador
    $datosArray = $_pedido->delete($postBody);
    //delvovemos una respuesta 
    header('Content-Type: application/json');
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);

}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}