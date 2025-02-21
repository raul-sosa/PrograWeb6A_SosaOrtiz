<?php

require_once "DataSource.php";
require_once "Usuario.php";
require_once "IDao.php";

class UsuarioDAO implements IDao {
    private $dataSource;

    public function __construct(){
        $this->dataSource = new DataSource();
    }

    public function buscarTodos() {
        $sql = "SELECT * FROM usuarios";
        $data = $this->dataSource->ejecutarConsulta($sql);

        $usuarios = [];
        foreach ($data as $row) {
            $usuario = new Usuario();
            $usuario->setId($row['id']);
            $usuario->setNombres($row['nombres']);
            $usuario->setApellidos($row['apellidos']);
            $usuario->setCorreo($row['correo']);
            array_push($usuarios, $usuario);
        }

        return $usuarios;
    }

    public function buscar($id) {
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $values = [':id' => $id];
        $data = $this->dataSource->ejecutarConsulta($sql, $values);

        if (!empty($data)) {
            $row = $data[0];
            $usuario = new Usuario();
            $usuario->setId($row['id']);
            $usuario->setNombres($row['nombres']);
            $usuario->setApellidos($row['apellidos']);
            $usuario->setCorreo($row['correo']);
            return $usuario;
        } else {
            return null;
        }
    }

    public function insertar(Usuario $usuario) {
        $sql = "INSERT INTO usuarios (nombres, apellidos, correo) VALUES (:nombres, :apellidos, :correo)";
        $values = [
            ':nombres' => $usuario->getNombres(),
            ':apellidos' => $usuario->getApellidos(),
            ':correo' => $usuario->getCorreo()
        ];
        return $this->dataSource->ejecutarActualizacion($sql, $values);
    }

    public function actualizar(Usuario $usuario) {
        $sql = "UPDATE usuarios SET nombres = :nombres, apellidos = :apellidos, correo = :correo WHERE id = :id";
        $values = [
            ':nombres' => $usuario->getNombres(),
            ':apellidos' => $usuario->getApellidos(),
            ':correo' => $usuario->getCorreo(),
            ':id' => $usuario->getId()
        ];
        return $this->dataSource->ejecutarActualizacion($sql, $values);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $values = [':id' => $id];
        return $this->dataSource->ejecutarActualizacion($sql, $values);
    }

    public function selectAll() {
        return $this->buscarTodos();
    }
}
?>