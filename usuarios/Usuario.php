<?php
include 'UsuarioDAO.php';

class Usuario {
    private $id;
    private $nombre;
    private $apellidos;
    private $correo;
    private $password;

    public function __construct($id = null) {
        if ($id != null) {
            $usuarioDAO = new UsuarioDAO();
            $usuario = $usuarioDAO->buscar($id);
            if (!empty($usuario)) {
                $this->id = $usuario->id;
                $this->nombre = $usuario->nombre;
                $this->apellidos = $usuario->apellidos;
                $this->correo = $usuario->correo;
            } else {
                throw new Exception("Usuario no encontrado");
            }
        }
    }

    public function guardar() {
        $usuarioDAO = new UsuarioDAO();
        return $usuarioDAO->insertar($this);
    }

    public function actualizar() {  
        if ($this->id === null) {  
            throw new Exception("El usuario no se ha guardado en la base de datos");  
        }  
        $usuarioDAO = new UsuarioDAO();  
        return $usuarioDAO->actualizar($this);  
    }  

    public function eliminar() {  
        if ($this->id === null) {  
            throw new Exception("El usuario no se ha guardado en la base de datos");  
        }  
        $usuarioDAO = new UsuarioDAO();  
        return $usuarioDAO->eliminar($this->id);  
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getNombres() {
        return $this->nombre;
    }

    public function getApellidos() {
        return $this->apellidos;
    }

    public function getCorreo() {
        return $this->correo;
    }

    // Setters
    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($password) {
        return password_verify($password, $this->password);
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNombres($nombre) {
        $this->nombre = $nombre;
    }

    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }
}
?>