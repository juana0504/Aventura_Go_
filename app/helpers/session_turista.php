<?php

session_start();

//VALIDAMOS SI HAY UNA SECCION ACTIVA, se crea solo cuando hay una sesion activa
if (!isset($_SESSION['user'])) {
    header('Location: ' . BASE_URL . 'login');
    exit;
}

//validamos que el rol sea el correspondiente
if ($_SESSION['user']['rol'] !== 'turista') {
    header('Location: ' . BASE_URL . 'login');
    exit;
}
