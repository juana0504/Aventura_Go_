<?php

function auth($rol) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] !== $rol) {
        header("Location: " . BASE_URL . "/login");
        exit;
      }
} 


