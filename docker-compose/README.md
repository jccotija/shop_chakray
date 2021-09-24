# Supuesto Práctico Develop 2020

## 1. MySQL

```
Puerto: 3306
Usuario root: mysqlpass
Base de Datos: shop_db
Usuario (shop_db): shop_db_user
Password (shop_db): shop_db_pass
```

## 2. WSO2 API Manager

```
Puerto administración: 9443
Puerto servicio (https): 8243
Puerto servicio (http): 8280
Usuario: admin
Password: admin
```

- https://{DOCKER_HOST}:9443/carbon
- https://{DOCKER_HOST}:9443/publisher
- https://{DOCKER_HOST}:9443/store

- https://{DOCKER_HOST}:8243/services/Version
- http://{DOCKER_HOST}:8280/services/Version


## 3. WSO2 Enterprise Integrator

```
Puerto administración: 9444
Puerto servicio (https): 8244
Puerto servicio (http): 8284
Usuario: admin
Password: admin
```

- https://{DOCKER_HOST}:9444/carbon

- https://{DOCKER_HOST}:8244/services/Version
- http://{DOCKER_HOST}:8284/services/Version

## 4. Docker

Para iniciar el entorno:

```
docker-compose up
```

Para iniciar el entorno en backgound:

```
docker-compose up -d
```

Para visualizar los logs, si el entorno ha sido arrancado en background:

```
docker-compose logs -f
```

Para parar el entorno:

```
docker-compose down
```