<?php

class Database
{
    public static function conectar()
    {
        try
        {
            $conexion = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexion;
        }catch (PDOException $e)
        {
            die("Error critico al conectar con la base de datos: " . $e->getMessage());

        }
    }
}