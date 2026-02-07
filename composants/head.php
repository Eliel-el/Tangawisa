<?php
$page = basename($_SERVER['PHP_SELF']);

$pageTitles = [
    'index.php' => 'Accueil',
    'produits.php' => 'Produit',
    'about.php' => 'À propos',
    'contact.php' => 'Contact',
    'recherche.php' => 'recherche',
    'create.php' => 'ajoute',
    'login.php' => 'login',
    'produit.php' => 'produit',
    'logout.php' => 'logout',
    'register.php' => 'register',
    'profil.php' => 'profil',
    'admin_dashboard.php' => 'Tableau de bord',
    'admin_products.php' => 'Gestion des produits',
    '403.php' => 'Accès refusé',
    'admin_orders.php' => 'Commandes',
    'admin_users.php' => 'Utilisateurs',
    'categories.php' => 'Catégories',
    


];


$currentTitle = $pageTitles[$page] ?: 'Page';
?>

<head>

    <title><?php echo $title; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/style.css">
    
    