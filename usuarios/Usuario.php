<?php
include 'UsuarioDAO.php';

class Usuario {
    private $id;
    private $nombre;
    private $apellidos;
    private $correo;

    public function __construct($id = null) {
        if ($id != null) {
            $usuarioDAO = new UsuarioDAO();
            $usuario = $usuarioDAO->buscar($id);
            $this->id = $usuario[0]['id'];
            $this->nombre = $usuario[0]['nombres'];
            $this->apellidos = $usuario[0]['apellidos'];
            $this->correo = $usuario[0]['correo'];
        }
    }

    public function guardar()
    {
        $usuarioDAO = new UsuarioDAO();
        return $usuarioDAO->insertar($this);
    }

    public function actualizar()  
    {  
        if ($this->id === null) {  
            throw new Exception("El usuario no se ha guardado en la base de datos");  
        }  
        $usuarioDAO = new UsuarioDAO();  
        return $usuarioDAO->actualizar($this);  
    }  
  
    public function eliminar()  
    {  
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