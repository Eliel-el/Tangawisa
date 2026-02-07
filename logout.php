<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (isset($_SESSION['user'])) {
    // Supprime toutes les variables de session
    $_SESSION = [];

    // Détruit la session
    session_destroy();

    // Redirection vers la page de login après déconnexion
    header("Location: login.php?logout=success");
    exit;
} else {
    // Si l'utilisateur n'était pas connecté, on le renvoie vers l'accueil
    header("Location: index.php");
    exit;
}
?>
