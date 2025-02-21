<?php

class DataSource {
    private $conexion;
    private $cadenaParaConexion;

    public function __construct() {
        try {
            $this->cadenaParaConexion = "mysql:host=localhost;dbname=prueba";
            $this->conexion = new PDO($this->cadenaParaConexion, "root", "root");
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            $this->conexion = null;
        }
    }

    public function ejecutarConsulta($sql = "", $values = []) {
        if ($sql != "" && $this->conexion != null) {
            if ($this->conexion !== null) {
                $consulta = $this->conexion->prepare($sql);
                $consulta->execute($values);
                return $consulta->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

    public function ejecutarActualizacion($sql = "", $values = []) {
        if ($sql != "" && $this->conexion != null) {
            if ($this->conexion !== null) {
                $consulta = $this->conexion->prepare($sql);
                $consulta->execute($values);
                return $consulta->rowCount();
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function getConexion() {
        return $this->conexion;
    }
}
?>