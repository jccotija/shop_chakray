<?php
require_once 'conexion/conexion.php';

class token extends conexion
{
    function actualizarTokens($fecha){
        $query = "UPDATE USUARIO_TOKEN SET ESTADO = 'Inactivo' WHERE  FECHA < '".$fecha."' AND ESTADO = 'Activo'";
        $verifica = parent::nonQuery($query);
        if($verifica){
            $this->escribirEntrada($verifica);
            return $verifica;
        }else{
            return 0;
        }
    }

    function crearTxt($direccion){
        $archivo = fopen($direccion, 'w') or die ("Error al crear el archivo de registros");
        $texto = "------------------------------------ Registros del CRON JOB ------------------------------------ \n";
        fwrite($archivo,$texto) or die ("No pudimos escribir el registro");
        fclose($archivo);
    }

    function escribirEntrada($registros){
        $direccion = "../cronjob/registros/log_tokens.txt";
        if(!file_exists($direccion)){
            $this->crearTxt($direccion);
        }
        $this->escribirTxt($direccion, $registros);
    }

    function escribirTxt($direccion, $registros){
        $date = date("Y-m-d H:i");
        $archivo = fopen($direccion, 'a') or die ("Error al abrir el archivo de registros");
        $texto = "Se modificaron $registros registro(s) en la fecha [$date].\n";
        fwrite($archivo,$texto) or die ("No pudimos escribir el registro");
        fclose($archivo);
    }
}