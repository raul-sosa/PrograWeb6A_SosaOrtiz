<?php
include_once 'Usuario.php'; // Usa include_once para prevenir inclusiones múltiples
require_once 'UsuarioDAO.php'; // Incluye UsuarioDAO.php

$usuarioDAO = new UsuarioDAO();

$usuario = new Usuario() ;
$usuario->setNombres('Bugs');
$usuario->setApellidos('Bunny');
$usuario->setCorreo('bugsbunny@wb.com');

$usuario2 = new Usuario() ;
$usuario2->setNombres('Lola');
$usuario2->setApellidos('Bunny');
$usuario2->setCorreo('lolabunny@wb.com');

$usuarioDAO->insertar($usuario);
$usuarioDAO->insertar($usuario2);

$usuarios = $usuarioDAO->selectAll();

foreach ($usuarios as $usuario) {
    echo "ID: " . $usuario->getId() . "<br>";
    echo "Nombres: " . $usuario->getNombres() . "<br>";
    echo "Apellidos: " . $usuario->getApellidos() . "<br>";
    echo "Correo: " . $usuario->getCorreo() . "<br><br>";
}