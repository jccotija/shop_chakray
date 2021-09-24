<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API - Shop</title>
    <link rel="stylesheet" href="assets/estilo.css" type="text/css">
</head>
<body>

<div  class="container">
    <h1>Api de Shop</h1>
    <div class="divbody">
        <h3>Auth - login</h3>
        <code>
            POST  /auth
            <br>
            {
                <br>
                "usuario" :"",  -> REQUERIDO
                <br>
                "password": "" -> REQUERIDO
                <br>
            }
        
        </code>
    </div>      
    <div class="divbody">   
        <h3>Producto</h3>
        <code>
            GET  /producto?page=$numeroPagina
            <br>
            GET  /producto?id=$idProducto
            <br>
        </code>

        <code>
            POST  /producto
            <br>
            {
                <br>
                "name" : "",    -> REQUERIDO
                <br>
                "token" : ""    -> REQUERIDO        
                <br>
            }

        </code>
        <code>
            PUT  /producto
            <br> 
            {
                <br> 
                "name" : "",    -> REQUERIDO
                <br>
                "id" : "",   -> REQUERIDO
                <br>
                "token" : ""    -> REQUERIDO        
                <br>
            }
        </code>
        <code>
            DELETE  /producto
            <br> 
            {   
                <br>    
                "token" : "",    -> REQUERIDO        
                <br>       
                "id" : ""    -> REQUERIDO
                <br>
            }

        </code>
    </div>
    <div class="divbody">   
        <h3>Pedido</h3>
        <code>
            GET  /pedido?page=$numeroPagina
            <br>
            GET  /pedido?id=$idPedido
            <br>
        </code>

        <code>
            POST  /pedido
            <br> 
            {
            <br> 
                "id" : "",  -> REQUERIDO
                <br>
                "user" : "",    -> REQUERIDO
                <br>
                "email" : "",   -> REQUERIDO
                <br>
                "productoId" : "",  -> REQUERIDO
                <br>
                "prodPedCantidad" : "", -> REQUERIDO
                <br>
                "token" : ""   -> REQUERIDO        
                <br>
            }

        </code>
        <code>
            PUT  /pedido
            <br> 
            {
            <br>
                "id" : "",  -> REQUERIDO
                <br>         
                "state" : "",   -> REQUERIDO
                <br>      
                "token" : ""   -> REQUERIDO        
                <br>
            }

        </code>
        <code>
            DELETE  /pedido
            <br> 
            {   
                <br>    
                "token" : "",    -> REQUERIDO        
                <br>       
                "id" : ""    -> REQUERIDO
                <br>
            }

        </code>
    </div>
</div>
    
</body>
</html>

