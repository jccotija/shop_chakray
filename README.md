# shop_chakray
API for Chakray

1.- Se clona el proyecto con el siguiente comando:
--------------------------------------------------

git clone https://github.com/jccotija/shop_chakray.git

2.- En consola dentro de la carpeta docker-compose se ejecutará el comando:
----------------------------------------------------------------------------
docker-compose up

Algunas indicaciones más están el archivo README.md dentro de la misma carpeta

NOTA: Realicé cambios en el archivo shop_db.sql para generar tokens en la tabla USUARIO_TOKEN

- Una vez que ws2 está en línea, para crear una API se puede importar el archivo api_shop.json que está en la carpeta raíz del proyecto

- Se debe crear una Application para suscribir a la API y el primer servicio a consumir es auth para obtener un token del backend y poder consumir los demás servicios