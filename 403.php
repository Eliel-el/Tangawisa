<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès interdit - 403</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #111;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        h1 {
            font-size: 6rem;
            color: #ff6600;
            margin-bottom: 10px;
        }
        h2 {
            font-size: 2rem;
            margin-bottom: 20px;
        }
        p {
            color: #ccc;
            margin-bottom: 30px;
        }
        a {
            display: inline-block;
            background: #ff6600;
            color: #fff;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s ease;
        }
        a:hover {
            background: #e65c00;
        }
    </style>
</head>
<body>
    <h1>403</h1>
    <h2>Accès interdit</h2>
    <p>Désolé, vous n’avez pas l’autorisation d’accéder à cette page.</p>
    <?php if (!isset($_SESSION['user'])): ?>
        <a href="login.php">Se connecter</a>
    <?php else: ?>
        <a href="index.php">Retour à l'accueil</a>
    <?php endif; ?>
</body>
</html>
