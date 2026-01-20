<?php

//impotamos las dependencias
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/perfil.php';

// ADMINISTRADOR
function mostrarPerfilAdmin($id)
{
    $objPerfil = new Perfil();
    $usuario = $objPerfil->mostrarPerfilAdmin($id);

    return $usuario;
}


// PROVEEDOR TURISTICO
function mostrarPerfilProveedor($id)
{
    $objPerfil = new Perfil();
    $usuario = $objPerfil->mostrarPerfilProveedor($id);

    return $usuario;
}


// PROVEEDOR HOTELERO
function mostrarPerfilProveedorHotelero($id)
{
    $objPerfil = new Perfil();
    $usuario = $objPerfil->mostrarPerfilProveedorHotelero($id);

    return $usuario;
}


// TURISTA
function mostrarPerfilTurista($id)
{
    $objPerfil = new Perfil();
    $usuario = $objPerfil->mostrarPerfilTurista($id);

    return $usuario;
}
