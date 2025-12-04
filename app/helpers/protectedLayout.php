<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Evitar que el navegador guarde caché del login
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

// Si no hay sesión → al login
if (!isset($_SESSION['user'])) {
    header("Location: /aventura_go/login");
    exit();
}
?>
<script>
    history.pushState(null, "", location.href);
    window.onpopstate = function() {
        history.pushState(null, "", location.href);
    };
</script>